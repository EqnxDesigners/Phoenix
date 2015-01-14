<?php
//Includes et instanciations
include_once '../../../includes/config.inc.php';
include_once '../../../class/db.class.php';
include_once 'module.class.php';
$db = new DB();
$module = new SIDEBAR();


//Action des master switch
if(isset($_POST['action']) && $_POST['action'] == 'masterSwitch') {
        mysql_query("UPDATE lay_sidebar_content SET active = '".$_POST['new_value']."' WHERE id = '".$_POST['id']."'");	
	echo $module->getMasterSwitch($_POST['id'], $_POST['new_value'], $_POST['element']);
}

//Afficher les widgets
if(isset($_POST['action']) && $_POST['action'] == 'getWidgets') {
    $result  = $module->getLayoutLstWidgets($_POST['idpage']);
    $result .= '@';
    $result .= $module->getLayoutLstAssignedWidgets($_POST['idpage']);
    echo $result;
}

//Ajouter un widget à une page
if(isset($_POST['action']) && $_POST['action'] == 'addWidgets') {
    mysql_query("INSERT INTO lay_sidebar_content VALUES ('','".$_POST['idpage']."','".$_POST['idwidget']."','".$module->getLastSort($_POST['idpage'])."','1')");
    echo $module->getLayoutLstAssignedWidgets($_POST['idpage']);
}

//Suppression d'un article
if(isset($_POST['action']) && $_POST['action'] == 'delWidget') {
    mysql_query("DELETE FROM lay_sidebar_content WHERE id = '".$_POST['idwidget']."'");
    echo $module->getLayoutLstAssignedWidgets($_POST['idpage']);
}

//Réorganisation des articles
if(isset($_POST['action']) && $_POST['action'] == 'reorderWidgets') {
    //Nettoyage de la chaine transmise
    $lst_ids = $module->cleanLstIds($_POST['lst_ids']);
    //Ordinateur
    $new_order = 1;

    //Réordination de la liste
    foreach($lst_ids as $id) {
        //echo $id.' : '.$new_order.'<br>';
        mysql_query("UPDATE `lay_sidebar_content` SET `sort`='".$new_order."' WHERE `lay_sidebar_content`.`id` ='".$id."'");
        $new_order++;
    }
}
?>