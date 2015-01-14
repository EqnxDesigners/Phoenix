<?php
/*           
==================================================================
Fichier: db.class.php                                
Description: Class de gestion de la base de donées                      
------------------------------------------------------------------
Auteur: Jérôme Clerc                              
Editeurs: Jérôme Clerc
Société: e-novinfo Sàrl                 
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
	public function setDbHost($dbhost)		{ $this->_dbhost = $dbhost; }
	public function setDbUserName($dbusername)	{ $this->_dbusername = $dbusername; }
	public function setDbPassword($dbpassword)	{ $this->_dbpassword = $dbpassword; }
	public function setDbName($dbname)		{ $this->_dbname = $dbname; }
        public function setDsn($dsn)                    { $this->_dsn = $dsn; }
        public function setDbh($dbh)                    { $this->_dbh = $dbh; }
	public function setReqString($reqstring)	{ $this->_reqstring = $reqstring; }
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
        
	//Ex�cution d'une requ�te externe
	public function executeExternalQuery($query) {
		//G�n�ration de la requ�te et encapsulation
		$this->setReqString($query);
		
		//Cr�ation d'un array contenant le r�sultat de la requ�te
		return $this->putInArray();
	}
	
	//Insert le r�sultat d'une requ�te dans un array
	public function putInArray() {
		//Ex�cution de la requ�te
		$req = mysql_query($this->getReqString())
				OR die('<p>***** Erreur : '.mysql_error().' *****</p>');
				
		$this->setLastInsertID(mysql_insert_id());
		
		if(mysql_num_rows($req)) {
			//$data = mysql_fetch_array($req, MYSQL_ASSOC);
			$data = mysql_fetch_array($req);
		
			//Compilation des r�sultats dans un array
			$result = array();
			do {
				$result[] = $data;
			}while($data = mysql_fetch_array($req));
	
			return $result;
		}
		else {
			return false;
		}
	}
	
	//Ex�cute une requ�te SQL
	public function executeReqSql() {
		$req = mysql_query($this->getReqString())
				OR die('<p>***** Erreur : '.mysql_error().' *****</p>');
		
		$this->setLastInsertID(mysql_insert_id());
	}
	
	//Return true si la rqu�te abouti
	public function checkIfResult() {
		$req = mysql_query($this->getReqString())
				OR die('<p>***** Erreur : '.mysql_error().' *****</p>');
		
		if(mysql_num_rows($req)) {
			return true;
		}
		else {
			return false;
		}
	}
	
	//R�cup�re l'entier d'une table
	public function getAllRows($table, $sort_field='id', $sort='ASC') {
		//G�n�ration de la requ�te et encapsulation
		$this->setReqString("SELECT * FROM ".$table." ORDER BY ".$sort_field." ".$sort."");
		
		//Cr�ation d'un array contenant le r�sultat de la requ�te
		return $this->putInArray();
	}
	
	//R�cup�rer une valeur de champs unique en fonction d'un crit�re
	function getDistinctWhereEqual($table, $ref_field, $target_field, $value) {
		//G�n�ration de la requ�te et encapsulation
		$this->setReqString("SELECT DISTINCT ".$ref_field." FROM ".$table." WHERE ".$target_field." = '".$value."'");
		
		//Cr�ation d'un array contenant le r�sultat de la requ�te
		return $this->putInArray();
	}
	
	//R�cup�rer une valeur de champs unique en fonction de plusieurs crit�res
	function getDistinctWhereMultiAnd($table, $ref_field, $array_fields_values) {
		/**************************************************************/
		/* PARAMETRES                                                 */
		/* $array_fields_values = [0] array[0] => field, [1] => value */
		/*                        [1] array[0] => field, [1] => value */
		/*						  [2] array[0] => field, [1] => value */
		/*						  etc...                              */
		/**************************************************************/
		
		$Query_str = "SELECT DISTINCT ".$ref_field." FROM ".$table." WHERE ";
		
		//Adjonction des conditions
		for($i=0;$i<count($array_fields_values);$i++) {
			$Query_str .= $array_fields_values[$i]['0']." = '".$array_fields_values[$i]['1']."'";
			if($i<(count($array_fields_values)-1)) { $Query_str .= " AND "; }
		}
		
		//G�n�ration de la requ�te et encapsulation
		$this->setReqString($Query_str);
		
		//Cr�ation d'un array contenant le r�sultat de la requ�te
		return $this->putInArray();
	}
	
	
	//R�cup�rer l'entier une table selon un crit�re d'�galit�
	public function getWhereEqual($table, $target_field, $value, $sort_field = 'id', $sort = 'ASC') {
		//G�n�ration de la requ�te et encapsulation
		$this->setReqString("SELECT * FROM ".$table." WHERE ".$target_field." = '".$value."' ORDER BY ".$sort_field." ".$sort."");
		
		//Cr�ation d'un array contenant le r�sultat de la requ�te
		return $this->putInArray();
	}
	
	//R�cup�re l'entier d'une table o� un filtre commence par une string donn�e
	public function getWhereBeginWith($table, $target_field, $value, $sort_field = 'id', $sort = 'ASC') {
		//G�n�ration de la requ�te et encapsulation
		$this->setReqString("SELECT * FROM ".$table." WHERE ".$target_field." LIKE '".$value."%' ORDER BY ".$sort_field." ".$sort."");
		
		//Cr�ation d'un array contenant le r�sultat de la requ�te
		return $this->putInArray();
	}
	
	//R�cup�re l'entier d'une table o� un filtre fini par une string donn�e
	public function getWhereEndWith($table, $target_field, $value, $sort_field = 'id', $sort = 'ASC') {
		//G�n�ration de la requ�te et encapsulation
		$this->setReqString("SELECT * FROM ".$table." WHERE ".$target_field." LIKE '%".$value."' ORDER BY ".$sort_field." ".$sort."");
		
		//Cr�ation d'un array contenant le r�sultat de la requ�te
		return $this->putInArray();
	}
	
	//R�cup�re l'entier d'une table sauf les lignes correspondantes � un crit�re donn�
	public function getWhereExclude($table, $target_field, $value, $sort_field = 'id', $sort = 'ASC') {
		//G�n�ration de la requ�te et encapsulation
		$this->setReqString("SELECT * FROM ".$table." WHERE ".$target_field." <> '".$value."' ORDER BY ".$sort_field." ".$sort."");
		
		//Cr�ation d'un array contenant le r�sultat de la requ�te
		return $this->putInArray();
	}
	
	//R�cup�re l'entier d'une table selons plusieurs crit�res d'�galit�s donn�
	public function getWhereMultiAnd($table, $array_fields_values, $sort_field = 'id', $sort = 'ASC') {
		/**************************************************************/
		/* PARAMETRES                                                 */
		/* $array_fields_values = [0] array[0] => field, [1] => value */
		/*                        [1] array[0] => field, [1] => value */
		/*						  [2] array[0] => field, [1] => value */
		/*						  etc...                              */
		/**************************************************************/
		
		//G�n�ration de la requ�te et encapsulation
		$Query_str = "SELECT * FROM ".$table." WHERE ";
		
		//Adjonction des conditions
		for($i=0;$i<count($array_fields_values);$i++) {
			$Query_str .= $array_fields_values[$i]['0']." = '".$array_fields_values[$i]['1']."'";
			if($i<(count($array_fields_values)-1)) { $Query_str .= " AND "; }
		}
		
		//Adjonction de la fin de la requ�te
		$Query_str .= " ORDER BY ".$sort_field." ".$sort."";
		
		//Encapsulation de la String termin�e
		$this->setReqString($Query_str);
		
		//Cr�ation d'un array contenant le r�sultat de la requ�te
		return $this->putInArray();
	}

	//R�cup�re l'entier de plusieurs tables par INNER JOIN avec close WHERE et ORDER BY optionnelle
	public function getInnerWhereOrder() {
		/********************************************************************************/
		/* getInnerWhereOrder('table1', 'ref1', 'table2', 'ref2',...);					*/
		/*																				*/
		/* Ajouter une close WHERE														*/
		/* getInnerWhereOrder(..., 'where', 'tablewhere', 'fieldwhere', 'value');		*/
		/*																				*/
		/* Ajouter une close ORDER BY													*/
		/* getInnerWhereOrder(..., 'orderby', 'tableorder', 'fieldorder', 'sortorder');	*/
		/********************************************************************************/
		
		
		//G�n�ration de la requ�te et encapsulation
		$_ = func_get_args();
		
		//Recherche de la close WHERE
		if(in_array('where', $_)) {
			$where_key = array_search('where', $_);
		}
		
		//Recherche de la close ORDER BY
		if(in_array('orderby', $_)) {
			$orderby_key = array_search('orderby', $_);
		}
		
		//D�but de la requ�te
		$Query_str = "SELECT * FROM ".$_['0']." ";
		
		//Si la close WHERE et ORDER BY sont d�finient
		if(isset($where_key) && isset($orderby_key)) {
			$i = 2;
			do {
				$Query_str .= "INNER JOIN ".$_[$i]." ON ".$_[$i-2].".".$_[$i-1]." = ".$_[$i].".".$_[$i+1]." ";
				$i = $i + 2;
			} while($i<$where_key);
		}
		
		//Si la close WHERE est d�finie
		if(isset($where_key) && !isset($orderby_key)) {
			$i = 2;
			do {
				$Query_str .= "INNER JOIN ".$_[$i]." ON ".$_[$i-2].".".$_[$i-1]." = ".$_[$i].".".$_[$i+1]." ";
				$i = $i + 2;
			} while($i<$where_key);
		}
		
		//Si la close ORDER BY est d�finie
		if(!isset($where_key) && isset($orderby_key)) {
			$i = 2;
			do {
				$Query_str .= "INNER JOIN ".$_[$i]." ON ".$_[$i-2].".".$_[$i-1]." = ".$_[$i].".".$_[$i+1]." ";
				$i = $i + 2;
			} while($i<$orderby_key);
		}
		
		//Si aucunes closes n'est d�finie
		if(!isset($where_key) && !isset($orderby_key)) {
			$i = 2;
			do {
				$Query_str .= "INNER JOIN ".$_[$i]." ON ".$_[$i-2].".".$_[$i-1]." = ".$_[$i].".".$_[$i+1]." ";
				$i = $i + 2;
			} while($i<func_num_args());
		}
		
		//Ajout de la close WHERE
		if(isset($where_key)) {
			$Query_str .= "WHERE ".$_[$where_key+1].".".$_[$where_key+2]." = '".$_[$where_key+3]."' ";
		}
		
		//Ajout de la close ORDER BY
		if(isset($orderby_key)) {
			$Query_str .= "ORDER BY ".$_[$orderby_key+1].".".$_[$orderby_key+2]." ".$_[$orderby_key+3]."";
		}
		
		//Encapsulation de la String termin�e
		$this->setReqString($Query_str);
		
		//Cr�ation d'un array contenant le r�sultat de la requ�te
		return $this->putInArray();
	}
	
	//Insert des valeurs dans une table
	public function insertIntoTable($table, $array_values) {
		//G�n�ration de la requ�te et encapsulation
		$Query_str = "INSERT INTO ".$table." VALUES (''";
		
		//Adjonction des valeurs
		for($i=0;$i<count($array_values);$i++) {
			$Query_str .= ",'".$array_values[$i]."'";
		}
		
		//Cl�ture de la requ�te
		$Query_str .= ")";
		
		//Encapsulation de la String termin�e
		$this->setReqString($Query_str);
		
		//Ex�cution de la requ�te
		//return $insert_id = $this->executeReqSql();
                $this->executeReqSql();
		
		//Retour du dernier ID
		return $result = $this->getLastInsertID();
	}
	
	//Modifier uns ou plusieures lignes d'une table
	public function updateElements($table, $id_field, $id, $value_to_edit) {
		for($i=0;$i<count($value_to_edit);$i++) {
			//G�n�ration de la requ�te et encapsulation
			$this->setReqString("UPDATE ".$table." SET ".$value_to_edit[$i]['0']."='".$value_to_edit[$i]['1']."' WHERE ".$id_field."='".$id."'");
			
			//Ex�cution de la requ�te
			$this->executeReqSql();
		}
	}
	
	//Supprimer la/les lignes qui correspondent � un crit�re donn�
	public function delRowWhereEqual($table, $field, $value) {
		//G�n�ration de la requ�te et encapsulation
		$this->setReqString("DELETE FROM ".$table." WHERE ".$field." = '".$value."'");
		
		//Ex�cution de la requ�te
		$this->executeReqSql();
	}
	
	//Supprime une table
	public function delTable($table) {
		//G�n�ration de la requ�te et encapsulation
		$this->setReqString("DROP TABLE ".$table."");
		
		//Ex�cution de la requ�te
		$this->executeReqSql();
	}
        
        static function disconnectDb() {
            /*if (@mysql_ping()) {
            //Connexion active
                mysql_close();
            }*/
            $this->setDbh(NULL);
        }

	public function __destruct() {
           
	}
}
?>