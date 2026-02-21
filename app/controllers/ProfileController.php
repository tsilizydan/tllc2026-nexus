<?php
class ProfileController extends Controller {
    public function index(): void {
        $this->requireAuth();
        $user = (new User())->find(Auth::id());
        $this->view('profile.index', ['pageTitle' => __('nav_profile'), 'user' => $user]);
    }

    public function update(): void {
        $this->requireAuth();
        if (!$this->validateCsrf()) { $this->redirect('/profile'); return; }

        (new User())->update(Auth::id(), [
            'name'     => $this->input('name'),
            'phone'    => $this->input('phone'),
            'position' => $this->input('position'),
            'bio'      => $this->rawInput('bio'),
        ]);

        $_SESSION['user_name'] = $this->input('name');
        $this->flash('success', 'Profil mis à jour.');
        $this->redirect('/profile');
    }

    public function updatePassword(): void {
        $this->requireAuth();
        if (!$this->validateCsrf()) { $this->redirect('/profile'); return; }

        $user = (new User())->find(Auth::id());
        $currentPassword = $_POST['current_password'] ?? '';
        $newPassword      = $_POST['new_password'] ?? '';

        if (!password_verify($currentPassword, $user['password'])) {
            $this->flash('error', 'Mot de passe actuel incorrect.');
            $this->redirect('/profile');
            return;
        }

        if (strlen($newPassword) < 8) {
            $this->flash('error', 'Le nouveau mot de passe doit contenir au moins 8 caractères.');
            $this->redirect('/profile');
            return;
        }

        (new User())->update(Auth::id(), ['password' => Auth::hashPassword($newPassword)]);
        $this->flash('success', 'Mot de passe modifié.');
        $this->redirect('/profile');
    }

    public function updateAvatar(): void {
        $this->requireAuth();
        if (!$this->validateCsrf()) { $this->redirect('/profile'); return; }

        // File upload handling
        if (empty($_FILES['avatar']) || $_FILES['avatar']['error'] !== UPLOAD_ERR_OK) {
            $this->flash('error', 'Aucun fichier sélectionné.');
            $this->redirect('/profile');
            return;
        }

        $file = $_FILES['avatar'];
        $maxSize = config('app.upload_max_size', 5242880);
        $allowed = ['jpg', 'jpeg', 'png', 'gif', 'webp'];

        // Validate size
        if ($file['size'] > $maxSize) {
            $this->flash('error', 'Le fichier est trop volumineux (max 5 Mo).');
            $this->redirect('/profile');
            return;
        }

        // Validate extension
        $ext = strtolower(pathinfo($file['name'], PATHINFO_EXTENSION));
        if (!in_array($ext, $allowed)) {
            $this->flash('error', 'Format non autorisé. Utilisez : ' . implode(', ', $allowed));
            $this->redirect('/profile');
            return;
        }

        // Validate MIME type
        $finfo = finfo_open(FILEINFO_MIME_TYPE);
        $mime  = finfo_file($finfo, $file['tmp_name']);
        finfo_close($finfo);

        $allowedMimes = ['image/jpeg', 'image/png', 'image/gif', 'image/webp'];
        if (!in_array($mime, $allowedMimes)) {
            $this->flash('error', 'Type de fichier non autorisé.');
            $this->redirect('/profile');
            return;
        }

        // Generate safe filename
        $filename = 'avatar_' . Auth::id() . '_' . bin2hex(random_bytes(8)) . '.' . $ext;
        $uploadDir = ROOT_PATH . '/storage/uploads/avatars';
        if (!is_dir($uploadDir)) {
            mkdir($uploadDir, 0755, true);
        }

        $destination = $uploadDir . '/' . $filename;
        if (move_uploaded_file($file['tmp_name'], $destination)) {
            // Delete old avatar if exists
            $user = (new User())->find(Auth::id());
            if (!empty($user['avatar'])) {
                $oldFile = ROOT_PATH . '/storage/uploads/avatars/' . basename($user['avatar']);
                if (file_exists($oldFile)) {
                    @unlink($oldFile);
                }
            }

            (new User())->update(Auth::id(), ['avatar' => $filename]);
            $_SESSION['user_avatar'] = $filename;
            $this->flash('success', 'Avatar mis à jour.');
        } else {
            $this->flash('error', 'Erreur lors de l\'upload.');
        }

        $this->redirect('/profile');
    }
}
