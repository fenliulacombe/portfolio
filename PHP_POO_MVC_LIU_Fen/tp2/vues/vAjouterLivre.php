<?php $this->titre = "Ajouter un livre"; ?>

 <div id="contenu">
            <section id="ajout-modification"> 

    <h1>Ajouter un livre</h1>
    
    <p class="erreur">&nbsp</p>

    <form method="POST" action="admin?item=livre&action=ajouter&id=">

        <label>Titre</label>
        <input name="titre" value="<?= $livre['titre'] ?>">
        <p class="erreur"><?= isset($erreursHydrate['titre'])?$erreursHydrate['titre']:"" ?></p>
    
        <label>Année</label>
        <input name="annee" value="<?= $livre['annee'] ?>">
        <p class="erreur"><?= isset($erreursHydrate['annee'])?$erreursHydrate['annee']:"" ?></p>
    
        <label>Auteur</label>
        <select name="id_auteur">
            <?php foreach ($auteurs as $auteur): ?>
                <option value="<?= $auteur['id_auteur'] ?>"><?= $auteur['auteur'] ?></option>
            <?php endforeach; ?>
        </select>

    <input type="submit" name="Envoyer" value="Envoyer">
</form>