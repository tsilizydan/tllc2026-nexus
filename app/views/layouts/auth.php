<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title><?= e($pageTitle ?? 'Connexion') ?> — <?= e($appName ?? 'TSILIZY Nexus') ?></title>
    <meta name="description" content="TSILIZY Nexus — Connexion à l'espace de travail">
    <meta name="robots" content="noindex, nofollow">
    <meta name="theme-color" content="#0F172A">
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@300;400;500;600;700;800;900&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.1/css/all.min.css">
    <style>
        * { margin: 0; padding: 0; box-sizing: border-box; }
        body {
            font-family: 'Inter', system-ui, sans-serif;
            background: #0F172A;
            color: #e2e8f0;
            min-height: 100vh;
            display: flex;
            align-items: center;
            justify-content: center;
            position: relative;
            overflow: hidden;
        }

        /* Animated background orbs */
        body::before, body::after {
            content: '';
            position: absolute;
            border-radius: 50%;
            filter: blur(100px);
            opacity: 0.15;
            animation: float 8s ease-in-out infinite;
        }
        body::before {
            width: 400px; height: 400px;
            background: #6C3CE1;
            top: -100px; left: -100px;
        }
        body::after {
            width: 300px; height: 300px;
            background: #22D3EE;
            bottom: -50px; right: -50px;
            animation-delay: -4s;
        }
        @keyframes float {
            0%, 100% { transform: translate(0, 0) scale(1); }
            50% { transform: translate(30px, -30px) scale(1.05); }
        }

        .auth-card {
            position: relative;
            z-index: 1;
            width: 100%;
            max-width: 440px;
            background: rgba(30,41,59,0.7);
            backdrop-filter: blur(20px);
            -webkit-backdrop-filter: blur(20px);
            border: 1px solid rgba(255,255,255,0.06);
            border-radius: 1.5rem;
            padding: 2.5rem;
            box-shadow: 0 25px 60px rgba(0,0,0,0.5);
            animation: slideUp 0.6s ease-out;
        }
        @keyframes slideUp {
            from { opacity: 0; transform: translateY(30px); }
            to { opacity: 1; transform: translateY(0); }
        }

        .auth-logo {
            display: flex;
            align-items: center;
            justify-content: center;
            gap: 0.75rem;
            margin-bottom: 2rem;
        }
        .auth-logo .icon {
            width: 48px; height: 48px;
            border-radius: 1rem;
            background: linear-gradient(135deg, #6C3CE1, #22D3EE);
            display: flex; align-items: center; justify-content: center;
        }
        .auth-logo .text h1 {
            font-size: 1.5rem; font-weight: 800;
            background: linear-gradient(135deg, #6C3CE1, #22D3EE);
            -webkit-background-clip: text; -webkit-text-fill-color: transparent;
        }
        .auth-logo .text p { font-size: 0.75rem; color: #64748b; }

        .form-group { margin-bottom: 1.25rem; }
        .form-label {
            display: block; font-size: 0.8125rem; font-weight: 500;
            color: #94a3b8; margin-bottom: 0.5rem;
        }
        .form-input {
            width: 100%;
            background: rgba(255,255,255,0.05);
            border: 1px solid rgba(255,255,255,0.1);
            border-radius: 0.75rem;
            padding: 0.75rem 1rem;
            color: white;
            font-size: 0.9375rem;
            outline: none;
            transition: all 0.3s;
        }
        .form-input:focus {
            border-color: #6C3CE1;
            box-shadow: 0 0 0 3px rgba(108,60,225,0.15);
        }
        .form-input::placeholder { color: #475569; }

        .btn-submit {
            width: 100%;
            background: linear-gradient(135deg, #6C3CE1, #5a1fd4);
            color: white;
            padding: 0.875rem;
            border-radius: 0.75rem;
            font-weight: 700;
            font-size: 0.9375rem;
            border: none;
            cursor: pointer;
            transition: all 0.3s;
            margin-top: 0.5rem;
        }
        .btn-submit:hover {
            box-shadow: 0 8px 25px rgba(108,60,225,0.4);
            transform: translateY(-1px);
        }

        .auth-link {
            color: #6C3CE1; text-decoration: none;
            font-weight: 500; transition: color 0.2s;
        }
        .auth-link:hover { color: #22D3EE; }

        .auth-footer { text-align: center; margin-top: 1.5rem; font-size: 0.875rem; color: #64748b; }

        /* Alert styles */
        .alert { padding: 0.75rem 1rem; border-radius: 0.75rem; margin-bottom: 1.25rem; font-size: 0.875rem; display: flex; align-items: center; gap: 0.5rem; }
        .alert-error { background: rgba(239,68,68,0.1); border: 1px solid rgba(239,68,68,0.2); color: #fca5a5; }
        .alert-success { background: rgba(16,185,129,0.1); border: 1px solid rgba(16,185,129,0.2); color: #6ee7b7; }
        .alert-info { background: rgba(34,211,238,0.1); border: 1px solid rgba(34,211,238,0.2); color: #67e8f9; }

        .checkbox-group { display: flex; align-items: center; gap: 0.5rem; }
        .checkbox-group input[type="checkbox"] { accent-color: #6C3CE1; width: 16px; height: 16px; }
        .checkbox-group label { font-size: 0.8125rem; color: #94a3b8; cursor: pointer; }

        .back-home {
            display: inline-flex; align-items: center; gap: 0.5rem;
            color: #64748b; text-decoration: none; font-size: 0.8125rem;
            font-weight: 500; transition: all 0.3s; margin-bottom: 1.5rem;
        }
        .back-home:hover { color: #22D3EE; transform: translateX(-3px); }
        .back-home i { transition: transform 0.3s; }
        .back-home:hover i { transform: translateX(-3px); }

        .auth-copyright {
            text-align: center; margin-top: 1.5rem;
            font-size: 0.75rem; color: #334155;
        }
    </style>
</head>
<body>
    <div style="display:flex; flex-direction:column; align-items:center; width:100%; max-width:440px; position:relative; z-index:1; padding:2rem 1rem;">
        <!-- Back to homepage -->
        <div style="width:100; align-self:flex-start;">
            <a href="<?= url('/') ?>" class="back-home">
                <i class="fas fa-arrow-left"></i> Retour à l'accueil
            </a>
        </div>

        <div class="auth-card">
            <!-- Logo -->
            <div class="auth-logo">
                <div class="icon">
                    <i class="fas fa-bolt text-white text-xl"></i>
                </div>
                <div class="text">
                    <h1><?= e($appName ?? 'TSILIZY Nexus') ?></h1>
                    <p>Espace de travail</p>
                </div>
            </div>

            <!-- Flash messages -->
            <?php if (!empty($flashSuccess)): ?>
            <div class="alert alert-success"><i class="fas fa-check-circle"></i><?= $flashSuccess ?></div>
            <?php endif; ?>
            <?php if (!empty($flashError)): ?>
            <div class="alert alert-error"><i class="fas fa-exclamation-circle"></i><?= $flashError ?></div>
            <?php endif; ?>
            <?php if (!empty($flashInfo)): ?>
            <div class="alert alert-info"><i class="fas fa-info-circle"></i><?= $flashInfo ?></div>
            <?php endif; ?>

            <!-- Page Content -->
            <?= $content ?>
        </div>

        <!-- Copyright -->
        <p class="auth-copyright">&copy; <?= date('Y') ?> TSILIZY LLC — Tous droits réservés</p>
    </div>
</body>
</html>
