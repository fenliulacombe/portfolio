<?php

//define('URL_BASE', 'http://e1795533.webdev.cmaisonneuve.qc.ca/TP2-PHP/');

$activeAcceuil = 'class="active"';
$activeListe = '';
$activeAjouter = '';

if(strpos($_SERVER['PHP_SELF'], 'AfficherAjoutLivre.php')){ 
	$activeAcceuil = '';
	$activeListe = '';
	$activeAjouter = 'class="active"';

}elseif(strpos($_SERVER['PHP_SELF'], 'AfficherListeLivres.php')){
	$activeAcceuil = '';
	$activeListe = 'class="active"';
	$activeAjouter = '';
}

?>
<!DOCTYPE>
<html>
<head>
	<title>Bibliotheque</title>
	<!--<base href="http://e1795533.webdev.cmaisonneuve.qc.ca/TP2-PHP/" >-->
	<meta charset="UTF-8">
	<link rel="stylesheet" href="https://getbootstrap.com/docs/3.3/dist/css/bootstrap-theme.min.css" crossorigin="anonymous">
	<link rel="stylesheet" href="https://getbootstrap.com/docs/3.3/dist/css/bootstrap.min.css" crossorigin="anonymous">
   
    
	<style type="text/css">
		<?php
			include('css/style.css');
		?>
    </style>
</head>
<body>
	<div id="header">
	 	  
	</div>


	<div id="menu">
		<ul class="nav nav-tabs" role="tablist">
				<li role="presentation" <?=$activeAcceuil;?>><a href="AfficherPageAcceuil.php">Accueil</a></li>
				<li role="presentation" <?=$activeListe;?>><a href="AfficherListeLivres.php">Liste des livres</a></li>
				<li role="presentation" <?=$activeAjouter;?>><a href="AfficherAjoutLivre.php">Ajouter un livre</a></li>
		</ul>
	</div>


	