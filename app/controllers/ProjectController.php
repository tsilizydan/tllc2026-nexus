<?php
class ProjectController extends Controller {
    private Project $model;
    public function __construct() { $this->model = new Project(); }

    public function index(): void {
        $this->requireAuth(); $this->requireFeature('projects');
        $projects = $this->model->getWithStats(Auth::id());
        $this->view('projects.index', ['pageTitle' => __('projects'), 'projects' => $projects]);
    }

    public function create(): void {
        $this->requireAuth();
        $this->view('projects.create', ['pageTitle' => __('new_project')]);
    }

    public function store(): void {
        $this->requireAuth(); if (!$this->validateCsrf()) { $this->redirect('/projects'); return; }
        $id = $this->model->create([
            'user_id' => Auth::id(), 'name' => $this->input('name'), 'description' => $this->rawInput('description'),
            'status' => $this->input('status', 'planning'), 'color' => $this->input('color', '#6C3CE1'),
            'start_date' => $this->input('start_date') ?: null, 'end_date' => $this->input('end_date') ?: null
        ]);
        $this->flash('success', 'Projet créé.'); Notification::notify(Auth::id(), 'project', 'Projet créé', '"' . $this->input('name') . '" a été créé.', url('/projects/' . $id), 'project-diagram'); $this->redirect('/projects/' . $id);
    }

    public function show(string $id): void {
        $this->requireAuth();
        $project = $this->model->find((int)$id);
        if (!$project || $project['user_id'] != Auth::id()) { $this->redirect('/projects'); return; }
        $tasks = $this->model->getTasks($project['id']);
        $milestones = $this->model->getMilestones($project['id']);
        $kanban = ['todo'=>[],'in_progress'=>[],'done'=>[]];
        foreach ($tasks as $t) $kanban[$t['status']][] = $t;
        $this->view('projects.show', ['pageTitle'=>$project['name'],'project'=>$project,'tasks'=>$tasks,'milestones'=>$milestones,'kanban'=>$kanban]);
    }

    public function edit(string $id): void {
        $this->requireAuth();
        $project = $this->model->find((int)$id);
        if (!$project || $project['user_id'] != Auth::id()) { $this->redirect('/projects'); return; }
        $this->view('projects.edit', ['pageTitle' => 'Modifier: '.$project['name'], 'project' => $project]);
    }

    public function update(string $id): void {
        $this->requireAuth(); if (!$this->validateCsrf()) { $this->redirect('/projects/'.$id.'/edit'); return; }
        $project = $this->model->find((int)$id);
        if (!$project || $project['user_id'] != Auth::id()) { $this->redirect('/projects'); return; }
        $this->model->update((int)$id, [
            'name'=>$this->input('name'),'description'=>$this->rawInput('description'),'status'=>$this->input('status'),
            'color'=>$this->input('color'),'start_date'=>$this->input('start_date')?:null,'end_date'=>$this->input('end_date')?:null
        ]);
        $this->flash('success', 'Projet mis à jour.'); $this->redirect('/projects/' . $id);
    }

    public function delete(string $id): void {
        $this->requireAuth(); if (!$this->validateCsrf()) { $this->redirect('/projects'); return; }
        $project = $this->model->find((int)$id);
        if ($project && $project['user_id'] == Auth::id()) { $this->model->delete((int)$id); $this->flash('success', 'Projet supprimé.'); }
        $this->redirect('/projects');
    }
}
