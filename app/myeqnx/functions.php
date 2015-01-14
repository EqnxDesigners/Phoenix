<?php
//------ Fonctions -----------------------------------------
function clearUser() {
    $_SESSION = array();
    unset($_SESSION);
    session_unset();
    session_destroy();
    include_once dirname(__FILE__).'/login.php';
}

function displayModule($module = NULL) {
    if($module === NULL) {
        include_once dirname(__FILE__).'/modules/'.DEFAULT_MODULE.'/index.php';
        $_SESSION['current_module'] = DEFAULT_MODULE;
    }
    else {
        include_once dirname(__FILE__).'/modules/'.$module.'/index.php';
        $_SESSION['current_module'] = $module;
    }
}

function the_top_bar() {
    $layout = new Layouts();
    $layout->buildTopBar();
}

function the_main_menu($module = NULL) {
    $layout = new Layouts();
    $layout->buildMainMenu($module);
}
?>