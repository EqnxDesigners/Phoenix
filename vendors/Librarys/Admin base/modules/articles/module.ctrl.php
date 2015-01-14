<?php
//------ Ajouter une categorie -----------------------------------------------
if(isset($_POST['add-item'])) {
    unset($alert_add);
    if(strlen($_POST['categorie_fr']) > 0) {
        require_once '../class/categories.class.php';
        $module = new Categories();
        
        try {
            $module->addItem($_POST);
            header("location: ".$_SERVER['HTTP_REFERER']);
        }
        catch (Exception $e) {
            $alert_add = $e->getMessage();
        }
    }
    else {
        $alert_add = 'Indiquer un nom de catégories...';
    }
}
?>