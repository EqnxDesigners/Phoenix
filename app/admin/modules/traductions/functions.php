<?php
//------ Langues ------------------------------------------
if(isset($_SESSION['current_lang'])) {
    $Langue = new Langues();
    try {
        $_SESSION['current_lang'] = $Langue->setLangById(DEFAULT_LANG);
    }
    catch (PDOException $e) {
        echo 'ERREUR : '.$e;
    }
}

//------ Fonctions du module EVENTS -----------------------
function the_Listing() {
    $Trad = new Traductions();
    try {
        echo $Trad->getLstTrads();
    }
    catch (PDOException $e) {
        echo 'ERREUR : '.$e;
    }
}

function the_trad_fields() {
    $Trad = new Traductions();
    try {
        echo $Trad->buildTradFields();
    }
    catch (PDOException $e) {
        echo 'ERREUR : '.$e;
    }
}

function display_alert() {
    if(isset($_GET['alert'])) {
        $result = '<div class="row">';
            $result .= '<div class="small-8 small-centered columns">';
                $result .= '<div data-alert class="alert-box alert">';
                    $result .= $_GET['alert'];
                    $result .= '<a href="#" class="close">&times;</a>';
                $result .= '</div>';
            $result .= '</div>';
        $result .= '</div>';
        echo $result;
    }
}

function the_value($index) {
    if(isset($_SESSION['data_swap'][$index])) {
        echo $_SESSION['data_swap'][$index];
    }
}