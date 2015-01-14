<?php
class CONFIG extends DB {
	
    //Génère la liste des modules
    public function getLstModules() {
            return $this->getAllRows('cms_list_modules', 'module_name');
    }

    //Liste les paramètres d'un module
    public function getModuleParams($id) {
            $module = $this->getWhereEqual('cms_list_modules', 'id', $id);
            return $this->getAllRows($module['0']['tbl_params']);
    }

    //Récupérer le nom de la table de paramétrage
    public function getModuleParamTable($id) {
            $module = $this->getWhereEqual('cms_list_modules', 'id', $id);
            return $module['0']['tbl_params'];
    }

    //Récupération du path d'un module
    public function getModulePath($id) {
            $module = $this->getWhereEqual('cms_list_modules', 'id', $id);
            return $module['0']['module_path'];
    }

    //Test si un module est activé ou pas
    public function checkActivedModule($id) {
            $req = $this->getWhereEqual('cms_mainmenu', 'id_module', $id);
            $path = $this->getModulePath($id);

            if($req['0'] != '') {
                    //Module activé
                    echo '<a href="modules/'.$path.'/install.php?action=uninstall&id='.$id.'" target="_self">
                            <img src="imgs/bton_valid_green.png" width="24" height="24">
                          </a>';
            }
            else {
                    //Module non activé
                    echo '<a href="modules/'.$path.'/install.php?action=install&id='.$id.'" target="_self">
                            <img src="imgs/bton_valid.png" width="24" height="24">
                          </a>';
            }
    }

    //Test si on peut configurer le module
    public function checkConfigModule($id) {
            $req = $this->getWhereEqual('cms_mainmenu', 'id_module', $id);

            if($req['0'] != '') {
                    //Module installé
                    $req = $this->getWhereEqual('cms_list_modules', 'id', $id);
                    if($req['0']['config'] == '1') {
                            //Module configurable
                            echo '	<a href="?module='.$_SESSION['module'].'&action=config&id='.$id.'" target="_self">
                                                    <img src="imgs/bton_config.png" width="24" height="24">
                                            </a>';
                    }
                    else {
                            //Module non configurable
                            echo '	<img src="imgs/bton_noconfig.png" width="24" height="24">';
                    }
            }
            else {
                    //Module non activé
                    echo '	<img src="imgs/bton_noconfig.png" width="24" height="24">';
            }
    }

    //Inscription d'un nouvel utilisateur
    public function addUser($login, $password, $user_name, $email, $user_lvl) {
            mysql_query("INSERT INTO cms_users VALUES ('','".$login."','".$password."','".$user_name."','".$email."','".$user_lvl."')");
    }

    //Test si le paramètre est actif
    public function checkActive($value, $state) {
            if($state == 'on') {
                    if($value == 1) {
                            echo 'checked';
                    }
            }

            if($state == 'off') {
                    if($value == 0) {
                            echo 'checked';
                    }
            }
    }

    //Activer un module
    public function enableModule($id) {
            $infos_module = $this->getWhereEqual('cms_list_modules', 'id', $id);
            $ordre = $this->getAllRows('cms_mainmenu', 'ordre', 'DESC');

            $ordre = $ordre['0']['ordre'] + 1;

            //Ajout du module dans le mainmenu
            mysql_query("INSERT INTO cms_mainmenu VALUES ('','".$infos_module['0']['id']."','".$ordre."')");
    }

    //Activer un module
    public function disableModule($id) {
            $infos_module = $this->getWhereEqual('cms_list_modules', 'id', $id);

            //Suppression dans le mainmenu
            $this->delRowWhereEqual('cms_mainmenu', 'id_module', $id);
    }

    //Mise à jour de la configuration du module
    public function updateModuleParam($id, $param, $value) {
            $table = $this->getModuleParamTable($id);
            mysql_query("UPDATE ".$table." SET value='".$value."' WHERE parametre='".$param."'");
    }
    
    private function getCatById($id) {
        $query = mysql_query("SELECT cat_name FROM lay_categories WHERE id='".$id."'");
        if(mysql_num_rows($query)) {
            $result = mysql_result($query, 0);
        }
        else {
            $result = 'Non définie';
        }
        return $result;
    }

