<?php $pageTitle = 'Modifier: '.$user['name']; ?>
<div class="max-w-3xl mx-auto">
    <div class="flex items-center gap-3 mb-6"><a href="<?= url('/admin/users') ?>" class="text-slate-400 hover:text-white"><i class="fas fa-arrow-left"></i></a><h1 class="text-xl font-bold text-white">Modifier l'utilisateur</h1></div>
    <form method="POST" action="<?= url('/admin/users/'.$user['id']) ?>" class="card p-6 space-y-5">
        <?= csrf_field() ?>
        <div class="grid grid-cols-1 sm:grid-cols-2 gap-4">
            <div><label class="block text-sm font-medium text-slate-300 mb-2">Nom</label><input type="text" name="name" class="input" value="<?= e($user['name']) ?>"></div>
            <div><label class="block text-sm font-medium text-slate-300 mb-2">Email</label><input type="email" name="email" class="input" value="<?= e($user['email']) ?>"></div>
        </div>
        <div class="grid grid-cols-1 sm:grid-cols-3 gap-4">
            <div><label class="block text-sm font-medium text-slate-300 mb-2">Rôle</label><select name="role" class="input">
                <option value="user" <?= $user['role']==='user'?'selected':'' ?>>Utilisateur</option>
                <option value="admin" <?= $user['role']==='admin'?'selected':'' ?>>Admin</option>
                <option value="super_admin" <?= $user['role']==='super_admin'?'selected':'' ?>>Super Admin</option>
            </select></div>
            <div><label class="block text-sm font-medium text-slate-300 mb-2">Plan</label><select name="plan_id" class="input">
                <option value="">— Aucun —</option>
                <?php foreach ($plans??[] as $p): ?><option value="<?= $p['id'] ?>" <?= ($user['plan_id']??0)==$p['id']?'selected':'' ?>><?= e($p['name']) ?></option><?php endforeach; ?>
            </select></div>
            <div class="flex items-end"><label class="flex items-center gap-2 text-sm text-slate-300"><input type="checkbox" name="is_active" class="accent-primary-500" <?= ($user['is_active']??1)?'checked':'' ?>> Compte actif</label></div>
        </div>
        <div class="flex items-center justify-between pt-4 border-t border-white/5">
            <form method="POST" action="<?= url('/admin/users/'.$user['id'].'/delete') ?>" onsubmit="return confirm('Supprimer cet utilisateur ?')"><?= csrf_field() ?><button type="submit" class="btn-danger text-sm"><i class="fas fa-trash mr-1"></i>Supprimer</button></form>
            <div class="flex gap-3"><a href="<?= url('/admin/users') ?>" class="btn-secondary">Annuler</a><button type="submit" class="btn-primary">Enregistrer</button></div>
        </div>
    </form>
</div>
