<?php
/*           
==================================================================
Fichier: pages.class.php                                
Description: Class de gestion des Pages     
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

class Pages extends DB {
    /* ATTRIBUTES */
    private $_idpage;
    private $_lang;
    
    /* CONSTANTE */
    const MODULE_NAME   = 'pages';
    const MODULE_PATH   = 'pages';
    const TBL_MAIN      = 'pages';
    const TBL_TRAD      = 'pages_trad';

    /* CONSTRUCTEUR */
    public function __construct() {
        parent::__construct();
    }

    /* GETTER */
    public function getIdPage()         { return $this->_idpage; }
    public function getLang()           { return $this->_lang; }
    
    /* SETTER */
    public function setIdPage($idpage)  { $this->_idpage = $idpage; }
    public function setLang($lang)      { $this->_lang = $lang; }
    
    /* INITTER */
    private function initLangues() {
        require_once 'langues.class.php';
        return new Langues();
    }

    /* METHODES */
    public function ajaxReload() {
        return $this->buildCMSListing($this->reqAllItemsForCMS());
    }
    
    public function buildCMSListing($data) {
        $result  = '<ul class="sortable">';
        foreach($data as $k => $obj) {
            $result .= '<li class="row" iditem="'.$obj->id_page.'" idparent="'.$obj->id_parent.'">';
                $result .= '<div class="col-lg-1">';
                if($this->getIdParent($obj->id_page)) {
                    $result .= '<div class="btn btn-default btn-xs"><span class="glyphicon glyphicon-chevron-right" module="'.self::MODULE_NAME.'" iditem="'.$obj->id_page.'"></span></div>';
                }
                $result .= '</div>';
                $result .= '<div class="col-lg-9">';
                $result .= '<strong>'.$obj->page_name.'</strong>';
                $result .= '</div>';
                //--- Toolbox ---------
                $result .= '<div class="col-lg-2 tool-box" id="tool-box-'.$obj->id_page.'">';
                    $result .= $this->getToolBox($obj);
                $result .= '</div>';
                //--- Del box ---------
                $result .= $this->getDelBox($obj);
            $result .= '</li>';
            //--- Pages enfants ---------
            $result .= $this->getSubItems($obj);
        }
        $result .= '</ul>';
        
        return $result;
    }
    
    private function getSubItems($data) {
        $items = $this->reqAllItemsForCMS($data->id_page);
        if(count($items) != 0) {
            $result .= '<div class="sub-container" id="sub-'.$data->id_page.'">';
                $result .= '<ul class="sortable">';
                foreach($items as $obj) {
                    $result .= '<li class="row sub" iditem="'.$obj->id_page.'" idparent="'.$obj->id_parent.'">';
                        $result .= '<div class="col-lg-1">';
                        if($this->getIdParent($obj->id_page)) {
                            $result .= '<div class="btn btn-default btn-xs"><span class="glyphicon glyphicon-chevron-right" module="'.self::MODULE_NAME.'" iditem="'.$obj->id_page.'"></span></div>';
                        }
                        $result .= '</div>';
                        $result .= '<div class="col-lg-9"><strong>'.$obj->page_name.'</strong></div>';
                        //--- Toolbox ---------
                        $result .= '<div class="col-lg-2 tool-box" id="tool-box-'.$obj->id_page.'">';
                            $result .= $this->getToolBox($obj);
                        $result .= '</div>';
                        //--- Del box ---------
                        $result .= $this->getDelBox($obj);
                    $result .= '</li>';
                    $result .= $this->getSubItems($obj);
                }
                $result .= '</ul>';
            $result .= '</div>';
        }
        return $result;
    }
    
    private function getToolBox($obj) {
        $result  = '<div class="btn btn-default btn-xs"><span class="glyphicon glyphicon-pencil" module="'.self::MODULE_NAME.'" iditem="'.$obj->id_page.'"></span></div>';
        if($obj->active == '1') {
            $result .= '<div class="btn btn-default btn-xs"><span class="glyphicon glyphicon-eye-open" module="'.self::MODULE_NAME.'" iditem="'.$obj->id_page.'"></span></div>';
        }
        else {
            $result .= '<div class="btn btn-default btn-xs"><span class="glyphicon glyphicon-eye-close" module="'.self::MODULE_NAME.'" iditem="'.$obj->id_page.'"></span></div>';
        }
        if($obj->is_menu == '1') {
            $result .= '<div class="btn btn-default btn-xs"><span class="glyphicon glyphicon-list" module="'.self::MODULE_NAME.'" iditem="'.$obj->id_page.'"></span></div>';
        }
        else {
            $result .= '<div class="btn btn-default btn-xs"><span class="glyphicon glyphicon-list inactive" module="'.self::MODULE_NAME.'" iditem="'.$obj->id_page.'"></span></div>';
        }
        $result .= '<div class="btn btn-default btn-xs"><span class="glyphicon glyphicon-trash" module="'.self::MODULE_NAME.'" iditem="'.$obj->id_page.'"></span></div>';
        
        return $result;
    }
    
    private function getDelBox($obj) {
        $result .= '<div class="col-lg-12 del-box" id="del-box-'.$obj->id_page.'">';
           $result .= 'Etes-vous sûre de vouloir supprimer cet élément&nbsp';
           $result .= '<div class="btn btn-default btn-xs"><span class="glyphicon glyphicon-ok" module="'.self::MODULE_NAME.'" iditem="'.$obj->id_page.'"></span></div>';
           $result .= '<div class="btn btn-default btn-xs"><span class="glyphicon glyphicon-remove" module="'.self::MODULE_NAME.'" iditem="'.$obj->id_page.'"></span></div>';
       $result .= '</div>';
        
        return $result;
    }
    
    public function buildPagesSelector($data, $current='0') {
        $result  = '<select class="form-control" name="page_parent" id="page_parent">';
        if($current == '0') {
            $result .= '<option value="0" selected>Aucune</option>';
        }
        else {
            $result .= '<option value="'.$current.'" selected>'.$this->getPageById($current)->page_name.'</option>';
        }
        foreach($data as $k => $obj) {
            $result .= '<option value="'.$obj->id_page.'">'.$obj->page_name.'</option>';
        }
        $result .= '</select>';
        return $result;
    }
    
    public function buildTemplateSelector($current='0') {
        $result  = '<select class="form-control" name="page_template" id="page_template">';
        if($current == '0') {
            $result .= '<option value="page.php" selected>Templates</option>';
        }
        else {
            $result .= '<option value="'.$current.'" selected>'.$current.'</option>';
        }
        foreach($this->listTemplateFiles() as $k => $file) {
            if(preg_match('/Template/', file_get_contents(dirname(__DIR__).'/'.self::MODULE_PATH.'/'.$file))) {
                $template_data = explode('|', file_get_contents(dirname(__DIR__).'/'.self::MODULE_PATH.'/'.$file));
                $split_name = explode(':', $template_data[1]);
                $split_file = explode(':', $template_data[2]);
                $result .= '<option value="'.$split_file['1'].'">'.$split_name['1'].' ('.$split_file['1'].')</option>';
            }
        }
        $result .= '</select>';
        return $result;
    }
    
    public function buildEditForm($id) {
        $item = $this->getPageById($id);
        
        $result  = '<div class="col-lg-12"><h3>Editer une page</h3></div>';
        $result .= '<form name="form_edit" id="form_edit" action="'.dirname(__DIR__).'/cms/modules/'.self::MODULE_PATH.'/module.ctrl.php" method="post">';
            $result .= '<div class="row">';
                $result .= '<div class="col-lg-12 form-group">';
                    $result .= '<label for="page_name">Nom de la page <small>(CMS uniquement)</small></label>';
                    $result .= '<input type="text" class="form-control" name="page_name" id="page_name" placeholder="ex. Accueil" value="'.$item->page_name.'">';
                $result .= '</div>';
            $result .= '</div>';
            $result .= '<div class="row">';
                $result .= '<div class="col-lg-4">';
                    $result .= '<h4>Intitulé du menu <small>(nom du menu)</small></h4>';
                    $result .= $this->getTextFieldsByLang('menu', $item->id, 'menu_name');
                $result .= '</div>';
                $result .= '<div class="col-lg-4">';
                    $result .= '<h4>Page URL <small>(URL rewrite)</small></h4>';
                    $result .= $this->getTextFieldsByLang('url', $item->id, 'page_url');
                $result .= '</div>';
                $result .= '<div class="col-lg-4">';
                    $result .= '<h4>Titre de la page <small>(Titre complémentaire)</small></h4>';
                    $result .= $this->getTextFieldsByLang('title', $item->id, 'page_title');
                $result .= '</div>';
            $result .= '</div>';
            $result .= '<div class="row">';
                $result .= '<div class="col-lg-6">';
                    $result .= '<h4>Template <small>(Mise en page particulière)</small></h4>';
                    $result .= $this->buildTemplateSelector($item->page_template);
                $result .= '</div>';
                $result .= '<div class="col-lg-6">';
                    $result .= '<h4>Page parent <small>(Crée un sous-menu)</small></h4>';
                    $result .= $this->buildPagesSelector($this->reqAllItemsForCMS(), $item->id_parent);
                $result .= '</div>';
            $result .= '</div>';
            $result .= '<div class="row">&nbsp;<input type="hidden" name="id_page" value="'.$item->id.'"></div>';
            $result .= '<div class="row">';
                $result .= '<div class="col-lg-12 text-right">';
                    $result .= '<input type="reset" name="reset-form" class="btn btn-danger" value="Annuler">&nbsp;';
                    $result .= '<input type="submit" name="edit-item" class="btn btn-success" value="Modifier">';
                $result .= '</div>';
            $result .= '</div>';
        $result .= '</form>';
        
        return $result;
    }
    
    private function getTextFieldsByLang($name, $id, $field) {
        $langue = $this->initLangues();
        $result = '';
        foreach($langue->reqAllLang() as $k => $lang) {
            $result .= '<div class="form-group">';
            $result .= '<label class="sr-only" for="'.$name.'_'.$lang->langue.'">'.$name.'_'.$lang->langue.'</label>';
            $result .= '<input type="text" class="form-control" name="'.$name.'_'.$lang->langue.'" id="'.$name.'_'.$lang->langue.'" value="'.$this->getValue($id, $lang->id, $field)->$field.'" placeholder="'.ucfirst($name).' '.$lang->langue.'">';
            $result .= '</div>';
        }
        return $result;
    }
    
    private function listTemplateFiles() {
        $result = array();
        $directory = dirname(__DIR__).'/'.self::MODULE_PATH.'/';
        
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
    
    public function addItem($post) {
        try {
            $sql = "INSERT INTO ".self::TBL_MAIN." (id_parent,page_name,page_template,is_menu,sort,active) 
                    VALUES ('".$post['page_parent']."',
                            '".addslashes($post['page_name'])."',
                            '".$post['page_template']."',
                            '".$post['page_menu']."',
                            '".$this->getNextSort($post['page_parent'])."',
                            '".$post['page_active']."')";
            $this->applyOneQuery($sql);
            $lastId = $this->execOneResultQuery("SELECT id FROM ".self::TBL_MAIN." ORDER BY id DESC LIMIT 1");
            
            $langue = $this->initLangues();
            foreach($langue->reqAllLang() as $k => $lang) {
                try {
                    $sql_trade = "INSERT INTO ".self::TBL_TRAD." (id_page,id_lang,menu_name,page_url,page_title) 
                                    VALUES ('".$lastId->id."',
                                            '".$lang->id."',
                                            '".addslashes($post['menu_'.$lang->langue])."',
                                            '".$post['url_'.$lang->langue]."',
                                            '".addslashes($post['title_'.$lang->langue])."')";
                    $this->applyOneQuery($sql_trade);
                }
                catch (PDOException $e) {
                    $this->manualInsertRollback(self::TBL_TRAD, 'id_parent', $lastId->id);
                    $this->manualInsertRollback(self::TBL_MAIN, 'id', $lastId->id);
                    throw new PDOException($e);
                }
            }
        }
        catch (PDOException $e) {
            $this->manualInsertRollback(self::TBL_MAIN, 'id', $lastId->id);
            throw new PDOException($e);
        } 
        
    }
    
    private function getNextSort($id) {
        try {
            $sql = "SELECT sort FROM ".self::TBL_MAIN." WHERE id_parent='".$id."' ORDER BY sort DESC LIMIT 1";
            return $this->execOneResultQuery($sql)->sort + 1;
        }
        catch (PDOException $e) {
            throw new PDOException($e);
        }    
    }
    
    public function ajaxShowHideItem($id, $value) {
        try {
            $sql = "UPDATE ".self::TBL_MAIN." SET active='".$value."' WHERE id='".$id."'";
            $this->applyOneQuery($sql);
        }
        catch (PDOException $e) {
            throw new PDOException($e);
        } 
    }
    
    public function ajaxIsMenuOrNot($id, $value) {
        try {
            $sql = "UPDATE ".self::TBL_MAIN." SET is_menu='".$value."' WHERE id='".$id."'";
            $this->applyOneQuery($sql);
        }
        catch (PDOException $e) {
            throw new PDOException($e);
        } 
    }
    
    public function ajaxEditItem($data) {
        $values = $this->refactorEditArray($data);
        try {
            $sql = "UPDATE ".self::TBL_MAIN."
                    SET id_parent='".$values['page_parent']."', 
                        page_name='".$values['page_name']."',
                        page_template='".$values['page_template']."' 
                    WHERE id='".$values['id_page']."'";
            $this->applyOneQuery($sql);

            try {
                $langues = $this->initLangues();
                foreach($langues->reqAllLang() as $k => $obj) {
                $sql = "UPDATE ".self::TBL_TRAD." 
                        SET menu_name='".$values['menu_'.$obj->langue]."', 
                            page_url='".$values['url_'.$obj->langue]."', 
                            page_title='".$values['title_'.$obj->langue]."' 
                        WHERE id_page='".$values['id_page']."' AND id_lang='".$obj->id."'";
                    $this->applyOneQuery($sql);
                }
            }
            catch (PDOException $e) {
                throw new PDOException($e);
            }
        }
        catch (PDOException $e) {
            throw new PDOException($e);
        }
    }
    
    public function ajaxReorderItem($ids) {
        foreach ($this->refactorSortableArray($ids) as $k => $sort) {
            try {
                $sql = "UPDATE ".self::TBL_MAIN." 
                        SET sort='".$k."' 
                        WHERE id='".$sort."'";
                    $this->applyOneQuery($sql);
            }
            catch (PDOException $e) {
                throw new PDOException($e);
            }
        }
    }
    
    private function refactorSortableArray($ids) {
        $ids = str_replace('undefined', '', $ids);
        $ids = substr($ids, 0, -1);
        
        return $result = explode('#', $ids);
    }
    
    private function refactorEditArray($data) {
        $result = array();
        foreach($data as $k => $item) {
            $result[$item['name']] = $item['value'];
        }
        return $result;
    }
    
    public function ajaxDelItem($id) {
        $this->getAllChildrens($id);
        $this->delItems($id);
    }
    
    private function getAllChildrens($id) {
        if($listIds = $this->getIdParent($id)) {
            foreach($listIds as $k => $item) {
                $this->delItems($item->id);
                $this->getAllChildrens($item->id);
            }
        }
        return $result;
    }
    
    private function delItems($id) {
        try {
            $sql = "DELETE FROM ".self::TBL_TRAD." WHERE id_page='".$id."'";
            $this->applyOneQuery($sql);

            try {
                $sql = "DELETE FROM ".self::TBL_MAIN." WHERE id='".$id."'";
                $this->applyOneQuery($sql);
            }
            catch (PDOException $e) {
                throw new PDOException($e);
            }
        }
        catch (PDOException $e) {
            throw new PDOException($e);
        }
    }
    
    private function getIdParent($id) {
        try {
            $sql = "SELECT id FROM ".self::TBL_MAIN." WHERE id_parent='".$id."'";
            return $this->execQuery($sql);
        }
        catch (PDOException $e) {
            throw new PDOException($e);
        } 
    }

    public function reqAllItemsForCMS($lvl='0') {
        try {
            $sql = "SELECT ".self::TBL_MAIN.".id AS id_page, id_parent, id_lang, page_name, page_template, menu_name, page_url, page_title, is_menu, active
                    FROM ".self::TBL_MAIN."
                    INNER JOIN ".self::TBL_TRAD." ON ".self::TBL_TRAD.".id_page=".self::TBL_MAIN.".id
                    WHERE ".self::TBL_MAIN.".id_parent='".$lvl."' AND ".self::TBL_TRAD.".id_lang='1' 
                    ORDER BY ".self::TBL_MAIN.".sort ASC";
            return $this->execQuery($sql);
        }
        catch (PDOException $e) {
            throw new PDOException($e);
        }
    }
    
    public function reqAllPages() {
        try {
            $sql = "SELECT ".self::TBL_MAIN.".id AS id_page, id_parent, id_lang, page_name, page_template, menu_name, page_url, page_title, is_menu, active
                    FROM ".self::TBL_MAIN."
                    INNER JOIN ".self::TBL_TRAD." ON ".self::TBL_TRAD.".id_page=".self::TBL_MAIN.".id
                    WHERE ".self::TBL_TRAD.".id_lang='1' 
                    ORDER BY ".self::TBL_MAIN.".sort ASC";
            return $this->execQuery($sql);
        }
        catch (PDOException $e) {
            throw new PDOException($e);
        }
    }
    
    private function getValue($id, $id_lang, $field) {
        try {
            $sql = "SELECT ".$field." FROM ".self::TBL_TRAD." WHERE id_page='".$id."' AND id_lang='".$id_lang."'";
            return $this->execOneResultQuery($sql);
        }
        catch (PDOException $e) {
            throw new PDOException($e);
        } 
    }
    
    private function getPageById($id) {
        try {
            $sql = "SELECT id,id_parent,page_name,page_template FROM ".self::TBL_MAIN." WHERE id='".$id."'";
            return $this->execOneResultQuery($sql);
        }
        catch (PDOException $e) {
            throw new PDOException($e);
        } 
    }
    
    public function getPageTemplate($idpage) {
        try {
            $sql = "SELECT page_template FROM ".self::TBL_MAIN." WHERE id='".$idpage."'";
            return $this->execOneResultQuery($sql);
        }
        catch (PDOException $e) {
            throw new PDOException($e);
        }
    }
}
?>