    public function getLayoutPages($cat = 'all') {
        $result = '<ul class="unsortable" alt="lst_pages">';
        //HEADER
        $result .= '<li class="no_drag" style="background:#404040;color:#fff;"><div class="row">';
        $result .= '<div class="three columns">Page</div>';
        $result .= '<div class="three columns">Titre</div>';
        $result .= '<div class="three columns">Catégorie</div>';
        $result .= '<div class="one columns text-center">Editer</div>';
        $result .= '<div class="one columns text-center">Activer</div>';
        $result .= '<div class="one columns text-center">Supprimer</div>';
        $result .= '</div></li>';
        
        foreach($this->getLstPages($cat) as $page) {
            $result .= '<li role="'.$page['id_page'].'#"><div class="row">';
            $result .= '<div class="three mobile-one columns"><strong>'.$page['page_name'].'</strong></div>';
            $result .= '<div class="three columns hide-for-small">'.$page['title'].'</div>';
            $result .= '<div class="three columns hide-for-small">'.$this->getCatById($page['id_cat']).'</div>';
            $result .= '<div class="one mobile-one columns text-center"><img src="imgs/bton_edit.png" class="tool" role="open_edit_box" alt="'.$page['id_page'].'"></div>';
            $result .= '<div class="one mobile-one columns text-center">'.$this->getMasterSwitch($page['id_page'], $page['active'], 'page').'</div>';
            $result .= '<div class="one mobile-one columns text-center"><img src="imgs/bton_del.png" class="tool" role="open_del_box" alt="'.$page['id_page'].'"></div>';
            $result .= '</div>';
            //Edit box
            $result .= '<div class="pop-box" id="edit_'.$page['id_page'].'">';
            $result .= '<form name="form_add_page" action="dashboard.php?module='.$_SESSION['module'].'&page=gestion&gerer=pages" method="POST" enctype="multipart/form-data">';
            $result .= '<div class="row"><div class="three mobile-one columns"><input type="text" name="page_name" value="'.$page['page_name'].'"></div>';
            $result .= '<div class="six columns hide-for-small">';
            foreach ($this->getLstLang() as $lang) {
                $result .= '<input type="text" name="title_'.$lang['langue'].'" value="'.$this->getPageTitle($page['id_page'], $lang['id']).'"><br>';
            }
            $result .= '</div>';
            $result .= '<div class="three columns text-right"><a href="#" class="tool" role="close_pop_box"><img src="imgs/bton_close.png" /></a></div></div>';
            $result .= '<div class="row"><div class="four columns">Template : ';
            $result .= $this->getSelectTemplate($page['id_template']);
            $result .= '</div>';
            $result .= '<div class="four columns">Catégorie : ';
            $result .= $this->getSelectCat($page['id_cat']);
            $result .= '</div>';
            $result .= '<div class="four mobile-one columns text-right"><input type="submit" name="maj_page" value="Mettre à jour">';
            $result .= '<input type="hidden" name="id_page" value="'.$page['id_page'].'"></div></div>';
            
            $result .= '</form>';
            $result .= '</div>';
            //Del box
            $result .= '<div class="pop-box" id="del_'.$page['id_page'].'">Etes-vous sûre de vouloir supprimer cette page ? <a href="#" class="tool" role="del_page" alt="'.$page['id_page'].'">OUI</a> / <a href="#" class="tool" role="close_pop_box">NON</a></div>';
            $result .= '</li>';
        }
        $result .= '</ul>';
        return $result;
    }

    public function getLayoutOptions() {
        $result = '<ul class="unsortable" alt="lst_options">';
        foreach($this->getLstOptionsCat() as $categorie) {
            $result .= '<li role="'.$categorie['id'].'" style="font-weight:bold;background:none;border:none;">'.$categorie['categorie'].'</li>';
            if($this->getLstOptionsByCat($categorie['id'])) {
                foreach($this->getLstOptionsByCat($categorie['id']) as $option) {
                    $result .= '<li role="'.$option['id'].'#"><div class="row">';
                    $result .= '<div class="eight mobile-one columns">'.$option['descriptif'].'</div>';
                    if($option['type'] == 'boolean') {
                        $result .= '<div class="four mobile-one columns">'.$this->getMasterSwitch($option['id'], $option['value'], 'option').'</div>';
                    }
                    else {
                        $result .= '<div class="four mobile-one columns"><input type="text" class="field-option-value" id="option-'.$option['id'].'" alt="'.$option['id'].'" value="'.$option['value'].'"></div>';
                    }
                    $result .= '</div>';
                    $result .= '</li>';
                }
            }
        }
        $result .= '</ul>';
        return $result;
    }

    public function getLayoutLangues() {
        $result = '<ul class="unsortable" alt="lst_options">';
        foreach($this->getLstLang() as $lang) {
            $result .= '<li role="'.$lang['id'].'#"><div class="row">';
            $result .= '<div class="four mobile-one columns">'.$lang['langue_txt'].'</div>';
            $result .= '<div class="four mobile-one columns">URL : '.$lang['langue'].'</div>';
            $result .= '<div class="four mobile-one columns text-right"><img src="imgs/bton_del.png" class="tool" role="open_del_box" alt="'.$lang['id'].'"></div>';
            $result .= '</div>';
            //Supprimer une langue
            $result .= '<div class="row pop-box" id="del_'.$lang['id'].'">';
            $result .= '<div class="twelve columns">Etes-vous sûre de vouloir supprimer cette langue ? Toutes les traductions seront supprimées.
                            <a href="#" class="tool" role="del-langue" alt="'.$lang['id'].'">OUI</a> / <a href="#" class="tool" role="close_pop_box">NON</a>
                        </div>';
            $result .= '</div>';
            $result .= '</li>';
        }
        $result .= '<li class="no_drag"><div class="row">';
        $result .= '<div class="twelve mobile-four columns"><a href="#" class="tool" role="open-add-lang"><img src="imgs/bton_add.png"></a></div>';
        $result .= '</div></li>';

        //Ajouter une langue
        $result .= '<li class="pop-box no_drag" id="add_lang"><div class="row">';
        $result .= '<form name="form_add_lang" action="dashboard.php?module='.$_SESSION['module'].'&page=gestion&gerer=langues" method="POST" enctype="multipart/form-data">';
        $result .= '<div class="three columns"><input type="text" name="langue_txt" placeholder="Langue (Français)"></div>';
        $result .= '<div class="three columns"><input type="text" name="langue" placeholder="Avreviation (fr)"></div>';
        $result .= '<div class="three columns"><input type="submit" name="add_lang" value="Ajouter"></div>';
        $result .= '<div class="three columns text-right"><a href="#" class="tool" role="close_pop_box"><img src="imgs/bton_close.png" /></a></div>';
        $result .= '</form></div></li>';

        $result .= '</ul>';
        return $result;
    }

