<?php
/*           
==================================================================
Fichier: slideshow.class.php                                
Description: Class de gestion des slideshows                     
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

class Slideshow extends DB {
    /* ATTRIBUTES */
    private $_title;
    private $_bullets;
    private $_nav;
    
    /* CONSTRUCTEUR */
    public function __construct($title, $bullets, $nav) {
        parent::__construct();
        
        $this->setTitle($title);
        $this->setBullets($bullets);
        $this->setNav($nav);
    }
    
    /* GETTER */
    public function getTitle()              { return $this->_title; }
    public function getBullets()            { return $this->_bullets; }
    public function getNav()                { return $this->_nav; }
    
    /* SETTER */
    public function setTitle($title)        { $this->_title = $title; }
    public function setBullets($bullets)    { $this->_bullets = $bullets; }
    public function setNav($nav)            { $this->_nav = $nav; }
    
    /* METHODES */
    public function buildSlide($data) {
        $result = '';
        
        if($this->_bullets) {
            $result .= '<ol class="carousel-indicators">';
            foreach($lst_files as $k => $img) {
                if($k == 0) {
                    $result .= '<li data-target="#home-slide" data-slide-to="'.$k.'" class="active"></li>';
                }
                else {
                    $result .= '<li data-target="#home-slide" data-slide-to="'.$k.'" class=""></li>';
                }
            }
            $result .= '</ol>';
        }

        $result .= '<div class="carousel-inner">';
        foreach($data as $k => $img) {
            if($k == 0) {
                $result .= '<div class="item active">';
            }
            else {
                $result .= '<div class="item">';
            }
            $result .= '<img src="medias/images/'.$img->file.'" alt="'.$img->file.'">';
            $result .= '</div>';
        }
        $result .= '</div>';

        if($this->_nav) {
            $result .= '<a class="left carousel-control" href="#carousel-example-generic" data-slide="prev">
                            <span class="icon-prev"></span>
                        </a>
                        <a class="right carousel-control" href="#carousel-example-generic" data-slide="next">
                            <span class="icon-next"></span>
                        </a>';
        }

        return $result;
    }
    
    public function slideFallBack() {
        $result  = '<div class="carousel-inner">';
            $result .= '<div class="item active">';
                $result .= '<img src="images/slide_fallback.jpg">';
            $result .= '</div>';
        $result .= '</div>';
        
        return $result;
    }

    public function reqSlideFiles() {
        try {
            $sql = "SELECT file
                    FROM lay_slideshows_imgs
                    INNER JOIN lay_slideshows ON lay_slideshows.id = lay_slideshows_imgs.id_slide
                    INNER JOIN lib_medias_adds ON lib_medias_adds.id_media = lay_slideshows_imgs.id_media
                    WHERE lay_slideshows.titre='".$this->_title."' AND lib_medias_adds.id_format<>'99'
                    ORDER BY lay_slideshows_imgs.sort ASC";
            return $this->execQuery($sql);
        }
        catch (PDOException $e) {
            throw new PDOException($e);
        }
    }
}
?>