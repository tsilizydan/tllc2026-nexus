<?php
class Notification extends Model {
    protected string $table = 'notifications';
    protected bool $softDelete = false;
    protected array $fillable = ['user_id','type','title','message','link','icon','is_read','read_at'];

    public function getUnread(int $userId): array {
        return $this->where(['user_id' => $userId, 'is_read' => 0], 'created_at', 'DESC');
    }
    public function unreadCount(int $userId): int {
        return $this->count(['user_id' => $userId, 'is_read' => 0]);
    }
    public function markRead(int $id): void {
        $this->rawExecute("UPDATE notifications SET is_read = 1, read_at = NOW() WHERE id = :id", ['id' => $id]);
    }
    public function markAllRead(int $userId): void {
        $this->rawExecute("UPDATE notifications SET is_read = 1, read_at = NOW() WHERE user_id = :uid AND is_read = 0", ['uid' => $userId]);
    }
    public static function notify(int $userId, string $type, string $title, ?string $message = null, ?string $link = null, string $icon = 'bell'): void {
        $model = new self();
        $model->create(['user_id'=>$userId,'type'=>$type,'title'=>$title,'message'=>$message,'link'=>$link,'icon'=>$icon]);
    }
}
