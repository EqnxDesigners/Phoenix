<?php
/*           
==================================================================
Fichier: clients.class.php                                
Description: Class du module Clients     
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

class Clients extends DB {
    /* TRAITS */
    use Trait_renderhtml;
    
    /* ATTRIBUTES */
//    private $_status;

    /* CONSTRUCTEUR */
    public function __construct() {
        parent::__construct();
    }

    /* GETTER */
//    public function getStatus()             { return $this->$_status; }
    
    /* SETTER */
//    public function setStatus($status)      { $this->_status = $status; }
    
    /* INITTER */
    
    /* METHODES */
    public function reloadListing() {
        return $this->getLstOptions();
    }
    
    public function getLstClients() {
        try {
            $allClients = $this->getClients();
            $result = '<ul>';
                $result .= $this->getListingHeader();
            if($allClients) {
                foreach($allClients as $K => $client) {
                    $result .= '<li class="row">';
                        $result .= '<div class="small-3 columns">'.$client->societe.'</div>';
                        $result .= '<div class="small-3 columns">'.$client->titre.' '.strtoupper($client->nom).' '.$client->prenom.'</div>';
                        $result .= '<div class="small-3 columns"><a href="mailto:'.$client->email.'">'.$client->email.'</a></div>';
                        $result .= '<div class="small-2 columns">';
                        if(strlen($client->telephone) > 1) {
                            $result .= 'T. '.$client->telephone.'<br>';
                        }
                        if(strlen($client->fax) > 1) {
                            $result .= 'F. '.$client->fax.'<br>';
                        }
                        if(strlen($client->mobile) > 1) {
                            $result .= 'M. '.$client->mobile.'<br>';
                        }
                    $result .= '</div>';
                        $result .= '<div class="small-1 columns toolbox text-right">'.$this->buildToolBox($client).'</div>';
                    $result .= '</li>';
                }
            }
            else {
                $result .= '<li class="row"><div class="small-12 columns">Aucun clients pour le moment...</div></li>';
            }
            $result .= '</ul>';
            $this->renderHtml($result);
        }
        catch (PDOException $e) {
            throw new PDOException($e);
        }
    }
    
    private function getListingHeader() {
        $result = '<li class="row lst-header">';
            $result .= '<div class="small-3 columns">Société</div>';
            $result .= '<div class="small-3 columns">Clients</div>';
            $result .= '<div class="small-3 columns">E-mail</div>';
            $result .= '<div class="small-2 columns">Coordonnées</div>';
            $result .= '<div class="small-1 columns">&nbsp;</div>';
        $result .= '</li>';
        return $result;
    }
    
    private function buildValueField($opt) {
        if($opt->type === 'bool') {
            $result = '<div class="switch tiny round">';
                $result .= '<input id="opt-'.$opt->id.'" ref="'.$opt->id.'" type="checkbox" ';
                if($opt->value === '1') {
                    $result .= 'checked>';
                }
                else {
                    $result .= '>';
                }
                $result .= '<label for="opt-'.$opt->id.'"></label>';
            $result .= '</div>';
        }
        if($opt->type === 'str') {
            $result = '<input type="text" name="opt-value" id="opt-'.$opt->id.'" ref="'.$opt->id.'" value="'.$opt->value.'" target="value">';
        }
        
        return $result;
    }
    
    private function buildToolBox($item) {
        $result = '';
        $result .= '&nbsp;<i class="fa fa-pencil  btn" role="edit" item="'.$item->id.'"></i>';
        $result .= '&nbsp;<i class="fa fa-trash-o btn" role="trash" item="'.$item->id.'"></i>';
        return $result;
    }
    
    private function getClients() {
        try {
            $sql = "SELECT *
                    FROM clients
                    ORDER BY nom ASC";
            return $this->execQuery($sql);
        }
        catch (PDOException $e) {
            throw new PDOException($e);
        }
    }
    
    private function getOptionsById($id) {
        try {
            $sql = "SELECT *
                    FROM options 
                    WHERE id='".$id."'";
            return $this->execOneResultQuery($sql);
        }
        catch (PDOException $e) {
            throw new PDOException($e);
        }
    }
    
    public function updateOption($field, $id, $value) {
        if($field === 'code') {
            $value = $this->formatCodeValue($value);
        }
        try {
            $sql = "UPDATE options 
                    SET ".$field."='".$value."' 
                    WHERE id='".$id."'";
            $this->applyOneQuery($sql);
            return $value;
        }
        catch (PDOException $e) {
            throw new PDOException($e);
        }
    }
    
    private function formatCodeValue($value) {
        $result = str_replace(' ', '_', $value);
        return strtoupper($result);
    }
    
    public function addClient($data) {
        try {
            $sql = "INSERT INTO clients (societe,titre,nom,prenom,email,telephone,fax,mobile) 
                    VALUES ('".addslashes($data['societe'])."',
                            '".$data['titre']."',
                            '".addslashes($data['nom'])."',
                            '".addslashes($data['prenom'])."',
                            '".$data['email']."',
                            '".$data['telephone']."',
                            '".$data['fax']."',
                            '".$data['mobile']."')";
            $this->applyOneQuery($sql);
        }
        catch (PDOException $e) {
            throw new PDOException($e);
        }
    }
    
    public function deleteItem($id) {
        try {
            $sql = "DELETE 
                    FROM options
                    WHERE id='".$id."'";
            $this->applyOneQuery($sql);
        }
        catch (PDOException $e) {
            throw new PDOException($e);
        }
    }
    
    public function __destruct() {
           
	}
}
?>