<?php $pageTitle = 'Publicités'; ?>
<div class="flex items-center justify-between mb-6">
    <div class="flex items-center gap-3"><a href="<?= url('/admin') ?>" class="text-slate-400 hover:text-white"><i class="fas fa-arrow-left"></i></a><h1 class="text-xl font-bold text-white"><i class="fas fa-bullhorn text-amber-400 mr-2"></i>Publicités</h1></div>
</div>
<div class="card overflow-hidden">
    <table class="w-full">
        <thead><tr class="border-b border-white/5 text-left">
            <th class="px-5 py-3 text-xs text-slate-500 uppercase">Titre</th>
            <th class="px-5 py-3 text-xs text-slate-500 uppercase hidden md:table-cell">Placement</th>
            <th class="px-5 py-3 text-xs text-slate-500 uppercase hidden md:table-cell">Clics</th>
            <th class="px-5 py-3 text-xs text-slate-500 uppercase hidden md:table-cell">Impressions</th>
            <th class="px-5 py-3 text-xs text-slate-500 uppercase">Statut</th>
        </tr></thead>
        <tbody class="divide-y divide-white/5">
            <?php foreach ($ads ?? [] as $ad): ?>
            <tr class="hover:bg-white/5">
                <td class="px-5 py-4 text-sm text-white"><?= e($ad['title']) ?></td>
                <td class="px-5 py-4 text-sm text-slate-400 hidden md:table-cell"><?= e($ad['placement']??'—') ?></td>
                <td class="px-5 py-4 text-sm text-slate-400 hidden md:table-cell"><?= number_format($ad['clicks']??0) ?></td>
                <td class="px-5 py-4 text-sm text-slate-400 hidden md:table-cell"><?= number_format($ad['impressions']??0) ?></td>
                <td class="px-5 py-4"><span class="badge <?= ($ad['is_active']??0)?'badge-emerald':'badge-red' ?>"><?= ($ad['is_active']??0)?'Actif':'Inactif' ?></span></td>
            </tr>
            <?php endforeach; ?>
            <?php if (empty($ads)): ?><tr><td colspan="5" class="px-5 py-12 text-center text-slate-500">Aucune publicité</td></tr><?php endif; ?>
        </tbody>
    </table>
</div>
