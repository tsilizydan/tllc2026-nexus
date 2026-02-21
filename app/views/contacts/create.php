<?php $pageTitle = __('new_contact'); ?>
<div class="max-w-3xl mx-auto">
    <div class="flex items-center gap-3 mb-6"><a href="<?= url('/contacts') ?>" class="text-slate-400 hover:text-white"><i class="fas fa-arrow-left"></i></a><h1 class="text-xl font-bold text-white">Nouveau contact</h1></div>
    <form method="POST" action="<?= url('/contacts/store') ?>" class="card p-6 space-y-5">
        <?= csrf_field() ?>
        <div class="grid grid-cols-1 sm:grid-cols-2 gap-4">
            <div><label class="block text-sm font-medium text-slate-300 mb-2">Prénom *</label><input type="text" name="first_name" class="input" required></div>
            <div><label class="block text-sm font-medium text-slate-300 mb-2">Nom</label><input type="text" name="last_name" class="input"></div>
        </div>
        <div class="grid grid-cols-1 sm:grid-cols-2 gap-4">
            <div><label class="block text-sm font-medium text-slate-300 mb-2">Email</label><input type="email" name="email" class="input"></div>
            <div><label class="block text-sm font-medium text-slate-300 mb-2">Téléphone</label><input type="text" name="phone" class="input"></div>
        </div>
        <div class="grid grid-cols-1 sm:grid-cols-2 gap-4">
            <div><label class="block text-sm font-medium text-slate-300 mb-2">Entreprise</label><input type="text" name="company" class="input"></div>
            <div><label class="block text-sm font-medium text-slate-300 mb-2">Poste</label><input type="text" name="position" class="input"></div>
        </div>
        <div><label class="block text-sm font-medium text-slate-300 mb-2">Adresse</label><textarea name="address" rows="2" class="input"></textarea></div>
        <div><label class="block text-sm font-medium text-slate-300 mb-2">Tags (séparés par des virgules)</label><input type="text" name="tags" class="input" placeholder="client, fournisseur, partenaire"></div>
        <div><label class="block text-sm font-medium text-slate-300 mb-2">Notes</label><textarea name="notes" rows="3" class="input"></textarea></div>
        <div class="flex justify-end gap-3 pt-4 border-t border-white/5"><a href="<?= url('/contacts') ?>" class="btn-secondary">Annuler</a><button type="submit" class="btn-primary">Créer le contact</button></div>
    </form>
</div>
