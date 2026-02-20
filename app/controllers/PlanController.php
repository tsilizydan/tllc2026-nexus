<?php
class PlanController extends Controller {
    public function index(): void {
        $this->requireAuth();
        $plans = (new Payment())->getActivePlans();
        $this->view('plans.index', ['pageTitle' => 'Plans', 'plans' => $plans]);
    }

    public function show(string $id): void {
        $this->requireAuth();
        $plan = (new Payment())->findPlan((int)$id);
        if (!$plan) {
            $this->flash('error', 'Plan introuvable.');
            $this->redirect('/plans');
            return;
        }
        $this->view('plans.index', ['pageTitle' => $plan['name'] ?? 'Plan', 'plans' => [(new Payment())->findPlan((int)$id)], 'selectedPlan' => $plan]);
    }
}
