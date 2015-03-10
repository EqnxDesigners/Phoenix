<?php
//----- Fichier de configuration --------------------------
require_once dirname(__FILE__).'/config/config.inc.php';

//----- Fonctions -----------------------------------------
require_once dirname(__FILE__).'/functions.php';

//----- Class autoload ------------------------------------
classAutoLoad();
require_once dirname(__FILE__).'/class/PHPMailer/PHPMailerAutoload.php';

//----- Header meta datas ---------------------------------
include_once dirname(__FILE__).'/config/header.meta.php';

//----- Langues -------------------------------------------
setCurrentLang();

//----- Display -------------------------------------------
include_once dirname(__FILE__).'/includes/header.inc.php';

setCurrentPage();

include_once dirname(__FILE__).'/includes/footer.inc.php';

//----- Footer meta datas ---------------------------------
include_once dirname(__FILE__).'/config/footer.meta.php';
?>