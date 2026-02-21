<!-- Reset Password Form Content — injected into auth.php layout -->
<h2 style="font-size:1.25rem; font-weight:600; color:white; margin-bottom:1.5rem;">
    <i class="fas fa-shield-alt" style="margin-right:0.5rem; opacity:0.7;"></i>Nouveau mot de passe
</h2>

<form method="POST" action="<?= url('/reset-password') ?>">
    <?= csrf_field() ?>
    <input type="hidden" name="token" value="<?= e($token ?? '') ?>">

    <div class="form-group">
        <label class="form-label">Nouveau mot de passe</label>
        <div style="position:relative;">
            <i class="fas fa-lock" style="position:absolute; left:0.75rem; top:50%; transform:translateY(-50%); color:#64748b; font-size:0.875rem;"></i>
            <input type="password" name="password" required minlength="8"
                   class="form-input" style="padding-left:2.5rem;"
                   placeholder="Minimum 8 caractères">
        </div>
    </div>

    <div class="form-group">
        <label class="form-label">Confirmer le mot de passe</label>
        <div style="position:relative;">
            <i class="fas fa-shield-alt" style="position:absolute; left:0.75rem; top:50%; transform:translateY(-50%); color:#64748b; font-size:0.875rem;"></i>
            <input type="password" name="password_confirm" required minlength="8"
                   class="form-input" style="padding-left:2.5rem;"
                   placeholder="Confirmez le mot de passe">
        </div>
    </div>

    <button type="submit" class="btn-submit">
        <i class="fas fa-key" style="margin-right:0.5rem;"></i>Réinitialiser
    </button>
</form>

<div class="auth-footer">
    <a href="<?= url('/login') ?>" class="auth-link">
        <i class="fas fa-arrow-left" style="margin-right:0.25rem;"></i>Retour à la connexion
    </a>
</div>
