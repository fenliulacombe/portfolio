<?php

// *******************************************************
// Page qui sert à lancer la requête de l'ajout des données dans la formulaire
// Auteur : Fen LIU
// Date : 22/09/2018
// *********************************************************

require_once("connexion.php");

$datas = Connexion::Ouvrir()->query("SELECT * FROM presentation ORDER BY thematique, title")->fetchAll(PDO::FETCH_ASSOC);

echo json_encode($datas);

?>