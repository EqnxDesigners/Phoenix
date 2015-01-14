<?php
/*           
==================================================================
Fichier: form.class.php                                
Description: Class de traitement des formulaires                      
------------------------------------------------------------------
Auteur: Jéréme Clerc                              
Editeurs: Jéréme Clerc
Société: e-novinfo Sàrl                 
Version: 1.0               
------------------------------------------------------------------
Changelog
------------------------------------------------------------------
00.00.0000 - 1.x
Descriptif

==================================================================
*/

class Formulaire extends DB {
    /* ATTRIBUTS */
    private $_sendstatu;

    /* METHODES */
    public function __construct() {
        $this->setSendStatu(true);
    }

    /* GETTER */
    public function getSendStatu()              { return $this->_sendstatu; }

    /* SETTER */
    public function setSendStatu($sendstatu)    { $this->_sendstatu = $sendstatu; }
    
    /* INNITER */
    private function initLangues() {
        require_once 'langues.class.php';
        return $langue = new Langues();
    }

    /* METHODES */
    //D�marrage des tests
    public function formTreatment($needed, $values) {
        $lst_needed_fields = $this->getNeededFields($needed);

        foreach($lst_needed_fields as $field) {
            //Test si le champ est vide
            if(!$this->verifEmptyField($values[$field])) {
                $this->setSendStatu(false);
            }

            //Test la synthaxe d'une email
            if($field == 'email') {
                if(!$this->verifSyntaxeEmail($values[$field])) {
                        $this->setSendStatu(false);
                }
            }
        }
        return $this->getSendStatu();
    }

    //R�cup�ration de la valeure d'un champ
    public function getValue($field) {
        if(isset($_POST[$field])) {
            echo $_POST[$field];
        }
    }

    //R�cup�ration des �l�ments obligatoires
    private function getNeededFields($lst) {
        return $result = explode('#', $lst);
    }

    //Fonction de v�rification de la saisie d'un champ
    private function verifEmptyField($field) {
        if(!empty($field)) {
                return true;
        }
        else {
                return false;
        }
    }

    //Fonction de v�rification de l'email
    private function verifSyntaxeEmail($adresse) { 
        $Syntaxe='#^[\w.-]+@[\w.-]+\.[a-zA-Z]{2,6}$#'; 
        if(preg_match($Syntaxe,$adresse)) { 
                return true;
        }
        else { 
                return false;
        }
    }
    
    public function getTextFieldsByLang($name) {
        $langue = $this->initLangues();
        $result = '';
        foreach($langue->reqAllLang() as $k => $lang) {
            $result .= '<div class="form-group">';
            $result .= '<label class="sr-only" for="'.$name.'_'.$lang->langue.'">'.$name.'_'.$lang->langue.'</label>';
            $result .= '<input type="text" class="form-control" name="'.$name.'_'.$lang->langue.'" id="'.$name.'_'.$lang->langue.'" placeholder="'.ucfirst($name).' '.$lang->langue.'">';
            $result .= '</div>';
        }
        return $result;
    }

    public function __destruct() {
    }
}
?>