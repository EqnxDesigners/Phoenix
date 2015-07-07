<?php
/*           
==================================================================
Fichier: layout.class.php                                
Description: Class de gestion des layouts     
------------------------------------------------------------------
Auteur: Jérôme Clerc                              
Editeurs: Jérôme Clerc
Société: Equinoxe MIS Development                 
Version: 1.0               
------------------------------------------------------------------
Changelog
------------------------------------------------------------------
??.??.???? - 1.1
xxxxxxx

==================================================================
*/

class Layouts extends DB {
    /* TRAITS */
    use Trait_renderhtml, Trait_traduction;
    
    /* ATTRIBUTES */
    private $_module;

    /* CONSTRUCTEUR */
    public function __construct() {
        parent::__construct();
        if(isset($_SESSION['current']['lang'])) {
            $this->setLang($_SESSION['current']['lang']);
            $this->setIdLang($this->reqIdLang()->id);
        }
    }

    /* GETTER */
    public function getModule()                     { return $this->$_module; }
    public function getLang()                       { return $this->_lang; }
    public function getIdLang()                     { return $this->_idlang; }
    
    /* SETTER */
    public function setModule($module)              { $this->_module = $module; }
    public function setLang($lang)		            { $this->_lang = $lang; }
    public function setIdLang($idlang)		        { $this->_idlang = $idlang; }
    
    /* INITTER */
    
    /* METHODES */
    private function reqIdLang() {
        try {
            $sql = "SELECT id FROM langues WHERE langue_abrev='".$this->_lang."'";
            return $this->execOneResultQuery($sql);
        }
        catch (PDOException $e) {
            throw new PDOException($e);
        }
    }

    public function buildTopBar() {
        $result =   '<section class="row" id="top-bar">
                        <div class="small-2 columns text-center">
                            &nbsp;
                        </div>
                        <div class="small-6 columns">
                            <p>Bienvenue, <strong>'.$_SESSION['user']['user_name'].'</strong></p>
                        </div>
                        <div class="small-4 columns text-right">
                            <i class="fa fa-power-off" role="logout"></i>
                        </div>
                    </section>';
        $this->renderHtml($result);
    }
    
    public function buildMyEqnxTopBar() {
        $result =   '<header class="wide-row row" id="top-bar">
                        <div class="small-12 columns">
                            <img src="images/logo_equinoxe_white.png" alt="Equinoxe MIS Development">
                            <p class="myeqnx">MyEqnx</p>
                            <p>Bienvenue, <strong>'.$_SESSION['client']['titre'].' '.strtoupper($_SESSION['client']['nom']).' '.$_SESSION['client']['prenom'].'</strong></p>
                            <p><i class="fa fa-power-off" role="logout"></i></p>
                        </div>
                    </header>';
        $this->renderHtml($result);
    }
    
    public function buildMainMenu($module) {
        $this->defineDefaultModule($module);
        $result = '<section class="row content"><nav class="small-2 columns" id="main-menu"><img src="images/logo_equinoxe_white.png" alt="Equinoxe MIS Development"><ul>';
        foreach($this->getListModules() as $k => $value) {
            $result .= $this->buildMainMenuLine($value);            
        }
        if(isset($_SESSION['user']['level']) && $_SESSION['user']['level'] === '0') {
            $result .= '</ul><img src="images/loading-cat.gif" class="cat" alt="Dancing cat"></nav>';
        }
        else {
            $result .= '</ul></nav>';
        }
        $this->renderHtml($result);
    }
    
    private function defineDefaultModule($module) {
        if(strlen($module) === 0) {
            //Au besoin, définir cette information dans une variable ou une constante.
            $this->setModule('news');
        }
        else {
            $this->setModule($module);
        }
    }
    
    private function buildMainMenuLine($mnu) {
        $result = '<li';
        if($this->_module === $mnu) {
            $result .= ' class="active"';
        }
            $result .= '><a href="?module='.$mnu.'" target="_self">'.$mnu.'</a></li>';
        return $result;
    }
    
    private function getListModules() {
        $result = array();
        $directory = dirname(__DIR__).'/admin/modules/';
        
        if (is_dir($directory)) {
            if ($dh = opendir($directory)) {
                while (($file = readdir($dh)) !== false) {
                    if($file!='..' && $file!='.' && $file!='.DS_Store') {
                        array_push($result, $file);
                    }
                }
                closedir($dh);
            }
        }
        return $result;
    }
    
    public function buildFormSelect($name, $value, $display, $data, $current = NULL) {
        $result = '<select name="'.$name.'" id="'.$name.'">';
        if($current !== NULL) {
            $result .= '<option value="" selected></option>';
        }
        else {
            $result .= '<option value="'.$data[0]->id.'" selected>'.$data[0]->langue.'</option>';
        }
        foreach($data as $k => $obj) {
            $result .= '<option value="'.$obj->$value.'">'.$obj->$display.'</option>';
        }
        $result .= '</select>';
        return $result;
    }
    
    public function checkBoolOpt($code) {
        try {
            $sql = "SELECT value FROM options WHERE code='".$code."'";
            return ($this->execOneResultQuery($sql)->value === '1' ? true : false);
        }
        catch (PDOException $e) {
            throw new PDOException($e);
        }
    }

    public function getSimpleTrad($code) {
        return $this->getTrad($code, $this->_idlang);
    }
    
    public function __destruct() {
           
	}
}
?>