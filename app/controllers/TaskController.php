<?php
class TaskController extends Controller {
    private Task $model;
    public function __construct() { $this->model = new Task(); }

    public function index(): void {
        $this->requireAuth(); $this->requireFeature('tasks');
        $userId = Auth::id();
        $status = $this->query('status'); $priority = $this->query('priority');
        $view = $this->query('view', 'kanban');

        $conditions = ['user_id' => $userId];
        if ($status) $conditions['status'] = $status;
        if ($priority) $conditions['priority'] = $priority;

        $tasks = $this->model->where($conditions, 'sort_order', 'ASC');
        $labels = $this->model->getUserLabels($userId);

        // Group by status for kanban
        $kanban = ['todo' => [], 'in_progress' => [], 'done' => []];
        foreach ($tasks as $task) {
            $task['labels'] = $this->model->getLabels($task['id']);
            $kanban[$task['status']][] = $task;
        }

        $this->view('tasks.index', [
            'pageTitle' => __('tasks'), 'tasks' => $tasks, 'kanban' => $kanban,
            'labels' => $labels, 'currentView' => $view, 'filterStatus' => $status, 'filterPriority' => $priority
        ]);
    }

    public function create(): void {
        $this->requireAuth(); $this->requireFeature('tasks');
        $labels = $this->model->getUserLabels(Auth::id());
        $projects = (new Project())->where(['user_id' => Auth::id()], 'name', 'ASC');
        $this->view('tasks.create', ['pageTitle' => __('new_task'), 'labels' => $labels, 'projects' => $projects]);
    }

    public function store(): void {
        $this->requireAuth(); if (!$this->validateCsrf()) { $this->redirect('/tasks'); return; }
        $id = $this->model->create([
            'user_id' => Auth::id(), 'title' => $this->input('title'), 'description' => $this->rawInput('description'),
            'status' => $this->input('status', 'todo'), 'priority' => $this->input('priority', 'medium'),
            'due_date' => $this->input('due_date') ?: null, 'project_id' => $this->input('project_id') ?: null
        ]);
        if (!empty($_POST['labels'])) $this->model->syncLabels($id, $_POST['labels']);
        $this->flash('success', 'Tâche créée avec succès.'); $this->redirect('/tasks');
    }

    public function show(string $id): void {
        $this->requireAuth();
        $task = $this->model->find((int)$id);
        if (!$task || $task['user_id'] != Auth::id()) { $this->flash('error', 'Tâche introuvable.'); $this->redirect('/tasks'); return; }
        $task['labels'] = $this->model->getLabels($task['id']);
        $this->view('tasks.show', ['pageTitle' => $task['title'], 'task' => $task]);
    }

    public function edit(string $id): void {
        $this->requireAuth();
        $task = $this->model->find((int)$id);
        if (!$task || $task['user_id'] != Auth::id()) { $this->redirect('/tasks'); return; }
        $labels = $this->model->getUserLabels(Auth::id());
        $taskLabels = array_column($this->model->getLabels($task['id']), 'id');
        $projects = (new Project())->where(['user_id' => Auth::id()], 'name', 'ASC');
        $this->view('tasks.edit', ['pageTitle' => 'Modifier: '.$task['title'], 'task' => $task, 'labels' => $labels, 'taskLabels' => $taskLabels, 'projects' => $projects]);
    }

    public function update(string $id): void {
        $this->requireAuth(); if (!$this->validateCsrf()) { $this->redirect('/tasks/'.$id.'/edit'); return; }
        $task = $this->model->find((int)$id);
        if (!$task || $task['user_id'] != Auth::id()) { $this->redirect('/tasks'); return; }
        $data = ['title'=>$this->input('title'),'description'=>$this->rawInput('description'),'status'=>$this->input('status'),'priority'=>$this->input('priority'),'due_date'=>$this->input('due_date')?:null,'project_id'=>$this->input('project_id')?:null];
        if ($data['status'] === 'done' && $task['status'] !== 'done') $data['completed_at'] = date('Y-m-d H:i:s');
        $this->model->update((int)$id, $data);
        if (isset($_POST['labels'])) $this->model->syncLabels((int)$id, $_POST['labels']);
        if ($task['project_id']) (new Project())->updateProgress($task['project_id']);
        $this->flash('success', 'Tâche mise à jour.'); $this->redirect('/tasks');
    }

    public function delete(string $id): void {
        $this->requireAuth(); if (!$this->validateCsrf()) { $this->redirect('/tasks'); return; }
        $task = $this->model->find((int)$id);
        if ($task && $task['user_id'] == Auth::id()) { $this->model->delete((int)$id); $this->flash('success', 'Tâche supprimée.'); }
        $this->redirect('/tasks');
    }

    public function updateStatus(string $id): void {
        $this->requireAuth();
        $task = $this->model->find((int)$id);
        if (!$task || $task['user_id'] != Auth::id()) { $this->json(['error' => 'Not found'], 404); return; }
        $status = $this->input('status');
        $data = ['status' => $status];
        if ($status === 'done') $data['completed_at'] = date('Y-m-d H:i:s');
        $this->model->update((int)$id, $data);
        if ($task['project_id']) (new Project())->updateProgress($task['project_id']);
        $this->json(['success' => true]);
    }

    public function reorder(): void {
        $this->requireAuth();
        $items = json_decode(file_get_contents('php://input'), true)['items'] ?? [];
        foreach ($items as $i => $item) {
            $this->model->update((int)$item['id'], ['sort_order' => $i, 'status' => $item['status'] ?? 'todo']);
        }
        $this->json(['success' => true]);
    }
}
