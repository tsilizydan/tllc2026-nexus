<?php $pageTitle = 'Créer un utilisateur'; ?>
<div class="max-w-3xl mx-auto">
    <div class="flex items-center gap-3 mb-6"><a href="<?= url('/admin/users') ?>" class="text-slate-400 hover:text-white"><i class="fas fa-arrow-left"></i></a><h1 class="text-xl font-bold text-white">Nouvel utilisateur</h1></div>
    <form method="POST" action="<?= url('/admin/users/store') ?>" class="card p-6 space-y-5">
        <?= csrf_field() ?>
        <div class="grid grid-cols-1 sm:grid-cols-2 gap-4">
            <div><label class="block text-sm font-medium text-slate-300 mb-2">Nom</label><input type="text" name="name" class="input" required placeholder="Nom complet"></div>
            <div><label class="block text-sm font-medium text-slate-300 mb-2">Email</label><input type="email" name="email" class="input" required placeholder="email@exemple.com"></div>
        </div>
        <div class="grid grid-cols-1 sm:grid-cols-2 gap-4">
            <div><label class="block text-sm font-medium text-slate-300 mb-2">Mot de passe</label><input type="password" name="password" class="input" required minlength="8" placeholder="Minimum 8 caractères"></div>
            <div><label class="block text-sm font-medium text-slate-300 mb-2">Confirmer le mot de passe</label><input type="password" name="password_confirm" class="input" required minlength="8" placeholder="Confirmer"></div>
        </div>
        <div class="grid grid-cols-1 sm:grid-cols-3 gap-4">
            <div><label class="block text-sm font-medium text-slate-300 mb-2">Rôle</label><select name="role" class="input">
                <option value="user">Utilisateur</option>
                <option value="admin">Admin</option>
                <option value="super_admin">Super Admin</option>
            </select></div>
            <div><label class="block text-sm font-medium text-slate-300 mb-2">Plan</label><select name="plan_id" class="input">
                <option value="">— Aucun —</option>
                <?php foreach ($plans??[] as $p): ?><option value="<?= $p['id'] ?>"><?= e($p['name']) ?></option><?php endforeach; ?>
            </select></div>
            <div class="flex items-end"><label class="flex items-center gap-2 text-sm text-slate-300"><input type="checkbox" name="is_active" class="accent-primary-500" checked> Compte actif</label></div>
        </div>
        <div class="flex justify-end gap-3 pt-4 border-t border-white/5">
            <a href="<?= url('/admin/users') ?>" class="btn-secondary">Annuler</a>
            <button type="submit" class="btn-primary"><i class="fas fa-user-plus mr-1"></i>Créer l'utilisateur</button>
        </div>
    </form>
</div>
