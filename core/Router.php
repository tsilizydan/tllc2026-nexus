<?php
/**
 * Router — TSILIZY Nexus
 *
 * Lightweight routing engine supporting:
 *  - GET / POST methods
 *  - Route groups with prefix and middleware
 *  - Named parameters: /tasks/{id}
 *  - 404 fallback
 *  - URL generation
 */

class Router
{
    /** @var array Registered routes */
    private static array $routes = [];

    /** @var array Active group stack (prefix, middleware) */
    private static array $groupStack = [];

    /** @var string Base path (auto-detected from SCRIPT_NAME) */
    private static string $basePath = '';

    // -----------------------------------------------------------------
    // Route registration
    // -----------------------------------------------------------------

    public static function get(string $uri, string $action): void
    {
        self::addRoute('GET', $uri, $action);
    }

    public static function post(string $uri, string $action): void
    {
        self::addRoute('POST', $uri, $action);
    }

    /**
     * Group routes with shared prefix / middleware
     */
    public static function group(array $options, callable $callback): void
    {
        self::$groupStack[] = $options;
        $callback();
        array_pop(self::$groupStack);
    }

    // -----------------------------------------------------------------
    // Internal helpers
    // -----------------------------------------------------------------

    private static function addRoute(string $method, string $uri, string $action): void
    {
        // Build full prefix from group stack
        $prefix = '';
        $middleware = [];
        foreach (self::$groupStack as $group) {
            if (!empty($group['prefix'])) {
                $prefix .= '/' . trim($group['prefix'], '/');
            }
            if (!empty($group['middleware'])) {
                $middleware = array_merge($middleware, (array) $group['middleware']);
            }
        }

        $fullUri = $prefix . '/' . ltrim($uri, '/');
        $fullUri = '/' . trim($fullUri, '/');
        if ($fullUri === '') $fullUri = '/';

        // Convert {param} to regex named groups
        // Escape dots in URI (e.g., sitemap.xml) before converting params
        $escaped = str_replace('.', '\.', $fullUri);
        $pattern = preg_replace('#\\{([a-zA-Z_]+)\\}#', '(?P<$1>[^/]+)', $escaped);
        $pattern = '#^' . $pattern . '$#';

        self::$routes[] = [
            'method'     => $method,
            'uri'        => $fullUri,
            'pattern'    => $pattern,
            'action'     => $action,      // "Controller@method"
            'middleware'  => $middleware,
        ];
    }

    // -----------------------------------------------------------------
    // Dispatch
    // -----------------------------------------------------------------

    public static function dispatch(): void
    {
        $method = $_SERVER['REQUEST_METHOD'];
        $uri    = self::getUri();

        // Debug: log what the router sees (remove in production if too noisy)
        if (config('app.debug', false)) {
            error_log("[ROUTER] {$method} {$uri} | SCRIPT_NAME=" . ($_SERVER['SCRIPT_NAME'] ?? 'N/A') . " | REQUEST_URI=" . ($_SERVER['REQUEST_URI'] ?? 'N/A') . " | BasePath=" . self::getBasePath());
        }

        foreach (self::$routes as $route) {
            if ($route['method'] !== $method) continue;

            if (preg_match($route['pattern'], $uri, $matches)) {
                // Run middleware
                foreach ($route['middleware'] as $mw) {
                    if (class_exists($mw)) {
                        $instance = new $mw();
                        if (method_exists($instance, 'handle')) {
                            if ($instance->handle() === false) return;
                        }
                    }
                }

                // Extract named params
                $params = array_filter($matches, 'is_string', ARRAY_FILTER_USE_KEY);

                // Parse Controller@method
                [$controllerClass, $methodName] = explode('@', $route['action']);

                if (!class_exists($controllerClass)) {
                    self::abort(500, "Controller not found: {$controllerClass}");
                    return;
                }

                $controller = new $controllerClass();

                if (!method_exists($controller, $methodName)) {
                    self::abort(500, "Method not found: {$controllerClass}@{$methodName}");
                    return;
                }

                // Call with extracted route params
                call_user_func_array([$controller, $methodName], array_values($params));
                return;
            }
        }

        // No route matched → 404
        error_log("[ROUTER] 404 — No route matched: {$method} {$uri}");
        self::abort(404);
    }

    // -----------------------------------------------------------------
    // URL helpers
    // -----------------------------------------------------------------

    /**
     * Generate URL with base path
     */
    public static function url(string $path = ''): string
    {
        $base = self::getBasePath();
        return rtrim($base, '/') . '/' . ltrim($path, '/');
    }

    /**
     * Get base path (e.g. /subfolder if app is in subfolder)
     * For Namecheap: when app is at document root, this MUST return ''
     */
    public static function getBasePath(): string
    {
        if (self::$basePath === '') {
            $scriptName = $_SERVER['SCRIPT_NAME'] ?? '/index.php';
            $dir = rtrim(dirname($scriptName), '/\\');

            // On Namecheap, SCRIPT_NAME is typically /index.php
            // dirname('/index.php') = '/' which should be treated as empty
            if ($dir === '/' || $dir === '.' || $dir === '\\' || $dir === '') {
                self::$basePath = '';
            } else {
                self::$basePath = $dir;
            }
        }
        return self::$basePath;
    }

    /**
     * Extract request URI relative to base path
     */
    private static function getUri(): string
    {
        $uri = parse_url($_SERVER['REQUEST_URI'] ?? '/', PHP_URL_PATH);
        $uri = rawurldecode($uri);  // Decode %20, etc.
        $base = self::getBasePath();

        if ($base !== '' && str_starts_with($uri, $base)) {
            $uri = substr($uri, strlen($base));
        }

        $uri = '/' . trim($uri, '/');
        if ($uri === '') $uri = '/';
        return $uri;
    }

    /**
     * Abort with error page
     */
    private static function abort(int $code, string $message = ''): void
    {
        http_response_code($code);

        if ($message) {
            error_log("[ROUTER] {$code}: {$message}");
        }

        $errorView = ROOT_PATH . "/app/views/errors/{$code}.php";
        if (file_exists($errorView)) {
            require $errorView;
        } else {
            echo "<h1>Error {$code}</h1>";
        }
        exit;
    }
}
