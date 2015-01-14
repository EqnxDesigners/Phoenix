<?php

class ARTICLES extends DB {

    public function getLayoutLstArticles($id_page = 'all', $id_cat = 'all') {
        if ($id_cat == 'all') {
            $listing = $this->getLstArticles($id_page);
        } else {
            $listing = $this->getLstArticlesByCat($id_cat);
        }
        if ($this->getLstArticles($id_page) || $this->getLstArticlesByCat($id_cat)) {
            if ($id_page == 'all') {
                $result = '<ul class="unsortable" alt="lst_articles">';
            } else {
                $result = '<ul class="sortable" alt="lst_articles">';
            }
            $result .= '<li class="no_drag" style="background:#404040;color:#fff;margin-top:12px;"><div class="row">';
            $result .= '<div class="four columns"><strong>Article</strong></div>';
            $result .= '<div class="two columns"><strong>Langues</strong></div>';
            $result .= '<div class="one columns"><strong>Publié</strong></div>';
            $result .= '<div class="one columns"><strong>Modifié</strong></div>';
            $result .= '<div class="one columns"><strong>Statut</strong></div>';
            $result .= '<div class="one columns">&nbsp;</div>';
            $result .= '<div class="one columns">&nbsp;</div>';
            $result .= '<div class="one columns">&nbsp;</div>';
            $result .= '</div></li>';
            foreach ($listing as $article) {
                $result .= '<li role="' . $article['id_article'] . '#"><div class="row">';
                $result .= '<div class="four columns"><strong>' . $article['titre'] . '</strong></div>';
                $result .= '<div class="two columns"><div id="switch-lang-' . $article['id_article'] . '">' . $this->getPublishedLang($article['id_article']) . '</div></div>';
                $result .= '<div class="one columns">' . $this->echoTiming($article['post_date']) . '</div>';
                $result .= '<div class="one columns">' . $this->echoTiming($article['modif_date']) . '</div>';
                $result .= '<div class="one columns">' . $this->getArticleStatut($article['active']) . '</div>';
                $result .= '<div class="one columns"><a href="?module=articles&page=edition&gerer=articles&id_art=' . $article['id_article'] . '" target="_self"><img src="imgs/bton_edit.png"></a></div>';
                $result .= '<div class="one columns">' . $this->getMasterSwitch($article['id_article'], $article['active'], 'article') . '</div>';
                $result .= '<div class="one columns"><img src="imgs/bton_del.png" class="sub-tool" role="open_del_box" alt="' . $article['id_article'] . '"></div>';
                $result .= '</div>';
                //Supprimer un menu
                $result .= '<div class="row pop-box" id="del_' . $article['id_article'] . '">';
                $result .= '<div class="twelve columns">Etes-vous sûre de vouloir supprimer cet article ? <a href="#" class="sub-tool" role="del-article" alt="' . $article['id_article'] . '">OUI</a> / <a href="#" class="tool" role="close_pop_box">NON</a></div>';
                $result .= '</div>';

                $result .= '</li>';
            }
            $result .= '</ul>';
        } else {
            $result = '<ul class="unsortable" alt="lst_articles">';
            $result .= '<li><div class="row">';
            $result .= '<div class="twelve columns">Aucun article...</div>';
            $result .= '</div></li>';
        }
        return $result;
    }

    private function echoTiming($time) {
        $split = explode(' ', $time);

        $split_date = explode('-', $split[0]);
        $date = $split_date[2] . '.' . $split_date[1] . '.' . $split_date[0];

        $split_heure = explode(':', $split[1]);
        $heure = 'à ' . $split_heure[0] . ':' . $split_heure[1];

        return $date . '<br>' . $heure;
    }

    public function getPublishedLang($id) {
        $result = '';

        foreach ($this->getLstLangues() as $lang) {
            if ($this->checkIfLangPublished($id, $lang['id'])) {
                if ($this->getLangStatut($id, $lang['id']) == '1') {
                    //$result .= '<div id="switch-'.$id.'-'.$lang['id'].'" style="float:left;">';
                    $result .= '<img src="imgs/bton_' . $this->getLangAbrev($lang['id']) . '.png" class="switch-lang" art="' . $id . '" lang="' . $lang['id'] . '" alt="0">';
                    //$result .= '</div>';
                } else {
                    //$result .= '<div id="switch-'.$id.'-'.$lang['id'].'" style="float:left;">';
                    $result .= '<img src="imgs/bton_' . $this->getLangAbrev($lang['id']) . '_off.png" class="switch-lang" art="' . $id . '" lang="' . $lang['id'] . '" alt="1">';
                    //$result .= '</div>';
                }
            }
        }
        return $result;
    }

    private function checkIfLangPublished($id, $idlang) {
        $query = mysql_query("SELECT id FROM trad_articles WHERE id_article='" . $id . "' AND id_lang='" . $idlang . "'");
        return mysql_num_rows($query);
    }

