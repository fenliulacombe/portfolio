<?php

include('template/header.php');
include('connexion.php');
include('functions.php');

$erreur=[];
$error_fatal = [];
//var_dump($_POST);

/*header('Content-type: text/html; charset=iso-8859-1');*/ 
//header('Content-type: text/html; charset=utf-8'); 

//on vérifie si le formulaire a été soumis
if(isset($_POST['update_livre']))
{  
    //On vérifie si les valeurs sont vides ou incorrectes
    $data = valider_livre($_POST); 
    //var_dump($data);
    if (in_array(false, $data))
    {
        $erreur =getMessagesErreurs($data);
    }
    //mise à jour de l'enregistrement
    if (empty($erreur))
    {
        //mise a jour les valeurs dans la bd 
        $result_query = update_livre($bdd, $data);
        if($result_query)
        {
          
           header("Location:AfficherFicheLivre.php?code_livre=".$data['code_livre']);
        }else{
            echo "erreur lors de l'enregistrement de la mise à jour.";
        }   
    }
}


if(isset($_GET['code_livre']) && is_numeric($_GET['code_livre']))
{
    // On va chercher les infos a afficher dans le formulaire d'apres le code passé en URL
    $livre = get_livre($bdd, $_GET['code_livre']); 
    //var_dump($livre);
    if(is_null($livre))
    {
        $error_fatal = "Le code du livre est invalide!";
    }

}else{
    //aucun code passé en paramètre
    $error_fatal = "Aucun code du livre est renseign&eacute; !";
}   

if ($error_fatal){    
    echo $error_fatal;
    echo '<br><a href="AfficherListeLivres.php">Reour &agrave; la liste.<a>';

}else{
        
?>

<html langue="fr">

<head>
</head>

<body>

    <div id="container">
 
    <?php

        $livre = get_livre($bdd, $_GET['code_livre']);
        echo '<h1>Fiche du livre : '.$livre['titre_livre'].'</h1>';
        
    ?>    
        <div class="formulaire">
            <form method="POST" >
                <div class="champs">
                    <input type="hidden" name="code_livre" value="<?php echo $livre['code_livre'] ?>"/>

                </div>  

                <div class="champs">
                    <p><strong>Titre du livre:</strong></p>
                    <input type="text" name="titre_livre" value="<?php echo $livre['titre_livre'] ?>"/>
                </div>

                <div class="champs">
                    <p><strong>Date de publication:</strong></p>
                    <input type="text" name="date_publication" pattern="[0-9]{1,4}" value="<?php echo $livre['date_publication'] ?>"/>
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
                </div>

                <input type="submit" name="update_livre" value="Sauvegarder"><br/>

                <div id="liste">
                <?php   
                    echo '<a href="AfficherFicheLivre.php?code_livre='.$livre['code_livre'].'">Retour &agrave; la fiche</a>';
                ?>
                    <br><a href="AfficherListeLivres.php">Retour &agrave; la liste</a>
                </div>
            </form>

        </div>  

        <div class="erreur">
            <?php
                if(!empty($erreur)){
                    echo "Erreur(s) de saisi: <br>";
                    foreach ($erreur as $key => $value){
                        echo'<span style="color:red;">'.$value.'</span><br>';   
                    }
                }
            ?>
        </div>
     </div> 
    </body>
</html> 

<?php
}
?>