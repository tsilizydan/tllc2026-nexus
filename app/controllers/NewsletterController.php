<?php
class NewsletterController extends Controller {
    /**
     * Subscribe to newsletter (public, no auth required)
     */
    public function subscribe(): void {
        $email = $this->input('email');

        if (!$email || !filter_var($email, FILTER_VALIDATE_EMAIL)) {
            $this->flash('error', 'Email invalide.');
            $this->redirect('/#newsletter');
            return;
        }

        $model = new NewsletterSubscriber();
        $existing = $model->findByEmail($email);

        if ($existing) {
            if ($existing['status'] === 'active') {
                $this->flash('info', 'Vous êtes déjà inscrit.');
            } else {
                $model->update($existing['id'], [
                    'status' => 'active',
                    'subscribed_at' => date('Y-m-d H:i:s'),
                    'unsubscribed_at' => null
                ]);
                $this->flash('success', __('newsletter_success'));
            }
        } else {
            $model->create([
                'email' => $email,
                'status' => 'active',
                'subscribed_at' => date('Y-m-d H:i:s'),
            ]);
            $this->flash('success', __('newsletter_success'));
        }

        $this->redirect('/#newsletter');
    }
}
