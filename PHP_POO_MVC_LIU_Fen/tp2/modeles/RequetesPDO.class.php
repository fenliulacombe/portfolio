<?php

class RequetesPDO {

    const ERREUR_MYSQL_INTEGRITY_CONSTRAINT_VIOLATION = 23000;

    /*requete pour connecter en tant qu'admin*/ 
    public function connexion($identifiant, $mdp){
        $sPDO = SingletonPDO::getInstance();
        $oPDOStatement = $sPDO->prepare(
            "SELECT * FROM administrateur WHERE identifiant = :identifiant AND mdp = :mdp"
          );
        $oPDOStatement->bindValue(':identifiant', $identifiant);
        $oPDOStatement->bindValue(':mdp', $mdp);
        $oPDOStatement->execute();
        if ($oPDOStatement->rowCount() == 0) {
            return "L'identifiant ou mot de passe incorrect.";
        }else{
            return 0;
        }
    }
    

    /*requete pour afficher les items*/ 
    public function getLivres($critereTri = "annee", $ordreTri = "asc") {
        if ($critereTri === "") $critereTri = "annee";
        if ($ordreTri   === "") $ordreTri = "asc";
        $sPDO = SingletonPDO::getInstance();
        $oPDOStatement = $sPDO->prepare(
            "SELECT LI.id_livre, LI.id_auteur, LI.titre, LI.annee, CONCAT(AU.nom,' ', AU.prenom) AS auteur
             FROM auteur AU 
             INNER JOIN livre LI ON AU.id_auteur = LI.id_auteur
             ORDER  BY ".$critereTri." ".$ordreTri 
          );
        $oPDOStatement->execute();
        $livres = $oPDOStatement->fetchAll(PDO::FETCH_ASSOC);
        return $livres;
    } 
    
    public function getAuteurs($critereTri = "id_auteur", $ordreTri = "asc") {
        if ($critereTri === "") $critereTri = "id_auteur";
        if ($ordreTri   === "") $ordreTri = "asc";
        $sPDO = SingletonPDO::getInstance();
        $oPDOStatement = $sPDO->prepare(
            "SELECT DISTINCT AU.id_auteur, CONCAT(AU.nom,' ', AU.prenom) AS auteur, count(id_livre) as nb_livres, LI.id_auteur AS id_auteur_livre
             FROM auteur AU 
             LEFT JOIN livre LI ON AU.id_auteur = LI.id_auteur
             GROUP BY AU.id_auteur
             ORDER BY ".$critereTri." ".$ordreTri 
          );
        $oPDOStatement->execute();
        $auteurs = $oPDOStatement->fetchAll(PDO::FETCH_ASSOC);
        return $auteurs;
    } 

    public function getAdministrateurs($critereTri = "id_administrateur", $ordreTri = "asc") {
        if ($critereTri === "") $critereTri = "id_administrateur";
        if ($ordreTri   === "") $ordreTri = "asc";
        $sPDO = SingletonPDO::getInstance();
        $oPDOStatement = $sPDO->prepare(
            "SELECT id_administrateur, identifiant, mdp
             FROM administrateur 
             ORDER BY ".$critereTri." ".$ordreTri 
          );
        $oPDOStatement->execute();
        $administrateurs = $oPDOStatement->fetchAll(PDO::FETCH_ASSOC);
        return $administrateurs;
    }

    /*requete pour ajouter les items*/ 
    public function ajouterItem($table, $champs){
        $sPDO = SingletonPDO::getInstance();
            try {
                $req = "INSERT INTO ".$table. " SET ";
                foreach ($champs as $nom => $valeur) {
                    $req .= $nom."=:".$nom.", ";
                }
                $req = substr($req, 0, -2);
                //var_dump($req);
                $oPDOStatement = $sPDO->prepare($req);
                foreach ($champs as $nom => $valeur) {
                    //var_dump($valeur);
                    $oPDOStatement->bindValue(":".$nom, $valeur);
                }
                $test = $oPDOStatement->execute();
                //var_dump($test);
                if ($oPDOStatement->rowCount() == 0) {
                    return "Ajout non effectué.";
                }else{
                    return 0;
                }
            }
            catch (Exception $e){
                if ($e->getCode() === self::ERREUR_MYSQL_INTEGRITY_CONSTRAINT_VIOLATION) {
                    return ucfirst($table)." déjà présent.";
                }else{
                    Controleur::erreur($e->getMessage());
                }
            }
    }
        