    public function getLayoutUsers() {
        $result = '<ul class="unsortable" alt="lst_users">';
        //HEADER
        $result .= '<li style="background:#404040;color:#fff;"><div class="row">';
        $result .= '<div class="three columns"><strong>Login</strong></div>';
        $result .= '<div class="two columns"><strong>User name</strong></div>';
        $result .= '<div class="three columns"><strong>E-mail</strong></div>';
        $result .= '<div class="three columns"><strong>Fonction</strong></div>';
        $result .= '<div class="one columns">&nbsp;</div>';
        $result .= '</li>';
        foreach($this->getLstUsers() as $user) {
            $result .= '<li role="'.$user['id'].'"><div class="row">';
            $result .= '<div class="three columns"><strong>'.$user['login'].'</strong></div>';
            $result .= '<div class="two columns">'.$user['user_name'].'</div>';
            $result .= '<div class="three columns"><a href="mailto:'.$user['email'].'">'.$user['email'].'</a></div>';
            $result .= '<div class="three columns">'.$this->getUserLvlTxt($user['user_level']).'</div>';
            $result .= '<div class="one columns"><img src="imgs/bton_del.png" class="tool" role="open_del_box" alt="'.$user['id'].'"></div>';
            $result .= '</div>';
            //Supprimer une langue
            $result .= '<div class="row pop-box" id="del_'.$user['id'].'">';
            $result .= '<div class="twelve columns">Etes-vous sûre de vouloir supprimer cet utilisateur ?
                            <a href="#" class="tool" role="del-user" alt="'.$user['id'].'">OUI</a> / <a href="#" class="tool" role="close_pop_box">NON</a>
                        </div>';
            $result .= '</div>';

            $result .= '</li>';
        }
        $result .= '<li class="no_drag"><div class="row">';
        $result .= '<div class="twelve mobile-four columns"><a href="#" class="tool" role="open-add-user"><img src="imgs/bton_add.png"></a></div>';
        $result .= '</div></li>';

        //Ajouter une langue
        $result .= '<li class="pop-box no_drag" id="add_user"><div class="row">';
        $result .= '<form name="form_add_user" action="dashboard.php?module='.$_SESSION['module'].'&page=gestion&gerer=users" method="POST" enctype="multipart/form-data">';
        $result .= '<div class="twelve columns text-right"><a href="#" class="tool" role="close_pop_box"><img src="imgs/bton_close.png" /></a></div>';
        $result .= '<div class="two columns"><input type="text" name="login" placeholder="Login"></div>';
        $result .= '<div class="two columns"><input type="password" name="password" placeholder="Password"></div>';
        $result .= '<div class="two columns"><input type="text" name="user_name" placeholder="User name"></div>';            
        $result .= '<div class="two columns"><input type="text" name="email" placeholder="E-mail"></div>';
        $result .= '<div class="two columns">
                        <select name="user_level">
                            <option value="1" selected>Administrateur</option>
                            <option value="2">Utilisateur</option>
                        </select>
                    </div>';
        $result .= '<div class="two columns"><input type="submit" name="add_user" value="Ajouter"></div>';            
        $result .= '</form></div></li>';

        $result .= '</ul>';
        return $result;
    }

    private function getUserLvlTxt($lvl) {
        if($lvl == '1') {
            $result = 'Administrateur';
        }
        else {
            $result = 'Utilisateur';
        }
        return $result;
    }

    private function getLstUsers() {
        $query = "SELECT * FROM cms_users";
        return $this->executeExternalQuery($query);
    }

    private function getLstOptionsCat() {
        $query = "SELECT * FROM cms_categories_options ORDER BY categorie ASC";
        return $this->executeExternalQuery($query);
    }

    private function getLstOptionsByCat($id) {
        $query = "SELECT id, descriptif, value, type FROM cms_global_options WHERE id_categorie='".$id."' ORDER BY descriptif ASC";
        return $this->executeExternalQuery($query);
    }

    private function getPageTitle($idpage, $lang) {
        $query = mysql_query("SELECT title FROM trad_pages WHERE id_page='".$idpage."' AND id_lang='".$lang."'");
        return $result = mysql_result($query, 0);
    }

    private function getLstPages($cat='all') {
        if($cat == 'all') {
        $query = "SELECT lay_pages.id AS id_page, id_cat, page_name, active, title, id_template
                    FROM lay_pages
                    INNER JOIN trad_pages ON trad_pages.id_page = lay_pages.id
                    WHERE trad_pages.id_lang = '1'
                    ORDER BY page_name ASC";
        }
        else {
            $query = "SELECT lay_pages.id AS id_page, id_cat, page_name, active, title, id_template
                    FROM lay_pages
                    INNER JOIN trad_pages ON trad_pages.id_page = lay_pages.id
                    WHERE trad_pages.id_lang = '1' AND id_cat = '".$cat."'
                    ORDER BY page_name ASC";
        }
        return $result = $this->executeExternalQuery($query);
    }

