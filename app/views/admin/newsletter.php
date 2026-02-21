<?php $pageTitle = 'Newsletter — Admin'; ?>
<div class="flex items-center justify-between mb-6">
    <h1 class="text-2xl font-bold text-white"><i class="fas fa-newspaper text-accent-400 mr-3"></i>Newsletter</h1>
    <div class="flex items-center gap-3">
        <span class="text-sm px-3 py-1 rounded-full bg-emerald-500/10 text-emerald-400"><?= count(array_filter($subscribers ?? [], fn($s) => $s['status'] === 'active')) ?> actifs</span>
        <span class="text-sm px-3 py-1 rounded-full bg-slate-500/10 text-slate-400"><?= count($subscribers ?? []) ?> total</span>
    </div>
</div>

<?php if (empty($subscribers)): ?>
<div class="card p-12 text-center">
    <i class="fas fa-envelope-open text-4xl text-slate-600 mb-4 block"></i>
    <p class="text-slate-400">Aucun abonné</p>
</div>
<?php else: ?>
<div class="card overflow-hidden">
    <table class="w-full text-sm">
        <thead>
            <tr class="border-b border-white/5">
                <th class="text-left text-xs font-semibold text-slate-400 uppercase px-5 py-3">Email</th>
                <th class="text-left text-xs font-semibold text-slate-400 uppercase px-5 py-3">Statut</th>
                <th class="text-left text-xs font-semibold text-slate-400 uppercase px-5 py-3">Inscrit le</th>
                <th class="text-right text-xs font-semibold text-slate-400 uppercase px-5 py-3">Actions</th>
            </tr>
        </thead>
        <tbody class="divide-y divide-white/5">
            <?php foreach ($subscribers as $sub): ?>
            <tr class="hover:bg-white/3 transition-colors">
                <td class="px-5 py-3">
                    <div class="flex items-center gap-3">
                        <div class="w-8 h-8 rounded-lg bg-accent-400/10 flex items-center justify-center text-accent-400 text-xs font-bold"><?= strtoupper(substr($sub['email'], 0, 1)) ?></div>
                        <span class="text-white"><?= e($sub['email']) ?></span>
                    </div>
                </td>
                <td class="px-5 py-3">
                    <?php if ($sub['status'] === 'active'): ?>
                    <span class="px-2 py-0.5 rounded-full bg-emerald-500/10 text-emerald-400 text-xs font-medium">Actif</span>
                    <?php else: ?>
                    <span class="px-2 py-0.5 rounded-full bg-red-500/10 text-red-400 text-xs font-medium">Désabonné</span>
                    <?php endif; ?>
                </td>
                <td class="px-5 py-3 text-slate-400"><?= format_date($sub['subscribed_at'] ?? $sub['created_at']) ?></td>
                <td class="px-5 py-3 text-right">
                    <form method="POST" action="<?= url('/admin/newsletter/'.$sub['id'].'/delete') ?>" onsubmit="return confirm('Supprimer ?')" class="inline">
                        <?= csrf_field() ?>
                        <button class="text-xs text-red-400 hover:text-red-300"><i class="fas fa-trash"></i></button>
                    </form>
                </td>
            </tr>
            <?php endforeach; ?>
        </tbody>
    </table>
</div>
<?php endif; ?>
