<?php

class ControleurLivres {

    private $typesTri = ['annee', 'titre', 'auteur'];
    private $ordresTri   = ['asc', 'desc'];
    
    CONST ANNEE_MINI = 1500;
    
    /**
     * Constructeur qui valide l'action et lance le traitement correspondant
     *
     */
    public function __construct() {
      
        // Action par défaut
        // -----------------
        
        if (!isset($_GET['action'])) {
            $_GET['action']  = "tri";
            $_POST['type']   = "annee";
            $_POST['ordre']  = "asc";
        }
        
        // Contrôle des actions
        // --------------------
        
        switch ($_GET['action']) {
            case "tri":
                 $this->getLivres();
                break;
            case "recherche":
                $this->rechercherLivres();
                break;
            default:
                throw new exception("Action invalide.");
        }
    }

    /**
     * Traitement de tri 
     *
     */
    private function getLivres() {
        
        /* Contrôles de la requête
           ----------------------- */
        
        if (!isset($_POST['type']) || !in_array($_POST['type'], $this->typesTri)) {
            throw new exception('Type de tri absent ou non valide.');
        };
        if (isset($_POST['ordre']) && !in_array($_POST['ordre'], $this->ordresTri)) {
            throw new exception("Ordre de tri non valide.");
        };
        
        /* Exécution de la requête
           ----------------------- */
        
        $reqPDO = new RequetesPDO();
        $typeTri = $_POST['type'];
        isset($_POST['ordre']) ? $ordreTri = $_POST['ordre'] : $ordreTri = "";
        $livres = $reqPDO->getLivres($typeTri, $ordreTri);
        
        /* Affichage du résultat
           --------------------- */

        $vue = new Vue("LivresTri", array('livres' => $livres));
    }

    /**
     * Traitement de recherche 
     *
     */
    private function rechercherLivres() {

        /* Contrôles de la requête
           ----------------------- */
        
        $msgErreur = "";
        
        $annee = "";
        if (isset($_POST['annee']) && strlen(trim($_POST['annee'])) !== 0) {
            $annee = trim($_POST['annee']);
            $regExp = "/^[0-9]+$/";
            if (!preg_match($regExp, $annee)) {
                $msgErreur = "Année non valide.";
            } elseif ($annee <= self::ANNEE_MINI || $annee > date('Y')) {
                $msgErreur = "Année hors de la période disponible.";
            }
        }
        
        $titreContient = "";
        if (isset($_POST['titreContient'])) $titreContient = trim($_POST['titreContient']);
        
        /* Exécution de la requête si aucune erreur et au moins un champ renseigné 
           ----------------------------------------------------------------------- */

        $livres = array();
        if ($msgErreur === "" && ($annee !== "" || $titreContient !== "")) {
            $reqPDO = new RequetesPDO();
            $livres = $reqPDO->rechercherLivres($annee, $titreContient);
            if (count($livres) === 0) $msgErreur = "Aucun résultat.";
        }

        /* Affichage du résultat ou des erreurs 
           ------------------------------------ */

        $vue = new Vue("LivresRecherche", array('livres' => $livres, 'msgErreur' => $msgErreur));
    }
}