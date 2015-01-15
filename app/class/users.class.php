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
        $_SESSION['user']['iduser'] = $data->id;
        $_SESSION['user']['login'] = $data->login;
        $_SESSION['user']['user_name'] = $data->user_name;
        $_SESSION['user']['email'] = $data->email;
        $_SESSION['user']['level'] = $data->level;
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
            $sql = "SELECT * FROM clients WHERE email='".$login."' AND password='".md5($password)."'";
            return $this->execOneResultQuery($sql);
        }
        catch (PDOException $e) {
            throw new PDOException($e);
        }
    }
    
    private function generateSecureKey($key) {
        $token = sha1(md5(sha1(md5($key))));
        try {
            return $token;
        }
        catch (PDOException $e) {
            throw new PDOException($e);
        }
    }
    
    private function buildSecureKey() {
        $str1 = session_id();
        $str2 = '';
        
        $str = "abcdefghijklmnopqrstuvwxyzABCDEFGHIJKLMNOPQRSTUVWXYZ1234567890?!#@%&";
        srand((double)microtime()*1000000);
        for($i=0; $i<60; $i++) {
            $str2 .= $str[rand()%strlen($str)];
        }
        return $str2.$str1;
    }
    
    public function secureSynch() {
        $key = $this->buildSecureKey();
        $_SESSION['user']['token'] = $this->generateSecureKey($key);
        return $key;
    }
    
    public function securityCheck($key) {
        if($this->generateSecureKey($key) === $_SESSION['user']['token']) {
            $result = true;
        }
        else {
            $result = false;
        }
    }
    
    public function __destruct() {
           
	}
}
?>
