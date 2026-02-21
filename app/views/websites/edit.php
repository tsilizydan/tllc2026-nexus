<?php $pageTitle = 'Modifier: '.$website['name']; ?>
<div class="max-w-3xl mx-auto">
    <div class="flex items-center gap-3 mb-6"><a href="<?= url('/websites/'.$website['id']) ?>" class="text-slate-400 hover:text-white"><i class="fas fa-arrow-left"></i></a><h1 class="text-xl font-bold text-white">Modifier le site</h1></div>
    <form method="POST" action="<?= url('/websites/'.$website['id'].'/update') ?>" class="card p-6 space-y-5">
        <?= csrf_field() ?>
        <div class="grid grid-cols-1 sm:grid-cols-2 gap-4">
            <div><label class="block text-sm font-medium text-slate-300 mb-2">Nom *</label><input type="text" name="name" class="input" required value="<?= e($website['name']) ?>"></div>
            <div><label class="block text-sm font-medium text-slate-300 mb-2">URL</label><input type="url" name="url" class="input" value="<?= e($website['url']??'') ?>"></div>
        </div>
        <div class="grid grid-cols-1 sm:grid-cols-2 gap-4">
            <div><label class="block text-sm font-medium text-slate-300 mb-2">Email</label><input type="email" name="email" class="input" value="<?= e($website['email']??'') ?>"></div>
            <div><label class="block text-sm font-medium text-slate-300 mb-2">Catégorie</label><select name="category" class="input">
                <?php foreach([''=>'— Aucune —','e-commerce'=>'E-commerce','vitrine'=>'Vitrine','blog'=>'Blog','portfolio'=>'Portfolio','application'=>'Application','autre'=>'Autre'] as $v=>$l): ?>
                <option value="<?= $v ?>" <?= ($website['category']??'')===$v?'selected':'' ?>><?= $l ?></option><?php endforeach; ?>
            </select></div>
        </div>
        <div class="grid grid-cols-1 sm:grid-cols-2 gap-4">
            <div><label class="block text-sm font-medium text-slate-300 mb-2">Propriétaire</label><input type="text" name="owner" class="input" value="<?= e($website['owner']??'') ?>"></div>
            <div><label class="block text-sm font-medium text-slate-300 mb-2">Statut</label><select name="status" class="input">
                <option value="active" <?= ($website['status']??'')==='active'?'selected':'' ?>>Actif</option>
                <option value="inactive" <?= ($website['status']??'')==='inactive'?'selected':'' ?>>Inactif</option>
                <option value="maintenance" <?= ($website['status']??'')==='maintenance'?'selected':'' ?>>Maintenance</option>
            </select></div>
        </div>
        <div><label class="block text-sm font-medium text-slate-300 mb-2">Description</label><textarea name="description" rows="2" class="input"><?= e($website['description']??'') ?></textarea></div>
        <div><label class="block text-sm font-medium text-slate-300 mb-2">Nouveaux identifiants <span class="text-xs text-slate-500">(laisser vide pour ne pas modifier)</span></label><textarea name="credentials" rows="2" class="input"></textarea></div>
        <div><label class="block text-sm font-medium text-slate-300 mb-2">Notes</label><textarea name="notes" rows="2" class="input"><?= e($website['notes']??'') ?></textarea></div>
        <div class="flex items-center justify-between pt-4 border-t border-white/5">
            <form method="POST" action="<?= url('/websites/'.$website['id'].'/delete') ?>" onsubmit="return confirm('Supprimer ce site ?')"><?= csrf_field() ?><button type="submit" class="btn-danger text-sm"><i class="fas fa-trash mr-1"></i>Supprimer</button></form>
            <div class="flex gap-3"><a href="<?= url('/websites/'.$website['id']) ?>" class="btn-secondary">Annuler</a><button type="submit" class="btn-primary">Enregistrer</button></div>
        </div>
    </form>
</div>
