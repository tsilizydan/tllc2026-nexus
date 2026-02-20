<?php $pageTitle = __('tasks'); ?>

<div class="flex items-center justify-between mb-6">
    <div>
        <h1 class="text-2xl font-bold text-white"><i class="fas fa-check-circle text-primary-400 mr-3"></i><?= __('tasks') ?></h1>
        <p class="text-slate-400 text-sm mt-1">Gérez vos tâches efficacement</p>
    </div>
    <div class="flex items-center gap-3">
        <!-- View Toggle -->
        <div class="flex bg-white/5 rounded-xl border border-white/10 p-1">
            <a href="?view=kanban" class="px-3 py-1.5 rounded-lg text-sm transition-all <?= ($currentView ?? 'kanban') === 'kanban' ? 'bg-primary-500/20 text-primary-300' : 'text-slate-400 hover:text-white' ?>">
                <i class="fas fa-columns mr-1"></i> Kanban
            </a>
            <a href="?view=list" class="px-3 py-1.5 rounded-lg text-sm transition-all <?= ($currentView ?? 'kanban') === 'list' ? 'bg-primary-500/20 text-primary-300' : 'text-slate-400 hover:text-white' ?>">
                <i class="fas fa-list mr-1"></i> Liste
            </a>
        </div>
        <a href="<?= url('/tasks/create') ?>" class="btn-primary inline-flex items-center gap-2 text-sm">
            <i class="fas fa-plus"></i> Nouvelle tâche
        </a>
    </div>
</div>

<!-- Filters -->
<div class="flex flex-wrap gap-3 mb-6" x-data="{ showFilters: false }">
    <button @click="showFilters = !showFilters" class="btn-secondary text-sm inline-flex items-center gap-2">
        <i class="fas fa-filter"></i> Filtres
    </button>
    <div x-show="showFilters" x-transition class="flex flex-wrap gap-3 w-full">
        <select onchange="window.location='?status='+this.value+'&view=<?= $currentView ?>'" class="input w-auto text-sm">
            <option value="">Tous les statuts</option>
            <option value="todo" <?= ($filterStatus ?? '') === 'todo' ? 'selected' : '' ?>>À faire</option>
            <option value="in_progress" <?= ($filterStatus ?? '') === 'in_progress' ? 'selected' : '' ?>>En cours</option>
            <option value="done" <?= ($filterStatus ?? '') === 'done' ? 'selected' : '' ?>>Terminé</option>
        </select>
        <select onchange="window.location='?priority='+this.value+'&view=<?= $currentView ?>'" class="input w-auto text-sm">
            <option value="">Toutes les priorités</option>
            <option value="low" <?= ($filterPriority ?? '') === 'low' ? 'selected' : '' ?>>Basse</option>
            <option value="medium" <?= ($filterPriority ?? '') === 'medium' ? 'selected' : '' ?>>Moyenne</option>
            <option value="high" <?= ($filterPriority ?? '') === 'high' ? 'selected' : '' ?>>Haute</option>
            <option value="urgent" <?= ($filterPriority ?? '') === 'urgent' ? 'selected' : '' ?>>Urgente</option>
        </select>
    </div>
</div>

<?php if (($currentView ?? 'kanban') === 'kanban'): ?>
<!-- KANBAN VIEW -->
<div class="grid grid-cols-1 md:grid-cols-3 gap-5" x-data="kanbanBoard()">
    <?php foreach (['todo' => ['À faire', 'slate'], 'in_progress' => ['En cours', 'amber'], 'done' => ['Terminé', 'emerald']] as $status => [$label, $color]): ?>
    <div class="glass rounded-2xl p-4" data-status="<?= $status ?>"
         @dragover.prevent @drop="drop($event, '<?= $status ?>')">
        <div class="flex items-center justify-between mb-4">
            <div class="flex items-center gap-2">
                <div class="w-2 h-2 rounded-full bg-<?= $color ?>-500"></div>
                <h3 class="text-sm font-semibold text-white"><?= $label ?></h3>
                <span class="badge badge-<?= $color ?> text-xs"><?= count($kanban[$status] ?? []) ?></span>
            </div>
        </div>
        <div class="space-y-3 min-h-[100px]">
            <?php foreach ($kanban[$status] ?? [] as $task): ?>
            <div class="card p-4 cursor-grab active:cursor-grabbing" draggable="true" 
                 data-task-id="<?= $task['id'] ?>" @dragstart="drag($event, <?= $task['id'] ?>)">
                <div class="flex items-start justify-between gap-2 mb-2">
                    <a href="<?= url('/tasks/'.$task['id']) ?>" class="text-sm font-medium text-white hover:text-accent-400 transition-colors flex-1">
                        <?= e($task['title']) ?>
                    </a>
                    <span class="badge text-[10px] <?php echo match($task['priority']??'') { 'urgent'=>'badge-red','high'=>'badge-amber','medium'=>'badge-purple',default=>'badge-cyan' }; ?>">
                        <?php echo match($task['priority']??''){  'urgent'=>'Urgente','high'=>'Haute','medium'=>'Moyenne',default=>'Basse' }; ?>
                    </span>
                </div>
                <?php if (!empty($task['labels'])): ?>
                <div class="flex flex-wrap gap-1 mb-2">
                    <?php foreach ($task['labels'] as $lbl): ?>
                    <span class="text-[10px] px-2 py-0.5 rounded-full" style="background:<?= e($lbl['color']) ?>20;color:<?= e($lbl['color']) ?>"><?= e($lbl['name']) ?></span>
                    <?php endforeach; ?>
                </div>
                <?php endif; ?>
                <?php if ($task['due_date']): ?>
                <p class="text-[11px] text-slate-500 mt-2">
                    <i class="fas fa-clock mr-1"></i> <?= format_date($task['due_date']) ?>
                </p>
                <?php endif; ?>
            </div>
            <?php endforeach; ?>
        </div>
    </div>
    <?php endforeach; ?>
