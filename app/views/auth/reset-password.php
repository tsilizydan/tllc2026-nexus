<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8"><meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Réinitialiser le mot de passe — <?= e($appName) ?></title>
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@400;500;600;700&display=swap" rel="stylesheet">
    <script src="https://cdn.tailwindcss.com"></script>
    <script>tailwind.config={theme:{extend:{colors:{primary:{500:'#6C3CE1'},accent:{400:'#22D3EE'}},fontFamily:{sans:['Inter','system-ui']}}}}</script>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.1/css/all.min.css">
    <style>body{font-family:'Inter',system-ui}.glass{background:rgba(255,255,255,0.05);backdrop-filter:blur(20px);border:1px solid rgba(255,255,255,0.08)}.gradient-text{background:linear-gradient(135deg,#6C3CE1,#22D3EE);-webkit-background-clip:text;-webkit-text-fill-color:transparent}.gradient-bg{background:linear-gradient(135deg,#6C3CE1,#22D3EE)}.input-focus:focus{border-color:#6C3CE1;box-shadow:0 0 0 3px rgba(108,60,225,0.15)}.auth-bg{background:#0F172A;background-image:radial-gradient(ellipse at 20% 50%,rgba(108,60,225,0.15),transparent 50%),radial-gradient(ellipse at 80% 50%,rgba(34,211,238,0.1),transparent 50%)}</style>
    <script defer src="https://cdn.jsdelivr.net/npm/alpinejs@3.x.x/dist/cdn.min.js"></script>
</head>
<body class="auth-bg min-h-screen flex items-center justify-center p-4">
    <?php if (!empty($flashError)): ?>
    <div x-data="{show:true}" x-show="show" x-init="setTimeout(()=>show=false,5000)" class="fixed top-4 right-4 z-50 glass rounded-xl p-4 text-red-400 border border-red-500/20"><i class="fas fa-exclamation-circle mr-2"></i><?= $flashError ?></div>
    <?php endif; ?>
    <div class="w-full max-w-md">
        <div class="text-center mb-8">
            <div class="inline-flex items-center justify-center w-16 h-16 rounded-2xl gradient-bg mb-4"><i class="fas fa-bolt text-white text-2xl"></i></div>
            <h1 class="text-3xl font-bold gradient-text"><?= e($appName) ?></h1>
        </div>
        <div class="glass rounded-2xl p-8">
            <h2 class="text-xl font-semibold text-white mb-6">Nouveau mot de passe</h2>
            <form method="POST" action="<?= url('/reset-password') ?>" class="space-y-5">
                <?= csrf_field() ?>
                <input type="hidden" name="token" value="<?= e($token) ?>">
                <div>
                    <label class="block text-sm font-medium text-slate-300 mb-2">Nouveau mot de passe</label>
                    <input type="password" name="password" required minlength="8" class="w-full bg-white/5 border border-white/10 rounded-xl px-4 py-3 text-white placeholder-slate-500 input-focus transition-all outline-none" placeholder="Minimum 8 caractères">
                </div>
                <div>
                    <label class="block text-sm font-medium text-slate-300 mb-2">Confirmer</label>
                    <input type="password" name="password_confirm" required minlength="8" class="w-full bg-white/5 border border-white/10 rounded-xl px-4 py-3 text-white placeholder-slate-500 input-focus transition-all outline-none" placeholder="Confirmez le mot de passe">
                </div>
                <button type="submit" class="w-full gradient-bg text-white py-3 rounded-xl font-semibold transition-all hover:shadow-lg active:scale-[0.98]">
                    <i class="fas fa-key mr-2"></i>Réinitialiser
                </button>
            </form>
        </div>
    </div>
</body>
</html>
