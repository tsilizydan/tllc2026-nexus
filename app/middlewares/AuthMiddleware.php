<?php
/**
 * AuthMiddleware — TSILIZY Nexus
 *
 * Route-level middleware that checks authentication.
 * Used in Router::group() middleware arrays.
 */

class AuthMiddleware
{
    /**
     * Handle the middleware check.
     * Returns true to continue, false to abort.
     */
    public function handle(): bool
    {
        if (Auth::check()) {
            return true;
        }

        // Store intended URL for post-login redirect
        $uri = $_SERVER['REQUEST_URI'] ?? '/dashboard';
        $_SESSION['intended_url'] = $uri;

        $_SESSION['flash_error'] = 'Veuillez vous connecter pour accéder à cette page.';

        // Redirect to landing page (NOT /login — that redirects back to /)
        $homeUrl = Router::url('/');
        header("Location: {$homeUrl}");
        exit;
        return false;
    }
}