</div>

<script>
function kanbanBoard() {
    return {
        drag(e, id) { e.dataTransfer.setData('text/plain', id); },
        async drop(e, status) {
            const id = e.dataTransfer.getData('text/plain');
            const res = await fetch('<?= url('/tasks/') ?>' + id + '/status', { method:'POST', headers:{'Content-Type':'application/x-www-form-urlencoded'}, body:'status='+status });
            if (res.ok) window.location.reload();
        }
    }
}
</script>

<?php else: ?>
<!-- LIST VIEW -->
<div class="card overflow-hidden">
    <table class="w-full">
        <thead>
            <tr class="border-b border-white/5 text-left">
                <th class="px-5 py-3 text-xs font-medium text-slate-500 uppercase">Tâche</th>
                <th class="px-5 py-3 text-xs font-medium text-slate-500 uppercase hidden md:table-cell">Statut</th>
                <th class="px-5 py-3 text-xs font-medium text-slate-500 uppercase hidden md:table-cell">Priorité</th>
                <th class="px-5 py-3 text-xs font-medium text-slate-500 uppercase hidden lg:table-cell">Échéance</th>
                <th class="px-5 py-3 text-xs font-medium text-slate-500 uppercase w-20">Actions</th>
            </tr>
        </thead>
        <tbody class="divide-y divide-white/5">
            <?php foreach ($tasks ?? [] as $task): ?>
            <tr class="hover:bg-white/5 transition-colors">
                <td class="px-5 py-4">
                    <a href="<?= url('/tasks/'.$task['id']) ?>" class="text-sm font-medium text-white hover:text-accent-400"><?= e($task['title']) ?></a>
                </td>
                <td class="px-5 py-4 hidden md:table-cell">
                    <span class="badge <?php echo match($task['status']){ 'done'=>'badge-emerald','in_progress'=>'badge-amber',default=>'badge-purple' }; ?>">
                        <?php echo match($task['status']){ 'done'=>'Terminé','in_progress'=>'En cours',default=>'À faire' }; ?>
                    </span>
                </td>
                <td class="px-5 py-4 hidden md:table-cell">
                    <span class="badge <?php echo match($task['priority']??''){ 'urgent'=>'badge-red','high'=>'badge-amber','medium'=>'badge-purple',default=>'badge-cyan' }; ?>">
                        <?php echo match($task['priority']??''){ 'urgent'=>'Urgente','high'=>'Haute','medium'=>'Moyenne',default=>'Basse' }; ?>
                    </span>
                </td>
                <td class="px-5 py-4 text-sm text-slate-400 hidden lg:table-cell"><?= $task['due_date'] ? format_date($task['due_date']) : '—' ?></td>
                <td class="px-5 py-4">
                    <a href="<?= url('/tasks/'.$task['id'].'/edit') ?>" class="text-slate-400 hover:text-white text-sm"><i class="fas fa-edit"></i></a>
                </td>
            </tr>
            <?php endforeach; ?>
            <?php if (empty($tasks)): ?>
            <tr><td colspan="5" class="px-5 py-12 text-center text-slate-500">
                <i class="fas fa-inbox text-3xl mb-3 block opacity-50"></i>Aucune tâche
            </td></tr>
            <?php endif; ?>
        </tbody>
    </table>
</div>
<?php endif; ?>
