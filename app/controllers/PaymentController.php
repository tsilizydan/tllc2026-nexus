<?php
class PaymentController extends Controller {
    private Payment $model;

    public function __construct() { $this->model = new Payment(); }

    /**
     * Create a payment for a plan
     */
    public function create(): void {
        $this->requireAuth();
        if (!$this->validateCsrf()) { $this->redirect('/plans'); return; }

        $planId = (int)$this->input('plan_id');
        $plan = (new Plan())->find($planId);

        if (!$plan || !$plan['is_active']) {
            $this->flash('error', 'Plan introuvable.');
            $this->redirect('/plans');
            return;
        }

        $user = Auth::user();
        $method = $this->input('method', 'contribution');

        // Create pending payment record
        $paymentId = $this->model->create([
            'user_id' => $user['id'],
            'plan_id' => $plan['id'],
            'amount' => $plan['price'],
            'currency' => $plan['currency'] ?? 'EUR',
            'method' => $method,
            'status' => 'pending',
            'notes' => 'Plan: ' . $plan['name']
        ]);

        // For free/contribution plans, auto-validate
        if ((float)$plan['price'] <= 0) {
            $this->model->update($paymentId, [
                'status' => 'completed',
                'validated_at' => date('Y-m-d H:i:s')
            ]);
            (new User())->update($user['id'], ['plan_id' => $plan['id']]);
            Notification::notify(
                $user['id'], 'payment', 'Paiement confirmé',
                'Votre plan "' . $plan['name'] . '" est maintenant actif.',
                url('/plans'), 'credit-card'
            );
            $this->flash('success', 'Plan activé avec succès !');
        } else {
            Notification::notify(
                $user['id'], 'payment', 'Paiement en attente',
                'Votre paiement pour le plan "' . $plan['name'] . '" est en attente de validation.',
                url('/plans'), 'clock'
            );
            $this->flash('info', 'Paiement enregistré. En attente de validation par l\'administrateur.');
        }

        $this->redirect('/plans');
    }
}
