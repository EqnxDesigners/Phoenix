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

//------ Fonctions du module NEWS -------------------------
function the_masse_actions_menu($status = '0') {
    $News = new News();
    echo $News->getMasseActionsMenu($status);
}

function the_Listing($status = '0') {
    $News = new News();
    try {
        echo $News->getLstNews($status);
    }
    catch (PDOException $e) {
        echo 'ERREUR : '.$e;
    }
}

function the_trad_fields() {
    $News = new News();
    echo $News->buildTradFields();
}

function select_lang() {
    $Layouts = new Layouts();
    $Db = new DB();
    
    var_dump($Db);
    
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
?>