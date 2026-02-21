<?php $pageTitle = __('projects'); ?>
<div class="flex items-center justify-between mb-6">
    <h1 class="text-2xl font-bold text-white"><i class="fas fa-project-diagram text-primary-400 mr-3"></i><?= __('projects') ?></h1>
    <a href="<?= url('/projects/create') ?>" class="btn-primary inline-flex items-center gap-2 text-sm"><i class="fas fa-plus"></i>Nouveau projet</a>
</div>
<?php if (empty($projects)): ?>
<div class="card p-12 text-center"><i class="fas fa-folder-open text-5xl text-primary-400/30 mb-4 block"></i><p class="text-slate-400">Aucun projet. Créez-en un !</p><a href="<?= url('/projects/create') ?>" class="btn-primary inline-flex items-center gap-2 mt-4 text-sm"><i class="fas fa-plus"></i>Nouveau projet</a></div>
<?php else: ?>
<div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-5">
    <?php foreach ($projects as $p): ?>
    <a href="<?= url('/projects/'.$p['id']) ?>" class="card p-5 hover:border-primary-500/30 group">
        <div class="flex items-start justify-between mb-3">
            <div class="w-10 h-10 rounded-xl flex items-center justify-center text-lg" style="background:<?= e($p['color']??'#6C3CE1') ?>20;color:<?= e($p['color']??'#6C3CE1') ?>">
                <i class="fas fa-folder"></i>
            </div>
            <span class="badge <?= match($p['status']??''){'active'=>'badge-emerald','completed'=>'badge-cyan','on_hold'=>'badge-amber',default=>'badge-purple'} ?>"><?= match($p['status']??''){'active'=>'Actif','completed'=>'Terminé','on_hold'=>'En pause',default=>'Planification'} ?></span>
        </div>
        <h3 class="text-base font-semibold text-white group-hover:text-accent-400 transition-colors mb-1"><?= e($p['name']) ?></h3>
        <p class="text-xs text-slate-500 mb-4"><?= e(mb_strimwidth($p['description']??'', 0, 80, '...')) ?></p>
        <div class="flex items-center justify-between text-xs text-slate-500 mb-2">
            <span><i class="fas fa-check mr-1"></i><?= $p['done_count'] ?? 0 ?>/<?= $p['task_count'] ?? 0 ?> tâches</span>
            <span><?= $p['progress'] ?? 0 ?>%</span>
        </div>
        <div class="progress-bar"><div class="progress-fill" style="width:<?= $p['progress']??0 ?>%;background:<?= e($p['color']??'#6C3CE1') ?>"></div></div>
    </a>
    <?php endforeach; ?>
</div>
<?php endif; ?>
