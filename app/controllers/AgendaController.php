<?php
class AgendaController extends Controller {
    private Event $model;
    public function __construct() { $this->model = new Event(); }

    public function index(): void {
        $this->requireAuth(); $this->requireFeature('agenda');
        $this->view('agenda.index', ['pageTitle' => __('agenda')]);
    }

    public function events(): void {
        $this->requireAuth();
        $start = $this->query('start', date('Y-m-01'));
        $end = $this->query('end', date('Y-m-t'));
        $events = $this->model->getByDateRange(Auth::id(), $start, $end);
        $formatted = array_map(fn($e) => [
            'id' => $e['id'], 'title' => $e['title'], 'start' => $e['start_date'], 'end' => $e['end_date'],
            'color' => $e['color'], 'allDay' => (bool)$e['all_day'], 'description' => $e['description'], 'location' => $e['location']
        ], $events);
        $this->json($formatted);
    }

    public function store(): void {
        $this->requireAuth(); if (!$this->validateCsrf()) { $this->redirect('/agenda'); return; }
        $this->model->create([
            'user_id' => Auth::id(), 'title' => $this->input('title'), 'description' => $this->input('description'),
            'start_date' => $this->input('start_date'), 'end_date' => $this->input('end_date') ?: null,
            'all_day' => isset($_POST['all_day']) ? 1 : 0, 'color' => $this->input('color', '#6C3CE1'),
            'location' => $this->input('location')
        ]);
        $this->flash('success', 'Événement créé.'); $this->redirect('/agenda');
    }

    public function update(string $id): void {
        $this->requireAuth(); if (!$this->validateCsrf()) { $this->redirect('/agenda'); return; }
        $event = $this->model->find((int)$id);
        if (!$event || $event['user_id'] != Auth::id()) { $this->redirect('/agenda'); return; }
        $this->model->update((int)$id, [
            'title' => $this->input('title'), 'description' => $this->input('description'),
            'start_date' => $this->input('start_date'), 'end_date' => $this->input('end_date') ?: null,
            'all_day' => isset($_POST['all_day']) ? 1 : 0, 'color' => $this->input('color'), 'location' => $this->input('location')
        ]);
        $this->flash('success', 'Événement mis à jour.'); $this->redirect('/agenda');
    }

    public function delete(string $id): void {
        $this->requireAuth(); if (!$this->validateCsrf()) { $this->redirect('/agenda'); return; }
        $event = $this->model->find((int)$id);
        if ($event && $event['user_id'] == Auth::id()) { $this->model->delete((int)$id); $this->flash('success', 'Événement supprimé.'); }
        $this->redirect('/agenda');
    }
}
