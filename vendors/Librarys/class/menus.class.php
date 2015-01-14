<?php
/*           
==================================================================
Fichier: menus.class.php                                
Description: Class de gestion des menus     
------------------------------------------------------------------
Auteur: Jérôme Clerc                              
Editeurs: Jérôme Clerc
Société: e-novinfo Sàrl                 
Version: 1.0               
------------------------------------------------------------------
Changelog
------------------------------------------------------------------
??.??.???? - 1.1
xxxxxxx

==================================================================
*/

class Menus extends DB {
    /* ATTRIBUTES */
    private $_idpage;
    private $_lang;


    /* CONSTRUCTEUR */
    public function __construct($idpage, $lang) {
        parent::__construct();
        $this->setIdPage($idpage);
        $this->setLang($lang);
    }

    /* GETTER */
    public function getIdPage()         { return $this->_idpage; }
    public function getLang()           { return $this->_lang; }
    
    /* SETTER */
    public function setIdPage($idpage)  { $this->_idpage = $idpage; }
    public function setLang($lang)      { $this->_lang = $lang; }
    
    /* INITTER */
    private function initMain() {
        require_once 'main.class.php';
        return new MAIN();
    }
    
    private function initLang() {
        require_once 'langues.class.php';
        return new Langues();
    }
    
    /* METHODES */
    public function buildMainMenu($data) {
        $result  = '<nav class="navbar navbar-default" role="navigation">';
            $result .= '<div class="row">';
                $result .= '<div class="col-xs-12 col-md-11">';
                    $result .= '<div class="navbar-header">';
                        $result .= '<button type="button" class="navbar-toggle" data-toggle="collapse" data-target=".navbar-ex1-collapse">
                                        <span class="sr-only">Toggle navigation</span>
                                        <span class="icon-bar"></span>
                                        <span class="icon-bar"></span>
                                        <span class="icon-bar"></span>
                                    </button>';
                        $result .= '<a class="navbar-brand visible-xs" href="#">'.NAME_SITE.'</a>';
                    $result .= '</div>';
                    $result .= '<div class="collapse navbar-collapse navbar-ex1-collapse">';
                        $result .= '<ul class="nav navbar-nav">';
                        foreach($data as $k => $mnu) {
                            $result .= $this->getMenuItem($mnu);
                        }
                        $result .= '</ul>';
                    $result .= '</div>';
                $result .= '</div>';
                $result .= '<div class="col-md-1 hidden-xs no-gutter">';
                    $result .= $this->buildLangMenu();
                $result .= '</div>';
            $result .= '</div>';
        $result .= '</nav>';

        return $result;
    }
    
    private function getMenuItem($obj) {
        $langues = $this->initLang();
        
        $items = $this->reqFullMenu($obj->id_page);
        
        if(count($items) != 0) {
            $result  = '<li class="dropdown">';
                $result .= '<a class="dropdown-toggle" data-toggle="dropdown">'.$obj->menu_name.' <b class="caret"></b></a>';
                $result .= '<ul class="dropdown-menu">';
                foreach($items as $k => $mnu) {
                    $result .= $this->getMenuItem($mnu);
                }
                $result .= '</ul>';
            $result .= '</li>';
        }
        else {
            $result = '<li><a href="'.$langues->getCurrentAbrev($this->_lang)->langue.'/'.$obj->id_page.'-'.$obj->page_url.'">'.$obj->menu_name.'</a></li>';
        }
        return $result;
    }
    
    private function buildLangMenu() {
        $main = $this->initMain();
        $langues = $this->initLang();
        
        if($main->isTrue('multi-lang')) {
            $result  = '<div class="dropdown mnu-lang">';
                $result .= '<a href="#" class="dropdown-toggle" data-toggle="dropdown"><span class="glyphicon glyphicon-globe"></span> '.strtoupper($langues->getCurrentAbrev($this->_lang)->langue).'</a>';
                $result .= '<ul class="dropdown-menu">';
                foreach($langues->reqAllLang() as $k => $lang) {
                    $result .= '<li><a href="'.$langues->getCurrentAbrev($lang->id)->langue.'/'.$this->_idpage.'-'.$this->reqCurrentURL($lang->id)->page_url.'">'.$lang->langue_txt.'</a></li>';
                }
                $result .= '</ul>';
            $result .= '</div>';
        }
        else {
            $result = '&nbsp';
        }        
        return $result;
    }
    
    public function buildFooterMenu($data) {
        $langues = $this->initLang();
        $result  = '<div class="row footer-menu hidden-xs">';
            $result .= '<div class="footer-menu-wrapper">';
                $result .= '<ul>';
                foreach($data as $k => $mnu) {
                    $result .= '<li><a href="'.$langues->getCurrentAbrev($this->_lang)->langue.'/'.$mnu->id_page.'-'.$mnu->page_url.'">'.$mnu->menu_name.'</a></li>';
                }
                $result .= '</ul>';
            $result .= '</div>';
        $result .= '</div>';

        return $result;
    }
    
    public function buildAdminMainMenu($module) {
        $lst_modules = array(
                        array('param' => 'commandes', 'name' => 'Commandes'),
                        array('param' => 'produits', 'name' => 'Produits'),
                        /*array('param' => 'categories', 'name' => 'Catégories'),
                        array('param' => 'articles', 'name' => 'Articles'),
                        array('param' => 'medias', 'name' => 'Médias'),
                        array('param' => 'sidebar', 'name' => 'Sidebar'),
                        array('param' => 'options', 'name' => 'Options'),*/
        );
        
        $result  = '<img src="imgs/logo_ilights_small.png">';
        $result .= '<ul>';
        foreach ($lst_modules as $k => $mod) {
            if($module == $mod['param']) {
                $result .= '<li class="active">';
            }
            else {
                $result .= '<li>';
            }
            $result .= '<a href="index.php?module='.$mod['param'].'" target="_self">'.$mod['name'].'</a></li>';
        }
        foreach($this->listAddsModules() as $k => $adds) {
            $result .= '<li>'.$adds.'</li>';
        }
        $result .= '</ul>';
        
        return $result;
    }
    
    private function listAddsModules() {
        $result = array();
        $directory = dirname(__DIR__).'/cms/modules_adds/';
        
        if (is_dir($directory)) {
            if ($dh = opendir($directory)) {
                while (($file = readdir($dh)) !== false) {
                    if($file!='..' && $file!='.') {
                        array_push($result, $file);
                    }
                }
                closedir($dh);
            }
        }
        return $result;
    }
    
    public function reqFullMenu($level = '0') {
        try {
            $sql = "SELECT pages.id AS id_page, id_parent, menu_name, page_url
                    FROM pages
                    INNER JOIN pages_trad ON pages_trad.id_page = pages.id
                    WHERE pages.id_parent='".$level."' AND pages_trad.id_lang='".$this->_lang."' AND pages.active='1' AND pages.is_menu='1'
                    ORDER BY pages.sort ASC";
            return $this->execQuery($sql);
        }
        catch (PDOException $e) {
            throw new PDOException($e);
        }
    }
    
    private function reqCurrentURL($lang) {
        try {
            $sql = "SELECT page_url FROM pages
                    INNER JOIN pages_trad ON pages_trad.id_page = pages.id 
                    WHERE pages.id='".$this->_idpage."' AND pages_trad.id_lang='".$lang."'";
            return $this->execOneResultQuery($sql);
        }
        catch (PDOException $e) {
            throw new PDOException($e);
        }
    }
}
?>