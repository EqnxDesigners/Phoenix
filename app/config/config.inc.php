<?php
//Démarrage de la session
session_start();

//Affichage des erreurs
ini_set('display_errors', 1); 
error_reporting(E_ALL); 

//Set local time
setlocale(LC_TIME, 'fr_FR.utf8','fra');
date_default_timezone_set('Europe/London');
//$date = strftime("%A %d %B %Y");

if($_SERVER['HTTP_HOST'] === 'localhost' || $_SERVER['HTTP_HOST'] === 'localhost:8888') {
    //DB HOST
    define('DB_HOST', 'localhost');
    //DB NAME
    define('DB_NAME', 'eqnxweb'); //Table de base pour le développement
    //DB USER NAME
    define('DB_USER_NAME', 'root');
    //DB PASSWORD
    define('DB_PASSWORD', 'root');
    //DB Data Source Name
    define('DB_DSN', 'mysql:dbname='.DB_NAME.';host='.DB_HOST);
    //Base URL pour le rewrite
    define('BASE_URL', 'http://localhost:8888/Phoenix/app/');
}
else {
    //DB HOST
    define('DB_HOST', 'mysql03');
    //DB NAME
    define('DB_NAME', 'db2649905 ');
    //DB USER NAME
    define('DB_USER_NAME', 'user26499');
    //DB PASSWORD
    define('DB_PASSWORD', 'dr94Y?2');
    //DB Data Source Name
    define('DB_DSN', 'mysql:dbname='.DB_NAME.';host='.DB_HOST);
    //Base URL pour le rewrite
//    define('BASE_URL', 'http://www.equinoxemis.ch/');
    define('BASE_URL', 'http://www.ilights.ch/eqnx/site/');
}
        
//TITRE DES PAGES
define('PAGE_TITLE', 'Equinoxe MIS Development');
//URL DE BASE DU SITE
define('URL_SITE', 'http://www.equinoxemis.ch/');
//NOM DU SITE
define('NAME_SITE', 'Equinoxe MIS Development');

//LANGUE PAR DEFAUT
define('DEFAULT_LANG', '1');

//PAGE PAR DEFAUT
define('DEFAULT_PAGE', 'accueil');

//MODULE PAR DEFAUT
define('DEFAULT_MODULE', 'news');

?>