<?php
/**
 * Auth Controller — TSILIZY Nexus
 */

class AuthController extends Controller
{
    private User $userModel;

    public function __construct()
    {
        $this->userModel = new User();
    }

    /**
     * Show login form
     */
    public function loginForm(): void
    {
        if (Auth::check()) {
            $this->redirect('/dashboard');
            return;
        }
        $this->viewOnly('auth.login');
    }

    /**
     * Process login
     */
    public function login(): void
    {
        if (!$this->validateCsrf()) {
            $this->redirect('/login');
            return;
        }

        // Rate limiting
        $rateLimiter = new RateLimitMiddleware();
        if (!$rateLimiter->handle()) return;

        $email = $this->input('email');
        $password = $_POST['password'] ?? '';
        $remember = isset($_POST['remember']);

        if (empty($email) || empty($password)) {
            $this->flash('error', 'Veuillez remplir tous les champs.');
            $this->redirect('/login');
            return;
        }

        if (Auth::attempt($email, $password, $remember)) {
            RateLimitMiddleware::clearAttempts();
            
            // Redirect to intended URL or dashboard
            $intended = $_SESSION['intended_url'] ?? '/dashboard';
            unset($_SESSION['intended_url']);
            $this->redirect($intended);
        } else {
            RateLimitMiddleware::recordFailure();
            $this->flash('error', 'Email ou mot de passe incorrect.');
            $this->redirect('/login');
        }
    }

    /**
     * Show registration form
     */
    public function registerForm(): void
    {
        if (Auth::check()) {
            $this->redirect('/dashboard');
            return;
        }
        $this->viewOnly('auth.register');
    }

    /**
     * Process registration
     */
    public function register(): void
    {
        if (!$this->validateCsrf()) {
            $this->redirect('/register');
            return;
        }

        $name = $this->input('name');
        $email = $this->input('email');
        $password = $_POST['password'] ?? '';
        $passwordConfirm = $_POST['password_confirm'] ?? '';

        // Validation
        $errors = [];
        if (empty($name) || strlen($name) < 2) $errors[] = 'Le nom doit contenir au moins 2 caractères.';
        if (empty($email) || !filter_var($email, FILTER_VALIDATE_EMAIL)) $errors[] = 'Email invalide.';
        if (strlen($password) < 8) $errors[] = 'Le mot de passe doit contenir au moins 8 caractères.';
        if ($password !== $passwordConfirm) $errors[] = 'Les mots de passe ne correspondent pas.';

        // Check if email exists
        if ($this->userModel->findByEmail($email)) {
            $errors[] = 'Cet email est déjà utilisé.';
        }

        if (!empty($errors)) {
            $this->flash('error', implode('<br>', $errors));
            $this->redirect('/register');
            return;
        }

        // Create user
        $verificationToken = Auth::generateVerificationToken();
        $userId = $this->userModel->create([
            'name'               => $name,
            'email'              => $email,
            'password'           => Auth::hashPassword($password),
            'role'               => 'user',
            'status'             => 'active',
            'verification_token' => $verificationToken,
            'plan_id'            => 1, // Free plan
        ]);

        if ($userId) {
            // Auto-login after registration
            Auth::attempt($email, $password);
            $this->flash('success', 'Bienvenue sur TSILIZY Nexus ! Votre compte a été créé avec succès.');
            $this->redirect('/dashboard');
        } else {
            $this->flash('error', 'Une erreur est survenue. Veuillez réessayer.');
            $this->redirect('/register');
        }
    }

    /**
     * Logout
     */
    public function logout(): void
    {
        Auth::logout();
        $this->flash('success', 'Vous avez été déconnecté avec succès.');
        $this->redirect('/');
    }

    /**
     * Show forgot password form
     */
    public function forgotPasswordForm(): void
    {
        $this->viewOnly('auth.forgot-password');
    }

    /**
     * Process forgot password
     */
    public function forgotPassword(): void
    {
        if (!$this->validateCsrf()) {
            $this->redirect('/forgot-password');
            return;
        }

        $email = $this->input('email');
        $user = $this->userModel->findByEmail($email);

        if ($user) {
            $token = Auth::generateResetToken();
            $this->userModel->update($user['id'], [
                'reset_token'         => $token,
                'reset_token_expires' => date('Y-m-d H:i:s', time() + 3600),
            ]);
            // In production, send email with reset link
        }

        // Always show success to prevent email enumeration
        $this->flash('success', 'Si cet email existe, un lien de réinitialisation a été envoyé.');
        $this->redirect('/forgot-password');
    }

    /**
     * Show reset password form
     */
    public function resetPasswordForm(string $token): void
    {
        $user = $this->userModel->findByResetToken($token);
        if (!$user) {
            $this->flash('error', 'Lien de réinitialisation invalide ou expiré.');
            $this->redirect('/login');
            return;
        }
        $this->viewOnly('auth.reset-password', ['token' => $token]);
    }

    /**
     * Process reset password
     */
    public function resetPassword(): void
    {
        if (!$this->validateCsrf()) {
            $this->redirect('/login');
            return;
        }

        $token = $this->input('token');
        $password = $_POST['password'] ?? '';
        $passwordConfirm = $_POST['password_confirm'] ?? '';

        if (strlen($password) < 8 || $password !== $passwordConfirm) {
            $this->flash('error', 'Le mot de passe doit contenir au moins 8 caractères et les deux champs doivent correspondre.');
            $this->redirect('/reset-password/' . $token);
            return;
        }

        $user = $this->userModel->findByResetToken($token);
        if (!$user) {
            $this->flash('error', 'Lien de réinitialisation invalide ou expiré.');
            $this->redirect('/login');
            return;
        }

        $this->userModel->update($user['id'], [
            'password'            => Auth::hashPassword($password),
            'reset_token'         => null,
            'reset_token_expires' => null,
        ]);

        $this->flash('success', 'Mot de passe modifié avec succès. Vous pouvez maintenant vous connecter.');
        $this->redirect('/login');
    }

    /**
     * Verify email
     */
    public function verifyEmail(string $token): void
    {
        $user = $this->userModel->findByVerificationToken($token);
        if ($user) {
            $this->userModel->update($user['id'], [
                'email_verified_at'  => date('Y-m-d H:i:s'),
                'verification_token' => null,
            ]);
            $this->flash('success', 'Email vérifié avec succès !');
        } else {
            $this->flash('error', 'Lien de vérification invalide.');
        }
        $this->redirect('/login');
    }
}
