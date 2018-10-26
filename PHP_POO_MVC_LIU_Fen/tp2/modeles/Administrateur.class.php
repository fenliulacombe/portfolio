<?php

class Administrateur extends Entite {
    protected $id_administrateur = NULL;
    protected $identifiant = NULL;
    protected $mdp = NULL;

    public function __construct() {}
    
    protected function setId_administrateur($id_administrateur = NULL){
        $this->id_administrateur = $id_administrateur;
    }

    protected function setIdentifiant($identifiant= NULL){
        if (trim($identifiant) === "") 
        {
            $this->erreursHydrate['identifiant'] = "Au moins un caractère.";
        }
        $this->identifiant = trim($identifiant);
    }

    protected function setMdp($mdp = NULL){
        if (trim($mdp) === "") {
            $this->erreursHydrate['mdp'] = "Au moins un caractère.";
        }
        $this->mdp = trim($mdp);
    }
}