<?php

/*fonction pour la liste déroulante
$bdd = connexion a la BD
$code = code de l'auteur ou de l'editeur ou du genre à afficher par defaut
$type = auteur, editeur, ou genre
*/
function getSelect($bdd, $code, $type)
{
	switch ($type) {
		case 'editeur':
			$input_name = 'code_editeur_livres';
			$query = 'SELECT code_editeur AS code, nom_editeur AS nom FROM editeurs ORDER BY nom ASC';
			$default_option = 'Selectionner un editeur';
			break;

		case 'auteur':
			$input_name = 'code_auteur_livres';
			$query = 'SELECT code_auteur AS code, CONCAT_WS(" ",prenom_auteur, nom_auteur) AS nom FROM auteurs ORDER BY nom ASC';
			$default_option = 'Selectionner un auteur';
			break;

		case 'genre':
			$input_name = 'code_genre_livres';
			$query = 'SELECT code_genre AS code, nom_genre AS nom FROM genres ORDER BY nom ASC';
			$default_option = 'Selectionner un genre';
			break;		
		
		default:
			# code...
			break;
	}

	$string ='<select name="'.$input_name.'"><option value="0">'.$default_option.'</option>';

	$stmt = mysqli_prepare($bdd, $query);
	mysqli_execute($stmt);
	$result = mysqli_stmt_get_result($stmt);


	while ($row = mysqli_fetch_assoc($result)) 
	{
    	$selected = ($row['code'] == $code)? ' selected ':'';
 		$string .='<option value="'. $row['code'].'" '.$selected.'>'.$row['nom'].'</option>';	 				        	
	}

	$string .= '</select>';
	        
	return $string;			 
}

/*fonction pour retourner un résultat booléan sur une valeur en chaine de caractère */
function estAlpha($value){
	return is_string(trim($value));
}


/*fonction pour retourner un résultat booléan sur une valeur numérique*/
function estNumerique($value){
	return is_numeric(trim($value));
}

/*fonction pour obtenir le résultat booléan sur le paramètre $value à tester;
$value : valeur à recevoir avec la méthode POST;
$type: chaine de caractère ou numérique;
 */
function valider($value, $type='alpha')
{
	switch ($type){
		case'alpha':
			return estAlpha($value);
			break;

		case'numerique':
			return estNumerique($value);
			break;

		default:
			break;
	}

}


/*fonction pour valider les valeurs à recevoir avec la méthode POST et les mettre dans un variable $data pour construire un tableau. Le résultat est soit $post['index']
, soit false;
$post: la méthode à recevoir l'information avec les variables superglobales comme POST;
$update: variable booléan pour savoir si on a besoin de l'information sur le code du livre mis à jour;
 */

function valider_livre($post, $update=true)
{
	$data = [];
	
	$data['titre_livre'] = valider($post['titre_livre'])?$post['titre_livre']:false;
	$data['date_publication'] = valider($post['date_publication'], 'numerique')?$post['date_publication']:false;
	$data['code_editeur_livres'] = valider($post['code_editeur_livres'], 'numerique')?$post['code_editeur_livres']:false;
	$data['code_auteur_livres'] = valider($post['code_auteur_livres'], 'numerique')?$post['code_auteur_livres']:false;
	$data['code_genre_livres'] = valider($post['code_genre_livres'], 'numerique')?$post['code_genre_livres']:false;
	$data['nombre_pages'] = valider($post['nombre_pages'], 'numerique')?$post['nombre_pages']:false;
	$data['isbn'] = valider($post['isbn'])?$post['isbn']:false;
	if($update)
	{
		$data['code_livre'] = valider($post['code_livre'], 'numerique')?$post['code_livre']:false;
	}
	return $data;
}

/*fonction pour obtenir tous les messages d'erreurs;
$data = le tableau $data obtenu après la validation avec les fonctions au-dessus*/
function getMessagesErreurs($data)
{
	$erreur =[];
	$message = 'Veuillez saisir ';
	foreach ($data as $key => $value)
	{
		if (!$value)
		{
			switch ($key)
			{
				case 'titre_livre':
					$erreur[] = $message.'un titre valide';
					break;
				
				case 'date_publication':
					$erreur[] = $message.'une date de publication valide';
					break;

				case 'code_editeur_livres':
					$erreur[] = $message.'un &eacutediteur valide';
					break;	

				case 'code_auteur_livres':
					$erreur[] = $message.'un auteur valide';
					break;	

				case 'code_genre_livres':
					$erreur[] = $message.'un genre valide';
					break;	

				case 'nombre_pages':
					$erreur[] = $message.'un nombre de pages valide';
					break;	

				case 'isbn':
					$erreur[] = $message.'un ISBN valide';
					break;			

				case 'code_livre':
					$erreur[] = $message.'un code livre valide';
					break;	

				default:
					break;	
			}
		}
	}

	return $erreur;
}

