<?php

// *******************************************************
// Page qui sert à lancer la requête de l'ajout des données dans la formulaire
// Auteur : Fen LIU
// Date : 22/09/2018
// *********************************************************

require_once("connexion.php");

// echo var_dump($_POST);

if (isset($_POST['envoyer']))
{
    
    // Récupération des données transmises
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

    // Modification (INSERT) + contrôle (try catch) des données
    try
    {
        $stmt = Connexion::Ouvrir()->prepare("INSERT INTO presentation 
            (title, description, thematique, date_presentation, heure_debut, heure_fin, salle, presentateur, institution)
            VALUES (:title, :description, :thematique, :date_presentation, :heure_debut, :heure_fin, :salle, :presentateur, :institution)");
        $stmt->bindParam(":title", $titre);
        $stmt->bindParam(":description", $description);
        $stmt->bindParam(":thematique", $thematique);
        $stmt->bindParam(":date_presentation", $date_presentation);
        $stmt->bindParam(":heure_debut", $heure_debut);
        $stmt->bindParam(":heure_fin", $heure_fin);
        $stmt->bindParam(":salle", $salle);
        $stmt->bindParam(":presentateur", $presentateur);
        $stmt->bindParam(":institution", $institution);
        $stmt->execute();

        echo "Présentation ajoutée avec succès";
    }
    catch(PDOException $e)
    {
        echo "Problème lors de l'ajout de la présentation : " . $e->getMessage();
    }
}
//echo var_dump($_POST);
?>