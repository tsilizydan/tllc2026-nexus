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
            <h1 class="text-3xl font-bold text-white mb-2">Politique de confidentialité</h1>
            <p class="text-sm text-slate-500 mb-8">Dernière mise à jour : <?= date('d/m/Y') ?></p>

            <div class="prose prose-invert max-w-none space-y-6 text-slate-300 text-sm leading-relaxed">
                <h2 class="text-xl font-semibold text-white mt-8">1. Collecte des données</h2>
                <p>Nous collectons uniquement les données nécessaires au fonctionnement du Service :</p>
                <ul class="list-disc list-inside space-y-1 text-slate-400">
                    <li><strong class="text-white">Données d'inscription :</strong> nom, adresse email, mot de passe (chiffré)</li>
                    <li><strong class="text-white">Données d'utilisation :</strong> tâches, projets, contacts, notes que vous créez</li>
                    <li><strong class="text-white">Données techniques :</strong> adresse IP, type de navigateur, horodatage de connexion</li>
                </ul>

                <h2 class="text-xl font-semibold text-white mt-8">2. Utilisation des données</h2>
                <p>Vos données sont utilisées exclusivement pour :</p>
                <ul class="list-disc list-inside space-y-1 text-slate-400">
                    <li>Fournir et améliorer le Service</li>
                    <li>Assurer la sécurité de votre compte</li>
                    <li>Communiquer avec vous (notifications, mises à jour)</li>
                </ul>

                <h2 class="text-xl font-semibold text-white mt-8">3. Protection des données</h2>
                <p>Nous mettons en oeuvre des mesures de sécurité robustes :</p>
                <ul class="list-disc list-inside space-y-1 text-slate-400">
                    <li>Mots de passe chiffrés avec bcrypt (coût 12)</li>
                    <li>Protection CSRF sur tous les formulaires</li>
                    <li>Protection contre les injections SQL via requêtes préparées</li>
                    <li>Protection XSS via l'échappement systématique des sorties</li>
                    <li>Sessions sécurisées (HttpOnly, SameSite, Strict Mode)</li>
                    <li>En-têtes de sécurité HTTP (X-Frame-Options, CSP, etc.)</li>
                </ul>

                <h2 class="text-xl font-semibold text-white mt-8">4. Partage des données</h2>
                <p>Nous ne vendons, ne louons et ne partageons jamais vos données personnelles avec des tiers. Vos données restent strictement confidentielles.</p>

                <h2 class="text-xl font-semibold text-white mt-8">5. Cookies</h2>
                <p>Nous utilisons uniquement des cookies techniques essentiels au fonctionnement du Service (session, authentification). Aucun cookie de suivi ou publicitaire n'est utilisé.</p>

                <h2 class="text-xl font-semibold text-white mt-8">6. Conservation des données</h2>
                <p>Vos données sont conservées tant que votre compte est actif. En cas de suppression, vos données sont effacées dans un délai de 30 jours.</p>

                <h2 class="text-xl font-semibold text-white mt-8">7. Vos droits</h2>
                <p>Conformément à la réglementation applicable, vous disposez des droits suivants :</p>
                <ul class="list-disc list-inside space-y-1 text-slate-400">
                    <li><strong class="text-white">Accès :</strong> obtenir une copie de vos données</li>
                    <li><strong class="text-white">Rectification :</strong> modifier vos données depuis votre profil</li>
                    <li><strong class="text-white">Suppression :</strong> supprimer votre compte et toutes vos données</li>
                    <li><strong class="text-white">Portabilité :</strong> exporter vos données en format standard</li>
                </ul>

                <h2 class="text-xl font-semibold text-white mt-8">8. Contact</h2>
                <p>Pour toute question relative à vos données, contactez notre délégué à la protection des données : <a href="mailto:privacy@tsilizy.com" class="text-accent-400 hover:underline">privacy@tsilizy.com</a>.</p>
            </div>
        </div>
    </main>

    <footer class="border-t border-white/5 py-6 text-center">
        <p class="text-xs text-slate-600">&copy; <?= date('Y') ?> TSILIZY LLC — Tous droits réservés</p>
    </footer>
</body>
</html>
