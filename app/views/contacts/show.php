<?php $pageTitle = $contact['first_name'].' '.($contact['last_name']??''); ?>
<div class="max-w-4xl mx-auto">
    <div class="flex items-center gap-3 mb-6">
        <a href="<?= url('/contacts') ?>" class="text-slate-400 hover:text-white"><i class="fas fa-arrow-left"></i></a>
        <div class="w-12 h-12 rounded-xl gradient-bg flex items-center justify-center text-white text-lg font-bold"><?= strtoupper(substr($contact['first_name'],0,1)) ?></div>
        <div class="flex-1"><h1 class="text-xl font-bold text-white"><?= e($contact['first_name'].' '.($contact['last_name']??'')) ?></h1>
        <?php if ($contact['company']): ?><p class="text-sm text-slate-400"><?= e($contact['position']?$contact['position'].' — ':'') ?><?= e($contact['company']) ?></p><?php endif; ?></div>
        <a href="<?= url('/contacts/'.$contact['id'].'/edit') ?>" class="btn-secondary text-sm"><i class="fas fa-edit mr-1"></i>Modifier</a>
    </div>
    <div class="grid grid-cols-1 lg:grid-cols-3 gap-6">
        <div class="lg:col-span-2 space-y-6">
            <!-- Info -->
            <div class="card p-6">
                <h3 class="text-sm font-semibold text-white mb-4">Informations</h3>
                <div class="grid grid-cols-2 gap-4 text-sm">
                    <div><span class="text-slate-500">Email</span><p class="text-white mt-1"><?= $contact['email'] ? '<a href="mailto:'.e($contact['email']).'" class="text-accent-400 hover:underline">'.e($contact['email']).'</a>' : '—' ?></p></div>
                    <div><span class="text-slate-500">Téléphone</span><p class="text-white mt-1"><?= $contact['phone'] ? '<a href="tel:'.e($contact['phone']).'" class="text-accent-400 hover:underline">'.e($contact['phone']).'</a>' : '—' ?></p></div>
                    <div class="col-span-2"><span class="text-slate-500">Adresse</span><p class="text-white mt-1"><?= e($contact['address'] ?? '—') ?></p></div>
                    <?php if ($contact['tags']): ?><div class="col-span-2"><span class="text-slate-500">Tags</span><div class="flex flex-wrap gap-1 mt-1"><?php foreach(explode(',',$contact['tags']) as $tag): ?><span class="badge badge-purple"><?= e(trim($tag)) ?></span><?php endforeach; ?></div></div><?php endif; ?>
                    <?php if ($contact['notes']): ?><div class="col-span-2"><span class="text-slate-500">Notes</span><p class="text-slate-300 mt-1 text-sm"><?= nl2br(e($contact['notes'])) ?></p></div><?php endif; ?>
                </div>
            </div>
        </div>
        <!-- Interactions -->
        <div class="card p-6">
            <h3 class="text-sm font-semibold text-white mb-4"><i class="fas fa-history mr-2 text-accent-400"></i>Interactions</h3>
            <?php if (empty($interactions)): ?><p class="text-sm text-slate-500 text-center py-4">Aucune interaction</p>
            <?php else: ?><div class="space-y-3"><?php foreach($interactions as $i): ?>
            <div class="border-l-2 border-primary-500/30 pl-3"><p class="text-xs text-slate-500"><?= format_date($i['interaction_date']) ?> — <span class="text-primary-300"><?= e($i['type']) ?></span></p><p class="text-sm text-slate-300"><?= e($i['description']) ?></p></div>
            <?php endforeach; ?></div><?php endif; ?>
        </div>
    </div>
</div>
