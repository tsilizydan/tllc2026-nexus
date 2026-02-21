<?php
/**
 * Payment Model — TSILIZY Nexus
 */
class Payment extends Model {
    protected string $table = 'payments';
    protected bool $softDelete = true;
    protected array $fillable = [
        'user_id', 'plan_id', 'amount', 'currency', 'method',
        'transaction_id', 'status', 'notes', 'validated_by', 'validated_at', 'deleted_at'
    ];

    /**
     * Get active plans (from plans table)
     */
    public function getActivePlans(): array {
        return $this->raw(
            "SELECT * FROM plans WHERE is_active = 1 AND deleted_at IS NULL ORDER BY sort_order ASC"
        );
    }

    /**
     * Find a single plan by ID
     */
    public function findPlan(int $id): ?array {
        $rows = $this->raw(
            "SELECT * FROM plans WHERE id = :id AND deleted_at IS NULL LIMIT 1",
            ['id' => $id]
        );
        return $rows[0] ?? null;
    }

    /**
     * Get user payments
     */
    public function getUserPayments(int $userId): array {
        return $this->where(['user_id' => $userId], 'created_at', 'DESC');
    }
}
