<?php
/**
 * Admin Controller — TSILIZY Nexus
 *
 * Full admin panel: dashboard, users CRUD, settings, payments, ads.
 * All actions require admin role via requireAdmin().
 */

class AdminController extends Controller {

    // -----------------------------------------------------------------
    // Dashboard
    // -----------------------------------------------------------------

    public function dashboard(): void {
        $this->requireAuth();
        $this->requireAdmin();

        $userModel   = new User();
        $taskModel   = new Task();
        $projectModel = new Project();

        $stats = [
            'users'    => $userModel->count(),
            'tasks'    => $taskModel->count(),
            'projects' => $projectModel->count(),
            'contacts' => (new Contact())->count(),
            'notes'    => (new Note())->count(),
        ];

        $recentUsers = $userModel->raw(
            "SELECT * FROM users WHERE deleted_at IS NULL ORDER BY created_at DESC LIMIT 10"
        );

        $this->view('admin.dashboard', [
            'pageTitle'   => 'Administration',
            'stats'       => $stats,
            'recentUsers' => $recentUsers,
        ]);
    }

    // -----------------------------------------------------------------
    // User management
    // -----------------------------------------------------------------

    public function users(): void {
        $this->requireAuth();
        $this->requireAdmin();

        $page   = max(1, (int)$this->query('page', 1));
        $result = (new User())->paginate($page, 30);

        $this->view('admin.users', [
            'pageTitle'  => 'Gestion des utilisateurs',
            'users'      => $result['data'],
            'pagination' => $result,
        ]);
    }

    public function createUser(): void {
        $this->requireAuth();
        $this->requireAdmin();

        $this->view('admin.user-edit', [
            'pageTitle' => 'Nouvel utilisateur',
            'user'      => null,
            'plans'     => (new Payment())->getActivePlans(),
        ]);
    }

    public function storeUser(): void {
        $this->requireAuth();
        $this->requireAdmin();
        if (!$this->validateCsrf()) { $this->redirect('/admin/users'); return; }

        $email = $this->input('email');
        $name  = $this->input('name');
        $password = $_POST['password'] ?? '';

        // Validation
        if (empty($name) || empty($email) || empty($password)) {
            $this->flash('error', 'Tous les champs sont obligatoires.');
            $this->redirect('/admin/users/create');
            return;
        }

        if ((new User())->findByEmail($email)) {
            $this->flash('error', 'Cet email est déjà utilisé.');
            $this->redirect('/admin/users/create');
            return;
        }

        (new User())->create([
            'name'     => $name,
            'email'    => $email,
            'password' => Auth::hashPassword($password),
            'role'     => $this->input('role', 'user'),
            'status'   => $this->input('status', 'active'),
            'plan_id'  => $this->input('plan_id') ?: null,
        ]);

        $this->flash('success', 'Utilisateur créé avec succès.');
        $this->redirect('/admin/users');
    }

    public function editUser(string $id): void {
        $this->requireAuth();
        $this->requireAdmin();

        $user = (new User())->find((int)$id);
        if (!$user) {
            $this->flash('error', 'Utilisateur introuvable.');
            $this->redirect('/admin/users');
            return;
        }

        $this->view('admin.user-edit', [
            'pageTitle' => 'Modifier: ' . $user['name'],
            'user'      => $user,
            'plans'     => (new Payment())->getActivePlans(),
        ]);
    }

    public function updateUser(string $id): void {
        $this->requireAuth();
        $this->requireAdmin();
        if (!$this->validateCsrf()) { $this->redirect('/admin/users/' . $id . '/edit'); return; }

        $data = [
            'name'    => $this->input('name'),
            'email'   => $this->input('email'),
            'role'    => $this->input('role'),
            'status'  => $this->input('status', 'active'),
            'plan_id' => $this->input('plan_id') ?: null,
        ];

        // Update password only if provided
        $newPass = $_POST['password'] ?? '';
        if (!empty($newPass)) {
            $data['password'] = Auth::hashPassword($newPass);
        }

        (new User())->update((int)$id, $data);
        $this->flash('success', 'Utilisateur mis à jour.');
        $this->redirect('/admin/users');
    }

    public function deleteUser(string $id): void {
        $this->requireAuth();
        $this->requireAdmin();
        if (!$this->validateCsrf()) { $this->redirect('/admin/users'); return; }

        if ((int)$id === Auth::id()) {
            $this->flash('error', 'Impossible de supprimer votre propre compte.');
        } else {
            (new User())->delete((int)$id);
            $this->flash('success', 'Utilisateur supprimé.');
        }

        $this->redirect('/admin/users');
    }

