<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title><?= e($pageTitle) ?> — <?= e($appName) ?></title>
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@400;500;600;700&display=swap" rel="stylesheet">
    <script src="https://cdn.tailwindcss.com"></script>
    <script>tailwind.config={theme:{extend:{colors:{primary:{500:'#6C3CE1'},accent:{400:'#22D3EE'}},fontFamily:{sans:['Inter','system-ui']}}}}</script>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.1/css/all.min.css">
    <style>
        body{font-family:'Inter',system-ui;background:#0F172A;color:#e2e8f0}
        .gradient-text{background:linear-gradient(135deg,#6C3CE1,#22D3EE);-webkit-background-clip:text;-webkit-text-fill-color:transparent}
        .glass{background:rgba(30,41,59,0.5);backdrop-filter:blur(20px);border:1px solid rgba(255,255,255,0.06)}
    </style>
</head>
<body class="min-h-screen">
    <!-- Nav -->
    <nav class="border-b border-white/5 py-4">
        <div class="max-w-4xl mx-auto px-4 flex items-center justify-between">
            <a href="<?= url('/') ?>" class="flex items-center gap-2">
                <div class="w-8 h-8 rounded-lg bg-gradient-to-br from-primary-500 to-accent-400 flex items-center justify-center">
                    <i class="fas fa-bolt text-white text-sm"></i>
                </div>
                <span class="font-bold gradient-text"><?= e($appName) ?></span>
            </a>
            <a href="<?= url('/') ?>" class="text-sm text-slate-500 hover:text-white transition-colors"><i class="fas fa-arrow-left mr-1"></i>Retour</a>
        </div>
    </nav>

    <main class="max-w-4xl mx-auto px-4 py-12">
        <div class="glass rounded-2xl p-8 lg:p-12">
            <h1 class="text-3xl font-bold text-white mb-2">Conditions d'utilisation</h1>
            <p class="text-sm text-slate-500 mb-8">Dernière mise à jour : <?= date('d/m/Y') ?></p>

            <div class="prose prose-invert max-w-none space-y-6 text-slate-300 text-sm leading-relaxed">
                <h2 class="text-xl font-semibold text-white mt-8">1. Acceptation des conditions</h2>
                <p>En accédant et en utilisant la plateforme TSILIZY Nexus ("le Service"), vous acceptez d'être lié par les présentes conditions d'utilisation. Si vous n'acceptez pas ces conditions, veuillez ne pas utiliser le Service.</p>

                <h2 class="text-xl font-semibold text-white mt-8">2. Description du Service</h2>
                <p>TSILIZY Nexus est une plateforme de productivité proposée par TSILIZY LLC. Elle offre des outils de gestion de tâches, de projets, de contacts, de notes, d'agenda et de sites web.</p>

                <h2 class="text-xl font-semibold text-white mt-8">3. Inscription et compte</h2>
                <p>Pour utiliser le Service, vous devez créer un compte avec des informations véridiques. Vous êtes responsable de la confidentialité de votre mot de passe et de toute activité effectuée sous votre compte.</p>

                <h2 class="text-xl font-semibold text-white mt-8">4. Utilisation acceptable</h2>
                <p>Vous vous engagez à ne pas :</p>
                <ul class="list-disc list-inside space-y-1 text-slate-400">
                    <li>Utiliser le Service à des fins illégales ou non autorisées</li>
                    <li>Tenter d'accéder à des données d'autres utilisateurs</li>
                    <li>Transmettre du contenu malveillant ou nuisible</li>
                    <li>Surcharger ou perturber le fonctionnement du Service</li>
                </ul>

                <h2 class="text-xl font-semibold text-white mt-8">5. Propriété intellectuelle</h2>
                <p>Le Service, son design, son code source et ses contenus sont la propriété de TSILIZY LLC. Vos données vous appartiennent et nous ne revendiquons aucun droit dessus.</p>

                <h2 class="text-xl font-semibold text-white mt-8">6. Tarification</h2>
                <p>Le plan gratuit est disponible sans limitation de durée. Les contributions sont volontaires et non remboursables. TSILIZY LLC se réserve le droit de modifier les tarifs avec un préavis de 30 jours.</p>

                <h2 class="text-xl font-semibold text-white mt-8">7. Limitation de responsabilité</h2>
                <p>Le Service est fourni "tel quel". TSILIZY LLC ne garantit pas que le Service sera exempt d'erreurs ou d'interruptions. En aucun cas, TSILIZY LLC ne sera responsable de dommages indirects.</p>

                <h2 class="text-xl font-semibold text-white mt-8">8. Résiliation</h2>
                <p>Vous pouvez supprimer votre compte à tout moment. TSILIZY LLC se réserve le droit de suspendre ou de supprimer un compte en cas de violation des présentes conditions.</p>

                <h2 class="text-xl font-semibold text-white mt-8">9. Modifications</h2>
                <p>TSILIZY LLC peut modifier ces conditions à tout moment. Les utilisateurs seront informés par email des modifications substantielles.</p>

                <h2 class="text-xl font-semibold text-white mt-8">10. Contact</h2>
                <p>Pour toute question, contactez-nous à <a href="mailto:contact@tsilizy.com" class="text-accent-400 hover:underline">contact@tsilizy.com</a>.</p>
            </div>
        </div>
    </main>

    <footer class="border-t border-white/5 py-6 text-center">
        <p class="text-xs text-slate-600">&copy; <?= date('Y') ?> TSILIZY LLC — Tous droits réservés</p>
    </footer>
</body>
</html>
