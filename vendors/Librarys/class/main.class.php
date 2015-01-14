<?php

/*
  ==================================================================
  Class: MAIN
  Description: Class de gestion du site
  ------------------------------------------------------------------
  Auteur: jcl
  Editeurs: jcl
  Société: e-novinfo Sàrl
  Version: 1.0
  ------------------------------------------------------------------
  Changelog
  ------------------------------------------------------------------
  XX.XX.XXXX - X.X
  Description de la modification

  ==================================================================
 */

class MAIN extends DB {
    /* ATTRIBUTS */
    private $_idpage;
    private $_lang;
    
    public function __construct($idpage='1', $lang='1') {
	//require_once'tests.class.php';
	//require_once'format.class.php';
        //
        //Constructeur de la CLASS parent
	parent::__construct();
        
        $this->setIdPage($idpage);
        $this->setLang($lang);     
    }
    
    /* GETTER */
    public function getIdPage()		{ return $this->_idpage; }
    public function getLang()		{ return $this->_lang; }
	
    /* SETTER */
    public function setIdPage($idpage)	{ $this->_idpage = $idpage; }
    public function setLang($lang)	{ $this->_lang = $lang; }
    
    /* INITTER */
    private function initLayout() {
        include_once 'layout.class.php';
        return $result = new LAYOUT($this->_lang);
    }
    
    /*
    public function initMain($idpage, $lang) {
        //Setting des variables
        $this->setIdPage($idpage);
        
        if(!is_numeric($lang)) {
            $this->setLang($this->getLangID($lang));
        }
        else {
            $this->setLang($lang);
        }
    }
    */
    
    private function initUsers($login, $password) {
        include_once '../cms/class/users.class.php';
        return $result = new USERS($login, $password);
    }
    
    private function initRwcupPwd() {
        include_once '../cms/class/recuppwd.class.php';
        return $result = new RECUPPWD();
    }
	
    /* METHODES */
    public function getPageTitle() {
        $query = mysql_query("SELECT title FROM trad_pages WHERE id_page = '".$this->_idpage."' AND id_lang = '".$this->_lang."'");
        return $result = mysql_result($query, 0);
    }
    
    public function getBadge() {
        $layout = $this->initLayout(); 
        return '<img src="images/badge_'.$layout->getLangAbrev().'.png" class="badge-dates">';
    }
    
    public function getSlideShow($title, $type) {        
        $layout = $this->initLayout();        
        if($this->getSlideFiles($title)) {
            $result = $layout->buildSlideshow($this->getSlideFiles($title), $title, $type);
        }
        else {
            $result = FALSE;
        }
        return $result;
    }
    
    private function getSlideFiles($title) {
        $query = "SELECT file
                    FROM lay_slideshows_imgs
                    INNER JOIN lay_slideshows ON lay_slideshows.id = lay_slideshows_imgs.id_slide
                    INNER JOIN lib_medias_adds ON lib_medias_adds.id_media = lay_slideshows_imgs.id_media
                    WHERE lay_slideshows.titre='".$title."' AND lib_medias_adds.id_format<>'99'
                    ORDER BY lay_slideshows_imgs.sort ASC";
        return $this->executeExternalQuery($query);
    }
    
    public function getHeaderImg($pic_name) {
        $layout = $this->initLayout();
        return $result = $layout->buildFixeHeader($this->getSlideFiles('images/slideshows', $pic_name));
    }
    
    public function getMenu($type) {
        $layout = $this->initLayout();
        if($type == 'nav-bar')      { $result = $layout->buildNavBarMenu(); }
        if($type == 'accordion')    { $result = $layout->buildAccordionMenu(); }
        if($type == 'footer')       { $result = $layout->buildFooterMenu(); }
        return $result;
    }
    
    public function getLangMenu($type) {
        $layout = $this->initLayout();
        return $result = $layout->buildLangMenu($this->_idpage, $type);
    }
    
    public function getPageTemplate() {
        $layout = $this->initLayout();
        return $layout->getTemplate($this->_idpage);
    }
    
    public function getPageContent() {
        $layout = $this->initLayout();
        $layout->buildPageContent($this->_idpage, $this->_lang);
    }
    
    public function getSidebarContent() {
        $layout = $this->initLayout();
        $layout->buildSidebarContent($this->_idpage);
    }
    
    public function getSponsors() {
        $layout = $this->initLayout();
        $layout->buildSponsors($this->_lang);
    }
    
