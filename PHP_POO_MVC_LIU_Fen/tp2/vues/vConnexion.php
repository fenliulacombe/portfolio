<?php $this->titre = "Connexion"; ?>

   <div id="contenu">
    <section id="connexion"> 

         <h1>Connexion</h1> 

        <form method="POST" action="admin">
            <p class="erreur"></p>
            <label>Identifiant</label>
            <input name="identifiant" value="">
            <p></p>
            <label>Mot de passe</label>
            <input name="mdp" type="password" value="">
            <p></p>
            <input type="submit" name="Envoyer" value="Envoyer">
        </form>
    </section> <!-- contenu d'une vue spécifique -->
    </div>