<?php

class Livre extends Entite {
    protected $id_livre = NULL;
    protected $id_auteur = NULL;
    protected $titre = NULL;
    protected $annee = NULL;

    public function __construct() {}
    
    protected function setId_livre($id_livre = NULL){
        $this->id_livre = $id_livre;
    }
    
    protected function setId_auteur($id_auteur = NULL){
        $this->id_auteur = $id_auteur;
    }

    protected function setTitre($titre = NULL){
        if (trim($titre) === "") 
        {
            $this->erreursHydrate['titre'] = "Au moins un caractère.";
        }
        $this->titre = trim($titre);
    }

    protected function setAnnee($annee = NULL){
        /*validation regex annee*/ 
        if (trim($annee) === "") {
            $this->erreursHydrate['annee'] = "Veuillez remplir le champ année";
        }
        $this->annee = trim($annee);
    }
}


