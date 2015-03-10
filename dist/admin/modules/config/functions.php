<?php
//------ Fonctions du module CONFIG -------------------------
function the_Listing() {
    $Conf = new Config();
    try {
        echo $Conf->getLstOptions();
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
?>