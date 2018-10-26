<?php


class ControleurAdmin {

        private $item;
        private $action;
        private $id;
    
        private $items = ['livre', 'auteur', 'administrateur'];
        private $actions  = ['lister', 'ajouter', 'modifier', 'supprimer','deconnecter']; /*funciton loginAdministrateur, et function logoutAdministrateur*/ 

        
        /* Constructeur qui valide l'action et lance le traitement correspondant */
        public function __construct() {
            
            session_start();
            // verif connexion
           if (isset($_SESSION['identifiant'])){
                // Action par défaut
                isset($_GET['item']) ? $this->item = $_GET['item'] : $this->item='livre';
                isset($_GET['action']) ? $this->action = $_GET['action'] : $this->action='lister';
                isset($_GET['id']) ? $this->id = $_GET['id'] : $this->id='';
            
                // Contrôle des actions
                foreach($this->items as $item){
                    if ($item === $this->item){
                        foreach ($this->actions as $action){
                            if($action === $this->action){
                                $fonction = $action.ucfirst($item);
                                $this->$fonction();
                                exit;
                            }
                        }
                        throw new exception("Action invalide.");
                    }
                }
                throw new exception("Item non valide");
            }else{
                $this->loginAdministrateur();
            }
    }

        public function loginAdministrateur()
        {
            
            $erreurMysql = "";

            if(isset($_POST['identifiant']) && isset($_POST['mdp'])){
                $reqPDO = new RequetesPDO();
                $erreurMysql = $reqPDO->connexion($_POST['identifiant'], $_POST['mdp']);
                
                //foreach ($administrateurs as $key => $administrateur) 
                if($erreurMysql === 0)
                {
                    /*attribuer une session*/ 
                    $_SESSION['identifiant'] = $_POST['identifiant'];
                    $this->listerLivre();
                }
            }

            $vue = new Vue("Connexion", array('erreurMysql'=>$erreurMysql), "gabaritNull");
        }

        public function deconnecterAdministrateur()
        {
            unset($_SESSION['identifiant']);
            session_destroy();
            $vue = new Vue("Connexion", array(), "gabaritNull");
        }


        
/******----------------------------------------------------------------------------------------------------------------- */
        private function listerLivre()
        { 
            /* Exécution de la requête*/
            $reqPDO = new RequetesPDO();
            isset($_POST['type']) ? $typeTri = $_POST['type'] : $typeTri = "";
            isset($_POST['ordre']) ? $ordreTri = $_POST['ordre'] : $ordreTri = "";
           
            $livres = $reqPDO->getLivres($typeTri, $ordreTri);
            /* Affichage du résultat  */
            $vue = new Vue("Livres", array('livres' => $livres), "gabaritAdmin");
        }

        private function listerAuteur()
        { 
            /* Exécution de la requête*/
            $reqPDO = new RequetesPDO();
            isset($_POST['type']) ? $typeTri = $_POST['type'] : $typeTri = "";
            isset($_POST['ordre']) ? $ordreTri = $_POST['ordre'] : $ordreTri = "";
           
            $auteurs = $reqPDO->getAuteurs($typeTri, $ordreTri);
            /* Affichage du résultat */
            $vue = new Vue("AdminAuteurListe", array('auteurs' => $auteurs), "gabaritAdmin");
        }

