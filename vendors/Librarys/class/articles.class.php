<?php
/*           
==================================================================
Fichier: articles.class.php                                
Description: Class de gestion des articles        
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

class Articles extends DB {
    /* ATTRIBUTES */
    private $_idpage;
    private $_lang;


    /* CONSTRUCTEUR */
    public function __construct() {
        parent::__construct();
    }

    /* GETTER */
    public function getIdPage()         { return $this->_idpage; }
    public function getLang()           { return $this->_lang; }
    
    /* SETTER */
    public function setIdPage($idpage)  { $this->_idpage = $idpage; }
    public function setLang($lang)      { $this->_lang = $lang; }
    
    /* INITTER */
    private function initMain() {
        require_once 'main.class.php';
        return new MAIN();
    }
    
    private function initLang() {
        require_once 'langues.class.php';
        return new Langues();
    }
    
    /* METHODES */
    public function buildingNewArticle() {
        if(!isset($_SESSION['new_article'])) {
            $this->initNewArticle();
        }
    }
    
    private function initNewArticle() {
        $_SESSION['new_article'] = array('slot0' => array());
    }

    public function buildArticles($data) {
        ob_start();
        foreach($data as $k => $art) {
            if($k == sizeof($lst_art)-1) {
                echo '<article class="col-xs-12">';
            }
            else {
                echo '<article class="col-xs-12 art-sep">';
            }
                echo '<h2>'.stripslashes($art->titre).'</h2>';
                echo stripslashes($art->article);
            echo '</article>';
        }
        ob_flush();
        ob_clean();
    }
    
    public function reqArticles() {
        try {
            $sql = "SELECT lay_articles.id AS id_article, titre, article
                    FROM lay_articles
                    INNER JOIN trad_articles ON trad_articles.id_article = lay_articles.id
                    WHERE trad_articles.id_lang='".$this->_lang."' AND lay_articles.id_page='".$this->_idpage."' AND lay_articles.active='1' AND trad_articles.active='1'
                    ORDER BY lay_articles.sort ASC";
            return $this->execQuery($sql);
        }
        catch (PDOException $e) {
            throw new PDOException($e);
        }
    }
}
?>