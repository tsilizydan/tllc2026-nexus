<?php $pageTitle = __('new_website'); ?>
<div class="max-w-3xl mx-auto">
    <div class="flex items-center gap-3 mb-6"><a href="<?= url('/websites') ?>" class="text-slate-400 hover:text-white"><i class="fas fa-arrow-left"></i></a><h1 class="text-xl font-bold text-white">Nouveau site web</h1></div>
    <form method="POST" action="<?= url('/websites') ?>" class="card p-6 space-y-5">
        <?= csrf_field() ?>
        <div class="grid grid-cols-1 sm:grid-cols-2 gap-4">
            <div><label class="block text-sm font-medium text-slate-300 mb-2">Nom du site *</label><input type="text" name="name" class="input" required></div>
            <div><label class="block text-sm font-medium text-slate-300 mb-2">URL</label><input type="url" name="url" class="input" placeholder="https://"></div>
        </div>
        <div class="grid grid-cols-1 sm:grid-cols-2 gap-4">
            <div><label class="block text-sm font-medium text-slate-300 mb-2">Email de contact</label><input type="email" name="email" class="input"></div>
            <div><label class="block text-sm font-medium text-slate-300 mb-2">Catégorie</label><select name="category" class="input"><option value="">— Aucune —</option><option value="e-commerce">E-commerce</option><option value="vitrine">Vitrine</option><option value="blog">Blog</option><option value="portfolio">Portfolio</option><option value="application">Application</option><option value="autre">Autre</option></select></div>
        </div>
        <div class="grid grid-cols-1 sm:grid-cols-2 gap-4">
            <div><label class="block text-sm font-medium text-slate-300 mb-2">Propriétaire</label><input type="text" name="owner" class="input"></div>
            <div><label class="block text-sm font-medium text-slate-300 mb-2">Statut</label><select name="status" class="input"><option value="active">Actif</option><option value="inactive">Inactif</option><option value="maintenance">Maintenance</option></select></div>
        </div>
        <div><label class="block text-sm font-medium text-slate-300 mb-2">Description</label><textarea name="description" rows="2" class="input"></textarea></div>
        <div><label class="block text-sm font-medium text-slate-300 mb-2">Identifiants d'accès <span class="text-xs text-slate-500">(seront chiffrés)</span></label><textarea name="credentials" rows="3" class="input" placeholder="URL admin, Login, Mot de passe..."></textarea></div>
        <div><label class="block text-sm font-medium text-slate-300 mb-2">Notes</label><textarea name="notes" rows="2" class="input"></textarea></div>
        <div class="flex justify-end gap-3 pt-4 border-t border-white/5"><a href="<?= url('/websites') ?>" class="btn-secondary">Annuler</a><button type="submit" class="btn-primary">Ajouter le site</button></div>
    </form>
</div>
