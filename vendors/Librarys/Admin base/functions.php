<?php
//------ Fonctions -----------------------------------------
function the_content($module=NULL) {
    if($module != NULL) {
        if(!isset($_SESSION['user']) || $_SESSION['user']['token'] != ADMIN_TOKEN) {
            include_once dirname(__FILE__).'/login.php';
        }
        else {
            include_once dirname(__FILE__).'/modules/'.$module.'/index.php';
        }
    }
    else {
        include_once dirname(__FILE__).'/login.php';
    }
}

function the_top_menu() {
    include_once dirname(__FILE__).'/includes/top-menu.inc.php';
}

function the_main_menu($module) {
    require_once dirname(__DIR__).'/class/menus.class.php';
    $menu = new Menus('1', '1');
    
    echo $menu->buildAdminMainMenu($module);
}

function the_header() {
    include_once dirname(__FILE__).'/pages/header.php';
}

function the_footer() {
    include_once dirname(__FILE__).'/pages/footer.php';
}

function the_menu($type = 'main') {
    require_once dirname(__FILE__).'/class/menus.class.php';
    $menu = new Menus($_GET['id_page'], $_GET['lang']);
    
    if($type == 'main')     {
        try {
            echo $menu->buildMainMenu($menu->reqFullMenu());
        }
        catch (Exception $e) {
            echo '';
        }
    }
    if($type == 'footer')   {
        try {
            echo $menu->buildFooterMenu($menu->reqFullMenu());
        }
        catch (Exception $e) {
            //echo 'Erreur : '.$e->getMessage();
            echo '...';
        }
    }
}

?>