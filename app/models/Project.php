<?php
class Project extends Model {
    protected string $table = 'projects';
    protected bool $softDelete = true;
    protected array $fillable = ['user_id','name','description','status','color','start_date','end_date','progress','deleted_at'];

    public function getWithStats(int $userId): array {
        return $this->raw(
            "SELECT p.*, (SELECT COUNT(*) FROM tasks t WHERE t.project_id = p.id AND t.deleted_at IS NULL) as task_count,
             (SELECT COUNT(*) FROM tasks t WHERE t.project_id = p.id AND t.status = 'done' AND t.deleted_at IS NULL) as done_count
             FROM projects p WHERE p.user_id = :uid AND p.deleted_at IS NULL ORDER BY p.updated_at DESC",
            ['uid' => $userId]
        );
    }

    public function getTasks(int $projectId): array {
        return $this->raw("SELECT * FROM tasks WHERE project_id = :pid AND deleted_at IS NULL ORDER BY sort_order ASC", ['pid' => $projectId]);
    }

    public function getMilestones(int $projectId): array {
        return $this->raw("SELECT * FROM milestones WHERE project_id = :pid AND deleted_at IS NULL ORDER BY due_date ASC", ['pid' => $projectId]);
    }

    public function createMilestone(array $data): int {
        $stmt = $this->db()->prepare("INSERT INTO milestones (project_id, title, description, due_date, sort_order, created_at, updated_at) VALUES (:pid, :title, :desc, :due, :sort, NOW(), NOW())");
        $stmt->execute(['pid'=>$data['project_id'],'title'=>$data['title'],'desc'=>$data['description']??null,'due'=>$data['due_date']??null,'sort'=>$data['sort_order']??0]);
        return (int)$this->db()->lastInsertId();
    }

    public function updateProgress(int $projectId): void {
        $stats = $this->raw("SELECT COUNT(*) as total, SUM(CASE WHEN status='done' THEN 1 ELSE 0 END) as done FROM tasks WHERE project_id = :pid AND deleted_at IS NULL", ['pid' => $projectId]);
        $progress = ($stats[0]['total'] ?? 0) > 0 ? round(($stats[0]['done'] / $stats[0]['total']) * 100) : 0;
        $this->update($projectId, ['progress' => $progress]);
    }
}
