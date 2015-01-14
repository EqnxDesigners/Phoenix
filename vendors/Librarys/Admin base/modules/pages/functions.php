<?php
function the_listing() {
    require_once '../class/pages.class.php';
    $module = new Pages();
    
    echo $module->buildCMSListing($module->reqAllItemsForCMS());
}

function txt_fields_by_lang($name) {
    require_once '../class/form.class.php';
    $form = new Formulaire();
    
    echo $form->getTextFieldsByLang($name);
}

function pages_templates() {
    require_once '../class/pages.class.php';
    $module = new Pages();
    
    echo $module->buildTemplateSelector();
}

function pages_selector() {
    require_once '../class/pages.class.php';
    $module = new Pages();
    
    echo $module->buildPagesSelector($module->reqAllPages());    
}
?>