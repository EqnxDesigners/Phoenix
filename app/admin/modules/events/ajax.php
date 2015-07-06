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

/*
if(isset($_POST['a']) && $_POST['a'] === 'test') {
    $News = new News();
    $result = $News->getTradIni();
    echo json_encode($result);
}

if(isset($_POST['a']) && $_POST['a'] === 'displayOtherNews') {
    $News = new News();
    try {
        echo $News->getLstNews($_POST['status']);
    }
    catch (PDOException $e) {
        echo 'ERRREUR : '.$e;
    }
}

if(isset($_POST['a']) && $_POST['a'] === 'emptyTrash') {
    $News = new News();
    try {
        $News->emptyTrash();
    }
    catch (PDOException $e) {
        echo 'ERRREUR : '.$e;
    }
}

if(isset($_POST['a']) && $_POST['a'] === 'buildMasseActionsMenu') {
    $News = new News();
    echo $News->getMasseActionsMenu($_POST['status']);
}

if(isset($_POST['a']) && $_POST['a'] === 'switchLang') {
    $News = new News();
    try {
        $_SESSION['current_lang'] = $News->setLang($_POST['lang']);
    }
    catch (PDOException $e) {
        echo 'ERREUR : '.$e;
    }
}

if(isset($_POST['a']) && $_POST['a'] === 'switchLangEdit') {
    $News = new News();
    try {
        $_SESSION['current_lang'] = $News->setLang($_POST['lang']);
        echo $News->buildNewsEditForm($_POST['idItem']);
    }
    catch (PDOException $e) {
        echo 'ERREUR : '.$e;
    }
}



if(isset($_POST['a']) && $_POST['a'] === 'reloadListing') {
    $News = new News();
    try {
        echo $News->reloadListing();
    }
    catch (PDOException $e) {
        echo 'ERREUR : '.$e;
    }
}

if(isset($_POST['a']) && $_POST['a'] === 'loadSelectedNews') {
    $News = new News();
    try {
        echo $News->buildNewsEditForm($_POST['idItem']);
    }
    catch (PDOException $e) {
        echo 'EREUR : '.$e;
    }
}
*/
//------ Formulaire ---------------------------------------
if(isset($_POST['add-event'])) {
    $Events = new Events();
    unset($alert);

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
        header("location: ../../index.php?module=".$_SESSION['current_module']);
    }
    else {
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