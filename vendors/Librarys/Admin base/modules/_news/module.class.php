<?php
class NEWS extends DB {
    /* ATTRIBUTS */
    private $_slideformatid;
    private $_imgformatid;
    
    public function __construct() {
        //Constructeur de la CLASS parent
	parent::__construct();
        
        $this->setSlideFormatId('1');
        $this->setImgFormatId('3');
    }
    
    /* GETTER */
    public function getSlideFormatId()                  { return $this->_slideformatid; }
    public function getImgFormatId()                    { return $this->_imgformatid; }
	
    /* SETTER */
    public function setSlideFormatId($slideformatid)    { $this->_slideformatid = $slideformatid; }
    public function setImgFormatId($imgformatid)        { $this->_imgformatid = $imgformatid; }
    
    /* INITIALIZER */
    
    public function getLayoutNews() {
        if($this->getLstNews()) {
            $result = '<ul class="unsortable" alt="lst_medias">';
            foreach($this->getLstNews() as $news) {
                $result .= '<li><div class="row">';
                $result .= '<div class="two columns"><img src="../medias/images/'.$this->getNewsThumb($news['id']).'"></div>';
                $result .= '<div class="four columns"><strong>'.$news['titre'].'</strong><br>'.$news['sous_titre'].'</div>';
                $result .= '<div class="four columns">'.$this->getDateAndHour($news['date_publi']).'</div>';
                $result .= '<div class="one columns tool-box">'.$this->getMasterSwitch($news['id'], $news['active'], 'news').'</div>';
                $result .= '<div class="one columns tool-box">
                                <a href="?module=news&page=edition&idnews='.$news['id'].'" target="_self"><img src="imgs/bton_edit.png" class="sub-tool"></a>
                                <img src="imgs/bton_del.png" class="sub-tool" role="open-del-box" alt="'.$news['id'].'">
                           </div>';
                $result .= '</div>';
                //Del box
                $result .= '<div class="row pop-box" id="del_'.$news['id'].'">';
                $result .= '<div class="eight columns">Supprimer cette news ?</div>';
                $result .= '<div class="four columns tool-box">
                                <img src="imgs/bton_yes.png" class="sub-tool" role="del-news" alt="'.$news['id'].'">
                                <img src="imgs/bton_no.png" class="tool" role="close_pop_box"">
                           </div>';
                $result .= '</div>';
                $result .= '</li>';
            }
            $result .= '</ul>';
        }
        else {
            $result  = '<ul class="unsortable" alt="lst_medias">';
            $result .= '<li><div class="row">';
            $result .= '<div class="twelve columns">Aucune news...</div>';
            $result .= '<div></li>';
            $result .= '</ul>';
        }
        return $result;
    }
    
    private function getLstNews() {
        $query = "SELECT id, date_publi, titre, sous_titre, active FROM lay_news ORDER BY date_publi DESC";
        return $this->executeExternalQuery($query);
    }
    
