<?php
/*           
==================================================================
Fichier: db.class.php                                
Description: Class de gestion de la base de donées                      
------------------------------------------------------------------
Auteur: Jérôme Clerc                              
Editeurs: Jérôme Clerc
Société: Equinoxe MIS Development                 
Version: 1.2               
------------------------------------------------------------------
Changelog
------------------------------------------------------------------
11.12.2012 - 1.1
Ajout d'un attribut $_lastinsertid et de ses GETTER & SETTER.
La méthode "insertIntoTable" retourne le dernier ID inséré
 
01.11.2013 - 1.2
Passage à PDO

==================================================================
*/

class DB {
	/* ATTRIBUTS */
	private $_dbhost;
	private $_dbusername;
	private $_dbpassword;
	private $_dbname;        
    private $_dsn;
    private $_dbh;
	private $_reqstring;
	private $_lastinsertid;
	
	/* CONSTRUCT */
	public function __construct() {
        $this->setDbHost(DB_HOST);
        $this->setDbUserName(DB_USER_NAME);
        $this->setDbPassword(DB_PASSWORD);
        $this->setDbName(DB_NAME);
        $this->setDsn(DB_DSN);
        $this->dbConnect();
	}
	
	/* GETTER */
	public function getDbHost()                     { return $this->_dbhost; }
	public function getDbUserName()                 { return $this->_dbusername; }
	public function getDbPassword()                 { return $this->_dbpassword; }
	public function getDbName()                     { return $this->_dbname; }
    public function getDsn()                        { return $this->_dsn; }
    public function getDbh()                        { return $this->_dbh; }
	public function getReqString()                  { return $this->_reqstring; }
	public function getLastInsertID()               { return $this->_lastinsertid; }
	
	/* SETTER */
	public function setDbHost($dbhost)		        { $this->_dbhost = $dbhost; }
	public function setDbUserName($dbusername)	    { $this->_dbusername = $dbusername; }
	public function setDbPassword($dbpassword)	    { $this->_dbpassword = $dbpassword; }
	public function setDbName($dbname)		        { $this->_dbname = $dbname; }
    public function setDsn($dsn)                    { $this->_dsn = $dsn; }
    public function setDbh($dbh)                    { $this->_dbh = $dbh; }
	public function setReqString($reqstring)	    { $this->_reqstring = $reqstring; }
	public function setLastInsertID($lastinsertid)  { $this->_lastinsertid = $lastinsertid; }
	
    /* METHODES */
	public function dbConnect() {
        try {
            $dbh = new PDO($this->_dsn, $this->_dbusername, $this->_dbpassword, array(PDO::ATTR_PERSISTENT => true));
            $dbh->exec('SET NAMES utf8');
            $dbh->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
            $this->setDbh($dbh);
        }
        catch (PDOException $e) {
            echo 'Connexion échouée : '.$e->getMessage();
        }
	}
        
    public function execQuery($sql) {
        try {
            $query = $this->_dbh->query($sql);
            $result = array();
            while($row = $query->fetch(PDO::FETCH_OBJ)) {
                array_push($result, $row);
            }
            return $result;
        }
        catch (PDOException $e) {
            throw new PDOException($e);
        }
    }

    public function execOneResultQuery($sql) {
        try {
            $query = $this->_dbh->query($sql);
            return $query->fetch(PDO::FETCH_OBJ);
        }
        catch (PDOException $e) {
            throw new PDOException($e);
        }
    }

    public function applyOneQuery($sql) {
        try {
            $this->_dbh->beginTransaction();
            $sth = $this->_dbh->exec($sql);
            $this->_dbh->commit();
        }
        catch (PDOException $e) {
            $this->_dbh->rollback();
            throw new PDOException($e);
        }
    }
    
    public function applyQueryWithLastId($sql) {
        try {
            $this->_dbh->beginTransaction();
            $sth = $this->_dbh->exec($sql);
            $result = $this->_dbh->lastInsertId();
            $this->_dbh->commit();
            return $result;
        }
        catch (PDOException $e) {
            $this->_dbh->rollback();
            throw new PDOException($e);
        }
    }

    public function manualInsertRollback($table, $ref, $value) {
        $sql = "DELETE FROM ".$table." WHERE ".$ref."='".$value."'";
        try {
            $this->_dbh->beginTransaction();
            $sth = $this->_dbh->exec($sql);
            $this->_dbh->commit();
        }
        catch (PDOException $e) {
            throw new PDOException($e);
        }
    }

	public function __destruct() {
           
	}
}
?>