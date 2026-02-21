<?php
class WebsiteController extends Controller {
    private Website $model;
    public function __construct() { $this->model = new Website(); }

    public function index(): void {
        $this->requireAuth(); $this->requireFeature('websites');
        $websites = $this->model->where(['user_id' => Auth::id()], 'name', 'ASC');
        $this->view('websites.index', ['pageTitle'=>__('websites'),'websites'=>$websites]);
    }
    public function create(): void { $this->requireAuth(); $this->view('websites.create', ['pageTitle'=>__('new_website')]); }
    public function store(): void {
        $this->requireAuth(); if (!$this->validateCsrf()) { $this->redirect('/websites'); return; }
        $id = $this->model->create([
            'user_id'=>Auth::id(),'name'=>$this->input('name'),'description'=>$this->input('description'),
            'url'=>$this->input('url'),'email'=>$this->input('email'),'category'=>$this->input('category'),
            'status'=>$this->input('status','active'),'owner'=>$this->input('owner'),'notes'=>$this->rawInput('notes')
        ]);
        if ($creds = $this->input('credentials')) $this->model->setCredentials($id, $creds);
        $this->flash('success','Site ajouté.'); $this->redirect('/websites');
    }
    public function show(string $id): void {
        $this->requireAuth();
        $site = $this->model->find((int)$id);
        if (!$site || $site['user_id'] != Auth::id()) { $this->redirect('/websites'); return; }
        $this->view('websites.show', ['pageTitle'=>$site['name'],'website'=>$site]);
    }
    public function edit(string $id): void {
        $this->requireAuth();
        $site = $this->model->find((int)$id);
        if (!$site || $site['user_id'] != Auth::id()) { $this->redirect('/websites'); return; }
        $this->view('websites.edit', ['pageTitle'=>'Modifier: '.$site['name'],'website'=>$site]);
    }
    public function update(string $id): void {
        $this->requireAuth(); if (!$this->validateCsrf()) { $this->redirect('/websites/'.$id.'/edit'); return; }
        $site = $this->model->find((int)$id);
        if (!$site || $site['user_id'] != Auth::id()) { $this->redirect('/websites'); return; }
        $this->model->update((int)$id, [
            'name'=>$this->input('name'),'description'=>$this->input('description'),'url'=>$this->input('url'),
            'email'=>$this->input('email'),'category'=>$this->input('category'),'status'=>$this->input('status'),
            'owner'=>$this->input('owner'),'notes'=>$this->rawInput('notes')
        ]);
        if ($creds = $this->input('credentials')) $this->model->setCredentials((int)$id, $creds);
        $this->flash('success','Site mis à jour.'); $this->redirect('/websites');
    }
    public function delete(string $id): void {
        $this->requireAuth(); if (!$this->validateCsrf()) { $this->redirect('/websites'); return; }
        $site = $this->model->find((int)$id);
        if ($site && $site['user_id'] == Auth::id()) { $this->model->delete((int)$id); $this->flash('success','Site supprimé.'); }
        $this->redirect('/websites');
    }
}