/*fonction pour obenir le résultat de la mise à jour de la base de données sur une fiche du livre;
$bdd = connexion a la BD
$data = le tableau qui contient des erreurs de saisi si la valeur "false" est dans le tableau $data*/
function update_livre($bdd, $data)
{
	$query = "UPDATE livres SET titre_livre = ?, date_publication = ?, code_editeur_livres = ?, code_auteur_livres = ?, code_genre_livres = ? , nombre_pages = ?, isbn = ? WHERE code_livre = ?;";
    $stmt=mysqli_prepare($bdd, $query);   
    mysqli_stmt_bind_param($stmt, "siiiiisi", $data['titre_livre'], $data['date_publication'], $data['code_editeur_livres'], $data['code_auteur_livres'], $data['code_genre_livres'], $data['nombre_pages'], $data['isbn'], $data['code_livre']);
    $result_query = mysqli_stmt_execute($stmt); //Cette fonction retourne TRUE en cas de succès ou FALSE si une erreur survient. 

    return $result_query; 
}


/*fonction pour obenir le résultat de recherche dans la base de données sur une fiche du livre avec un code précis;
$bdd = connexion a la BD
$code_livre = ID du livre */
function get_livre($bdd, $code_livre)
{
	$query_code = 'SELECT * FROM livres WHERE code_livre = ? ';

    $stmt = mysqli_prepare($bdd, $query_code);
    mysqli_stmt_bind_param($stmt, 'i', $code_livre);
    mysqli_stmt_execute($stmt);

    $result = mysqli_stmt_get_result($stmt);
    $livre = mysqli_fetch_assoc($result);
    return $livre;
}

/*fonction pour obenir le résultat de recherche dans la base de données sur le premier fiche du livre à afficher;
$bdd = connexion a la BD */
function get_livres($bdd)
{
	$query_code = 'SELECT * FROM livres';

    $stmt = mysqli_prepare($bdd, $query_code);
    /*mysqli_stmt_bind_param($stmt, 'i', $code_livre);*/
    mysqli_stmt_execute($stmt);
    $result = mysqli_stmt_get_result($stmt);
    $livre = mysqli_fetch_assoc($result);
    return $livre;
}

