<?php
/**
 * User Model — TSILIZY Nexus
 */

class User extends Model
{
    protected string $table = 'users';
    protected bool $softDelete = true;
    protected array $fillable = [
        'name', 'email', 'password', 'role', 'status', 'avatar', 'phone',
        'position', 'bio', 'email_verified_at', 'verification_token',
        'reset_token', 'reset_token_expires', 'remember_token', 'plan_id',
        'last_login_at', 'last_login_ip', 'login_attempts', 'locked_until',
        'preferences', 'deleted_at'
    ];

    /**
     * Find user by email
     */
    public function findByEmail(string $email): ?array
    {
        return $this->findWhere(['email' => $email]);
    }

    /**
     * Find user by verification token
     */
    public function findByVerificationToken(string $token): ?array
    {
        return $this->findWhere(['verification_token' => $token]);
    }

    /**
     * Find user by reset token
     */
    public function findByResetToken(string $token): ?array
    {
        $user = $this->findWhere(['reset_token' => $token]);
        if ($user && $user['reset_token_expires'] && strtotime($user['reset_token_expires']) > time()) {
            return $user;
        }
        return null;
    }

    /**
     * Get all users by role
     */
    public function getByRole(string $role): array
    {
        return $this->where(['role' => $role]);
    }

    /**
     * Get active users count
     */
    public function activeCount(): int
    {
        return $this->count(['status' => 'active']);
    }
}
