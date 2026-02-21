<?php $pageTitle = __('new_project'); ?>
<div class="max-w-3xl mx-auto">
    <div class="flex items-center gap-3 mb-6"><a href="<?= url('/projects') ?>" class="text-slate-400 hover:text-white"><i class="fas fa-arrow-left"></i></a><h1 class="text-xl font-bold text-white">Nouveau projet</h1></div>
    <form method="POST" action="<?= url('/projects') ?>" class="card p-6 space-y-5">
        <?= csrf_field() ?>
        <div><label class="block text-sm font-medium text-slate-300 mb-2">Nom du projet *</label><input type="text" name="name" class="input" required></div>
        <div><label class="block text-sm font-medium text-slate-300 mb-2">Description</label><textarea name="description" rows="3" class="input"></textarea></div>
        <div class="grid grid-cols-1 sm:grid-cols-3 gap-4">
            <div><label class="block text-sm font-medium text-slate-300 mb-2">Statut</label><select name="status" class="input"><option value="planning">Planification</option><option value="active">Actif</option></select></div>
            <div><label class="block text-sm font-medium text-slate-300 mb-2">Couleur</label><input type="color" name="color" value="#6C3CE1" class="w-full h-10 rounded-lg cursor-pointer bg-transparent border border-white/10"></div>
            <div><label class="block text-sm font-medium text-slate-300 mb-2">Date début</label><input type="date" name="start_date" class="input"></div>
        </div>
        <div class="flex justify-end gap-3 pt-4 border-t border-white/5"><a href="<?= url('/projects') ?>" class="btn-secondary">Annuler</a><button type="submit" class="btn-primary">Créer le projet</button></div>
    </form>
</div>
