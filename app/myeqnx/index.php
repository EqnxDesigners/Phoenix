<?php
//----- Fichier de configuration --------------------------
require_once dirname(__DIR__).'/config/config.inc.php';

//----- Class ---------------------------------------------
require_once dirname(__DIR__).'/class/PHPMailer/PHPMailerAutoload.php';
spl_autoload_register(function($class) {
    require_once dirname(__DIR__).'/class/'.$class.'.class.php';
});

//----- Fonctions -----------------------------------------
require_once dirname(__FILE__).'/functions.php';

//----- Header meta datas ---------------------------------
include_once dirname(__FILE__).'/config/header.meta.php';



//----- Langues -------------------------------------------
//if(!isset($_GET['lang'])) {
//    $_SESSION['current_lang'] = DEFAULT_LANG;
//}
//else {
//    $_SESSION['current_lang'] = $_GET['lang'];
//}

//----- Templates -----------------------------------------
   

if(isset($_SESSION['user'])) {
    the_top_bar();
    //----- navigation file ---------------------------------
    include_once dirname(__FILE__).'/includes/mainmenu.inc.php';
    
    if(!isset($_GET['page'])) {
        include_once dirname(__FILE__).'/includes/documents.inc.php';
    }
    else {
        include_once dirname(__FILE__).'/includes/'.$_GET['page'].'.inc.php';
    } 
}
else {
    clearUser();
}    

//----- Footer meta datas ---------------------------------
include_once dirname(__FILE__).'/config/footer.meta.php';
?>