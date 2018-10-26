<?php
//echo "<pre>";
$bdd = @mysqli_connect('localhost', 'user_4', '123456', 'tp2');
mysqli_set_charset($bdd, 'utf8');
if (!$bdd) {
	echo'Erreur de connexion '.mysqli_connect_error();
	exit();
}

//var_dump($bdd);
//echo "</pre>";
?>

<html>
	<head>
		<meta charset="utf-8" />
	</head>
	<body>
    <br>
 
	</body>
</html>

