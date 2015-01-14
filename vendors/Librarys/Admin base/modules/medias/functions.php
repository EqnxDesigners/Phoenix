<?php
function the_listing() {
    require_once '../class/medias.class.php';
    $module = new Medias();
    
    echo $module->buildCMSListing($module->reqAllItemsForCMS());
}

function the_edit_box() {
    if(isset($_SESSION['edit-stack'])) {
        require_once '../class/medias.class.php';
        $module = new Medias();

        echo $module->buildEditBox();
    }
}

function txt_fields_by_lang($name) {
    require_once '../class/form.class.php';
    $form = new Formulaire();
    
    echo $form->getTextFieldsByLang($name);
}
?>