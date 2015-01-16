<?php
//------ Fonctions -----------------------------------------
function clearUser() {
    $_SESSION = array();
    unset($_SESSION);
    session_unset();
    session_destroy();
    include_once dirname(__FILE__).'/login.php';
}

function the_top_bar() {
    $layout = new Layouts();
    $layout->buildMyEqnxTopBar();
}
?>