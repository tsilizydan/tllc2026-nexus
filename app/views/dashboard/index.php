<?php $pageTitle = __('dashboard'); ?>

<!-- Welcome Banner -->
<div class="mb-8">
    <h1 class="text-2xl font-bold text-white">Bonjour, <?= e($auth['name'] ?? 'Utilisateur') ?> 👋</h1>
    <p class="text-slate-400 text-sm mt-1">Voici un résumé de votre activité</p>
</div>

<!-- Stats Grid -->
<div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-4 gap-5 mb-8">
    <!-- Tasks -->
    <div class="card stat-card purple p-5">
        <div class="flex items-center justify-between mb-3">
            <div class="w-10 h-10 rounded-xl bg-primary-500/15 flex items-center justify-center">
                <i class="fas fa-check-circle text-primary-400"></i>
            </div>
            <span class="badge badge-purple"><?= $doneTasks ?>/<?= $totalTasks ?></span>
        </div>
        <h3 class="text-2xl font-bold text-white"><?= $totalTasks ?></h3>
        <p class="text-sm text-slate-400 mt-1">Tâches totales</p>
        <div class="progress-bar mt-3">
            <div class="progress-fill gradient-bg" style="width: <?= $totalTasks > 0 ? round($doneTasks / $totalTasks * 100) : 0 ?>%"></div>
        </div>
    </div>

    <!-- Projects -->
    <div class="card stat-card cyan p-5">
        <div class="flex items-center justify-between mb-3">
            <div class="w-10 h-10 rounded-xl bg-accent-400/15 flex items-center justify-center">
                <i class="fas fa-project-diagram text-accent-400"></i>
            </div>
            <span class="badge badge-cyan"><?= $activeProjects ?> actifs</span>
        </div>
        <h3 class="text-2xl font-bold text-white"><?= $totalProjects ?></h3>
        <p class="text-sm text-slate-400 mt-1">Projets</p>
    </div>

    <!-- Contacts -->
    <div class="card stat-card emerald p-5">
        <div class="flex items-center justify-between mb-3">
            <div class="w-10 h-10 rounded-xl bg-emerald-500/15 flex items-center justify-center">
                <i class="fas fa-address-book text-emerald-400"></i>
            </div>
        </div>
        <h3 class="text-2xl font-bold text-white"><?= $totalContacts ?></h3>
        <p class="text-sm text-slate-400 mt-1">Contacts</p>
    </div>

    <!-- Notes -->
    <div class="card stat-card amber p-5">
        <div class="flex items-center justify-between mb-3">
            <div class="w-10 h-10 rounded-xl bg-amber-500/15 flex items-center justify-center">
                <i class="fas fa-sticky-note text-amber-400"></i>
            </div>
        </div>
        <h3 class="text-2xl font-bold text-white"><?= $totalNotes ?></h3>
        <p class="text-sm text-slate-400 mt-1">Notes</p>
    </div>
</div>

