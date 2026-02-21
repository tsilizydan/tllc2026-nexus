<?php
class ContactFormController extends Controller {
    /**
     * Handle contact form submission (public, no auth required)
     */
    public function submit(): void {
        $name = $this->input('name');
        $email = $this->input('email');
        $subject = $this->input('subject');
        $message = $this->rawInput('message');

        if (!$name || !$email || !$message) {
            $this->flash('error', 'Veuillez remplir tous les champs obligatoires.');
            $this->redirect('/#contact');
            return;
        }

        if (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
            $this->flash('error', 'Email invalide.');
            $this->redirect('/#contact');
            return;
        }

        $model = new ContactMessage();
        $model->create([
            'name'       => $name,
            'email'      => $email,
            'subject'    => $subject ?: 'Pas de sujet',
            'message'    => $message,
            'status'     => 'unread',
            'ip_address' => $_SERVER['REMOTE_ADDR'] ?? '',
        ]);

        // Notify admin
        try {
            Notification::notify(1, 'contact', 'Nouveau message', 'Message de ' . $name, '/admin/messages', 'fas fa-envelope');
        } catch (\Throwable $e) {}

        $this->flash('success', __('contact_success'));
        $this->redirect('/#contact');
    }
}
