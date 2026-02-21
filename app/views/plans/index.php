<?php $pageTitle = 'Plans'; ?>
<div class="max-w-5xl mx-auto">
    <div class="text-center mb-10">
        <h1 class="text-3xl font-bold text-white mb-3">Choisissez votre plan</h1>
        <p class="text-slate-400">Débloquez tout le potentiel de TSILIZY Nexus</p>
    </div>
    <div class="grid grid-cols-1 md:grid-cols-<?= count($plans ?? []) > 2 ? '3' : '2' ?> gap-6">
        <?php foreach ($plans ?? [] as $i => $plan): ?>
        <?php $isCurrent = isset($currentPlanId) && $currentPlanId == $plan['id']; ?>
        <div class="card p-6 text-center <?= $i === 1 ? 'ring-2 ring-primary-500/50 relative' : '' ?> <?= $isCurrent ? 'ring-2 ring-emerald-500/50' : '' ?>">
            <?php if ($i === 1 && !$isCurrent): ?><div class="absolute -top-3 left-1/2 -translate-x-1/2 badge badge-purple px-4 py-1 text-xs font-semibold">Populaire</div><?php endif; ?>
            <?php if ($isCurrent): ?><div class="absolute -top-3 left-1/2 -translate-x-1/2 badge badge-emerald px-4 py-1 text-xs font-semibold">Plan actuel</div><?php endif; ?>
            <h3 class="text-lg font-bold text-white mt-2"><?= e($plan['name']) ?></h3>
            <p class="text-sm text-slate-400 mt-1"><?= e($plan['description']??'') ?></p>
            <div class="my-6">
                <span class="text-4xl font-extrabold gradient-text"><?= number_format($plan['price'],0,',',' ') ?></span>
                <span class="text-sm text-slate-500 ml-1"><?= e($plan['currency']??'EUR') ?>/<?= ($plan['billing_cycle']??'free')==='yearly'?'an':'mois' ?></span>
            </div>
            <?php
                $features = json_decode($plan['features']??'{}', true) ?: [];
                // Format features for display
                $featureLabels = [];
                if (isset($features['tasks'])) $featureLabels[] = ($features['tasks'] < 0 ? 'Tâches illimitées' : $features['tasks'] . ' tâches');
                if (isset($features['projects'])) $featureLabels[] = ($features['projects'] < 0 ? 'Projets illimités' : $features['projects'] . ' projets');
                if (isset($features['contacts'])) $featureLabels[] = ($features['contacts'] < 0 ? 'Contacts illimités' : $features['contacts'] . ' contacts');
                if (isset($features['notes'])) $featureLabels[] = ($features['notes'] < 0 ? 'Notes illimitées' : $features['notes'] . ' notes');
            ?>
            <ul class="space-y-2 text-left mb-6">
                <?php foreach ($featureLabels as $f): ?>
                <li class="flex items-center gap-2 text-sm text-slate-300"><i class="fas fa-check text-emerald-400 text-xs"></i><?= e($f) ?></li>
                <?php endforeach; ?>
            </ul>
            <?php if ($isCurrent): ?>
                <span class="btn-secondary w-full block text-center cursor-default opacity-60"><i class="fas fa-check mr-2"></i>Plan actuel</span>
            <?php else: ?>
                <form method="POST" action="<?= url('/plans/'.$plan['id'].'/select') ?>">
                    <?= csrf_field() ?>
                    <button type="submit" class="<?= $i === 1 ? 'btn-primary' : 'btn-secondary' ?> w-full block text-center">Choisir ce plan</button>
                </form>
            <?php endif; ?>
        </div>
        <?php endforeach; ?>
        <?php if (empty($plans)): ?>
        <div class="col-span-3 card p-12 text-center"><p class="text-slate-400">Les plans seront bientôt disponibles</p></div>
        <?php endif; ?>
    </div>
</div>
