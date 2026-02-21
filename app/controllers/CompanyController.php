<?php
class CompanyController extends Controller {
    private Company $model;
    public function __construct() { $this->model = new Company(); }

    public function index(): void {
        $this->requireAuth(); $this->requireFeature('company');
        $company = $this->model->getByUser(Auth::id());
        $this->view('company.index', ['pageTitle'=>__('company_profile'),'company'=>$company]);
    }

    public function update(): void {
        $this->requireAuth(); if (!$this->validateCsrf()) { $this->redirect('/company'); return; }
        $existing = $this->model->getByUser(Auth::id());
        $data = [
            'name'=>$this->input('name'),'manager'=>$this->input('manager'),'type'=>$this->input('type'),
            'phone'=>$this->input('phone'),'email'=>$this->input('email'),'address'=>$this->input('address'),
            'capital'=>$this->input('capital'),'employees'=>$this->input('employees'),'registration_number'=>$this->input('registration_number'),
            'tax_id'=>$this->input('tax_id'),'website'=>$this->input('website'),'description'=>$this->rawInput('description'),'notes'=>$this->rawInput('notes')
        ];
        if ($existing) { $this->model->update($existing['id'], $data); }
        else { $data['user_id'] = Auth::id(); $this->model->create($data); }
        $this->flash('success','Profil entreprise mis à jour.'); $this->redirect('/company');
    }
}
