<?php
/*           
==================================================================
Fichier: produits.class.php                                
Description: Class de gestion des produits        
------------------------------------------------------------------
Auteur: Jérôme Clerc                              
Editeurs: Jérôme Clerc
Société: iLights - Web&Design                 
Version: 1.0               
------------------------------------------------------------------
Changelog
------------------------------------------------------------------
JCL | ??.??.???? - 1.1
xxxxxxx

==================================================================
*/

class Produits extends DB {
    /* ATTRIBUTES */
    private $_idprod;
    private $_type;
    private $_name;
    private $_description;
    private $_img;
    private $_price;
    private $_active;


    /* CONSTRUCTEUR */
    public function __construct() {
        parent::__construct();
    }

    /* GETTER */
    public function getIdProd()                     { return $this->_idprod; }
    public function getType()                       { return $this->_type; }
    public function getName()                       { return $this->_name; }
    public function getDescription()                { return $this->_description; }
    public function getImg()                        { return $this->_img; }
    public function getPrice()                      { return $this->_price; }
    public function getActive()                     { return $this->_active; }
    
    /* SETTER */
    public function setIdProd($idprod)              { $this->_idprod = $idprod; }
    public function setType($type)                  { $this->_type = $type; }
    public function setName($name)                  { $this->_name = $name; }
    public function setDescription($description)    { $this->_description = $description; }
    public function setImg($img)                    { $this->_img = $description; }
    public function setPrice($price)                { $this->_price = $price; }
    public function setActive($active)              { $this->_active = $active; }
    
    /* METHODES */
    public function buildTbfMenu($data) {
        $result  = '';
        foreach($data as $k => $type) {
            $result .= '<div class="col-xs-12 col-md-6 col-lg-4">';
                $result .= '<h3>'.$type->type_title.'</h3>';
                $result .= '<ul class="lst-prod">';
                foreach($this->reqProductsByType($type->id) as $k => $obj) {
                    $result .= '<li>';
                        $result .= '<div class="row">';
                            $result .= '<div class="col-lg-12">';
                                $result .= '<h2>'.$obj->prod_name.'</h2>';
                            $result .= '</div>';
                        $result .= '</div>';
                        $result .= '<div class="row">';
                            $result .= '<div class="col-lg-3">';
                                $result .= '<img src="images/products/'.$obj->prod_img.'" class="img-circle">';
                            $result .= '</div>';
                            $result .= '<div class="col-lg-6">';
                                $result .= '<p>'.$obj->prod_description.'</p>';
                            $result .= '</div>';
                            $result .= '<div class="col-lg-3">';
                                //$result .= 'CHF 6.<span class="exp">20</span>';
                                $result .= $this->stylePrice($obj->prod_price);
                            $result .= '</div>';
                        $result .= '</div>';
                    $result .= '</li>';
                }
                $result .= '</ul>';
            $result .= '</div>';
        }
        
        
        return $result;
    }
    
    public function bildPromotProducts($obj) {
        $result  = '<div class="row">';
            $result .= '<div class="col-lg-12">';
                $result .= '<img src="images/products/'.$obj->prod_img.'" class="img-circle img-center">';
            $result .= '</div>';
        $result .= '</div>';
        $result .= '<div class="row">';
            $result .= '<div class="col-lg-12">';
                $result .= '<h3>'.$obj->prod_name.'</h3>';
                $result .= '<p>'.$obj->prod_description.'</p>';
            $result .= '</div>';
        $result .= '</div>';
        
        return $result;
    }
    
    private function stylePrice($price) {
        $split = explode('.', $price);
        return 'CHF '.$split['0'].'.<span class="exp">'.$split['1'].'</span>';
    }
    
    private function reqProductsByType($id) {
        try {
            $sql = "SELECT * FROM produits WHERE id_type_prod='".$id."'";
            return $this->execQuery($sql);
        }
        catch (PDOException $e) {
            throw new PDOException($e);
        }
    }
    
    public function reqPormotedProducts() {
        try {
            $sql = "SELECT * FROM produits WHERE promote='1'";
            return $this->execOneResultQuery($sql);
        }
        catch (PDOException $e) {
            throw new PDOException($e);
        }
    }
    
    public function reqTypeProducts() {
        try {
            $sql = "SELECT * FROM types_produits ORDER BY sort ASC";
            return $this->execQuery($sql);
        }
        catch (PDOException $e) {
            throw new PDOException($e);
        }
    }
}
?>