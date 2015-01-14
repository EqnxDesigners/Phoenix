<?php
/*           
==================================================================
Fichier: categories.class.php                                
Description: Class de gestion des Catégories     
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

class Categories extends DB {
    /* ATTRIBUTES */
    //private $_idpage;
    
    /* CONSTANTE */
    const MODULE_NAME   = 'categories';
    const MODULE_PATH   = 'categories';
    const TBL_MAIN      = 'categories';
    const TBL_TRAD      = 'categories_trad';

    /* CONSTRUCTEUR */
    public function __construct() {
        parent::__construct();
    }

    /* GETTER */
    //public function getIdPage()         { return $this->_idpage; }
    
    /* SETTER */
    //public function setIdPage($idpage)  { $this->_idpage = $idpage; }
    
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
        $result  = '<ul>';
        foreach($data as $k => $obj) {
            $result .= '<li class="row" iditem="'.$obj->id_cat.'" idparent="'.$obj->id_parent.'">';
                $result .= '<div class="col-lg-1">';
                if($this->getIdParent($obj->id_cat)) {
                    $result .= '<div class="btn btn-default btn-xs"><span class="glyphicon glyphicon-chevron-right" module="'.self::MODULE_NAME.'" iditem="'.$obj->id_cat.'"></span></div>';
                }
                $result .= '</div>';
                $result .= '<div class="col-lg-4"><strong>'.$obj->cat_name.'</strong></div>';
                $result .= '<div class="col-lg-5"><small>'.$obj->cat_description.'</small></div>';
                //--- Toolbox ---------
                $result .= '<div class="col-lg-2 tool-box" id="tool-box-'.$obj->id_cat.'">';
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
        $items = $this->reqAllItemsForCMS($data->id_cat);
        if(count($items) != 0) {
            $result .= '<div class="sub-container" id="sub-'.$data->id_cat.'">';
                $result .= '<ul>';
                foreach($items as $obj) {
                    $result .= '<li class="row sub" iditem="'.$obj->id_cat.'" idparent="'.$obj->id_parent.'">';
                        $result .= '<div class="col-lg-1">';
                        if($this->getIdParent($obj->id_cat)) {
                            $result .= '<div class="btn btn-default btn-xs"><span class="glyphicon glyphicon-chevron-right" module="'.self::MODULE_NAME.'" iditem="'.$obj->id_cat.'"></span></div>';
                        }
                        $result .= '</div>';
                        $result .= '<div class="col-lg-4"><strong>'.$obj->cat_name.'</strong></div>';
                        $result .= '<div class="col-lg-5"><small>'.$obj->cat_description.'</small></div>';
                        //--- Toolbox ---------
                        $result .= '<div class="col-lg-2 tool-box" id="tool-box-'.$obj->id_cat.'">';
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
        $result  = '<div class="btn btn-default btn-xs"><span class="glyphicon glyphicon-pencil" module="'.self::MODULE_NAME.'" iditem="'.$obj->id_cat.'"></span></div>';
        $result .= '<div class="btn btn-default btn-xs"><span class="glyphicon glyphicon-trash" module="'.self::MODULE_NAME.'" iditem="'.$obj->id_cat.'"></span></div>';
        
        return $result;
    }
    
    private function getDelBox($obj) {
        $result .= '<div class="col-lg-12 del-box" id="del-box-'.$obj->id_cat.'">';
           $result .= 'Etes-vous sûre de vouloir supprimer cet élément&nbsp';
           $result .= '<div class="btn btn-default btn-xs"><span class="glyphicon glyphicon-ok" module="'.self::MODULE_NAME.'" iditem="'.$obj->id_cat.'"></span></div>';
           $result .= '<div class="btn btn-default btn-xs"><span class="glyphicon glyphicon-remove" module="'.self::MODULE_NAME.'" iditem="'.$obj->id_cat.'"></span></div>';
       $result .= '</div>';
        
        return $result;
    }
    
    public function buildCatSelector($data, $current='0') {
        $result  = '<select class="form-control" name="cat_parent" id="cat_parent">';
        if($current == '0') {
            $result .= '<option value="0" selected>Aucune</option>';
        }
        else {
            $result .= '<option value="'.$current.'" selected>'.$this->getItemById($current)->cat_name.'</option>';
        }
        foreach($data as $k => $obj) {
            $result .= '<option value="'.$obj->id_cat.'">'.$obj->cat_name.'</option>';
        }
        $result .= '</select>';
        return $result;
    }
    
    public function buildEditForm($id) {
        $item = $this->getItemById($id);
        
        $result  = '<div class="col-lg-12"><h3>Editer une catégorie</h3></div>';
        $result .= '<form name="form_edit" id="form_edit" action="'.dirname(__DIR__).'/cms/modules/'.self::MODULE_PATH.'/module.ctrl.php" method="post">';
            $result .= '<div class="row">';
                $result .= '<div class="col-lg-4">';
                    $result .= '<h4>Intitulé de la categorie</h4>';
                    $result .= $this->getTextFieldsByLang('categorie', $item->id_cat, 'cat_name');
                    $result .= '<div class="form-group">';
                        $result .= '<label for="cat_description">Description <small>(CMS uniquement)</small></label>';
                        $result .= '<input type="text" class="form-control" name="cat_description" id="cat_description" value="'.$item->cat_description.'" placeholder="ex. Articles de news">';
                    $result .= '</div>';
                $result .= '</div>';
                
                $result .= '<div class="col-lg-4">';
                    $result .= '<div class="row">';
                        $result .= '<div class="col-lg-12">';
                            $result .= '<h4>Catégorie parente</h4>';
                            $result .= $this->buildCatSelector($this->reqAllItemsForCMS(), $item->id_parent);
                        $result .= '</div>';
                    $result .= '</div>';
                    $result .= '<div class="row"><input type="hidden" name="id_cat" value="'.$item->id_cat.'">&nbsp;</div>';
                    $result .= '<div class="row">';
                        $result .= '<div class="col-lg-12 text-right">';
                            $result .= '<input type="reset" name="reset-form" class="btn btn-danger" value="Annuler">&nbsp;';
                            $result .= '<input type="submit" name="edit-item" class="btn btn-success" value="Modifier">';
                        $result .= '</div>';
                    $result .= '</div>';
                $result .= '</div>';
                $result .= '<div class="col-lg-4">&nbsp;</div>';
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
    
    public function addItem($post) {
        try {
            $sql = "INSERT INTO ".self::TBL_MAIN." (id_parent,cat_description,active) 
                    VALUES ('".$post['cat_parent']."',
                            '".addslashes($post['cat_description'])."',
                            '1')";
            $this->applyOneQuery($sql);
            $lastId = $this->execOneResultQuery("SELECT id FROM ".self::TBL_MAIN." ORDER BY id DESC LIMIT 1");
            
            $langue = $this->initLangues();
            foreach($langue->reqAllLang() as $k => $lang) {
                try {
                    $sql_trade = "INSERT INTO ".self::TBL_TRAD." (id_cat,id_lang,cat_name) 
                                    VALUES ('".$lastId->id."',
                                            '".$lang->id."',
                                            '".addslashes($post['categorie_'.$lang->langue])."')";
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
    
    public function ajaxShowHideItem($id, $value) {
        try {
            $sql = "UPDATE ".self::TBL_MAIN." SET active='".$value."' WHERE id='".$id."'";
            $this->applyOneQuery($sql);
        }
        catch (PDOException $e) {
            throw new PDOException($e);
        } 
    }
    
    public function ajaxEditItem($data) {
        $values = $this->refactorEditArray($data);
        //var_dump($values);
        try {
            $sql = "UPDATE ".self::TBL_MAIN."
                    SET id_parent='".$values['cat_parent']."', 
                        cat_description='".addslashes($values['cat_description'])."' 
                    WHERE id='".$values['id_cat']."'";
            $this->applyOneQuery($sql);

            try {
                $langues = $this->initLangues();
                foreach($langues->reqAllLang() as $k => $obj) {
                $sql = "UPDATE ".self::TBL_TRAD." 
                        SET cat_name='".addslashes($values['categorie_'.$obj->langue])."' 
                        WHERE id_cat='".$values['id_cat']."' AND id_lang='".$obj->id."'";
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
            $sql = "DELETE FROM ".self::TBL_TRAD." WHERE id_cat='".$id."'";
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
            $sql = "SELECT ".self::TBL_MAIN.".id AS id_cat, id_parent, id_lang, cat_name, cat_description, active
                    FROM ".self::TBL_MAIN."
                    INNER JOIN ".self::TBL_TRAD." ON ".self::TBL_TRAD.".id_cat=".self::TBL_MAIN.".id
                    WHERE ".self::TBL_MAIN.".id_parent='".$lvl."' AND ".self::TBL_TRAD.".id_lang='1' 
                    ORDER BY ".self::TBL_TRAD.".cat_name ASC";
            return $this->execQuery($sql);
        }
        catch (PDOException $e) {
            throw new PDOException($e);
        }
    }
    
    public function reqAllCats() {
        try {
            $sql = "SELECT ".self::TBL_MAIN.".id AS id_cat, id_parent, id_lang, cat_name, cat_description, active
                    FROM ".self::TBL_MAIN."
                    INNER JOIN ".self::TBL_TRAD." ON ".self::TBL_TRAD.".id_cat=".self::TBL_MAIN.".id
                    WHERE ".self::TBL_TRAD.".id_lang='1' 
                    ORDER BY ".self::TBL_TRAD.".cat_name ASC";
            return $this->execQuery($sql);
        }
        catch (PDOException $e) {
            throw new PDOException($e);
        }
    }
    
    private function getValue($id, $id_lang, $field) {
        try {
            $sql = "SELECT ".$field." FROM ".self::TBL_TRAD." WHERE id_cat='".$id."' AND id_lang='".$id_lang."'";
            return $this->execOneResultQuery($sql);
        }
        catch (PDOException $e) {
            throw new PDOException($e);
        } 
    }
    
    private function getItemById($id) {
        try {
            $sql = "SELECT ".self::TBL_MAIN.".id AS id_cat, id_parent, cat_description, active, cat_name 
                    FROM ".self::TBL_MAIN." 
                    INNER JOIN ".self::TBL_TRAD." ON ".self::TBL_TRAD.".id_cat=".self::TBL_MAIN.".id
                    WHERE ".self::TBL_MAIN.".id='".$id."'";
            return $this->execOneResultQuery($sql);
        }
        catch (PDOException $e) {
            throw new PDOException($e);
        } 
    }
}
?>