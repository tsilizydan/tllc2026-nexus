<!-- Login Form Content — injected into auth.php layout -->
<h2 style="font-size:1.25rem; font-weight:600; color:white; margin-bottom:1.5rem;">
    <i class="fas fa-sign-in-alt" style="margin-right:0.5rem; opacity:0.7;"></i><?= __('sign_in') ?>
</h2>

<form method="POST" action="<?= url('/login') ?>">
    <?= csrf_field() ?>

    <div class="form-group">
        <label class="form-label"><?= __('email') ?></label>
        <div style="position:relative;">
            <i class="fas fa-envelope" style="position:absolute; left:0.75rem; top:50%; transform:translateY(-50%); color:#64748b; font-size:0.875rem;"></i>
            <input type="email" name="email" required autocomplete="email"
                   class="form-input" style="padding-left:2.5rem;"
                   placeholder="votre@email.com">
        </div>
    </div>

    <div class="form-group">
        <label class="form-label"><?= __('password') ?></label>
        <div style="position:relative;">
            <i class="fas fa-lock" style="position:absolute; left:0.75rem; top:50%; transform:translateY(-50%); color:#64748b; font-size:0.875rem;"></i>
            <input type="password" name="password" required
                   class="form-input" style="padding-left:2.5rem;"
                   placeholder="••••••••"
                   id="loginPassword">
            <button type="button" onclick="togglePassword('loginPassword', this)"
                    style="position:absolute; right:0.75rem; top:50%; transform:translateY(-50%); background:none; border:none; color:#64748b; cursor:pointer; padding:0.25rem;">
                <i class="fas fa-eye"></i>
            </button>
        </div>
    </div>

    <div style="display:flex; align-items:center; justify-content:space-between; margin-bottom:1.25rem;">
        <div class="checkbox-group">
            <input type="checkbox" name="remember" id="remember">
            <label for="remember"><?= __('remember_me') ?></label>
        </div>
        <a href="<?= url('/forgot-password') ?>" class="auth-link" style="font-size:0.8125rem;">
            <?= __('forgot_password') ?>
        </a>
    </div>

    <button type="submit" class="btn-submit">
        <i class="fas fa-sign-in-alt" style="margin-right:0.5rem;"></i><?= __('sign_in') ?>
    </button>
</form>

<div class="auth-footer">
    <?= __('no_account') ?>
    <a href="<?= url('/register') ?>" class="auth-link"><?= __('sign_up') ?></a>
</div>

<script>
function togglePassword(inputId, btn) {
    const input = document.getElementById(inputId);
    const icon = btn.querySelector('i');
    if (input.type === 'password') {
        input.type = 'text';
        icon.className = 'fas fa-eye-slash';
    } else {
        input.type = 'password';
        icon.className = 'fas fa-eye';
    }
}
</script>
