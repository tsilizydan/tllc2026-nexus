<?php $pageTitle = 'Administration'; ?>
<h1 class="text-2xl font-bold text-white mb-6"><i class="fas fa-shield-alt text-primary-400 mr-3"></i>Tableau de bord Admin</h1>

<!-- Stats -->
<div class="grid grid-cols-2 md:grid-cols-5 gap-4 mb-8">
    <?php foreach ([['users','Utilisateurs','users','purple'],['tasks','Tâches','check-circle','cyan'],['projects','Projets','project-diagram','emerald'],['contacts','Contacts','address-book','amber'],['notes','Notes','sticky-note','red']] as [$key,$label,$icon,$color]): ?>
    <div class="card stat-card <?= $color ?> p-5 text-center">
        <div class="w-10 h-10 rounded-xl bg-<?= $color ?>-500/15 flex items-center justify-center mx-auto mb-3"><i class="fas fa-<?= $icon ?> text-<?= $color ?>-400"></i></div>
        <h3 class="text-2xl font-bold text-white"><?= $stats[$key] ?? 0 ?></h3>
        <p class="text-xs text-slate-400"><?= $label ?></p>
    </div>
    <?php endforeach; ?>
</div>

<!-- Quick Links -->
<div class="grid grid-cols-1 md:grid-cols-4 gap-4 mb-8">
    <a href="<?= url('/admin/users') ?>" class="card p-4 flex items-center gap-3 hover:border-primary-500/30"><i class="fas fa-users text-primary-400"></i><span class="text-sm text-white">Utilisateurs</span><i class="fas fa-chevron-right text-xs text-slate-600 ml-auto"></i></a>
    <a href="<?= url('/admin/payments') ?>" class="card p-4 flex items-center gap-3 hover:border-primary-500/30"><i class="fas fa-credit-card text-emerald-400"></i><span class="text-sm text-white">Paiements</span><i class="fas fa-chevron-right text-xs text-slate-600 ml-auto"></i></a>
    <a href="<?= url('/admin/ads') ?>" class="card p-4 flex items-center gap-3 hover:border-primary-500/30"><i class="fas fa-bullhorn text-amber-400"></i><span class="text-sm text-white">Publicités</span><i class="fas fa-chevron-right text-xs text-slate-600 ml-auto"></i></a>
    <a href="<?= url('/admin/settings') ?>" class="card p-4 flex items-center gap-3 hover:border-primary-500/30"><i class="fas fa-cog text-accent-400"></i><span class="text-sm text-white">Paramètres</span><i class="fas fa-chevron-right text-xs text-slate-600 ml-auto"></i></a>
</div>

<!-- Recent Users -->
<div class="card p-6">
    <div class="flex items-center justify-between mb-4"><h3 class="text-sm font-semibold text-white">Derniers utilisateurs inscrits</h3><a href="<?= url('/admin/users') ?>" class="text-xs text-accent-400">Voir tout</a></div>
    <div class="overflow-x-auto">
        <table class="w-full">
            <thead><tr class="border-b border-white/5 text-left"><th class="px-4 py-2 text-xs text-slate-500">Nom</th><th class="px-4 py-2 text-xs text-slate-500">Email</th><th class="px-4 py-2 text-xs text-slate-500">Rôle</th><th class="px-4 py-2 text-xs text-slate-500">Date</th></tr></thead>
            <tbody class="divide-y divide-white/5">
                <?php foreach ($recentUsers ?? [] as $u): ?>
                <tr class="hover:bg-white/5">
                    <td class="px-4 py-3 text-sm text-white"><?= e($u['name']) ?></td>
                    <td class="px-4 py-3 text-sm text-slate-400"><?= e($u['email']) ?></td>
                    <td class="px-4 py-3"><span class="badge <?= $u['role']==='super_admin'?'badge-red':($u['role']==='admin'?'badge-purple':'badge-cyan') ?>"><?= e($u['role']) ?></span></td>
                    <td class="px-4 py-3 text-sm text-slate-500"><?= format_date($u['created_at']) ?></td>
                </tr>
                <?php endforeach; ?>
            </tbody>
        </table>
    </div>
</div>