/*fonction pour obenir le résultat de recherche dans la base de données sur le premier fiche du livre à afficher;
$bdd = connexion a la BD 
$orderType = la valeur sur laquelle on ordonne
$order = ASC ou DESC
*/
function get_livre_by_order($bdd, $orderType, $order)
{
	$query = ('SELECT code_livre, titre_livre, date_publication, nom_editeur, code_auteur, nom_auteur, nom_genre FROM `livres` 
            INNER JOIN editeurs ON code_editeur_livres = code_editeur 
            INNER JOIN auteurs ON code_auteur_livres = code_auteur 
            INNER JOIN genres ON code_genre_livres = code_genre 
            ORDER BY '.$orderType.' '.$order. '');

	$stmt = mysqli_prepare ($bdd, $query);
	mysqli_stmt_execute($stmt);
	$result = mysqli_stmt_get_result($stmt);
	$livres_affiche = [];

	while ($row = mysqli_fetch_assoc($result))
	{
		$livres_affiche [] = $row;
	}

	return $livres_affiche; //output le tableau de 2 dimensions des livres à afficher	
}

/*fonction pour ajouter un livre dans la BD;
$bdd = connexion a la BD 
$data = le tableau qui contient les informations à insérer;
*/

function inserer_livre($bdd, $data)
{
    $query = "INSERT INTO livres(titre_livre, date_publication, code_auteur_livres, code_genre_livres, code_editeur_livres, nombre_pages, isbn) 
    VALUES (?, ?, ?, ?, ?, ?, ?);";
    $stmt=mysqli_prepare($bdd, $query);   
    mysqli_stmt_bind_param($stmt, "siiiiis", $data['titre_livre'], $data['date_publication'], $data['code_auteur_livres'], $data['code_genre_livres'], $data['code_editeur_livres'], $data['nombre_pages'], $data['isbn']);
    $result_query = mysqli_stmt_execute($stmt);
   
    return $result_query;
}

/*fonction pour obtenir une fiche d'un livre dans la BD;
$bdd = connexion a la BD 
$data = le code du livre à obtenir avec la méthode GET;
*/

function get_livre_fiche($bdd, $data)
{
	$query = ( 'SELECT code_livre as "Code", titre_livre as "Titre", date_publication as "Ann&eacute;e de publication", nom_editeur as Editeur, CONCAT_WS(" ",prenom_auteur, nom_auteur) as Auteur, nom_genre as Genre, nombre_pages as "Nombre de pages", isbn as ISBN FROM `livres` 
                INNER JOIN editeurs ON code_editeur_livres = code_editeur 
                INNER JOIN auteurs ON code_auteur_livres = code_auteur 
                INNER JOIN genres ON code_genre_livres = code_genre
                WHERE code_livre = ?'
                );

    $stmt = mysqli_prepare ($bdd, $query);
    mysqli_stmt_bind_param($stmt, "i", $data);
    mysqli_stmt_execute($stmt);
    $result = mysqli_stmt_get_result($stmt);
    $livre = mysqli_fetch_assoc($result);

    return $livre;
}


/*fonction pour obtenir une fiche d'un auteur dans la BD;
$bdd = connexion a la BD 
$data = le code de l'auteur à obtenir avec la méthode GET;
*/
function get_auteur_fiche($bdd, $data)
{
	$query = ('SELECT nom_auteur, prenom_auteur FROM `auteurs` 
                WHERE code_auteur = ?'  
              );

    $stmt = mysqli_prepare ($bdd, $query);
    mysqli_stmt_bind_param($stmt, "i", $data);
    mysqli_stmt_execute($stmt);
    $result = mysqli_stmt_get_result($stmt);
    $auteur = mysqli_fetch_assoc($result);

    return $auteur;
}

/*fonction pour obtenir les informations sur les livres publiés par un auteur dans la BD;
$bdd = connexion a la BD 
$data = le code de l'auteur à obtenir avec la méthode GET;
*/
function get_auteur_livres($bdd, $data)
{
	$query = ( 'SELECT code_livre, titre_livre, nom_auteur, nom_genre, nom_editeur FROM `livres` 
                INNER JOIN editeurs ON code_editeur_livres = code_editeur 
                INNER JOIN auteurs ON code_auteur_livres = code_auteur 
                INNER JOIN genres ON code_genre_livres = code_genre
                WHERE code_auteur = ?'  
              );

    $stmt = mysqli_prepare ($bdd, $query);
    mysqli_stmt_bind_param($stmt, "i", $data);
    mysqli_stmt_execute($stmt);
    $result = mysqli_stmt_get_result($stmt);
    $auteur = [];
    while ($row = mysqli_fetch_assoc($result))
	{
		$auteur[] = $row;
	}

    return $auteur;
}

/*fonction pour obtenir le résulat de recherche des mots clés 
$bdd = connexion a la BD 
$requete = la requete avec la méthode GET;
*/
function moteur_recherche($bdd, $requete){
	$recherche = '%'.trim(addslashes($requete)).'%';
	$query = ('SELECT code_livre, titre_livre, date_publication, nom_editeur, nom_auteur, nom_genre , code_auteur FROM `livres` 
            INNER JOIN editeurs ON code_editeur_livres = code_editeur 
            INNER JOIN auteurs ON code_auteur_livres = code_auteur 
            INNER JOIN genres ON code_genre_livres = code_genre 
            WHERE nom_auteur LIKE ? OR prenom_auteur LIKE ? OR nom_editeur LIKE ? OR titre_livre LIKE ?
            ORDER BY code_livre');

			//var_dump($query);
	$stmt = mysqli_prepare ($bdd, $query);
	mysqli_stmt_bind_param($stmt, "ssss", $recherche, $recherche, $recherche, $recherche);
	mysqli_stmt_execute($stmt);
	$result = mysqli_stmt_get_result($stmt);
	$livre =[];
	while($row = mysqli_fetch_assoc($result))
	{
		$livre[] = $row;
	}
	return $livre;
}

?>