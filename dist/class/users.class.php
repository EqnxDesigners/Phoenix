<?php
/*           
==================================================================
Fichier: users.class.php                                
Description: Class de gestion des Utilisateurs     
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

class Users extends DB {
    /* TRAITS */
    use Trait_security;
    
    /* ATTRIBUTES */
//    private $_iduser;

    /* CONSTRUCTEUR */
    public function __construct() {
        parent::__construct();
    }

    /* GETTER */
//    public function getIdUser()             { return $this->_iduser; }
    
    /* SETTER */
//    public function setIdUser($iduser)      { $this->_iduser = $iduser; }
    
    /* INITTER */
    
    /* METHODES */
    private function storeUserInSession($data) {
        $_SESSION['user'] = array();
        $_SESSION['user']['iduser'] = $data->id;
        $_SESSION['user']['login'] = $data->login;
        $_SESSION['user']['user_name'] = $data->user_name;
        $_SESSION['user']['email'] = $data->email;
        $_SESSION['user']['level'] = $data->level;
    }
    
    private function storeClientInSession($data) {
        $_SESSION['client'] = array();
        $_SESSION['client']['idclient'] = $data->id;
        $_SESSION['client']['societe'] = $data->societe;
        $_SESSION['client']['titre'] = $data->titre;
        $_SESSION['client']['nom'] = $data->nom;
        $_SESSION['client']['prenom'] = $data->prenom;
    }
    
    public function selectUserInfo($login, $password) {
        try {
            $sql = "SELECT * FROM users WHERE login='".$login."' AND password='".md5($password)."'";
            $data = $this->execOneResultQuery($sql);
            if($data) {
                $this->storeUserInSession($data);
                $result = true;
            }
            else {
                $result = false;
            }
            return $result;
        }
        catch (PDOException $e) {
            throw new PDOException($e);
        }
    }
    
    public function selectClientInfo($login, $password) {
        try {
            if($data = $this->getUserInDB('clients', $login, $password)) {
                $this->storeClientInSession($data);
                return true;
            }
            else {
                return false;
            }
        }
        catch (PDOException $e) {
            throw new PDOException($e);
        }
    }
    
    private function getUserInDB($table, $login, $password) {
        try {
            $sql = "SELECT * FROM ".$table." WHERE email='".$login."' AND password='".md5($password)."'";
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