    public function addNewPages($array_values) {
        return $result = $this->insertIntoTable('lay_pages', $array_values);
    }

    public function addNewTradPages($array_values) {
        foreach($array_values as $values) {
            $submit = array($values['0'], $values['1'], $values['2']);
            $this->insertIntoTable('trad_pages', $submit);
        }
    }

    public function getMasterSwitch($id, $state, $item) {
        $div_id = $item.'_'.$id;

        $result = '<div class="master-switch-content" id="'.$div_id.'">';
        if($state == '1') {
            $result .= '<div class="master-switch active" id="'.$id.'" alt="0" role="'.$item.'"></div>';
        }
        else {
            $result .= '<div class="master-switch" id="'.$id.'" alt="1" role="'.$item.'"></div>';
        }
        $result .= '</div>';

        return $result;
    }
    
    public function reqGetCat($sub_level = '0') {
        $query = "SELECT c.id, c.id_parent, c.cat_name, c.sort, c.active, tc.id AS id_trad, tc.id_categorie, tc.id_lang, tc.title
                    FROM lay_categories c
                    INNER JOIN trad_categories tc
                    ON c.id=tc.id_categorie
                    WHERE id_parent='".$sub_level."'
                    AND tc.id_lang='1'
                    ORDER BY sort ASC";
        return $result = $this->executeExternalQuery($query);
    }
    
    public function getLayoutCats() {
        $result  = '<ul class="unsortable">';
        //HEADER
        $result .= '<li class="no_drag" style="background:#404040;color:#fff;"><div class="row">';
        $result .= '<div class="eight columns"><strong>Catégorie</strong></div>';
        $result .= '<div class="one columns text-center">Ajouter</div>';
        $result .= '<div class="one columns text-center">Editer</div>';
        $result .= '<div class="one columns text-center">Activer</div>';
        $result .= '<div class="one columns text-center">Supprimer</div>';
        $result .= '</div></li>';
        
        //Listing Main menus
        if($this->reqGetCat()) {
            foreach($this->reqGetCat() as $cat) {
                $result .= '<li role="'.$cat['id'].'#"><div class="row">';
                $result .= '<div class="eight mobile-one columns"><strong>'.$cat['title'].'</strong></div>';
                $result .= '<div class="one mobile-one columns text-center"><img src="imgs/bton_add.png" class="tool" role="open-add-sub-cat" alt="'.$cat['id'].'"></div>';
                $result .= '<div class="one mobile-one columns text-center"><img src="imgs/bton_edit.png" class="tool" role="open_edit_box" alt="'.$cat['id'].'"></div>';
                $result .= '<div class="one mobile-one columns text-center">'.$this->getMasterSwitch($cat['id'], $cat['active'], 'categories').'</div>';
                $result .= '<div class="one mobile-one columns text-center"><img src="imgs/bton_del.png" class="tool" role="open_del_box" alt="'.$cat['id'].'"></div>';
                $result .= '</div>';
                //Ajouter une sous-categorie
                $result .= $this->getFormAddCat('sub', $cat['id']);
                //editer une categorie
                $result .= $this->getFormEditCat($cat['id'], $cat['title']);
                //Supprimer un menu
                $result .= $this->getFormDelCat($cat['id']);                

                $result .= '</li>';
                
                //Listing sous-catégories
                $result .= $this->getSubCat($cat['id']);
            }
        }
        
        $result .= '<li class="no_drag"><div class="row">';
        $result .= '<div class="twelve mobile-four columns"><a href="#" class="tool" role="open-add-cat"><img src="imgs/bton_add.png"></a></div>';
        $result .= '</div></li>';
        
        //Ajouter une catégorie
        $result .= $this->getFormAddCat('main');
         
        $result .= '</ul>';
        return $result;
    }
    
    private function getSubCat($id, $padding = '40') {
        if($this->reqGetCat($id)) {
            $result  = '<ul class="unsortable">';
            foreach($this->reqGetCat($id) as $cat) {
                $result .= '<li role="'.$cat['id'].'#" class="sub-li" alt="'.$id.'"><div class="row">';
                $result .= '<div class="eight mobile-one columns" style="padding-left:'.$padding.'px;"><strong>'.$cat['cat_name'].'</strong></div>';
                $result .= '<div class="one mobile-one columns text-center"><img src="imgs/bton_add.png" class="tool" role="open-add-sub-cat" alt="'.$cat['id'].'"></div>';
                $result .= '<div class="one mobile-one columns text-center"><img src="imgs/bton_edit.png" class="tool" role="open_edit_box" alt="'.$cat['id'].'"></div>';
                $result .= '<div class="one mobile-one columns text-center">'.$this->getMasterSwitch($cat['id'], $cat['active'], 'mainmenu').'</div>';
                $result .= '<div class="one mobile-one columns text-center"><img src="imgs/bton_del.png" class="tool" role="open_del_box" alt="'.$cat['id'].'"></div>';
                $result .= '</div>';
                //Ajouter une sous-categorie
                $result .= $this->getFormAddCat('sub', $cat['id']);
                //editer une categorie
                $result .= $this->getFormEditCat($cat['id'], $cat['cat_name']);
                //Supprimer un menu
                $result .= $this->getFormDelCat($cat['id']);
                
                $result .= '</li>';
                
                //Récursivité
                $subpadding = $padding + 40;
                $result .= $this->getSubCat($cat['id'], $subpadding);
            }
            $result .= '</ul>';
        }
        else {
            $result = FALSE;
        }
        return $result;
    }
    
    
    private function getCatTitle($idcat, $lang) {
        $query = mysql_query("SELECT title FROM trad_categories WHERE id_categorie='".$idcat."' AND id_lang='".$lang."'");
        return $result = mysql_result($query, 0);
    }
    
