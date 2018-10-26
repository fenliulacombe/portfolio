<?php

class Controleur {

    const BASE_URI = "/tp2";
    
    private $controleurs = array(
        ""          => "ControleurAccueil",
        "livres"    => "ControleurLivres",
        "admin"     => "ControleurAdmin"
    ); 

    /**
     * Constructeur qui valide l'URI et instancie le controleur correspondant
     *
     */
    public function __construct() {
        try {
            $regExp = '/^'.strtolower(str_replace('/','\/', self::BASE_URI)).'[\/]?([^\?]*)(\?.*)?$/';
            $requestUri = strtolower($_SERVER["REQUEST_URI"]);
        
            if (preg_match($regExp, $requestUri, $result)) {
                foreach ($this->controleurs as $uri => $controleur) {
                    if ($uri == $result[1]) {
                        //validation connextion
                        new $controleur;
                        exit;
                    }
                }
            }
            throw new exception ('URL non valide.');
        }
        catch (Exception $e) {
            $this->erreur($e->getMessage());
        }
    }

    /**
     * Méthode qui affiche une page d'erreur
     */
    static public function erreur($msgErreur) {
        $vue = new Vue("Erreur", array('msgErreur' => $msgErreur), 'gabaritErreur');
    }

}