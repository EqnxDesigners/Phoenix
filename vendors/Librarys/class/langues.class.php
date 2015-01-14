<?php
/*           
==================================================================
Fichier: langues.class.php                                
Description: Class de gestion des langues                     
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

class Langues extends DB {
    /* ATTRIBUTES */
    //private $_title;
    
    /* CONSTRUCTEUR */
    public function __construct() {
        parent::__construct();
    }
    
    /* GETTER */
    //public function getTitle()              { return $this->_title; }
    
    /* SETTER */
    //public function setTitle($title)        { $this->_title = $title; }
    
    /* METHODES */
    public function reqAllLang() {
        try {
            $sql = "SELECT * FROM lay_langues";
            return $this->execQuery($sql);
        } catch (PDOException $ex) {
            throw new PDOException($e);
        }        
    }
    
    public function getCurrentAbrev($id) {
        try {
            $sql = "SELECT langue FROM lay_langues WHERE id='".$id."'";
            return $this->execOneResultQuery($sql);
        } catch (PDOException $ex) {
            throw new PDOException($e);
        }  
    }
    
    public function getLangIdByAbrev($abrev) {
        try {
            $sql = "SELECT id FROM lay_langues WHERE langue='".$abrev."'";
            return $this->execOneResultQuery($sql);
        } catch (PDOException $ex) {
            throw new PDOException($e);
        } 
    }
}
?>