<?php $pageTitle = __('contact_us') . ' — Admin'; ?>
<div class="flex items-center justify-between mb-6">
    <h1 class="text-2xl font-bold text-white"><i class="fas fa-envelope text-primary-400 mr-3"></i>Messages de contact</h1>
    <span class="text-sm px-3 py-1 rounded-full bg-primary-500/10 text-primary-400"><?= count($messages ?? []) ?> messages</span>
</div>

<?php if (empty($messages)): ?>
<div class="card p-12 text-center">
    <i class="fas fa-inbox text-4xl text-slate-600 mb-4 block"></i>
    <p class="text-slate-400">Aucun message reçu</p>
</div>
<?php else: ?>
<div class="space-y-3">
    <?php foreach ($messages as $msg): ?>
    <div class="card p-5 group hover:border-primary-500/20 transition-all" x-data="{ open: false }">
        <div class="flex items-start gap-4 cursor-pointer" @click="open = !open">
            <div class="w-10 h-10 rounded-xl gradient-bg flex items-center justify-center text-white text-sm font-bold flex-shrink-0">
                <?= strtoupper(substr($msg['name'], 0, 1)) ?>
            </div>
            <div class="flex-1 min-w-0">
                <div class="flex items-center gap-3 flex-wrap">
                    <span class="font-semibold text-white text-sm"><?= e($msg['name']) ?></span>
                    <span class="text-xs text-slate-500">&lt;<?= e($msg['email']) ?>&gt;</span>
                    <?php if ($msg['status'] === 'unread'): ?>
                    <span class="px-2 py-0.5 rounded-full bg-primary-500/20 text-primary-400 text-[10px] font-semibold">Nouveau</span>
                    <?php endif; ?>
                </div>
                <p class="text-sm text-slate-300 truncate"><?= e($msg['subject'] ?? 'Pas de sujet') ?></p>
                <p class="text-xs text-slate-500 mt-1"><?= format_date($msg['created_at']) ?></p>
            </div>
            <i :class="open ? 'fas fa-chevron-up' : 'fas fa-chevron-down'" class="text-slate-500 text-sm mt-2"></i>
        </div>
        <div x-show="open" x-transition class="mt-4 pt-4 border-t border-white/5">
            <div class="text-sm text-slate-300 leading-relaxed whitespace-pre-line"><?= e($msg['message']) ?></div>
            <div class="flex items-center gap-3 mt-4">
                <?php if ($msg['status'] === 'unread'): ?>
                <form method="POST" action="<?= url('/admin/messages/'.$msg['id'].'/read') ?>" class="inline">
                    <?= csrf_field() ?>
                    <button class="text-xs px-3 py-1.5 rounded-lg bg-emerald-500/10 text-emerald-400 hover:bg-emerald-500/20 transition-colors"><i class="fas fa-check mr-1"></i>Marquer lu</button>
                </form>
                <?php endif; ?>
                <a href="mailto:<?= e($msg['email']) ?>?subject=Re: <?= e($msg['subject'] ?? '') ?>" class="text-xs px-3 py-1.5 rounded-lg bg-primary-500/10 text-primary-400 hover:bg-primary-500/20 transition-colors"><i class="fas fa-reply mr-1"></i>Répondre</a>
                <form method="POST" action="<?= url('/admin/messages/'.$msg['id'].'/delete') ?>" onsubmit="return confirm('Supprimer ce message ?')" class="inline">
                    <?= csrf_field() ?>
                    <button class="text-xs px-3 py-1.5 rounded-lg bg-red-500/10 text-red-400 hover:bg-red-500/20 transition-colors"><i class="fas fa-trash mr-1"></i>Supprimer</button>
                </form>
                <?php if ($msg['ip_address']): ?>
                <span class="text-[10px] text-slate-600 ml-auto">IP: <?= e($msg['ip_address']) ?></span>
                <?php endif; ?>
            </div>
        </div>
    </div>
    <?php endforeach; ?>
</div>
<?php endif; ?>
