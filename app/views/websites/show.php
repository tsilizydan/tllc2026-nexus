<?php $pageTitle = $website['name'] ?? 'Site web'; ?>
<div class="max-w-3xl mx-auto">
    <div class="flex items-center gap-3 mb-6">
        <a href="<?= url('/websites') ?>" class="text-slate-400 hover:text-white"><i class="fas fa-arrow-left"></i></a>
        <div class="w-10 h-10 rounded-xl bg-accent-400/15 flex items-center justify-center text-accent-400"><i class="fas fa-globe text-lg"></i></div>
        <div class="flex-1"><h1 class="text-xl font-bold text-white"><?= e($website['name']) ?></h1>
        <?php if ($website['url']): ?><a href="<?= e($website['url']) ?>" target="_blank" class="text-sm text-accent-400 hover:underline"><?= e($website['url']) ?> <i class="fas fa-external-link-alt text-xs"></i></a><?php endif; ?></div>
        <a href="<?= url('/websites/'.$website['id'].'/edit') ?>" class="btn-secondary text-sm"><i class="fas fa-edit mr-1"></i>Modifier</a>
    </div>
    <div class="card p-6">
        <div class="grid grid-cols-2 gap-4 text-sm">
            <div><span class="text-slate-500">Statut</span><p class="mt-1"><span class="badge <?= ($website['status']??'')=='active'?'badge-emerald':'badge-amber' ?>"><?= ($website['status']??'')==='active'?'Actif':'Inactif' ?></span></p></div>
            <div><span class="text-slate-500">Catégorie</span><p class="text-white mt-1"><?= e($website['category'] ?? '—') ?></p></div>
            <div><span class="text-slate-500">Email</span><p class="text-white mt-1"><?= $website['email'] ? '<a href="mailto:'.e($website['email']).'" class="text-accent-400">'.e($website['email']).'</a>' : '—' ?></p></div>
            <div><span class="text-slate-500">Propriétaire</span><p class="text-white mt-1"><?= e($website['owner'] ?? '—') ?></p></div>
            <?php if ($website['description']): ?><div class="col-span-2"><span class="text-slate-500">Description</span><p class="text-slate-300 mt-1"><?= nl2br(e($website['description'])) ?></p></div><?php endif; ?>
            <?php if ($website['notes']): ?><div class="col-span-2"><span class="text-slate-500">Notes</span><p class="text-slate-300 mt-1"><?= nl2br(e($website['notes'])) ?></p></div><?php endif; ?>
        </div>
    </div>
</div>
