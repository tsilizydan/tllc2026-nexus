<?php
/**
 * Front Controller — TSILIZY Nexus
 *
 * Entry point for all HTTP requests. Handles autoloading,
 * session initialization, config loading, and route dispatching.
 */

// ---------------------------------------------------------------
// Define root path FIRST (needed by everything else)
// ---------------------------------------------------------------
define('ROOT_PATH', __DIR__);

// ---------------------------------------------------------------
// Production error handling — NEVER display errors to users
// ---------------------------------------------------------------
error_reporting(E_ALL);
ini_set('display_errors', '0');
ini_set('display_startup_errors', '0');
ini_set('log_errors', '1');

// Ensure log directory exists
$logDir = ROOT_PATH . '/storage/logs';
if (!is_dir($logDir)) {
    @mkdir($logDir, 0755, true);
}
ini_set('error_log', $logDir . '/error.log');

// ---------------------------------------------------------------
// Global exception handler — prevents stack trace leaks
// ---------------------------------------------------------------
set_exception_handler(function (Throwable $e) {
    error_log('[EXCEPTION] ' . $e->getMessage() . ' in ' . $e->getFile() . ':' . $e->getLine());
    if (!headers_sent()) {
        http_response_code(500);
    }
    $errorView = ROOT_PATH . '/app/views/errors/500.php';
    if (file_exists($errorView)) {
        require $errorView;
    } else {
        echo '<h1>Internal Server Error</h1>';
    }
    exit;
});

set_error_handler(function (int $severity, string $message, string $file, int $line) {
    if (!(error_reporting() & $severity)) return false;
    throw new ErrorException($message, 0, $severity, $file, $line);
});

// ---------------------------------------------------------------
// Start session with secure defaults
// ---------------------------------------------------------------
if (session_status() === PHP_SESSION_NONE) {
    $isHttps = (!empty($_SERVER['HTTPS']) && $_SERVER['HTTPS'] !== 'off')
            || (!empty($_SERVER['SERVER_PORT']) && $_SERVER['SERVER_PORT'] == 443)
            || (!empty($_SERVER['HTTP_X_FORWARDED_PROTO']) && $_SERVER['HTTP_X_FORWARDED_PROTO'] === 'https');

    session_start([
        'cookie_httponly'  => true,
        'cookie_samesite'  => 'Lax',
        'cookie_secure'    => $isHttps,
        'use_strict_mode'  => true,
        'use_only_cookies' => true,
        'gc_maxlifetime'   => 7200,
    ]);
}

// -------------------------------------------------------------------
// Config helper
// -------------------------------------------------------------------
function config(string $key, $default = null)
{
    static $configs = [];

    $parts = explode('.', $key);
    $file = $parts[0];

    if (!isset($configs[$file])) {
        $path = ROOT_PATH . '/config/' . $file . '.php';
        if (file_exists($path)) {
            $configs[$file] = require $path;
        } else {
            return $default;
        }
    }

    $value = $configs[$file];
    for ($i = 1; $i < count($parts); $i++) {
        if (is_array($value) && isset($value[$parts[$i]])) {
            $value = $value[$parts[$i]];
        } else {
            return $default;
        }
    }

    return $value;
}

// -------------------------------------------------------------------
// Set timezone
// -------------------------------------------------------------------
date_default_timezone_set(config('app.timezone', 'UTC'));

// -------------------------------------------------------------------
// Autoloader
// -------------------------------------------------------------------
spl_autoload_register(function (string $class) {
    $paths = [
        ROOT_PATH . '/core/' . $class . '.php',
        ROOT_PATH . '/app/controllers/' . $class . '.php',
        ROOT_PATH . '/app/models/' . $class . '.php',
        ROOT_PATH . '/app/middlewares/' . $class . '.php',
        ROOT_PATH . '/app/services/' . $class . '.php',
        ROOT_PATH . '/app/helpers/' . $class . '.php',
    ];

    foreach ($paths as $path) {
        if (file_exists($path)) {
            require_once $path;
            return;
        }
    }
});

// -------------------------------------------------------------------
// Helper functions
// -------------------------------------------------------------------

/**
 * Generate asset URL
 */
