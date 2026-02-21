<!DOCTYPE html>
<html lang="<?= get_locale() ?>" x-data="appState()" :class="{ 'dark': darkMode }">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title><?= e($pageTitle ?? 'Dashboard') ?> — <?= e($appName) ?></title>
    <meta name="description" content="TSILIZY Nexus — Espace de travail">
    <meta name="robots" content="noindex, nofollow">
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
                    primary: {50:'#f3f0ff',100:'#e9e3ff',200:'#d4c8ff',300:'#b49dff',400:'#9166ff',500:'#6C3CE1',600:'#5a1fd4',700:'#4a15b8'},
                    secondary: {500:'#1E1B4B',600:'#1a1741',700:'#151237',800:'#100e2d',900:'#0b0a23'},
                    accent: {50:'#ecfeff',100:'#cffafe',200:'#a5f3fc',300:'#67e8f9',400:'#22D3EE',500:'#06b6d4'},
                    surface: {light:'#F8FAFC',dark:'#0F172A',card:'#1E293B',hover:'#334155'}
                },
                fontFamily: { sans: ['Inter','system-ui','sans-serif'] }
            }
        }
    }
    </script>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.1/css/all.min.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/animate.css/4.1.1/animate.min.css">
    <link rel="stylesheet" href="<?= url('/public/assets/css/app.css') ?>">
    <style>
        * { margin: 0; padding: 0; box-sizing: border-box; }
        body { font-family: 'Inter', system-ui, sans-serif; background: #0F172A; color: #e2e8f0; }
        
        /* Scrollbar */
        ::-webkit-scrollbar { width: 6px; height: 6px; }
        ::-webkit-scrollbar-track { background: transparent; }
        ::-webkit-scrollbar-thumb { background: rgba(108,60,225,0.3); border-radius: 3px; }
        ::-webkit-scrollbar-thumb:hover { background: rgba(108,60,225,0.5); }
        
        /* Glass */
        .glass { background: rgba(255,255,255,0.03); backdrop-filter: blur(20px); -webkit-backdrop-filter: blur(20px); border: 1px solid rgba(255,255,255,0.06); }
        .glass-solid { background: rgba(30,41,59,0.95); backdrop-filter: blur(20px); border: 1px solid rgba(255,255,255,0.06); }
        
        /* Gradients */
        .gradient-text { background: linear-gradient(135deg, #6C3CE1, #22D3EE); -webkit-background-clip: text; -webkit-text-fill-color: transparent; }
        .gradient-bg { background: linear-gradient(135deg, #6C3CE1, #22D3EE); }
        
        /* Sidebar */
        .sidebar { background: linear-gradient(180deg, #1E1B4B 0%, #0F172A 100%); transition: width 0.3s cubic-bezier(0.4,0,0.2,1); }
        .sidebar-link { transition: all 0.2s ease; border-radius: 0.75rem; }
        .sidebar-link:hover { background: rgba(108,60,225,0.15); }
        .sidebar-link.active { background: rgba(108,60,225,0.2); color: #22D3EE; border-left: 3px solid #6C3CE1; }
        
        /* Cards */
        .card { background: rgba(30,41,59,0.6); border: 1px solid rgba(255,255,255,0.06); border-radius: 1rem; transition: all 0.3s ease; }
        .card:hover { border-color: rgba(108,60,225,0.3); transform: translateY(-1px); box-shadow: 0 8px 25px rgba(0,0,0,0.3); }
        
        /* Stat card */
        .stat-card { position: relative; overflow: hidden; }
        .stat-card::before { content: ''; position: absolute; top: 0; right: 0; width: 100px; height: 100px; border-radius: 50%; opacity: 0.1; transform: translate(30%, -30%); }
        .stat-card.purple::before { background: #6C3CE1; }
        .stat-card.cyan::before { background: #22D3EE; }
        .stat-card.emerald::before { background: #10B981; }
        .stat-card.amber::before { background: #F59E0B; }
        
        /* Animations */
        .fade-in { animation: fadeIn 0.5s ease-out; }
        @keyframes fadeIn { from { opacity: 0; transform: translateY(10px); } to { opacity: 1; transform: translateY(0); } }
        .slide-in-left { animation: slideInLeft 0.3s ease-out; }
        @keyframes slideInLeft { from { opacity: 0; transform: translateX(-20px); } to { opacity: 1; transform: translateX(0); } }
        
        /* Topbar */
        .topbar { background: rgba(15,23,42,0.8); backdrop-filter: blur(20px); border-bottom: 1px solid rgba(255,255,255,0.06); }
        
        /* Badge */
        .badge { display: inline-flex; align-items: center; padding: 0.125rem 0.5rem; border-radius: 9999px; font-size: 0.75rem; font-weight: 500; }
        .badge-purple { background: rgba(108,60,225,0.15); color: #b49dff; }
        .badge-cyan { background: rgba(34,211,238,0.15); color: #67e8f9; }
        .badge-emerald { background: rgba(16,185,129,0.15); color: #6ee7b7; }
        .badge-amber { background: rgba(245,158,11,0.15); color: #fcd34d; }
        .badge-red { background: rgba(239,68,68,0.15); color: #fca5a5; }
        
        /* Progress bar */
        .progress-bar { height: 6px; border-radius: 3px; background: rgba(255,255,255,0.1); overflow: hidden; }
        .progress-fill { height: 100%; border-radius: 3px; transition: width 1s cubic-bezier(0.4,0,0.2,1); }
        
        /* Notification dot */
        .notif-dot { width: 8px; height: 8px; border-radius: 50%; background: #EF4444; position: absolute; top: -2px; right: -2px; animation: pulse 2s infinite; }
        @keyframes pulse { 0%, 100% { opacity: 1; } 50% { opacity: 0.5; } }
        
        /* Dropdown */
        .dropdown-menu { background: rgba(30,41,59,0.98); border: 1px solid rgba(255,255,255,0.1); border-radius: 0.75rem; box-shadow: 0 20px 40px rgba(0,0,0,0.5); }
        
        /* Button styles */
        .btn-primary { background: linear-gradient(135deg, #6C3CE1, #5a1fd4); color: white; padding: 0.5rem 1.25rem; border-radius: 0.75rem; font-weight: 600; transition: all 0.3s; border: none; cursor: pointer; }
        .btn-primary:hover { box-shadow: 0 4px 15px rgba(108,60,225,0.4); transform: translateY(-1px); }
        .btn-secondary { background: rgba(255,255,255,0.05); color: #94a3b8; padding: 0.5rem 1.25rem; border-radius: 0.75rem; font-weight: 500; transition: all 0.3s; border: 1px solid rgba(255,255,255,0.1); cursor: pointer; }
        .btn-secondary:hover { background: rgba(255,255,255,0.1); color: white; }
        .btn-danger { background: rgba(239,68,68,0.15); color: #fca5a5; padding: 0.5rem 1.25rem; border-radius: 0.75rem; font-weight: 500; transition: all 0.3s; border: 1px solid rgba(239,68,68,0.2); cursor: pointer; }
        .btn-danger:hover { background: rgba(239,68,68,0.25); }
        
        /* Input */
        .input { width: 100%; background: rgba(255,255,255,0.05); border: 1px solid rgba(255,255,255,0.1); border-radius: 0.75rem; padding: 0.625rem 1rem; color: white; outline: none; transition: all 0.3s; }
        .input:focus { border-color: #6C3CE1; box-shadow: 0 0 0 3px rgba(108,60,225,0.15); }
        .input::placeholder { color: #475569; }
        
        /* ========================================= */
        /* LIGHT MODE (default when .dark is absent) */
        /* ========================================= */
        html:not(.dark) body { background: #F8FAFC; color: #1E293B; }
        html:not(.dark) .sidebar { background: linear-gradient(180deg, #FFFFFF 0%, #F1F5F9 100%); border-right: 1px solid #E2E8F0; }
        html:not(.dark) .sidebar-link { color: #64748B; }
        html:not(.dark) .sidebar-link:hover { background: rgba(108,60,225,0.08); color: #1E293B; }
        html:not(.dark) .sidebar-link.active { background: rgba(108,60,225,0.1); color: #6C3CE1; border-left-color: #6C3CE1; }
        html:not(.dark) .topbar { background: rgba(255,255,255,0.85); border-bottom: 1px solid #E2E8F0; }
        html:not(.dark) .card { background: #FFFFFF; border: 1px solid #E2E8F0; }
        html:not(.dark) .card:hover { border-color: rgba(108,60,225,0.3); box-shadow: 0 4px 12px rgba(0,0,0,0.06); }
        html:not(.dark) .glass { background: rgba(255,255,255,0.8); border: 1px solid #E2E8F0; }
        html:not(.dark) .glass-solid { background: #FFFFFF; border: 1px solid #E2E8F0; }
        html:not(.dark) .input { background: #F8FAFC; border: 1px solid #CBD5E1; color: #1E293B; }
        html:not(.dark) .input:focus { border-color: #6C3CE1; box-shadow: 0 0 0 3px rgba(108,60,225,0.1); }
        html:not(.dark) .input::placeholder { color: #94A3B8; }
        html:not(.dark) .dropdown-menu { background: #FFFFFF; border: 1px solid #E2E8F0; box-shadow: 0 10px 30px rgba(0,0,0,0.1); }
        html:not(.dark) .btn-secondary { background: #F1F5F9; color: #475569; border: 1px solid #E2E8F0; }
        html:not(.dark) .btn-secondary:hover { background: #E2E8F0; color: #1E293B; }
        html:not(.dark) .btn-danger { background: rgba(239,68,68,0.08); color: #DC2626; border: 1px solid rgba(239,68,68,0.2); }
        html:not(.dark) .badge-purple { background: rgba(108,60,225,0.1); color: #6C3CE1; }
        html:not(.dark) .badge-cyan { background: rgba(34,211,238,0.1); color: #0891B2; }
        html:not(.dark) .badge-emerald { background: rgba(16,185,129,0.1); color: #059669; }
        html:not(.dark) .badge-amber { background: rgba(245,158,11,0.1); color: #D97706; }
        html:not(.dark) .badge-red { background: rgba(239,68,68,0.1); color: #DC2626; }
        html:not(.dark) .stat-card { background: #FFFFFF; }
        html:not(.dark) .progress-bar { background: #E2E8F0; }
        html:not(.dark) ::-webkit-scrollbar-thumb { background: rgba(108,60,225,0.2); }
        html:not(.dark) ::-webkit-scrollbar-thumb:hover { background: rgba(108,60,225,0.4); }
        /* Light mode text helpers */
        html:not(.dark) .text-white { color: #1E293B !important; }
        html:not(.dark) .text-slate-400 { color: #64748B !important; }
        html:not(.dark) .text-slate-300 { color: #475569 !important; }
        html:not(.dark) .text-slate-500 { color: #64748B !important; }
        html:not(.dark) .text-slate-600 { color: #475569 !important; }
        html:not(.dark) .bg-white\/5 { background: rgba(0,0,0,0.03) !important; }
        html:not(.dark) .border-white\/5, html:not(.dark) .border-white\/10 { border-color: #E2E8F0 !important; }
        html:not(.dark) .border-white\/6 { border-color: #E2E8F0 !important; }
    </style>
    <script defer src="https://cdn.jsdelivr.net/npm/alpinejs@3.x.x/dist/cdn.min.js"></script>
    <script src="<?= url('/public/assets/js/app.js') ?>"></script>
</head>
<body>
    <div class="flex h-screen overflow-hidden">
        <!-- ============================================ -->
        <!-- SIDEBAR -->
        <!-- ============================================ -->
        <aside class="sidebar fixed lg:relative z-40 h-full flex flex-col"
               :class="sidebarOpen ? 'w-64' : 'w-20'"
               x-show="sidebarVisible"
               x-transition:enter="slide-in-left">
            
            <!-- Logo -->
            <div class="flex items-center gap-3 px-5 py-5 border-b border-white/5">
                <div class="flex-shrink-0 w-10 h-10 rounded-xl gradient-bg flex items-center justify-center">
                    <i class="fas fa-bolt text-white text-lg"></i>
                </div>
                <div x-show="sidebarOpen" x-transition class="overflow-hidden">
                    <h1 class="text-lg font-bold gradient-text whitespace-nowrap">TSILIZY Nexus</h1>
                    <p class="text-[10px] text-slate-500 whitespace-nowrap">Espace de travail</p>
                </div>
            </div>

            <!-- Navigation -->
            <nav class="flex-1 px-3 py-4 space-y-1 overflow-y-auto">
                <a href="<?= url('/dashboard') ?>" class="sidebar-link flex items-center gap-3 px-3 py-2.5 text-sm <?= is_active('/dashboard') ? 'active' : 'text-slate-400 hover:text-white' ?>">
                    <i class="fas fa-th-large w-5 text-center"></i>
                    <span x-show="sidebarOpen" x-transition class="whitespace-nowrap"><?= __('nav_dashboard') ?></span>
                </a>

                <?php if (!empty($features['tasks'])): ?>
                <a href="<?= url('/tasks') ?>" class="sidebar-link flex items-center gap-3 px-3 py-2.5 text-sm <?= is_active('/tasks') ? 'active' : 'text-slate-400 hover:text-white' ?>">
                    <i class="fas fa-check-circle w-5 text-center"></i>
                    <span x-show="sidebarOpen" x-transition class="whitespace-nowrap"><?= __('nav_tasks') ?></span>
                </a>
                <?php endif; ?>

                <?php if (!empty($features['notes'])): ?>
                <a href="<?= url('/notes') ?>" class="sidebar-link flex items-center gap-3 px-3 py-2.5 text-sm <?= is_active('/notes') ? 'active' : 'text-slate-400 hover:text-white' ?>">
                    <i class="fas fa-sticky-note w-5 text-center"></i>
                    <span x-show="sidebarOpen" x-transition class="whitespace-nowrap"><?= __('nav_notes') ?></span>
                </a>
                <?php endif; ?>

                <?php if (!empty($features['agenda'])): ?>
                <a href="<?= url('/agenda') ?>" class="sidebar-link flex items-center gap-3 px-3 py-2.5 text-sm <?= is_active('/agenda') ? 'active' : 'text-slate-400 hover:text-white' ?>">
                    <i class="fas fa-calendar-alt w-5 text-center"></i>
                    <span x-show="sidebarOpen" x-transition class="whitespace-nowrap"><?= __('nav_agenda') ?></span>
                </a>
                <?php endif; ?>

                <?php if (!empty($features['projects'])): ?>
                <a href="<?= url('/projects') ?>" class="sidebar-link flex items-center gap-3 px-3 py-2.5 text-sm <?= is_active('/projects') ? 'active' : 'text-slate-400 hover:text-white' ?>">
                    <i class="fas fa-project-diagram w-5 text-center"></i>
                    <span x-show="sidebarOpen" x-transition class="whitespace-nowrap"><?= __('nav_projects') ?></span>
                </a>
                <?php endif; ?>

                <?php if (!empty($features['contacts'])): ?>
                <a href="<?= url('/contacts') ?>" class="sidebar-link flex items-center gap-3 px-3 py-2.5 text-sm <?= is_active('/contacts') ? 'active' : 'text-slate-400 hover:text-white' ?>">
                    <i class="fas fa-address-book w-5 text-center"></i>
                    <span x-show="sidebarOpen" x-transition class="whitespace-nowrap"><?= __('nav_contacts') ?></span>
                </a>
                <?php endif; ?>

                <?php if (!empty($features['websites'])): ?>
                <a href="<?= url('/websites') ?>" class="sidebar-link flex items-center gap-3 px-3 py-2.5 text-sm <?= is_active('/websites') ? 'active' : 'text-slate-400 hover:text-white' ?>">
                    <i class="fas fa-globe w-5 text-center"></i>
                    <span x-show="sidebarOpen" x-transition class="whitespace-nowrap"><?= __('nav_websites') ?></span>
                </a>
                <?php endif; ?>

                <?php if (!empty($features['company'])): ?>
                <a href="<?= url('/company') ?>" class="sidebar-link flex items-center gap-3 px-3 py-2.5 text-sm <?= is_active('/company') ? 'active' : 'text-slate-400 hover:text-white' ?>">
                    <i class="fas fa-building w-5 text-center"></i>
                    <span x-show="sidebarOpen" x-transition class="whitespace-nowrap"><?= __('nav_company') ?></span>
                </a>
                <?php endif; ?>

                <!-- Separator -->
                <div class="border-t border-white/5 my-3"></div>

                <?php if (Auth::isAdmin()): ?>
                <a href="<?= url('/admin') ?>" class="sidebar-link flex items-center gap-3 px-3 py-2.5 text-sm <?= is_active('/admin') ? 'active' : 'text-slate-400 hover:text-white' ?>">
                    <i class="fas fa-shield-alt w-5 text-center"></i>
                    <span x-show="sidebarOpen" x-transition class="whitespace-nowrap"><?= __('nav_admin') ?></span>
                </a>
                <?php endif; ?>
            </nav>

            <!-- Sidebar Footer -->
            <div class="px-3 py-4 border-t border-white/5">
                <button @click="sidebarOpen = !sidebarOpen" class="w-full flex items-center justify-center gap-2 px-3 py-2 text-slate-500 hover:text-white rounded-lg transition-colors text-sm">
                    <i :class="sidebarOpen ? 'fas fa-chevron-left' : 'fas fa-chevron-right'" class="text-xs"></i>
                    <span x-show="sidebarOpen" x-transition>Réduire</span>
                </button>
            </div>
        </aside>

        <!-- Mobile overlay -->
        <div x-show="sidebarVisible && window.innerWidth < 1024" @click="sidebarVisible = false"
             class="fixed inset-0 bg-black/50 z-30 lg:hidden" x-transition.opacity></div>

        <!-- ============================================ -->
        <!-- MAIN CONTENT -->
        <!-- ============================================ -->
        <div class="flex-1 flex flex-col overflow-hidden">
            
            <!-- TOPBAR -->
            <header class="topbar sticky top-0 z-20 flex items-center justify-between px-6 py-3">
                <!-- Left -->
                <div class="flex items-center gap-4">
                    <button @click="sidebarVisible = !sidebarVisible" class="lg:hidden text-slate-400 hover:text-white transition-colors">
                        <i class="fas fa-bars text-lg"></i>
                    </button>
                    <button @click="sidebarOpen = !sidebarOpen" class="hidden lg:block text-slate-400 hover:text-white transition-colors">
                        <i class="fas fa-bars text-lg"></i>
                    </button>
                    
                    <!-- Search -->
                    <div class="hidden md:flex items-center gap-2 bg-white/5 border border-white/10 rounded-xl px-4 py-2 w-80 focus-within:border-primary-500/50 transition-colors">
                        <i class="fas fa-search text-slate-500 text-sm"></i>
                        <input type="text" placeholder="Rechercher..." 
                               class="bg-transparent text-sm text-white placeholder-slate-500 outline-none w-full"
                               @keyup.enter="window.location.href='<?= url('/search') ?>?q=' + $event.target.value">
                        <kbd class="hidden lg:inline-block text-[10px] text-slate-600 bg-white/5 px-1.5 py-0.5 rounded">⌘K</kbd>
                    </div>
                </div>

                <!-- Right -->
                <div class="flex items-center gap-3">
                    <!-- Language switcher -->
                    <div class="relative" x-data="{ langOpen: false }" @click.outside="langOpen = false">
                        <button @click="langOpen = !langOpen" class="w-9 h-9 rounded-xl bg-white/5 border border-white/10 flex items-center justify-center text-slate-400 hover:text-white transition-all hover:bg-white/10 text-xs font-bold uppercase">
                            <?= get_locale() ?>
                        </button>
                        <div x-show="langOpen" x-transition class="dropdown-menu absolute right-0 mt-2 w-32 p-1">
                            <a href="<?= url('/lang/fr') ?>" class="flex items-center gap-2 px-3 py-2 text-sm rounded-lg <?= get_locale()==='fr' ? 'text-primary-300 bg-primary-500/10' : 'text-slate-400 hover:text-white hover:bg-white/5' ?>">
                                🇫🇷 Français
                            </a>
                            <a href="<?= url('/lang/en') ?>" class="flex items-center gap-2 px-3 py-2 text-sm rounded-lg <?= get_locale()==='en' ? 'text-primary-300 bg-primary-500/10' : 'text-slate-400 hover:text-white hover:bg-white/5' ?>">
                                🇬🇧 English
                            </a>
                        </div>
                    </div>

                    <!-- Dark mode toggle -->
                    <button @click="darkMode = !darkMode; localStorage.setItem('darkMode', darkMode)" 
                            class="w-9 h-9 rounded-xl bg-white/5 border border-white/10 flex items-center justify-center text-slate-400 hover:text-white transition-all hover:bg-white/10">
                        <i :class="darkMode ? 'fas fa-sun text-amber-400' : 'fas fa-moon'"></i>
                    </button>

                    <!-- Notifications -->
                    <div class="relative" x-data="{ open: false, notifications: [], loading: false }" @click.outside="open = false">
                        <button @click="open = !open; if(open) { loading = true; window.fetchNotifs?.().then(n => { notifications = n; loading = false; }).catch(() => { loading = false; }) }" class="relative w-9 h-9 rounded-xl bg-white/5 border border-white/10 flex items-center justify-center text-slate-400 hover:text-white transition-all hover:bg-white/10">
                            <i class="fas fa-bell"></i>
                            <span class="notif-dot" x-show="unreadNotifs > 0"></span>
                        </button>
                        <div x-show="open" x-transition
                             class="dropdown-menu absolute right-0 mt-2 w-80 max-h-96 overflow-y-auto p-2">
                            <div class="flex items-center justify-between px-3 py-2">
                                <span class="text-sm font-semibold text-white">Notifications</span>
                                <a href="<?= url('/notifications') ?>" class="text-xs text-accent-400 hover:text-accent-300">Tout voir</a>
                            </div>
                            <template x-if="loading">
                                <div class="text-center py-6"><i class="fas fa-circle-notch fa-spin text-slate-500"></i></div>
                            </template>
                            <template x-if="!loading && notifications.length === 0">
                                <div class="text-center py-8 text-sm text-slate-500">
                                    <i class="fas fa-bell-slash text-2xl mb-2 block"></i>
                                    Aucune notification
                                </div>
                            </template>
                            <template x-for="n in notifications" :key="n.id">
                                <a :href="n.link || '<?= url('/notifications') ?>'" class="block px-3 py-2.5 rounded-lg hover:bg-white/5 transition-colors" :class="n.is_read == 0 ? 'bg-primary-500/5' : ''">
                                    <div class="flex items-start gap-3">
                                        <div class="w-8 h-8 rounded-lg bg-primary-500/15 flex items-center justify-center flex-shrink-0 mt-0.5">
                                            <i :class="'fas fa-' + (n.icon || 'bell')" class="text-primary-400 text-xs"></i>
                                        </div>
                                        <div class="flex-1 min-w-0">
                                            <p class="text-sm font-medium text-white truncate" x-text="n.title"></p>
                                            <p class="text-xs text-slate-500 truncate" x-text="n.message || ''"></p>
                                        </div>
                                        <span x-show="n.is_read == 0" class="w-2 h-2 rounded-full bg-primary-400 mt-2 flex-shrink-0"></span>
                                    </div>
                                </a>
                            </template>
                        </div>
                    </div>

                    <!-- Profile -->
                    <div class="relative" x-data="{ open: false }">
                        <button @click="open = !open" class="flex items-center gap-3 hover:bg-white/5 rounded-xl px-3 py-1.5 transition-colors">
                            <div class="w-8 h-8 rounded-lg gradient-bg flex items-center justify-center text-white text-sm font-bold">
                                <?= strtoupper(substr($auth['name'] ?? 'U', 0, 1)) ?>
                            </div>
                            <div class="hidden md:block text-left">
                                <p class="text-sm font-medium text-white"><?= e($auth['name'] ?? 'Utilisateur') ?></p>
                                <p class="text-[10px] text-slate-500"><?= e(ucfirst(str_replace('_', ' ', $auth['role'] ?? 'user'))) ?></p>
                            </div>
                            <i class="fas fa-chevron-down text-[10px] text-slate-500 hidden md:inline"></i>
                        </button>
                        <div x-show="open" @click.outside="open = false" x-transition
                             class="dropdown-menu absolute right-0 mt-2 w-56 p-2">
                            <a href="<?= url('/profile') ?>" class="flex items-center gap-3 px-3 py-2 text-sm text-slate-400 hover:text-white hover:bg-white/5 rounded-lg transition-colors">
                                <i class="fas fa-user w-4"></i> Mon profil
                            </a>
                            <a href="<?= url('/plans') ?>" class="flex items-center gap-3 px-3 py-2 text-sm text-slate-400 hover:text-white hover:bg-white/5 rounded-lg transition-colors">
                                <i class="fas fa-crown w-4"></i> Mon plan
                            </a>
                            <div class="border-t border-white/5 my-1"></div>
                            <a href="<?= url('/logout') ?>" class="flex items-center gap-3 px-3 py-2 text-sm text-red-400 hover:text-red-300 hover:bg-red-500/5 rounded-lg transition-colors">
                                <i class="fas fa-sign-out-alt w-4"></i> <?= __('logout') ?>
                            </a>
                        </div>
                    </div>
                </div>
            </header>

            <!-- Toast Notifications -->
            <?php if ($flashSuccess || $flashError || $flashInfo): ?>
            <div x-data="{ show: true }" x-show="show" x-init="setTimeout(() => show = false, 5000)"
                 x-transition class="mx-6 mt-4">
                <?php if ($flashSuccess): ?>
                <div class="flex items-center gap-3 bg-emerald-500/10 border border-emerald-500/20 rounded-xl px-4 py-3 text-emerald-400 text-sm">
                    <i class="fas fa-check-circle"></i><span><?= $flashSuccess ?></span>
                    <button @click="show = false" class="ml-auto text-emerald-500/50 hover:text-emerald-400"><i class="fas fa-times"></i></button>
                </div>
                <?php elseif ($flashError): ?>
                <div class="flex items-center gap-3 bg-red-500/10 border border-red-500/20 rounded-xl px-4 py-3 text-red-400 text-sm">
                    <i class="fas fa-exclamation-circle"></i><span><?= $flashError ?></span>
                    <button @click="show = false" class="ml-auto text-red-500/50 hover:text-red-400"><i class="fas fa-times"></i></button>
                </div>
                <?php elseif ($flashInfo): ?>
                <div class="flex items-center gap-3 bg-accent-500/10 border border-accent-500/20 rounded-xl px-4 py-3 text-accent-400 text-sm">
                    <i class="fas fa-info-circle"></i><span><?= $flashInfo ?></span>
                    <button @click="show = false" class="ml-auto text-accent-500/50 hover:text-accent-400"><i class="fas fa-times"></i></button>
                </div>
                <?php endif; ?>
            </div>
            <?php endif; ?>

            <!-- PAGE CONTENT -->
            <main class="flex-1 overflow-y-auto p-6 fade-in">
                <?= $content ?>
            </main>
        </div>
    </div>

    <script>
    function appState() {
        return {
            sidebarOpen: window.innerWidth >= 1024,
            sidebarVisible: window.innerWidth >= 1024,
            darkMode: localStorage.getItem('darkMode') !== 'false',
            unreadNotifs: 0,
            init() {
                this.fetchNotifications();
                setInterval(() => this.fetchNotifications(), 60000);
                window.addEventListener('resize', () => {
                    this.sidebarVisible = window.innerWidth >= 1024;
                });
                // Expose fetchNotifs globally for notification dropdown
                window.fetchNotifs = async function() {
                    try {
                        const res = await fetch('<?= url('/notifications/recent') ?>');
                        const data = await res.json();
                        return data.notifications || [];
                    } catch(e) { return []; }
                };
            },
            async fetchNotifications() {
                try {
                    const res = await fetch('<?= url('/notifications/unread-count') ?>');
                    const data = await res.json();
                    this.unreadNotifs = data.count || 0;
                } catch(e) {}
            }
        }
    }
    </script>
</body>
</html>