<!-- Main Content Grid -->
<div class="grid grid-cols-1 lg:grid-cols-3 gap-6">
    <!-- Recent Tasks (2 columns) -->
    <div class="lg:col-span-2 card p-6">
        <div class="flex items-center justify-between mb-5">
            <h2 class="text-lg font-semibold text-white">
                <i class="fas fa-tasks text-primary-400 mr-2"></i>Tâches récentes
            </h2>
            <a href="<?= url('/tasks') ?>" class="text-sm text-accent-400 hover:text-accent-300 transition-colors">
                Tout voir <i class="fas fa-arrow-right ml-1 text-xs"></i>
            </a>
        </div>

        <?php if (empty($recentTasks)): ?>
        <div class="text-center py-10 text-slate-500">
            <i class="fas fa-inbox text-4xl mb-3 block opacity-50"></i>
            <p>Aucune tâche pour le moment</p>
            <a href="<?= url('/tasks/create') ?>" class="btn-primary inline-flex items-center gap-2 mt-4 text-sm">
                <i class="fas fa-plus"></i> Créer une tâche
            </a>
        </div>
        <?php else: ?>
        <div class="space-y-3">
            <?php foreach ($recentTasks as $task): ?>
            <div class="flex items-center gap-4 p-3 rounded-xl hover:bg-white/5 transition-colors group">
                <div class="w-3 h-3 rounded-full flex-shrink-0 <?php
                    echo match($task['status']) {
                        'done' => 'bg-emerald-500',
                        'in_progress' => 'bg-amber-500',
                        default => 'bg-slate-500'
                    };
                ?>"></div>
                <div class="flex-1 min-w-0">
                    <a href="<?= url('/tasks/' . $task['id']) ?>" class="text-sm font-medium text-white hover:text-accent-400 transition-colors truncate block">
                        <?= e($task['title']) ?>
                    </a>
                    <p class="text-xs text-slate-500 mt-0.5">
                        <?= $task['due_date'] ? format_date($task['due_date']) : 'Sans échéance' ?>
                    </p>
                </div>
                <span class="badge <?php
                    echo match($task['priority']) {
                        'urgent' => 'badge-red',
                        'high' => 'badge-amber',
                        'medium' => 'badge-purple',
                        default => 'badge-cyan'
                    };
                ?>"><?php
                    echo match($task['priority']) {
                        'urgent' => 'Urgente',
                        'high' => 'Haute',
                        'medium' => 'Moyenne',
                        default => 'Basse'
                    };
                ?></span>
            </div>
            <?php endforeach; ?>
        </div>
        <?php endif; ?>
    </div>

    <!-- Sidebar Column -->
    <div class="space-y-6">
        <!-- Task Status Summary -->
        <div class="card p-6">
            <h3 class="text-sm font-semibold text-white mb-4">Résumé des tâches</h3>
            <div class="space-y-3">
                <div class="flex items-center justify-between">
                    <div class="flex items-center gap-2">
                        <div class="w-2 h-2 rounded-full bg-slate-500"></div>
                        <span class="text-sm text-slate-400">À faire</span>
                    </div>
                    <span class="text-sm font-semibold text-white"><?= $todoTasks ?></span>
                </div>
                <div class="flex items-center justify-between">
                    <div class="flex items-center gap-2">
                        <div class="w-2 h-2 rounded-full bg-amber-500"></div>
                        <span class="text-sm text-slate-400">En cours</span>
                    </div>
                    <span class="text-sm font-semibold text-white"><?= $inProgressTasks ?></span>
                </div>
                <div class="flex items-center justify-between">
                    <div class="flex items-center gap-2">
                        <div class="w-2 h-2 rounded-full bg-emerald-500"></div>
                        <span class="text-sm text-slate-400">Terminées</span>
                    </div>
                    <span class="text-sm font-semibold text-white"><?= $doneTasks ?></span>
                </div>
            </div>
        </div>

        <!-- Upcoming Events -->
        <div class="card p-6">
            <div class="flex items-center justify-between mb-4">
                <h3 class="text-sm font-semibold text-white">
                    <i class="fas fa-calendar text-accent-400 mr-2"></i>Événements à venir
                </h3>
                <a href="<?= url('/agenda') ?>" class="text-xs text-accent-400 hover:text-accent-300">Voir tout</a>
            </div>
            <?php if (empty($upcomingEvents)): ?>
            <p class="text-sm text-slate-500 text-center py-4">Aucun événement prévu</p>
            <?php else: ?>
            <div class="space-y-3">
                <?php foreach ($upcomingEvents as $event): ?>
                <div class="flex items-start gap-3 p-2 rounded-lg hover:bg-white/5 transition-colors">
                    <div class="w-1 h-8 rounded-full flex-shrink-0" style="background-color: <?= e($event['color']) ?>"></div>
                    <div>
                        <p class="text-sm text-white font-medium"><?= e($event['title']) ?></p>
                        <p class="text-xs text-slate-500"><?= format_date($event['start_date'], 'd/m — H:i') ?></p>
                    </div>
                </div>
                <?php endforeach; ?>
            </div>
            <?php endif; ?>
        </div>

        <!-- Active Projects -->
        <div class="card p-6">
            <div class="flex items-center justify-between mb-4">
                <h3 class="text-sm font-semibold text-white">
                    <i class="fas fa-folder text-primary-400 mr-2"></i>Projets actifs
                </h3>
                <a href="<?= url('/projects') ?>" class="text-xs text-accent-400 hover:text-accent-300">Voir tout</a>
            </div>
            <?php if (empty($projects)): ?>
            <p class="text-sm text-slate-500 text-center py-4">Aucun projet actif</p>
            <?php else: ?>
            <div class="space-y-3">
                <?php foreach ($projects as $proj): ?>
                <a href="<?= url('/projects/' . $proj['id']) ?>" class="block p-3 rounded-lg hover:bg-white/5 transition-colors">
                    <div class="flex items-center justify-between mb-2">
                        <span class="text-sm font-medium text-white"><?= e($proj['name']) ?></span>
                        <span class="text-xs text-slate-500"><?= $proj['progress'] ?>%</span>
                    </div>
                    <div class="progress-bar">
                        <div class="progress-fill" style="width: <?= $proj['progress'] ?>%; background-color: <?= e($proj['color']) ?>"></div>
                    </div>
                </a>
                <?php endforeach; ?>
            </div>
            <?php endif; ?>
        </div>
    </div>
</div>

<!-- Quick Actions FAB (Mobile) -->
<div class="fixed bottom-6 right-6 lg:hidden" x-data="{ open: false }">
    <div x-show="open" x-transition class="absolute bottom-16 right-0 space-y-2 mb-2">
        <a href="<?= url('/tasks/create') ?>" class="flex items-center gap-2 bg-surface-card border border-white/10 rounded-xl px-4 py-2 text-sm text-white shadow-lg whitespace-nowrap">
            <i class="fas fa-check-circle text-primary-400"></i> Nouvelle tâche
        </a>
        <a href="<?= url('/notes/create') ?>" class="flex items-center gap-2 bg-surface-card border border-white/10 rounded-xl px-4 py-2 text-sm text-white shadow-lg whitespace-nowrap">
            <i class="fas fa-sticky-note text-accent-400"></i> Nouvelle note
        </a>
        <a href="<?= url('/contacts/create') ?>" class="flex items-center gap-2 bg-surface-card border border-white/10 rounded-xl px-4 py-2 text-sm text-white shadow-lg whitespace-nowrap">
            <i class="fas fa-user-plus text-emerald-400"></i> Nouveau contact
        </a>
    </div>
    <button @click="open = !open" class="w-14 h-14 rounded-2xl gradient-bg flex items-center justify-center text-white text-xl shadow-lg shadow-primary-500/30 transition-transform"
            :class="open ? 'rotate-45' : ''">
        <i class="fas fa-plus"></i>
    </button>
</div>
