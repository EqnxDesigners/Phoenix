<?php
class MEDIAS extends DB {
    /* ATTRIBUTS */
    private $_media;
    private $_mediafolder;
    
    public function __construct() {
        //Constructeur de la CLASS parent
	parent::__construct();
    }
    
     /* GETTER */
    public function getMedia()                      { return $this->_media; }
    public function getMediaFolder()                { return $this->_mediafolder; }
	
    /* SETTER */
    public function setMedia($media)                { $this->_media = $media; }
    public function setMediaFolder($mediafolder)    { $this->_mediafolder = $mediafolder; }
    
    /* INITIALIZER */
    private function initFiles() {
            include_once'../class/files.class.php';
            return $files = new FILES();
    }
    
    public function getIdMedia($media) {
        switch ($media) {
            case 'images':
                $result = 1;
                break;
            case 'docs':
                $result = 3;
                break;
            case 'videos':
                $result = 2;
                break;
        }
        return $result;
    }
    
    public function getLayoutMedias($type='all', $case='manager') {
        if($this->getLstMedias($type)) {
            $result = '<ul class="block-grid eight-up mobile-four-up unsortable" alt="lst_medias">';
            foreach($this->getLstMedias($type) as $media) {
                $result .= '<li class="media-choose" alt="'.$media['id'].'">';
                if($media['type'] == '1') {
                    $result .= '<img src="../medias/images/'.$this->getThumb($media['id']).'">';
                }
                if($media['type'] == '2') {
                    $result .= '<img src="http://i.ytimg.com/vi/'.$this->getVideoYoutubeId($media['file_url']).'/default.jpg" />';
                }
                if($media['type'] == '3') {
                    $result .= '<a href="../medias/docs/'.$media['file_url'].'" target="_blank"><img src="imgs/ico_pdf.png"></a>';
                }
                $result .= '<img src="imgs/corner_del.png" class="btn-corner top right">';
                $result .= '</li>';
                
                /*
                $result .= '<li><div class="row">';
                $result .= '<div class="two columns">';
                    if($media['type'] == '1') {
                        $result .= '<img src="../medias/images/'.$this->getThumb($media['id']).'">';
                    }
                    if($media['type'] == '2') {
                        $result .= '<img src="http://i.ytimg.com/vi/'.$this->getVideoYoutubeId($media['file_url']).'/default.jpg" />';
                    }
                    if($media['type'] == '3') {
                        $result .= '<a href="../medias/docs/'.$media['file_url'].'" target="_blank"><img src="imgs/ico_pdf.png"></a>';
                    } 
                $result .= '</div>';
                $result .= '<div class="six columns">'.$media['titre'].'</div>';
                if($case == 'manager') {
                    $result .= '<div class="four columns tool-box">
                                    <img src="imgs/bton_del.png" class="sub-tool" role="open-del-box" alt="'.$media['id'].'">
                                    <img src="imgs/bton_next.png" class="sub-tool" role="view-adds" alt="'.$media['id'].'">
                               </div>';
                }
                else {
                    $result .= '<div class="four columns tool-box">
                                    <img src="imgs/bton_add.png" class="sub-tool" role="add-pic-to-slide" alt="'.$media['id'].'">
                               </div>';
                }
                $result .= '</div>';
                //Del box
                $result .= '<div class="row pop-box" id="del_'.$media['id'].'">';
                $result .= '<div class="eight columns">Supprimer ce média ?</div>';
                $result .= '<div class="four columns tool-box">
                                <img src="imgs/bton_yes.png" class="sub-tool" role="del-media" alt="'.$media['id'].'" rel="'.$media['type'].'">
                                <img src="imgs/bton_no.png" class="tool" role="close_pop_box"">
                           </div>';
                $result .= '</div>';
                $result .= '</li>';
                 * 
                 */
            }
            $result .= '</ul>';
        }
        return $result;
    }
    
