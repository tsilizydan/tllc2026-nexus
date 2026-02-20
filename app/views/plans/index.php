<?php $pageTitle = 'Plans'; ?>
<div class="max-w-5xl mx-auto">
    <div class="text-center mb-10">
        <h1 class="text-3xl font-bold text-white mb-3">Choisissez votre plan</h1>
        <p class="text-slate-400">Débloquez tout le potentiel de TSILIZY Nexus</p>
    </div>
    <div class="grid grid-cols-1 md:grid-cols-3 gap-6">
        <?php foreach ($plans ?? [] as $i => $plan): ?>
        <div class="card p-6 text-center <?= $i === 1 ? 'ring-2 ring-primary-500/50 relative' : '' ?>">
            <?php if ($i === 1): ?><div class="absolute -top-3 left-1/2 -translate-x-1/2 badge badge-purple px-4 py-1 text-xs font-semibold">Populaire</div><?php endif; ?>
            <h3 class="text-lg font-bold text-white mt-2"><?= e($plan['name']) ?></h3>
            <p class="text-sm text-slate-400 mt-1"><?= e($plan['description']??'') ?></p>
            <div class="my-6">
                <span class="text-4xl font-extrabold gradient-text"><?= number_format($plan['price'],0,',',' ') ?></span>
                <span class="text-sm text-slate-500 ml-1"><?= e($plan['currency']??'FCFA') ?>/<?= ($plan['billing_cycle']??'monthly')==='yearly'?'an':'mois' ?></span>
            </div>
            <?php $features = json_decode($plan['features']??'[]', true) ?: []; ?>
            <ul class="space-y-2 text-left mb-6">
                <?php foreach ($features as $f): ?>
                <li class="flex items-center gap-2 text-sm text-slate-300"><i class="fas fa-check text-emerald-400 text-xs"></i><?= e($f) ?></li>
                <?php endforeach; ?>
            </ul>
            <a href="<?= url('/payments/create?plan='.$plan['id']) ?>" class="<?= $i === 1 ? 'btn-primary' : 'btn-secondary' ?> w-full block text-center">Choisir ce plan</a>
        </div>
        <?php endforeach; ?>
        <?php if (empty($plans)): ?>
        <div class="col-span-3 card p-12 text-center"><p class="text-slate-400">Les plans seront bientôt disponibles</p></div>
        <?php endif; ?>
    </div>
</div>
