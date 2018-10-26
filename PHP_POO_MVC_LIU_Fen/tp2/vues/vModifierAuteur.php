<?php $this->titre = "Modifier un auteur"; ?>

<div id="contenu">
    
    <section id="ajout-modification"> 

    <h1>Modifier un auteur</h1>
    
    <p class="erreur">&nbsp</p>

    <form method="POST" action="admin?item=auteur&action=modifier&id=<?= $auteur['id_auteur'] ?>">
    
        <p>Id auteur : <?= $auteur['id_auteur'] ?></p>
        <input type="hidden" name="id_auteur" value="<?= $auteur['id_auteur'] ?>">
    
        <label>Nom</label>
        <input name="nom" value="<?= $auteur['nom'] ?>">
        <p class="erreur"><?= isset($erreursHydrate['nom'])?$erreursHydrate['nom']:"" ?></p>
    
        <label>Prénom</label>
        <input name="prenom" value="<?= $auteur['prenom'] ?>">
        <p class="erreur"><?= isset($erreursHydrate['prenom'])?$erreursHydrate['prenom']:"" ?></p>

        <input type="submit" name="Envoyer" value="Envoyer">

    </form>
