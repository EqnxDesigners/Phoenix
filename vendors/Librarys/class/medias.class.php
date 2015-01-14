<?php
/*           
==================================================================
Fichier: medias.class.php                                
Description: Class de gestion des Médias     
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

class Medias extends DB {
    /* ATTRIBUTES */
    //private $_idpage;
    
    /* CONSTANTE */
    const MODULE_NAME   = 'medias';
    const MODULE_PATH   = 'medias';
    const TBL_MAIN      = 'medias';

    /* CONSTRUCTEUR */
    public function __construct() {
        parent::__construct();
    }

    /* GETTER */
    //public function getIdPage()         { return $this->_idpage; }
    
    /* SETTER */
    //public function setIdPage($idpage)  { $this->_idpage = $idpage; }
    
    /* INITTER */

    /* METHODES */
    public function ajaxReload() {
        return $this->buildCMSListing($this->reqAllItemsForCMS());
    }
    
    public function buildCMSListing($data) {
        $result  = '<ul class="block-grid seven-up">';
        foreach($data as $k => $obj) {
            $result .= '<li>';
                $result .= '<div class="img-slot">';
                    if($obj->media_type == 'thumb') {
                        $result .= '<img src="../medias/'.$obj->media_file.'">';
                        $result .= '<div class="indicator" module="'.self::MODULE_NAME.'" iditem="'.$obj->id_parent.'"></div>';
                    }
                    if($obj->media_type == 'file')  {
                        $result .= '<img src="imgs/acrobat_reader.png">';
                        $result .= '<div class="indicator" module="'.self::MODULE_NAME.'" iditem="'.$obj->id.'"></div>';
                    }
                $result .= '</div>';
            $result .= '</li>';
        }
        $result .= '</ul>';
        
        return $result;
    }
    
    public function buildEditBox() {
        $result  = '<ul>';
        foreach($_SESSION['edit-stack'] as $item) {
            $obj = $this->getItemById($item);
            
            $result .= '<li class="row" iditem="'.$obj->id.'" idparent="'.$obj->id_parent.'">';
                $result .= '<div class="col-lg-8"><strong>'.$obj->media_file.'</strong></div>';
                //--- Toolbox ---------
                $result .= '<div class="col-lg-4 tool-box" id="tool-box-'.$obj->id.'">';
                    $result .= $this->getToolBox($obj);
                $result .= '</div>';
                //--- Del box ---------
                $result .= $this->getDelBox($obj);
            $result .= '</li>';
        }
        $result .= '</ul>';
        
        //--- Actions globales ---------
        $result .= '<div class="row">';
            $result .= '<h3>Actions globales</h3>';
            $result .= '<a href="#" class="btn btn-primary btn-sm">Supprimer tous les médias sélectionnés</a>';
            $result .= '<a href="#" class="btn btn-primary btn-sm clear-stack">Vider la liste de médias à éditer</a>';
        $result .= '</div>';
        
        return $result;
    }
    
    private function getToolBox($obj) {
        $result  = '';
        if($obj->media_type == 'file') {
            $result .= '<div class="btn btn-default btn-xs"><span class="glyphicon glyphicon-zoom-in" module="'.self::MODULE_NAME.'" nameitem="'.$obj->media_file.'"></span></div>';
        }
        $result .= '<div class="btn btn-default btn-xs"><span class="glyphicon glyphicon-pencil" module="'.self::MODULE_NAME.'" iditem="'.$obj->id.'"></span></div>';
        $result .= '<div class="btn btn-default btn-xs"><span class="glyphicon glyphicon-minus" module="'.self::MODULE_NAME.'" iditem="'.$obj->id.'"></span></div>';
        $result .= '<div class="btn btn-default btn-xs"><span class="glyphicon glyphicon-trash" module="'.self::MODULE_NAME.'" iditem="'.$obj->id.'"></span></div>';
        
        return $result;
    }
    
    private function getDelBox($obj) {
        $result .= '<div class="col-lg-12 del-box" id="del-box-'.$obj->id.'">';
           $result .= 'Etes-vous sûre de vouloir supprimer cet élément&nbsp';
           $result .= '<div class="btn btn-default btn-xs"><span class="glyphicon glyphicon-ok" module="'.self::MODULE_NAME.'" iditem="'.$obj->id.'"></span></div>';
           $result .= '<div class="btn btn-default btn-xs"><span class="glyphicon glyphicon-remove" module="'.self::MODULE_NAME.'" iditem="'.$obj->id.'"></span></div>';
       $result .= '</div>';
        
        return $result;
    }
    
    public function buildMediasForArticle($trow, $tcol) {
        $result  = '<div class="row">';
            $result .= '<div class="col-lg-12 text-right" style="margin-bottom:12px;">';
                $result .= '<span class="glyphicon glyphicon-remove-circle"></span>';
            $result .= '</div>';
        $result .= '</div>';
        
        $result .= '<ul class="block-grid two-up">';
        foreach($this->reqAllItemsForArticle() as $k => $obj) {
            $result .= '<li style="text-align:center;">';
                $result .= '<img src="../medias/'.$obj->media_file.'" trow="'.$trow.'" tcol="'.$tcol.'" fname="'.$this->getFileName($obj->id_parent)->media_file.'">';
            $result .= '</li>';
        }
        $result .= '</ul>';
        
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
    
    public function addItem($file, $id='0', $type_media='full') {
        if(!$this->checkIfInDb($file)) {
            try {
                $sql = "INSERT INTO ".self::TBL_MAIN." (id_parent,media_type,media_file,media_alt,media_post_date) 
                        VALUES ('".$id."',
                                '".$type_media."',
                                '".$file."',
                                '".$file."',
                                '".date("y-m-d H:m:s")."')";
                $this->applyOneQuery($sql);
                $lastId = $this->execOneResultQuery("SELECT id FROM ".self::TBL_MAIN." ORDER BY id DESC LIMIT 1");
                return $lastId->id;
            }
            catch (PDOException $e) {
                $this->manualInsertRollback(self::TBL_MAIN, 'id', $lastId->id);
                throw new PDOException($e);
            } 
        }
        else { 
            throw new PDOException('Ce fichier est déjà en base de données');
        }
    }
    
    private function checkIfInDb($file) {
        try {
            $sql = "SELECT id FROM ".self::TBL_MAIN." WHERE media_file='".$file."' LIMIT 1";
            return $this->execOneResultQuery($sql);
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
    
    private function getFileName($id_parent) {
        try {
            $sql = "SELECT media_file FROM ".self::TBL_MAIN." WHERE id='".$id_parent."'";
            return $this->execOneResultQuery($sql);
        }
        catch (PDOException $e) {
            throw new PDOException($e);
        }
    }

    public function reqAllItemsForCMS() {
        try {
            $sql = "SELECT * FROM ".self::TBL_MAIN." WHERE media_type='thumb' OR media_type='file' ORDER BY media_post_date ASC";
            return $this->execQuery($sql);
        }
        catch (PDOException $e) {
            throw new PDOException($e);
        }
    }
    
    public function reqAllItemsForArticle() {
        try {
            $sql = "SELECT * FROM ".self::TBL_MAIN." WHERE media_type='thumb'  ORDER BY media_post_date ASC";
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
            $sql = "SELECT * FROM ".self::TBL_MAIN." WHERE id='".$id."'";
            return $this->execOneResultQuery($sql);
        }
        catch (PDOException $e) {
            throw new PDOException($e);
        } 
    }
    
    public function getNewSize($dim, $ratio) {
        return ceil(($dim * $ratio) / 100);
    }
}
?>