        private function listerAdministrateur()
        { 
            /* Exécution de la requête */
            $reqPDO = new RequetesPDO();
            isset($_POST['type']) ? $typeTri = $_POST['type'] : $typeTri = "";
            isset($_POST['ordre']) ? $ordreTri = $_POST['ordre'] : $ordreTri = "";
           
            $administrateurs = $reqPDO->getAdministrateurs($typeTri, $ordreTri);
            /* Affichage du résultat */
            $vue = new Vue("Administrateur", array('administrateurs' => $administrateurs), "gabaritAdmin");
        }
    
/*-------------------------------------------------*----------------------------------------------*--------------------------------------/

        
        /*ajouter les items*/ 
        private function ajouterAuteur()
        { 
            $oAuteur = new Auteur();
            $erreursHydrate = [];
            $erreurMysql = 0;
            
            /*S'il existe des variables $_POST (retour du formulaire)*/ 
            //if(isset($_POST['nom']) && isset($_POST['prenom'])) /*faut jamais utiliser un isset($_POST) car il existe tout le temps*/ 
            if(count($_POST) !== 0)
            {  
                $erreursHydrate = $oAuteur->hydrate($_POST);
                 /*s'il n'y a pas d'erreurs d'hydratation (erreursHydrate vide)*/
                if(count($erreursHydrate) === 0)
                {
                    $reqPDO = new RequetesPDO();
                    $erreurMysql = $reqPDO->ajouterItem('auteur', $oAuteur->getItem());

                    /*s'il n'y a pas d'erreur MySQL*/
                    if($erreurMysql === 0)
                    {
                        $this->listerAuteur();
                        exit;
                    }
                }
            }
            $vue = new Vue("AdminAuteurAjout", array('itemMenu' => $this->item, 'auteur' => $oAuteur->getItem(), 'erreursHydrate'=>$erreursHydrate, 'erreurMysql'=>$erreurMysql) , "gabaritAdmin");
        }

        private function ajouterAdministrateur()
        { 
            $oAdministrateur = new Administrateur();
            $erreursHydrate = [];
            $erreurMysql = 0;
            
            /*S'il existe des variables $_POST (retour du formulaire)*/ 
            //if(isset($_POST['nom']) && isset($_POST['prenom'])) /*faut jamais utiliser un isset($_POST) car il existe tout le temps*/ 
            if(count($_POST) !== 0)
            {  
                $erreursHydrate = $oAdministrateur->hydrate($_POST);
                 /*s'il n'y a pas d'erreurs d'hydratation (erreursHydrate vide)*/
                if(count($erreursHydrate) === 0)
                {
                    $reqPDO = new RequetesPDO();
                    $erreurMysql = $reqPDO->ajouterItem('administrateur', $oAdministrateur->getItem());
                    //var_dump($erreurMysql);

                    /*s'il n'y a pas d'erreur MySQL*/
                    if($erreurMysql === 0)
                    {
                        $this->listerAdministrateur();
                        exit;
                    }
                }
            }
            $vue = new Vue("AjouterAdmin", array('itemMenu' => $this->item, 'administrateur' => $oAdministrateur->getItem(), 'erreursHydrate'=>$erreursHydrate, 'erreurMysql'=>$erreurMysql) , "gabaritAdmin");
        }

        private function ajouterLivre()
        { 
            $oLivre = new Livre();
            $erreursHydrate = [];
            $erreurMysql = 0;
            $reqPDO = new RequetesPDO();
            /*S'il existe des variables $_POST (retour du formulaire)*/ 
            if(count($_POST) !== 0)
            {  
                $erreursHydrate = $oLivre->hydrate($_POST);
                 /*s'il n'y a pas d'erreurs d'hydratation (erreursHydrate vide)*/
                if(count($erreursHydrate) === 0)
                {
                    
                    $erreurMysql = $reqPDO->ajouterItem('livre', $oLivre->getItem());

                    /*s'il n'y a pas d'erreur MySQL*/
                    if($erreurMysql === 0)
                    {
                        $this->listerLivre();
                        exit;
                    }
                }
            }
            
            $vue = new Vue("AjouterLivre", array('itemMenu' => $this->item, 'livre' => $oLivre->getItem(), 'auteurs' => $reqPDO->getAuteurs(), 'erreursHydrate'=>$erreursHydrate, 'erreurMysql'=>$erreurMysql) , "gabaritAdmin");
        }

/*-------------------------------------------------*----------------------------------------------*--------------------------------------*/
        private function modifierAuteur()
        { 
            /*Initialiser les variables*/ 
            $oAuteur = new Auteur();
            $erreursHydrate = [];
            $erreurMysql = "";

            
            /*validation comme dans l'ajout auteur*/
            if(count($_POST) !== 0)
            {
                $erreursHydrate = $oAuteur->hydrate($_POST);
                if(empty($erreursHydrate))
                {
                    $reqPDO = new RequetesPDO();
                    $erreurMysql = $reqPDO->modifierItem('auteur', $oAuteur->getItem(), $this->id);
                    
                    if($erreurMysql == 0)
                    {
                        $this->listerAuteur();
                        return;
                    }
                }    
            }else{
                $reqPDO = new RequetesPDO();
                $auteur = $reqPDO->getItem('auteur', $this->id);
                //var_dump($auteur);
                $erreursHydrate = $oAuteur->hydrate($auteur);
            } 

            /* Affichage du résultat */
            $vue = new Vue("ModifierAuteur", array('auteur' => $oAuteur->getItem(), 'erreursHydrate'=>$erreursHydrate, 'erreurMysql'=>$erreurMysql) , "gabaritAdmin");
        }
        

