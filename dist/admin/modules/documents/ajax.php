<?php
//----- Fichier de configuration --------------------------
require_once dirname(__DIR__).'/../../config/config.inc.php';

//----- Class ---------------------------------------------
require_once dirname(__DIR__).'/../../class/PHPMailer/PHPMailerAutoload.php';
spl_autoload_register(function($class) {
    require_once dirname(__DIR__).'/../../class/'.$class.'.class.php';
});

if(isset($_POST['a']) && $_POST['a'] === 'changePrivacy') {
    $Media = new Medias();
    try {
        $Media->changePrivacy('docs', $_POST['idItem'], $_POST['newValue']);
        echo $Media->reloadListing();
    }
    catch (PDOException $e) {
        echo 'Erreur : '.$e->getMessage();
    }
}

if(isset($_POST['a']) && $_POST['a'] === 'loadClient') {
    $Media = new Medias();
    try {
        echo $Media->loadClientBinded($_POST['idItem'], 'doc');
    }
    catch (PDOException $e) {
        echo 'Erreur : '.$e->getMessage();
    }
}

if(isset($_POST['a']) && $_POST['a'] === 'bindClientToMedia') {
    $Media = new Medias();
    try {
        echo $Media->bindClientToMedia($_POST['idclient'], $_POST['idmedia'], 'doc');
    }
    catch (PDOException $e) {
        echo 'Erreur : '.$e->getMessage();
    }
}

if(isset($_POST['a']) && $_POST['a'] === 'unbindClientToMedia') {
    $Media = new Medias();
    try {
        echo $Media->unbindClientToMedia($_POST['idclient'], $_POST['idmedia'], 'doc');
    }
    catch (PDOException $e) {
        echo 'Erreur : '.$e->getMessage();
    }
}

//------ Formulaire ---------------------------------------
if(isset($_POST['publish'])) {
    $ReadyToPost = true;
    unset($alert);
//    var_dump($_POST);
    if(strlen($_POST['categorie']) < 1 && strlen($_POST['file_name']) < 1) {
        $ReadyToPost = false;
        $alert = 'Une catégorie et un fichier doivent être spécifiés...';
    }
    if($ReadyToPost) {
        (!isset($_POST['private']) ? $_POST['private'] = '0' : $_POST['private'] = '1');
        try {
            $Media = new Medias();
            $Media->addItem($_POST, 'docs');
            header("location: ../../index_spip.php?module=".$_SESSION['current_module']);
        }
        catch (PDOException $e) {
            $alert = 'ERREUR : '.$e;
            header("location: ../../index_spip.php?module=".$_SESSION['current_module']."&alert=".$alert);
        }
    }
    else {
        header("location: ../../index_spip.php?module=".$_SESSION['current_module']."&alert=".$alert);
    }
}

//if(isset($_POST['majitem'])) {
//    $ReadyToPost = true;
//    unset($alert);
//    if(strlen($_POST['societe']) < 1) {
//        if(strlen($_POST['nom']) < 1 && strlen($_POST['prenom']) < 1) {
//            $ReadyToPost = false;
//            $alert = 'Une société, un nom ou un prénom doit être spécifié...';
//        }
//    }
//    if($ReadyToPost) {
//        try {
//            $Client = new Clients();
//            $Client->updateClient($_POST);
//            header("location: ../../index_spip.php?module=".$_SESSION['current_module']);
//        }
//        catch (PDOException $e) {
//            $alert = 'ERREUR : '.$e;
//            header("location: ../../index_spip.php?module=".$_SESSION['current_module']."&alert=".$alert);
//        }
//    }
//    else {
//        header("location: ../../index_spip.php?module=".$_SESSION['current_module']."&alert=".$alert);
//    }
//}
?>
