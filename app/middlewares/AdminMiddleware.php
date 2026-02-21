<?php
/**
 * AdminMiddleware — TSILIZY Nexus
 *
 * Route-level middleware that checks admin role.
 * Used in Router::group() for admin routes.
 */

class AdminMiddleware
{
    /**
     * Handle the middleware check
     */
    public function handle(): bool
    {
        if (Auth::isAdmin()) {
            return true;
        }

        http_response_code(403);
        $errorView = ROOT_PATH . '/app/views/errors/403.php';
        if (file_exists($errorView)) {
            require $errorView;
        } else {
            echo '<h1>403 — Accès interdit</h1>';
        }
        exit;
        return false;
    }
}
