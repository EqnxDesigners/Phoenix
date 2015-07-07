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

function select_lang() {
    $Layouts = new Layouts();
    $Db = new DB();
    
    $sql = "SELECT * FROM langues ORDER BY id ASC";
    echo $Layouts->buildFormSelect('select-lang', 'id', 'langue', $Db->execQuery($sql));
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