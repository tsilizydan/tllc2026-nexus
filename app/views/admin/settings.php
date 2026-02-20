<?php $pageTitle = 'Paramètres'; ?>
<div class="max-w-3xl mx-auto">
    <div class="flex items-center gap-3 mb-6"><a href="<?= url('/admin') ?>" class="text-slate-400 hover:text-white"><i class="fas fa-arrow-left"></i></a><h1 class="text-xl font-bold text-white"><i class="fas fa-cog text-accent-400 mr-2"></i>Paramètres</h1></div>
    <form method="POST" action="<?= url('/admin/settings') ?>" class="space-y-6">
        <?= csrf_field() ?>
        <div class="card p-6 space-y-4">
            <h3 class="text-sm font-semibold text-white">Général</h3>
            <div><label class="block text-sm text-slate-300 mb-2">Nom de l'application</label><input type="text" name="app_name" class="input" value="<?= e($settings['app_name']??'TSILIZY Nexus') ?>"></div>
            <div><label class="block text-sm text-slate-300 mb-2">Email de contact</label><input type="email" name="contact_email" class="input" value="<?= e($settings['contact_email']??'') ?>"></div>
            <div><label class="block text-sm text-slate-300 mb-2">Message de maintenance</label><textarea name="maintenance_message" rows="2" class="input"><?= e($settings['maintenance_message']??'') ?></textarea></div>
        </div>
        <div class="card p-6 space-y-4">
            <h3 class="text-sm font-semibold text-white">Fonctionnalités</h3>
            <?php foreach (['tasks'=>'Tâches','notes'=>'Notes','agenda'=>'Agenda','projects'=>'Projets','contacts'=>'Contacts','websites'=>'Sites web','company'=>'Entreprise'] as $k=>$l): ?>
            <label class="flex items-center justify-between p-2 rounded-lg hover:bg-white/5 cursor-pointer">
                <span class="text-sm text-slate-300"><?= $l ?></span>
                <input type="hidden" name="feature_<?= $k ?>" value="0">
                <input type="checkbox" name="feature_<?= $k ?>" value="1" class="accent-primary-500" <?= ($settings['feature_'.$k]??'1')==='1'?'checked':'' ?>>
            </label>
            <?php endforeach; ?>
        </div>
        <div class="flex justify-end"><button type="submit" class="btn-primary"><i class="fas fa-save mr-2"></i>Enregistrer</button></div>
    </form>
</div>
