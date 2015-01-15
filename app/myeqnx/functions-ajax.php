<?php
//----- Fichier de configuration --------------------------
require_once dirname(__DIR__).'/config/config.inc.php';

//----- Class ---------------------------------------------
spl_autoload_register(function($class) {
    require_once dirname(__DIR__).'/class/'.$class.'.class.php';
});

//--------------- Functions ---------------
if(isset($_POST['a']) && $_POST['a'] === 'logClientIn') {
    $user = new Users();
    try {
        if(!$user->selectClientInfo($_POST['user_login'], $_POST['user_password'])) {
            echo 'FALSE';
        }
        else {
            echo 'TRUE';
        }
    }
    catch (PDOException $e) {
        echo 'Erreur : '.$e->getMessage();
    }
}

if(isset($_POST['a']) && $_POST['a'] === 'valideClient') {
    var_dump($_POST['data']);
//    $user = new Users();
//    try {
//        if(!$user->selectClientInfo($_POST['user_login'], $_POST['user_password'])) {
//            echo 'FALSE';
//        }
//        else {
//            echo 'TRUE';
//        }
//    }
//    catch (PDOException $e) {
//        echo 'Erreur : '.$e->getMessage();
//    }
}

if(isset($_POST['a']) && $_POST['a'] === 'logMeOut') {
    $_SESSION = array();
    unset($_SESSION);
    session_unset();
    session_destroy();
    session_regenerate_id();
}

if(isset($_POST['a']) && $_POST['a'] === 'secureSynch') {
    $user = new Users();
    
    try {
        echo $user->secureSynch();
    }
    catch (PDOException $e) {
        echo 'Erreur : '.$e->getMessage();
    }
}

if(isset($_POST['a']) && $_POST['a'] === 'securityCheck') {
    $user = new Users();
    if(!$user->securityCheck($_POST['token'])) {
        echo 'FALSE';
    }
    else {
        echo 'TRUE';
    }
}
?>