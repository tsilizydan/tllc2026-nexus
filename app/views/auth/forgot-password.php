<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8"><meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Mot de passe oublié — <?= e($appName) ?></title>
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@400;500;600;700&display=swap" rel="stylesheet">
    <script src="https://cdn.tailwindcss.com"></script>
    <script>tailwind.config={theme:{extend:{colors:{primary:{500:'#6C3CE1'},accent:{400:'#22D3EE'}},fontFamily:{sans:['Inter','system-ui']}}}}</script>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.1/css/all.min.css">
    <style>body{font-family:'Inter',system-ui;}.glass{background:rgba(255,255,255,0.05);backdrop-filter:blur(20px);border:1px solid rgba(255,255,255,0.08)}.gradient-text{background:linear-gradient(135deg,#6C3CE1,#22D3EE);-webkit-background-clip:text;-webkit-text-fill-color:transparent}.gradient-bg{background:linear-gradient(135deg,#6C3CE1,#22D3EE)}.input-focus:focus{border-color:#6C3CE1;box-shadow:0 0 0 3px rgba(108,60,225,0.15)}.auth-bg{background:#0F172A;background-image:radial-gradient(ellipse at 20% 50%,rgba(108,60,225,0.15) 0%,transparent 50%),radial-gradient(ellipse at 80% 50%,rgba(34,211,238,0.1) 0%,transparent 50%)}</style>
    <script defer src="https://cdn.jsdelivr.net/npm/alpinejs@3.x.x/dist/cdn.min.js"></script>
</head>
<body class="auth-bg min-h-screen flex items-center justify-center p-4">
    <?php if (!empty($flashSuccess)): ?>
    <div x-data="{show:true}" x-show="show" x-init="setTimeout(()=>show=false,5000)" class="fixed top-4 right-4 z-50 glass rounded-xl p-4 text-emerald-400 border border-emerald-500/20 max-w-md flex items-center gap-3">
        <i class="fas fa-check-circle"></i><span class="text-sm"><?= $flashSuccess ?></span>
    </div>
    <?php endif; ?>
    <div class="w-full max-w-md" style="animation:slideUp .6s ease-out">
        <div class="text-center mb-8">
            <div class="inline-flex items-center justify-center w-16 h-16 rounded-2xl gradient-bg mb-4"><i class="fas fa-bolt text-white text-2xl"></i></div>
            <h1 class="text-3xl font-bold gradient-text"><?= e($appName) ?></h1>
        </div>
        <div class="glass rounded-2xl p-8">
            <h2 class="text-xl font-semibold text-white mb-2">Mot de passe oublié</h2>
            <p class="text-slate-400 text-sm mb-6">Entrez votre email pour recevoir un lien de réinitialisation.</p>
            <form method="POST" action="<?= url('/forgot-password') ?>" class="space-y-5">
                <?= csrf_field() ?>
                <div>
                    <label class="block text-sm font-medium text-slate-300 mb-2">Email</label>
                    <div class="relative">
                        <i class="fas fa-envelope absolute left-3 top-1/2 -translate-y-1/2 text-slate-500"></i>
                        <input type="email" name="email" required class="w-full bg-white/5 border border-white/10 rounded-xl pl-10 pr-4 py-3 text-white placeholder-slate-500 input-focus transition-all outline-none" placeholder="votre@email.com">
                    </div>
                </div>
                <button type="submit" class="w-full gradient-bg text-white py-3 px-6 rounded-xl font-semibold transition-all duration-300 hover:shadow-lg active:scale-[0.98]">
                    <i class="fas fa-paper-plane mr-2"></i>Envoyer le lien
                </button>
            </form>
            <div class="mt-6 text-center"><a href="<?= url('/login') ?>" class="text-accent-400 hover:text-accent-300 text-sm"><i class="fas fa-arrow-left mr-1"></i>Retour à la connexion</a></div>
        </div>
    </div>
    <style>@keyframes slideUp{from{opacity:0;transform:translateY(30px)}to{opacity:1;transform:translateY(0)}}</style>
</body>
</html>
