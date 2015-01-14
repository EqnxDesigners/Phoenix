<?php
/**
 * Description of produit
 *
 * @author jerome
 */
class Produit {
    //----- ATTRIBUTES ------
    private $_id;
    private $_type;
    private $_name;
    private $_descriptif;
    private $_image;
    private $_prix;
    private $_state;
    
    //----- GETTER -----
    public function getId()                     { return $this->_id; }
    public function getType()                   { return $this->_type; }
    public function getName()                   { return $this->_name; }
    public function getDescriptif()             { return $this->_descriptif; }
    public function getImage()                  { return $this->_image; }
    public function getPrix()                   { return $this->_prix; }
    public function getState()                  { return $this->_state; }
    
    //----- SETTER -----
    public function setId($id)                  { $this->_id = $id; }
    public function setType($type)              { $this->_type = $type; }
    public function setName($name)              { $this->_name = $name; }
    public function setDescriptif($descriptif)  { $this->_descriptif = $descriptif; }
    public function setImage($image)            { $this->_image = $image; }
    public function setPrix($prix)              { $this->_prix = $prix; }
    public function setState($state)            { $this->_state = $state; }
    
    //----- METHODES ------
    public function __construct() {
        
    }
}
