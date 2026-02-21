<?php
/**
 * NewsletterSubscriber Model — TSILIZY Nexus
 */
class NewsletterSubscriber extends Model {
    protected string $table = 'newsletter_subscribers';
    protected bool $softDelete = false;
    protected array $fillable = ['email', 'status', 'subscribed_at', 'unsubscribed_at'];

    public function getAll(string $order = 'DESC'): array {
        return $this->where([], 'subscribed_at', $order);
    }

    public function getActive(): array {
        return $this->where(['status' => 'active'], 'subscribed_at', 'DESC');
    }

    public function activeCount(): int {
        return count($this->getActive());
    }

    public function findByEmail(string $email): ?array {
        $results = $this->where(['email' => $email]);
        return $results[0] ?? null;
    }

    public function unsubscribe(int $id): void {
        $this->update($id, ['status' => 'unsubscribed', 'unsubscribed_at' => date('Y-m-d H:i:s')]);
    }
}
