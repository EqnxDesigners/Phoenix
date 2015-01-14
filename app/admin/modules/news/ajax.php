<?php
//----- Fichier de configuration --------------------------
require_once dirname(__DIR__).'/../../config/config.inc.php';

//----- Class ---------------------------------------------
spl_autoload_register(function($class) {
    require_once dirname(__DIR__).'/../../class/'.$class.'.class.php';
});

//--------------- Functions ---------------
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

if(isset($_POST['a']) && $_POST['a'] === 'changeStatus') {
    $News = new News();
    try {
        $News->setVisibility($_POST['idItem'], $_POST['setTo']);
        echo $News->reloadListing();
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

//------ Formulaire ---------------------------------------
if(isset($_POST['save-news']) || isset($_POST['publish-news'])) {
    $News = new News();
    $Langue = new Langues();
    unset($alert);
    if(isset($_POST['save-news']) && !isset($_POST['publish-news'])) {
        // ENREGISTREMENT DE LA NEWS
        try {
            $News->saveNews($_POST);
        }
        catch (PDOException $e) {
            $alert = 'ERREUR : '.$e;
        }
    }
    else {
        // PUBLICATION DE LA NEWS
        $lg = $Langue->getLangByiD($_POST['select-lang'])->langue_abrev;
        if(strlen($_POST['title_'.$lg]) > 1 && strlen($_POST['news-editor_'.$lg]) > 10) {
            try {
                $News->publishNews($_POST);
            }
            catch (PDOException $e) {
                $alert = 'ERREUR : '.$e;
            }
        }
        else {
            $alert = 'ERREUR : Vous devez, au moins, saisir un titre et du texte...';
        }
        
    }
    if(!isset($alert)) {
        header("location: ../../index.php?module=".$_SESSION['current_module']);
    }
    else {
        header("location: ../../index.php?module=".$_SESSION['current_module']."&alert=".$alert);
    }
}

if(isset($_POST['maj-news'])) {
    $News = new News();
    unset($alert);
    // MISE A JOUR DE LA NEWS
    try {
        $News->majNews($_POST);
    }
    catch (PDOException $e) {
        $alert = 'ERREUR : '.$e;
    }
    if(!isset($alert)) {
        header("location: ../../index.php?module=".$_SESSION['current_module']);
    }
    else {
        header("location: ../../index.php?module=".$_SESSION['current_module']."&alert=".$alert);
    }
}
?>