    private function getFormAddCat($type, $id='NULL') {
        if($type == 'main') {
            $result  = '<li class="pop-box no_drag" id="add_cat"><div class="row">';
            $result .= '<form name="form_add_cat" action="dashboard.php?module='.$_SESSION['module'].'&page=gestion&gerer=categories" method="POST" enctype="multipart/form-data">';
            $result .= '<input type="hidden" name="id_parent" value="0">';
        }
        else {
            $result  = '<li class="pop-box no_drag" id="add_cat_'.$id.'"><div class="row">';
            $result .= '<form name="form_add_cat" action="dashboard.php??module='.$_SESSION['module'].'&page=gestion&gerer=categories" method="POST" enctype="multipart/form-data">';
            $result .= '<input type="hidden" name="id_parent" value="'.$id.'">';
        }
        $result .= '<div class="six columns">';
        
        foreach ($this->getLstLang() as $lang) {
                $result .= '<input type="text" name="title_'.$lang['langue'].'" placeholder="Nom de la catégorie '.$lang["langue"].'">';
        }

        $result .= '</div>';
        $result .= '<div class="one mobile-two columns">
                        <input type="submit" name="add_cat" value="Ajouter">
                    </div>';
        $result .= '<div class="four columns hide-for-small">&nbsp;</div>';
        $result .= '<div class="one mobile-two columns"><a href="#" class="tool" role="close_pop_box"><img src="imgs/bton_close.png" /></a></div>';
        $result .= '</form></div></li>';

        return $result;
    }
    
    private function getFormEditCat($id, $value) {
        $result  = '<li class="pop-box" id="edit_'.$id.'"><div class="row">';
        $result .= '<form name="form_edit_cat" action="dashboard.php?module='.$_SESSION['module'].'&page=gestion&gerer=categories" method="POST" enctype="multipart/form-data">';
        $result .= '<div class="six columns end">';
        
        foreach ($this->getLstLang() as $lang) {
                $result .= '<input type="text" name="title_'.$lang['langue'].'" value="'.$this->getCatTitle($id, $lang['id']).'">';
        }
        
        $result .= '</div>';
        
        $result .= '<div class="one mobile-two columns">
                        <input type="submit" name="edit-cat" value="Mettre à jour">
                        <input type="hidden" name="id_cat" value="'.$id.'"></div>';
        $result .= '<div class="four columns hide-for-small">&nbsp;</div>';
        $result .= '<div class="one mobile-two columns"><a href="#" class="tool" role="close_pop_box"><img src="imgs/bton_close.png" /></a></div>';
        $result .= '</form></div></li>';

        return $result;
    }
    
    private function getFormDelCat($id) {
        $result  = '<li class="pop-box" id="del_'.$id.'"><div class="row">';
        $result .= '<div class="twelve columns">
                        Etes-vous sûre de vouloir supprimer cette catégorie et les sous-catégories liées ?
                        <a href="#" class="tool" role="del-cat" alt="'.$id.'">OUI</a>
                        &nbsp;|&nbsp;
                        <a href="#" class="tool" role="close_pop_box">NON</a>
                    </div>';
        $result .= '</div></li>';

        return $result;
    }

    
    public function addNewCategories($array_values) {
        return $result = $this->insertIntoTable('lay_categories', $array_values);
    }
    
    public function addNewTradCategories($array_values) {
        foreach($array_values as $values) {
            $submit = array($values['0'], $values['1'], $values['2']);
            $this->insertIntoTable('trad_categories', $submit);
        }
    }
    