    private function getLangAbrev($id) {
        $query = mysql_query("SELECT langue FROM lay_langues WHERE id='" . $id . "'");
        return mysql_result($query, 0);
    }

    private function getLangStatut($idart, $idlang) {
        $query = mysql_query("SELECT active FROM trad_articles WHERE id_article='" . $idart . "' AND id_lang='" . $idlang . "'");
        return mysql_result($query, 0);
    }

    private function getArticleStatut($stat) {
        switch ($stat) {
            case '0':
                $result = 'Non visible';
                break;
            case '1':
                $result = 'Publié';
                break;
            case '2':
                $result = 'Enregistré';
                break;
        }
        return $result;
    }

    public function updateImgLink($html) {
        //$search = array('src=\"../medias/','src=\"../images/','&lt;','&gt;');
        $search = array('src="../medias/', 'src="../images/', '&lt;', '&gt;');
        $replace = array('src="medias/', 'src="images/', '<', '>');
        $result = str_replace($search, $replace, $html);

        return addslashes($result);
    }

    private function downgradeImgLink($html) {
        $search = array('src="medias/', 'src="images/');
        $replace = array('src="../medias/', 'src="../images/');

        return str_replace($search, $replace, $html);
    }

    public function getSelectPages($type = 'ajax', $current = 'all') {
        if ($type == 'ajax') {
            $result = '<select id="select-pages">';
            $result .= '<option value="all" selected>Sélectionnez une page</options>';
            $result .= '<option value="all">Toutes les pages</options>';
        } else {
            $result = '<select name="id_page" id="select-id-pages">';
            if ($current == 'all') {
                $result .= '<option value="all" selected>Sélectionnez une page</options>';
            } else {
                $result .= '<option value="' . $current . '" selected>' . $this->getPageNameById($current) . '</options>';
            }
        }
        foreach ($this->getLstPages() as $page) {
            $result .= '<option value="' . $page['id_page'] . '">' . $page['page_name'] . '</option>';
        }
        $result .= '</select>';
        return $result;
    }

    public function getSelectPagesFiltred($id) {
        $result = '<select id="select-pages">';
        $result .= '<option value="all" selected>Sélectionnez une page</options>';
        $result .= '<option value="allbycat" role="' . $id . '">Toutes les pages</options>';
        foreach ($this->getLstPagesByCat($id) as $page) {
            $result .= '<option value="' . $page['id_page'] . '">' . $page['page_name'] . '</option>';
        }
        $result .= '</select>';
        return $result;
    }

    public function getSelectLangues($current = '1', $idarticle = '999999999') {
        if ($idarticle == '999999999') {
            $result = '<select name="id_lang" id="select-id-lang" role="">';
        } else {
            $result = '<select name="id_lang" id="select-id-lang" role="' . $idarticle . '">';
        }
        $result .= '<option value="' . $current . '" selected>' . $this->getLangNameById($current) . '</options>';
        foreach ($this->getLstLangues() as $lang) {
            $result .= '<option value="' . $lang['id'] . '">' . $lang['langue_txt'] . '</option>';
        }
        $result .= '</select>';
        return $result;
    }

    private function getLstPages() {
        $query = "SELECT lay_pages.id AS id_page, page_name, active, title
                    FROM lay_pages
                    INNER JOIN trad_pages ON trad_pages.id_page = lay_pages.id
                    WHERE trad_pages.id_lang = '1'
                    ORDER BY page_name ASC";
        return $result = $this->executeExternalQuery($query);
    }

    public function getLstPagesByCat($id) {
        if ($id == 'all') {
            $query = "SELECT lay_pages.id AS id_page, page_name, active, title
                    FROM lay_pages
                    INNER JOIN trad_pages ON trad_pages.id_page = lay_pages.id
                    WHERE trad_pages.id_lang = '1'
                    ORDER BY page_name ASC";
        } else {
            $query = "SELECT lay_pages.id AS id_page, page_name, active, title
                    FROM lay_pages
                    INNER JOIN trad_pages ON trad_pages.id_page = lay_pages.id
                    WHERE trad_pages.id_lang = '1' AND id_cat='" . $id . "'
                    ORDER BY page_name ASC";
        }
        return $result = $this->executeExternalQuery($query);
    }

    private function getPageNameById($id) {
        $query = mysql_query("SELECT page_name FROM lay_pages WHERE id='" . $id . "'");
        return mysql_result($query, 0);
    }

    public function getLstLangues() {
        $query = "SELECT * FROM lay_langues";
        return $this->executeExternalQuery($query);
    }

    public function getLstInsertLang($id) {
        $query = "SELECT id FROM lay_langues WHERE id<>'" . $id . "'";
        return $this->executeExternalQuery($query);
    }

