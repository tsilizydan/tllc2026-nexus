<?php $pageTitle = 'Modifier: '.$project['name']; ?>
<div class="max-w-3xl mx-auto">
    <div class="flex items-center gap-3 mb-6"><a href="<?= url('/projects/'.$project['id']) ?>" class="text-slate-400 hover:text-white"><i class="fas fa-arrow-left"></i></a><h1 class="text-xl font-bold text-white">Modifier le projet</h1></div>
    <form method="POST" action="<?= url('/projects/'.$project['id'].'/update') ?>" class="card p-6 space-y-5">
        <?= csrf_field() ?>
        <div><label class="block text-sm font-medium text-slate-300 mb-2">Nom *</label><input type="text" name="name" class="input" required value="<?= e($project['name']) ?>"></div>
        <div><label class="block text-sm font-medium text-slate-300 mb-2">Description</label><textarea name="description" rows="3" class="input"><?= e($project['description'] ?? '') ?></textarea></div>
        <div class="grid grid-cols-1 sm:grid-cols-3 gap-4">
            <div><label class="block text-sm font-medium text-slate-300 mb-2">Statut</label><select name="status" class="input">
                <option value="planning" <?= $project['status']==='planning'?'selected':'' ?>>Planification</option>
                <option value="active" <?= $project['status']==='active'?'selected':'' ?>>Actif</option>
                <option value="on_hold" <?= $project['status']==='on_hold'?'selected':'' ?>>En pause</option>
                <option value="completed" <?= $project['status']==='completed'?'selected':'' ?>>Terminé</option>
            </select></div>
            <div><label class="block text-sm font-medium text-slate-300 mb-2">Couleur</label><input type="color" name="color" value="<?= e($project['color']??'#6C3CE1') ?>" class="w-full h-10 rounded-lg cursor-pointer bg-transparent border border-white/10"></div>
            <div><label class="block text-sm font-medium text-slate-300 mb-2">Date fin</label><input type="date" name="end_date" class="input" value="<?= $project['end_date'] ?? '' ?>"></div>
        </div>
        <div class="flex items-center justify-between pt-4 border-t border-white/5">
            <form method="POST" action="<?= url('/projects/'.$project['id'].'/delete') ?>" onsubmit="return confirm('Supprimer ce projet ?')">
                <?= csrf_field() ?><button type="submit" class="btn-danger text-sm"><i class="fas fa-trash mr-1"></i>Supprimer</button>
            </form>
            <div class="flex gap-3"><a href="<?= url('/projects/'.$project['id']) ?>" class="btn-secondary">Annuler</a><button type="submit" class="btn-primary">Enregistrer</button></div>
        </div>
    </form>
</div>
