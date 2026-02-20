<?php $pageTitle = 'Modifier: '.$contact['first_name']; ?>
<div class="max-w-3xl mx-auto">
    <div class="flex items-center gap-3 mb-6"><a href="<?= url('/contacts/'.$contact['id']) ?>" class="text-slate-400 hover:text-white"><i class="fas fa-arrow-left"></i></a><h1 class="text-xl font-bold text-white">Modifier le contact</h1></div>
    <form method="POST" action="<?= url('/contacts/'.$contact['id'].'/edit') ?>" class="card p-6 space-y-5">
        <?= csrf_field() ?>
        <div class="grid grid-cols-1 sm:grid-cols-2 gap-4">
            <div><label class="block text-sm font-medium text-slate-300 mb-2">Prénom *</label><input type="text" name="first_name" class="input" required value="<?= e($contact['first_name']) ?>"></div>
            <div><label class="block text-sm font-medium text-slate-300 mb-2">Nom</label><input type="text" name="last_name" class="input" value="<?= e($contact['last_name']??'') ?>"></div>
        </div>
        <div class="grid grid-cols-1 sm:grid-cols-2 gap-4">
            <div><label class="block text-sm font-medium text-slate-300 mb-2">Email</label><input type="email" name="email" class="input" value="<?= e($contact['email']??'') ?>"></div>
            <div><label class="block text-sm font-medium text-slate-300 mb-2">Téléphone</label><input type="text" name="phone" class="input" value="<?= e($contact['phone']??'') ?>"></div>
        </div>
        <div class="grid grid-cols-1 sm:grid-cols-2 gap-4">
            <div><label class="block text-sm font-medium text-slate-300 mb-2">Entreprise</label><input type="text" name="company" class="input" value="<?= e($contact['company']??'') ?>"></div>
            <div><label class="block text-sm font-medium text-slate-300 mb-2">Poste</label><input type="text" name="position" class="input" value="<?= e($contact['position']??'') ?>"></div>
        </div>
        <div><label class="block text-sm font-medium text-slate-300 mb-2">Adresse</label><textarea name="address" rows="2" class="input"><?= e($contact['address']??'') ?></textarea></div>
        <div><label class="block text-sm font-medium text-slate-300 mb-2">Tags</label><input type="text" name="tags" class="input" value="<?= e($contact['tags']??'') ?>"></div>
        <div><label class="block text-sm font-medium text-slate-300 mb-2">Notes</label><textarea name="notes" rows="3" class="input"><?= e($contact['notes']??'') ?></textarea></div>
        <div class="flex items-center justify-between pt-4 border-t border-white/5">
            <form method="POST" action="<?= url('/contacts/'.$contact['id'].'/delete') ?>" onsubmit="return confirm('Supprimer ce contact ?')"><?= csrf_field() ?><button type="submit" class="btn-danger text-sm"><i class="fas fa-trash mr-1"></i>Supprimer</button></form>
            <div class="flex gap-3"><a href="<?= url('/contacts/'.$contact['id']) ?>" class="btn-secondary">Annuler</a><button type="submit" class="btn-primary">Enregistrer</button></div>
        </div>
    </form>
</div>
