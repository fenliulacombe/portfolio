<?php
require_once("connexion.php");
$id = $_POST["id"];
$data = Connexion::Ouvrir()->query("SELECT * FROM presentation WHERE id=".$id)->fetch(PDO::FETCH_ASSOC);
echo json_encode($data);
?>
