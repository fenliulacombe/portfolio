<!doctype html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <link rel="stylesheet" href="<?= Controleur::BASE_URI."/styles/styles.css" ?>">
    <title><?= $titre ?></title>
</head>
<body>   

    <div id="global">
    <header>
    <h1>Administration de la bibliothèque</h1>
</header>
        <div id="contenu">
            <?= $contenu ?> <!-- contenu d'une vue spécifique -->
        </div>
    </div>
</body>
</html>