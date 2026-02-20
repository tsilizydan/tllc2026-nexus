<?php $pageTitle = __('nav_profile'); ?>
<div class="max-w-3xl mx-auto">
    <h1 class="text-2xl font-bold text-white mb-6"><i class="fas fa-user text-primary-400 mr-3"></i>Mon profil</h1>
    <!-- Profile Info -->
    <form method="POST" action="<?= url('/profile') ?>" class="card p-6 space-y-5 mb-6">
        <?= csrf_field() ?>
        <div class="flex items-center gap-4 mb-4">
            <div class="w-16 h-16 rounded-2xl gradient-bg flex items-center justify-center text-white text-2xl font-bold"><?= strtoupper(substr($user['name']??'U',0,1)) ?></div>
            <div><h2 class="text-lg font-bold text-white"><?= e($user['name']??'') ?></h2><p class="text-sm text-slate-400"><?= e($user['email']??'') ?></p></div>
        </div>
        <div class="grid grid-cols-1 sm:grid-cols-2 gap-4">
            <div><label class="block text-sm font-medium text-slate-300 mb-2">Nom complet</label><input type="text" name="name" class="input" value="<?= e($user['name']??'') ?>"></div>
            <div><label class="block text-sm font-medium text-slate-300 mb-2">Téléphone</label><input type="text" name="phone" class="input" value="<?= e($user['phone']??'') ?>"></div>
        </div>
        <div><label class="block text-sm font-medium text-slate-300 mb-2">Poste / Fonction</label><input type="text" name="position" class="input" value="<?= e($user['position']??'') ?>"></div>
        <div><label class="block text-sm font-medium text-slate-300 mb-2">Bio</label><textarea name="bio" rows="3" class="input"><?= e($user['bio']??'') ?></textarea></div>
        <div class="flex justify-end pt-4 border-t border-white/5"><button type="submit" class="btn-primary">Mettre à jour</button></div>
    </form>

    <!-- Change Password -->
    <form method="POST" action="<?= url('/profile/password') ?>" class="card p-6 space-y-5">
        <?= csrf_field() ?>
        <h3 class="text-lg font-semibold text-white"><i class="fas fa-lock text-accent-400 mr-2"></i>Changer le mot de passe</h3>
        <div><label class="block text-sm font-medium text-slate-300 mb-2">Mot de passe actuel</label><input type="password" name="current_password" class="input" required></div>
        <div class="grid grid-cols-1 sm:grid-cols-2 gap-4">
            <div><label class="block text-sm font-medium text-slate-300 mb-2">Nouveau mot de passe</label><input type="password" name="new_password" class="input" required minlength="8"></div>
            <div><label class="block text-sm font-medium text-slate-300 mb-2">Confirmer</label><input type="password" name="new_password_confirm" class="input" required></div>
        </div>
        <div class="flex justify-end pt-4 border-t border-white/5"><button type="submit" class="btn-primary">Modifier le mot de passe</button></div>
    </form>
</div>
