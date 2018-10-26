<?php
// *******************************************************
// Class de connexion - singleton
// Auteur : Fen LIU
// Date : 22/09/2018
// *********************************************************

require_once("config.php");

/*
*@brief classe qui sert à créer un singleton pour avoir une connexion unique à la BD
*/ 
class Connexion
{
    private static $instance = null;

    private function __construct()
    {}

    public static function Ouvrir()
    {
        if(is_null(self::$instance))
        {
            try
            {
                $newinstance = new PDO('mysql:host='.DB_HOST.';dbname='.DB_NAME, DB_USER, DB_PASS);
                self::$instance = $newinstance;
            }
            catch(PDOException $e)
            {
                echo "Error : " . $e->getMessage();
            }
        }
        return self::$instance;
    }
}