    public function getLangID($lang) {
        $query = mysql_query("SELECT id FROM lay_langues WHERE langue = '".$lang."'");
        return $result = mysql_result($query, 0);
    }
    
    public function getLangAbrev($lang) {
        $query = mysql_query("SELECT langue FROM lay_langues WHERE id='".$lang."'");
        return mysql_result($query, 0);
    }
    
    public function getURLByPageId($idpage, $lang) {
        $query = mysql_query("SELECT url
                                FROM lay_mainmenu
                                INNER JOIN trad_mainmenu ON trad_mainmenu.id_menu = lay_mainmenu.id
                                WHERE lay_mainmenu.id_page = '".$idpage."' AND trad_mainmenu.id_lang = '".$this->getLangID($lang)."'");
        return $result = mysql_result($query, 0);
    }
    
    public function checkIfWidgets($idpage) {
        $query = mysql_query("SELECT id_widget FROM lay_sidebar_content WHERE id_page = '".$idpage."' AND active = '1'");
        if(mysql_num_rows($query)) {
            return TRUE;
        }
        else {
            return FALSE;
        }
    }
    
    private function getFiles($folder) {
        $dir = opendir($folder);
	$result = array();
		
	while($file = readdir($dir)) {
            if($file != '.' && $file != '..') {
                array_push($result, $file);
            }
        }
        return $result;
    }
    
    public function isTrue($ref) {
        $sql = "SELECT value FROM cms_global_options WHERE ref = '".$ref."'";
        return $this->execOneResultQuery($sql)->value == '1';
    }
    
    public function getOptionValue($ref) {
        $sql = "SELECT value FROM cms_global_options WHERE ref = '".$ref."'";
        return $this->execOneResultQuery($sql)->value;
    }
    
    //////////////////////////
    // CLASS DE BASE DU CMS //
    //////////////////////////
    public function cmsLogin($login, $password) {
	//Test si les champs du login sont remplis
	if(TESTS::verifEmptyField($login) != true) {
		throw new Exception('Identifiant manquant !');
	}
	
	if(TESTS::verifEmptyField($password) != true) {
		throw new Exception('Mot de passe manquant !');
	}
	
	//Include des class utiles
	//require_once'users.class.php';
	
	//Instace de USERS
	//$user = new USERS($login, $password);
        $user = $this->initUsers($login, $password);
	
	//Login
	try {
		$user->logUserIn();
	}
	catch (Exception $e) {
		throw new Exception($e->getMessage());
	}
    }

    //Vérification de la validité de la session
    public function verifSession() {
	if(TESTS::verifSession() == true) {
		return true;
	}
	else {
		return false;
	}
    }

    //Préparation à la récupération du mot de passe
    public function recupPassword($user_login) {
	//Test si les champs du login sont remplis
	if(TESTS::verifEmptyField($user_login) != true) {
		throw new Exception('Identifiant manquant !');
	}
	
	//Include des class utiles
	//require_once'recuppwd.class.php';
	
	//Instance de RECUPPWD
	//$recup = new RECUPPWD();
        $recup = $this->initRwcupPwd();
	
	//Lancement de la procédure
	try {
            $recup->pwdReinitSetting($user_login); 
	}
	catch (Exception $e) {
		throw new Exception($e->getMessage());
	}
    }

    //Mise à jour du nouveau mot de passe
    public function updatePassword($id, $token, $new_password, $new_password_confirme) {
	//Test si les champs du login sont remplis
	if(TESTS::verifEmptyField($new_password) != true) {
		throw new Exception('Nouveau mot de passe manquant !');
	}
	
	if(TESTS::verifEmptyField($new_password_confirme) != true) {
		throw new Exception('Confirmez le mot de passe !');
	}
	
	//Include des class utiles
	//require_once'recuppwd.class.php';
	
	//Instance de RECUPPWD
	//$recup = new RECUPPWD();
        $recup = $this->initRwcupPwd();
	
	//Lancement de la procédure
	try {
		$recup->pwdReinitVerif($id, $token, $new_password);
	}
	catch (Exception $e) {
		throw new Exception($e->getMessage());
	}
    }
    
    //Chargement du menu principal
    public function getMainMenu() {
        $layout = $this->initLayout();
	$layout->getMainMenu();
    }

    //Chargement du menu principal
    public function getFirstModule() {
        $layout = $this->initLayout();
	return $result = $layout->getFirstModule();
    }
	
    public function logOut() {
	$_SESSION = array();
	session_destroy();
    }
	
    /* DESTRUCTEUR */
    public function __destruct() {
        
    }
}
?>