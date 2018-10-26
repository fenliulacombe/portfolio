<?php $this->titre = "Ajouter un auteur"; ?>

<form method="POST" action="admin?item=auteur&action=ajouter">
    <label>Nom</label>     
        <input name="nom" value="<?= $auteur['nom'] ?>"><br>
        <p class="erreur"><?= isset($erreursHydrate['nom'])?$erreursHydrate['nom']:"" ?></p><br><br>
    <label>Prénom</label> 
        <input name="prenom" value="<?= $auteur['prenom'] ?>"><br>
        <p class="erreur"><?= isset($erreursHydrate['prenom'])?$erreursHydrate['prenom']:"" ?></p><br><br>
    

    <input type="submit" name="Envoyer" value="Envoyer">
</form>
