<?php

include('template/header.php');
include('connexion.php');
include('functions.php');

$error_fatal = "";

if(isset($_GET['requete']))
{    
   if (!empty($_GET['requete']))
   {
        $livre = moteur_recherche($bdd, ($_GET['requete']));
        if(empty($livre)){
            $error_fatal = "Aucun resultat ne correspond &agrave votre recherche.";
            echo $error_fatal;
        }else{
            echo '<div style="text-align:center;">
            <h1>Resultat de recherche
            </h1></div>';
            echo '<table>';
            echo '<tr><th>Code</th><th>Titre</th><th>Auteur</th><th>Genre</th><th>Editeur</th><th>Publication</th>
            </tr>';

            foreach ($livre as $key => $value) 
            {
                echo '<tr><td>'.$value['code_livre'].'</td>';
                echo '<td><a href="AfficherFicheLivre.php?code_livre='.$value['code_livre'].'">'.$value['titre_livre'].'</a></td>';
                echo '<td><a href="AfficherFicheAuteur.php?code_auteur='.$value['code_auteur'].'">'.$value['nom_auteur'].'</a></td>';
                echo '<td>'.$value['nom_genre'].'</td>';
                echo '<td>'.$value['nom_editeur'].'</td>';
                echo '<td>'.$value['date_publication'].'</td></tr>';   
            }
            echo '</table>';
        }
    }else{
?>        
        <h1>Resultat de Recherche</h1>
        <p>Veuillez saisir une valeur de recherche</p>
        <form method="GET" action ='AfficherResultat.php'>
        Recherche:
        <input type="text" name="requete" placeholder="mots cles">
        <input type="submit" name="submit" value="Go">
    </form>
<?php    
    }
    echo '<br><a href="AfficherListeLivres.php">Retour &agrave; la liste<a>';
}    
