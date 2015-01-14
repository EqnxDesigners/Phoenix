<?php
//Includes et instanciations
include_once '../../../includes/config.inc.php';
include_once '../../../class/db.class.php';
include_once 'module.class.php';
$db = new DB();
$module = new CONFIG();

//Action des master switch
if(isset($_POST['action']) && $_POST['action'] == 'masterSwitch') {
	if($_POST['element'] == 'page') {
		mysql_query("UPDATE lay_pages SET active = '".$_POST['new_value']."' WHERE id = '".$_POST['id']."'");
		mysql_query("UPDATE lay_mainmenu SET active = '".$_POST['new_value']."' WHERE id_page = '".$_POST['id']."' AND id_parent <> '0'");
	}
        if($_POST['element'] == 'mainmenu') {
		mysql_query("UPDATE lay_mainmenu SET active = '".$_POST['new_value']."' WHERE id = '".$_POST['id']."'");
	}
        if($_POST['element'] == 'option') {
            mysql_query("UPDATE cms_global_options SET value = '".$_POST['new_value']."' WHERE id = '".$_POST['id']."'");
        }
        if($_POST['element'] == 'categories') {
            mysql_query("UPDATE lay_categories SET active = '".$_POST['new_value']."' WHERE id = '".$_POST['id']."'");
        }
	
	echo $module->getMasterSwitch($_POST['id'], $_POST['new_value'], $_POST['element']);
}

//Afficher les pages par catégories
if(isset($_POST['action']) && $_POST['action'] == 'sortPageByCat') {
    echo $module->getLayoutPages($_POST['id']);
}

//Supprimer une catégorie
if(isset($_POST['action']) && $_POST['action'] == 'delCat') {    
    mysql_query("DELETE FROM trad_categories WHERE id_categorie = '".$_POST['id']."'");
    mysql_query("DELETE FROM lay_categories WHERE id_parent = '".$_POST['id']."'");
    mysql_query("DELETE FROM lay_categories WHERE id = '".$_POST['id']."'");
        
    echo $module->getLayoutCats();
}

//Supprimer une page
if(isset($_POST['action']) && $_POST['action'] == 'delPage') {
    mysql_query("DELETE FROM trad_pages WHERE id_page = '".$_POST['id']."'");
    mysql_query("DELETE FROM lay_pages WHERE id = '".$_POST['id']."'");
    
    //Suppression des articles liés à la page
    $req = mysql_query("SELECT id FROM lay_articles WHERE id_page='".$_POST['id']."'");
    $data = mysql_fetch_array($req);
    
    //Suppression des articles
    do {
        mysql_query("DELETE FROM trad_articles WHERE id_article='".$data['id']."'");
    } while($data = mysql_fetch_array($req));
    mysql_query("DELETE FROM lay_articles WHERE id='".$_POST['id']."'");
    
    echo $module->getLayoutPages();
}

//Supprimer un utilisateur
if(isset($_POST['action']) && $_POST['action'] == 'delUser') {
    mysql_query("DELETE FROM cms_users WHERE id='".$_POST['id']."'");
    
    echo $module->getLayoutUsers();
}

//Supprimer un menu
if(isset($_POST['action']) && $_POST['action'] == 'delMenu') {
    $id_parent = $module->getMenuParentId($_POST['id']);
    //echo $id_parent;
    if($module->getMenuParentId($_POST['id']) || $module->getMenuParentId($_POST['id']) == '0') {
        //echo 'EFFACEMENT';
        mysql_query("DELETE FROM trad_mainmenu WHERE id_menu='".$_POST['id']."'");
        mysql_query("DELETE FROM lay_mainmenu WHERE id='".$_POST['id']."'");
    }
    else {
        echo 'PAD EFFACEMENT';
    }
    
    $module->resortMainMenu($id_parent);
    
    echo $module->getLayoutMainMenu();
}

//Réordonner les menu
if(isset($_POST['action']) && $_POST['action'] == 'reorderMenu') {
	//Nettoyage de la chaine transmise
	$lst_ids = $module->cleanLstIds($_POST['lst_ids']);

	//Ordinateur
	$new_order = 1;
        
        $final_lst_ids = $module->filterLstIds($lst_ids, $_POST['id_parent']);
        //var_dump($final_lst_ids);
	
	//Réordination de la liste
        foreach($final_lst_ids as $id) {
            //echo $id.'<br>';
            //echo $new_order.'<br>';
            mysql_query("UPDATE `lay_mainmenu` SET `sort`='".$new_order."' WHERE `lay_mainmenu`.`id` ='".$id."'");
            $new_order++;
        }
}

//Changer la valeure d'un option
if(isset($_POST['action']) && $_POST['action'] == 'changeOptionValue') {
    mysql_query("UPDATE `cms_global_options` SET `value`='".$_POST['newvalue']."' WHERE `cms_global_options`.`id` ='".$_POST['idoption']."'");
}

//Formater l'URL d'un lien
if(isset($_POST['action']) && $_POST['action'] == 'formatMnuUrl') {
    //Suppression des accents, espaces et apostrophe
    $search = array('à','á','â','ã','ä','ç','è','é','ê','ë','ì','í','î','ï','ñ','ò','ó','ô','õ','ö','ù','ú','û','ü','ý','ÿ',
                    'À','Á','Â','Ã','Ä','Ç','È','É','Ê','Ë','Ì','Í','Î','Ï','Ñ','Ò','Ó','Ô','Õ','Ö','Ù','Ú','Û','Ü','Ý',' ','\'');
    $replace = array('a','a','a','a','a','c','e','e','e','e','i','i','i','i','n','o','o','o','o','o','u','u','u','u','y','y',
                     'A','A','A','A','A','C','E','E','E','E','I','I','I','I','N','O','O','O','O','O','U','U','U','U','Y','-','-');

    $result = str_replace($search, $replace, $_POST['mnuname']);
    
    echo strtolower($result);
}

//Supprimer une langue
if(isset($_POST['action']) && $_POST['action'] == 'delLang') {
    //Suppression des traductions
    foreach(getLstTableDb() as $table) {
        mysql_query("DELETE FROM ".$table." WHERE id_lang='".$_POST['id']."'");
    }
    //Suppression de la langue
    mysql_query("DELETE FROM lay_langues WHERE id='".$_POST['id']."'");
    
    echo $module->getLayoutLangues();
}

function getLstTableDb() {
    $sql = mysql_query("SHOW TABLES");
    $data = mysql_fetch_array($sql);
    
    $result = array();
    do {
        array_push($result, $data['Tables_in_'.DB_NAME]);
    } while($data = mysql_fetch_array($sql));
    
    return $result;
}

function isTrad($table) {
    return preg_match("/trad_/", $table);
}
?>