    private function getThumb($id) {
        $query = mysql_query("SELECT file FROM lib_medias_adds WHERE id_media='".$id."' AND id_format='99'");
        if(mysql_num_rows($query)) {
            return mysql_result($query, 0);
        }
        else {
            return false;
        }
    }
    
    public function getLayoutSubMedias($id) {
        if($this->getLstSubMedias($id)) {
            $result = '<ul class="unsortable" alt="lst_medias">';
            foreach($this->getLstSubMedias($id) as $media) {
                $result .= '<li><div class="row">';
                $result .= '<div class="three columns">';
                $result .= '<img src="../medias/images/'.$media['file'].'">';
                $result .= '</div>';
                $result .= '<div class="five columns">'.$media['file'].'</div>';
                $result .= '<div class="four columns tool-box">
                                <img src="imgs/bton_del.png" class="sub-tool" role="open-del-sub-box" alt="'.$media['id'].'">
                           </div>';
                $result .= '</div>';
                //Del box
                $result .= '<div class="row pop-box" id="del-sub_'.$media['id'].'">';
                $result .= '<div class="eight columns">Supprimer ce média ?</div>';
                $result .= '<div class="four columns tool-box">
                                <img src="imgs/bton_yes.png" class="sub-tool" role="del-sub-media" alt="'.$media['id'].'">
                                <img src="imgs/bton_no.png" class="sub-tool" role="close_pop_box"">
                           </div>';
                $result .= '</div>';
                $result .= '</li>';
            }
            $result .= '</ul>';
        }
        else {
            $result  = '<ul class="unsortable" alt="lst_medias">';
            $result .= '<li><div class="row">';
            $result .= '<div class="twelve columns" style="padding-bottom:6px;">Aucun autre fichiers liés...</div>';
            $result .= '</div></li>';
        }
        return $result;
    }
    
    public function getLayoutSlideShow() {
        if($this->getLstSlideShow()) {
            $result = '<ul class="unsortable" alt="lst_slideshows">';
            foreach($this->getLstSlideShow() as $slide) {
                $result .= '<li><div class="row">';
                $result .= '<div class="eight columns"><strong>'.$slide['titre'].'</strong></div>';
                $result .= '<div class="four columns tool-box">
                                <img src="imgs/bton_edit.png" class="sub-tool" role="select-slide" alt="'.$slide['id'].'">                                
                                <img src="imgs/bton_del.png" class="sub-tool" role="open-del-slide" alt="'.$slide['id'].'">
                           </div>';
                $result .= '</div>';
                //Del box
                $result .= '<div class="row pop-box" id="del-slide_'.$slide['id'].'">';
                $result .= '<div class="eight columns">Supprimer ce slideshow ?</div>';
                $result .= '<div class="four columns tool-box">
                                <img src="imgs/bton_yes.png" class="sub-tool" role="del-slide" alt="'.$slide['id'].'">
                                <img src="imgs/bton_no.png" class="tool" role="close_pop_box"">
                           </div>';
                $result .= '</div>';
                $result .= '</li>';
            }
        }
        else {
            $result  = '<ul class="unsortable" alt="lst_slideshows">';
            $result .= '<li><div class="row">';
            $result .= '<div class="twelve columns" style="padding-bottom:6px;">Aucun slideshow créé...</div>';
            $result .= '</div></li>';
        }
        return $result;
    }
    
    public function getSelectedSlideContent($id) {
        if($this->getSlideContent($id)) {
            $result = '<ul class="sortable" alt="lst_imgs_in_slide">';
            foreach($this->getSlideContent($id) as $media) {
                $result .= '<li role="'.$media['id_img'].'#"><div class="row">';
                $result .= '<div class="three columns"><img src="../medias/images/'.$media['file'].'"></div>';
                $result .= '<div class="five columns">'.$media['file'].'</div>';
                $result .= '<div class="four columns tool-box">                              
                                <img src="imgs/bton_soustract.png" class="sub-tool" role="remove-pic-from-slide" alt="'.$media['id_img'].'" rel="'.$media['id_slide'].'">
                           </div>';
                $result .= '</div></li>';
            }
        }
        else {
            $result  = '<ul class="unsortable" alt="lst_slideshows">';
            $result .= '<li><div class="row">';
            $result .= '<div class="twelve columns" style="padding-bottom:6px;">Aucune images liées...</div>';
            $result .= '</div></li>';
        }
        return $result;
    }
    
