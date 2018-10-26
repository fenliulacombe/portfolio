<?php

include('template/header.php');
include('connexion.php');
include('functions.php');


/*header('Content-type: text/html; charset=iso-8859-1');*/

$error_fatal = '';

if(isset($_GET['code_livre']) && is_numeric($_GET['code_livre'])){
    //on affiche dans le formulaire d'après le code passé en URL
    $livre = get_livre_fiche($bdd, $_GET['code_livre']);
    if(is_null($livre))
    {
        $error_fatal = "Le code du livre est invalide!";
    }else{
        if(isset($_GET['ajout']))
        {
            echo '<span style="color:blue;">Votre livre a été bien ajouté!</span>';
        }

        echo '<table>';
        echo '<h1>Fiche du livre : '.$livre['Titre'].'</h1>';
        foreach ($livre as $key => $value)
        {
            echo '<tr><td>'.$key.'</td><td>'.$value.'</td></tr>';
        }
        echo '</table>';
        echo '<br>'; 
        echo '<a href="AfficherFormeLivre.php?code_livre='.$livre['Code'].'">Modifier la fiche</a>';
        echo '<br><a href="AfficherListeLivres.php">Retour &agrave; la liste<a>';
    }
   
}else{
        //aucun code passé en paramètre
        $error_fatal = "Aucun code du livre est renseign&eacute; !";
}

if($error_fatal)
{    
    echo $error_fatal;
    echo '<br><a href="AfficherListeLivres.php">Reour &agrave; la liste.<a>';
}
?>