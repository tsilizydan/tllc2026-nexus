<?php $pageTitle = $project['name'] ?? 'Projet'; ?>
<div class="flex items-center gap-3 mb-6">
    <a href="<?= url('/projects') ?>" class="text-slate-400 hover:text-white"><i class="fas fa-arrow-left"></i></a>
    <div class="w-10 h-10 rounded-xl flex items-center justify-center" style="background:<?= e($project['color']??'#6C3CE1') ?>20;color:<?= e($project['color']??'#6C3CE1') ?>"><i class="fas fa-folder text-lg"></i></div>
    <div class="flex-1"><h1 class="text-xl font-bold text-white"><?= e($project['name']) ?></h1><p class="text-sm text-slate-400"><?= e(mb_strimwidth($project['description']??'', 0, 100, '...')) ?></p></div>
    <a href="<?= url('/projects/'.$project['id'].'/edit') ?>" class="btn-secondary text-sm"><i class="fas fa-edit mr-1"></i>Modifier</a>
</div>

<!-- Progress -->
<div class="card p-5 mb-6">
    <div class="flex items-center justify-between mb-2"><span class="text-sm text-slate-400">Progression</span><span class="text-sm font-bold text-white"><?= $project['progress'] ?? 0 ?>%</span></div>
    <div class="progress-bar h-3"><div class="progress-fill" style="width:<?= $project['progress']??0 ?>%;background:<?= e($project['color']??'#6C3CE1') ?>"></div></div>
</div>

<!-- Kanban -->
<h2 class="text-lg font-semibold text-white mb-4"><i class="fas fa-tasks text-primary-400 mr-2"></i>Tâches du projet</h2>
<div class="grid grid-cols-1 md:grid-cols-3 gap-5 mb-8">
    <?php foreach (['todo'=>['À faire','slate'],'in_progress'=>['En cours','amber'],'done'=>['Terminé','emerald']] as $status => [$label, $color]): ?>
    <div class="glass rounded-2xl p-4">
        <div class="flex items-center gap-2 mb-4"><div class="w-2 h-2 rounded-full bg-<?= $color ?>-500"></div><h3 class="text-sm font-semibold text-white"><?= $label ?></h3><span class="badge badge-<?= $color ?> text-xs"><?= count($kanban[$status]??[]) ?></span></div>
        <div class="space-y-3 min-h-[60px]">
            <?php foreach ($kanban[$status] ?? [] as $t): ?>
            <a href="<?= url('/tasks/'.$t['id']) ?>" class="card p-3 block hover:border-primary-500/30">
                <p class="text-sm text-white font-medium"><?= e($t['title']) ?></p>
                <?php if ($t['due_date']): ?><p class="text-[10px] text-slate-500 mt-1"><i class="fas fa-clock mr-1"></i><?= format_date($t['due_date']) ?></p><?php endif; ?>
            </a>
            <?php endforeach; ?>
        </div>
    </div>
    <?php endforeach; ?>
</div>

<!-- Milestones -->
<?php if (!empty($milestones)): ?>
<h2 class="text-lg font-semibold text-white mb-4"><i class="fas fa-flag text-accent-400 mr-2"></i>Jalons</h2>
<div class="space-y-3">
    <?php foreach ($milestones as $m): ?>
    <div class="card p-4 flex items-center gap-4">
        <div class="w-8 h-8 rounded-lg bg-accent-400/15 flex items-center justify-center text-accent-400"><i class="fas fa-flag"></i></div>
        <div class="flex-1"><p class="text-sm font-medium text-white"><?= e($m['title']) ?></p><?php if ($m['due_date']): ?><p class="text-xs text-slate-500"><?= format_date($m['due_date']) ?></p><?php endif; ?></div>
    </div>
    <?php endforeach; ?>
</div>
<?php endif; ?>