    public function getLayoutMainMenu() {
         $result = '<ul class="sortable" alt="0">';
         //HEADER
         $result .= '<li class="no_drag" style="background:#404040;color:#fff;"><div class="row">';
         $result .= '<div class="three mobile-one columns"><strong>Menu</strong></div>';
         $result .= '<div class="two columns hide-for-small"><em>URL</em></div>';
         $result .= '<div class="three columns hide-for-small">Page liée</div>';
         $result .= '<div class="one mobile-one columns text-center">Editer</div>';
         $result .= '<div class="one mobile-one columns text-center">Lien</div>';
         $result .= '<div class="one mobile-one columns text-center">Activer</div>';
         $result .= '<div class="one mobile-one columns text-center">Supprimer</div>';
         $result .= '</div></li>';

         //Listing Main menus
         if($this->reqGetMenu()) {
            foreach($this->reqGetMenu() as $mnu) {                 
                $result .= '<li role="'.$mnu['id_menu'].'#"><div class="row">';
                $result .= '<div class="three mobile-one columns"><strong>'.$mnu['menu_name'].'</strong></div>';
                $result .= '<div class="two columns hide-for-small"><em>'.$mnu['url'].'</em></div>';
                $result .= '<div class="three columns hide-for-small"><img src="imgs/ico_link.png">&nbsp;'.$this->getPageNameById($mnu['id_page']).'</div>';
                $result .= '<div class="one mobile-one columns text-center"><img src="imgs/bton_edit.png" class="tool" role="open_edit_box" alt="'.$mnu['id_menu'].'"></div>';
                $result .= '<div class="one mobile-one columns text-center"><img src="imgs/bton_share.png" class="tool" role="open_link_box" alt="'.$mnu['id_menu'].'"></div>';
                $result .= '<div class="one mobile-one columns text-center">'.$this->getMasterSwitch($mnu['id_menu'], $mnu['active'], 'mainmenu').'</div>';
                $result .= '<div class="one mobile-one columns text-center"><img src="imgs/bton_del.png" class="tool" role="open_del_box" alt="'.$mnu['id_menu'].'"></div>';
                $result .= '</div>';
                //Supprimer un menu
                $result .= $this->getFormDelMenu($mnu['id_menu']);
                //editer un menu
                $result .= $this->getFormEditMenu($mnu['id_menu'], $mnu['id_page']);
                //Lier un menu
                $result .= $this->getFormLinkMenu($mnu['id_menu'], $mnu['id_page']);

                $result .= '</li>';

                //Listing Sub-menus
                if($this->checkIfFlyout($mnu['id_menu'])) {
                    $result .= '<ul class="sortable" alt="'.$mnu['id_menu'].'">';
                    foreach($this->reqGetMenu($mnu['id_menu']) as $submnu) {

                        $result .= '<li role="'.$submnu['id_menu'].'#" class="sub-li" alt="'.$mnu['id_menu'].'"><div class="row">';
                        $result .= '<div class="one columns hide-for-small">&nbsp;</div>';
                        $result .= '<div class="two mobile-one columns"><strong>'.$submnu['menu_name'].'</strong></div>';
                        $result .= '<div class="two columns hide-for-small"><em>'.$submnu['url'].'</em></div>';
                        $result .= '<div class="three columns hide-for-small"><img src="imgs/ico_link.png">&nbsp;'.$this->getPageNameById($submnu['id_page']).'</div>';
                        $result .= '<div class="one mobile-one columns text-center"><img src="imgs/bton_edit.png" class="tool" role="open_edit_box" alt="'.$submnu['id_menu'].'"></div>';
                        $result .= '<div class="one mobile-one columns text-center"><img src="imgs/bton_share.png" class="tool" role="open_link_box" alt="'.$submnu['id_menu'].'"></div>';
                        $result .= '<div class="one mobile-one columns text-center">'.$this->getMasterSwitch($submnu['id_menu'], $submnu['active'], 'mainmenu').'</div>';
                        $result .= '<div class="one mobile-one columns text-center"><img src="imgs/bton_del.png" class="tool" role="open_del_box" alt="'.$submnu['id_menu'].'"></div>';
                        $result .= '</div>';
                        //Supprimer un sous-menu
                        $result .= $this->getFormDelMenu($submnu['id_menu']);
                        //editer un sous-menu
                        $result .= $this->getFormEditMenu($submnu['id_menu'], $submnu['id_page']);
                        //Lier un menu
                        $result .= $this->getFormLinkMenu($submnu['id_menu'], $submnu['id_page']);

                        $result .= '</li>';
                    }
                    $result .= '</ul>';
                }
                //Ajouter un sous-menu
                $result .= $this->getFormAddMenu('sub', $mnu['id_menu']);

                $result .= '<li class="sub-li no_drag"><div class="row">';
                $result .= '<div class="one columns hide-for-small">&nbsp;</div>';
                $result .= '<div class="eleven mobile-four columns"><a href="#" class="tool" role="open-add-sub-menu" alt="'.$mnu['id_menu'].'"><img src="imgs/bton_add.png"></a></div>';
                $result .= '</div></li>';                    
            }
         }

         $result .= '<li class="no_drag"><div class="row">';
         $result .= '<div class="twelve mobile-four columns"><a href="#" class="tool" role="open-add-menu"><img src="imgs/bton_add.png"></a></div>';
         $result .= '</div></li>';

         //Ajouter un menu
         $result .= $this->getFormAddMenu('menu');

         $result .= '</ul>';

         return $result;
    }
    
   
    private function getFormDelMenu($id) {
        $result  = '<div class="row pop-box" id="del_'.$id.'">';
        $result .= '<div class="twelve columns">Etes-vous sûre de vouloir supprimer ce menu ?
                    <a href="#" class="tool" role="del-mainmenu" alt="'.$id.'">OUI</a> / <a href="#" class="tool" role="close_pop_box">NON</a></div>';
        $result .= '</div>';
        return $result;
    }

