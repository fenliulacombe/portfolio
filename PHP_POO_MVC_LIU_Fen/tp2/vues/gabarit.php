<!doctype html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <link rel="stylesheet" href="styles/styles.css">
    <title><?= $titre ?></title>
</head>
<body>
    <div id="global">
        <header>
            <h1>Bibliothèque</h1>
            <ul>
                <li><a class="<?= $this->vue === "Accueil" ? "active" : ""; ?>"
                       href=".">Accueil</a></li>
                <li><a class="<?= $this->vue === "LivresTri" ? "active" : ""; ?>"
                       href="livres">Liste des livres</a></li>
                <li><a class="<?= $this->vue === "LivresRecherche" ? "active" : ""; ?>"
                       href="livres?action=recherche">Recherche</a></li>
            </ul>
        </header>
        <div id="contenu">
            <?= $contenu ?> <!-- contenu d'une vue spécifique -->
        </div>
        <footer>
        </footer>
    </div>
</body>
</html>