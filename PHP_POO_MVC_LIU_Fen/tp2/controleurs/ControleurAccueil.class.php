<?php

class ControleurAccueil {

  public function __construct() {
    $this->accueil();
  }

  // Affiche la liste de tous les Livres
  public function accueil() {
    $vue = new Vue("Accueil");
  }
}