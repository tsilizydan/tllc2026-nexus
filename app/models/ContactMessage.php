<?php
/**
 * ContactMessage Model — TSILIZY Nexus
 */
class ContactMessage extends Model {
    protected string $table = 'contact_messages';
    protected bool $softDelete = false;
    protected array $fillable = ['name', 'email', 'subject', 'message', 'status', 'ip_address'];

    public function getAll(string $order = 'DESC'): array {
        return $this->where([], 'created_at', $order);
    }

    public function getUnread(): array {
        return $this->where(['status' => 'unread'], 'created_at', 'DESC');
    }

    public function unreadCount(): int {
        return count($this->getUnread());
    }

    public function markRead(int $id): void {
        $this->update($id, ['status' => 'read']);
    }
}