    private function getLangNameById($id) {
        $query = mysql_query("SELECT langue_txt FROM lay_langues WHERE id='" . $id . "'");
        return mysql_result($query, 0);
    }

    private function getLstArticles($id_page) {
        if ($id_page == 'all') {
            $query = "SELECT lay_articles.id AS id_article, id_page, post_date, modif_date, lay_articles.active AS active, trad_articles.active AS trad_active, titre, article 
                        FROM lay_articles
                        INNER JOIN trad_articles ON trad_articles.id_article = lay_articles.id
                        WHERE trad_articles.id_lang='1'
                        ORDER BY lay_articles.post_date ASC";
        } else {
            $query = "SELECT lay_articles.id AS id_article, id_page, post_date, modif_date, lay_articles.active AS active, trad_articles.active AS trad_active, titre, article 
                        FROM lay_articles
                        INNER JOIN trad_articles ON trad_articles.id_article = lay_articles.id
                        WHERE trad_articles.id_lang='1' AND lay_articles.id_page='" . $id_page . "'
                        ORDER BY lay_articles.sort ASC";
        }
        return $this->executeExternalQuery($query);
    }

    private function getLstArticlesByCat($id_cat) {
        $query = "SELECT lay_articles.id AS id_article, id_page, id_cat, post_date, modif_date, lay_articles.active AS active, trad_articles.active AS trad_active, titre, article 
                    FROM lay_articles
                    INNER JOIN lay_pages ON lay_pages.id = lay_articles.id_page
                    INNER JOIN trad_articles ON trad_articles.id_article = lay_articles.id
                    WHERE trad_articles.id_lang='1' AND lay_pages.id_cat='" . $id_cat . "'
                    ORDER BY lay_articles.post_date ASC";
        return $this->executeExternalQuery($query);
    }

    public function getLstMedias($type) {
        if ($type == '1') {
            $query = "SELECT file_url, file, id_media
                        FROM lib_medias
                        INNER JOIN lib_medias_adds ON lib_medias_adds.id_media = lib_medias.id
                        WHERE type='" . $type . "' AND id_format='99'
                        ORDER BY post_date DESC";
        } else {
            $query = "SELECT * FROM lib_medias WHERE type='" . $type . "' ORDER BY post_date DESC";
        }
        return $this->executeExternalQuery($query);
    }

    public function getLstMediasInterface($type) {
        if ($this->getLstMedias($type)) {
            $lst_medias = $this->getLstMedias($type);
            if ($type == '1') {
                $rows = ceil(count($lst_medias) / 4);
                $iter = 0;
                $result = '<table role="presentation" class="mce-grid">';
                for ($i = 0; $i < $rows; $i++) {
                    $result .= '<tr>';
                    for ($ii = 0; $ii < 4; $ii++) {
                        if ($iter < count($lst_medias)) {
                            $id_img = explode('.', $lst_medias[$iter]['file']);
                            $result .= '<td>
                                        <a href="#" data-mce-alt="' . $id_img['0'] . '" data-mce-url="../medias/images/' . $lst_medias[$iter]['file_url'] . '" tabindex="-1">
                                            <img src="../medias/images/' . $lst_medias[$iter]['file'] . '" style="width: 48px; height: 48px">
                                        </a>
                                        </td>';
                        } else {
                            $result .= '<td>&nbsp;</td>';
                        }
                        $iter++;
                    }
                    $result .= '</tr>';
                }
                $result .= '</table>';
            }

            if ($type == '2') {
                $rows = ceil(count($lst_medias) / 2);
                $iter = 0;
                $result = '<table role="presentation" class="mce-grid">';
                for ($i = 0; $i < $rows; $i++) {
                    $result .= '<tr>';
                    for ($ii = 0; $ii < 2; $ii++) {
                        if ($iter < count($lst_medias)) {
                            $result .= '<td><a href="#" data-mce-url="' . $this->getVideoYoutubeId($lst_medias[$iter]['file_url']) . '" tabindex="-1"><img src="http://i.ytimg.com/vi/' . $this->getVideoYoutubeId($lst_medias[$iter]['file_url']) . '/default.jpg" width="60" /></a></td>';
                        } else {
                            $result .= '<td>&nbsp;</td>';
                        }
                        $iter++;
                    }
                    $result .= '</tr>';
                }
                $result .= '</table>';
            }

            if ($type == '3') {
                $result = '<table role="presentation" class="mce-grid" cellpadding="2">';
                foreach ($lst_medias as $media) {
                    $result .= '<tr>';
                    $result .= '<td><a href="#" data-mce-url="medias/docs/' . $media['file_url'] . '" data-mce-file="' . $media['file_url'] . '" tabindex="-1">' . $media['file_url'] . '</a></td>';
                    $result .= '</tr>';
                }
                $result .= '</table>';
            }
        } else {
            $result = 'Acun médias';
        }
        return $result;
    }

