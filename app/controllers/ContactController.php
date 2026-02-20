<?php
class ContactController extends Controller {
    private Contact $model;
    public function __construct() { $this->model = new Contact(); }

    public function index(): void {
        $this->requireAuth(); $this->requireFeature('contacts');
        $search = $this->query('q');
        if ($search) { $contacts = $this->model->searchContacts(Auth::id(), $search); }
        else { $result = $this->model->paginate((int)$this->query('page', 1), 20, ['user_id' => Auth::id()], 'first_name', 'ASC'); $contacts = $result['data']; }
        $this->view('contacts.index', ['pageTitle'=>__('contacts'),'contacts'=>$contacts,'search'=>$search,'pagination'=>$result??null]);
    }

    public function create(): void { $this->requireAuth(); $this->view('contacts.create', ['pageTitle'=>__('new_contact')]); }

    public function store(): void {
        $this->requireAuth(); if (!$this->validateCsrf()) { $this->redirect('/contacts'); return; }
        $this->model->create([
            'user_id'=>Auth::id(),'first_name'=>$this->input('first_name'),'last_name'=>$this->input('last_name'),
            'email'=>$this->input('email'),'phone'=>$this->input('phone'),'company'=>$this->input('company'),
            'position'=>$this->input('position'),'address'=>$this->input('address'),'tags'=>$this->input('tags'),'notes'=>$this->rawInput('notes')
        ]);
        $this->flash('success','Contact créé.'); $this->redirect('/contacts');
    }

    public function show(string $id): void {
        $this->requireAuth();
        $contact = $this->model->find((int)$id);
        if (!$contact || $contact['user_id'] != Auth::id()) { $this->redirect('/contacts'); return; }
        $interactions = $this->model->getInteractions($contact['id']);
        $this->view('contacts.show', ['pageTitle'=>$contact['first_name'].' '.($contact['last_name']??''),'contact'=>$contact,'interactions'=>$interactions]);
    }

    public function edit(string $id): void {
        $this->requireAuth();
        $contact = $this->model->find((int)$id);
        if (!$contact || $contact['user_id'] != Auth::id()) { $this->redirect('/contacts'); return; }
        $this->view('contacts.edit', ['pageTitle'=>'Modifier: '.$contact['first_name'],'contact'=>$contact]);
    }

    public function update(string $id): void {
        $this->requireAuth(); if (!$this->validateCsrf()) { $this->redirect('/contacts/'.$id.'/edit'); return; }
        $contact = $this->model->find((int)$id);
        if (!$contact || $contact['user_id'] != Auth::id()) { $this->redirect('/contacts'); return; }
        $this->model->update((int)$id, [
            'first_name'=>$this->input('first_name'),'last_name'=>$this->input('last_name'),'email'=>$this->input('email'),
            'phone'=>$this->input('phone'),'company'=>$this->input('company'),'position'=>$this->input('position'),
            'address'=>$this->input('address'),'tags'=>$this->input('tags'),'notes'=>$this->rawInput('notes')
        ]);
        $this->flash('success','Contact mis à jour.'); $this->redirect('/contacts/' . $id);
    }

    public function delete(string $id): void {
        $this->requireAuth(); if (!$this->validateCsrf()) { $this->redirect('/contacts'); return; }
        $contact = $this->model->find((int)$id);
        if ($contact && $contact['user_id'] == Auth::id()) { $this->model->delete((int)$id); $this->flash('success','Contact supprimé.'); }
        $this->redirect('/contacts');
    }

    public function export(): void {
        $this->requireAuth();
        $csv = $this->model->exportCsv(Auth::id());
        header('Content-Type: text/csv; charset=utf-8');
        header('Content-Disposition: attachment; filename="contacts_'.date('Y-m-d').'.csv"');
        echo $csv; exit;
    }
}