function asset(string $path): string
{
    return rtrim(config('app.url', ''), '/') . '/public/assets/' . ltrim($path, '/');
}

/**
 * Generate URL
 */
function url(string $path = ''): string
{
    return Router::url($path);
}

/**
 * Escape HTML output
 */
function e(string $value): string
{
    return htmlspecialchars($value, ENT_QUOTES, 'UTF-8');
}

/**
 * Get current locale (session → cookie → browser → config)
 */
function get_locale(): string
{
    static $locale = null;
    if ($locale !== null) return $locale;

    // 1. Session
    if (!empty($_SESSION['locale'])) { $locale = $_SESSION['locale']; return $locale; }
    // 2. Cookie
    if (!empty($_COOKIE['locale'])) { $locale = $_COOKIE['locale']; $_SESSION['locale'] = $locale; return $locale; }
    // 3. Browser Accept-Language
    if (!empty($_SERVER['HTTP_ACCEPT_LANGUAGE'])) {
        $browserLang = strtolower(substr($_SERVER['HTTP_ACCEPT_LANGUAGE'], 0, 2));
        $supported = ['fr', 'en'];
        if (in_array($browserLang, $supported)) { $locale = $browserLang; $_SESSION['locale'] = $locale; return $locale; }
    }
    // 4. Config fallback
    $locale = config('app.locale', 'fr');
    return $locale;
}

/**
 * Translation helper
 */
function __(string $key, $default = null): string
{
    static $translations = null;
    static $loadedLocale = null;

    $locale = get_locale();

    if ($translations === null || $loadedLocale !== $locale) {
        $loadedLocale = $locale;
        $langFile = ROOT_PATH . '/lang/' . $locale . '.php';
        $translations = file_exists($langFile) ? require $langFile : [];
    }

    return $translations[$key] ?? $default ?? $key;
}

/**
 * CSRF input field
 */
function csrf_field(): string
{
    $tokenName = config('app.csrf_token_name', '_csrf_token');
    $token = $_SESSION[$tokenName] ?? '';
    return '<input type="hidden" name="' . $tokenName . '" value="' . e($token) . '">';
}

/**
 * Check if current path matches
 */
function is_active(string $path): bool
{
    $uri = parse_url($_SERVER['REQUEST_URI'], PHP_URL_PATH);
    $scriptDir = dirname($_SERVER['SCRIPT_NAME']);
    if ($scriptDir !== '/' && $scriptDir !== '\\') {
        $uri = substr($uri, strlen($scriptDir));
    }
    $uri = '/' . trim($uri, '/');
    return str_starts_with($uri, $path);
}

/**
 * Encrypt data
 */
function encrypt(string $data): string
{
    $key = config('app.encryption_key', '');
    $method = config('app.encryption_method', 'AES-256-CBC');
    $iv = random_bytes(openssl_cipher_iv_length($method));
    $encrypted = openssl_encrypt($data, $method, $key, 0, $iv);
    return base64_encode($iv . '::' . $encrypted);
}

/**
 * Decrypt data
 */
function decrypt(string $data): string
{
    $key = config('app.encryption_key', '');
    $method = config('app.encryption_method', 'AES-256-CBC');
    $decoded = base64_decode($data);
    [$iv, $encrypted] = explode('::', $decoded, 2);
    return openssl_decrypt($encrypted, $method, $key, 0, $iv);
}

/**
 * Format date in French
 */
function format_date(string $date, string $format = 'd/m/Y'): string
{
    return date($format, strtotime($date));
}

/**
 * Time ago in French
 */
function time_ago(string $datetime): string
{
    $diff = time() - strtotime($datetime);
    if ($diff < 60) return 'à l\'instant';
    if ($diff < 3600) return floor($diff / 60) . ' min';
    if ($diff < 86400) return floor($diff / 3600) . ' h';
    if ($diff < 604800) return floor($diff / 86400) . ' j';
    if ($diff < 2592000) return floor($diff / 604800) . ' sem';
    return format_date($datetime);
}

// -------------------------------------------------------------------
// Load routes and dispatch
// -------------------------------------------------------------------
require ROOT_PATH . '/routes/web.php';
Router::dispatch();
