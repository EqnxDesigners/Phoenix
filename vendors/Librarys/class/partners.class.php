<?php
/*           
==================================================================
Fichier: partners.class.php                                
Description: Class de gestion des partenaires                     
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

class Partners extends DB {
    /* ATTRIBUTES */
    private $_lang;
    
    /* CONSTRUCTEUR */
    public function __construct($lang = '1') {
        parent::__construct();
        
        $this->setLang($lang);
    }
    
    /* GETTER */
    public function getLang()       { return $this->_lang; }
    
    /* SETTER */
    public function setLang($lang)  { $this->_lang = $lang; }
    
    /* METHODES */
    public function buildPartenairesSlide($data) {
        $result = '';

        $result .= '<div class="carousel-inner">';
        foreach($data as $k => $img) {
            if($k == 0) {
                $result .= '<div class="item active">';
            }
            else {
                $result .= '<div class="item">';
            }
            $result .= '<img src="images/pubs/partenaires/'.$img->logo.'" alt="'.$img->logo.'">';
            $result .= '</div>';
        }
        $result .= '</div>';

        return $result;
    }
    
    public function reqRandPartnersLogos() {
        try {
            $sql = "SELECT logo FROM cte_sponsors ORDER BY rand()";
            return $this->execQuery($sql);
        }
        catch (PDOException $e) {
            throw new PDOException($e);
        }
    }
}
?>