        private function modifierAdministrateur()
        { 
            /*Initialiser les variables*/ 
            $oAdministrateur = new Administrateur();
            $erreursHydrate = [];
            $erreurMysql = "";

            /*validation comme dans l'ajout auteur*/
            if(count($_POST) !== 0)
            {
                $erreursHydrate = $oAdministrateur->hydrate($_POST);
                //var_dump($erreursHydrate);
                if(empty($erreursHydrate))
                {
                    $reqPDO = new RequetesPDO();
                    $erreurMysql = $reqPDO->modifierItem('administrateur', $oAdministrateur->getItem(), $this->id);
                    //var_dump($erreurMysql);
                    if($erreurMysql == 0)
                    {
                        $this->listerAdministrateur();
                        return;
                    }
                }    
            }else{
                $reqPDO = new RequetesPDO();
                $administrateur= $reqPDO->getItem('administrateur', $this->id);
                //var_dump($administrateur);
                $erreursHydrate = $oAdministrateur->hydrate($administrateur);
            } 

            /* Affichage du résultat */
            $vue = new Vue("ModifierAdministrateur", array('administrateur' => $oAdministrateur->getItem(), 'erreursHydrate'=>$erreursHydrate, 'erreurMysql'=>$erreurMysql) , "gabaritAdmin");
        }

        private function modifierLivre()
        { 
            /*Initialiser les variables*/ 
            $oLivre = new Livre();
            $erreursHydrate = [];
            $erreurMysql = "";
            
            /*validation comme dans l'ajout auteur*/
            if(count($_POST) !== 0)
            {
                $erreursHydrate = $oLivre->hydrate($_POST);
                if(empty($erreursHydrate))
                {
                    $reqPDO = new RequetesPDO();
                    $erreurMysql = $reqPDO->modifierItem('livre', $oLivre->getItem(), $this->id);
                    //var_dump($erreurMysql);
                    
                    if($erreurMysql == 0)
                    {
                        $this->listerLivre();
                        return;
                    }
                }    
            }else{
                $reqPDO = new RequetesPDO();
                $livre = $reqPDO->getItem('livre', $this->id);
                $erreursHydrate = $oLivre->hydrate($livre);
            } 

            /* Affichage du résultat */
            $vue = new Vue("ModifierLivre", array('livre'=>$oLivre->getItem(), 'auteurs'=>$reqPDO->getAuteurs(), 'erreursHydrate'=>$erreursHydrate, 'erreurMysql'=>$erreurMysql) , "gabaritAdmin");
        }

        /**--------------------------------------------------------------------------------------------------------------------------------- */

        private function supprimerLivre()
        {
            $erreurMysql = "";
            
            /* Exécution de la requête */
            $reqPDO = new RequetesPDO();
            $erreurMysql = $reqPDO->supprimerItem('livre', $this->id);

            if($erreurMysql === 0)
            {
                $this->listerLivre();
            }else{
                echo $erreurMysql;
            }

            /* Affichage du résultat */
            
        }

        private function supprimerAdministrateur(){ 
            $erreurMysql = "";
            
            /* Exécution de la requête */
            $reqPDO = new RequetesPDO();
            $erreurMysql = $reqPDO->supprimerItem('administrateur', $this->id);

            if($erreurMysql === 0)
            {
                $this->listerAdministrateur();
            }else{
                echo $erreurMysql;
            }
            
        }

        private function supprimerAuteur(){ 
            $erreurMysql = "";
            
            /* Exécution de la requête */
            $reqPDO = new RequetesPDO();
            $erreurMysql = $reqPDO->supprimerItem('auteur', $this->id);

            if($erreurMysql === 0)
            {
                $this->listerAuteur();
            }else{
                echo $erreurMysql;
            }
           
        }

    }        
    