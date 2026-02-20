<?php $pageTitle = __('contacts'); ?>
<div class="flex items-center justify-between mb-6">
    <h1 class="text-2xl font-bold text-white"><i class="fas fa-address-book text-emerald-400 mr-3"></i><?= __('contacts') ?></h1>
    <div class="flex items-center gap-3">
        <a href="<?= url('/contacts/export') ?>" class="btn-secondary text-sm"><i class="fas fa-download mr-1"></i>Exporter CSV</a>
        <a href="<?= url('/contacts/create') ?>" class="btn-primary inline-flex items-center gap-2 text-sm"><i class="fas fa-plus"></i>Nouveau</a>
    </div>
</div>
<!-- Search -->
<form action="<?= url('/contacts') ?>" method="GET" class="mb-6">
    <div class="flex gap-3"><input type="text" name="q" value="<?= e($search ?? '') ?>" class="input flex-1" placeholder="Rechercher un contact..."><button type="submit" class="btn-primary"><i class="fas fa-search"></i></button></div>
</form>
<?php if (empty($contacts)): ?>
<div class="card p-12 text-center"><i class="fas fa-users text-5xl text-emerald-400/30 mb-4 block"></i><p class="text-slate-400">Aucun contact trouvé</p></div>
<?php else: ?>
<div class="card overflow-hidden">
    <table class="w-full">
        <thead><tr class="border-b border-white/5 text-left">
            <th class="px-5 py-3 text-xs font-medium text-slate-500 uppercase">Nom</th>
            <th class="px-5 py-3 text-xs font-medium text-slate-500 uppercase hidden md:table-cell">Email</th>
            <th class="px-5 py-3 text-xs font-medium text-slate-500 uppercase hidden md:table-cell">Téléphone</th>
            <th class="px-5 py-3 text-xs font-medium text-slate-500 uppercase hidden lg:table-cell">Entreprise</th>
            <th class="px-5 py-3 text-xs font-medium text-slate-500 uppercase w-20">Actions</th>
        </tr></thead>
        <tbody class="divide-y divide-white/5">
            <?php foreach ($contacts as $c): ?>
            <tr class="hover:bg-white/5 transition-colors">
                <td class="px-5 py-4"><a href="<?= url('/contacts/'.$c['id']) ?>" class="flex items-center gap-3">
                    <div class="w-9 h-9 rounded-lg gradient-bg flex items-center justify-center text-white text-sm font-bold"><?= strtoupper(substr($c['first_name'],0,1)) ?></div>
                    <span class="text-sm font-medium text-white hover:text-accent-400"><?= e($c['first_name'].' '.($c['last_name']??'')) ?></span>
                </a></td>
                <td class="px-5 py-4 text-sm text-slate-400 hidden md:table-cell"><?= e($c['email'] ?? '—') ?></td>
                <td class="px-5 py-4 text-sm text-slate-400 hidden md:table-cell"><?= e($c['phone'] ?? '—') ?></td>
                <td class="px-5 py-4 text-sm text-slate-400 hidden lg:table-cell"><?= e($c['company'] ?? '—') ?></td>
                <td class="px-5 py-4"><a href="<?= url('/contacts/'.$c['id'].'/edit') ?>" class="text-slate-400 hover:text-white"><i class="fas fa-edit"></i></a></td>
            </tr>
            <?php endforeach; ?>
        </tbody>
    </table>
</div>
<?php endif; ?>
