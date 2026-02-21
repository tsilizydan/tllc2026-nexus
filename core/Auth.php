<?php
/**
 * Auth — TSILIZY Nexus
 * 
 * Session-based authentication with RBAC, remember-me tokens,
 * password hashing, and role checking.
 */

class Auth
{
    /**
     * Attempt login
     */
    public static function attempt(string $email, string $password, bool $remember = false): bool
    {
        $userModel = new User();
        $user = $userModel->findByEmail($email);

        if (!$user || !password_verify($password, $user['password'])) {
            return false;
        }

        // Check if account is active
        if ($user['status'] !== 'active') {
            return false;
        }

        // Set session
        self::loginUser($user);

        // Remember me
        if ($remember) {
            self::setRememberToken($user['id']);
        }

        // Update last login
        $userModel->update($user['id'], [
            'last_login_at' => date('Y-m-d H:i:s'),
            'last_login_ip' => $_SERVER['REMOTE_ADDR'] ?? '0.0.0.0',
        ]);

        return true;
    }

    /**
     * Set session data for authenticated user
     */
    private static function loginUser(array $user): void
    {
        session_regenerate_id(true);
        $_SESSION['user_id'] = $user['id'];
        $_SESSION['user_name'] = $user['name'];
        $_SESSION['user_email'] = $user['email'];
        $_SESSION['user_role'] = $user['role'];
        $_SESSION['user_avatar'] = $user['avatar'] ?? null;
        $_SESSION['logged_in'] = true;
        $_SESSION['login_time'] = time();
    }

    /**
     * Check if user is authenticated
     */
    public static function check(): bool
    {
        if (!empty($_SESSION['logged_in']) && !empty($_SESSION['user_id'])) {
            return true;
        }

        // Try remember me token
        return self::checkRememberToken();
    }

    /**
     * Get current user data
     */
    public static function user(): ?array
    {
        if (!self::check()) return null;

        return [
            'id'     => $_SESSION['user_id'],
            'name'   => $_SESSION['user_name'],
            'email'  => $_SESSION['user_email'],
            'role'   => $_SESSION['user_role'],
            'avatar' => $_SESSION['user_avatar'] ?? null,
        ];
    }

    /**
     * Get current user ID
     */
    public static function id(): ?int
    {
        return $_SESSION['user_id'] ?? null;
    }

    /**
     * Get current user role
     */
    public static function role(): ?string
    {
        return $_SESSION['user_role'] ?? null;
    }

    /**
     * Check if user has one of the specified roles
     */
    public static function hasRole(string ...$roles): bool
    {
        $currentRole = self::role();
        if (!$currentRole) return false;
        return in_array($currentRole, $roles);
    }

    /**
     * Check if user is admin
     */
    public static function isAdmin(): bool
    {
        return self::hasRole('super_admin', 'admin');
    }

    /**
     * Check if user is super admin
     */
    public static function isSuperAdmin(): bool
    {
        return self::hasRole('super_admin');
    }

    /**
     * Logout
     */
    public static function logout(): void
    {
        // Clear remember token
        if (isset($_SESSION['user_id'])) {
            $userModel = new User();
            $userModel->update($_SESSION['user_id'], ['remember_token' => null]);
        }

        // Clear session
        $_SESSION = [];
        if (ini_get('session.use_cookies')) {
            $params = session_get_cookie_params();
            setcookie(session_name(), '', time() - 3600,
                $params['path'], $params['domain'],
                $params['secure'], $params['httponly']
            );
        }
        session_destroy();

        // Clear remember cookie
        if (isset($_COOKIE['remember_token'])) {
            setcookie('remember_token', '', time() - 3600, '/', '', false, true);
        }
    }

    /**
     * Hash password
     */
    public static function hashPassword(string $password): string
    {
        return password_hash($password, PASSWORD_BCRYPT, ['cost' => 12]);
    }

    /**
     * Set remember me token
     */
    private static function setRememberToken(int $userId): void
    {
        $token = bin2hex(random_bytes(32));
        $hashedToken = hash('sha256', $token);

        $userModel = new User();
        $userModel->update($userId, ['remember_token' => $hashedToken]);

        $lifetime = config('app.remember_lifetime', 2592000);
        setcookie('remember_token', "{$userId}|{$token}", time() + $lifetime, '/', '', false, true);
    }

    /**
     * Check remember me token
     */
    private static function checkRememberToken(): bool
    {
        if (empty($_COOKIE['remember_token'])) return false;

        $parts = explode('|', $_COOKIE['remember_token']);
        if (count($parts) !== 2) return false;

        [$userId, $token] = $parts;
        $hashedToken = hash('sha256', $token);

        $userModel = new User();
        $user = $userModel->find((int) $userId);

        if ($user && $user['remember_token'] === $hashedToken && $user['status'] === 'active') {
            self::loginUser($user);
            return true;
        }

        // Invalid token, clear cookie
        setcookie('remember_token', '', time() - 3600, '/', '', false, true);
        return false;
    }

    /**
     * Generate email verification token
     */
    public static function generateVerificationToken(): string
    {
        return bin2hex(random_bytes(32));
    }

    /**
     * Generate password reset token
     */
    public static function generateResetToken(): string
    {
        return bin2hex(random_bytes(32));
    }
}
