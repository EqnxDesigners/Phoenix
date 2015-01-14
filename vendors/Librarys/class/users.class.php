<?php
/*           
==================================================================
Fichier: users.class.php                                
Description: Class de gestion des Utilisateurs     
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

class Users extends DB {
    /* ATTRIBUTES */
    private $_iduser;
    private $_login;
    private $_password;
    private $_username;
    private $_email;
    private $_level;
    private $_token;


    /* CONSTRUCTEUR */
    public function __construct($login, $password) {
        parent::__construct();
        $this->setLogin($login);
        $this->setPassword($password);
    }

    /* GETTER */
    public function getIdUser()             { return $this->_iduser; }
    public function getLogin()              { return $this->_login; }
    public function getPassword()           { return $this->_password; }
    public function getUserName()           { return $this->_username; }
    public function getEmail()              { return $this->_email; }
    public function getLevel()              { return $this->_level; }
    public function getToken()              { return $this->_token; }
    
    /* SETTER */
    public function setIdUser($iduser)      { $this->_iduser = $iduser; }
    public function setLogin($login)        { $this->_login = $login; }
    public function setPassword($password)  { $this->_password = $password; }
    public function setUserName($username)  { $this->_username = $username; }
    public function setEmail($email)        { $this->_email = $email; }
    public function setLevel($level)        { $this->_level = $level; }
    public function setToken($token)        { $this->_token = $token; }
    
    /* INITTER */
    
    /* METHODES */
    public function userLogIn($data) {
        $_SESSION['user']['user_name'] = $data->user_name;
        $_SESSION['user']['email'] = $data->email;
        $_SESSION['user']['level'] = $data->user_level;
        $_SESSION['user']['token'] = ADMIN_TOKEN;
    }
    
    public function reqUserInfo() {
        try {
            $sql = "SELECT * FROM users WHERE login='".$this->_login."' AND password='".md5($this->_password)."'";
            return $this->execOneResultQuery($sql);
        }
        catch (PDOException $e) {
            throw new PDOException($e);
        }
    }
}
?>