<?php

include('template/header.php');
include('connexion.php');
include('functions.php');

$error_fatal = '';

if(isset($_GET['code_auteur']) && is_numeric($_GET['code_auteur']))
{
    //on affiche dans le formulaire d'après le code passé en URL
    
    $auteur = get_auteur_fiche($bdd, $_GET['code_auteur']);

    if(is_null($auteur))
    {
        $error_fatal = "Le code de l'auteur est invalide!";
    }

}else{
        //aucun code passé en paramètre
    $error_fatal = "Aucun code de l'auteur est renseign&eacute; !";
}   

if ($error_fatal){    
    echo $error_fatal;
    echo '<br><a href="AfficherListeLivres.php">Reour &agrave; la liste.<a>';

}else{ 
    echo '<table>';
    echo '<div style="text-align:center;">
    <h1>Fiche de l\'auteur : '.$auteur['nom_auteur'].'</h1></div>';
    echo '<tr><td>Nom</td><td>'.$auteur['nom_auteur'].'</td></tr>';
    echo '<tr><td>Pr&eacutenom</td><td>'.$auteur['prenom_auteur'].'</td></tr>';
    echo '</table>';
    echo '<br>';
    echo '<table>';   
    $auteur_livre = get_auteur_livres($bdd, $_GET['code_auteur']);
    //var_dump($auteur_livre);
    echo '<tr><th><strong>Titre</strong></th><th><strong>Auteur</strong></th><th><strong>Genre</strong></th><th><strong>Editeur</strong></th></tr>';
    foreach ($auteur_livre as $key => $value) 
    {
        echo '<tr><td><a href="AfficherFicheLivre.php?code_livre='.$value['code_livre'].'">'.$value['titre_livre'].'</a></td>';
        echo '<td>'.$value['nom_auteur'].'</td>';
        echo '<td>'.$value['nom_genre'].'</td>';
        echo '<td>'.$value['nom_editeur'].'</td></tr>';
    }

    echo '</table>';
    echo '<br>'; 
    echo '<br><a href="AfficherListeLivres.php">Retour &agrave; la liste<a>';
}

?>   