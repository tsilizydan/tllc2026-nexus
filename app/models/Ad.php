<?php
/**
 * Ad Model — TSILIZY Nexus
 */
class Ad extends Model {
    protected string $table = 'ads';
    protected bool $softDelete = true;
    protected array $fillable = [
        'title', 'content', 'image', 'link', 'placement',
        'start_date', 'end_date', 'clicks', 'impressions',
        'is_active', 'created_by', 'deleted_at'
    ];

    public function getActiveByPlacement(string $placement): array {
        return $this->raw(
            "SELECT * FROM ads WHERE is_active = 1 AND deleted_at IS NULL
             AND (placement = :p OR placement = 'all')
             AND (start_date IS NULL OR start_date <= CURDATE())
             AND (end_date IS NULL OR end_date >= CURDATE())
             ORDER BY RAND() LIMIT 3",
            ['p' => $placement]
        );
    }

    public function recordClick(int $id): void {
        $this->rawExecute("UPDATE ads SET clicks = clicks + 1 WHERE id = :id", ['id' => $id]);
    }

    public function recordImpression(int $id): void {
        $this->rawExecute("UPDATE ads SET impressions = impressions + 1 WHERE id = :id", ['id' => $id]);
    }
}
