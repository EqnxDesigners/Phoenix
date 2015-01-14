<?php 
//////////////////////////////////////////////////////////
// ALANA 0.1 | Site builder by iLights - Web&Design     //
// (C) 2013 - 2014 | Jérôme Clerc                       //
//                                                      //
// I named this project "Alana" in honor to my little   //
// princess, who's born in 2014. Kiss, your geeky dad   //
//////////////////////////////////////////////////////////

//--------------- Fichier de configuration ---------------
require_once dirname(__DIR__).'/includes/config.inc.php';

//--------------- Class ---------------
require_once dirname(__DIR__).'/class/db.class.php';

//--------------- Fonctions ---------------
require_once dirname(__FILE__).'/functions.php';

//--------------- Header meta datas ---------------
include_once dirname(__FILE__).'/includes/header.meta.php';

//--------------- Templates ---------------
if(isset($_GET['module'])) {
    try {
        the_content($_GET['module']);
    }
    catch (Exception $e) {
        $alert = $e->getMessage();
    }
}
else {
    try {
        the_content();
    }
    catch (Exception $e) {
        $alert = $e->getMessage();
    }
}


//--------------- Footer meta datas ---------------
include_once dirname(__FILE__).'/includes/footer.meta.php';
?>