<?php
//----- Fichier de configuration --------------------------
require_once dirname(__FILE__).'/config/config.inc.php';

//----- Class autoload ------------------------------------
require_once dirname(__FILE__).'/class/PHPMailer/PHPMailerAutoload.php';
//classAutoLoad();
spl_autoload_register(function($class) {
    require_once dirname(__FILE__).'/class/'.$class.'.class.php';
});

//----- Fonctions -----------------------------------------
require_once dirname(__FILE__).'/functions.php';

//----- Header meta datas ---------------------------------
include_once dirname(__FILE__).'/config/header.meta.php';

//----- Set default ---------------------------------------
setCurrentPage();
setCurrentLang();

//----- Langues -------------------------------------------
setCurrentLang();

//----- Display -------------------------------------------
include_once dirname(__FILE__).'/includes/header.inc.php';

setCurrentPage();

include_once dirname(__FILE__).'/includes/footer.inc.php';

//include_once dirname(__FILE__).'/includes/'.$_SESSION['current']['page'].'.inc.php';

//----- Footer meta datas ---------------------------------
include_once dirname(__FILE__).'/config/footer.meta.php';
?>