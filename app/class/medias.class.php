<?php
/*           
==================================================================
Fichier: medias.class.php                                
Description: Class du module Medias     
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

class Medias extends DB {
    /* TRAITS */
    use Trait_renderhtml, Trait_datetime;
    
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
        return $this->getLstDocs();
    }
    
    public function getLstDocs() {
        try {
            $allDocs = $this->getDocs();
            $result = '<ul>';
                $result .= $this->getListingHeader();
            if($allDocs) {
                foreach($allDocs as $K => $doc) {
                    $result .= '<li class="row">';
                        $result .= '<div class="small-4 columns"><strong>'.$doc->doc.'</strong></div>';
                        $result .= '<div class="small-3 columns">'.$doc->categorie.'</div>';
                        $result .= '<div class="small-3 columns">'.$this->displayDate($doc->date_publi).'</div>';
                        $result .= '<div class="small-2 columns toolbox text-right">'.$this->buildToolBox($doc).'</div>';
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
            $result .= '<div class="small-4 columns">Document</div>';
            $result .= '<div class="small-3 columns">Catégorie</div>';
            $result .= '<div class="small-3 columns">Publication</div>';
            $result .= '<div class="small-2 columns">&nbsp;</div>';
        $result .= '</li>';
        return $result;
    }
    
//    public function buildEditForm($id) {
//        try {
//            $client = $this->getClientById($id);
//            $result =   '<form name="form_edit" action="modules/clients/ajax.php" method="post" enctype="multipart/form-data">
//                            <div class="row">
//                                <div class="small-12 columns">
//                                    <input type="text" name="societe" placeholder="Société" value="'.$client->societe.'" list="societe-in-db" autocomplete="off" >';
//            $result .=              $this->buildAutoCompleteLst('societe-in-db');
//            $result .=  '       </div>
//                                <div class="small-2 columns">
//                                    <select name="titre">';
//            $result .=  '               <option value="'.$client->titre.'">'.($client->titre === 'M.' ? 'Monsieur' : 'Madame').'</option>';
//            $result .=  '               <option value="M.">Monsieur</option>
//                                        <option value="Mme">Madame</option>
//                                    </select>
//                                </div>
//                                <div class="small-5 columns">
//                                    <input type="text" name="nom" placeholder="Nom" value="'.$client->nom.'">
//                                </div>
//                                <div class="small-5 columns">
//                                    <input type="text" name="prenom" placeholder="Prénom" value="'.$client->prenom.'">
//                                </div>
//                                <div class="small-6 columns" >
//                                    <input type="email" name="email" placeholder="E-mail" value="'.$client->email.'" required="required">
//                                </div>
//                                <div class="small-6 columns">
//                                    <input type="text" name="telephone" placeholder="Téléphone" value="'.$client->telephone.'" pattern="[0-9\s]*">
//                                </div>
//                                <div class="small-6 columns">
//                                    <input type="text" name="mobile" placeholder="Mobile" value="'.$client->fax.'" pattern="[0-9\s]*">
//                                </div>
//                                <div class="small-6 columns">
//                                    <input type="text" name="fax" placeholder="Fax" value="'.$client->mobile.'" pattern="[0-9\s]*">
//                                </div>
//                                <div class="small-12 columns text-right">
//                                    <input type="hidden" name="iditem" value="'.$id.'">
//                                    <input type="submit" class="button success" name="majitem" value="Modifier">
//                                </div>
//                            </div>
//                        </form>';
//            return $result;
//        }
//        catch (PDOException $e) {
//            throw new PDOException($e);
//        }
//    }
    
    private function buildToolBox($item) {
        $result = '';
        $result .= '&nbsp;<i class="fa '.($item->active === '0' ? 'fa-eye-slash' : 'fa-eye btn').' btn" role="'.($item->active === '0' ? 'enable' : 'disable').'" item="'.$item->id.'"></i>';
        $result .= '&nbsp;<i class="fa '.($item->private === '0' ? 'fa-unlock-alt' : 'fa-lock btn').' btn" role="'.($item->private === '0' ? 'media-lock' : 'media-unlock').'" item="'.$item->id.'"></i>';
        $result .= '&nbsp;<i class="fa fa-pencil  btn" role="edit" item="'.$item->id.'"></i>';
        $result .= '&nbsp;<i class="fa fa-share-alt  btn" role="media-share" item="'.$item->id.'"></i>';
        $result .= '&nbsp;<i class="fa fa-trash-o btn" role="trash" item="'.$item->id.'"></i>';
        return $result;
    }
    
    private function getDocs() {
        try {
            $sql = "SELECT docs.id, categorie, doc, titre, descriptif, date_publi, active, private
                    FROM docs
                    INNER JOIN categories_medias ON docs.id_categorie = categories_medias.id
                    ORDER BY id_categorie, doc ASC";
            return $this->execQuery($sql);
        }
        catch (PDOException $e) {
            throw new PDOException($e);
        }
    }
    
    public function selectCategories($current = null) {
        $result = '<select name="categorie">';
        $result .= ($current === null ? '<option value="xxx" selected>Choisir une catégorie</option>' : '<option value="'.$current.'" selected>'.$this->getCategorieById($current)->categorie.'</option>');
        foreach($this->getCategories() as $k => $cat) {
            $result .= '<option value="'.$cat->id.'">'.$cat->categorie.'</option>';
        }
        $result .= '</select>';
        return $result;
    }
    
    private function getCategories() {
        try {
            $sql = "SELECT * FROM categories_medias ORDER BY categorie ASC";
            return $this->execQuery($sql);
        }
        catch (PDOException $e) {
            throw new PDOException($e);
        }
    }
    
    private function getCategorieById($id) {
        try {
            $sql = "SELECT * FROM categories_medias WHERE id = '".$id."'";
            return $this->execOneResultQuery($sql);
        }
        catch (PDOException $e) {
            throw new PDOException($e);
        }
    }
    
    public function addItem($data, $table) {
        try {
            $sql = "INSERT INTO ".$table." (id_categorie,doc,titre,descriptif,date_publi,active,private) 
                    VALUES ('".$data['categorie']."',
                            '".$data['file_name']."',
                            '".addslashes($data['titre'])."',
                            '".addslashes($data['descriptif'])."',
                            '".$this->setDateTimeNow()."',
                            '1',
                            '".$data['private']."')";
            $this->applyOneQuery($sql);
        }
        catch (PDOException $e) {
            throw new PDOException($e);
        }
    }
    
    public function changeVisibility($table, $id, $value) {
        try {
            $sql = "UPDATE ".$table."
                    SET
                    active='".$value."'
                    WHERE id='".$id."'";
            $this->applyOneQuery($sql);
        }
        catch (PDOException $e) {
            throw new PDOException($e);
        }
    }
    
    public function changePrivacy($table, $id, $value) {
        try {
            $sql = "UPDATE ".$table."
                    SET
                    private='".$value."'
                    WHERE id='".$id."'";
            $this->applyOneQuery($sql);
        }
        catch (PDOException $e) {
            throw new PDOException($e);
        }
    }
    
    public function loadClientBinded($id, $table) {
        //($table === 'documents' ? $col = 'doc' : $col = 'video');
        try {
            $result = '<li class="mix">';
            foreach($this->getTheClients() as $k => $client) {
                $result .= '<div class="row">';
                $result .= '<div class="small-10 columns">'.$client->nom.'</div>';
                $result .= '<div class="small-2 columns text-right"><i class="fa fa-check"></i></div>';
                $result .= '</div>';
            }
            $result .= '</li>';
            return $result;
        }
        catch (PDOException $e) {
            throw new PDOException($e);
        }
        
//        <li class="mix">
//                                <div class="row">
//                                    <div class="small-10 columns">Client 1</div>
//                                    <div class="small-2 columns text-right"><i class="fa fa-check"></i></div>
//                                </div>
//                            </li>
    }
    
    private function getTheClients() {
        try {
            $sql = "SELECT *
                    FROM clients
                    ORDER BY societe, nom ASC";
            return $this->execQuery($sql);
        }
        catch (PDOException $e) {
            throw new PDOException($e);
        }
    }
    
//    private function getClientById($id) {
//        try {
//            $sql = "SELECT *
//                    FROM clients
//                    WHERE id='".$id."'";
//            return $this->execOneResultQuery($sql);
//        }
//        catch (PDOException $e) {
//            throw new PDOException($e);
//        }
//    }
    
//    public function getClientByToken($token) {
//        try {
//            $sql = "SELECT clients.id, societe, titre, nom, prenom, email, telephone, fax, mobile
//                    FROM clients
//                    INNER JOIN clients_tokens ON clients_tokens.id_client = clients.id
//                    WHERE clients_tokens.token='".$token."'";
//            return $this->execOneResultQuery($sql);
//        }
//        catch (PDOException $e) {
//            throw new PDOException($e);
//        }
//    }
    
//    public function updateClient($data) {
//        try {
//            $sql = "UPDATE clients
//                    SET
//                    societe='".addslashes($data['societe'])."',
//                    titre='".$data['titre']."',
//                    nom='".addslashes($data['nom'])."',
//                    prenom='".addslashes($data['prenom'])."',
//                    email='".$data['email']."',
//                    telephone='".$data['telephone']."',
//                    fax='".$data['fax']."',
//                    mobile='".$data['mobile']."'
//                    WHERE id='".$data['iditem']."'";
//            $this->applyOneQuery($sql);
//        }
//        catch (PDOException $e) {
//            throw new PDOException($e);
//        }
//    }
    
//    private function insertClientPwd($data) {
//        try {
//            $sql = "UPDATE clients
//                    SET
//                    password='".md5($data['password'])."'
//                    WHERE id='".$data['iditem']."'";
//            $this->applyOneQuery($sql);
//        }
//        catch (PDOException $e) {
//            throw new PDOException($e);
//        }
//    }
    
//    public function valideClientAccount($data) {
//        try {
//            $this->updateClient($data);
//            
//            try {
//                $this->insertClientPwd($data);
//                
//                try {
//                    $this->delClientToken($data['iditem']);
//                    return true;
//                }
//                catch (PDOException $e) {
//                    throw new PDOException($e);
//                }
//            }
//            catch (PDOException $e) {
//                throw new PDOException($e);
//            }
//        }
//        catch (PDOException $e) {
//            throw new PDOException($e);
//        }
//    }

//    public function deleteItem($id) {
//        try {
//            $sql = "DELETE FROM clients_tokens WHERE id_client='".$id."'";
//            $this->applyOneQuery($sql);
//            
//            try {
//                $sql = "DELETE FROM clients_docs WHERE id_client='".$id."'";
//                $this->applyOneQuery($sql);
//                
//                try {
//                    $sql = "DELETE FROM clients WHERE id='".$id."'";
//                    $this->applyOneQuery($sql);
//                }
//                catch (PDOException $e) {
//                    throw new PDOException($e);
//                }
//            }
//            catch (PDOException $e) {
//                throw new PDOException($e);
//            }
//        }
//        catch (PDOException $e) {
//            throw new PDOException($e);
//        }
//    }
    
//    private function delClientToken($id) {
//        try {
//            $sql = "DELETE FROM clients_tokens WHERE id_client='".$id."'";
//            $this->applyOneQuery($sql);
//        }
//        catch (PDOException $e) {
//            throw new PDOException($e);
//        }
//    }
    
//    public function buildAutoCompleteLst($id) {
//        $result = '<datalist id="'.$id.'">';
//        try {
//            foreach($this->getAutoCompleteItems() as $k => $item) {
//                $result .= '<option value="'.$item->societe.'">';
//            }
//        }
//        catch (PDOException $e) {
//            throw new PDOException($e);
//        }
//        $result .= '</datalist>';
//        return $result;
//    }
    
//    private function getAutoCompleteItems() {
//        try {
//            $sql = "SELECT DISTINCT societe FROM clients ORDER BY societe ASC";
//            return $this->execQuery($sql);
//        }
//        catch (PDOException $e) {
//            throw new PDOException($e);
//        }
//    }
    
//    private function insertToken($id) {
//        try {
//            $token = $this->buildSecureToken();
//            $sql = "INSERT INTO clients_tokens (id_client,token) 
//                    VALUES ('".$id."',
//                            '".$token."')";
//            $this->applyOneQuery($sql);
//            
//            return $token;
//        }
//        catch (PDOException $e) {
//            throw new PDOException($e);
//        }
//    }
    
    public function __destruct() {
           
	}
}
?>
