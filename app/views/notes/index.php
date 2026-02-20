<?php $pageTitle = __('notes'); ?>
<div class="flex items-center justify-between mb-6">
    <h1 class="text-2xl font-bold text-white"><i class="fas fa-sticky-note text-primary-400 mr-3"></i><?= __('notes') ?></h1>
    <a href="<?= url('/notes/create') ?>" class="btn-primary inline-flex items-center gap-2 text-sm"><i class="fas fa-plus"></i>Nouvelle note</a>
</div>
<?php if (empty($notes)): ?>
<div class="card p-12 text-center"><i class="fas fa-sticky-note text-5xl text-primary-400/30 mb-4 block"></i><p class="text-slate-400">Aucune note. Créez-en une !</p></div>
<?php else: ?>
<div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-3 gap-4">
    <?php foreach ($notes as $n): ?>
    <a href="<?= url('/notes/'.$n['id']) ?>" class="card p-5 hover:border-primary-500/30">
        <span class="text-2xl mb-2 block"><?= e($n['icon'] ?? '📝') ?></span>
        <h3 class="text-sm font-semibold text-white mb-1"><?= e($n['title']) ?></h3>
        <p class="text-xs text-slate-500"><?= e(mb_strimwidth(strip_tags($n['content'] ?? ''), 0, 80, '...')) ?></p>
        <p class="text-[10px] text-slate-600 mt-3"><?= format_date($n['updated_at'] ?? $n['created_at']) ?></p>
    </a>
    <?php endforeach; ?>
</div>
<?php endif; ?>
