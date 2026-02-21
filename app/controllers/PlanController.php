<?php
class PlanController extends Controller {
    private Plan $planModel;

    public function __construct() { $this->planModel = new Plan(); }

    public function index(): void {
        $this->requireAuth();
        $plans = $this->planModel->getActive();
        $user = Auth::user();
        $this->view('plans.index', [
            'pageTitle' => 'Plans',
            'plans' => $plans,
            'currentPlanId' => $user['plan_id'] ?? null
        ]);
    }

    public function show(string $id): void {
        $this->requireAuth();
        $plan = $this->planModel->find((int)$id);
        if (!$plan) {
            $this->flash('error', 'Plan introuvable.');
            $this->redirect('/plans');
            return;
        }
        $plans = $this->planModel->getActive();
        $user = Auth::user();
        $this->view('plans.index', [
            'pageTitle' => $plan['name'] ?? 'Plan',
            'plans' => $plans,
            'selectedPlan' => $plan,
            'currentPlanId' => $user['plan_id'] ?? null
        ]);
    }

    /**
     * Handle plan selection / switching
     */
    public function select(string $id): void {
        $this->requireAuth();
        if (!$this->validateCsrf()) { $this->redirect('/plans'); return; }

        $plan = $this->planModel->find((int)$id);
        if (!$plan || !$plan['is_active']) {
            $this->flash('error', 'Plan indisponible.');
            $this->redirect('/plans');
            return;
        }

        $user = Auth::user();

        // Free plans: assign immediately
        if ((float)$plan['price'] <= 0) {
            (new User())->update($user['id'], ['plan_id' => $plan['id']]);
            Notification::notify(
                $user['id'], 'plan', 'Plan mis à jour',
                'Vous êtes maintenant sur le plan "' . $plan['name'] . '".',
                url('/plans'), 'crown'
            );
            $this->flash('success', 'Plan "' . e($plan['name']) . '" activé avec succès !');
            $this->redirect('/plans');
            return;
        }

        // Paid plans: redirect to payment flow
        $this->redirect('/plans/' . $plan['id'] . '?pay=1');
    }
}
