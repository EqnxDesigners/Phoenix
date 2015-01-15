<?php
trait Trait_security {
    
    private function generateSecureKey($key) {
        $token = sha1(md5(sha1(md5($key))));
        return $token;
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
    
    public function buildSecureToken() {
        $str1 = session_id();
        $str2 = '';
        
        $str = "abcdefghijklmnopqrstuvwxyzABCDEFGHIJKLMNOPQRSTUVWXYZ1234567890";
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
}
?>