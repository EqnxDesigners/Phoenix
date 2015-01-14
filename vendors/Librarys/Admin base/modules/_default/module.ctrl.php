<?php

//Nouvelle instance de la class
$module = new CONFIG;

//Gestion d'affichage des pages
if (!isset($_GET['page'])) {
    $page_to_load = 'gestion.php';
    $elem_to_manage = 'categories';
} else {
    $page_to_load = $_GET['page'] . '.php';
    $elem_to_manage = $_GET['gerer'];
}

//Ajout d'une catégorie
if (isset($_POST['add_cat'])) {
   
    $array_values = array($_POST['id_parent'], addslashes($_POST['title_fr']), $module->getLastSortCat($_POST['id_parent']), '1');
    $last_id = $module->addNewCategories($array_values);
    
    $array_values = array();
    foreach ($module->getLstLang() as $lang) {
        $array_values[] = array($last_id, $lang['id'], addslashes($_POST['title_' . $lang['langue']]));
    }

    $module->addNewTradCategories($array_values);

    header("location: dashboard.php?module=" . $_SESSION['module'] . "&page=gestion&gerer=categories");
}

//Edition d'une catégorie
if (isset($_POST['edit-cat'])) {
    mysql_query("UPDATE lay_categories SET cat_name='" . addslashes($_POST['title_fr']) . "' WHERE id='" . $_POST['id_cat'] . "'");
    
    foreach ($module->getLstLang() as $lang) {
        mysql_query("UPDATE trad_categories SET title='" . addslashes($_POST['title_' . $lang['langue']]) . "' WHERE id_categorie='" . $_POST['id_cat'] . "' AND id_lang='" . $lang['id'] . "'");
    }
    
    header("location: dashboard.php?module=" . $_SESSION['module'] . "&page=gestion&gerer=categories");
}

//Création d'une nouvelle page
if (isset($_POST['add_page'])) {
    if (!empty($_POST['page_name'])) {
        if (!isset($_POST['publie_now'])) {
            $active = 0;
        } else {
            $active = $_POST['publie_now'];
        }
        $array_values = array($_POST['categorie'], addslashes($_POST['page_name']), $_POST['template'], $active);

        $last_id = $module->addNewPages($array_values);

        $array_values = array();
        foreach ($module->getLstLang() as $lang) {
            $array_values[] = array($last_id, $lang['id'], addslashes($_POST['title_' . $lang['langue']]));
        }
        $module->addNewTradPages($array_values);
    }
    header("location: dashboard.php?module=".$_SESSION['module']."&page=gestion&gerer=pages");
}

//Mise à jour d'une page
if (isset($_POST['maj_page'])) {
    mysql_query("UPDATE lay_pages SET page_name='" . addslashes($_POST['page_name']) . "' WHERE id='" . $_POST['id_page'] . "'");
    mysql_query("UPDATE lay_pages SET id_template='" . $_POST['template'] . "' WHERE id='" . $_POST['id_page'] . "'");
    mysql_query("UPDATE lay_pages SET id_cat='" . $_POST['categorie'] . "' WHERE id='" . $_POST['id_page'] . "'");

    foreach ($module->getLstLang() as $lang) {
        mysql_query("UPDATE trad_pages SET title='" . addslashes($_POST['title_' . $lang['langue']]) . "' WHERE id_page='" . $_POST['id_page'] . "' AND id_lang='" . $lang['id'] . "'");
    }

    header("location: dashboard.php?module=" . $_SESSION['module'] . "&page=gestion&gerer=pages");
}

//Ajouter un menu
if (isset($_POST['add-menu'])) {
    $array_values = array($_POST['id_parent'], $_POST['id_page'], $module->getLastSortMenu($_POST['id_parent']), '1','0');
    $last_id = $module->addNewMenu($array_values);

    $array_values = array();
    foreach ($module->getLstLang() as $lang) {
        $array_values[] = array($last_id, $lang['id'], addslashes($_POST['menu_name_'.$lang["langue"]]), addslashes($_POST['url_'.$lang["langue"]]));
    }
    $module->addNewTradMenu($array_values);

    header("location: dashboard.php?module=" . $_SESSION['module'] . "&page=gestion&gerer=mainmenu");
}

