<?php
class Task extends Model {
    protected string $table = 'tasks';
    protected bool $softDelete = true;
    protected array $fillable = ['user_id','project_id','title','description','status','priority','due_date','completed_at','sort_order','assigned_to','deleted_at'];

    public function getByStatus(int $userId, string $status): array {
        return $this->where(['user_id' => $userId, 'status' => $status], 'sort_order', 'ASC');
    }

    public function getLabels(int $taskId): array {
        return $this->raw("SELECT tl.* FROM task_labels tl JOIN task_label_pivot tlp ON tl.id = tlp.label_id WHERE tlp.task_id = :tid", ['tid' => $taskId]);
    }

    public function syncLabels(int $taskId, array $labelIds): void {
        $this->rawExecute("DELETE FROM task_label_pivot WHERE task_id = :tid", ['tid' => $taskId]);
        foreach ($labelIds as $lid) {
            $this->rawExecute("INSERT INTO task_label_pivot (task_id, label_id) VALUES (:tid, :lid)", ['tid' => $taskId, 'lid' => $lid]);
        }
    }

    public function getUserLabels(int $userId): array {
        return $this->raw("SELECT * FROM task_labels WHERE user_id = :uid ORDER BY name", ['uid' => $userId]);
    }

    public function createLabel(int $userId, string $name, string $color = '#6C3CE1'): int {
        $this->rawExecute("INSERT INTO task_labels (user_id, name, color, created_at) VALUES (:uid, :name, :color, NOW())", ['uid' => $userId, 'name' => $name, 'color' => $color]);
        return (int)$this->db()->lastInsertId();
    }
}