    /*requete pour modifier les items*/

    public function modifierItem($table, $champs, $cle){
        $sPDO = SingletonPDO::getInstance();
            try {
                $req = "UPDATE ".$table. " SET ";
                foreach ($champs as $nom => $valeur) {
                    $req .= $nom."=:".$nom.", ";
                }
                $req = substr($req, 0, -2);
                $req .= " WHERE id_".$table."=:id_".$table;
                $oPDOStatement = $sPDO->prepare($req);
                foreach ($champs as $nom => $valeur) {
                    $oPDOStatement->bindValue(":".$nom, $valeur);
                }
                $oPDOStatement->bindValue(":id_".$table, $cle);
                $oPDOStatement->execute();
                if ($oPDOStatement->rowCount() == 0) {
                    return "La modification non effectuée.";
                }else{
                    return 0;
                }
            }
            catch (Exception $e){
                // if ($e->getCode() === self::ERREUR_MYSQL_INTEGRITY_CONSTRAINT_VIOLATION) {
                //     return ucfirst($table)." déjà présent.";
                // }else{
                    Controleur::erreur($e->getMessage());
                //}
            }
    }

    public function supprimerItem($table, $cle){
        $sPDO = SingletonPDO::getInstance();
            try {
                $req = "DELETE FROM ".$table." WHERE id_".$table."=:id_".$table;
                $oPDOStatement = $sPDO->prepare($req);
                $oPDOStatement->bindValue(":id_".$table, $cle);
                $oPDOStatement->execute();
                if ($oPDOStatement->rowCount() == 0) {
                    return "La suppression non effectuée.";
                }else{
                    return 0;
                }
            }
            catch (Exception $e){
                if ($e->getCode() === self::ERREUR_MYSQL_INTEGRITY_CONSTRAINT_VIOLATION) {
                    return ucfirst($table)." déjà présent.";
                }else{
                    Controleur::erreur($e->getMessage());
                }
            }
    }

    /*requete pour obtenir un item*/

    public function getItem($table, $id)
    {
        $sPDO = SingletonPDO::getInstance();
        try {
            $req = "SELECT * FROM ".$table." WHERE id_".$table." =:id_".$table;
          
            //var_dump($req);
            $oPDOStatement = $sPDO->prepare($req);
            $oPDOStatement->bindValue(":id_".$table, $id);    
            $test = $oPDOStatement->execute();
            //var_dump($test);
            $item = $oPDOStatement->fetch(PDO::FETCH_ASSOC);
            return $item;
        }
        catch (Exception $e){
            // if ($e->getCode() === self::ERREUR_MYSQL_INTEGRITY_CONSTRAINT_VIOLATION) {
            //     return ucfirst($table)." déjà présent.";
            // }else{
                Controleur::erreur($e->getMessage());
            //}
        }
    }
    
    /*supprimer les items*/
    public function supprimerLivre($id)
    {
        $sPDO = SingletonPDO::getInstance();
        $oPDOStatement = $sPDO->prepare(
            "DELETE FROM livre WHERE id_livre = :id;" 
        );
        $oPDOStatement->bindParam(':id', $id, PDO::PARAM_INT);
        $oPDOStatement->execute(); 
        if($oPDOStatement->rowCount() == 0){
            echo "la suppression est échouée";
        }
    } 

    public function supprimerAdministrateur($id)
    {
        $sPDO = SingletonPDO::getInstance();
        $oPDOStatement = $sPDO->prepare(
            "DELETE FROM administrateur WHERE id_administrateur = :id;" 
            );
        $oPDOStatement->bindParam(':id', $id, PDO::PARAM_INT);
        $oPDOStatement->execute(); 
        if ($oPDOStatement->rowCount() == 0) {
            echo "la suppression est échouée";
        }
    }

    public function supprimerAuteur($id)
    {
        $sPDO = SingletonPDO::getInstance();
        $oPDOStatement = $sPDO->prepare(
            "DELETE FROM auteur WHERE id_auteur = :id;" 
            );
        $oPDOStatement->bindParam(':id', $id, PDO::PARAM_INT);
        $oPDOStatement->execute(); 
        if ($oPDOStatement->rowCount() == 0) {
            echo "la suppression est échouée";
        }
    }

    
     
}