//Editer un menu
if (isset($_POST['edit-menu'])) {
    
    foreach ($module->getLstLang() as $lang) {
        mysql_query("UPDATE trad_mainmenu SET menu_name='" . addslashes($_POST['menu_name_' . $lang['langue']]) . "', url='".$_POST["url_".$lang['langue']]."' WHERE id_menu='" . $_POST['id_menu'] . "' AND id_lang='" . $lang['id'] . "'");
    }
    
    mysql_query("UPDATE lay_mainmenu SET id_page='" . $_POST['id_page'] . "' WHERE id='" . $_POST['id_menu'] . "'");

    header("location: dashboard.php?module=" . $_SESSION['module'] . "&page=gestion&gerer=mainmenu");
}

//Lier un menu
if (isset($_POST['link-menu'])) {
    mysql_query("UPDATE lay_mainmenu SET id_page='" . $_POST['id_page'] . "' WHERE id='" . $_POST['id_menu'] . "'");

    header("location: dashboard.php?module=" . $_SESSION['module'] . "&page=gestion&gerer=mainmenu");
}

//Ajouter un utilisateur
if (isset($_POST['add_user'])) {
    mysql_query("INSERT INTO cms_users VALUES ('','" . cleanLogin($_POST['login']) . "','" . md5($_POST['password']) . "','" . $_POST['user_name'] . "','" . $_POST['email'] . "','" . $_POST['user_level'] . "')");
    header("location: dashboard.php?module=" . $_SESSION['module'] . "&page=gestion&gerer=users");
}

//Ajouter une langue
if (isset($_POST['add_lang'])) {
    //Ajout de la langue dans la table dédiée
    mysql_query("INSERT INTO lay_langues VALUES ('','" . strtolower($_POST['langue']) . "','" . $_POST['langue_txt'] . "')");
    $idlang = mysql_insert_id();

    foreach (getLstTableDb() as $table) {
        if (isTrad($table)) {
;
            //Récupération de la liste des champs
            $fields = getLstColumns($table);
            foreach (getElemToImplement($table, $fields['1']) as $elem) {
                mysql_query("INSERT INTO " . $table . " (" . $fields['1'] . ", id_lang) VALUES ('" . $elem . "','" . $idlang . "')");
            }
        }
    }
}

function getLstTableDb() {
    $sql = mysql_query("SHOW TABLES");
    $data = mysql_fetch_array($sql);

    $result = array();
    do {
        array_push($result, $data['Tables_in_' . DB_NAME]);
    } while ($data = mysql_fetch_array($sql));

    return $result;
}

function getLstColumns($table) {
    $sql = mysql_query("SHOW COLUMNS FROM " . $table . "");
    $data = mysql_fetch_array($sql);

    $result = array();
    do {
        array_push($result, $data['Field']);
    } while ($data = mysql_fetch_array($sql));

    return $result;
}

function getElemToImplement($table, $field) {
    $sql = mysql_query("SELECT DISTINCT " . $field . " FROM " . $table . "");
    $data = mysql_fetch_array($sql);

    $result = array();
    do {
        array_push($result, $data[$field]);
    } while ($data = mysql_fetch_array($sql));

    return $result;
}

function isTrad($table) {
    return preg_match("/trad_/", $table);
}

function cleanLogin($login) {
    $search = array('à', 'á', 'â', 'ã', 'ä', 'ç', 'è', 'é', 'ê', 'ë', 'ì', 'í', 'î', 'ï', 'ñ', 'ò', 'ó', 'ô', 'õ', 'ö', 'ù', 'ú', 'û', 'ü', 'ý', 'ÿ',
        'À', 'Á', 'Â', 'Ã', 'Ä', 'Ç', 'È', 'É', 'Ê', 'Ë', 'Ì', 'Í', 'Î', 'Ï', 'Ñ', 'Ò', 'Ó', 'Ô', 'Õ', 'Ö', 'Ù', 'Ú', 'Û', 'Ü', 'Ý', ' ', '\'');
    $replace = array('a', 'a', 'a', 'a', 'a', 'c', 'e', 'e', 'e', 'e', 'i', 'i', 'i', 'i', 'n', 'o', 'o', 'o', 'o', 'o', 'u', 'u', 'u', 'u', 'y', 'y',
        'A', 'A', 'A', 'A', 'A', 'C', 'E', 'E', 'E', 'E', 'I', 'I', 'I', 'I', 'N', 'O', 'O', 'O', 'O', 'O', 'U', 'U', 'U', 'U', 'Y', '-', '-');

    $result = str_replace($search, $replace, $login);

    return strtolower($result);
}
?>













