<?php
/*           
==================================================================
Fichier: config.class.php                                
Description: Class du module Config     
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

class Config extends DB {
    /* TRAITS */
    use Trait_renderhtml;
    
    /* ATTRIBUTES */
//    private $_status;

    /* CONSTRUCTEUR */
    public function __construct() {
        parent::__construct();
    }

    /* GETTER */
//    public function getStatus()             { return $this->$_status; }
    
    /* SETTER */
//    public function setStatus($status)      { $this->_status = $status; }
    
    /* INITTER */
    
    /* METHODES */
    public function reloadListing() {
        return $this->getLstOptions();
    }
    
    public function getLstOptions() {
        try {
            $allOptions = $this->getOptions();
            $result = '<ul>';
                $result .= $this->getListingHeader();
            if($allOptions) {
                foreach($allOptions as $K => $opt) {
                    $result .= '<li class="row">';
                        $result .= '<div class="small-5 columns">'.$opt->label.'</div>';
                        $result .= '<div class="small-3 columns code" ref="'.$opt->id.'">'.$opt->code.'</div>';
                        $result .= '<div class="small-3 columns">'.$this->buildValueField($opt).'</div>';
                        $result .= '<div class="small-1 columns toolbox text-right">'.$this->buildToolBox($opt).'</div>';
                    $result .= '</li>';
                }
            }
            else {
                $result .= '<li class="row"><div class="small-12 columns">Aucune options paramétrée pour le moment...</div></li>';
            }
            $result .= '</ul>';
            $this->renderHtml($result);
        }
        catch (PDOException $e) {
            throw new PDOException($e);
        }
    }
    
    private function getListingHeader() {
        $result = '<li class="row lst-header">';
            $result .= '<div class="small-6 columns">Options</div>';
            $result .= '<div class="small-3 columns">Code</div>';
            $result .= '<div class="small-3 columns">Valeur</div>';
        $result .= '</li>';
        return $result;
    }
    
    private function buildValueField($opt) {
        if($opt->type === 'bool') {
            $result = '<div class="switch tiny round">';
                $result .= '<input id="opt-'.$opt->id.'" ref="'.$opt->id.'" type="checkbox" ';
                if($opt->value === '1') {
                    $result .= 'checked>';
                }
                else {
                    $result .= '>';
                }
                $result .= '<label for="opt-'.$opt->id.'"></label>';
            $result .= '</div>';
        }
        if($opt->type === 'str') {
            $result = '<input type="text" name="opt-value" id="opt-'.$opt->id.'" ref="'.$opt->id.'" value="'.$opt->value.'" target="value">';
        }
        
        return $result;
    }
    
    private function buildToolBox($item) {
        $result = '';
        //$result .= '&nbsp;<i class="fa fa-pencil  btn" role="edit" item="'.$item->id.'"></i>';
        $result .= '&nbsp;<i class="fa fa-trash-o btn" role="trash" item="'.$item->id.'"></i>';
        return $result;
    }
    
    private function getOptions() {
        try {
            $sql = "SELECT *
                    FROM options";
            return $this->execQuery($sql);
        }
        catch (PDOException $e) {
            throw new PDOException($e);
        }
    }
    
    private function getOptionsById($id) {
        try {
            $sql = "SELECT *
                    FROM options 
                    WHERE id='".$id."'";
            return $this->execOneResultQuery($sql);
        }
        catch (PDOException $e) {
            throw new PDOException($e);
        }
    }
    
    public function updateOption($field, $id, $value) {
        if($field === 'code') {
            $value = $this->formatCodeValue($value);
        }
        try {
            $sql = "UPDATE options 
                    SET ".$field."='".$value."' 
                    WHERE id='".$id."'";
            $this->applyOneQuery($sql);
            return $value;
        }
        catch (PDOException $e) {
            throw new PDOException($e);
        }
    }
    
    private function formatCodeValue($value) {
        $result = str_replace(' ', '_', $value);
        return strtoupper($result);
    }
    
    public function addVariable($data) {
        try {
            $sql = "INSERT INTO options (label,type,value,code) 
                    VALUES ('".addslashes($data['label'])."',
                            '".$data['type_var']."',
                            '".addslashes($data['value_var'])."',
                            '".$this->formatCodeValue($data['code_var'])."')";
            $this->applyOneQuery($sql);
        }
        catch (PDOException $e) {
            throw new PDOException($e);
        }
    }
    
    public function deleteItem($id) {
        try {
            $sql = "DELETE 
                    FROM options
                    WHERE id='".$id."'";
            $this->applyOneQuery($sql);
        }
        catch (PDOException $e) {
            throw new PDOException($e);
        }
    }
    
    public function __destruct() {
           
	}
}
?>