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

//DB HOST
define('DB_HOST', 'mysql.kiwanis-cossonay.ch');
//DB NAME
define('DB_NAME', 'kiwaniscossonaych14');
//DB USER NAME
define('DB_USER_NAME', 'ilights');
//DB PASSWORD
define('DB_PASSWORD', 'cE@TLVuo9Zok');
//DB Data Source Name
define('DB_DSN', 'mysql:dbname='.DB_NAME.';host='.DB_HOST);
//Base URL pour le rewrite
define('BASE_URL', 'http://www.kiwanis-cossonay.ch/eqnx-test/');
        
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