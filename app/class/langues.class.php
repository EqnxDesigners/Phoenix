<?php
/*           
==================================================================
Fichier: langues.class.php                                
Description: Class de gestion des langues                      
------------------------------------------------------------------
Auteur: Jérôme Clerc                              
Editeurs: Jérôme Clerc
Société: Equinoxe MIS Development                 
Version: 1.0               
------------------------------------------------------------------
Changelog
------------------------------------------------------------------
00.00.0000 - 1.1
???

==================================================================
*/

class Langues extends DB {
	/* ATTRIBUTS */
//	private $_dbhost;
	
	/* CONSTRUCT */
	public function __construct() {
        parent::__construct();
	}
	
	/* GETTER */
//	public function getDbHost()                     { return $this->_dbhost; }
	
	/* SETTER */
//	public function setDbHost($dbhost)		        { $this->_dbhost = $dbhost; }
	
    /* METHODES */
    public function getTradIni($file) {
        return parse_ini_file('trad/'.$file, true);
    }
    
    public function setLangById($id) {
        try {
            $sql = "SELECT * FROM langues WHERE id='".$id."'";
            return $this->execOneResultQuery($sql);
        }
        catch (PDOException $e) {
            throw new PDOException($e);
        }
    }
    
    public function getLangs() {
        try {
            $sql = "SELECT * FROM langues ORDER BY id ASC";
            return $this->execQuery($sql);
        }
        catch (PDOException $e) {
            throw new PDOException($e);
        }
    }
    
    public function getLangByiD($id) {
        try {
            $sql = "SELECT * FROM langues WHERE id='".$id."'";
            return $this->execOneResultQuery($sql);
        }
        catch (PDOException $e) {
            throw new PDOException($e);
        }
    }

	public function __destruct() {
           
	}
}
?>