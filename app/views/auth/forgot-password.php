<!-- Forgot Password Form Content — injected into auth.php layout -->
<h2 style="font-size:1.25rem; font-weight:600; color:white; margin-bottom:0.5rem;">
    <i class="fas fa-key" style="margin-right:0.5rem; opacity:0.7;"></i>Mot de passe oublié
</h2>
<p style="font-size:0.875rem; color:#94a3b8; margin-bottom:1.5rem;">
    Entrez votre email pour recevoir un lien de réinitialisation.
</p>

<form method="POST" action="<?= url('/forgot-password') ?>">
    <?= csrf_field() ?>

    <div class="form-group">
        <label class="form-label">Email</label>
        <div style="position:relative;">
            <i class="fas fa-envelope" style="position:absolute; left:0.75rem; top:50%; transform:translateY(-50%); color:#64748b; font-size:0.875rem;"></i>
            <input type="email" name="email" required
                   class="form-input" style="padding-left:2.5rem;"
                   placeholder="votre@email.com">
        </div>
    </div>

    <button type="submit" class="btn-submit">
        <i class="fas fa-paper-plane" style="margin-right:0.5rem;"></i>Envoyer le lien
    </button>
</form>

<div class="auth-footer">
    <a href="<?= url('/login') ?>" class="auth-link">
        <i class="fas fa-arrow-left" style="margin-right:0.25rem;"></i>Retour à la connexion
    </a>
</div>
