<?php
class NoteController extends Controller {
    private Note $model;
    public function __construct() { $this->model = new Note(); }

    public function index(): void {
        $this->requireAuth(); $this->requireFeature('notes');
        $notes = $this->model->getTree(Auth::id());
        $this->view('notes.index', ['pageTitle' => __('notes'), 'notes' => $notes, 'currentNote' => null]);
    }

    public function create(): void {
        $this->requireAuth();
        $parentId = $this->query('parent_id');
        $this->view('notes.editor', ['pageTitle' => __('new_note'), 'note' => null, 'parentId' => $parentId, 'notes' => $this->model->getTree(Auth::id())]);
    }

    public function store(): void {
        $this->requireAuth(); if (!$this->validateCsrf()) { $this->redirect('/notes'); return; }
        $id = $this->model->create([
            'user_id' => Auth::id(), 'title' => $this->input('title', 'Sans titre'),
            'content' => $this->rawInput('content', ''), 'parent_id' => $this->input('parent_id') ?: null,
            'icon' => $this->input('icon', '📝')
        ]);
        $this->flash('success', 'Note créée.'); $this->redirect('/notes/' . $id);
    }

    public function show(string $id): void {
        $this->requireAuth();
        $note = $this->model->find((int)$id);
        if (!$note || $note['user_id'] != Auth::id()) { $this->redirect('/notes'); return; }
        $notes = $this->model->getTree(Auth::id());
        $this->view('notes.editor', ['pageTitle' => $note['title'], 'note' => $note, 'notes' => $notes, 'parentId' => null]);
    }

    public function edit(string $id): void { $this->show($id); }

    public function update(string $id): void {
        $this->requireAuth(); if (!$this->validateCsrf()) { $this->redirect('/notes/'.$id); return; }
        $note = $this->model->find((int)$id);
        if (!$note || $note['user_id'] != Auth::id()) { $this->redirect('/notes'); return; }
        $this->model->saveVersion((int)$id, $note['content'] ?? '');
        $this->model->update((int)$id, [
            'title' => $this->input('title'), 'content' => $this->rawInput('content'),
            'icon' => $this->input('icon', $note['icon'])
        ]);
        $this->flash('success', 'Note mise à jour.'); $this->redirect('/notes/' . $id);
    }

    public function delete(string $id): void {
        $this->requireAuth(); if (!$this->validateCsrf()) { $this->redirect('/notes'); return; }
        $note = $this->model->find((int)$id);
        if ($note && $note['user_id'] == Auth::id()) { $this->model->delete((int)$id); $this->flash('success', 'Note supprimée.'); }
        $this->redirect('/notes');
    }

    public function autosave(string $id): void {
        $this->requireAuth();
        $note = $this->model->find((int)$id);
        if (!$note || $note['user_id'] != Auth::id()) { $this->json(['error' => 'Not found'], 404); return; }
        $data = json_decode(file_get_contents('php://input'), true);
        $this->model->update((int)$id, ['content' => $data['content'] ?? '', 'title' => $data['title'] ?? $note['title']]);
        $this->json(['success' => true, 'saved_at' => date('H:i:s')]);
    }
}
