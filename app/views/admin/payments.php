<?php $pageTitle = 'Paiements'; ?>
<div class="flex items-center gap-3 mb-6"><a href="<?= url('/admin') ?>" class="text-slate-400 hover:text-white"><i class="fas fa-arrow-left"></i></a><h1 class="text-xl font-bold text-white"><i class="fas fa-credit-card text-emerald-400 mr-2"></i>Paiements</h1></div>
<div class="card overflow-hidden">
    <table class="w-full">
        <thead><tr class="border-b border-white/5 text-left">
            <th class="px-5 py-3 text-xs text-slate-500 uppercase">Utilisateur</th>
            <th class="px-5 py-3 text-xs text-slate-500 uppercase">Plan</th>
            <th class="px-5 py-3 text-xs text-slate-500 uppercase">Montant</th>
            <th class="px-5 py-3 text-xs text-slate-500 uppercase hidden md:table-cell">Méthode</th>
            <th class="px-5 py-3 text-xs text-slate-500 uppercase">Statut</th>
            <th class="px-5 py-3 text-xs text-slate-500 uppercase hidden lg:table-cell">Date</th>
        </tr></thead>
        <tbody class="divide-y divide-white/5">
            <?php foreach ($payments ?? [] as $p): ?>
            <tr class="hover:bg-white/5">
                <td class="px-5 py-4"><p class="text-sm text-white"><?= e($p['user_name']??'—') ?></p><p class="text-xs text-slate-500"><?= e($p['user_email']??'') ?></p></td>
                <td class="px-5 py-4 text-sm text-slate-400"><?= e($p['plan_name']??'—') ?></td>
                <td class="px-5 py-4 text-sm font-semibold text-white"><?= number_format($p['amount'],0,',',' ') ?> <?= e($p['currency']??'FCFA') ?></td>
                <td class="px-5 py-4 text-sm text-slate-400 hidden md:table-cell"><?= e($p['method']??'—') ?></td>
                <td class="px-5 py-4"><span class="badge <?= match($p['status']??''){'completed'=>'badge-emerald','pending'=>'badge-amber','failed'=>'badge-red',default=>'badge-purple'} ?>"><?= e(ucfirst($p['status']??'')) ?></span></td>
                <td class="px-5 py-4 text-sm text-slate-500 hidden lg:table-cell"><?= format_date($p['created_at']) ?></td>
            </tr>
            <?php endforeach; ?>
            <?php if (empty($payments)): ?><tr><td colspan="6" class="px-5 py-12 text-center text-slate-500">Aucun paiement</td></tr><?php endif; ?>
        </tbody>
    </table>
</div>