    public function getVideoYoutubeId($url) {
        $split = explode("/", $url);
        return $split[count($split) - 1];
    }

    public function getArticleLastSort($idpage) {
        $query = mysql_query("SELECT sort FROM lay_articles WHERE id_page='" . $idpage . "' ORDER BY sort DESC LIMIT 1");
        if (mysql_num_rows($query)) {
            $result = mysql_result($query, 0) + 1;
        } else {
            $result = '1';
        }
        return $result;
    }

    public function checkIfArticleRecorded($id_article, $id_lang) {
        $query = mysql_query("SELECT * FROM trad_articles WHERE id_article='" . $id_article . "' AND id_lang='" . $id_lang . "'");
        return mysql_num_rows($query);
    }

    public function getFieldValue($value) {
        if (isset($_POST[$value])) {
            echo stripslashes($_POST[$value]);
        }
    }

    public function getArticleContent() {
        if (isset($_POST['article'])) {
            $_POST['article'] = $this->downgradeImgLink($_POST['article']);
            echo $_POST['article'];
        }
    }

    public function getArticleValue($idarticle, $idlang, $field) {
        $query = mysql_query("SELECT " . $field . " FROM trad_articles WHERE id_article='" . $idarticle . "' AND id_lang='" . $idlang . "'");
        $result = stripslashes(mysql_result($query, 0));
        if ($field == 'article') {
            $result = stripslashes($this->downgradeImgLink($result));
        }

        return $result;
    }

    public function getMasterSwitch($id, $state, $item) {
        $div_id = $item . '_' . $id;

        $result = '<div class="master-switch-content" id="' . $div_id . '">';
        if ($state == '1') {
            $result .= '<div class="master-switch active" id="' . $id . '" alt="0" role="' . $item . '"></div>';
        } else {
            $result .= '<div class="master-switch" id="' . $id . '" alt="1" role="' . $item . '"></div>';
        }
        $result .= '</div>';

        return $result;
    }

    public function cleanLstIds($lst_ids) {
        $search = array('undefined', 'no_use', 'NaN');
        $replace = array('', '', '');
        $string = str_replace($search, $replace, $lst_ids);
        $search = array('#');
        $replace = array(',');
        $string = str_replace($search, $replace, $string);
        $string = substr($string, 0, -1);

        return $result = explode(',', $string);
    }

    public function getSelectCat($current = 'all', $id = 'catxxxx') {
        $result = '<select name="categorie" id="' . $id . '">';
        if ($current == 'all') {
            $result .= '<option value="all" selected>Sélectionnez une catégorie</option>';
        } else {
            $result .= '<option value="' . $current . '" selected>' . $this->getCatById($current) . '</option>';
        }
        if ($id != 'catxxxx') {
            $result .= '<option value="all">Toutes les catégories</option>';
        }
        foreach ($this->getLstCat() as $cat) {
            $result .= '<option value="' . $cat['id'] . '">' . $cat['cat_name'] . '</option>';
        }
        $result .= '</select>';
        return $result;
    }

    private function getLstCat() {
        $query = "SELECT * FROM lay_categories ORDER BY sort ASC";
        return $this->executeExternalQuery($query);
    }

    private function getCatById($id) {
        $query = mysql_query("SELECT cat_name FROM lay_categories WHERE id='" . $id . "'");
        if (mysql_num_rows($query)) {
            $result = mysql_result($query, 0);
        } else {
            $result = 'Non définie';
        }
        return $result;
    }

    public function checkIfMultiLang() {
        $query = mysql_query("SELECT value FROM cms_global_options WHERE ref='multi-lang'");
        return mysql_result($query, 0) == 1;
    }

    public function getIdPageFromArt($id) {
        $query = mysql_query("SELECT id_page FROM lay_articles WHERE id='" . $id . "'");
        return mysql_result($query, 0);
    }

    public function buildArtPreview($idart) {
        ob_start();
        if ($this->getPrevArticles($idart)) {
            foreach ($this->getPrevArticles($idart) as $article) {
                echo '<article class="twelve mobile-four columns">';
                echo '<h2>' . stripslashes($article['titre']) . '</h2>';
                echo $this->downgradeImgLink(stripslashes($article['article']));
                echo '</article>';
            }
        } else {
            echo '...';
        }
        ob_flush();
        ob_clean();
    }

    public function getPrevArticles($idart) {
        $query = "SELECT lay_articles.id AS id_article, titre, article
                    FROM lay_articles
                    INNER JOIN trad_articles ON trad_articles.id_article = lay_articles.id
                    WHERE trad_articles.id_lang='1' AND lay_articles.id='" . $idart . "'
                    ORDER BY lay_articles.sort ASC";
        return $this->executeExternalQuery($query);
    }

}

?>