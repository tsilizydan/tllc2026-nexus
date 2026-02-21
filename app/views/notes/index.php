<?php $pageTitle = __('notes'); ?>
<div class="flex flex-col sm:flex-row items-start sm:items-center justify-between mb-6 gap-3">
    <h1 class="text-2xl font-bold text-white"><i class="fas fa-sticky-note text-primary-400 mr-3"></i><?= __('notes') ?></h1>
    <div class="flex items-center gap-3">
        <div class="relative" x-data="{ q: '' }">
            <i class="fas fa-search absolute left-3 top-1/2 -translate-y-1/2 text-slate-500 text-xs"></i>
            <input type="text" x-model="q" @input="
                document.querySelectorAll('.note-card').forEach(el => {
                    el.style.display = el.textContent.toLowerCase().includes(q.toLowerCase()) ? '' : 'none';
                });
            " placeholder="<?= __('search') ?>..." class="input pl-9 text-sm w-48">
        </div>
        <a href="<?= url('/notes/create') ?>" class="btn-primary inline-flex items-center gap-2 text-sm"><i class="fas fa-plus"></i><?= __('new_note') ?></a>
    </div>
</div>
<?php if (empty($notes)): ?>
<div class="card p-12 text-center">
    <i class="fas fa-sticky-note text-5xl text-primary-400/30 mb-4 block"></i>
    <p class="text-slate-400 mb-4"><?= __('no_results') ?></p>
    <a href="<?= url('/notes/create') ?>" class="btn-primary inline-flex items-center gap-2"><i class="fas fa-plus"></i><?= __('new_note') ?></a>
</div>
<?php else: ?>
<div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-3 xl:grid-cols-4 gap-4">
    <?php foreach ($notes as $n): ?>
    <a href="<?= url('/notes/'.$n['id']) ?>" class="note-card card p-5 hover:border-primary-500/30 group transition-all duration-300">
        <div class="flex items-center gap-2 mb-3">
            <span class="text-xl"><?= e($n['icon'] ?? '📝') ?></span>
            <h3 class="text-sm font-semibold text-white group-hover:text-primary-300 transition-colors truncate flex-1"><?= e($n['title']) ?></h3>
        </div>
        <p class="text-xs text-slate-500 leading-relaxed line-clamp-3 mb-3"><?= e(mb_strimwidth(strip_tags($n['content'] ?? ''), 0, 120, '...')) ?></p>
        <div class="flex items-center justify-between">
            <p class="text-[10px] text-slate-600"><?= format_date($n['updated_at'] ?? $n['created_at']) ?></p>
            <?php if (!empty($n['children'])): ?>
            <span class="text-[10px] px-2 py-0.5 rounded-full bg-primary-500/10 text-primary-400"><?= count($n['children']) ?> sub</span>
            <?php endif; ?>
        </div>
    </a>
    <?php endforeach; ?>
</div>
<?php endif; ?>
