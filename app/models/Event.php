<?php
class Event extends Model {
    protected string $table = 'events';
    protected bool $softDelete = true;
    protected array $fillable = ['user_id','title','description','start_date','end_date','all_day','color','location','is_recurring','recurrence_rule','reminder_minutes','deleted_at'];

    public function getByDateRange(int $userId, string $start, string $end): array {
        return $this->raw(
            "SELECT * FROM events WHERE user_id = :uid AND start_date >= :start AND start_date <= :end AND deleted_at IS NULL ORDER BY start_date ASC",
            ['uid' => $userId, 'start' => $start, 'end' => $end]
        );
    }

    public function getUpcoming(int $userId, int $limit = 5): array {
        return $this->raw(
            "SELECT * FROM events WHERE user_id = :uid AND start_date >= NOW() AND deleted_at IS NULL ORDER BY start_date ASC LIMIT {$limit}",
            ['uid' => $userId]
        );
    }
}