    private function getFormAddMenu($type, $id='NULL') {
        if($type == 'menu') {
            $result  = '<li class="pop-box no_drag" id="add_menu"><div class="row">';
            $result .= '<form name="form_add_sub-menu" action="dashboard.php?module='.$_SESSION['module'].'&page=gestion&gerer=mainmenu" method="POST" enctype="multipart/form-data">';
            $result .= '<input type="hidden" name="id_parent" value="0">';
        }
        else {
            $result  = '<li class="pop-box no_drag" id="add_sub_'.$id.'"><div class="row">';
            $result .= '<form name="form_add_sub-menu" action="dashboard.php?module='.$_SESSION['module'].'&page=gestion&gerer=mainmenu" method="POST" enctype="multipart/form-data">';
            $result .= '<input type="hidden" name="id_parent" value="'.$id.'">';
        }
        $result .= '<div class="three mobile-four columns">';
        $result .= $this->getInputFieldsNameByLang($id);
        $result .= '</div>';
        $result .= '<div class="three mobile-four columns">';
        $result .= $this->getInputFieldsURLByLang($id);
        $result .= '</div>';
        $result .= '<div class="three mobile-four columns">'.$this->getPageSelect().'</div>';
        $result .= '<div class="one mobile-two columns">
                        <input type="submit" name="add-menu" value="Ajouter">
                    </div>';
        $result .= '<div class="one columns hide-for-small">&nbsp;</div>';
        $result .= '<div class="one mobile-two columns"><a href="#" class="tool" role="close_pop_box"><img src="imgs/bton_close.png" /></a></div>';
        $result .= '</form></div></li>';

        return $result;
    }

    private function getFormEditMenu($id, $idpage) {
        $result  = '<div class="row pop-box" id="edit_'.$id.'">';
        $result .= '<div class="twelve columns">';
        $result .= '<form name="form_add_sub-menu" action="dashboard.php?module='.$_SESSION['module'].'&page=gestion&gerer=pages" method="POST" enctype="multipart/form-data">';
        $result .= '<div class="three mobile-four columns">';
        $result .= $this->getInputFieldsNameByLang($id, 'edit');
        $result .= '</div>';
        $result .= '<div class="three mobile-four columns">';
        $result .= $this->getInputFieldsURLByLang($id, 'edit');
        $result .= '</div>';
        $result .= '<div class="three mobile-four columns">'.$this->getPageSelect($idpage, $this->getPageNameById($idpage)).'</div>';
        $result .= '<div class="one mobile-two columns">
                        <input type="submit" name="edit-menu" value="Mettre à jour">
                        <input type="hidden" name="id_menu" value="'.$id.'"></div>';
        $result .= '<div class="one columns hide-for-small">&nbsp;</div>';
        $result .= '<div class="one mobile-two columns"><a href="#" class="tool" role="close_pop_box"><img src="imgs/bton_close.png" /></a></div>';
        $result .= '</form></div>';                
        $result .= '</div>';

        return $result;
    }

    private function getInputFieldsNameByLang($id, $func='add') {
        $result = '';
        foreach($this->getLstLang() as $lang) {
            if($func == 'add') {
                $result .= '<input type="text" name="menu_name_'.$lang['langue'].'" class="field_menu_name" alt="'.$lang['langue'].'" placeholder="Nom '.$lang['langue'].'">';
            }
            else {
                $result .= '<input type="text" name="menu_name_'.$lang['langue'].'" class="field_menu_name" alt="'.$lang['langue'].'" value="'.$this->getMenuNamesById($id, $lang['id']).'" placeholder="Nom '.$lang['langue'].'">';
            }
        }
        return $result;
    }

    private function getInputFieldsURLByLang($id, $func='add') {
        $result = '';
        foreach($this->getLstLang() as $lang) {
            if($func == 'add') {
                $result .= '<input type="text" name="url_'.$lang['langue'].'" id="url_'.$lang['langue'].'" placeholder="URL '.$lang['langue'].'">';
            }
            else {
                $result .= '<input type="text" name="url_'.$lang['langue'].'" id="url_'.$lang['langue'].'" value="'.$this->getMenuURLById($id, $lang['id']).'" placeholder="URL '.$lang['langue'].'">';
            }
        }
        return $result;
    }

    public function getLstLang() {
        $query = "SELECT * FROM lay_langues";
        return $this->executeExternalQuery($query);
    }

    private function getFormLinkMenu($idmenu, $idpage) {
        $result  = '<div class="row pop-box" id="link_'.$idmenu.'">';
        $result .= '<form name="form_link_menu" action="dashboard.php?module='.$_SESSION['module'].'&page=gestion&gerer=pages" method="POST" enctype="multipart/form-data">';
        $result .= '<div class="three columns">Lier ce menu à la page : </div>';
        $result .= '<div class="three columns">'.$this->getPageSelect($idpage, $this->getPageNameById($idpage)).'</div>';
        $result .= '<div class="five columns"><input type="submit" name="link-menu" value="Mettre à jour"><input type="hidden" name="id_menu" value="'.$idmenu.'"></div>';
        $result .= '<div class="one columns"><a href="#" class="tool" role="close_pop_box"><img src="imgs/bton_close.png" /></a></div>';
        $result .= '</form>';
        $result .= '</div>';

        return $result;
    }

    private function getPageSelect($value='9999', $option='Sélectionnez une page') {
        $result = '<select name="id_page">';
        $result .= '<option value="'.$value.'" selected>'.$option.'</option>';
        $result .= '<option value="9999">Aucune page</option>';
        foreach($this->getLstPages() as $page) {
            $result .= '<option value="'.$page['id_page'].'">'.$page['page_name'].'</option>';
        }
        $result .= '</select>';
        return $result;
    }

    public function reqGetMenu($sub_level = '0') {
        $query = "SELECT lay_mainmenu.id AS id_menu, id_parent, id_page, menu_name, url, active
                    FROM lay_mainmenu
                    INNER JOIN trad_mainmenu ON trad_mainmenu.id_menu = lay_mainmenu.id
                    WHERE lay_mainmenu.id_parent='".$sub_level."' AND trad_mainmenu.id_lang='1'
                    ORDER BY lay_mainmenu.sort ASC";
        return $result = $this->executeExternalQuery($query);
    }

