<?php
/**
 * Plan Model — TSILIZY Nexus
 */
class Plan extends Model {
    protected string $table = 'plans';
    protected bool $softDelete = true;
    protected array $fillable = [
        'name', 'slug', 'description', 'price', 'currency', 'billing_cycle',
        'features', 'max_tasks', 'max_projects', 'max_contacts', 'max_notes',
        'max_websites', 'is_active', 'sort_order', 'deleted_at'
    ];

    public function getActive(): array {
        return $this->where(['is_active' => 1], 'sort_order', 'ASC');
    }

    public function findBySlug(string $slug): ?array {
        return $this->findWhere(['slug' => $slug]);
    }
}
