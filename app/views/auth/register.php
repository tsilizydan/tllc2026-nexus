<!-- Register Form Content — injected into auth.php layout -->
<h2 style="font-size:1.25rem; font-weight:600; color:white; margin-bottom:1.5rem;">
    <i class="fas fa-user-plus" style="margin-right:0.5rem; opacity:0.7;"></i><?= __('sign_up') ?>
</h2>

<form method="POST" action="<?= url('/register') ?>">
    <?= csrf_field() ?>

    <div class="form-group">
        <label class="form-label"><?= __('name') ?></label>
        <div style="position:relative;">
            <i class="fas fa-user" style="position:absolute; left:0.75rem; top:50%; transform:translateY(-50%); color:#64748b; font-size:0.875rem;"></i>
            <input type="text" name="name" required minlength="2"
                   class="form-input" style="padding-left:2.5rem;"
                   placeholder="Votre nom complet">
        </div>
    </div>

    <div class="form-group">
        <label class="form-label"><?= __('email') ?></label>
        <div style="position:relative;">
            <i class="fas fa-envelope" style="position:absolute; left:0.75rem; top:50%; transform:translateY(-50%); color:#64748b; font-size:0.875rem;"></i>
            <input type="email" name="email" required
                   class="form-input" style="padding-left:2.5rem;"
                   placeholder="votre@email.com">
        </div>
    </div>

    <div class="form-group">
        <label class="form-label"><?= __('password') ?></label>
        <div style="position:relative;">
            <i class="fas fa-lock" style="position:absolute; left:0.75rem; top:50%; transform:translateY(-50%); color:#64748b; font-size:0.875rem;"></i>
            <input type="password" name="password" required minlength="8"
                   class="form-input" style="padding-left:2.5rem;"
                   placeholder="Minimum 8 caractères"
                   id="regPassword"
                   oninput="updateStrength(this.value)">
        </div>
        <!-- Password strength indicator -->
        <div style="margin-top:0.5rem; height:4px; border-radius:4px; background:rgba(255,255,255,0.1); overflow:hidden;">
            <div id="pwStrength" style="height:100%; border-radius:4px; width:0%; transition:all 0.3s;"></div>
        </div>
    </div>

    <div class="form-group">
        <label class="form-label"><?= __('password_confirm') ?></label>
        <div style="position:relative;">
            <i class="fas fa-shield-alt" style="position:absolute; left:0.75rem; top:50%; transform:translateY(-50%); color:#64748b; font-size:0.875rem;"></i>
            <input type="password" name="password_confirm" required minlength="8"
                   class="form-input" style="padding-left:2.5rem;"
                   placeholder="Confirmez le mot de passe">
        </div>
    </div>

    <button type="submit" class="btn-submit">
        <i class="fas fa-user-plus" style="margin-right:0.5rem;"></i><?= __('sign_up') ?>
    </button>
</form>

<div class="auth-footer">
    <?= __('have_account') ?>
    <a href="<?= url('/login') ?>" class="auth-link"><?= __('sign_in') ?></a>
</div>

<script>
function updateStrength(pw) {
    const bar = document.getElementById('pwStrength');
    if (pw.length < 8) {
        bar.style.width = '25%';
        bar.style.background = '#ef4444';
    } else if (pw.length < 12) {
        bar.style.width = '50%';
        bar.style.background = '#eab308';
    } else {
        bar.style.width = '100%';
        bar.style.background = '#10b981';
    }
}
</script>