    public function getMenuParentId($id) {
        $query = mysql_query("SELECT id_parent FROM lay_mainmenu WHERE id='".$id."'");
        if(mysql_num_rows($query)) {
            return $result = mysql_result($query, 0);
        }
        else {
            return false;
        }

    }

    private function getMenuNamesById($id, $lang) {
        $query = mysql_query("SELECT menu_name FROM trad_mainmenu WHERE id_menu='".$id."' AND id_lang='".$lang."'");
        return $result = mysql_result($query, 0);
    }

    private function getMenuURLById($id, $lang) {
        $query = mysql_query("SELECT url FROM trad_mainmenu WHERE id_menu='".$id."' AND id_lang='".$lang."'");
        return $result = mysql_result($query, 0);
    }

    public function resortMainMenu($id_parent) {
        $query = mysql_query("SELECT * FROM lay_mainmenu WHERE id_parent='".$id_parent."' ORDER BY sort ASC");
        $data = mysql_fetch_array($query);
        $sort = 1;
        do {
            mysql_query("UPDATE lay_mainmenu SET sort='".$sort."' WHERE id='".$data['id']."'");
            $sort++;
        } while($data = mysql_fetch_array($query));
    }

    public function getPageNameById($idpage) {
        $query = mysql_query("SELECT page_name FROM lay_pages WHERE id='".$idpage."'");
        if(mysql_num_rows($query)) {
            return mysql_result($query, 0);
        }
        else {
            return '...';
        }
    }

    public function addNewMenu($array_values) {
        return $result = $this->insertIntoTable('lay_mainmenu', $array_values);
    }

    public function addNewTradMenu($array_values) {
        foreach($array_values as $values) {
            $submit = array($values['0'], $values['1'], $values['2'], $values['3']);
            $this->insertIntoTable('trad_mainmenu', $submit);
        }
    }

    public function getLastSortMenu($id_parent) {
        $query = mysql_query("SELECT sort FROM lay_mainmenu WHERE id_parent='".$id_parent."' ORDER BY sort DESC LIMIT 1");
        $last_num = mysql_result($query, 0);
        return $result = $last_num + 1;
    }
    
    public function getLastSortCat($id_parent) {
        $query = mysql_query("SELECT sort FROM lay_categories WHERE id_parent='".$id_parent."' ORDER BY sort DESC LIMIT 1");
        $last_num = mysql_result($query, 0);
        return $result = $last_num + 1;
    }

    private function checkIfFlyout($id_mnu) {
        $query = mysql_query("SELECT id_parent FROM lay_mainmenu WHERE id_parent='".$id_mnu."'");
        return mysql_num_rows($query);
    }

    public function cleanLstIds($lst_ids) {
        $search = array('undefined', 'no_use', 'NaN1', 'NaN2');
        $replace = array('', '', '', '');
        $string = str_replace($search, $replace, $lst_ids);
        //var_dump($string);
        $search = array('#');
        $replace = array(',');
        $string = str_replace($search, $replace, $string);
        //var_dump($string);
        $string = substr($string, 1, -1);
        //var_dump($string);

        return $result = explode(',', $string);
    }

    public function filterLstIds($lst_ids, $id_parent) {
        $result = array();
        foreach($lst_ids as $id) {
            $query = mysql_query("SELECT id FROM lay_mainmenu WHERE id='".$id."' AND id_parent='".$id_parent."'");
            if(mysql_num_rows($query)) {
                array_push($result, $id);
            }
        }
        return $result;
    }

    public function getSelectTemplate($current='all') {
        $result = '<select name="template">';
        if($current == 'all') {
            $result .= '<option value="all" selected>Sélectionnez un template</option>';
        }
        else {
            $result .= '<option value="'.$current.'" selected>'.$this->getCurrentTemplate($current).'</option>';
        }
        foreach($this->getLstTemplate() as $template) {
            $result .= '<option value="'.$template['id'].'">'.$template['file'].'</option>';
        }
        $result .= '</select>';
        return $result;
    }
    
    public function getSelectCat($current='all', $id='catxxxx') {
        $result = '<select name="categorie" id="'.$id.'">';
        if($current == 'all') {
            $result .= '<option value="all" selected>Sélectionnez une catégorie</option>';
        }
        else {
            $result .= '<option value="'.$current.'" selected>'.$this->getCatById($current).'</option>';
        }
        if($id != 'catxxxx') {
            $result .= '<option value="all">Toutes les pages</option>';
        }
        foreach($this->getLstCat() as $cat) {
            $result .= '<option value="'.$cat['id'].'">'.$cat['cat_name'].'</option>';
        }
        $result .= '</select>';
        return $result;
    }
    
    private function getLstCat() {
        $query = "SELECT * FROM lay_categories ORDER BY cat_name ASC";
        return $this->executeExternalQuery($query);
    }

    private function getLstTemplate() {
        $query = "SELECT * FROM lay_templates";
        return $this->executeExternalQuery($query);
    }

    private function getCurrentTemplate($id) {
        $query = mysql_query("SELECT file FROM lay_templates WHERE id='".$id."'");
        return mysql_result($query, 0);
    }
}
?>