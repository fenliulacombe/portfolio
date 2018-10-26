<?php

require_once("connexion.php");

$stmt = Connexion::Ouvrir()->prepare( "DELETE FROM presentation WHERE id=:id");
$stmt->bindParam(':id', $_POST['id'], PDO::PARAM_INT);
$stmt->execute();