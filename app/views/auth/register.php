<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title><?= __('register') ?> — <?= e($appName) ?></title>
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@300;400;500;600;700;800&display=swap" rel="stylesheet">
    <script src="https://cdn.tailwindcss.com"></script>
    <script>tailwind.config={darkMode:'class',theme:{extend:{colors:{primary:{500:'#6C3CE1',600:'#5a1fd4'},accent:{300:'#67e8f9',400:'#22D3EE'}},fontFamily:{sans:['Inter','system-ui','sans-serif']}}}}</script>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.1/css/all.min.css">
    <style>
        body { font-family: 'Inter', system-ui, sans-serif; }
        .glass { background: rgba(255,255,255,0.05); backdrop-filter: blur(20px); border: 1px solid rgba(255,255,255,0.08); }
        .gradient-text { background: linear-gradient(135deg, #6C3CE1, #22D3EE); -webkit-background-clip: text; -webkit-text-fill-color: transparent; }
        .gradient-bg { background: linear-gradient(135deg, #6C3CE1, #22D3EE); }
        .input-focus:focus { border-color: #6C3CE1; box-shadow: 0 0 0 3px rgba(108, 60, 225, 0.15); }
        .auth-bg { background: #0F172A; background-image: radial-gradient(ellipse at 20% 50%, rgba(108,60,225,0.15) 0%, transparent 50%), radial-gradient(ellipse at 80% 50%, rgba(34,211,238,0.1) 0%, transparent 50%); }
        .slide-up { animation: slideUp 0.6s ease-out; }
        @keyframes slideUp { from { opacity:0; transform:translateY(30px); } to { opacity:1; transform:translateY(0); } }
    </style>
    <script defer src="https://cdn.jsdelivr.net/npm/alpinejs@3.x.x/dist/cdn.min.js"></script>
</head>
<body class="auth-bg min-h-screen flex items-center justify-center p-4">
    <?php if (!empty($flashError)): ?>
    <div x-data="{show:true}" x-show="show" x-init="setTimeout(()=>show=false,5000)" class="fixed top-4 right-4 z-50 glass rounded-xl p-4 flex items-center gap-3 text-red-400 border border-red-500/20 max-w-md">
        <i class="fas fa-exclamation-circle"></i><span class="text-sm"><?= $flashError ?></span>
        <button @click="show=false" class="ml-auto text-white/50 hover:text-white"><i class="fas fa-times"></i></button>
    </div>
    <?php endif; ?>

    <div class="w-full max-w-md slide-up">
        <div class="text-center mb-8">
            <div class="inline-flex items-center justify-center w-16 h-16 rounded-2xl gradient-bg mb-4" style="box-shadow:0 0 30px rgba(108,60,225,0.3)">
                <i class="fas fa-bolt text-white text-2xl"></i>
            </div>
            <h1 class="text-3xl font-bold gradient-text"><?= e($appName) ?></h1>
            <p class="text-slate-400 mt-2 text-sm">Créez votre compte</p>
        </div>

        <div class="glass rounded-2xl p-8">
            <h2 class="text-xl font-semibold text-white mb-6"><?= __('sign_up') ?></h2>
            <form method="POST" action="<?= url('/register') ?>" class="space-y-4" x-data="{ pw: '' }">
                <?= csrf_field() ?>
                <div>
                    <label class="block text-sm font-medium text-slate-300 mb-2"><?= __('name') ?></label>
                    <div class="relative">
                        <i class="fas fa-user absolute left-3 top-1/2 -translate-y-1/2 text-slate-500"></i>
                        <input type="text" name="name" required minlength="2" class="w-full bg-white/5 border border-white/10 rounded-xl pl-10 pr-4 py-3 text-white placeholder-slate-500 input-focus transition-all outline-none" placeholder="Votre nom complet">
                    </div>
                </div>
                <div>
                    <label class="block text-sm font-medium text-slate-300 mb-2"><?= __('email') ?></label>
                    <div class="relative">
                        <i class="fas fa-envelope absolute left-3 top-1/2 -translate-y-1/2 text-slate-500"></i>
                        <input type="email" name="email" required class="w-full bg-white/5 border border-white/10 rounded-xl pl-10 pr-4 py-3 text-white placeholder-slate-500 input-focus transition-all outline-none" placeholder="votre@email.com">
                    </div>
                </div>
                <div>
                    <label class="block text-sm font-medium text-slate-300 mb-2"><?= __('password') ?></label>
                    <div class="relative">
                        <i class="fas fa-lock absolute left-3 top-1/2 -translate-y-1/2 text-slate-500"></i>
                        <input type="password" name="password" required minlength="8" x-model="pw" class="w-full bg-white/5 border border-white/10 rounded-xl pl-10 pr-4 py-3 text-white placeholder-slate-500 input-focus transition-all outline-none" placeholder="Minimum 8 caractères">
                    </div>
                    <div class="mt-2 h-1 rounded-full bg-white/10 overflow-hidden">
                        <div class="h-full rounded-full transition-all duration-300"
                             :class="pw.length < 8 ? 'w-1/4 bg-red-500' : pw.length < 12 ? 'w-2/4 bg-yellow-500' : 'w-full bg-emerald-500'"></div>
                    </div>
                </div>
                <div>
                    <label class="block text-sm font-medium text-slate-300 mb-2"><?= __('password_confirm') ?></label>
                    <div class="relative">
                        <i class="fas fa-shield-alt absolute left-3 top-1/2 -translate-y-1/2 text-slate-500"></i>
                        <input type="password" name="password_confirm" required minlength="8" class="w-full bg-white/5 border border-white/10 rounded-xl pl-10 pr-4 py-3 text-white placeholder-slate-500 input-focus transition-all outline-none" placeholder="Confirmez le mot de passe">
                    </div>
                </div>
                <button type="submit" class="w-full gradient-bg text-white py-3 px-6 rounded-xl font-semibold transition-all duration-300 hover:shadow-lg hover:shadow-primary-500/25 active:scale-[0.98] mt-2">
                    <i class="fas fa-user-plus mr-2"></i><?= __('sign_up') ?>
                </button>
            </form>
            <div class="mt-6 text-center">
                <p class="text-slate-500 text-sm"><?= __('have_account') ?> <a href="<?= url('/login') ?>" class="text-accent-400 hover:text-accent-300 font-medium"><?= __('sign_in') ?></a></p>
            </div>
        </div>
        <p class="text-center text-slate-600 text-xs mt-6">&copy; <?= date('Y') ?> TSILIZY LLC</p>
    </div>
</body>
</html>
