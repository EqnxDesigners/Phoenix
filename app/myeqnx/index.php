<?php
//----- Fichier de configuration --------------------------
require_once dirname(__DIR__).'/config/config.inc.php';

//----- Class ---------------------------------------------
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

//    if(isset($_GET['module'])) {
//        the_main_menu($_GET['module']);
//    }
//    else {
//        the_main_menu();
//    }

    echo '<div class="small-10 columns" id="main-wrapper">';

    if(isset($_GET['module'])) {
        displayModule($_GET['module']);
    }
    else {
        displayModule();
    }
    echo '</div></section>';
}
else {
    clearUser();
}

//----- Footer meta datas ---------------------------------
include_once dirname(__FILE__).'/config/footer.meta.php';
?>