<?php $pageTitle = __('notes'); ?>
<div class="flex h-[calc(100vh-120px)]">
    <!-- Notes Tree Sidebar -->
    <div class="w-64 flex-shrink-0 glass rounded-2xl mr-4 flex flex-col overflow-hidden hidden lg:flex">
        <div class="p-4 border-b border-white/5 flex items-center justify-between">
            <h3 class="text-sm font-semibold text-white">Notes</h3>
            <a href="<?= url('/notes/create') ?>" class="w-7 h-7 rounded-lg bg-primary-500/20 flex items-center justify-center text-primary-400 hover:bg-primary-500/30 transition-colors text-xs"><i class="fas fa-plus"></i></a>
        </div>
        <div class="flex-1 overflow-y-auto p-2 space-y-0.5">
            <?php if (empty($notes)): ?>
            <p class="text-sm text-slate-500 text-center py-4">Aucune note</p>
            <?php else: ?>
            <?php foreach ($notes as $n): ?>
            <?php echo renderNoteTree($n, $note ?? null); ?>
            <?php endforeach; ?>
            <?php endif; ?>
        </div>
    </div>

    <!-- Editor Area -->
    <div class="flex-1 glass rounded-2xl flex flex-col overflow-hidden">
        <?php if ($note): ?>
        <form method="POST" action="<?= url('/notes/'.$note['id'].'/edit') ?>" class="flex flex-col h-full" x-data="noteEditor(<?= $note['id'] ?>)">
            <?= csrf_field() ?>
            <div class="flex items-center gap-3 px-5 py-3 border-b border-white/5">
                <input type="text" name="title" value="<?= e($note['title']) ?>" class="text-lg font-bold text-white bg-transparent outline-none flex-1" placeholder="Titre de la note" @input="autoSave()">
                <span x-show="saving" class="text-xs text-slate-500"><i class="fas fa-circle-notch fa-spin"></i> Sauvegarde...</span>
                <span x-show="savedAt" x-text="'Sauvé à ' + savedAt" class="text-xs text-emerald-400"></span>
                <button type="submit" class="btn-primary text-sm"><i class="fas fa-save mr-1"></i>Sauvegarder</button>
                <div class="relative" x-data="{ open: false }">
                    <button type="button" @click="open = !open" class="text-slate-400 hover:text-white"><i class="fas fa-ellipsis-v"></i></button>
                    <div x-show="open" @click.outside="open = false" class="dropdown-menu absolute right-0 mt-2 w-40 p-1">
                        <a href="<?= url('/notes/create?parent_id='.$note['id']) ?>" class="block px-3 py-2 text-sm text-slate-400 hover:text-white hover:bg-white/5 rounded-lg"><i class="fas fa-plus mr-2"></i>Sous-note</a>
                    </div>
                </div>
            </div>
            <div class="flex-1 overflow-y-auto p-5">
                <textarea name="content" class="w-full h-full bg-transparent text-slate-300 text-sm outline-none resize-none leading-relaxed" placeholder="Commencez à écrire..." @input="autoSave()"><?= e($note['content']??'') ?></textarea>
            </div>
        </form>
        <?php else: ?>
        <div class="flex-1 flex items-center justify-center text-center p-8">
            <div>
                <i class="fas fa-sticky-note text-5xl text-primary-400/30 mb-4 block"></i>
                <h2 class="text-xl font-semibold text-white mb-2">Bienvenue dans Notes</h2>
                <p class="text-sm text-slate-400 mb-6">Créez votre première note pour commencer</p>
                <a href="<?= url('/notes/create') ?>" class="btn-primary inline-flex items-center gap-2"><i class="fas fa-plus"></i>Créer une note</a>
            </div>
        </div>
        <?php endif; ?>
    </div>
</div>

<?php
function renderNoteTree(array $note, ?array $current): string {
    $active = $current && $current['id'] == $note['id'];
    $html = '<a href="'.url('/notes/'.$note['id']).'" class="flex items-center gap-2 px-3 py-1.5 rounded-lg text-sm transition-colors '.($active ? 'bg-primary-500/15 text-primary-300' : 'text-slate-400 hover:text-white hover:bg-white/5').'">
        <span>'.e($note['icon']??'📝').'</span><span class="truncate">'.e($note['title']).'</span></a>';
    if (!empty($note['children'])) {
        $html .= '<div class="ml-4 border-l border-white/5 pl-1">';
        foreach ($note['children'] as $child) $html .= renderNoteTree($child, $current);
        $html .= '</div>';
    }
    return $html;
}
?>

<script>
function noteEditor(noteId) {
    return {
        saving: false, savedAt: null, timeout: null,
        autoSave() {
            clearTimeout(this.timeout);
            this.timeout = setTimeout(async () => {
                this.saving = true;
                const title = document.querySelector('input[name="title"]').value;
                const content = document.querySelector('textarea[name="content"]').value;
                const res = await fetch('<?= url('/notes/') ?>' + noteId + '/autosave', {
                    method: 'POST', headers: { 'Content-Type': 'application/json' },
                    body: JSON.stringify({ title, content })
                });
                const data = await res.json();
                this.saving = false;
                this.savedAt = data.saved_at || null;
            }, 2000);
        }
    }
}
</script>
