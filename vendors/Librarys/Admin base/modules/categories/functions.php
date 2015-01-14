<?php
function the_listing() {
    require_once '../class/categories.class.php';
    $module = new Categories();
    
    echo $module->buildCMSListing($module->reqAllItemsForCMS());
}

function txt_fields_by_lang($name) {
    require_once '../class/form.class.php';
    $form = new Formulaire();
    
    echo $form->getTextFieldsByLang($name);
}

function cat_selector() {
    require_once '../class/categories.class.php';
    $module = new Categories();
    
    echo $module->buildCatSelector($module->reqAllCats());    
}
?>