    private function getDateAndHour($date) {
        $time = explode(" ", $date);
        $split = explode("-", $time['0']);
        return 'Publiée le '.$split['2'].'.'.$split['1'].'.'.$split['0'].'<br>à '.$time['1'];
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
    
    private function getNewsThumb($id) {
        $query = mysql_query("SELECT file
                                FROM lib_medias_adds
                                WHERE lib_medias_adds.id_format='99' AND lib_medias_adds.id_media='".$this->getIdMedia($id)."'");
        return mysql_result($query, 0);
    }
    
    private function getIdMedia($id) {
        $query = mysql_query("SELECT lib_medias_adds.id_media AS idmedia
                                FROM lay_news_medias
                                INNER JOIN lib_medias_adds ON lib_medias_adds.id = lay_news_medias.id_media
                                WHERE lay_news_medias.id_news='".$id."'");
        return mysql_result($query, 0);
    }
    
    public function getLayoutMedias($linkto) {
        if($this->getLstMedias($linkto)) {
            $result = '<ul class="unsortable" alt="lst_medias">';
            foreach($this->getLstMedias($linkto) as $media) {
                $result .= '<li><div class="row">';
                $result .= '<div class="two columns"><img src="../medias/images/'.$this->getThumb($media['id_media']).'"></div>';
                $result .= '<div class="six columns">'.$media['file'].'</div>';
                $result .= '<div class="four columns tool-box">
                                <img src="imgs/bton_add.png" class="sub-tool" linkto="'.$linkto.'" idmedia="'.$media['id'].'">
                            </div>';
                $result .= '</div></li>';
            }
            $result .= '</ul>';
        }
        return $result;
    }
    
    private function getLstMedias($linkto) {
        if($linkto == '1') {
            $query = "SELECT * FROM lib_medias_adds WHERE id_format='".$this->_slideformatid."' ORDER BY lib_medias_adds.id DESC LIMIT 20";
            //$query = "SELECT * FROM lib_medias_adds WHERE id_format='3'";
        }
        else {
            $query = "SELECT * FROM lib_medias_adds WHERE id_format='".$this->_imgformatid."' ORDER BY lib_medias_adds.id DESC LIMIT 20";
            //$query = "SELECT * FROM lib_medias_adds WHERE id_format='3'";
        }
        return $this->executeExternalQuery($query);
    }
    
   
    public function addNewsToDb($data) {
        if(isset($data['to-app'])) {
            $to_app = $data['to-app'];
        }
        else {
            $to_app = 0;
        }
        
        if($to_app == 0) {
            $to_app_home = 0;
        }
        else {
            if(isset($data['to-app-home'])) {
                $to_app_home = $data['to-app-home'];
            }
            else {
                $to_app_home = 0;
            }
        }
        /*
        echo '<br>';
        echo 'to-app : '.$to_app.'<br>';
        echo 'to-app-home : '.$to_app_home.'<br>';
        */
        $sql = mysql_query("INSERT INTO lay_news
                            (date_publi, titre, sous_titre, texte, active, to_app, to_app_home)
                            VALUES
                            ('".date("y-m-d H:m:s")."',
                             '".addslashes($data['titre'])."',
                             '".addslashes($data['sous-titre'])."',
                             '".addslashes($data['texte'])."',
                             '1',
                             '".$to_app."',
                             '".$to_app_home."')");
        $id_news = mysql_insert_id();
        
        if(!$sql) {
            throw new Exception('alert');
        }
        
        $sql = mysql_query("INSERT INTO lay_news_medias
                            (id_news, id_media, type)
                            VALUES
                            ('".$id_news."',
                             '".$data['img-slide']."',
                             '1')");
        if(!$sql) {
            throw new Exception('alert');
        }
        
        
        
        //Insertion de la liaison pour le thumb mobile de la news
        $sql = mysql_query("INSERT INTO lay_news_medias
                            (id_news, id_media, type)
                            VALUES
                            ('".$id_news."',
                             '".$this->getIdImgMobile($data['img-slide'],'2')."',
                             '2')");
        if(!$sql) {
            throw new Exception('alert');
        }
        
        //Insertion de la liaison pour l'image de contenu mobile de la news
        $sql = mysql_query("INSERT INTO lay_news_medias
                            (id_news, id_media, type)
                            VALUES
                            ('".$id_news."',
                             '".$this->getIdImgMobile($data['img-slide'],'3')."',
                             '2')");
        if(!$sql) {
            throw new Exception('alert');
        }
        
    }
    
    
    private function getIdImgMobile($id_medias_adds_Slide,$id_format) {
        
         $query = mysql_query("SELECT id FROM `lib_medias_adds` 
                    WHERE id_media=
                    (SELECT DISTINCT id_media 
                        FROM `lib_medias_adds` 
                        WHERE id='".$id_medias_adds_Slide."')
                    AND id_format='".$id_format."' LIMIT 1");

        if(mysql_num_rows($query)) {
            return mysql_result($query, 0);
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
    
    public function getValueToEdit($id, $value) {
        $query = mysql_query("SELECT ".$value." FROM lay_news WHERE id='".$id."'");
        return stripslashes(mysql_result($query, 0));
    }
    
    public function getNewsImgIdToEdit($id, $type) {
        $query = mysql_query("SELECT id_media FROM lay_news_medias WHERE id_news='".$id."' AND type='".$type."'");
        return mysql_result($query, 0);
    }
    
    public function getThumbToEdit($id, $type) {
        $query = mysql_query("SELECT file FROM lib_medias_adds WHERE id_media IN 
                                (SELECT id_media FROM lib_medias_adds WHERE id IN 
                                    (SELECT id_media FROM lay_news_medias WHERE id_news='".$id."' AND type='".$type."')) 
                              AND id_format='99'");
        return mysql_result($query, 0);
    }
    
    public function editNews($data) {
        if(isset($data['to-app'])) {
            $to_app = $data['to-app'];
        }
        else {
            $to_app = 0;
        }
        
        if($to_app == 0) {
            $to_app_home = 0;
        }
        else {
            if(isset($data['to-app-home'])) {
                $to_app_home = $data['to-app-home'];
            }
            else {
                $to_app_home = 0;
            }
        }
        
        $sql = mysql_query("UPDATE lay_news SET
                            titre='".addslashes($data['titre'])."',
                            sous_titre='".addslashes($data['sous-titre'])."',
                            texte='".addslashes($data['texte'])."',
                            to_app='".$to_app."',
                            to_app_home='".$to_app_home."'
                            WHERE id='".$data['idnews']."'");
        if(!$sql) {
            throw new Exception('alert');
        }
        
        
        
        $sql = mysql_query("UPDATE lay_news_medias SET id_media='".$data['img-slide']."' WHERE id_news='".$data['idnews']."' AND type='1'");
        if(!$sql) {
            throw new Exception('alert');
        }
         
        //Update du thumb iPhone
        try {
            $this->updateImageMobile($data['idnews'], $this->getIdImgMobile($data['img-slide'],'2'), '2');
        }
        catch (Exception $e) {
            throw new Exception($e);
        }

        //Update image news iPhone
        try {
            $this->updateImageMobile($data['idnews'], $this->getIdImgMobile($data['img-slide'],'3'), '3');
        }
        catch (Exception $e) {
            throw new Exception($e);
        }
    }
    
    private function getIDMediaByIDNewsAndIDFormat($id_news, $id_format){
         $query = mysql_query("SELECT DISTINCT ma.id 
                    FROM lib_medias_adds ma
                    INNER JOIN lay_news_medias nm2
                    ON ma.id=nm2.id_media
                    WHERE nm2.id_news='".$id_news."' 
                    AND nm2.type='2' 
                    AND ma.id_format='".$id_format."'LIMIT 1");
         
        if(mysql_num_rows($query)) {
            return mysql_result($query, 0);
        }   
    }
    
    private function updateImageMobile($id_news, $id_medias_adds, $id_format){
         $sql = mysql_query("UPDATE lay_news_medias SET lay_news_medias.id_media='".$id_medias_adds."' 
                WHERE lay_news_medias.id_news='".$id_news."' 
                AND lay_news_medias.id_media=".$this->getIDMediaByIDNewsAndIDFormat($id_news, $id_format)."
                AND lay_news_medias.type='2'");
            if(!$sql) {
                throw new Exception('alert');
            }
    }
    
    
    public function getMsgBox($alert) {
        if($alert == 'success') {
            $result = '<div class="twelve columns alert-box '.$alert.' text-center">News correctement ajoutée...</div>';
        }
        elseif($alert == 'alert') {
            $result = '<div class="twelve columns alert-box '.$alert.' text-center">Une erreur est survenue...</div>';
        }
        elseif($alert == 'success-maj') {
            $result = '<div class="twelve columns alert-box success text-center">La news a été correctement modifiée...</div>';
        }
        else {
            $result = '<div class="twelve columns alert-box alert text-center">'.$alert.'</div>';
        }
        return $result;
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
            $result  = '<ul class="block-grid three-up mobile">';
            foreach ($this->getLstFormats() as $format) {
                $result .= '<li class="select-img-format" role="'.$format['width'].'x'.$format['height'].'"><input type="checkbox" name="format_'.$format['id'].'" value="1"> '.$format['width'].' x '.$format['height'].' px</li>';
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