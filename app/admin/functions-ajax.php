<?php
//----- Fichier de configuration --------------------------
require_once dirname(__DIR__).'/config/config.inc.php';

//----- Class ---------------------------------------------
spl_autoload_register(function($class) {
    require_once dirname(__DIR__).'/class/'.$class.'.class.php';
});

//--------------- Functions ---------------
if(isset($_POST['a']) && $_POST['a'] === 'logMeIn') {
    $user = new Users();
    try {
        if(!$user->selectUserInfo($_POST['user_login'], $_POST['user_password'])) {
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

if(isset($_POST['a']) && $_POST['a'] === 'editItem') {
    $theClass = initTheClass($_SESSION['current_module']);
    try {
        echo $theClass->buildEditForm($_POST['idItem']);
    }
    catch (PDOException $e) {
        echo 'Erreur : '.$e->getMessage();
    }
}

if(isset($_POST['a']) && $_POST['a'] === 'deleteItem') {
    $theClass = initTheClass($_SESSION['current_module']);
    try {
        $theClass->deleteItem($_POST['idItem']);
        echo $theClass->reloadListing();
    }
    catch (PDOException $e) {
        echo 'Erreur : '.$e->getMessage();
    }
}

if(isset($_POST['a']) && $_POST['a'] === 'changeVisibility') {
    $theClass = initTheClass($_SESSION['current_module']);
    ($_SESSION['current_module'] === 'documents' ? $table = 'docs' : $table = 'videos');
    try {
        $theClass->changeVisibility($table, $_POST['idItem'], $_POST['newValue']);
        echo $theClass->reloadListing();
    }
    catch (PDOException $e) {
        echo 'Erreur : '.$e->getMessage();
    }
}

function initTheClass($ref) {
    switch($ref) {
        case 'config':
            $instance = new Config();
            break;
        case 'news':
            $instance = new News();
            break;
        case 'clients':
            $instance = new Clients();
            break;
        case 'documents':
            $instance = new Medias();
            break;
        case 'videos':
            $instance = new Medias();
            break;
    }
    return $instance;
}
?>