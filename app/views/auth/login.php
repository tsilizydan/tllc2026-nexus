<!DOCTYPE html>
<html lang="fr" x-data="{ darkMode: localStorage.getItem('darkMode') === 'true' }" :class="{ 'dark': darkMode }">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title><?= e($pageTitle ?? __('login')) ?> — <?= e($appName) ?></title>
    <meta name="description" content="TSILIZY Nexus — Plateforme de productivité entreprise">
    <link rel="manifest" href="<?= url('/public/manifest.json') ?>">
    <meta name="theme-color" content="#0F172A">
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@300;400;500;600;700;800;900&display=swap" rel="stylesheet">
    <script src="https://cdn.tailwindcss.com"></script>
    <script>
        tailwind.config = {
            darkMode: 'class',
            theme: {
                extend: {
                    colors: {
                        primary: { 50:'#f3f0ff',100:'#e9e3ff',200:'#d4c8ff',300:'#b49dff',400:'#9166ff',500:'#6C3CE1',600:'#5a1fd4',700:'#4a15b8',800:'#3d1296',900:'#33107a' },
                        secondary: { 50:'#eef0ff',100:'#e0e4ff',200:'#c7cdfe',400:'#5b63dc',500:'#1E1B4B',600:'#1a1741',700:'#151237',800:'#100e2d',900:'#0b0a23' },
                        accent: { 50:'#ecfeff',100:'#cffafe',200:'#a5f3fc',300:'#67e8f9',400:'#22D3EE',500:'#06b6d4',600:'#0891b2' },
                        surface: { light:'#F8FAFC',dark:'#0F172A',card:'#1E293B' }
                    },
                    fontFamily: { sans: ['Inter', 'system-ui', 'sans-serif'] }
                }
            }
        }
    </script>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.1/css/all.min.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/animate.css/4.1.1/animate.min.css">
    <style>
        * { margin: 0; padding: 0; box-sizing: border-box; }
        body { font-family: 'Inter', system-ui, sans-serif; }
        .glass { background: rgba(255,255,255,0.05); backdrop-filter: blur(20px); -webkit-backdrop-filter: blur(20px); border: 1px solid rgba(255,255,255,0.08); }
        .glass-light { background: rgba(255,255,255,0.7); backdrop-filter: blur(20px); border: 1px solid rgba(255,255,255,0.3); }
        .gradient-text { background: linear-gradient(135deg, #6C3CE1, #22D3EE); -webkit-background-clip: text; -webkit-text-fill-color: transparent; }
        .gradient-bg { background: linear-gradient(135deg, #6C3CE1, #22D3EE); }
        .gradient-bg-hover:hover { background: linear-gradient(135deg, #5a1fd4, #06b6d4); }
        .glow { box-shadow: 0 0 30px rgba(108, 60, 225, 0.3); }
        .glow-accent { box-shadow: 0 0 30px rgba(34, 211, 238, 0.2); }
        .input-focus:focus { border-color: #6C3CE1; box-shadow: 0 0 0 3px rgba(108, 60, 225, 0.15); }
        .auth-bg {
            background: #0F172A;
            background-image: radial-gradient(ellipse at 20% 50%, rgba(108, 60, 225, 0.15) 0%, transparent 50%),
                              radial-gradient(ellipse at 80% 50%, rgba(34, 211, 238, 0.1) 0%, transparent 50%),
                              radial-gradient(ellipse at 50% 0%, rgba(108, 60, 225, 0.1) 0%, transparent 40%);
        }
        .float-animation { animation: float 6s ease-in-out infinite; }
        @keyframes float { 0%, 100% { transform: translateY(0); } 50% { transform: translateY(-10px); } }
        .pulse-glow { animation: pulseGlow 3s ease-in-out infinite; }
        @keyframes pulseGlow { 0%, 100% { box-shadow: 0 0 20px rgba(108, 60, 225, 0.2); } 50% { box-shadow: 0 0 40px rgba(108, 60, 225, 0.4); } }
        .slide-up { animation: slideUp 0.6s ease-out; }
        @keyframes slideUp { from { opacity: 0; transform: translateY(30px); } to { opacity: 1; transform: translateY(0); } }
    </style>
    <script defer src="https://cdn.jsdelivr.net/npm/alpinejs@3.x.x/dist/cdn.min.js"></script>
</head>
<body class="auth-bg min-h-screen flex items-center justify-center p-4">
    <!-- Toast notifications -->
    <?php if ($flashSuccess || $flashError || $flashInfo): ?>
    <div x-data="{ show: true }" x-show="show" x-init="setTimeout(() => show = false, 5000)"
         x-transition:enter="transition ease-out duration-300"
         x-transition:enter-start="opacity-0 translate-y-[-20px]"
         x-transition:enter-end="opacity-100 translate-y-0"
         x-transition:leave="transition ease-in duration-200"
         x-transition:leave-start="opacity-100"
         x-transition:leave-end="opacity-0"
         class="fixed top-4 right-4 z-50 max-w-md">
        <?php if ($flashSuccess): ?>
        <div class="glass rounded-xl p-4 flex items-center gap-3 text-emerald-400 border border-emerald-500/20">
            <i class="fas fa-check-circle text-lg"></i>
            <span class="text-sm"><?= $flashSuccess ?></span>
            <button @click="show = false" class="ml-auto text-white/50 hover:text-white"><i class="fas fa-times"></i></button>
        </div>
        <?php elseif ($flashError): ?>
        <div class="glass rounded-xl p-4 flex items-center gap-3 text-red-400 border border-red-500/20">
            <i class="fas fa-exclamation-circle text-lg"></i>
            <span class="text-sm"><?= $flashError ?></span>
            <button @click="show = false" class="ml-auto text-white/50 hover:text-white"><i class="fas fa-times"></i></button>
        </div>
        <?php elseif ($flashInfo): ?>
        <div class="glass rounded-xl p-4 flex items-center gap-3 text-accent-400 border border-accent-500/20">
            <i class="fas fa-info-circle text-lg"></i>
            <span class="text-sm"><?= $flashInfo ?></span>
            <button @click="show = false" class="ml-auto text-white/50 hover:text-white"><i class="fas fa-times"></i></button>
        </div>
        <?php endif; ?>
    </div>
    <?php endif; ?>

    <div class="w-full max-w-md slide-up">
        <!-- Logo -->
        <div class="text-center mb-8">
            <div class="inline-flex items-center justify-center w-16 h-16 rounded-2xl gradient-bg mb-4 glow float-animation">
                <i class="fas fa-bolt text-white text-2xl"></i>
            </div>
            <h1 class="text-3xl font-bold gradient-text"><?= e($appName) ?></h1>
            <p class="text-slate-400 mt-2 text-sm">Plateforme de productivité entreprise</p>
        </div>

        <!-- Login Card -->
        <div class="glass rounded-2xl p-8 pulse-glow">
            <h2 class="text-xl font-semibold text-white mb-6"><?= __('sign_in') ?></h2>

            <form method="POST" action="<?= url('/login') ?>" class="space-y-5">
                <?= csrf_field() ?>

                <div>
                    <label class="block text-sm font-medium text-slate-300 mb-2"><?= __('email') ?></label>
                    <div class="relative">
                        <i class="fas fa-envelope absolute left-3 top-1/2 -translate-y-1/2 text-slate-500"></i>
                        <input type="email" name="email" required autocomplete="email"
                               class="w-full bg-white/5 border border-white/10 rounded-xl pl-10 pr-4 py-3 text-white placeholder-slate-500 input-focus transition-all duration-300 outline-none"
                               placeholder="votre@email.com">
                    </div>
                </div>

                <div>
                    <label class="block text-sm font-medium text-slate-300 mb-2"><?= __('password') ?></label>
                    <div class="relative" x-data="{ showPw: false }">
                        <i class="fas fa-lock absolute left-3 top-1/2 -translate-y-1/2 text-slate-500"></i>
                        <input :type="showPw ? 'text' : 'password'" name="password" required
                               class="w-full bg-white/5 border border-white/10 rounded-xl pl-10 pr-12 py-3 text-white placeholder-slate-500 input-focus transition-all duration-300 outline-none"
                               placeholder="••••••••">
                        <button type="button" @click="showPw = !showPw" class="absolute right-3 top-1/2 -translate-y-1/2 text-slate-500 hover:text-slate-300">
                            <i :class="showPw ? 'fas fa-eye-slash' : 'fas fa-eye'"></i>
                        </button>
                    </div>
                </div>

                <div class="flex items-center justify-between">
                    <label class="flex items-center gap-2 cursor-pointer">
                        <input type="checkbox" name="remember" class="w-4 h-4 rounded border-white/20 bg-white/5 text-primary-500 focus:ring-primary-500">
                        <span class="text-sm text-slate-400"><?= __('remember_me') ?></span>
                    </label>
                    <a href="<?= url('/forgot-password') ?>" class="text-sm text-accent-400 hover:text-accent-300 transition-colors">
                        <?= __('forgot_password') ?>
                    </a>
                </div>

                <button type="submit"
                        class="w-full gradient-bg gradient-bg-hover text-white py-3 px-6 rounded-xl font-semibold transition-all duration-300 hover:shadow-lg hover:shadow-primary-500/25 active:scale-[0.98]">
                    <i class="fas fa-sign-in-alt mr-2"></i><?= __('sign_in') ?>
                </button>
            </form>

            <div class="mt-6 text-center">
                <p class="text-slate-500 text-sm">
                    <?= __('no_account') ?> 
                    <a href="<?= url('/register') ?>" class="text-accent-400 hover:text-accent-300 font-medium transition-colors"><?= __('sign_up') ?></a>
                </p>
            </div>
        </div>

        <!-- Footer -->
        <p class="text-center text-slate-600 text-xs mt-6">
            &copy; <?= date('Y') ?> TSILIZY LLC — Tous droits réservés
        </p>
    </div>
</body>
</html>
