<?php

class Auteur extends Entite {
    protected $id_auteur = NULL;
    protected $nom = NULL;
    protected $prenom = NULL;

    public function __construct() {}
    
    protected function setId_auteur($id_auteur = NULL){
        $this->id_auteur = $id_auteur;
    }

    protected function setNom($nom = NULL){
        if (trim($nom) === "") 
        {
            $this->erreursHydrate['nom'] = "Au moins un caractère.";
        }
        $this->nom = trim($nom);
    }

    protected function setPrenom($prenom = NULL){
        if (trim($prenom) === "") {
            $this->erreursHydrate['prenom'] = "Au moins un caractère.";
        }
        $this->prenom = trim($prenom);
    }
}


