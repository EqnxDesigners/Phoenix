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
    use Trait_renderhtml, Trait_security;
    
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
        return $this->getLstClients();
    }
    
    public function getLstClients() {
        try {
            $allClients = $this->getClients();
            $result = '<ul>';
                $result .= $this->getListingHeader();
            if($allClients) {
                foreach($allClients as $K => $client) {
                    $result .= '<li class="row">';
                        if(strlen($client->societe) < 1) {
                            $result .= '<div class="small-3 columns">&nbsp;</div>';
                        }
                        else {
                            $result .= '<div class="small-3 columns">'.$client->societe.'</div>';
                        }
                        if(strlen($client->nom) < 1 && strlen($client->prenom) < 1) {
                            $result .= '<div class="small-3 columns">&nbsp;</div>';
                        }
                        else {
                            $result .= '<div class="small-3 columns">'.$client->titre.' '.strtoupper($client->nom).' '.$client->prenom.'</div>';
                        }
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
    
    public function buildEditForm($id) {
        try {
            $client = $this->getClientById($id);
            $result =   '<form name="form_edit" action="modules/clients/ajax.php" method="post" enctype="multipart/form-data">
                            <div class="row">
                                <div class="small-12 columns">
                                    <input type="text" name="societe" placeholder="Société" value="'.$client->societe.'" list="societe-in-db" autocomplete="off" >';
            $result .=              $this->buildAutoCompleteLst('societe-in-db');
            $result .=  '       </div>
                                <div class="small-2 columns">
                                    <select name="titre">';
            $result .=  '               <option value="'.$client->titre.'">'.($client->titre === 'M.' ? 'Monsieur' : 'Madame').'</option>';
            $result .=  '               <option value="M.">Monsieur</option>
                                        <option value="Mme">Madame</option>
                                    </select>
                                </div>
                                <div class="small-5 columns">
                                    <input type="text" name="nom" placeholder="Nom" value="'.$client->nom.'">
                                </div>
                                <div class="small-5 columns">
                                    <input type="text" name="prenom" placeholder="Prénom" value="'.$client->prenom.'">
                                </div>
                                <div class="small-6 columns" >
                                    <input type="email" name="email" placeholder="E-mail" value="'.$client->email.'" required="required">
                                </div>
                                <div class="small-6 columns">
                                    <input type="text" name="telephone" placeholder="Téléphone" value="'.$client->telephone.'" pattern="[0-9\s]*">
                                </div>
                                <div class="small-6 columns">
                                    <input type="text" name="mobile" placeholder="Mobile" value="'.$client->fax.'" pattern="[0-9\s]*">
                                </div>
                                <div class="small-6 columns">
                                    <input type="text" name="fax" placeholder="Fax" value="'.$client->mobile.'" pattern="[0-9\s]*">
                                </div>
                                <div class="small-12 columns text-right">
                                    <input type="hidden" name="iditem" value="'.$id.'">
                                    <input type="submit" class="button success" name="majitem" value="Modifier">
                                </div>
                            </div>
                        </form>';
            return $result;
        }
        catch (PDOException $e) {
            throw new PDOException($e);
        }
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
    
    private function getClientById($id) {
        try {
            $sql = "SELECT *
                    FROM clients
                    WHERE id='".$id."'";
            return $this->execOneResultQuery($sql);
        }
        catch (PDOException $e) {
            throw new PDOException($e);
        }
    }
    
    public function getClientByToken($token) {
        try {
            $sql = "SELECT clients.id, societe, titre, nom, prenom, email, telephone, fax, mobile
                    FROM clients
                    INNER JOIN clients_tokens ON clients_tokens.id_client = clients.id
                    WHERE clients_tokens.token='".$token."'";
            return $this->execOneResultQuery($sql);
        }
        catch (PDOException $e) {
            throw new PDOException($e);
        }
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
            $id = $this->applyQueryWithLastId($sql);
            
            return $this->insertToken($id);
        }
        catch (PDOException $e) {
            throw new PDOException($e);
        }
    }
    
    public function updateClient($data) {
        try {
            $sql = "UPDATE clients
                    SET
                    societe='".addslashes($data['societe'])."',
                    titre='".$data['titre']."',
                    nom='".addslashes($data['nom'])."',
                    prenom='".addslashes($data['prenom'])."',
                    email='".$data['email']."',
                    telephone='".$data['telephone']."',
                    fax='".$data['fax']."',
                    mobile='".$data['mobile']."'
                    WHERE id='".$data['iditem']."'";
            $this->applyOneQuery($sql);
        }
        catch (PDOException $e) {
            throw new PDOException($e);
        }
    }

    public function deleteItem($id) {
        try {
            $sql = "DELETE FROM clients_tokens WHERE id_client='".$id."'";
            $this->applyOneQuery($sql);
            
            try {
                $sql = "DELETE FROM clients_docs WHERE id_client='".$id."'";
                $this->applyOneQuery($sql);
                
                try {
                    $sql = "DELETE FROM clients WHERE id='".$id."'";
                    $this->applyOneQuery($sql);
                }
                catch (PDOException $e) {
                    throw new PDOException($e);
                }
            }
            catch (PDOException $e) {
                throw new PDOException($e);
            }
        }
        catch (PDOException $e) {
            throw new PDOException($e);
        }
    }
    
    public function buildAutoCompleteLst($id) {
        $result = '<datalist id="'.$id.'">';
        try {
            foreach($this->getAutoCompleteItems() as $k => $item) {
                $result .= '<option value="'.$item->societe.'">';
            }
        }
        catch (PDOException $e) {
            throw new PDOException($e);
        }
        $result .= '</datalist>';
        return $result;
    }
    
    private function getAutoCompleteItems() {
        try {
            $sql = "SELECT DISTINCT societe FROM clients ORDER BY societe ASC";
            return $this->execQuery($sql);
        }
        catch (PDOException $e) {
            throw new PDOException($e);
        }
    }
    
    private function insertToken($id) {
        try {
            $token = $this->buildSecureToken();
            $sql = "INSERT INTO clients_tokens (id_client,token) 
                    VALUES ('".$id."',
                            '".$token."')";
            $this->applyOneQuery($sql);
            
            return $token;
        }
        catch (PDOException $e) {
            throw new PDOException($e);
        }
    }
    
    public function __destruct() {
           
	}
}
?>
