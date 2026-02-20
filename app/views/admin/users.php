<?php $pageTitle = 'Gestion des utilisateurs'; ?>
<div class="flex items-center justify-between mb-6">
    <div class="flex items-center gap-3"><a href="<?= url('/admin') ?>" class="text-slate-400 hover:text-white"><i class="fas fa-arrow-left"></i></a><h1 class="text-xl font-bold text-white">Utilisateurs</h1></div>
</div>
<div class="card overflow-hidden">
    <table class="w-full">
        <thead><tr class="border-b border-white/5 text-left">
            <th class="px-5 py-3 text-xs text-slate-500 uppercase">Utilisateur</th>
            <th class="px-5 py-3 text-xs text-slate-500 uppercase hidden md:table-cell">Email</th>
            <th class="px-5 py-3 text-xs text-slate-500 uppercase hidden md:table-cell">Rôle</th>
            <th class="px-5 py-3 text-xs text-slate-500 uppercase hidden lg:table-cell">Statut</th>
            <th class="px-5 py-3 text-xs text-slate-500 uppercase hidden lg:table-cell">Inscription</th>
            <th class="px-5 py-3 text-xs text-slate-500 uppercase w-24">Actions</th>
        </tr></thead>
        <tbody class="divide-y divide-white/5">
            <?php foreach ($users ?? [] as $u): ?>
            <tr class="hover:bg-white/5">
                <td class="px-5 py-4 flex items-center gap-3">
                    <div class="w-8 h-8 rounded-lg gradient-bg flex items-center justify-center text-white text-sm font-bold"><?= strtoupper(substr($u['name'],0,1)) ?></div>
                    <span class="text-sm font-medium text-white"><?= e($u['name']) ?></span>
                </td>
                <td class="px-5 py-4 text-sm text-slate-400 hidden md:table-cell"><?= e($u['email']) ?></td>
                <td class="px-5 py-4 hidden md:table-cell"><span class="badge <?= $u['role']==='super_admin'?'badge-red':($u['role']==='admin'?'badge-purple':'badge-cyan') ?>"><?= e(ucfirst(str_replace('_',' ',$u['role']))) ?></span></td>
                <td class="px-5 py-4 hidden lg:table-cell"><span class="badge <?= ($u['is_active']??1)?'badge-emerald':'badge-red' ?>"><?= ($u['is_active']??1)?'Actif':'Inactif' ?></span></td>
                <td class="px-5 py-4 text-sm text-slate-500 hidden lg:table-cell"><?= format_date($u['created_at']) ?></td>
                <td class="px-5 py-4 flex gap-2">
                    <a href="<?= url('/admin/users/'.$u['id']) ?>" class="text-slate-400 hover:text-white text-sm"><i class="fas fa-edit"></i></a>
                </td>
            </tr>
            <?php endforeach; ?>
        </tbody>
    </table>
</div>