    private function getSlideContent($id) {
        $query = "SELECT lay_slideshows_imgs.id AS id_img, id_slide, sort, file
                    FROM lay_slideshows_imgs
                    INNER JOIN lib_medias_adds ON lib_medias_adds.id_media = lay_slideshows_imgs.id_media
                    WHERE lay_slideshows_imgs.id_slide='".$id."' AND lib_medias_adds.id_format='99'
                    ORDER BY sort ASC";
        return $this->executeExternalQuery($query);
    }
    
    private function getLstSlideShow() {
        $query = "SELECT * FROM lay_slideshows";
        return $this->executeExternalQuery($query);
    }
    
    private function getLstMedias($type) {
        if($type == 'all') {
            $query = "SELECT * FROM lib_medias ORDER BY titre ASC";
        }
        else {
            $query = "SELECT * FROM lib_medias WHERE type='".$type."' ORDER BY titre ASC";
        }
        return $this->executeExternalQuery($query);
    }
    
    private function getLstSubMedias($id) {
        $query = "SELECT * FROM lib_medias_adds WHERE id_media='".$id."' AND id_format<>'99'";
        return $this->executeExternalQuery($query);
    }
    
    public function getLstAllSubMedias($id) {
        $query = "SELECT * FROM lib_medias_adds WHERE id_media='".$id."'";
        return $this->executeExternalQuery($query);
    }
    
    public function getMediasInfos($id) {
        $query = "SELECT * FROM lib_medias WHERE id='".$id."'";
        return $this->executeExternalQuery($query);
    }
    
