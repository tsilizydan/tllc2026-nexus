<?php $pageTitle = __('websites'); ?>
<div class="flex items-center justify-between mb-6">
    <h1 class="text-2xl font-bold text-white"><i class="fas fa-globe text-accent-400 mr-3"></i><?= __('websites') ?></h1>
    <a href="<?= url('/websites/create') ?>" class="btn-primary inline-flex items-center gap-2 text-sm"><i class="fas fa-plus"></i>Nouveau site</a>
</div>
<?php if (empty($websites)): ?>
<div class="card p-12 text-center"><i class="fas fa-globe text-5xl text-accent-400/30 mb-4 block"></i><p class="text-slate-400">Aucun site web enregistré</p></div>
<?php else: ?>
<div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-5">
    <?php foreach ($websites as $w): ?>
    <a href="<?= url('/websites/'.$w['id']) ?>" class="card p-5 group hover:border-accent-400/30">
        <div class="flex items-start justify-between mb-3">
            <div class="w-10 h-10 rounded-xl bg-accent-400/15 flex items-center justify-center text-accent-400"><i class="fas fa-globe"></i></div>
            <span class="badge <?= ($w['status']??'')=='active'?'badge-emerald':'badge-amber' ?>"><?= ($w['status']??'')==='active'?'Actif':'Inactif' ?></span>
        </div>
        <h3 class="text-sm font-semibold text-white group-hover:text-accent-400 transition-colors"><?= e($w['name']) ?></h3>
        <p class="text-xs text-slate-500 mt-1 truncate"><?= e($w['url'] ?? '—') ?></p>
        <?php if ($w['category']): ?><span class="badge badge-purple text-[10px] mt-2"><?= e($w['category']) ?></span><?php endif; ?>
    </a>
    <?php endforeach; ?>
</div>
<?php endif; ?>
