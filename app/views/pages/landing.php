<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title><?= e($appName) ?> — <?= e($pageTitle) ?></title>
    <meta name="description" content="TSILIZY Nexus — La plateforme de productivité tout-en-un pour votre entreprise. Gérez tâches, projets, contacts et plus.">
    <meta name="theme-color" content="#0F172A">
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
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/animate.css/4.1.1/animate.min.css">
    <style>
        * { margin: 0; padding: 0; box-sizing: border-box; }
        body { font-family: 'Inter', system-ui, sans-serif; background: #0F172A; color: #e2e8f0; overflow-x: hidden; }
        .gradient-text { background: linear-gradient(135deg, #6C3CE1, #22D3EE); -webkit-background-clip: text; -webkit-text-fill-color: transparent; }
        .gradient-bg { background: linear-gradient(135deg, #6C3CE1, #22D3EE); }
        .gradient-border { border: 2px solid transparent; background-clip: padding-box; position: relative; }
        .gradient-border::before { content: ''; position: absolute; inset: -2px; border-radius: inherit; background: linear-gradient(135deg, #6C3CE1, #22D3EE); z-index: -1; }
        .glass { background: rgba(30,41,59,0.5); backdrop-filter: blur(20px); -webkit-backdrop-filter: blur(20px); border: 1px solid rgba(255,255,255,0.06); }
        .glass-hover:hover { background: rgba(30,41,59,0.8); border-color: rgba(108,60,225,0.3); transform: translateY(-4px); }
        .glow { box-shadow: 0 0 40px rgba(108,60,225,0.2); }
        .glow-accent { box-shadow: 0 0 40px rgba(34,211,238,0.15); }
        .hero-gradient { 
            background: radial-gradient(ellipse 80% 50% at 50% -20%, rgba(108,60,225,0.25), transparent),
                        radial-gradient(ellipse 60% 40% at 80% 50%, rgba(34,211,238,0.1), transparent),
                        radial-gradient(ellipse 60% 40% at 20% 80%, rgba(108,60,225,0.1), transparent);
        }
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
        .grid-bg { background-image: radial-gradient(rgba(255,255,255,0.03) 1px, transparent 1px); background-size: 40px 40px; }
        .btn-primary { background: linear-gradient(135deg, #6C3CE1, #5a1fd4); transition: all 0.3s; }
        .btn-primary:hover { box-shadow: 0 10px 40px rgba(108,60,225,0.4); transform: translateY(-2px); }
        .btn-outline { border: 1px solid rgba(255,255,255,0.15); transition: all 0.3s; }
        .btn-outline:hover { border-color: #6C3CE1; background: rgba(108,60,225,0.1); }
        .counter { font-variant-numeric: tabular-nums; }
        .nav-blur { backdrop-filter: blur(20px); -webkit-backdrop-filter: blur(20px); }
        .feature-icon { background: linear-gradient(135deg, rgba(108,60,225,0.2), rgba(34,211,238,0.1)); }
        .step-line { background: linear-gradient(180deg, #6C3CE1, #22D3EE); }
        .testimonial-glow:hover { box-shadow: 0 20px 60px rgba(108,60,225,0.15); }
        .pricing-popular { border: 2px solid #6C3CE1; }
        .pricing-popular::before { content: 'Populaire'; position: absolute; top: -12px; left: 50%; transform: translateX(-50%); background: linear-gradient(135deg, #6C3CE1, #22D3EE); padding: 4px 16px; border-radius: 20px; font-size: 0.75rem; font-weight: 600; color: white; }
    </style>
    <script defer src="https://cdn.jsdelivr.net/npm/alpinejs@3.x.x/dist/cdn.min.js"></script>
</head>
<body class="dark">

<!-- ═══════════════════════════════════════════════════ -->
<!-- NAVIGATION -->
<!-- ═══════════════════════════════════════════════════ -->
<nav x-data="{ open: false, scrolled: false }" 
     @scroll.window="scrolled = window.scrollY > 50"
     :class="scrolled ? 'bg-surface-dark/90 nav-blur shadow-xl shadow-black/10' : 'bg-transparent'"
     class="fixed top-0 inset-x-0 z-50 transition-all duration-500">
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
        <div class="flex items-center justify-between h-16 lg:h-20">
            <!-- Logo -->
            <a href="<?= url('/') ?>" class="flex items-center gap-3 group">
                <div class="w-10 h-10 rounded-xl gradient-bg flex items-center justify-center transition-transform group-hover:scale-110">
                    <i class="fas fa-bolt text-white text-lg"></i>
                </div>
                <span class="text-xl font-bold gradient-text hidden sm:block"><?= e($appName) ?></span>
            </a>

            <!-- Desktop nav -->
            <div class="hidden md:flex items-center gap-8">
                <a href="#features" class="text-sm text-slate-400 hover:text-white transition-colors">Fonctionnalités</a>
                <a href="#how-it-works" class="text-sm text-slate-400 hover:text-white transition-colors">Comment ça marche</a>
                <a href="#pricing" class="text-sm text-slate-400 hover:text-white transition-colors">Tarifs</a>
                <a href="#testimonials" class="text-sm text-slate-400 hover:text-white transition-colors">Témoignages</a>
            </div>

            <!-- CTA buttons -->
            <div class="hidden md:flex items-center gap-3">
                <a href="<?= url('/login') ?>" class="btn-outline px-5 py-2.5 rounded-xl text-sm font-medium text-white">
                    Se connecter
                </a>
                <a href="<?= url('/register') ?>" class="btn-primary px-5 py-2.5 rounded-xl text-sm font-semibold text-white">
                    Commencer gratuitement
                </a>
            </div>

            <!-- Mobile burger -->
            <button @click="open = !open" class="md:hidden text-white p-2">
                <i :class="open ? 'fas fa-times' : 'fas fa-bars'" class="text-xl"></i>
            </button>
        </div>

        <!-- Mobile menu -->
        <div x-show="open" x-transition class="md:hidden pb-6 space-y-2">
            <a href="#features" @click="open=false" class="block py-2 text-slate-300 hover:text-white">Fonctionnalités</a>
            <a href="#how-it-works" @click="open=false" class="block py-2 text-slate-300 hover:text-white">Comment ça marche</a>
            <a href="#pricing" @click="open=false" class="block py-2 text-slate-300 hover:text-white">Tarifs</a>
            <a href="#testimonials" @click="open=false" class="block py-2 text-slate-300 hover:text-white">Témoignages</a>
            <div class="pt-4 flex flex-col gap-2">
                <a href="<?= url('/login') ?>" class="btn-outline px-5 py-2.5 rounded-xl text-sm font-medium text-white text-center">Se connecter</a>
                <a href="<?= url('/register') ?>" class="btn-primary px-5 py-2.5 rounded-xl text-sm font-semibold text-white text-center">Commencer</a>
            </div>
        </div>
    </div>
</nav>


<!-- ═══════════════════════════════════════════════════ -->
<!-- 1. HERO SECTION -->
<!-- ═══════════════════════════════════════════════════ -->
<section class="hero-gradient relative min-h-screen flex items-center pt-20 grid-bg">
    <!-- Floating orbs -->
    <div class="absolute top-20 left-10 w-72 h-72 bg-primary-500/10 rounded-full blur-3xl float"></div>
    <div class="absolute bottom-20 right-10 w-96 h-96 bg-accent-400/5 rounded-full blur-3xl float-delay"></div>
    
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-20 lg:py-32">
        <div class="grid lg:grid-cols-2 gap-12 lg:gap-20 items-center">
            <!-- Left: Text -->
            <div class="fade-up">
                <div class="inline-flex items-center gap-2 bg-primary-500/10 border border-primary-500/20 rounded-full px-4 py-1.5 mb-6">
                    <span class="w-2 h-2 bg-emerald-400 rounded-full animate-pulse"></span>
                    <span class="text-xs font-medium text-primary-300">Nouveau — Plateforme v1.0</span>
                </div>

                <h1 class="text-4xl sm:text-5xl lg:text-6xl font-extrabold leading-tight mb-6">
                    Votre espace de travail
                    <span class="gradient-text block">tout-en-un</span>
                </h1>

                <p class="text-lg text-slate-400 max-w-xl mb-8 leading-relaxed">
                    Gérez vos tâches, projets, contacts et bien plus dans une seule plateforme élégante. 
                    Conçu pour les équipes ambitieuses qui veulent <strong class="text-white">booster leur productivité</strong>.
                </p>

                <div class="flex flex-col sm:flex-row gap-4 mb-10">
                    <a href="<?= url('/register') ?>" class="btn-primary px-8 py-4 rounded-2xl text-base font-semibold text-white flex items-center justify-center gap-2 pulse-ring">
                        <i class="fas fa-rocket"></i> Commencer gratuitement
                    </a>
                    <a href="#features" class="btn-outline px-8 py-4 rounded-2xl text-base font-medium text-white flex items-center justify-center gap-2">
                        <i class="fas fa-play-circle"></i> Découvrir
                    </a>
                </div>

                <!-- Stats bar -->
                <div class="flex items-center gap-8 sm:gap-12">
                    <div>
                        <div class="text-2xl font-bold text-white counter">7+</div>
                        <div class="text-xs text-slate-500">Modules intégrés</div>
                    </div>
                    <div class="w-px h-10 bg-white/10"></div>
                    <div>
                        <div class="text-2xl font-bold text-white counter">100%</div>
                        <div class="text-xs text-slate-500">Gratuit</div>
                    </div>
                    <div class="w-px h-10 bg-white/10"></div>
                    <div>
                        <div class="text-2xl font-bold text-white counter">∞</div>
                        <div class="text-xs text-slate-500">Possibilités</div>
                    </div>
                </div>
            </div>

            <!-- Right: Dashboard mockup -->
            <div class="fade-up relative hidden lg:block">
                <div class="relative glass rounded-2xl p-1 glow shine">
                    <div class="bg-surface-dark rounded-xl overflow-hidden">
                        <!-- Fake topbar -->
                        <div class="flex items-center gap-2 px-4 py-3 border-b border-white/5">
                            <div class="flex gap-1.5">
                                <div class="w-3 h-3 rounded-full bg-red-500/80"></div>
                                <div class="w-3 h-3 rounded-full bg-yellow-500/80"></div>
                                <div class="w-3 h-3 rounded-full bg-green-500/80"></div>
                            </div>
                            <div class="flex-1 text-center">
                                <div class="inline-block bg-white/5 rounded-lg px-4 py-1 text-xs text-slate-500">nexus.tsilizy.com/dashboard</div>
                            </div>
                        </div>
                        <!-- Fake dashboard content -->
                        <div class="p-6 space-y-4">
                            <div class="flex items-center justify-between">
                                <div>
                                    <div class="text-lg font-bold text-white">Bonjour, Admin 👋</div>
                                    <div class="text-xs text-slate-500">Mardi 18 février 2026</div>
                                </div>
                                <div class="flex gap-2">
                                    <div class="w-8 h-8 rounded-lg bg-primary-500/20 flex items-center justify-center"><i class="fas fa-bell text-primary-400 text-xs"></i></div>
                                    <div class="w-8 h-8 rounded-lg bg-white/5 flex items-center justify-center"><i class="fas fa-cog text-slate-500 text-xs"></i></div>
                                </div>
                            </div>
                            <!-- Stats cards -->
                            <div class="grid grid-cols-4 gap-3">
                                <div class="bg-white/5 rounded-xl p-3 text-center">
                                    <div class="text-xl font-bold text-primary-400">12</div>
                                    <div class="text-[10px] text-slate-500">Tâches</div>
                                </div>
                                <div class="bg-white/5 rounded-xl p-3 text-center">
                                    <div class="text-xl font-bold text-accent-400">5</div>
                                    <div class="text-[10px] text-slate-500">Projets</div>
                                </div>
                                <div class="bg-white/5 rounded-xl p-3 text-center">
                                    <div class="text-xl font-bold text-emerald-400">28</div>
                                    <div class="text-[10px] text-slate-500">Contacts</div>
                                </div>
                                <div class="bg-white/5 rounded-xl p-3 text-center">
                                    <div class="text-xl font-bold text-amber-400">3</div>
                                    <div class="text-[10px] text-slate-500">Événements</div>
                                </div>
                            </div>
                            <!-- Fake task list -->
                            <div class="space-y-2">
                                <div class="bg-white/5 rounded-lg px-3 py-2 flex items-center gap-3">
                                    <div class="w-4 h-4 rounded border-2 border-primary-500"></div>
                                    <span class="text-xs text-slate-300 flex-1">Préparer la présentation Q1</span>
                                    <span class="text-[10px] px-2 py-0.5 rounded-full bg-red-500/20 text-red-400">Urgent</span>
                                </div>
                                <div class="bg-white/5 rounded-lg px-3 py-2 flex items-center gap-3">
                                    <div class="w-4 h-4 rounded border-2 border-emerald-500 bg-emerald-500/20 flex items-center justify-center"><i class="fas fa-check text-emerald-400" style="font-size:8px"></i></div>
                                    <span class="text-xs text-slate-500 flex-1 line-through">Design du logo finalisé</span>
                                    <span class="text-[10px] px-2 py-0.5 rounded-full bg-emerald-500/20 text-emerald-400">Terminé</span>
                                </div>
                                <div class="bg-white/5 rounded-lg px-3 py-2 flex items-center gap-3">
                                    <div class="w-4 h-4 rounded border-2 border-amber-500"></div>
                                    <span class="text-xs text-slate-300 flex-1">Réunion client — 14h00</span>
                                    <span class="text-[10px] px-2 py-0.5 rounded-full bg-amber-500/20 text-amber-400">En cours</span>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                <!-- Floating elements -->
                <div class="absolute -top-4 -right-4 glass rounded-xl p-3 float text-xs">
                    <div class="flex items-center gap-2">
                        <div class="w-6 h-6 rounded-full gradient-bg flex items-center justify-center"><i class="fas fa-chart-line text-white" style="font-size:10px"></i></div>
                        <div><div class="text-white font-semibold">+42%</div><div class="text-slate-500 text-[10px]">Productivité</div></div>
                    </div>
                </div>
                <div class="absolute -bottom-4 -left-4 glass rounded-xl p-3 float-delay text-xs">
                    <div class="flex items-center gap-2">
                        <div class="w-6 h-6 rounded-full bg-emerald-500/20 flex items-center justify-center"><i class="fas fa-check text-emerald-400" style="font-size:10px"></i></div>
                        <div><div class="text-white font-semibold">6 tâches</div><div class="text-slate-500 text-[10px]">Terminées aujourd'hui</div></div>
                    </div>
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
            <span class="text-primary-400 text-sm font-semibold uppercase tracking-wider">Fonctionnalités</span>
            <h2 class="text-3xl lg:text-4xl font-bold text-white mt-3 mb-4">Tout ce dont vous avez besoin,<br><span class="gradient-text">en un seul endroit</span></h2>
            <p class="text-slate-400 max-w-2xl mx-auto">Chaque module est conçu pour s'intégrer parfaitement avec les autres, créant un écosystème de productivité fluide.</p>
        </div>

        <div class="grid sm:grid-cols-2 lg:grid-cols-3 gap-6">
            <!-- Feature 1: Tasks -->
            <div class="glass rounded-2xl p-6 glass-hover transition-all duration-500 fade-up group">
                <div class="feature-icon w-12 h-12 rounded-xl flex items-center justify-center mb-4 group-hover:scale-110 transition-transform">
                    <i class="fas fa-tasks text-primary-400 text-lg"></i>
                </div>
                <h3 class="text-lg font-semibold text-white mb-2">Gestion de tâches</h3>
                <p class="text-sm text-slate-400 leading-relaxed">Kanban, listes, priorités, labels et dates d'échéance. Organisez votre travail avec puissance et clarté.</p>
            </div>

            <!-- Feature 2: Notes -->
            <div class="glass rounded-2xl p-6 glass-hover transition-all duration-500 fade-up group" style="transition-delay: 0.1s">
                <div class="feature-icon w-12 h-12 rounded-xl flex items-center justify-center mb-4 group-hover:scale-110 transition-transform">
                    <i class="fas fa-sticky-note text-accent-400 text-lg"></i>
                </div>
                <h3 class="text-lg font-semibold text-white mb-2">Notes intelligentes</h3>
                <p class="text-sm text-slate-400 leading-relaxed">Éditeur riche style Notion, auto-sauvegarde, arborescence hiérarchique et recherche instantanée.</p>
            </div>

            <!-- Feature 3: Agenda -->
            <div class="glass rounded-2xl p-6 glass-hover transition-all duration-500 fade-up group" style="transition-delay: 0.2s">
                <div class="feature-icon w-12 h-12 rounded-xl flex items-center justify-center mb-4 group-hover:scale-110 transition-transform">
                    <i class="fas fa-calendar-alt text-emerald-400 text-lg"></i>
                </div>
                <h3 class="text-lg font-semibold text-white mb-2">Agenda & Calendrier</h3>
                <p class="text-sm text-slate-400 leading-relaxed">Vue calendrier interactive, événements récurrents, rappels et synchronisation avec vos projets.</p>
            </div>

            <!-- Feature 4: Projects -->
            <div class="glass rounded-2xl p-6 glass-hover transition-all duration-500 fade-up group" style="transition-delay: 0.3s">
                <div class="feature-icon w-12 h-12 rounded-xl flex items-center justify-center mb-4 group-hover:scale-110 transition-transform">
                    <i class="fas fa-project-diagram text-amber-400 text-lg"></i>
                </div>
                <h3 class="text-lg font-semibold text-white mb-2">Projets & Jalons</h3>
                <p class="text-sm text-slate-400 leading-relaxed">Suivez l'avancement de vos projets avec des barres de progression, des jalons et une vue d'ensemble claire.</p>
            </div>

            <!-- Feature 5: Contacts -->
            <div class="glass rounded-2xl p-6 glass-hover transition-all duration-500 fade-up group" style="transition-delay: 0.4s">
                <div class="feature-icon w-12 h-12 rounded-xl flex items-center justify-center mb-4 group-hover:scale-110 transition-transform">
                    <i class="fas fa-address-book text-rose-400 text-lg"></i>
                </div>
                <h3 class="text-lg font-semibold text-white mb-2">CRM & Contacts</h3>
                <p class="text-sm text-slate-400 leading-relaxed">Gérez vos contacts avec tags, historique d'interactions, export CSV et recherche avancée.</p>
            </div>

            <!-- Feature 6: Websites -->
            <div class="glass rounded-2xl p-6 glass-hover transition-all duration-500 fade-up group" style="transition-delay: 0.5s">
                <div class="feature-icon w-12 h-12 rounded-xl flex items-center justify-center mb-4 group-hover:scale-110 transition-transform">
                    <i class="fas fa-globe text-cyan-400 text-lg"></i>
                </div>
                <h3 class="text-lg font-semibold text-white mb-2">Sites web</h3>
                <p class="text-sm text-slate-400 leading-relaxed">Centralisez tous vos sites web : suivi SSL, domaines, statuts, et accès en un clic.</p>
            </div>
        </div>
    </div>
</section>


<!-- ═══════════════════════════════════════════════════ -->
<!-- 3. HOW IT WORKS -->
<!-- ═══════════════════════════════════════════════════ -->
<section id="how-it-works" class="py-24 lg:py-32 relative grid-bg">
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
        <div class="text-center mb-16 fade-up">
            <span class="text-accent-400 text-sm font-semibold uppercase tracking-wider">Comment ça marche</span>
            <h2 class="text-3xl lg:text-4xl font-bold text-white mt-3 mb-4">Productif en <span class="gradient-text">3 étapes</span></h2>
            <p class="text-slate-400 max-w-xl mx-auto">Commencez en quelques secondes. Pas de carte requise, pas de configuration complexe.</p>
        </div>

        <div class="grid md:grid-cols-3 gap-8 lg:gap-12 relative">
            <!-- Connecting line (desktop) -->
            <div class="hidden md:block absolute top-16 left-1/6 right-1/6 h-0.5 bg-gradient-to-r from-primary-500 via-accent-400 to-emerald-400 opacity-20"></div>

            <!-- Step 1 -->
            <div class="text-center fade-up relative">
                <div class="w-14 h-14 rounded-2xl gradient-bg flex items-center justify-center mx-auto mb-6 text-white font-bold text-xl glow relative z-10">1</div>
                <h3 class="text-lg font-semibold text-white mb-3">Créez votre compte</h3>
                <p class="text-sm text-slate-400 leading-relaxed">Inscription gratuite en 30 secondes. Email et mot de passe — c'est tout.</p>
            </div>

            <!-- Step 2 -->
            <div class="text-center fade-up relative" style="transition-delay: 0.15s">
                <div class="w-14 h-14 rounded-2xl bg-accent-400/20 border border-accent-400/30 flex items-center justify-center mx-auto mb-6 text-accent-400 font-bold text-xl relative z-10">2</div>
                <h3 class="text-lg font-semibold text-white mb-3">Organisez votre travail</h3>
                <p class="text-sm text-slate-400 leading-relaxed">Ajoutez vos tâches, projets, contacts. Tout est connecté et synchronisé.</p>
            </div>

            <!-- Step 3 -->
            <div class="text-center fade-up relative" style="transition-delay: 0.3s">
                <div class="w-14 h-14 rounded-2xl bg-emerald-500/20 border border-emerald-500/30 flex items-center justify-center mx-auto mb-6 text-emerald-400 font-bold text-xl relative z-10">3</div>
                <h3 class="text-lg font-semibold text-white mb-3">Boostez votre productivité</h3>
                <p class="text-sm text-slate-400 leading-relaxed">Suivez vos progrès, collaborez et atteignez vos objectifs plus rapidement.</p>
            </div>
        </div>
    </div>
</section>


<!-- ═══════════════════════════════════════════════════ -->
<!-- 4. DASHBOARD PREVIEW -->
<!-- ═══════════════════════════════════════════════════ -->
<section class="py-24 lg:py-32 relative overflow-hidden">
    <div class="absolute inset-0 hero-gradient opacity-20"></div>
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 relative">
        <div class="grid lg:grid-cols-2 gap-12 items-center">
            <div class="fade-up">
                <span class="text-primary-400 text-sm font-semibold uppercase tracking-wider">Interface</span>
                <h2 class="text-3xl lg:text-4xl font-bold text-white mt-3 mb-6">Un tableau de bord<br><span class="gradient-text">qui vous ressemble</span></h2>
                <p class="text-slate-400 mb-8 leading-relaxed">Interface sombre moderne, navigation fluide, et design glassmorphique. Chaque pixel est pensé pour votre confort.</p>
                
                <div class="space-y-4">
                    <div class="flex items-center gap-4">
                        <div class="w-10 h-10 rounded-xl bg-primary-500/20 flex items-center justify-center flex-shrink-0"><i class="fas fa-moon text-primary-400 text-sm"></i></div>
                        <div><h4 class="text-white font-medium text-sm">Mode sombre natif</h4><p class="text-slate-500 text-xs">Conçu pour être agréable même après des heures d'utilisation</p></div>
                    </div>
                    <div class="flex items-center gap-4">
                        <div class="w-10 h-10 rounded-xl bg-accent-400/20 flex items-center justify-center flex-shrink-0"><i class="fas fa-mobile-alt text-accent-400 text-sm"></i></div>
                        <div><h4 class="text-white font-medium text-sm">100% responsive</h4><p class="text-slate-500 text-xs">Fonctionne parfaitement sur mobile, tablette et desktop</p></div>
                    </div>
                    <div class="flex items-center gap-4">
                        <div class="w-10 h-10 rounded-xl bg-emerald-500/20 flex items-center justify-center flex-shrink-0"><i class="fas fa-shield-alt text-emerald-400 text-sm"></i></div>
                        <div><h4 class="text-white font-medium text-sm">Sécurité maximale</h4><p class="text-slate-500 text-xs">CSRF, XSS protection, chiffrement et contrôle d'accès par rôle</p></div>
                    </div>
                </div>
            </div>

            <!-- Preview cards -->
            <div class="fade-up relative">
                <div class="grid grid-cols-2 gap-4">
                    <div class="glass rounded-2xl p-5 col-span-2 shine">
                        <div class="flex items-center gap-3 mb-4">
                            <div class="w-8 h-8 rounded-lg gradient-bg flex items-center justify-center"><i class="fas fa-tasks text-white text-xs"></i></div>
                            <span class="text-white font-semibold text-sm">Mes tâches</span>
                            <span class="ml-auto text-xs bg-primary-500/20 text-primary-400 px-2 py-0.5 rounded-full">12 actives</span>
                        </div>
                        <div class="flex items-center gap-2 mb-3">
                            <div class="flex-1 h-2 bg-white/5 rounded-full overflow-hidden"><div class="h-full gradient-bg rounded-full" style="width:65%"></div></div>
                            <span class="text-xs text-slate-500">65%</span>
                        </div>
                        <div class="flex gap-2">
                            <span class="text-[10px] px-2 py-0.5 rounded-full bg-red-500/20 text-red-400">2 urgentes</span>
                            <span class="text-[10px] px-2 py-0.5 rounded-full bg-amber-500/20 text-amber-400">4 en cours</span>
                            <span class="text-[10px] px-2 py-0.5 rounded-full bg-emerald-500/20 text-emerald-400">6 terminées</span>
                        </div>
                    </div>
                    <div class="glass rounded-2xl p-5">
                        <div class="w-8 h-8 rounded-lg bg-accent-400/20 flex items-center justify-center mb-3"><i class="fas fa-calendar text-accent-400 text-xs"></i></div>
                        <div class="text-2xl font-bold text-white">3</div>
                        <div class="text-xs text-slate-500">Événements cette semaine</div>
                    </div>
                    <div class="glass rounded-2xl p-5">
                        <div class="w-8 h-8 rounded-lg bg-emerald-500/20 flex items-center justify-center mb-3"><i class="fas fa-users text-emerald-400 text-xs"></i></div>
                        <div class="text-2xl font-bold text-white">28</div>
                        <div class="text-xs text-slate-500">Contacts actifs</div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</section>


<!-- ═══════════════════════════════════════════════════ -->
<!-- 5. PRICING -->
<!-- ═══════════════════════════════════════════════════ -->
<section id="pricing" class="py-24 lg:py-32 relative grid-bg">
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
        <div class="text-center mb-16 fade-up">
            <span class="text-emerald-400 text-sm font-semibold uppercase tracking-wider">Tarifs</span>
            <h2 class="text-3xl lg:text-4xl font-bold text-white mt-3 mb-4">Simple et <span class="gradient-text">transparent</span></h2>
            <p class="text-slate-400 max-w-xl mx-auto">Commencez gratuitement. Contribuez si vous aimez le projet.</p>
        </div>

        <div class="grid md:grid-cols-2 gap-8 max-w-3xl mx-auto">
            <!-- Free Plan -->
            <div class="glass rounded-2xl p-8 fade-up relative group glass-hover transition-all duration-500">
                <h3 class="text-xl font-bold text-white mb-2">Gratuit</h3>
                <p class="text-slate-400 text-sm mb-6">Parfait pour commencer</p>
                <div class="flex items-baseline gap-1 mb-8">
                    <span class="text-4xl font-extrabold text-white">0€</span>
                    <span class="text-slate-500 text-sm">/ pour toujours</span>
                </div>
                <ul class="space-y-3 mb-8">
                    <li class="flex items-center gap-3 text-sm text-slate-300"><i class="fas fa-check text-emerald-400 text-xs"></i>50 tâches</li>
                    <li class="flex items-center gap-3 text-sm text-slate-300"><i class="fas fa-check text-emerald-400 text-xs"></i>5 projets</li>
                    <li class="flex items-center gap-3 text-sm text-slate-300"><i class="fas fa-check text-emerald-400 text-xs"></i>100 contacts</li>
                    <li class="flex items-center gap-3 text-sm text-slate-300"><i class="fas fa-check text-emerald-400 text-xs"></i>50 notes</li>
                    <li class="flex items-center gap-3 text-sm text-slate-300"><i class="fas fa-check text-emerald-400 text-xs"></i>Agenda complet</li>
                    <li class="flex items-center gap-3 text-sm text-slate-300"><i class="fas fa-check text-emerald-400 text-xs"></i>Gestion de sites web</li>
                </ul>
                <a href="<?= url('/register') ?>" class="block text-center btn-outline px-6 py-3 rounded-xl text-sm font-semibold text-white">
                    Commencer gratuitement
                </a>
            </div>

            <!-- Contribution Plan -->
            <div class="glass rounded-2xl p-8 fade-up relative pricing-popular group glass-hover transition-all duration-500" style="transition-delay: 0.15s">
                <h3 class="text-xl font-bold text-white mb-2">Contribution</h3>
                <p class="text-slate-400 text-sm mb-6">Soutenez le projet</p>
                <div class="flex items-baseline gap-1 mb-8">
                    <span class="text-4xl font-extrabold gradient-text">Libre</span>
                    <span class="text-slate-500 text-sm">/ don unique</span>
                </div>
                <ul class="space-y-3 mb-8">
                    <li class="flex items-center gap-3 text-sm text-slate-300"><i class="fas fa-infinity text-primary-400 text-xs"></i>Tâches illimitées</li>
                    <li class="flex items-center gap-3 text-sm text-slate-300"><i class="fas fa-infinity text-primary-400 text-xs"></i>Projets illimités</li>
                    <li class="flex items-center gap-3 text-sm text-slate-300"><i class="fas fa-infinity text-primary-400 text-xs"></i>Contacts illimités</li>
                    <li class="flex items-center gap-3 text-sm text-slate-300"><i class="fas fa-infinity text-primary-400 text-xs"></i>Notes illimitées</li>
                    <li class="flex items-center gap-3 text-sm text-slate-300"><i class="fas fa-star text-amber-400 text-xs"></i>Badge contributeur</li>
                    <li class="flex items-center gap-3 text-sm text-slate-300"><i class="fas fa-heart text-rose-400 text-xs"></i>Soutenez le développement</li>
                </ul>
                <a href="<?= url('/register') ?>" class="block text-center btn-primary px-6 py-3 rounded-xl text-sm font-semibold text-white">
                    <i class="fas fa-heart mr-1"></i> Contribuer
                </a>
            </div>
        </div>
    </div>
</section>


<!-- ═══════════════════════════════════════════════════ -->
<!-- 6. TESTIMONIALS -->
<!-- ═══════════════════════════════════════════════════ -->
<section id="testimonials" class="py-24 lg:py-32 relative">
    <div class="absolute inset-0 hero-gradient opacity-20"></div>
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 relative">
        <div class="text-center mb-16 fade-up">
            <span class="text-primary-400 text-sm font-semibold uppercase tracking-wider">Témoignages</span>
            <h2 class="text-3xl lg:text-4xl font-bold text-white mt-3 mb-4">Ce qu'ils en <span class="gradient-text">pensent</span></h2>
        </div>

        <div class="grid md:grid-cols-3 gap-6">
            <!-- Testimonial 1 -->
            <div class="glass rounded-2xl p-6 fade-up transition-all duration-500 testimonial-glow hover:border-primary-500/20">
                <div class="flex items-center gap-1 mb-4">
                    <i class="fas fa-star text-amber-400 text-xs"></i>
                    <i class="fas fa-star text-amber-400 text-xs"></i>
                    <i class="fas fa-star text-amber-400 text-xs"></i>
                    <i class="fas fa-star text-amber-400 text-xs"></i>
                    <i class="fas fa-star text-amber-400 text-xs"></i>
                </div>
                <p class="text-slate-300 text-sm leading-relaxed mb-6">"TSILIZY Nexus a transformé la façon dont notre équipe gère les projets. L'interface est intuitive et les fonctionnalités sont exactement ce dont nous avions besoin."</p>
                <div class="flex items-center gap-3">
                    <div class="w-10 h-10 rounded-full gradient-bg flex items-center justify-center text-white font-bold text-sm">JD</div>
                    <div>
                        <div class="text-white font-medium text-sm">Jean Dupont</div>
                        <div class="text-slate-500 text-xs">Directeur Technique, TechCorp</div>
                    </div>
                </div>
            </div>

            <!-- Testimonial 2 -->
            <div class="glass rounded-2xl p-6 fade-up transition-all duration-500 testimonial-glow hover:border-primary-500/20" style="transition-delay: 0.1s">
                <div class="flex items-center gap-1 mb-4">
                    <i class="fas fa-star text-amber-400 text-xs"></i>
                    <i class="fas fa-star text-amber-400 text-xs"></i>
                    <i class="fas fa-star text-amber-400 text-xs"></i>
                    <i class="fas fa-star text-amber-400 text-xs"></i>
                    <i class="fas fa-star text-amber-400 text-xs"></i>
                </div>
                <p class="text-slate-300 text-sm leading-relaxed mb-6">"Enfin une plateforme tout-en-un qui ne sacrifie pas l'esthétique pour la fonctionnalité. Le mode sombre est magnifique et le CRM est puissant."</p>
                <div class="flex items-center gap-3">
                    <div class="w-10 h-10 rounded-full bg-accent-400/20 flex items-center justify-center text-accent-400 font-bold text-sm">MM</div>
                    <div>
                        <div class="text-white font-medium text-sm">Marie Martin</div>
                        <div class="text-slate-500 text-xs">Designer UX, DesignHub</div>
                    </div>
                </div>
            </div>

            <!-- Testimonial 3 -->
            <div class="glass rounded-2xl p-6 fade-up transition-all duration-500 testimonial-glow hover:border-primary-500/20" style="transition-delay: 0.2s">
                <div class="flex items-center gap-1 mb-4">
                    <i class="fas fa-star text-amber-400 text-xs"></i>
                    <i class="fas fa-star text-amber-400 text-xs"></i>
                    <i class="fas fa-star text-amber-400 text-xs"></i>
                    <i class="fas fa-star text-amber-400 text-xs"></i>
                    <i class="fas fa-star-half-alt text-amber-400 text-xs"></i>
                </div>
                <p class="text-slate-300 text-sm leading-relaxed mb-6">"La gestion des contacts et l'export CSV m'ont fait gagner des heures chaque semaine. Le fait que ça soit gratuit est incroyable."</p>
                <div class="flex items-center gap-3">
                    <div class="w-10 h-10 rounded-full bg-emerald-500/20 flex items-center justify-center text-emerald-400 font-bold text-sm">PB</div>
                    <div>
                        <div class="text-white font-medium text-sm">Pierre Bernard</div>
                        <div class="text-slate-500 text-xs">Chef de Projet, MarketPro</div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</section>


<!-- ═══════════════════════════════════════════════════ -->
<!-- 7. CTA SECTION -->
<!-- ═══════════════════════════════════════════════════ -->
<section class="py-24 lg:py-32 relative overflow-hidden">
    <div class="absolute inset-0 gradient-bg opacity-10"></div>
    <div class="absolute -top-40 -right-40 w-80 h-80 bg-primary-500/20 rounded-full blur-3xl"></div>
    <div class="absolute -bottom-40 -left-40 w-80 h-80 bg-accent-400/10 rounded-full blur-3xl"></div>
    
    <div class="max-w-4xl mx-auto px-4 sm:px-6 lg:px-8 text-center relative fade-up">
        <h2 class="text-3xl lg:text-5xl font-extrabold text-white mb-6">
            Prêt à transformer votre<br><span class="gradient-text">façon de travailler ?</span>
        </h2>
        <p class="text-lg text-slate-400 mb-10 max-w-2xl mx-auto">Rejoignez les professionnels qui ont déjà choisi TSILIZY Nexus. Commencez gratuitement, sans engagement.</p>
        <div class="flex flex-col sm:flex-row gap-4 justify-center">
            <a href="<?= url('/register') ?>" class="btn-primary px-10 py-4 rounded-2xl text-lg font-bold text-white inline-flex items-center justify-center gap-2">
                <i class="fas fa-rocket"></i> Créer mon compte gratuit
            </a>
            <a href="<?= url('/login') ?>" class="btn-outline px-10 py-4 rounded-2xl text-lg font-medium text-white inline-flex items-center justify-center gap-2">
                <i class="fas fa-sign-in-alt"></i> Se connecter
            </a>
        </div>
    </div>
</section>


<!-- ═══════════════════════════════════════════════════ -->
<!-- 8. FOOTER -->
<!-- ═══════════════════════════════════════════════════ -->
<footer class="border-t border-white/5 py-16 relative">
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
        <div class="grid sm:grid-cols-2 lg:grid-cols-4 gap-10 mb-12">
            <!-- Brand -->
            <div>
                <div class="flex items-center gap-3 mb-4">
                    <div class="w-10 h-10 rounded-xl gradient-bg flex items-center justify-center">
                        <i class="fas fa-bolt text-white text-lg"></i>
                    </div>
                    <span class="text-xl font-bold gradient-text"><?= e($appName) ?></span>
                </div>
                <p class="text-sm text-slate-500 leading-relaxed mb-4">La plateforme de productivité tout-en-un pour les équipes modernes.</p>
                <div class="flex gap-3">
                    <a href="#" class="w-9 h-9 rounded-lg bg-white/5 flex items-center justify-center text-slate-500 hover:text-primary-400 hover:bg-primary-500/10 transition-all"><i class="fab fa-facebook-f text-sm"></i></a>
                    <a href="#" class="w-9 h-9 rounded-lg bg-white/5 flex items-center justify-center text-slate-500 hover:text-accent-400 hover:bg-accent-400/10 transition-all"><i class="fab fa-twitter text-sm"></i></a>
                    <a href="#" class="w-9 h-9 rounded-lg bg-white/5 flex items-center justify-center text-slate-500 hover:text-white hover:bg-white/10 transition-all"><i class="fab fa-github text-sm"></i></a>
                    <a href="#" class="w-9 h-9 rounded-lg bg-white/5 flex items-center justify-center text-slate-500 hover:text-rose-400 hover:bg-rose-500/10 transition-all"><i class="fab fa-instagram text-sm"></i></a>
                </div>
            </div>

            <!-- Product -->
            <div>
                <h4 class="text-white font-semibold mb-4">Produit</h4>
                <ul class="space-y-2">
                    <li><a href="#features" class="text-sm text-slate-500 hover:text-white transition-colors">Fonctionnalités</a></li>
                    <li><a href="#pricing" class="text-sm text-slate-500 hover:text-white transition-colors">Tarifs</a></li>
                    <li><a href="#how-it-works" class="text-sm text-slate-500 hover:text-white transition-colors">Comment ça marche</a></li>
                    <li><a href="<?= url('/register') ?>" class="text-sm text-slate-500 hover:text-white transition-colors">Inscription</a></li>
                </ul>
            </div>

            <!-- Legal -->
            <div>
                <h4 class="text-white font-semibold mb-4">Légal</h4>
                <ul class="space-y-2">
                    <li><a href="<?= url('/terms') ?>" class="text-sm text-slate-500 hover:text-white transition-colors">Conditions d'utilisation</a></li>
                    <li><a href="<?= url('/privacy') ?>" class="text-sm text-slate-500 hover:text-white transition-colors">Politique de confidentialité</a></li>
                </ul>
            </div>

            <!-- Contact -->
            <div>
                <h4 class="text-white font-semibold mb-4">Contact</h4>
                <ul class="space-y-2">
                    <li class="flex items-center gap-2 text-sm text-slate-500"><i class="fas fa-envelope text-xs text-primary-400"></i>contact@tsilizy.com</li>
                    <li class="flex items-center gap-2 text-sm text-slate-500"><i class="fas fa-globe text-xs text-accent-400"></i>tsilizy.com</li>
                </ul>
            </div>
        </div>

        <div class="border-t border-white/5 pt-8 flex flex-col sm:flex-row items-center justify-between gap-4">
            <p class="text-xs text-slate-600">&copy; <?= date('Y') ?> TSILIZY LLC — Tous droits réservés</p>
            <p class="text-xs text-slate-600">Fait avec <i class="fas fa-heart text-rose-500 text-xs"></i> par l'équipe TSILIZY</p>
        </div>
    </div>
</footer>


<!-- Scroll animations -->
<script>
    // Intersection Observer for fade-up animations
    const observer = new IntersectionObserver((entries) => {
        entries.forEach(entry => {
            if (entry.isIntersecting) {
                entry.target.classList.add('visible');
            }
        });
    }, { threshold: 0.1, rootMargin: '0px 0px -50px 0px' });

    document.querySelectorAll('.fade-up').forEach(el => observer.observe(el));

    // Smooth scroll for anchor links
    document.querySelectorAll('a[href^="#"]').forEach(anchor => {
        anchor.addEventListener('click', function(e) {
            e.preventDefault();
            const target = document.querySelector(this.getAttribute('href'));
            if (target) {
                target.scrollIntoView({ behavior: 'smooth', block: 'start' });
            }
        });
    });

    // Register service worker
    if ('serviceWorker' in navigator) {
        navigator.serviceWorker.register('<?= url('/public/sw.js') ?>').catch(() => {});
    }
</script>

</body>
</html>
