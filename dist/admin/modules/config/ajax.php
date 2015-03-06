<?php
//----- Fichier de configuration --------------------------
require_once dirname(__DIR__).'/../../config/config.inc.php';

//----- Fonctions -----------------------------------------
require_once dirname(__FILE__).'/../../functions.php';

//----- Class ---------------------------------------------
classAutoLoad();
//spl_autoload_register(function($class) {
//    require_once dirname(__DIR__).'/../../class/'.$class.'.class.php';
//});

//--------------- Functions ---------------
if(isset($_POST['a']) && $_POST['a'] === 'updateOptionValue') {
    $Conf = new Config();
    try {
        $Conf->updateOption('value', $_POST['id'], $_POST['value']);
    }
    catch (PDOException $e) {
        echo 'ERRREUR : '.$e;
    }
}

if(isset($_POST['a']) && $_POST['a'] === 'updateOptionCode') {
    $Conf = new Config();
    try {
        echo $Conf->updateOption('code', $_POST['id'], $_POST['value']);
    }
    catch (PDOException $e) {
        echo 'ERREUR : '.$e;
    }
}

//------ Formulaire ---------------------------------------
if(isset($_POST['publish'])) {
    $ReadyToPost = true;
    unset($alert);
    // Test des champs obligatoire
    if (strlen($_POST['code_var']) < 1) {
        $ReadyToPost = false;
        $alert = 'Un code doit être spécifié...';
    }
    if ($_POST['type_var'] === 'bool') {
        if (!isset($_POST['value_var'])) {
            $_POST['value_var'] = 0;
        } else {
            $_POST['value_var'] = 1;
        }
    }
    if ($ReadyToPost) {
        try {
            $Conf = new Config();
            $Conf->addVariable($_POST);
            header("location: ../../index.php?module=" . $_SESSION['current_module']);
        } catch (PDOException $e) {
            $alert = 'ERREUR : ' . $e;
            header("location: ../../index.php?module=" . $_SESSION['current_module'] . "&alert=" . $alert);
        }
    } else {
        header("location: ../../index.php?module=" . $_SESSION['current_module'] . "&alert=" . $alert);
    }
}
?>