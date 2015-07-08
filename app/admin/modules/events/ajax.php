<?php
//----- Fichier de configuration --------------------------
require_once dirname(__DIR__).'/../../config/config.inc.php';

//----- Fonctions -----------------------------------------
require_once dirname(__FILE__).'/../../functions.php';

//----- Class ---------------------------------------------
classAutoLoad();

//----- Functions -----------------------------------------
if(isset($_POST['a']) && $_POST['a'] === 'changeStatus') {
    $Events = new Events();
    try {
        $Events->setStatus($_POST['idItem'], $_POST['setTo']);
        echo $Events->reloadListing();
    }
    catch (PDOException $e) {
        echo 'ERREUR : '.$e;
    }
}

if(isset($_POST['a']) && $_POST['a'] === 'delEvent') {
    $Events = new Events();
    try {
        $Events->delEvent($_POST['idItem']);
        echo $Events->reloadListing();
    }
    catch (PDOException $e) {
        echo 'ERREUR : '.$e;
    }
}

if(isset($_POST['a']) && $_POST['a'] === 'editEvent') {
    $Events = new Events();
    try {
        echo $Events->buildEditForm($_POST['idItem']);
    }
    catch (PDOException $e) {
        echo 'ERREUR : '.$e;
    }
}

//------ Formulaire ---------------------------------------
if(isset($_POST['add-event'])) {
    $Events = new Events();
    unset($alert);
    unset($_SESSION['data_swap']);

    if(!empty($_POST['event-title']) && !empty($_POST['date-event']) && !empty($_POST['event-hour']) && !empty($_POST['event-min'])) {
        try {
            $Events->addEvent($_POST);
        }
        catch (PDOException $e) {
            $alert = 'ERREUR : '.$e;
        }
    }
    else {
        $alert = "ERREUR : Vous devez saisir un titre, un date et définir l'heure";

    }
    if(!isset($alert)) {
        unset($_SESSION['data_swap']);
        header("location: ../../index.php?module=".$_SESSION['current_module']);
    }
    else {
        $_SESSION['data_swap'] = $_POST;
        header("location: ../../index.php?module=".$_SESSION['current_module']."&alert=".$alert);
    }
}

if(isset($_POST['edit-event'])) {
    $Events = new Events();
    unset($alert);

    // MISE A JOUR DE LA NEWS
    if(!empty($_POST['event-title']) && !empty($_POST['date-event']) && !empty($_POST['event-hour']) && !empty($_POST['event-min'])) {
        try {
            $Events->editEvent($_POST);
        }
        catch (PDOException $e) {
            $alert = 'ERREUR : '.$e;
        }
    }
    else {
        $alert = "ERREUR : Vous devez saisir un titre, un date et définir l'heure";

    }

    if(!isset($alert)) {
        header("location: ../../index.php?module=".$_SESSION['current_module']);
    }
    else {
        header("location: ../../index.php?module=".$_SESSION['current_module']."&alert=".$alert);
    }
}