    public function addMediaToDb($file_name,$titre,$alt,$legende,$typemedia) {
        $sql = mysql_query("INSERT INTO lib_medias
                            (file_url, titre, alt, legende, post_date, type, active)
                            VALUES
                            ('".$file_name."',
                             '".addslashes($titre)."',
                             '".addslashes($alt)."',
                             '".addslashes($legende)."',
                             '".date("Y-m-d H:m:s")."',
                             '".$typemedia."',
                             '1')");
        if(!$sql) {
            throw new Exception('alert');
        }
        else {
            return mysql_insert_id();
        }
    }
    
    public function addMediaAddsToDb($id_media,$id_format,$file) {
        $sql = mysql_query("INSERT INTO lib_medias_adds
                            (id_media, id_format, file, active)
                            VALUES
                            ('".$id_media."',
                             '".$id_format."',
                             '".$file."',
                             '1')");
        if(!$sql) {
            throw new Exception('alert');
        }
    }
    
    public function addVidToDb($vids_url,$titre,$alt,$legende,$typemedia) {
        $sql = mysql_query("INSERT INTO lib_medias
                            (file_url, titre, alt, legende, post_date, type, active)
                            VALUES
                            ('".$vids_url."',
                             '".addslashes($titre)."',
                             '".addslashes($alt)."',
                             '".addslashes($legende)."',
                             '".date("Y-m-d H:m:s")."',
                             '".$typemedia."',
                             '1')");
        if(!$sql) {
            throw new Exception('alert');
        }
    }
    
    public function updateMedia($data) {
        $sql = mysql_query("UPDATE lib_medias SET 
                            titre='".addslashes($data['titre'])."',
                            alt='".addslashes($data['alt'])."',
                            legende='".addslashes($data['legende'])."'
                            WHERE id='".$data['id_media']."'");
        if(!$sql) {
            throw new Exception('alert');
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
    
    public function getFileName($id) {
        $query = mysql_query("SELECT file_url FROM lib_medias WHERE id='".$id."'");
        if(mysql_num_rows($query)) {
            return mysql_result($query, 0);
        }
    }
    
    public function getSubFileName($id) {
        $query = mysql_query("SELECT file FROM lib_medias_adds WHERE id='".$id."'");
        if(mysql_num_rows($query)) {
            return mysql_result($query, 0);
        }
    }
    
    public function getParentMediaId($id) {
        $query = mysql_query("SELECT id_media FROM lib_medias_adds WHERE id='".$id."'");
        if(mysql_num_rows($query)) {
            return mysql_result($query, 0);
        }
    }
    
    public function checkNbSubMedias($id) {
        $query = mysql_query("SELECT id FROM lib_medias_adds WHERE id_media='".$id."'");
        return mysql_num_rows($query);
    }
    
    public function getVideoYoutubeId($url) {
        $split = explode("/", $url);
        return $split[count($split)-1];
    }
    
    public function getLayoutFormats() {
        if($this->getLstFormats()) {            
            $result  = '<ul class="unsortable" alt="lst_medias">';
            foreach($this->getLstFormats() as $format) {
                $result .= '<li><div class="row">';
                $result .= '<div class="six columns">'.$format['format'].'</div>';
                $result .= '<div class="four columns">'.$format['width'].' x '.$format['height'].' px</div>';
                $result .= '<div class="two columns tool-box"><img src="imgs/bton_del.png" class="sub-tool" role="del_format" alt="'.$format['id'].'"></div>';
                $result .= '</div></li>';
            }
            $result .= '</ul>';
        }
        else {
            $result  = '<ul class="unsortable" alt="lst_medias">';
            $result .= '<li>Aucun format défini...</li>';
            $result .= '</ul>';
        }
        return $result;
    }
    
    public function getLstFormats() {
        $query = "SELECT * FROM lib_imgs_formats";
        return $this->executeExternalQuery($query);
    }
    
    public function getFormLstFormat() {
        if($this->getLstFormats()) {
            $result  = '<ul class="block-grid two-up mobile">';
            foreach ($this->getLstFormats() as $format) {
                $result .= '<li class="select-img-format" role="'.$format['width'].'x'.$format['height'].'"><input type="checkbox" name="format_'.$format['id'].'" value="1"> '.$format['format'].' ('.$format['width'].'x'.$format['height'].')</li>';
            }
            $result .= '</ul>';
        }
        return $result;
    }
    
    public function getFormatSize($id, $dist) {
        $query = mysql_query("SELECT ".$dist." FROM lib_imgs_formats WHERE id='".$id."'");
        return mysql_result($query, 0);
    }
    
    public function addSlideShow($data) {
        $sql = mysql_query("INSERT INTO lay_slideshows (titre) VALUES ('".$data['titre']."')");
        if(!$sql) {
            throw new Exception('Ce nom de slide existe déjà.');
        }
    }
    
    public function getLastSort($id) {
        $query = mysql_query("SELECT sort FROM lay_slideshows_imgs WHERE id_slide='".$id."' ORDER BY sort DESC LIMIT 1");
        if(mysql_num_rows($query)) {
            $result = mysql_result($query, 0) + 1;
        }
        else {
            $result = 1;
        }
        return $result;
    }
    
    public function getMsgBox($alert) {
        if($alert == 'success') {
            $result = '<div class="twelve columns alert-box '.$alert.' text-center">Le média a été correctement uploadé</div>';
        }
        elseif($alert == 'alert') {
            $result = '<div class="twelve columns alert-box '.$alert.' text-center">Une erreur est survenue...</div>';
        }
        elseif($alert == 'success-slide') {
            $result = '<div class="twelve columns alert-box success text-center">Le slide a été correctement créé</div>';
        }
        else {
            $result = '<div class="twelve columns alert-box alert text-center">'.$alert.'</div>';
        }
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
}
?>