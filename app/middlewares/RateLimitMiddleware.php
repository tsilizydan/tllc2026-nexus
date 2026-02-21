<?php
/**
 * RateLimitMiddleware — TSILIZY Nexus
 *
 * Session-based rate limiting for login and password reset.
 * Blocks after N failed attempts within a time window.
 */

class RateLimitMiddleware
{
    /**
     * Check if the current IP/session is rate-limited
     * Returns true if allowed, false if blocked
     */
    public function handle(): bool
    {
        $maxAttempts = config('app.rate_limit_attempts', 5);
        $window      = config('app.rate_limit_window', 900); // 15 min
        $key         = 'rate_limit_' . $this->getIdentifier();

        $attempts = $_SESSION[$key] ?? [];

        // Clean expired attempts
        $now = time();
        $attempts = array_filter($attempts, fn($t) => ($now - $t) < $window);
        $_SESSION[$key] = $attempts;

        if (count($attempts) >= $maxAttempts) {
            $retryAfter = $window - ($now - min($attempts));
            $minutes = (int) ceil($retryAfter / 60);

            http_response_code(429);
            if (isset($_SERVER['HTTP_X_REQUESTED_WITH']) && $_SERVER['HTTP_X_REQUESTED_WITH'] === 'XMLHttpRequest') {
                header('Content-Type: application/json');
                echo json_encode(['error' => "Trop de tentatives. Réessayez dans {$minutes} minutes."]);
            } else {
                $_SESSION['flash_error'] = "Trop de tentatives. Réessayez dans {$minutes} minutes.";
                $redirectTo = Router::url('/login');
                header("Location: {$redirectTo}");
            }
            exit;
            return false;
        }

        return true;
    }

    /**
     * Record a failed attempt
     */
    public static function recordFailure(): void
    {
        $key = 'rate_limit_' . self::staticIdentifier();
        $attempts = $_SESSION[$key] ?? [];
        $attempts[] = time();
        $_SESSION[$key] = $attempts;
    }

    /**
     * Clear attempts on success
     */
    public static function clearAttempts(): void
    {
        $key = 'rate_limit_' . self::staticIdentifier();
        unset($_SESSION[$key]);
    }

    /**
     * Get identifier for rate limiting
     */
    private function getIdentifier(): string
    {
        return md5(($_SERVER['REMOTE_ADDR'] ?? '0.0.0.0') . session_id());
    }

    private static function staticIdentifier(): string
    {
        return md5(($_SERVER['REMOTE_ADDR'] ?? '0.0.0.0') . session_id());
    }
}
