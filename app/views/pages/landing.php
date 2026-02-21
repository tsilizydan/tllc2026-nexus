<!DOCTYPE html>
<html :lang="locale" x-data="landingApp()" :class="{ 'dark': darkMode }">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
<?= SEO::render() ?>
    <meta name="theme-color" :content="darkMode ? '#0F172A' : '#F8FAFC'">
    <link rel="manifest" href="<?= url('/public/manifest.json') ?>">
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
                        accent: { 50:'#ecfeff',100:'#cffafe',200:'#a5f3fc',300:'#67e8f9',400:'#22D3EE',500:'#06b6d4',600:'#0891b2' },
                        surface: { dark:'#0F172A',card:'#1E293B',card2:'#334155' }
                    },
                    fontFamily: { sans: ['Inter', 'system-ui', 'sans-serif'] }
                }
            }
        }
    </script>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.1/css/all.min.css">
    <style>
        * { margin: 0; padding: 0; box-sizing: border-box; }
        body { font-family: 'Inter', system-ui, sans-serif; overflow-x: hidden; transition: background 0.4s, color 0.4s; }
        .dark body { background: #0F172A; color: #e2e8f0; }
        body { background: #F8FAFC; color: #1E293B; }

        /* Custom Scrollbar */
        ::-webkit-scrollbar { width: 8px; height: 8px; }
        ::-webkit-scrollbar-track { background: transparent; }
        .dark ::-webkit-scrollbar-thumb { background: linear-gradient(180deg, rgba(108,60,225,0.4), rgba(34,211,238,0.3)); border-radius: 4px; }
        ::-webkit-scrollbar-thumb { background: linear-gradient(180deg, rgba(108,60,225,0.3), rgba(34,211,238,0.2)); border-radius: 4px; }
        ::-webkit-scrollbar-thumb:hover { background: linear-gradient(180deg, rgba(108,60,225,0.6), rgba(34,211,238,0.4)); }
        * { scrollbar-width: thin; scrollbar-color: rgba(108,60,225,0.3) transparent; }

        .gradient-text { background: linear-gradient(135deg, #6C3CE1, #22D3EE); -webkit-background-clip: text; -webkit-text-fill-color: transparent; }
        .gradient-bg { background: linear-gradient(135deg, #6C3CE1, #22D3EE); }
        .dark .glass { background: rgba(30,41,59,0.5); backdrop-filter: blur(20px); border: 1px solid rgba(255,255,255,0.06); }
        .glass { background: rgba(255,255,255,0.7); backdrop-filter: blur(20px); border: 1px solid rgba(0,0,0,0.06); }
        .dark .glass-hover:hover { background: rgba(30,41,59,0.8); border-color: rgba(108,60,225,0.3); transform: translateY(-4px); }
        .glass-hover:hover { background: rgba(255,255,255,0.9); border-color: rgba(108,60,225,0.3); transform: translateY(-4px); box-shadow: 0 10px 40px rgba(108,60,225,0.1); }
        .glow { box-shadow: 0 0 40px rgba(108,60,225,0.2); }
        .hero-gradient { background: radial-gradient(ellipse 80% 50% at 50% -20%, rgba(108,60,225,0.25), transparent), radial-gradient(ellipse 60% 40% at 80% 50%, rgba(34,211,238,0.1), transparent); }
        .float { animation: float 6s ease-in-out infinite; }
        .float-delay { animation: float 6s ease-in-out infinite; animation-delay: -3s; }
        @keyframes float { 0%, 100% { transform: translateY(0); } 50% { transform: translateY(-15px); } }
        .fade-up { opacity: 0; transform: translateY(30px); transition: all 0.8s cubic-bezier(0.16, 1, 0.3, 1); }
        .fade-up.visible { opacity: 1; transform: translateY(0); }
        .pulse-ring { animation: pulseRing 3s ease-in-out infinite; }
        @keyframes pulseRing { 0%, 100% { box-shadow: 0 0 0 0 rgba(108,60,225,0.3); } 50% { box-shadow: 0 0 0 15px rgba(108,60,225,0); } }
        .shine { position: relative; overflow: hidden; }
        .shine::after { content: ''; position: absolute; top: -50%; left: -50%; width: 200%; height: 200%; background: linear-gradient(transparent, rgba(255,255,255,0.03), transparent); transform: rotate(45deg); animation: shine 4s ease-in-out infinite; }
        @keyframes shine { 0%, 100% { transform: translateX(-100%) rotate(45deg); } 50% { transform: translateX(100%) rotate(45deg); } }
        .dark .grid-bg { background-image: radial-gradient(rgba(255,255,255,0.03) 1px, transparent 1px); background-size: 40px 40px; }
        .grid-bg { background-image: radial-gradient(rgba(0,0,0,0.04) 1px, transparent 1px); background-size: 40px 40px; }
        .btn-primary { background: linear-gradient(135deg, #6C3CE1, #5a1fd4); transition: all 0.3s; color: white; }
        .btn-primary:hover { box-shadow: 0 10px 40px rgba(108,60,225,0.4); transform: translateY(-2px); }
        .dark .btn-outline { border: 1px solid rgba(255,255,255,0.15); color: white; transition: all 0.3s; }
        .btn-outline { border: 1px solid rgba(0,0,0,0.15); color: #1E293B; transition: all 0.3s; }
        .btn-outline:hover { border-color: #6C3CE1; background: rgba(108,60,225,0.1); }
        .nav-blur { backdrop-filter: blur(20px); }
        .feature-icon { background: linear-gradient(135deg, rgba(108,60,225,0.2), rgba(34,211,238,0.1)); }
        .pricing-popular { border: 2px solid #6C3CE1; }
        .pricing-popular::before { content: 'Populaire'; position: absolute; top: -12px; left: 50%; transform: translateX(-50%); background: linear-gradient(135deg, #6C3CE1, #22D3EE); padding: 4px 16px; border-radius: 20px; font-size: 0.75rem; font-weight: 600; color: white; }
        .input-landing { width: 100%; padding: 0.75rem 1rem; border-radius: 0.75rem; outline: none; transition: all 0.3s; font-size: 0.875rem; }
        .dark .input-landing { background: rgba(255,255,255,0.05); border: 1px solid rgba(255,255,255,0.1); color: white; }
        .input-landing { background: white; border: 1px solid rgba(0,0,0,0.1); color: #1E293B; }
        .input-landing:focus { border-color: #6C3CE1; box-shadow: 0 0 0 3px rgba(108,60,225,0.15); }
        .input-landing::placeholder { color: #94a3b8; }
        .dark .text-body { color: #e2e8f0; }
        .text-body { color: #1E293B; }
        .dark .text-muted { color: #94a3b8; }
        .text-muted { color: #64748b; }
        .dark .text-heading { color: white; }
        .text-heading { color: #0F172A; }
        .dark .border-subtle { border-color: rgba(255,255,255,0.05); }
        .border-subtle { border-color: rgba(0,0,0,0.05); }
    </style>
    <script defer src="https://cdn.jsdelivr.net/npm/alpinejs@3.x.x/dist/cdn.min.js"></script>
<?= SEO::renderStructuredData() ?>
</head>
<body>

<!-- ═══════════════════════════════════════════════════ -->
<!-- NAVIGATION -->
<!-- ═══════════════════════════════════════════════════ -->
<nav @scroll.window="scrolled = window.scrollY > 50"
     :class="scrolled ? (darkMode ? 'bg-surface-dark/90' : 'bg-white/90') + ' nav-blur shadow-xl shadow-black/5' : 'bg-transparent'"
     class="fixed top-0 inset-x-0 z-50 transition-all duration-500">
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
        <div class="flex items-center justify-between h-16 lg:h-20">
            <a href="<?= url('/') ?>" class="flex items-center gap-3 group">
                <div class="w-10 h-10 rounded-xl gradient-bg flex items-center justify-center transition-transform group-hover:scale-110">
                    <i class="fas fa-bolt text-white text-lg"></i>
                </div>
                <span class="text-xl font-bold gradient-text hidden sm:block"><?= e($appName) ?></span>
            </a>

            <div class="hidden md:flex items-center gap-8">
                <a href="#features" class="text-sm text-muted hover:text-heading transition-colors" x-text="t.features"></a>
                <a href="#how-it-works" class="text-sm text-muted hover:text-heading transition-colors" x-text="t.howItWorks"></a>
                <a href="#pricing" class="text-sm text-muted hover:text-heading transition-colors" x-text="t.pricing"></a>
                <a href="#contact" class="text-sm text-muted hover:text-heading transition-colors" x-text="t.contact"></a>
            </div>

            <div class="hidden md:flex items-center gap-3">
                <!-- Language switcher -->
                <div class="relative" x-data="{ langOpen: false }" @click.outside="langOpen = false">
                    <button @click="langOpen = !langOpen" class="w-9 h-9 rounded-xl bg-white/10 dark:bg-white/5 border border-black/10 dark:border-white/10 flex items-center justify-center text-muted hover:text-heading transition-all text-xs font-bold uppercase" x-text="locale"></button>
                    <div x-show="langOpen" x-transition class="absolute right-0 mt-2 w-32 p-1 glass rounded-xl shadow-lg">
                        <a href="<?= url('/lang/fr') ?>" class="flex items-center gap-2 px-3 py-2 text-sm rounded-lg hover:bg-primary-500/10 text-muted hover:text-heading">🇫🇷 Français</a>
                        <a href="<?= url('/lang/en') ?>" class="flex items-center gap-2 px-3 py-2 text-sm rounded-lg hover:bg-primary-500/10 text-muted hover:text-heading">🇬🇧 English</a>
                    </div>
                </div>
                <!-- Dark mode toggle -->
                <button @click="toggleDark()" class="w-9 h-9 rounded-xl bg-white/10 dark:bg-white/5 border border-black/10 dark:border-white/10 flex items-center justify-center text-muted hover:text-heading transition-all">
                    <i :class="darkMode ? 'fas fa-sun text-amber-400' : 'fas fa-moon'"></i>
                </button>
                <a href="<?= url('/login') ?>" class="btn-outline px-5 py-2.5 rounded-xl text-sm font-medium" x-text="t.signIn"></a>
                <a href="<?= url('/register') ?>" class="btn-primary px-5 py-2.5 rounded-xl text-sm font-semibold" x-text="t.getStarted"></a>
            </div>

            <div class="flex items-center gap-2 md:hidden">
                <button @click="toggleDark()" class="w-9 h-9 rounded-xl bg-white/10 dark:bg-white/5 flex items-center justify-center text-muted"><i :class="darkMode ? 'fas fa-sun text-amber-400' : 'fas fa-moon'"></i></button>
                <button @click="mobileMenu = !mobileMenu" class="text-heading p-2"><i :class="mobileMenu ? 'fas fa-times' : 'fas fa-bars'" class="text-xl"></i></button>
            </div>
        </div>

        <div x-show="mobileMenu" x-transition class="md:hidden pb-6 space-y-2">
            <a href="#features" @click="mobileMenu=false" class="block py-2 text-muted hover:text-heading" x-text="t.features"></a>
            <a href="#how-it-works" @click="mobileMenu=false" class="block py-2 text-muted hover:text-heading" x-text="t.howItWorks"></a>
            <a href="#pricing" @click="mobileMenu=false" class="block py-2 text-muted hover:text-heading" x-text="t.pricing"></a>
            <a href="#contact" @click="mobileMenu=false" class="block py-2 text-muted hover:text-heading" x-text="t.contact"></a>
            <div class="pt-4 flex flex-col gap-2">
                <div class="flex gap-2">
                    <a href="<?= url('/lang/fr') ?>" class="flex-1 text-center py-2 rounded-lg text-sm btn-outline">🇫🇷 FR</a>
                    <a href="<?= url('/lang/en') ?>" class="flex-1 text-center py-2 rounded-lg text-sm btn-outline">🇬🇧 EN</a>
                </div>
                <a href="<?= url('/login') ?>" class="btn-outline px-5 py-2.5 rounded-xl text-sm font-medium text-center" x-text="t.signIn"></a>
                <a href="<?= url('/register') ?>" class="btn-primary px-5 py-2.5 rounded-xl text-sm font-semibold text-center" x-text="t.getStarted"></a>
            </div>
        </div>
    </div>
</nav>


<!-- ═══════════════════════════════════════════════════ -->
<!-- 1. HERO SECTION -->
<!-- ═══════════════════════════════════════════════════ -->
<section class="hero-gradient relative min-h-screen flex items-center pt-20 grid-bg">
    <div class="absolute top-20 left-10 w-72 h-72 bg-primary-500/10 rounded-full blur-3xl float"></div>
    <div class="absolute bottom-20 right-10 w-96 h-96 bg-accent-400/5 rounded-full blur-3xl float-delay"></div>
    
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-20 lg:py-32">
        <div class="grid lg:grid-cols-2 gap-12 lg:gap-20 items-center">
            <div class="fade-up">
                <div class="inline-flex items-center gap-2 bg-primary-500/10 border border-primary-500/20 rounded-full px-4 py-1.5 mb-6">
                    <span class="w-2 h-2 bg-emerald-400 rounded-full animate-pulse"></span>
                    <span class="text-xs font-medium text-primary-400" x-text="t.badge"></span>
                </div>

                <h1 class="text-4xl sm:text-5xl lg:text-6xl font-extrabold leading-tight mb-6 text-heading">
                    <span x-text="t.heroTitle1"></span>
                    <span class="gradient-text block" x-text="t.heroTitle2"></span>
                </h1>

                <p class="text-lg text-muted max-w-xl mb-8 leading-relaxed" x-html="t.heroDesc"></p>

                <div class="flex flex-col sm:flex-row gap-4 mb-10">
                    <a href="<?= url('/register') ?>" class="btn-primary px-8 py-4 rounded-2xl text-base font-semibold flex items-center justify-center gap-2 pulse-ring">
                        <i class="fas fa-rocket"></i> <span x-text="t.getStartedFree"></span>
                    </a>
                    <a href="#features" class="btn-outline px-8 py-4 rounded-2xl text-base font-medium flex items-center justify-center gap-2">
                        <i class="fas fa-play-circle"></i> <span x-text="t.discover"></span>
                    </a>
                </div>

                <div class="flex items-center gap-8 sm:gap-12">
                    <div><div class="text-2xl font-bold text-heading">7+</div><div class="text-xs text-muted" x-text="t.modules"></div></div>
                    <div class="w-px h-10 border-subtle border-r"></div>
                    <div><div class="text-2xl font-bold text-heading">100%</div><div class="text-xs text-muted" x-text="t.free"></div></div>
                    <div class="w-px h-10 border-subtle border-r"></div>
                    <div><div class="text-2xl font-bold text-heading">∞</div><div class="text-xs text-muted" x-text="t.possibilities"></div></div>
                </div>
            </div>

            <div class="fade-up relative hidden lg:block">
                <div class="relative glass rounded-2xl p-1 glow shine">
                    <div class="dark:bg-surface-dark bg-white rounded-xl overflow-hidden">
                        <div class="flex items-center gap-2 px-4 py-3 border-b border-subtle">
                            <div class="flex gap-1.5">
                                <div class="w-3 h-3 rounded-full bg-red-500/80"></div>
                                <div class="w-3 h-3 rounded-full bg-yellow-500/80"></div>
                                <div class="w-3 h-3 rounded-full bg-green-500/80"></div>
                            </div>
                            <div class="flex-1 text-center"><div class="inline-block bg-black/5 dark:bg-white/5 rounded-lg px-4 py-1 text-xs text-muted">nexus.tsilizy.com/dashboard</div></div>
                        </div>
                        <div class="p-6 space-y-4">
                            <div class="flex items-center justify-between">
                                <div><div class="text-lg font-bold text-heading">Bonjour, Admin 👋</div><div class="text-xs text-muted" x-text="new Date().toLocaleDateString(locale, {weekday:'long',day:'numeric',month:'long',year:'numeric'})"></div></div>
                            </div>
                            <div class="grid grid-cols-4 gap-3">
                                <div class="bg-black/5 dark:bg-white/5 rounded-xl p-3 text-center"><div class="text-xl font-bold text-primary-400">12</div><div class="text-[10px] text-muted">Tâches</div></div>
                                <div class="bg-black/5 dark:bg-white/5 rounded-xl p-3 text-center"><div class="text-xl font-bold text-accent-400">5</div><div class="text-[10px] text-muted">Projets</div></div>
                                <div class="bg-black/5 dark:bg-white/5 rounded-xl p-3 text-center"><div class="text-xl font-bold text-emerald-400">28</div><div class="text-[10px] text-muted">Contacts</div></div>
                                <div class="bg-black/5 dark:bg-white/5 rounded-xl p-3 text-center"><div class="text-xl font-bold text-amber-400">3</div><div class="text-[10px] text-muted">Événements</div></div>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="absolute -top-4 -right-4 glass rounded-xl p-3 float text-xs">
                    <div class="flex items-center gap-2"><div class="w-6 h-6 rounded-full gradient-bg flex items-center justify-center"><i class="fas fa-chart-line text-white" style="font-size:10px"></i></div><div><div class="text-heading font-semibold">+42%</div><div class="text-muted text-[10px]">Productivité</div></div></div>
                </div>
                <div class="absolute -bottom-4 -left-4 glass rounded-xl p-3 float-delay text-xs">
                    <div class="flex items-center gap-2"><div class="w-6 h-6 rounded-full bg-emerald-500/20 flex items-center justify-center"><i class="fas fa-check text-emerald-400" style="font-size:10px"></i></div><div><div class="text-heading font-semibold">6 tâches</div><div class="text-muted text-[10px]">Terminées</div></div></div>
                </div>
            </div>
        </div>
    </div>
</section>


<!-- ═══════════════════════════════════════════════════ -->
<!-- 2. FEATURES SECTION -->
<!-- ═══════════════════════════════════════════════════ -->
<section id="features" class="py-24 lg:py-32 relative">
    <div class="absolute inset-0 hero-gradient opacity-30"></div>
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 relative">
        <div class="text-center mb-16 fade-up">
            <span class="text-primary-400 text-sm font-semibold uppercase tracking-wider" x-text="t.features"></span>
            <h2 class="text-3xl lg:text-4xl font-bold text-heading mt-3 mb-4" x-html="t.featuresTitle"></h2>
            <p class="text-muted max-w-2xl mx-auto" x-text="t.featuresDesc"></p>
        </div>

        <div class="grid sm:grid-cols-2 lg:grid-cols-3 gap-6">
            <template x-for="(f, i) in featureList" :key="i">
                <div class="glass rounded-2xl p-6 glass-hover transition-all duration-500 fade-up group" :style="'transition-delay:' + (i*0.1) + 's'">
                    <div class="feature-icon w-12 h-12 rounded-xl flex items-center justify-center mb-4 group-hover:scale-110 transition-transform">
                        <i :class="f.icon + ' text-lg'" :style="'color:' + f.color"></i>
                    </div>
                    <h3 class="text-lg font-semibold text-heading mb-2" x-text="f.title"></h3>
                    <p class="text-sm text-muted leading-relaxed" x-text="f.desc"></p>
                </div>
            </template>
        </div>
    </div>
</section>


<!-- ═══════════════════════════════════════════════════ -->
<!-- 3. HOW IT WORKS -->
<!-- ═══════════════════════════════════════════════════ -->
<section id="how-it-works" class="py-24 lg:py-32 relative grid-bg">
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
        <div class="text-center mb-16 fade-up">
            <span class="text-accent-400 text-sm font-semibold uppercase tracking-wider" x-text="t.howItWorks"></span>
            <h2 class="text-3xl lg:text-4xl font-bold text-heading mt-3 mb-4" x-html="t.stepsTitle"></h2>
            <p class="text-muted max-w-xl mx-auto" x-text="t.stepsDesc"></p>
        </div>

        <div class="grid md:grid-cols-3 gap-8 lg:gap-12 relative">
            <div class="hidden md:block absolute top-16 left-1/6 right-1/6 h-0.5 bg-gradient-to-r from-primary-500 via-accent-400 to-emerald-400 opacity-20"></div>
            <template x-for="(step, i) in steps" :key="i">
                <div class="text-center fade-up relative" :style="'transition-delay:' + (i*0.15) + 's'">
                    <div class="w-14 h-14 rounded-2xl flex items-center justify-center mx-auto mb-6 font-bold text-xl relative z-10" :class="step.cls" x-text="i+1"></div>
                    <h3 class="text-lg font-semibold text-heading mb-3" x-text="step.title"></h3>
                    <p class="text-sm text-muted leading-relaxed" x-text="step.desc"></p>
                </div>
            </template>
        </div>
    </div>
</section>


<!-- ═══════════════════════════════════════════════════ -->
<!-- 4. PRICING -->
<!-- ═══════════════════════════════════════════════════ -->
<section id="pricing" class="py-24 lg:py-32 relative grid-bg">
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
        <div class="text-center mb-16 fade-up">
            <span class="text-emerald-400 text-sm font-semibold uppercase tracking-wider" x-text="t.pricing"></span>
            <h2 class="text-3xl lg:text-4xl font-bold text-heading mt-3 mb-4" x-html="t.pricingTitle"></h2>
            <p class="text-muted max-w-xl mx-auto" x-text="t.pricingDesc"></p>
        </div>

        <div class="grid md:grid-cols-2 gap-8 max-w-3xl mx-auto">
            <div class="glass rounded-2xl p-8 fade-up relative group glass-hover transition-all duration-500">
                <h3 class="text-xl font-bold text-heading mb-2" x-text="t.planFree"></h3>
                <p class="text-muted text-sm mb-6" x-text="t.planFreeDesc"></p>
                <div class="flex items-baseline gap-1 mb-8">
                    <span class="text-4xl font-extrabold text-heading">0€</span>
                    <span class="text-muted text-sm" x-text="t.planFreePrice"></span>
                </div>
                <ul class="space-y-3 mb-8">
                    <template x-for="f in planFreeFeatures"><li class="flex items-center gap-3 text-sm text-muted"><i class="fas fa-check text-emerald-400 text-xs"></i><span x-text="f"></span></li></template>
                </ul>
                <a href="<?= url('/register') ?>" class="block text-center btn-outline px-6 py-3 rounded-xl text-sm font-semibold" x-text="t.getStartedFree"></a>
            </div>

            <div class="glass rounded-2xl p-8 fade-up relative pricing-popular group glass-hover transition-all duration-500" style="transition-delay:0.15s">
                <h3 class="text-xl font-bold text-heading mb-2" x-text="t.planPro"></h3>
                <p class="text-muted text-sm mb-6" x-text="t.planProDesc"></p>
                <div class="flex items-baseline gap-1 mb-8">
                    <span class="text-4xl font-extrabold gradient-text" x-text="t.planProPrice"></span>
                    <span class="text-muted text-sm" x-text="t.planProPriceLabel"></span>
                </div>
                <ul class="space-y-3 mb-8">
                    <template x-for="f in planProFeatures"><li class="flex items-center gap-3 text-sm text-muted"><i class="fas fa-infinity text-primary-400 text-xs"></i><span x-text="f"></span></li></template>
                </ul>
                <a href="<?= url('/register') ?>" class="block text-center btn-primary px-6 py-3 rounded-xl text-sm font-semibold">
                    <i class="fas fa-heart mr-1"></i> <span x-text="t.contribute"></span>
                </a>
            </div>
        </div>
    </div>
</section>


<!-- ═══════════════════════════════════════════════════ -->
<!-- 5. CONTACT FORM -->
<!-- ═══════════════════════════════════════════════════ -->
<section id="contact" class="py-24 lg:py-32 relative">
    <div class="absolute inset-0 hero-gradient opacity-20"></div>
    <div class="max-w-4xl mx-auto px-4 sm:px-6 lg:px-8 relative">
        <div class="text-center mb-12 fade-up">
            <span class="text-primary-400 text-sm font-semibold uppercase tracking-wider" x-text="t.contact"></span>
            <h2 class="text-3xl lg:text-4xl font-bold text-heading mt-3 mb-4" x-html="t.contactTitle"></h2>
            <p class="text-muted max-w-xl mx-auto" x-text="t.contactDesc"></p>
        </div>

        <?php if (!empty($_SESSION['flash_success'])): ?>
        <div class="mb-6 p-4 rounded-xl bg-emerald-500/10 border border-emerald-500/20 text-emerald-400 text-sm text-center"><?= e($_SESSION['flash_success']); unset($_SESSION['flash_success']); ?></div>
        <?php endif; ?>
        <?php if (!empty($_SESSION['flash_error'])): ?>
        <div class="mb-6 p-4 rounded-xl bg-red-500/10 border border-red-500/20 text-red-400 text-sm text-center"><?= e($_SESSION['flash_error']); unset($_SESSION['flash_error']); ?></div>
        <?php endif; ?>

        <form method="POST" action="<?= url('/contact') ?>" class="glass rounded-2xl p-8 fade-up space-y-5">
            <div class="grid sm:grid-cols-2 gap-5">
                <div>
                    <label class="block text-sm text-muted mb-1.5" x-text="t.contactName"></label>
                    <input type="text" name="name" class="input-landing" required>
                </div>
                <div>
                    <label class="block text-sm text-muted mb-1.5" x-text="t.contactEmail"></label>
                    <input type="email" name="email" class="input-landing" required>
                </div>
            </div>
            <div>
                <label class="block text-sm text-muted mb-1.5" x-text="t.contactSubject"></label>
                <input type="text" name="subject" class="input-landing">
            </div>
            <div>
                <label class="block text-sm text-muted mb-1.5" x-text="t.contactMessage"></label>
                <textarea name="message" rows="5" class="input-landing resize-none" required></textarea>
            </div>
            <div class="text-center pt-2">
                <button type="submit" class="btn-primary px-10 py-3.5 rounded-xl text-sm font-semibold inline-flex items-center gap-2">
                    <i class="fas fa-paper-plane"></i> <span x-text="t.contactSend"></span>
                </button>
            </div>
        </form>
    </div>
</section>


<!-- ═══════════════════════════════════════════════════ -->
<!-- 6. CTA + NEWSLETTER -->
<!-- ═══════════════════════════════════════════════════ -->
<section id="newsletter" class="py-24 lg:py-32 relative overflow-hidden">
    <div class="absolute inset-0 gradient-bg opacity-10"></div>
    <div class="absolute -top-40 -right-40 w-80 h-80 bg-primary-500/20 rounded-full blur-3xl"></div>
    <div class="absolute -bottom-40 -left-40 w-80 h-80 bg-accent-400/10 rounded-full blur-3xl"></div>
    
    <div class="max-w-4xl mx-auto px-4 sm:px-6 lg:px-8 text-center relative fade-up">
        <h2 class="text-3xl lg:text-5xl font-extrabold text-heading mb-6" x-html="t.ctaTitle"></h2>
        <p class="text-lg text-muted mb-10 max-w-2xl mx-auto" x-text="t.ctaDesc"></p>
        <div class="flex flex-col sm:flex-row gap-4 justify-center mb-12">
            <a href="<?= url('/register') ?>" class="btn-primary px-10 py-4 rounded-2xl text-lg font-bold inline-flex items-center justify-center gap-2">
                <i class="fas fa-rocket"></i> <span x-text="t.ctaBtn"></span>
            </a>
            <a href="<?= url('/login') ?>" class="btn-outline px-10 py-4 rounded-2xl text-lg font-medium inline-flex items-center justify-center gap-2">
                <i class="fas fa-sign-in-alt"></i> <span x-text="t.signIn"></span>
            </a>
        </div>

        <!-- Newsletter -->
        <div class="glass rounded-2xl p-8 max-w-lg mx-auto">
            <h3 class="text-lg font-semibold text-heading mb-2" x-text="t.newsletterTitle"></h3>
            <p class="text-sm text-muted mb-4" x-text="t.newsletterDesc"></p>
            <form method="POST" action="<?= url('/newsletter/subscribe') ?>" class="flex gap-2">
                <input type="email" name="email" class="input-landing flex-1" placeholder="email@example.com" required>
                <button type="submit" class="btn-primary px-5 py-3 rounded-xl text-sm font-semibold whitespace-nowrap" x-text="t.newsletterBtn"></button>
            </form>
        </div>
    </div>
</section>


<!-- ═══════════════════════════════════════════════════ -->
<!-- 7. FOOTER -->
<!-- ═══════════════════════════════════════════════════ -->
<footer class="border-t border-subtle py-16 relative">
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
        <div class="grid sm:grid-cols-2 lg:grid-cols-4 gap-10 mb-12">
            <div>
                <div class="flex items-center gap-3 mb-4">
                    <div class="w-10 h-10 rounded-xl gradient-bg flex items-center justify-center"><i class="fas fa-bolt text-white text-lg"></i></div>
                    <span class="text-xl font-bold gradient-text"><?= e($appName) ?></span>
                </div>
                <p class="text-sm text-muted leading-relaxed mb-4" x-text="t.footerDesc"></p>
                <div class="flex gap-3">
                    <a href="#" class="w-9 h-9 rounded-lg bg-black/5 dark:bg-white/5 flex items-center justify-center text-muted hover:text-primary-400 transition-all"><i class="fab fa-facebook-f text-sm"></i></a>
                    <a href="#" class="w-9 h-9 rounded-lg bg-black/5 dark:bg-white/5 flex items-center justify-center text-muted hover:text-accent-400 transition-all"><i class="fab fa-twitter text-sm"></i></a>
                    <a href="#" class="w-9 h-9 rounded-lg bg-black/5 dark:bg-white/5 flex items-center justify-center text-muted hover:text-heading transition-all"><i class="fab fa-github text-sm"></i></a>
                    <a href="#" class="w-9 h-9 rounded-lg bg-black/5 dark:bg-white/5 flex items-center justify-center text-muted hover:text-rose-400 transition-all"><i class="fab fa-instagram text-sm"></i></a>
                </div>
            </div>

            <div>
                <h4 class="text-heading font-semibold mb-4" x-text="t.product"></h4>
                <ul class="space-y-2">
                    <li><a href="#features" class="text-sm text-muted hover:text-heading transition-colors" x-text="t.features"></a></li>
                    <li><a href="#pricing" class="text-sm text-muted hover:text-heading transition-colors" x-text="t.pricing"></a></li>
                    <li><a href="#how-it-works" class="text-sm text-muted hover:text-heading transition-colors" x-text="t.howItWorks"></a></li>
                    <li><a href="<?= url('/register') ?>" class="text-sm text-muted hover:text-heading transition-colors" x-text="t.signUp"></a></li>
                </ul>
            </div>

            <div>
                <h4 class="text-heading font-semibold mb-4" x-text="t.legal"></h4>
                <ul class="space-y-2">
                    <li><a href="<?= url('/terms') ?>" class="text-sm text-muted hover:text-heading transition-colors" x-text="t.terms"></a></li>
                    <li><a href="<?= url('/privacy') ?>" class="text-sm text-muted hover:text-heading transition-colors" x-text="t.privacy"></a></li>
                </ul>
            </div>

            <div>
                <h4 class="text-heading font-semibold mb-4" x-text="t.contact"></h4>
                <ul class="space-y-2">
                    <li class="flex items-center gap-2 text-sm text-muted"><i class="fas fa-envelope text-xs text-primary-400"></i>contact@tsilizy.com</li>
                    <li class="flex items-center gap-2 text-sm text-muted"><i class="fas fa-globe text-xs text-accent-400"></i>tsilizy.com</li>
                </ul>
            </div>
        </div>

        <div class="border-t border-subtle pt-8 flex flex-col sm:flex-row items-center justify-between gap-4">
            <p class="text-xs text-muted">&copy; <?= date('Y') ?> TSILIZY LLC — <span x-text="t.allRights"></span></p>
            <p class="text-xs text-muted"><span x-text="t.madeWith"></span> <i class="fas fa-heart text-rose-500 text-xs"></i> <span x-text="t.byTeam"></span></p>
        </div>
    </div>
</footer>


<!-- ═══════════════════════════════════════════════════ -->
<!-- SCRIPTS -->
<!-- ═══════════════════════════════════════════════════ -->
<script>
function landingApp() {
    const locale = '<?= get_locale() ?>';
    const translations = {
        fr: {
            features: 'Fonctionnalités', howItWorks: 'Comment ça marche', pricing: 'Tarifs', contact: 'Contact',
            signIn: 'Se connecter', signUp: 'Inscription', getStarted: 'Commencer', getStartedFree: 'Commencer gratuitement',
            badge: 'Nouveau — Plateforme v1.0',
            heroTitle1: 'Votre espace de travail', heroTitle2: 'tout-en-un',
            heroDesc: 'Gérez vos tâches, projets, contacts et bien plus dans une seule plateforme élégante. Conçu pour les équipes ambitieuses qui veulent <strong class="text-heading">booster leur productivité</strong>.',
            discover: 'Découvrir', modules: 'Modules intégrés', free: 'Gratuit', possibilities: 'Possibilités',
            featuresTitle: 'Tout ce dont vous avez besoin,<br><span class="gradient-text">en un seul endroit</span>',
            featuresDesc: 'Chaque module est conçu pour s\'intégrer parfaitement avec les autres, créant un écosystème de productivité fluide.',
            stepsTitle: 'Productif en <span class="gradient-text">3 étapes</span>',
            stepsDesc: 'Commencez en quelques secondes. Pas de carte requise.',
            pricingTitle: 'Simple et <span class="gradient-text">transparent</span>',
            pricingDesc: 'Commencez gratuitement. Contribuez si vous aimez le projet.',
            planFree: 'Gratuit', planFreeDesc: 'Parfait pour commencer', planFreePrice: '/ pour toujours',
            planPro: 'Contribution', planProDesc: 'Soutenez le projet', planProPrice: 'Libre', planProPriceLabel: '/ don unique',
            contribute: 'Contribuer',
            contactTitle: 'Une question ? <span class="gradient-text">Écrivez-nous</span>',
            contactDesc: 'Notre équipe vous répondra dans les plus brefs délais.',
            contactName: 'Votre nom', contactEmail: 'Votre email', contactSubject: 'Sujet', contactMessage: 'Message', contactSend: 'Envoyer le message',
            ctaTitle: 'Prêt à transformer votre<br><span class="gradient-text">façon de travailler ?</span>',
            ctaDesc: 'Rejoignez les professionnels qui ont déjà choisi TSILIZY Nexus.',
            ctaBtn: 'Créer mon compte gratuit',
            newsletterTitle: 'Restez informé', newsletterDesc: 'Recevez les dernières nouvelles et astuces.', newsletterBtn: 'S\'abonner',
            footerDesc: 'La plateforme de productivité tout-en-un pour les équipes modernes.',
            product: 'Produit', legal: 'Légal', terms: 'Conditions d\'utilisation', privacy: 'Politique de confidentialité',
            allRights: 'Tous droits réservés', madeWith: 'Fait avec', byTeam: 'par l\'équipe TSILIZY',
            f1: 'Gestion de tâches', f1d: 'Kanban, listes, priorités, labels et dates d\'échéance.',
            f2: 'Notes intelligentes', f2d: 'Éditeur riche, auto-sauvegarde, arborescence hiérarchique.',
            f3: 'Agenda & Calendrier', f3d: 'Vue calendrier interactive, événements, rappels.',
            f4: 'Projets & Jalons', f4d: 'Suivez l\'avancement avec barres de progression et jalons.',
            f5: 'CRM & Contacts', f5d: 'Tags, historique d\'interactions, export CSV, recherche.',
            f6: 'Sites web', f6d: 'Centralisez vos sites : suivi SSL, domaines, statuts.',
            s1: 'Créez votre compte', s1d: 'Inscription gratuite en 30 secondes.',
            s2: 'Organisez votre travail', s2d: 'Ajoutez vos tâches, projets, contacts.',
            s3: 'Boostez votre productivité', s3d: 'Suivez vos progrès et atteignez vos objectifs.',
            pf1: '50 tâches', pf2: '5 projets', pf3: '100 contacts', pf4: '50 notes', pf5: 'Agenda complet', pf6: 'Gestion de sites web',
            pp1: 'Tâches illimitées', pp2: 'Projets illimités', pp3: 'Contacts illimités', pp4: 'Notes illimitées', pp5: 'Badge contributeur', pp6: 'Soutenez le développement'
        },
        en: {
            features: 'Features', howItWorks: 'How it works', pricing: 'Pricing', contact: 'Contact',
            signIn: 'Sign in', signUp: 'Sign up', getStarted: 'Get started', getStartedFree: 'Start for free',
            badge: 'New — Platform v1.0',
            heroTitle1: 'Your workspace', heroTitle2: 'all-in-one',
            heroDesc: 'Manage your tasks, projects, contacts and more in one elegant platform. Built for ambitious teams who want to <strong class="text-heading">boost productivity</strong>.',
            discover: 'Discover', modules: 'Integrated modules', free: 'Free', possibilities: 'Possibilities',
            featuresTitle: 'Everything you need,<br><span class="gradient-text">in one place</span>',
            featuresDesc: 'Each module is designed to integrate seamlessly with the others, creating a fluid productivity ecosystem.',
            stepsTitle: 'Productive in <span class="gradient-text">3 steps</span>',
            stepsDesc: 'Get started in seconds. No card required.',
            pricingTitle: 'Simple and <span class="gradient-text">transparent</span>',
            pricingDesc: 'Start for free. Contribute if you love the project.',
            planFree: 'Free', planFreeDesc: 'Perfect to get started', planFreePrice: '/ forever',
            planPro: 'Contribution', planProDesc: 'Support the project', planProPrice: 'Custom', planProPriceLabel: '/ one-time donation',
            contribute: 'Contribute',
            contactTitle: 'Got a question? <span class="gradient-text">Write to us</span>',
            contactDesc: 'Our team will respond as soon as possible.',
            contactName: 'Your name', contactEmail: 'Your email', contactSubject: 'Subject', contactMessage: 'Message', contactSend: 'Send message',
            ctaTitle: 'Ready to transform your<br><span class="gradient-text">way of working?</span>',
            ctaDesc: 'Join the professionals who already chose TSILIZY Nexus.',
            ctaBtn: 'Create my free account',
            newsletterTitle: 'Stay informed', newsletterDesc: 'Get updates on new features and tips.', newsletterBtn: 'Subscribe',
            footerDesc: 'The all-in-one productivity platform for modern teams.',
            product: 'Product', legal: 'Legal', terms: 'Terms of service', privacy: 'Privacy policy',
            allRights: 'All rights reserved', madeWith: 'Made with', byTeam: 'by team TSILIZY',
            f1: 'Task management', f1d: 'Kanban, lists, priorities, labels and due dates.',
            f2: 'Smart notes', f2d: 'Rich editor, auto-save, hierarchical tree.',
            f3: 'Agenda & Calendar', f3d: 'Interactive calendar view, events, reminders.',
            f4: 'Projects & Milestones', f4d: 'Track progress with progress bars and milestones.',
            f5: 'CRM & Contacts', f5d: 'Tags, interaction history, CSV export, search.',
            f6: 'Websites', f6d: 'Centralize your sites: SSL tracking, domains, status.',
            s1: 'Create your account', s1d: 'Free signup in 30 seconds.',
            s2: 'Organize your work', s2d: 'Add your tasks, projects, contacts.',
            s3: 'Boost your productivity', s3d: 'Track your progress and reach your goals.',
            pf1: '50 tasks', pf2: '5 projects', pf3: '100 contacts', pf4: '50 notes', pf5: 'Full agenda', pf6: 'Website management',
            pp1: 'Unlimited tasks', pp2: 'Unlimited projects', pp3: 'Unlimited contacts', pp4: 'Unlimited notes', pp5: 'Contributor badge', pp6: 'Support development'
        }
    };
    const t = translations[locale] || translations['fr'];

    return {
        locale, t, scrolled: false, mobileMenu: false,
        darkMode: localStorage.getItem('landingDarkMode') !== 'false',
        toggleDark() { this.darkMode = !this.darkMode; localStorage.setItem('landingDarkMode', this.darkMode); },
        get featureList() {
            return [
                { icon: 'fas fa-tasks', color: '#9166ff', title: t.f1, desc: t.f1d },
                { icon: 'fas fa-sticky-note', color: '#22D3EE', title: t.f2, desc: t.f2d },
                { icon: 'fas fa-calendar-alt', color: '#10B981', title: t.f3, desc: t.f3d },
                { icon: 'fas fa-project-diagram', color: '#F59E0B', title: t.f4, desc: t.f4d },
                { icon: 'fas fa-address-book', color: '#F43F5E', title: t.f5, desc: t.f5d },
                { icon: 'fas fa-globe', color: '#06b6d4', title: t.f6, desc: t.f6d },
            ];
        },
        get steps() {
            return [
                { title: t.s1, desc: t.s1d, cls: 'gradient-bg text-white glow' },
                { title: t.s2, desc: t.s2d, cls: 'bg-accent-400/20 border border-accent-400/30 text-accent-400' },
                { title: t.s3, desc: t.s3d, cls: 'bg-emerald-500/20 border border-emerald-500/30 text-emerald-400' }
            ];
        },
        get planFreeFeatures() { return [t.pf1, t.pf2, t.pf3, t.pf4, t.pf5, t.pf6]; },
        get planProFeatures() { return [t.pp1, t.pp2, t.pp3, t.pp4, t.pp5, t.pp6]; }
    }
}

// Scroll animations
const observer = new IntersectionObserver((entries) => {
    entries.forEach(entry => { if (entry.isIntersecting) entry.target.classList.add('visible'); });
}, { threshold: 0.1, rootMargin: '0px 0px -50px 0px' });
document.querySelectorAll('.fade-up').forEach(el => observer.observe(el));

// Smooth scroll
document.querySelectorAll('a[href^="#"]').forEach(anchor => {
    anchor.addEventListener('click', function(e) {
        e.preventDefault();
        const target = document.querySelector(this.getAttribute('href'));
        if (target) target.scrollIntoView({ behavior: 'smooth', block: 'start' });
    });
});

// Service worker
if ('serviceWorker' in navigator) {
    navigator.serviceWorker.register('<?= url('/public/sw.js') ?>').catch(() => {});
}
</script>

</body>
</html>
