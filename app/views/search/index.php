<?php $pageTitle = 'Recherche'; ?>
<div class="max-w-4xl mx-auto">
    <h1 class="text-2xl font-bold text-white mb-6"><i class="fas fa-search text-primary-400 mr-3"></i>Recherche</h1>
    <form action="<?= url('/search') ?>" method="GET" class="mb-6">
        <div class="flex gap-3"><input type="text" name="q" value="<?= e($query??'') ?>" class="input flex-1 text-lg" placeholder="Rechercher partout..." autofocus><button type="submit" class="btn-primary px-6"><i class="fas fa-search mr-2"></i>Chercher</button></div>
    </form>
    <?php if (!empty($query)): ?>
    <p class="text-sm text-slate-400 mb-4">Résultats pour "<span class="text-white"><?= e($query) ?></span>"</p>
    <?php $sections = ['tasks'=>['Tâches','check-circle','primary'],'notes'=>['Notes','sticky-note','accent'],'contacts'=>['Contacts','address-book','emerald'],'projects'=>['Projets','project-diagram','amber']]; ?>
    <?php $hasResults = false; foreach ($results as $items) if (!empty($items)) $hasResults = true; ?>
    <?php if (!$hasResults): ?>
    <div class="card p-12 text-center"><i class="fas fa-search text-5xl text-slate-600 mb-4 block"></i><p class="text-slate-400">Aucun résultat</p></div>
    <?php else: ?>
    <?php foreach ($sections as $key => [$label, $icon, $color]): ?>
    <?php if (!empty($results[$key])): ?>
    <div class="mb-6">
        <h3 class="text-sm font-semibold text-white mb-3"><i class="fas fa-<?= $icon ?> text-<?= $color ?>-400 mr-2"></i><?= $label ?></h3>
        <div class="space-y-2">
            <?php foreach (array_slice($results[$key], 0, 10) as $item): ?>
            <a href="<?= url('/'.$key.'/'.($item['id']??'')) ?>" class="card p-3 block hover:border-primary-500/30">
                <p class="text-sm text-white"><?= e($item['title']??$item['name']??$item['first_name']??'') ?></p>
            </a>
            <?php endforeach; ?>
        </div>
    </div>
    <?php endif; endforeach; endif; endif; ?>
</div>
