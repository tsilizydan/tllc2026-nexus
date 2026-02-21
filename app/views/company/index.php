<?php $pageTitle = __('company_profile'); ?>
<div class="max-w-4xl mx-auto">
    <h1 class="text-2xl font-bold text-white mb-6"><i class="fas fa-building text-primary-400 mr-3"></i><?= __('company_profile') ?></h1>
    <form method="POST" action="<?= url('/company/update') ?>" class="card p-6 space-y-6">
        <?= csrf_field() ?>
        <div class="grid grid-cols-1 sm:grid-cols-2 gap-4">
            <div><label class="block text-sm font-medium text-slate-300 mb-2">Nom de l'entreprise</label><input type="text" name="name" class="input" value="<?= e($company['name']??'') ?>"></div>
            <div><label class="block text-sm font-medium text-slate-300 mb-2">Gérant / Directeur</label><input type="text" name="manager" class="input" value="<?= e($company['manager']??'') ?>"></div>
        </div>
        <div class="grid grid-cols-1 sm:grid-cols-3 gap-4">
            <div><label class="block text-sm font-medium text-slate-300 mb-2">Type</label><select name="type" class="input">
                <option value="">—</option>
                <?php foreach(['SARL'=>'SARL','SA'=>'SA','SAS'=>'SAS','SASU'=>'SASU','EI'=>'Entreprise Individuelle','AUTO'=>'Auto-entrepreneur','Autre'=>'Autre'] as $v=>$l): ?>
                <option value="<?= $v ?>" <?= ($company['type']??'')===$v?'selected':'' ?>><?= $l ?></option><?php endforeach; ?>
            </select></div>
            <div><label class="block text-sm font-medium text-slate-300 mb-2">Capital</label><input type="text" name="capital" class="input" value="<?= e($company['capital']??'') ?>" placeholder="Ex: 1 000 000 FCFA"></div>
            <div><label class="block text-sm font-medium text-slate-300 mb-2">Nombre d'employés</label><input type="number" name="employees" class="input" value="<?= e($company['employees']??'') ?>"></div>
        </div>
        <div class="grid grid-cols-1 sm:grid-cols-2 gap-4">
            <div><label class="block text-sm font-medium text-slate-300 mb-2">Téléphone</label><input type="text" name="phone" class="input" value="<?= e($company['phone']??'') ?>"></div>
            <div><label class="block text-sm font-medium text-slate-300 mb-2">Email</label><input type="email" name="email" class="input" value="<?= e($company['email']??'') ?>"></div>
        </div>
        <div><label class="block text-sm font-medium text-slate-300 mb-2">Adresse</label><textarea name="address" rows="2" class="input"><?= e($company['address']??'') ?></textarea></div>
        <div class="grid grid-cols-1 sm:grid-cols-2 gap-4">
            <div><label class="block text-sm font-medium text-slate-300 mb-2">N° Registre de Commerce</label><input type="text" name="registration_number" class="input" value="<?= e($company['registration_number']??'') ?>"></div>
            <div><label class="block text-sm font-medium text-slate-300 mb-2">N° Identification Fiscale</label><input type="text" name="tax_id" class="input" value="<?= e($company['tax_id']??'') ?>"></div>
        </div>
        <div><label class="block text-sm font-medium text-slate-300 mb-2">Site web</label><input type="url" name="website" class="input" value="<?= e($company['website']??'') ?>"></div>
        <div><label class="block text-sm font-medium text-slate-300 mb-2">Description</label><textarea name="description" rows="3" class="input"><?= e($company['description']??'') ?></textarea></div>
        <div><label class="block text-sm font-medium text-slate-300 mb-2">Notes internes</label><textarea name="notes" rows="3" class="input"><?= e($company['notes']??'') ?></textarea></div>
        <div class="flex justify-end pt-4 border-t border-white/5"><button type="submit" class="btn-primary"><i class="fas fa-save mr-2"></i>Enregistrer</button></div>
    </form>
</div>