    public function toggleUser(string $id): void {
        $this->requireAuth();
        $this->requireAdmin();
        if (!$this->validateCsrf()) { $this->redirect('/admin/users'); return; }

        if ((int)$id === Auth::id()) {
            $this->flash('error', 'Impossible de modifier votre propre statut.');
            $this->redirect('/admin/users');
            return;
        }

        $user = (new User())->find((int)$id);
        if ($user) {
            $newStatus = ($user['status'] === 'active') ? 'inactive' : 'active';
            (new User())->update((int)$id, ['status' => $newStatus]);
            $this->flash('success', 'Statut modifié.');
        }

        $this->redirect('/admin/users');
    }

    // -----------------------------------------------------------------
    // Settings
    // -----------------------------------------------------------------

    /** Whitelist of allowed setting keys */
    private const ALLOWED_SETTINGS = [
        'site_name', 'site_description', 'maintenance_mode',
        'allow_registration', 'require_email_verification', 'default_theme',
        'payment_paypal', 'payment_stripe', 'payment_visa',
        'payment_wise', 'payment_crypto', 'payment_redotpay',
        'payment_leetchi', 'payment_gofundme',
    ];

    public function settings(): void {
        $this->requireAuth();
        $this->requireAdmin();

        $settings = (new Model())->raw("SELECT * FROM settings");
        $map = [];
        foreach ($settings as $s) {
            $map[$s['key']] = $s['value'];
        }

        $this->view('admin.settings', ['pageTitle' => 'Paramètres', 'settings' => $map]);
    }

    public function updateSettings(): void {
        $this->requireAuth();
        $this->requireAdmin();
        if (!$this->validateCsrf()) { $this->redirect('/admin/settings'); return; }

        $model = new Model();
        $tokenName = config('app.csrf_token_name', '_csrf_token');

        foreach ($_POST as $key => $val) {
            if ($key === $tokenName) continue;

            // Whitelist check — prevent arbitrary key injection
            if (!in_array($key, self::ALLOWED_SETTINGS, true)) continue;

            $safeVal = htmlspecialchars(trim((string)$val), ENT_QUOTES, 'UTF-8');

            $existing = $model->raw(
                "SELECT id FROM settings WHERE `key` = :k",
                ['k' => $key]
            );

            if ($existing) {
                $model->rawExecute(
                    "UPDATE settings SET `value` = :v, updated_at = NOW() WHERE `key` = :k",
                    ['v' => $safeVal, 'k' => $key]
                );
            } else {
                $model->rawExecute(
                    "INSERT INTO settings (`key`, `value`, `type`, `group`, updated_at) VALUES (:k, :v, 'string', 'general', NOW())",
                    ['k' => $key, 'v' => $safeVal]
                );
            }
        }

        $this->flash('success', 'Paramètres mis à jour.');
        $this->redirect('/admin/settings');
    }

    // -----------------------------------------------------------------
    // Ads
    // -----------------------------------------------------------------

    public function ads(): void {
        $this->requireAuth();
        $this->requireAdmin();

        $ads = (new Model())->raw(
            "SELECT * FROM ads WHERE deleted_at IS NULL ORDER BY created_at DESC"
        );

        $this->view('admin.ads', ['pageTitle' => 'Publicités', 'ads' => $ads]);
    }

    // -----------------------------------------------------------------
    // Payments
    // -----------------------------------------------------------------

    public function payments(): void {
        $this->requireAuth();
        $this->requireAdmin();

        $payments = (new Payment())->raw(
            "SELECT p.*, u.name as user_name, u.email as user_email, pl.name as plan_name
             FROM payments p
             LEFT JOIN users u ON p.user_id = u.id
             LEFT JOIN plans pl ON p.plan_id = pl.id
             WHERE p.deleted_at IS NULL
             ORDER BY p.created_at DESC LIMIT 100"
        );

        $this->view('admin.payments', ['pageTitle' => 'Paiements', 'payments' => $payments]);
    }

    public function validatePayment(string $id): void {
        $this->requireAuth();
        $this->requireAdmin();
        if (!$this->validateCsrf()) { $this->redirect('/admin/payments'); return; }

        (new Payment())->update((int)$id, [
            'status'       => 'completed',
            'validated_by' => Auth::id(),
            'validated_at' => date('Y-m-d H:i:s'),
        ]);

        $this->flash('success', 'Paiement validé.');
        $this->redirect('/admin/payments');
    }
}
