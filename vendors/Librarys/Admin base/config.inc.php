<?php
//Démarrage de la session
session_start();

//Affichage des erreurs
ini_set('display_errors', 1); 
error_reporting(E_ALL); 

//Set local time
setlocale(LC_TIME, 'fr_FR.utf8','fra');
//$date = strftime("%A %d %B %Y");

if($_SERVER['HTTP_HOST'] == 'localhost' || $_SERVER['HTTP_HOST'] == '192.168.1.40:8888' || $_SERVER['HTTP_HOST'] == 'srvweb01.enovinfo.local') {
    //DB HOST
    define('DB_HOST', 'localhost');
    //DB NAME
    define('DB_NAME', 'tbfdev'); //Table de base pour le développement
    //DB USER NAME
    define('DB_USER_NAME', 'root');
    //DB PASSWORD
    define('DB_PASSWORD', 'root');
    //DB Data Source Name
    define('DB_DSN', 'mysql:dbname='.DB_NAME.';host='.DB_HOST);
    //Base URL pour le rewrite
    define('BASE_URL', 'http://localhost:8888/TheBunchFactory/WWW/');
}
else {
    //DB HOST
    define('DB_HOST', 'mysql.thebunchfactory.ch');
    //DB NAME
    define('DB_NAME', 'thebunchfactorych1');
    //DB USER NAME
    define('DB_USER_NAME', 'ilights');
    //DB PASSWORD
    define('DB_PASSWORD', 'F1e!i%.mHE1$!Sc');
    //DB Data Source Name
    define('DB_DSN', 'mysql:dbname='.DB_NAME.';host='.DB_HOST);
    //Base URL pour le rewrite
    define('BASE_URL', 'http://www.thebunchfactory.ch/');
}
        
//CMS
define('PAGE_TITLE', 'The Bunch Factory - Book online & take away');
//URL DE BASE DU SITE
define('URL_SITE', 'http://www.thebunchfactory.ch/');
//NOM DU SITE
define('NAME_SITE', 'The Bunch Factory');
//SECURE TOKEN
define('ADMIN_TOKEN', 'cGzgi0vGQ@m1tFggR9p9QPxOhRMYCj5gchqAGUCFiDKSfLG$bv');

//MEDIAS MANAGER
//Largeur maximale d'une image
define('MAX_IMG_DIM', '1024');
//Poid maximal d'une image
define('MAX_IMG_SIZE', '2000000');
//Chemin d'upload par défaut
define('DEFAULT_PATH', './images/produits');
//Taille des vignettes par défaut
define('THUMB_SIZE', '50');
?>