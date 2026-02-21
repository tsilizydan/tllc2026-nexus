<?php
/**
 * Base Controller — TSILIZY Nexus
 * 
 * Provides view rendering, redirects, JSON responses, CSRF handling,
 * and flash message utilities.
 */

class Controller
{
    /**
     * Render a view with layout
     */
    protected function view(string $view, array $data = [], string $layout = 'app'): void
    {
        // Extract data to make variables available in views
        extract($data);

        // Generate CSRF token
        $csrfToken = $this->generateCsrf();

        // Auth data
        $auth = Auth::user();
        $isLoggedIn = Auth::check();

        // App config
        $appName = config('app.name', 'TSILIZY Nexus');
        $appUrl = config('app.url', '');

        // Flash messages
        $flashSuccess = $_SESSION['flash_success'] ?? null;
        $flashError = $_SESSION['flash_error'] ?? null;
        $flashInfo = $_SESSION['flash_info'] ?? null;
        unset($_SESSION['flash_success'], $_SESSION['flash_error'], $_SESSION['flash_info']);

        // Features
        $features = config('app.features', []);

        // Build view path
        $viewPath = ROOT_PATH . '/app/views/' . str_replace('.', '/', $view) . '.php';
        $layoutPath = ROOT_PATH . '/app/views/layouts/' . $layout . '.php';

        if (!file_exists($viewPath)) {
            throw new \RuntimeException("View not found: {$view}");
        }

        // Capture view content
        ob_start();
        require $viewPath;
        $content = ob_get_clean();

        // Render with layout if layout exists
        if (file_exists($layoutPath)) {
            require $layoutPath;
        } else {
            echo $content;
        }
    }

    /**
     * Render a view without main app layout (for auth pages)
     */
    protected function viewOnly(string $view, array $data = []): void
    {
        extract($data);

        $csrfToken = $this->generateCsrf();
        $appName = config('app.name', 'TSILIZY Nexus');
        $appUrl = config('app.url', '');

        // Flash messages
        $flashSuccess = $_SESSION['flash_success'] ?? null;
        $flashError = $_SESSION['flash_error'] ?? null;
        $flashInfo = $_SESSION['flash_info'] ?? null;
        unset($_SESSION['flash_success'], $_SESSION['flash_error'], $_SESSION['flash_info']);

        $viewPath = ROOT_PATH . '/app/views/' . str_replace('.', '/', $view) . '.php';
        $layoutPath = ROOT_PATH . '/app/views/layouts/auth.php';

        if (!file_exists($viewPath)) {
            throw new \RuntimeException("View not found: {$view}");
        }

        ob_start();
        require $viewPath;
        $content = ob_get_clean();

        if (file_exists($layoutPath)) {
            require $layoutPath;
        } else {
            echo $content;
        }
    }

    /**
     * Render a standalone view without any layout (for landing pages)
     */
    protected function viewRaw(string $view, array $data = []): void
    {
        extract($data);

        $csrfToken = $this->generateCsrf();
        $appName = config('app.name', 'TSILIZY Nexus');
        $appUrl = config('app.url', '');

        $flashSuccess = $_SESSION['flash_success'] ?? null;
        $flashError = $_SESSION['flash_error'] ?? null;
        $flashInfo = $_SESSION['flash_info'] ?? null;
        unset($_SESSION['flash_success'], $_SESSION['flash_error'], $_SESSION['flash_info']);

        $viewPath = ROOT_PATH . '/app/views/' . str_replace('.', '/', $view) . '.php';
        if (!file_exists($viewPath)) {
            throw new \RuntimeException("View not found: {$view}");
        }
        require $viewPath;
    }

    /**
     * Redirect to a URL
     */
    protected function redirect(string $path): void
    {
        $url = Router::url($path);
        header("Location: {$url}");
        exit;
    }

    /**
     * Return JSON response
     */
    protected function json(array $data, int $status = 200): void
    {
        http_response_code($status);
        header('Content-Type: application/json; charset=utf-8');
        echo json_encode($data, JSON_UNESCAPED_UNICODE);
        exit;
    }

    /**
     * Generate CSRF token
     */
    protected function generateCsrf(): string
    {
        if (empty($_SESSION[config('app.csrf_token_name', '_csrf_token')])) {
            $_SESSION[config('app.csrf_token_name', '_csrf_token')] = bin2hex(random_bytes(32));
        }
        return $_SESSION[config('app.csrf_token_name', '_csrf_token')];
    }

    /**
     * Validate CSRF token
     */
    protected function validateCsrf(): bool
    {
        $tokenName = config('app.csrf_token_name', '_csrf_token');
        $token = $_POST[$tokenName] ?? $_SERVER['HTTP_X_CSRF_TOKEN'] ?? '';
        $sessionToken = $_SESSION[$tokenName] ?? '';

        if (empty($token) || !hash_equals($sessionToken, $token)) {
            $this->flash('error', 'Jeton de sécurité invalide. Veuillez réessayer.');
            return false;
        }

        // Regenerate after validation
        unset($_SESSION[$tokenName]);
        return true;
    }

    /**
     * Set flash message
     */
    protected function flash(string $type, string $message): void
    {
        $_SESSION["flash_{$type}"] = $message;
    }

    /**
     * Get POST input with sanitization
     */
    protected function input(string $key, $default = null)
    {
        $value = $_POST[$key] ?? $default;
        if (is_string($value)) {
            return htmlspecialchars(trim($value), ENT_QUOTES, 'UTF-8');
        }
        return $value;
    }

    /**
     * Get raw POST input (for rich text)
     */
    protected function rawInput(string $key, $default = null)
    {
        return $_POST[$key] ?? $default;
    }

    /**
     * Get GET parameter
     */
    protected function query(string $key, $default = null)
    {
        $value = $_GET[$key] ?? $default;
        if (is_string($value)) {
            return htmlspecialchars(trim($value), ENT_QUOTES, 'UTF-8');
        }
        return $value;
    }

    /**
     * Require authentication
     */
    protected function requireAuth(): void
    {
        if (!Auth::check()) {
            $this->flash('error', 'Veuillez vous connecter pour accéder à cette page.');
            $this->redirect('/login');
        }
    }

    /**
     * Require specific role
     */
    protected function requireRole(string ...$roles): void
    {
        $this->requireAuth();
        if (!Auth::hasRole(...$roles)) {
            http_response_code(403);
            $this->viewOnly('errors.403');
            exit;
        }
    }

    /**
     * Check if a feature is enabled
     */
    protected function requireFeature(string $feature): void
    {
        $features = config('app.features', []);
        if (empty($features[$feature])) {
            $this->flash('error', 'Cette fonctionnalité est désactivée.');
            $this->redirect('/dashboard');
        }
    }

    /**
     * Require admin role
     */
    protected function requireAdmin(): void
    {
        $this->requireRole('super_admin', 'admin');
    }
}
