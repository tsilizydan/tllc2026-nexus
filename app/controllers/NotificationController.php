<?php
class NotificationController extends Controller {
    private Notification $model;
    public function __construct() { $this->model = new Notification(); }

    public function index(): void {
        $this->requireAuth();
        $notifs = $this->model->where(['user_id' => Auth::id()], 'created_at', 'DESC');
        $this->view('notifications.index', ['pageTitle' => __('notifications'), 'notifications' => $notifs]);
    }

    public function markRead(string $id): void {
        $this->requireAuth();
        $this->model->markRead((int)$id);
        $this->json(['success' => true]);
    }

    public function markAllRead(): void {
        $this->requireAuth();
        if (!$this->validateCsrf()) { $this->redirect('/notifications'); return; }
        $this->model->markAllRead(Auth::id());
        $this->flash('success', 'Toutes les notifications marquées comme lues.');
        $this->redirect('/notifications');
    }

    public function unreadCount(): void {
        $this->requireAuth();
        $this->json(['count' => $this->model->unreadCount(Auth::id())]);
    }
}
