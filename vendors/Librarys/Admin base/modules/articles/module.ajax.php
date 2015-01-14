<?php
//Includes et instanciations
include_once '../../../includes/config.inc.php';
include_once '../../../class/db.class.php';
include_once 'module.class.php';
$db = new DB();
$module = new ARTICLES();


//Action des master switch
if(isset($_POST['action']) && $_POST['action'] == 'masterSwitch') {
        mysql_query("UPDATE lay_articles SET active = '".$_POST['new_value']."' WHERE id = '".$_POST['id']."'");	
	echo $module->getMasterSwitch($_POST['id'], $_POST['new_value'], $_POST['element']);
}

//Filtrer les pages par catégories
if(isset($_POST['action']) && $_POST['action'] == 'filterPages') {
    echo $module->getSelectPagesFiltred($_POST['id']);
}

//Action des switch langues
if(isset($_POST['action']) && $_POST['action'] == 'langSwitch') {
        mysql_query("UPDATE trad_articles SET active = '".$_POST['new_value']."' WHERE id_article='".$_POST['idart']."' AND id_lang='".$_POST['idlang']."'");	
	echo $module->getPublishedLang($_POST['idart']);
}

//Switch médias liste
if(isset($_POST['action']) && $_POST['action'] == 'switchMedia') {
    echo $module->getLayoutLstMedias($_POST['typemedia']);
}

//Affichage des médias par type
if(isset($_POST['action']) && $_POST['action'] == 'getArtByPage') {
    $_SESSION['page'] = $_POST['idpage'];
    echo $module->getLayoutLstArticles($_SESSION['page'], $_POST['idcat']);
}

//Nouvel article
if(isset($_POST['action']) && $_POST['action'] == 'resetArticle') {
    unset($_SESSION['id_article']);
    $_SESSION['lang'] = 1;
    $_SESSION['page'] = 'all';
}

//Changement de la variable langue
if(isset($_POST['action']) && $_POST['action'] == 'setVarLang') {
    $_SESSION['lang'] = $_POST['idlang'];    
    echo $_POST['idart'];
}

//Changement de la variable page
if(isset($_POST['action']) && $_POST['action'] == 'setVarPage') {
    $_SESSION['page'] = $_POST['idpage'];
}

//Suppression d'un article
if(isset($_POST['action']) && $_POST['action'] == 'delArticle') {
    mysql_query("DELETE FROM lay_articles WHERE id = '".$_POST['id']."'");
    mysql_query("DELETE FROM trad_articles WHERE id_article = '".$_POST['id']."'");
    
    echo $module->getLayoutLstArticles();
}

//Réorganisation des articles
if(isset($_POST['action']) && $_POST['action'] == 'reorderArticles') {
    //Nettoyage de la chaine transmise
    $lst_ids = $module->cleanLstIds($_POST['lst_ids']);
    //Ordinateur
    $new_order = 1;

    //Réordination de la liste
    foreach($lst_ids as $id) {
        mysql_query("UPDATE `lay_articles` SET `sort`='".$new_order."' WHERE `lay_articles`.`id` ='".$id."'");
        $new_order++;
    }
}
?>