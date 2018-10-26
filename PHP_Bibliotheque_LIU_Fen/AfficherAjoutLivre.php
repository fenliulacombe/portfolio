<?php

include('template/header.php');
include('connexion.php');
include('functions.php');


/*header('Content-type: text/html; charset=iso-8859-1');*/

$erreur=[];
$error_fatal = [];

if(isset($_POST['insert_livre']))
{
    $livre = valider_livre($_POST, false); 
    if(in_array(false, $livre)){
        $erreur =getMessagesErreurs($livre);
    }  
    if ($livre['titre_livre'])
    {
        $query_exist = mysqli_query($bdd, 'SELECT titre_livre FROM livres WHERE titre_livre = "'.$_POST['titre_livre'].'"');
        if(mysqli_num_rows($query_exist) > 0)
        {
            $erreur[] = "Ce titre de livre existe d&eacute;j&agrave; dans la biblioth&egrave;que. Veuillez entrer un autre nom du livre.";
        }
    }
    
    if (empty($erreur))
    {   
        $result_inserer = inserer_livre($bdd, $livre);
        if($result_inserer)
        {  
           $id = mysqli_insert_id($bdd);
           //var_dump($id);
           header("Location:AfficherFicheLivre.php?code_livre=".$id."&ajout=1");
        }else{
            echo "Erreur lors de l\'enregistrement de l\'ajout du livre.";
        }
    }
}else{
    $livre = get_livres($bdd);
}
?>

<html>
<head>
</head>

<body>

    <div class="titre">
        <h1>Ajouter un livre</h1>
    </div>  

    <div class="formulaire">
        <form method="POST" >

            <div class="champs">
                <input type="hidden" name="code_livre" value="<?php echo $livre['code_livre'] ?>"/><br/>
            </div>  

            <div class="champs">
                <p><strong>Titre du livre:</strong></p>
                <input type="text" name="titre_livre" value="<?php echo $livre['titre_livre'] ?>"/><br/>
            </div>

            <div class="champs">
                <p><strong>Date de publication:</strong></p>
                <input type="text" name="date_publication" pattern="[0-9]{1,4}" value="<?php echo $livre['date_publication'] ?>"/><br/>
            </div>

            <div class="champs">
                <p><strong>&Eacute;diteur:</strong></p>
                <?php
                echo getSelect($bdd, $livre['code_editeur_livres'], 'editeur');
                ?>
            </div>

            <div class="champs">
                <p><strong>Auteur:</strong></p>
                <?php
                echo getSelect($bdd, $livre['code_auteur_livres'], 'auteur');
                ?>
            </div>
            

            <div class="champs">
                <p><strong>Genre: </strong></p>
                <?php
                echo getSelect($bdd, $livre['code_genre_livres'], 'genre');
                ?>
            </div>
       
            <div class="champs">
                <p><strong>Nombre de pages:</strong></p>
                <input type="text" name="nombre_pages" value="<?php echo $livre['nombre_pages']?>"/><br/>
            </div>


            <div class="champs">
                <p><strong>ISBN:</strong></p>
                <input type="text" name="isbn" value="<?php echo $livre['isbn']?>"/><br/>
                <br>
            </div>

            <input type="submit" name="insert_livre" value="Sauvegarder">


            <div id="liste">
            <br><a href="AfficherListeLivres.php">Retour &agrave; la liste</a>
            </div>
        </form>



    </div>  

    <div class="erreur">
        <?php

            if(!empty($erreur)){
                echo "Erreur(s) de saisi: <br>";
                    foreach ($erreur as $key => $value)
                    {
                    echo'<span style="color:red;">'.$value.'</span><br>';    
                    }
            }
        ?>
    </div>
    </body>
</html> 


