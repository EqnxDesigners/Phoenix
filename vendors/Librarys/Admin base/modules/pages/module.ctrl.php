<?php
//------ Ajouter une page -----------------------------------------------
if(isset($_POST['add-item'])) {
    unset($alert_add);
    if(strlen($_POST['page_name']) > 0) {
        require_once '../class/pages.class.php';
        $module = new Pages();
        
        try {
            $module->addItem($_POST);
            header("location: ".$_SERVER['HTTP_REFERER']);
        }
        catch (Exception $e) {
            $alert_add = $e->getMessage();
        }
    }
    else {
        $alert_add = 'Indiquer un nom de page...';
    }
}
?>