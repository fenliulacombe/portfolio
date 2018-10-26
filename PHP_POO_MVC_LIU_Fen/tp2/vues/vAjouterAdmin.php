<?php $this->titre = "Ajouter un administrateur"; ?>

<div id="contenu">
    <section id="ajout-modification"> 

    <h1>Ajouter un administrateur</h1>
    
    <p class="erreur">&nbsp</p>

    <form method="POST" action="admin?item=administrateur&action=ajouter">

        <label>Identifiant</label>
        <input name="identifiant" value="<?= $administrateur['identifiant'] ?>">
        <p class="erreur"><?= isset($erreursHydrate['identifiant'])?$erreursHydrate['identifiant']:"" ?></p>
    
        <label>Mot de passe</label>
        <input name="mdp" value="<?= $administrateur['mdp'] ?>">
        <p class="erreur"><?= isset($erreursHydrate['mdp'])?$erreursHydrate['mdp']:"" ?></p>

        <input type="submit" name="Envoyer" value="Envoyer">
    </form>
</section>

 <!-- contenu d'une vue spécifique -->
</div>

