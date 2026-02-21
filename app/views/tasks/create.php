<?php $pageTitle = __('new_task'); ?>
<div class="max-w-3xl mx-auto">
    <div class="flex items-center gap-3 mb-6">
        <a href="<?= url('/tasks') ?>" class="text-slate-400 hover:text-white transition-colors"><i class="fas fa-arrow-left"></i></a>
        <h1 class="text-xl font-bold text-white">Nouvelle tâche</h1>
    </div>
    <form method="POST" action="<?= url('/tasks') ?>" class="card p-6 space-y-5">
        <?= csrf_field() ?>
        <div>
            <label class="block text-sm font-medium text-slate-300 mb-2">Titre *</label>
            <input type="text" name="title" class="input" required placeholder="Titre de la tâche">
        </div>
        <div>
            <label class="block text-sm font-medium text-slate-300 mb-2">Description</label>
            <textarea name="description" rows="4" class="input" placeholder="Description détaillée..."></textarea>
        </div>
        <div class="grid grid-cols-1 sm:grid-cols-2 gap-4">
            <div>
                <label class="block text-sm font-medium text-slate-300 mb-2">Statut</label>
                <select name="status" class="input">
                    <option value="todo">À faire</option><option value="in_progress">En cours</option><option value="done">Terminé</option>
                </select>
            </div>
            <div>
                <label class="block text-sm font-medium text-slate-300 mb-2">Priorité</label>
                <select name="priority" class="input">
                    <option value="low">Basse</option><option value="medium" selected>Moyenne</option><option value="high">Haute</option><option value="urgent">Urgente</option>
                </select>
            </div>
        </div>
        <div class="grid grid-cols-1 sm:grid-cols-2 gap-4">
            <div>
                <label class="block text-sm font-medium text-slate-300 mb-2">Date d'échéance</label>
                <input type="datetime-local" name="due_date" class="input">
            </div>
            <div>
                <label class="block text-sm font-medium text-slate-300 mb-2">Projet</label>
                <select name="project_id" class="input">
                    <option value="">— Aucun projet —</option>
                    <?php foreach ($projects ?? [] as $p): ?>
                    <option value="<?= $p['id'] ?>"><?= e($p['name']) ?></option>
                    <?php endforeach; ?>
                </select>
            </div>
        </div>
        <?php if (!empty($labels)): ?>
        <div>
            <label class="block text-sm font-medium text-slate-300 mb-2">Étiquettes</label>
            <div class="flex flex-wrap gap-2">
                <?php foreach ($labels as $lbl): ?>
                <label class="inline-flex items-center gap-1.5 px-3 py-1.5 rounded-lg cursor-pointer border border-white/10 hover:border-primary-500/30 transition-colors">
                    <input type="checkbox" name="labels[]" value="<?= $lbl['id'] ?>" class="accent-primary-500">
                    <span class="w-2 h-2 rounded-full" style="background:<?= e($lbl['color']) ?>"></span>
                    <span class="text-sm text-white"><?= e($lbl['name']) ?></span>
                </label>
                <?php endforeach; ?>
            </div>
        </div>
        <?php endif; ?>
        <div class="flex justify-end gap-3 pt-4 border-t border-white/5">
            <a href="<?= url('/tasks') ?>" class="btn-secondary">Annuler</a>
            <button type="submit" class="btn-primary">Créer la tâche</button>
        </div>
    </form>
</div>
