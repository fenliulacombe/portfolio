<?php

include('template/header.php');
include('connexion.php');
include('functions.php');

/*header('Content-type: text/html; charset=iso-8859-1');*/


$orderType=(isset($_GET['orderType']))?$_GET['orderType']:'code_livre';
$order = (isset($_GET['order']) && ($_GET['order'] == 'ASC' || $_GET['order'] == 'DESC'))? $_GET['order']:'ASC';
$order_code = $order_livre = $order_date_publication = $order_editeur = $order_auteur = $order_genre = 'ASC';

switch ($orderType) {
    case 'code':
        $orderType = 'code_livre';
        $order_code = ($order == 'ASC')?'DESC' : 'ASC';
        break;
        
    case 'livre':
        $orderType = 'titre_livre';
        $order_livre = ($order == 'ASC')?'DESC' : 'ASC';
        break;      

    case 'auteur':
        $orderType = 'nom_auteur';
        $order_auteur = ($order == 'ASC')?'DESC' : 'ASC';
        break;

    case 'genre':
        $orderType = 'nom_genre';
        $order_genre = ($order == 'ASC')?'DESC' : 'ASC';
        break;  
        
    case 'editeur':
        $orderType = 'nom_editeur';
        $order_editeur = ($order == 'ASC')?'DESC' : 'ASC';
        break; 
        
    case 'date':
        $orderType = 'date_publication';
        $order_date_publication = ($order == 'ASC')?'DESC' : 'ASC';
        break;    
    
    default:
        $orderType = 'code_livre';
        break;
}

$livres_affiche = get_livre_by_order($bdd, $orderType, $order);

?>

<html>
<body>
<div id="resultat">
    <!--<form method="POST" action="AfficherResultat.php">-->
    <form method="GET" action ='AfficherResultat.php'>
    Recherche:
        <input type="text" name="requete" placeholder="mots cles">
        <input type="submit" name="submit" value="Go">
    </form>

    <h1>Liste des livres</h1>
    <table>
<?php    
    echo '<tr>      
            <th><a href="?orderType=code&order='.$order_code.'">Code</a></th>     
            <th><a href="?orderType=livre&order='.$order_livre.'">Titre</a></th>
            <th><a href="?orderType=auteur&order='.$order_auteur.'">Auteur</a></th>
            <th><a href="?orderType=genre&order='.$order_genre.'">Genre</a></th>
            <th><a href="?orderType=editeur&order='.$order_editeur.'">Editeur</a></th>
            <th><a href="?orderType=date&order='.$order_date_publication.'">Publication</a></th>
         </tr>';

    foreach ($livres_affiche as $value)
    {
        echo '<tr>
            <td>'.$value['code_livre'].'</td>
            <td><a href="AfficherFicheLivre.php?code_livre='.$value['code_livre'].'">'.$value['titre_livre'].'</a></td>
            <td><a href="AfficherFicheAuteur.php?code_auteur='.$value['code_auteur'].'">'.$value['nom_auteur'].'</a></td>
            <td>'.$value['nom_genre'].'</td>
            <td>'.$value['nom_editeur'].'</td>
            <td>'.$value['date_publication'].'</td>
            </tr>';
    }    
?>

    </table>
</div>
</body>
</html>