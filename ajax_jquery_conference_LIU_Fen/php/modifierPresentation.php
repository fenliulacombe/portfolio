
<?php
// *******************************************************
// Page qui sert à lancer la requête de la modification des données dans la formulaire
// Auteur : Fen LIU
// Date : 22/09/2018
// *********************************************************
require_once("connexion.php");

if (isset($_POST['envoyer']))
{
    
    // Récupération des données transmises
   
    $id = $_POST['id'];
    $titre = $_POST['titre'];
    $description = $_POST['description'];
    $thematique = $_POST['thematique'];
    $date_presentation = $_POST['date_presentation'];
    $heure_debut = $_POST['heure_debut'];
    $heure_fin = $_POST['heure_fin'];
    $salle = $_POST['salle'];
    $presentateur = $_POST['presentateur'];
    $institution = $_POST['institution'];
    // Contrôle des données reçues

    // Modification (Update) + contrôle (try catch) des données
    try
    {
        $stmt = Connexion::Ouvrir()->prepare("UPDATE presentation SET
        title=:title, description=:description, thematique=:thematique, date_presentation=:date_presentation, heure_debut=:heure_debut, heure_fin=:heure_fin, salle=:salle, presentateur=:presentateur, institution=:institution
        WHERE id=:id");
        $stmt->bindParam(":id", $id);
        $stmt->bindParam(":title", $titre);
        $stmt->bindParam(":description", $description);
        $stmt->bindParam(":thematique", $thematique);
        $stmt->bindParam(":date_presentation", $date_presentation);
        $stmt->bindParam(":heure_debut", $heure_debut);
        $stmt->bindParam(":heure_fin", $heure_fin);
        $stmt->bindParam(":salle", $salle);
        $stmt->bindParam(":presentateur", $presentateur);
        $stmt->bindParam(":institution", $institution);
        $erreur = $stmt->execute();

        if ($erreur != "")
        {
            echo "code erreur : " .$erreur;
        }
        else
        {
            echo "Présentation ajoutée avec succès";
        }
    }
    catch(PDOException $e)
    {
        echo "Problème lors de l'ajout de la présentation : " . $e->getMessage();
    }
}

?>
