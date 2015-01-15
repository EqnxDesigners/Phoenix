<?php
//----- Fichier de configuration --------------------------
require_once dirname(__DIR__).'/../../config/config.inc.php';

//----- Class ---------------------------------------------
require_once dirname(__DIR__).'/../../class/PHPMailer/PHPMailerAutoload.php';
spl_autoload_register(function($class) {
    require_once dirname(__DIR__).'/../../class/'.$class.'.class.php';
});

//--------------- Functions ---------------
//if(isset($_POST['a']) && $_POST['a'] === 'updateOptionValue') {
//    $Conf = new Config();
//    try {
//        $Conf->updateOption('value', $_POST['id'], $_POST['value']);
//    }
//    catch (PDOException $e) {
//        echo 'ERRREUR : '.$e;
//    }
//}
//
//if(isset($_POST['a']) && $_POST['a'] === 'updateOptionCode') {
//    $Conf = new Config();
//    try {
//        echo $Conf->updateOption('code', $_POST['id'], $_POST['value']);
//    }
//    catch (PDOException $e) {
//        echo 'ERREUR : '.$e;
//    }
//}


//------ Formulaire ---------------------------------------
if(isset($_POST['publish'])) {
    $ReadyToPost = true;
    unset($alert);
    if(strlen($_POST['societe']) < 1) {
        if(strlen($_POST['nom']) < 1 && strlen($_POST['prenom']) < 1) {
            $ReadyToPost = false;
            $alert = 'Une société, un nom ou un prénom doit être spécifié...';
        }
    }
    if($ReadyToPost) {
        try {
            $Client = new Clients();
            $Client->addClient($_POST);
            header("location: ../../index.php?module=".$_SESSION['current_module']);
        }
        catch (PDOException $e) {
            $alert = 'ERREUR : '.$e;
            header("location: ../../index.php?module=".$_SESSION['current_module']."&alert=".$alert);
        }
    }
    else {
        header("location: ../../index.php?module=".$_SESSION['current_module']."&alert=".$alert);
    }
}

if(isset($_POST['majitem'])) {
    $ReadyToPost = true;
    unset($alert);
    if(strlen($_POST['societe']) < 1) {
        if(strlen($_POST['nom']) < 1 && strlen($_POST['prenom']) < 1) {
            $ReadyToPost = false;
            $alert = 'Une société, un nom ou un prénom doit être spécifié...';
        }
    }
    if($ReadyToPost) {
        try {
            $Client = new Clients();
            $Client->updateClient($_POST);
            header("location: ../../index.php?module=".$_SESSION['current_module']);
        }
        catch (PDOException $e) {
            $alert = 'ERREUR : '.$e;
            header("location: ../../index.php?module=".$_SESSION['current_module']."&alert=".$alert);
        }
    }
    else {
        header("location: ../../index.php?module=".$_SESSION['current_module']."&alert=".$alert);
    }
}
?>
