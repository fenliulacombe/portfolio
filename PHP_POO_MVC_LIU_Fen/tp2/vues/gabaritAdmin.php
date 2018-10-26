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
          <h1>Administration de la bibliothèque</h1>
            <div id="info">
              
                <p id="identifiant">
                    <a href="admin?item=administrateur&action=deconnecter">Déconnexion</a>
                    administrateur connecté                </p>
            
            </div>    
            <ul>
                <li><a class="<?= $this->vue === "administrateur" ? "active" : ""; ?>"
                       href="admin?item=administrateur">Administrateurs</a></li>
               
                <li><a class="<?= $this->vue === "auteur" ? "active" : ""; ?>"
                       href="admin?item=auteur">Auteurs</a></li>

                <li><a class="<?= $this->vue === "livre" ? "active" : ""; ?>"
                       href="admin?item=livre">Livres</a></li>       
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