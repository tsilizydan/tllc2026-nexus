<?php $pageTitle = __('notifications'); ?>
<div class="max-w-3xl mx-auto">
    <div class="flex items-center justify-between mb-6">
        <h1 class="text-2xl font-bold text-white"><i class="fas fa-bell text-accent-400 mr-3"></i><?= __('notifications') ?></h1>
        <form method="POST" action="<?= url('/notifications/read-all') ?>"><?= csrf_field() ?><button type="submit" class="btn-secondary text-sm">Tout marquer comme lu</button></form>
    </div>
    <?php if (empty($notifications)): ?>
    <div class="card p-12 text-center"><i class="fas fa-bell-slash text-5xl text-slate-600 mb-4 block"></i><p class="text-slate-400">Aucune notification</p></div>
    <?php else: ?>
    <div class="space-y-2">
        <?php foreach ($notifications as $n): ?>
        <div class="card p-4 flex items-start gap-4 <?= $n['is_read'] ? 'opacity-60' : '' ?>">
            <div class="w-9 h-9 rounded-xl flex-shrink-0 flex items-center justify-center <?= $n['is_read'] ? 'bg-white/5' : 'bg-primary-500/15' ?>">
                <i class="fas fa-<?= e($n['icon']??'bell') ?> <?= $n['is_read'] ? 'text-slate-500' : 'text-primary-400' ?>"></i>
            </div>
            <div class="flex-1 min-w-0">
                <?php if ($n['link']): ?><a href="<?= url($n['link']) ?>" class="text-sm font-medium text-white hover:text-accent-400 block"><?= e($n['title']) ?></a>
                <?php else: ?><p class="text-sm font-medium text-white"><?= e($n['title']) ?></p><?php endif; ?>
                <?php if ($n['message']): ?><p class="text-xs text-slate-400 mt-0.5"><?= e($n['message']) ?></p><?php endif; ?>
                <p class="text-[10px] text-slate-600 mt-1"><?= format_date($n['created_at']) ?></p>
            </div>
            <?php if (!$n['is_read']): ?>
            <button onclick="fetch('<?= url('/notifications/'.$n['id'].'/read') ?>',{method:'POST'}).then(()=>this.parentElement.classList.add('opacity-60'))" class="text-slate-500 hover:text-white text-xs"><i class="fas fa-check"></i></button>
            <?php endif; ?>
        </div>
        <?php endforeach; ?>
    </div>
    <?php endif; ?>
</div>
