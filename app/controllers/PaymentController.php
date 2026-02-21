<?php
class PaymentController extends Controller {
    public function create(): void {
        $this->requireAuth();
        if (!$this->validateCsrf()) { $this->redirect('/plans'); return; }

        $this->flash('info', 'Système de paiement en cours de configuration.');
        $this->redirect('/plans');
    }
}
