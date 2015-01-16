<?php
//------ Fonctions du module CONFIG -------------------------
function the_Listing() {
    $Media = new Medias();
    try {
        echo $Media->getLstDocs();
    }
    catch (PDOException $e) {
        echo 'ERREUR : '.$e;
    }
}

function autocomplete($id) {
    $Client = new Clients();
    echo $Client->buildAutoCompleteLst($id);
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