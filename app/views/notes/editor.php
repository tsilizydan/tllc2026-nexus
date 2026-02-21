<?php $pageTitle = __('notes'); ?>
<div class="flex h-[calc(100vh-120px)]" x-data="{ mobileTree: false }">
    <!-- Notes Tree Sidebar -->
    <div class="w-64 flex-shrink-0 glass rounded-2xl mr-4 flex flex-col overflow-hidden hidden lg:flex">
        <div class="p-4 border-b border-white/5 flex items-center justify-between">
            <h3 class="text-sm font-semibold text-white"><?= __('notes') ?></h3>
            <a href="<?= url('/notes/create') ?>" class="w-7 h-7 rounded-lg bg-primary-500/20 flex items-center justify-center text-primary-400 hover:bg-primary-500/30 transition-colors text-xs"><i class="fas fa-plus"></i></a>
        </div>
        <div class="px-3 py-2 border-b border-white/5">
            <input type="text" placeholder="<?= __('search') ?>..." class="input text-xs py-1.5 w-full" x-data x-on:input="
                document.querySelectorAll('.note-tree-item').forEach(el => {
                    el.style.display = el.textContent.toLowerCase().includes($el.value.toLowerCase()) ? '' : 'none';
                });
            ">
        </div>
        <div class="flex-1 overflow-y-auto p-2 space-y-0.5">
            <?php if (empty($notes)): ?>
            <p class="text-sm text-slate-500 text-center py-4"><?= __('no_results') ?></p>
            <?php else: ?>
            <?php foreach ($notes as $n): ?>
            <?php echo renderNoteTree($n, $note ?? null); ?>
            <?php endforeach; ?>
            <?php endif; ?>
        </div>
    </div>

    <!-- Mobile tree toggle -->
    <button @click="mobileTree = !mobileTree" class="lg:hidden fixed bottom-6 left-6 z-40 w-12 h-12 rounded-xl gradient-bg text-white flex items-center justify-center shadow-lg">
        <i class="fas fa-list"></i>
    </button>
    <div x-show="mobileTree" x-transition class="lg:hidden fixed inset-0 z-50">
        <div class="absolute inset-0 bg-black/60" @click="mobileTree = false"></div>
        <div class="absolute left-0 top-0 bottom-0 w-72 glass-solid p-4 overflow-y-auto" @click.stop>
            <div class="flex items-center justify-between mb-4">
                <h3 class="text-sm font-semibold text-white"><?= __('notes') ?></h3>
                <button @click="mobileTree = false" class="text-slate-400"><i class="fas fa-times"></i></button>
            </div>
            <?php if (!empty($notes)): ?>
            <?php foreach ($notes as $n): echo renderNoteTree($n, $note ?? null); endforeach; ?>
            <?php endif; ?>
            <a href="<?= url('/notes/create') ?>" class="block mt-4 btn-primary text-sm text-center"><i class="fas fa-plus mr-1"></i><?= __('new_note') ?></a>
        </div>
    </div>

    <!-- Editor Area -->
    <div class="flex-1 glass rounded-2xl flex flex-col overflow-hidden">
        <?php if ($note): ?>
        <form method="POST" action="<?= url('/notes/'.$note['id'].'/update') ?>" class="flex flex-col h-full" x-data="noteEditor(<?= $note['id'] ?>)">
            <?= csrf_field() ?>
            <div class="flex items-center gap-3 px-5 py-3 border-b border-white/5">
                <select name="icon" class="bg-transparent text-xl cursor-pointer outline-none border-none" style="width:36px">
                    <?php foreach (['📝','📌','⭐','💡','📋','🔖','📎','🎯','💼','🗂️'] as $ic): ?>
                    <option value="<?= $ic ?>" <?= ($note['icon']??'📝') === $ic ? 'selected' : '' ?>><?= $ic ?></option>
                    <?php endforeach; ?>
                </select>
                <input type="text" name="title" value="<?= e($note['title']) ?>" class="text-lg font-bold text-white bg-transparent outline-none flex-1" placeholder="<?= __('note_title') ?>" @input="autoSave()">
                <span x-show="saving" class="text-xs text-slate-500"><i class="fas fa-circle-notch fa-spin"></i> <?= __('loading') ?></span>
                <span x-show="savedAt" x-text="'✓ ' + savedAt" class="text-xs text-emerald-400"></span>
                <span class="text-xs text-slate-500" x-text="wordCount + ' mots'"></span>
                <button type="submit" class="btn-primary text-sm"><i class="fas fa-save mr-1"></i><?= __('save') ?></button>
                <div class="relative" x-data="{ open: false }">
                    <button type="button" @click="open = !open" class="text-slate-400 hover:text-white"><i class="fas fa-ellipsis-v"></i></button>
                    <div x-show="open" @click.outside="open = false" class="dropdown-menu absolute right-0 mt-2 w-48 p-1">
                        <a href="<?= url('/notes/create?parent_id='.$note['id']) ?>" class="block px-3 py-2 text-sm text-slate-400 hover:text-white hover:bg-white/5 rounded-lg"><i class="fas fa-plus mr-2"></i><?= __('create') ?> sous-note</a>
                        <button type="button" @click="copyMarkdown()" class="w-full text-left px-3 py-2 text-sm text-slate-400 hover:text-white hover:bg-white/5 rounded-lg"><i class="fas fa-copy mr-2"></i>Copier texte</button>
                        <form method="POST" action="<?= url('/notes/'.$note['id'].'/delete') ?>" onsubmit="return confirm('<?= __('confirm') ?> ?')" class="block">
                            <?= csrf_field() ?>
                            <button type="submit" class="w-full text-left px-3 py-2 text-sm text-red-400 hover:text-red-300 hover:bg-red-500/5 rounded-lg"><i class="fas fa-trash mr-2"></i><?= __('delete') ?></button>
                        </form>
                    </div>
                </div>
            </div>
            <div class="flex-1 overflow-y-auto p-5">
                <textarea name="content" class="w-full h-full bg-transparent text-slate-300 text-sm outline-none resize-none leading-relaxed font-mono" placeholder="<?= __('note_content') ?>..." @input="autoSave(); updateWordCount()"><?= e($note['content']??'') ?></textarea>
            </div>
        </form>
        <?php else: ?>
        <!-- CREATE NEW NOTE FORM -->
        <form method="POST" action="<?= url('/notes/store') ?>" class="flex flex-col h-full" x-data="{ title: '' }">
            <?= csrf_field() ?>
            <?php if (!empty($parentId)): ?>
            <input type="hidden" name="parent_id" value="<?= e($parentId) ?>">
            <?php endif; ?>
            <div class="flex items-center gap-3 px-5 py-3 border-b border-white/5">
                <select name="icon" class="bg-transparent text-xl cursor-pointer outline-none border-none" style="width:36px">
                    <?php foreach (['📝','📌','⭐','💡','📋','🔖','📎','🎯','💼','🗂️'] as $ic): ?>
                    <option value="<?= $ic ?>"><?= $ic ?></option>
                    <?php endforeach; ?>
                </select>
                <input type="text" name="title" x-model="title" class="text-lg font-bold text-white bg-transparent outline-none flex-1" placeholder="<?= __('note_title') ?>" required autofocus>
                <button type="submit" class="btn-primary text-sm" :disabled="!title.trim()"><i class="fas fa-plus mr-1"></i><?= __('create') ?></button>
            </div>
            <div class="flex-1 overflow-y-auto p-5">
                <textarea name="content" class="w-full h-full bg-transparent text-slate-300 text-sm outline-none resize-none leading-relaxed font-mono" placeholder="<?= __('note_content') ?>..."></textarea>
            </div>
        </form>
        <?php endif; ?>
    </div>
</div>

<?php
function renderNoteTree(array $note, ?array $current): string {
    $active = $current && $current['id'] == $note['id'];
    $html = '<a href="'.url('/notes/'.$note['id']).'" class="note-tree-item flex items-center gap-2 px-3 py-1.5 rounded-lg text-sm transition-colors '.($active ? 'bg-primary-500/15 text-primary-300' : 'text-slate-400 hover:text-white hover:bg-white/5').'">
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
        saving: false, savedAt: null, timeout: null, wordCount: 0,
        init() { this.updateWordCount(); },
        updateWordCount() {
            const t = document.querySelector('textarea[name="content"]');
            this.wordCount = t ? t.value.trim().split(/\s+/).filter(w => w).length : 0;
        },
        copyMarkdown() {
            const t = document.querySelector('textarea[name="content"]');
            if (t) { navigator.clipboard.writeText(t.value); }
        },
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
                this.updateWordCount();
            }, 2000);
        }
    }
}
</script>
