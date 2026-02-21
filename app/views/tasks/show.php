<?php $pageTitle = $task['title'] ?? 'Tâche'; ?>
<div class="max-w-3xl mx-auto">
    <div class="flex items-center gap-3 mb-6">
        <a href="<?= url('/tasks') ?>" class="text-slate-400 hover:text-white"><i class="fas fa-arrow-left"></i></a>
        <h1 class="text-xl font-bold text-white flex-1"><?= e($task['title']) ?></h1>
        <a href="<?= url('/tasks/'.$task['id'].'/edit') ?>" class="btn-secondary text-sm"><i class="fas fa-edit mr-1"></i>Modifier</a>
    </div>
    <div class="card p-6">
        <div class="flex flex-wrap gap-3 mb-5">
            <span class="badge <?= match($task['status']){'done'=>'badge-emerald','in_progress'=>'badge-amber',default=>'badge-purple'} ?>"><?= match($task['status']){'done'=>'Terminé','in_progress'=>'En cours',default=>'À faire'} ?></span>
            <span class="badge <?= match($task['priority']??''){'urgent'=>'badge-red','high'=>'badge-amber','medium'=>'badge-purple',default=>'badge-cyan'} ?>"><?= match($task['priority']??''){'urgent'=>'Urgente','high'=>'Haute','medium'=>'Moyenne',default=>'Basse'} ?></span>
            <?php if (!empty($task['labels'])): foreach ($task['labels'] as $l): ?>
            <span class="badge text-xs" style="background:<?= e($l['color']) ?>20;color:<?= e($l['color']) ?>"><?= e($l['name']) ?></span>
            <?php endforeach; endif; ?>
        </div>
        <?php if ($task['description']): ?>
        <div class="prose prose-invert text-slate-300 text-sm mb-5"><?= nl2br(e($task['description'])) ?></div>
        <?php endif; ?>
        <div class="grid grid-cols-2 gap-4 text-sm border-t border-white/5 pt-4">
            <div><span class="text-slate-500">Échéance:</span> <span class="text-white"><?= $task['due_date'] ? format_date($task['due_date']) : '—' ?></span></div>
            <div><span class="text-slate-500">Créée:</span> <span class="text-white"><?= format_date($task['created_at']) ?></span></div>
            <?php if ($task['completed_at']): ?><div><span class="text-slate-500">Terminée:</span> <span class="text-emerald-400"><?= format_date($task['completed_at']) ?></span></div><?php endif; ?>
        </div>
        <div class="mt-6 pt-4 border-t border-white/5 flex gap-3">
            <form method="POST" action="<?= url('/tasks/'.$task['id'].'/delete') ?>" onsubmit="return confirm('Supprimer cette tâche ?')">
                <?= csrf_field() ?><button type="submit" class="btn-danger text-sm"><i class="fas fa-trash mr-1"></i>Supprimer</button>
            </form>
        </div>
    </div>
</div>
