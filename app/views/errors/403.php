<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8"><meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>403 — Accès interdit</title>
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@400;700;800&display=swap" rel="stylesheet">
    <style>
        * { margin: 0; padding: 0; box-sizing: border-box; }
        body { font-family: 'Inter', sans-serif; background: #0F172A; color: #e2e8f0; min-height: 100vh; display: flex; align-items: center; justify-content: center; text-align: center; }
        .code { font-size: 7rem; font-weight: 800; background: linear-gradient(135deg, #EF4444, #6C3CE1); -webkit-background-clip: text; -webkit-text-fill-color: transparent; line-height: 1; }
        .title { font-size: 1.5rem; font-weight: 700; margin: 1rem 0 0.5rem; }
        .desc { color: #94a3b8; margin-bottom: 2rem; }
        .btn { display: inline-flex; align-items: center; gap: 0.5rem; background: linear-gradient(135deg, #6C3CE1, #5a1fd4); color: white; padding: 0.75rem 1.5rem; border-radius: 0.75rem; text-decoration: none; font-weight: 600; transition: all 0.3s; }
        .btn:hover { box-shadow: 0 4px 15px rgba(108,60,225,0.4); transform: translateY(-1px); }
    </style>
</head>
<body>
    <div>
        <div class="code">403</div>
        <h1 class="title">Accès interdit</h1>
        <p class="desc">Vous n'avez pas les permissions nécessaires pour accéder à cette page.</p>
        <a href="/" class="btn">← Retour à l'accueil</a>
    </div>
</body>
</html>
