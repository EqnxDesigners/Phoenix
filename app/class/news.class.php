<?php
/*           
==================================================================
Fichier: news.class.php                                
Description: Class de gestion des news                      
------------------------------------------------------------------
Auteur: Jérôme Clerc                              
Editeurs: Jérôme Clerc
Société: Equinoxe MIS Development                 
Version: 1.0               
------------------------------------------------------------------
Changelog
------------------------------------------------------------------
00.00.0000 - 1.1
???

==================================================================
*/

class News extends DB {
    /* TRAITS */
    use Trait_datetime, Trait_renderhtml, Trait_traduction;
    
	/* ATTRIBUTS */
	private $_lang;
	private $_idlang;
    private $_status;
	
	/* CONSTRUCT */
	public function __construct() {
        parent::__construct();
        if(isset($_SESSION['current']['lang'])) {
            $this->setLang($_SESSION['current']['lang']);
            $this->setIdLang($this->reqIdLang()->id);
        }
	}
	
	/* GETTER */
	public function getLang()                       { return $this->_lang; }
	public function getIdLang()                     { return $this->_idlang; }
    public function getStatus()                     { return $this->$_status; }
	
	/* SETTER */
	public function setLang($lang)		            { $this->_lang = $lang; }
	public function setIdLang($idlang)		        { $this->_idlang = $idlang; }
    public function setStatus($status)              { $this->_status = $status; }
    
    /* INITTER */
    public function initLangues() {
        return new Langues();
    }
	
    /* METHODES */
    public function displayNews($currentPage, $max = 6) {
        try {
            if($allNews = $this->getNewsToDisplay($currentPage, $max)) {
                $result = '';
                foreach($allNews as $k => $news) {
                    
                    
                    $result .= '<div class="article">';
                        if($news->imageUrl !== NULL){
                            $result .= '<div class="image" style="background-image:url(img/img-news/'.$news->imageUrl.');"></div>';
                        }
                        $result .= '<div class="content">';
                            $result .= '<div class="header">';
                                $result .= '<span class="date">'.$this->displayDate($news->date_update).'</span>';
                                $result .= '<h1>'.$news->title.'</h1>';
                                $result .= '<h2>'.$news->sub_title.'</h2>';
                            $result .= '</div>';
                            $result .= '<div class="body multiplecolumns">';
                                $result .= $news->content;
                            $result .= '</div>';
                        $result .= '</div>';
                    $result .= '</div>';
                }
            }
            else {
                $result = '<div class="new" style="width:100%">';
                    $result .= '<div class="content">';
                        $result .= '<div class="row">';
                            $result .= '<div class="small-12 columns">';
                                $result .= 'Aucune news pour le moment...';
                            $result .= '</div>';
                        $result .= '</div>';
                    $result .= '</div>';
                $result .= '</div>';
            }
        }
        catch (PDOException $e) {
            throw new PDOException($e);
        }
        return $result;
    }

    public function displayLastNews($max = 2) {
        try {
            if($allNews = $this->getNewsToDisplay(0, $max)) {
                $nbcol = 12 / $max;
                $result = '';
                foreach($allNews as $k => $news) {
                    $result .= '<div class="small-12 medium-'.$nbcol.' columns article" data-equalizer-watch>';
                        if($news->imageUrl !== NULL){
                            $result .= '<div class="image" style="background-image:url(img/img-news/'.$news->imageUrl.');"></div>';
                        }
                        $result .= '<div class="content">';
                            $result .= '<div class="header">';
                                $result .= '<span class="date">'.$this->displayDate($news->date_update).'</span>';
                                $result .= '<h1>'.$news->title.'</h1>';
                                $result .= '<h2>'.$news->sub_title.'</h2>';
                            $result .= '</div>';
                            $result .= '<div class="body multiplecolumns">';
                                $result .= $news->content;
                            $result .= '</div>';
                        $result .= '</div>';
                    $result .= '</div>';
                }
            }
        }
        catch (PDOException $e) {
            throw new PDOException($e);
        }
        return $result;
    }

    public function getPagination($currentPage, $max = 6) {
        $nbPage = ceil(count($this->getNewsToDisplay()) / $max);
        $numPage = 1;
        $result = '';

        if($nbPage > 1) {
            $lastPage = $currentPage - 1;
            $nextPage = $currentPage + 1;

            $result .= '<ul class="pag">';
            $result .= ($nbPage > 1 && $currentPage != '1' ? '<li class="fleche prev"><a href="'.$_SESSION['current']['lang'].'/news-'.$lastPage.'"><img src="img/fleche-bleue-prev.png" alt="prev" /></a></li>' : '<li>&nbsp;</li>');
            for($i=0;$i<$nbPage;$i++) {
                $result .= '<li';
                $result .= ($currentPage == $numPage ? ' class="active">' : '>');
                $result .= '<a href="'.$_SESSION['current']['lang'].'/news-'.$numPage.'">'.$numPage.'</a>';
                $result .= '</li>';
                $numPage++;
            }
            $result .= ($nbPage > 1 && $currentPage < $nbPage ? '<li class="fleche next"><a href="'.$_SESSION['current']['lang'].'/news-'.$nextPage.'"><img src="img/fleche-bleue-next.png" alt="next" /></a></li>' : '<li>&nbsp;</li>' );
            $result .= '</ul>';
        }

        return $result;
    }
    
    private function getNewsToDisplay($currentPage = 0, $max = 9999999) {
        try {
            $sql = "SELECT news.id AS idnews, date_publi, date_start, date_end, date_update, title, sub_title, content, imageUrl
                    FROM news
                    INNER JOIN news_trad ON news.id = news_trad.id_news
                    WHERE news.status='1' ";
            $sql .= ($this->_lang === 'fr' || $this->_lang === 'en' ? "AND news_trad.id_lang = '".$this->_idlang."' " : "AND news_trad.id_lang = '".$this->_idlang."' OR news_trad.id_lang = 'en' ");
            if($currentPage === 0 || $currentPage == '1') {
                $sql .= "ORDER BY news.date_publi DESC LIMIT ".$max;
            }
            else {
                $sqlMin = ($currentPage - 1) * $max;
                $sqlMax = $sqlMin + $max;
                $sql .= "ORDER BY news.date_publi DESC LIMIT ".$sqlMin.", ".$sqlMax;
            }
            return $this->execQuery($sql);
        }
        catch (PDOException $e) {
            throw new PDOException($e);
        }
    }
    
    private function reqIdLang() {
        try {
            $sql = "SELECT id FROM langues WHERE langue_abrev='".$this->_lang."'";
            return $this->execOneResultQuery($sql);
        }
        catch (PDOException $e) {
            throw new PDOException($e);
        }
    }
    
    public function reloadListing() {
        return $this->getLstNews('0');
    }
    
    public function getLstNews($status) {
        $this->setStatus($status);
        try {
            $allNews = $this->getNews();
            $result = '<ul>';
                $result .= $this->getListingHeader();
            if($allNews) {
                foreach($allNews as $K => $news) {
                    $firstDisplayed = false;
                    foreach($this->getNewsTrad($news->id) as $k => $trad) {
                        if($firstDisplayed === false) {
                            $result .= $this->buildListingLine($news, $trad);
                            $firstDisplayed = true;
                        }
                        else {
                            if($trad->title !== '') {
                                $result .= $this->buildListingLine($news, $trad, 'sub');
                            }
                        }
                    }
                }
            }
            else {
                if($status === '2') {
                    $result .= '<li class="row"><div class="small-12 columns">Aucune News archivées pour le moment...</div></li>';
                }
                elseif($status === '3') {
                    $result .= '<li class="row"><div class="small-12 columns">La corbeille est vide pour le moment...</div></li>';
                }
                else {
                    $result .= '<li class="row"><div class="small-12 columns">Aucune News pour le moment...</div></li>';
                }
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
            $result .= '<div class="small-1 columns"><input type="checkbox" id="check-toggle"></div>';
            $result .= '<div class="small-5 columns">Titre</div>';
            $result .= '<div class="small-1 columns">Création</div>';
            $result .= '<div class="small-1 columns">Diffusion</div>';
            $result .= '<div class="small-1 columns">Revocation</div>';
            $result .= '<div class="small-1 columns">Modification</div>';
            $result .= '<div class="small-2 columns">&nbsp;</div>';
        $result .= '</li>';
        return $result;
    }
    
    private function buildListingLine($news, $trad, $lvl='main') {
        if($lvl === 'main') {
            $result = '<li class="row main-row">';
            $result .= '<div class="small-1 columns">';
            $result .= '<input type="checkbox" class="check-masse-actions" name="news-'.$news->id.'" item="'.$news->id.'">&nbsp;';
            if(count($this->getNewsTrad($news->id)) > 1) {
                $result .= '<i class="fa fa-plus-square-o sub-action" tohide="'.$news->id.'"></i>';
            }
            $result .= '</div>';
            $result .= '<div class="small-4 columns"><strong>'.$trad->title.'</strong>';
        }
        else {
            $result = '<li class="row sub-row sub-row-'.$news->id.'">';
            $result .= '<div class="small-1 columns">&nbsp;</div>';
            $result .= '<div class="small-4 columns sub-row-title">'.$trad->title;
        }
        if($news->status === '4') {
            $result .= '&nbsp;<small>(brouillon)</small>';
        }
        $result .= '</div>';
        $result .= '<div class="small-1 columns"><img src="images/'.$trad->langue_abrev.'-icon.png" alt="flag icone" /></div>';
        if($lvl === 'main') {
            $result .= '<div class="small-1 columns">'.$this->displayDate($news->date_publi).'</div>';
            $result .= '<div class="small-1 columns">'.$this->displayDate($news->date_start).'</div>';
            $result .= '<div class="small-1 columns">'.$this->displayDate($news->date_end).'</div>';
            $result .= '<div class="small-1 columns">'.$this->displayDate($news->date_update).'</div>';
            $result .= '<div class="small-2 columns toolbox text-right">'.$this->buildToolBox($news).'</div>';
        }
        else {
            $result .= '<div class="small-6 columns">&nbsp;</div>';
        }
        $result .= '</li>';
        return $result;
    }
    
    public function getMasseActionsMenu($status) {
        $this->setStatus($status);
        $result = '<select name="select-actions-masse" id="select-actions-masse">';
        $result .= '<option selected>Actions</option>';
        if($this->_status === '2') {
            $result .= '<option value="restaurer">Restaurer</option>';
            $result .= '<option value="supprimer">Supprimer</option>';
        }
        elseif($this->_status === '3') {
            $result .= '<option value="restaurer">Restaurer</option>';
        }
        else {
            $result .= '<option value="activer">Activer</option>';
            $result .= '<option value="desactiver">Désactiver</option>';
            $result .= '<option value="archiver">Archiver</option>';
            $result .= '<option value="supprimer">Supprimer</option>';
        }
        $result .= '</select>';
        return $result;
    }
    
    private function buildToolBox($item) {
        $result = '';
        if($item->status === '4') {
            $result .= '&nbsp;<i class="fa fa-cloud-upload btn" role="news-publish" item="'.$item->id.'"></i>';
        }
        if($item->status === '0') {
            $result .= '&nbsp;<i class="fa fa-eye-slash btn" role="news-enable" item="'.$item->id.'"></i>';
        }
        elseif($item->status === '1') {
            $result .= '&nbsp;<i class="fa fa-eye btn" role="news-disable" item="'.$item->id.'"></i>';
        }
        else {
            $result .= '';
        }
        if($item->status === '0' || $item->status === '1' || $item->status === '4') {
            $result .= '&nbsp;<i class="fa fa-pencil  btn" role="news-edit" item="'.$item->id.'"></i>';
            $result .= '&nbsp;<i class="fa fa-archive btn" role="news-archives" item="'.$item->id.'"></i>';
            $result .= '&nbsp;<i class="fa fa-trash-o btn" role="news-trash" item="'.$item->id.'"></i>';
        }
        if($item->status === '2') {
            $result .= '&nbsp;<i class="fa fa-reply btn" role="news-restore" item="'.$item->id.'"></i>';
            $result .= '&nbsp;<i class="fa fa-trash-o btn" role="news-trash" item="'.$item->id.'"></i>';
        }
        if($item->status === '3') {
            $result .= '&nbsp;<i class="fa fa-reply btn" role="news-restore" item="'.$item->id.'"></i>';
        }
        return $result;
    }
    
    public function saveNews($data, $fileName) {
        $Langue = $this->initLangues();
        try {
            $lastId = $this->insertNewsMeta($data, $fileName, '4');
            
            foreach($Langue->getLangs() as $k => $lang) {
                try {
                    $sql = "INSERT INTO news_trad (id_news,id_lang,title,sub_title,content) 
                            VALUES ('".$lastId."',
                                    '".$lang->id."',
                                    '".$data['title_'.$lang->langue_abrev]."',
                                    '".$data['sub-title_'.$lang->langue_abrev]."',
                                    '".$data['news-editor_'.$lang->langue_abrev]."')";
                    $this->applyOneQuery($sql);
                }
                catch (PDOException $e) {
                    throw new PDOException($e);
                }
            }
        }
        catch (PDOException $e) {
            throw new PDOException($e);
        }
    }
    
    public function publishNews($data, $fileName) {
        $Langue = $this->initLangues();
        try {
            $lastId = $this->insertNewsMeta($data, $fileName, '1');
            if(isset($data['idem-all-lang'])) {
                foreach($Langue->getLangs() as $k => $lang) {
                    try {
                        $this->insertNewsTrad($data, $lang, $Langue->getLangByiD($data['select-lang']), $lastId);
                    }
                    catch (PDOException $e) {
                        throw new PDOException($e);
                    }
                }
            }
            else {
                foreach($Langue->getLangs() as $k => $lang) {
                    if(strlen($data['title_'.$lang->langue_abrev]) > 0 && strlen($data['news-editor_'.$lang->langue_abrev]) > 0) {
                        try {
                            $this->insertOneNewsTrad($data, $lang, $lastId);
                        }
                        catch (PDOException $e) {
                            throw new PDOException($e);
                        }
                    }
                }
            }
        }
        catch (PDOException $e) {
            throw new PDOException($e);
        }
    }
    
    public function majNews($data, $fileName) {
        $Langue = $this->initLangues();
        if(strlen($data['date-diffusion'] > 0)) {
            try {
                $this->updateNewsMetaField('date_start', $this->setDateTime($data['date-diffusion']), $data['id_news']);
            }
            catch (PDOException $e) {
                throw new PDOException($e);
            }
        }
       if(strlen($data['date-revocation'] > 0)) {
            try {
                $this->updateNewsMetaField('date_end', $this->setDateTime($data['date-revocation']), $data['id_news']);
            }
            catch (PDOException $e) {
                throw new PDOException($e);
            }
        }
        if($fileName !== 'NULL') {
            try {
                if($this->delOldImage($data['id_news'])) {
                    $this->updateNewsMetaField('imageUrl', $fileName, $data['id_news']);
                }
                else {
                    throw new Exception("Impossible de supprimer l'ancienne image...");
                }
            }
            catch (PDOException $e) {
                throw new PDOException($e);
            }
        }
        if(isset($data['del-news-img']) && $data['del-news-img'] === '1') {
            try {
                if($this->delOldImage($data['id_news'])) {
                    $this->updateNewsMetaField('imageUrl', 'NULL', $data['id_news']);
                }
                else {
                    throw new Exception("Impossible de supprimer l'ancienne image...");
                }
            }
            catch (PDOException $e) {
                throw new PDOException($e);
            }
        }
        foreach($Langue->getLangs() as $k => $lang) {
            if($this->checkIfNewsEntry($data['id_news'], $lang->id)) {
                //Mise à jour de la news
                try {
                    $this->updateNewsTrad($data, $lang);
                }
                catch (PDOException $e) {
                    throw new PDOException($e);
                }
            }
            else {
                //Test si il y a un titre et du contenu
                if(strlen($data['title_'.$lang->langue_abrev]) > 0 && strlen($data['news-editor_'.$lang->langue_abrev]) > 0) {
                    try {
                        $this->insertNewsTrad($data, $lang, $lang, $data['id_news']);
                    }
                    catch (PDOException $e) {
                        throw new PDOException($e);
                    }
                }
            }
        }
        try {
            $this->updateNewsMetaField('date_update', $this->setDateTimeNow(), $data['id_news']);
        }
        catch (PDOException $e) {
            throw new PDOException($e);
        }
    }
          
    private function updateNewsMetaField($field, $value, $id) {
        try {
            $sql = "UPDATE news ";
            ($value === 'NULL' ? $sql .= "SET ".$field."=NULL " : $sql .= "SET ".$field."='".$value."' ");
            $sql .= "WHERE id='".$id."'";
            $this->applyOneQuery($sql);
        }
        catch (PDOException $e) {
            throw new PDOException($e);
        }
    }
          
    private function updateNewsTrad($data, $lang) {
        try {
            $sql = "UPDATE news_trad 
                    SET title='".addslashes($data['title_'.$lang->langue_abrev])."',
                    sub_title='".addslashes($data['sub-title_'.$lang->langue_abrev])."',
                    content='".addslashes($data['news-editor_'.$lang->langue_abrev])."'
                    WHERE id_news='".$data['id_news']."' AND id_lang='".$lang->id."'";
            $this->applyOneQuery($sql);
        }
        catch (PDOException $e) {
            throw new PDOException($e);
        }
    }

    private function delOldImage($id) {
        try {
            $oldImageName = $this->getOldImageName($id);
            if($oldImageName->imageUrl !== NULL) {
               return unlink('../../../img/img-news/'.$oldImageName->imageUrl);
            }
            else {
                return true;
            }

        }
        catch (PDOException $e) {
            throw new PDOException($e);
        }
    }

    private function getOldImageName($id) {
        try {
            $sql = "SELECT imageUrl FROM news WHERE id='".$id."'";
            return $this->execOneResultQuery($sql);
        }
        catch (PDOException $e) {
            throw new PDOException($e);
        }
    }
          
    private function checkIfNewsEntry($idnews, $idlang) {
        $sql = "SELECT * FROM news_trad WHERE id_news='".$idnews."' AND id_lang='".$idlang."'";
        if($this->execOneResultQuery($sql)) {
            $result = true;
        }
        else {
            $result = false;
        }
        return $result;
    }
    
    private function insertNewsTrad($data, $lang, $selectedLang, $lastId) {
        try {
            $sql = "INSERT INTO news_trad (id_news,id_lang,title,sub_title,content) 
                    VALUES ('".$lastId."',
                            '".$lang->id."',
                            '".addslashes($data['title_'.$selectedLang->langue_abrev])."',
                            '".addslashes($data['sub-title_'.$selectedLang->langue_abrev])."',
                            '".addslashes($data['news-editor_'.$selectedLang->langue_abrev])."')";
            $this->applyOneQuery($sql);
        }
        catch (PDOException $e) {
            throw new PDOException($e);
        }
    }
    
    private function insertOneNewsTrad($data, $lang, $lastId) {
        try {
            $sql = "INSERT INTO news_trad (id_news,id_lang,title,sub_title,content) 
                    VALUES ('".$lastId."',
                            '".$lang->id."',
                            '".addslashes($data['title_'.$lang->langue_abrev])."',
                            '".addslashes($data['sub-title_'.$lang->langue_abrev])."',
                            '".addslashes($data['news-editor_'.$lang->langue_abrev])."')";
            $this->applyOneQuery($sql);
        }
        catch (PDOException $e) {
            throw new PDOException($e);
        }
    }
    
    private function insertNewsMeta($data, $fileName, $status) {
        try {
            $dateJour   = $this->setDateTimeNow();
            $dateStart  = $this->setDateTime($data['date-diffusion']);
            $dateEnd    = $this->setDateTime($data['date-revocation']);

            $sql = "INSERT INTO news (date_publi,date_start,date_end,date_update,imageUrl,status)
                        VALUES ('".$dateJour."', '".$dateStart."', '".$dateEnd."', '".$dateJour."', ";
            if($fileName === 'NULL') {
                $sql .= " NULL, ";
            }
            else {
                $sql .= " '".$fileName."', ";
            }
            $sql .= " '".$status."') ";

            return $this->applyQueryWithLastId($sql);
        }
        catch (PDOException $e) {
            throw new PDOException($e);
        }
    }
    
    public function buildTradFields() {
        $Langue = $this->initLangues();
        $result = '';
        $trad = $this->getModuleTradIni('news');
        foreach($Langue->getLangs() as $k => $lang) {
            $result .= '<div class="row trad-forms';
            if($_SESSION['current_lang']->id != $lang->id) {
                $result .= ' masked"';
            }
            else {
                $result .= '"';
            }
            $result .= ' id="trad-form-'.$lang->id.'">';
            $result .= '<div class="small-12 columns">';
            $result .= '<input type="text" name="title_'.$lang->langue_abrev.'" placeholder="'.$trad['title_'.$lang->id]['placeholder'].'">';
            $result .= '</div><div class="small-12 columns">';
            $result .= '<input type="text" name="sub-title_'.$lang->langue_abrev.'" placeholder="'.$trad['sub-title_'.$lang->id]['placeholder'].'">';
            $result .= '</div><div class="small-12 columns">';
            $result .= '<textarea name="news-editor_'.$lang->langue_abrev.'" class="extend-text" id="news-editor" rows="20"></textarea>';
            $result .= '</div></div>';
        }
        return $result;
    }
    
    private function buildTradFieldsForOneNews($id, $trad) {
        $Langue = $this->initLangues();
        $result = '';
        foreach($Langue->getLangs() as $k => $lang) {
            $NewsTrad = $this->getNewsTradByLang($id, $lang->id);
            $result .= '<div class="row trad-forms';
            if($_SESSION['current_lang']->id != $lang->id) {
                $result .= ' masked"';
            }
            else {
                $result .= '"';
            }
            $result .= ' id="trad-edit-form-'.$lang->id.'">';
            $result .= '<div class="small-9 columns">';
            if($NewsTrad) {
                $result .= '<input type="text" name="title_'.$lang->langue_abrev.'" placeholder="'.$trad['title_'.$lang->id]['placeholder'].'" value="'.$NewsTrad->title.'">';
                $result .= '</div><div class="small-12 columns">';
                $result .= '<input type="text" name="sub-title_'.$lang->langue_abrev.'" placeholder="'.$trad['sub-title_'.$lang->id]['placeholder'].'" value="'.$NewsTrad->sub_title.'">';
                $result .= '</div><div class="small-12 columns">';
                $result .= '<textarea name="news-editor_'.$lang->langue_abrev.'" class="extend-text" id="news-editor_'.$lang->langue_abrev.'" rows="20">'.$NewsTrad->content.'</textarea>';
            }
            else {
                $result .= '<input type="text" name="title_'.$lang->langue_abrev.'" placeholder="'.$trad['title_'.$lang->id]['placeholder'].'">';
                $result .= '</div><div class="small-12 columns">';
                $result .= '<input type="text" name="sub-title_'.$lang->langue_abrev.'" placeholder="'.$trad['sub-title_'.$lang->id]['placeholder'].'">';
                $result .= '</div><div class="small-12 columns">';
                $result .= '<textarea name="news-editor_'.$lang->langue_abrev.'" class="extend-text" id="news-editor_'.$lang->langue_abrev.'" rows="20"></textarea>';
            }
            $result .= '</div></div>';
        }
        return $result;
    }
    
    private function buildNewsMetasForOneNews($News) {
        $result = '<div class="row">';
            $result .= '<div class="small-12 columns">';
                $result .= $this->buildFormSelectLang($News->id);
            $result .= '</div>';
            $result .= '<div class="small-12 columns">';
                if($News->date_start !== '0000-00-00 00:00:00') {
                    $result .= '<input type="text" name="date-diffusion" class="datepicker" placeholder="Date de diffusion" value="'.$this->convertDateTimeToDate($News->date_start).'">';
                }
                else {
                    $result .= '<input type="text" name="date-diffusion" class="datepicker" placeholder="Date de diffusion">';
                }
            $result .= '</div>';
            $result .= '<div class="small-12 columns">';
                if($News->date_end !== '0000-00-00 00:00:00') {
                    $result .= '<input type="text" name="date-revocation" class="datepicker" placeholder="Date de révocation" value="'.$this->convertDateTimeToDate($News->date_end).'">';
                }
                else {
                    $result .= '<input type="text" name="date-revocation" class="datepicker" placeholder="Date de révocation">';
                }
            $result .= '</div>';
            if($News->imageUrl !== NULL) {
                $result .= '<div class="small-12 columns">';
                    $result .= '<label for="news-img">Modifier une image</label>';
                    $result .= '<input type="file" name="news-img">';
                $result .= '</div>';
                $result .= '<div class="small-12 columns">';
                    $result .= '<img src="../img/img-news/'.$News->imageUrl.'" alt="illustration news" />';
                $result .= '</div>';
                $result .= '<div class="small-12 columns">';
                    $result .= '<input type="checkbox" name="del-news-img" value="1">';
                    $result .= '<label for="del-news-img">Supprimer l\'image</label>';
                $result .= '</div>';
            }
            else {
                $result .= '<div class="small-12 columns">';
                    $result .= '<label for="news-img">Ajouter une image</label>';
                    $result .= '<input type="file" name="news-img">';
                $result .= '</div>';
            }
            $result .= '<div class="small-12 columns">';
                $result .= '<input type="hidden" name="id_news" value="'.$News->id.'">';
                $result .= '<input type="submit" class="button success expand" name="maj-news" value="Mettre à jour">';
            $result .= '</div>';
        $result .= '</div>';
        return $result;
    }
    
    public function buildNewsEditForm($id, $idlang=0) {
        $result = '';
        $trad = $this->getModuleTradIni('news');
        $News = $this->getNewsById($id);
        $result .= '<form name="form_edit_news" action="modules/news/ajax.php" method="post" enctype="multipart/form-data">';
            $result .= '<div class="row">';
                $result .= '<div class="small-9 columns" id="form-trad-wrapper">';
                    $result .= $this->buildTradFieldsForOneNews($id, $trad);
                $result .= '</div>';
                $result .= '<div class="small-3 columns">';
                    $result .= $this->buildNewsMetasForOneNews($News);    
                $result .= '</div>';
            $result .= '</div>';
        $result .= '</form>';
        return $result;
    }
    
    private function buildFormSelectLang($idNews) {
        $Langue = $this->initLangues();
        $result = '<select name="select-lang" id="select-lang-edit" idItem="'.$idNews.'">';
        $result .= '<option value="1" selected>Français</option>';
        foreach($Langue->getLangs() as $k => $lang) {
            $result .= '<option value="'.$lang->id.'">'.$lang->langue.'</option>';
        }
        $result .= '</select>';
        return $result;
    }
    
    private function getNews() {
        try {
            $sql = "SELECT *
                    FROM news ";
            if($this->_status === '0' || $this->_status === '1' || $this->_status === '4') {
                $sql .= "WHERE (status='0' OR status='1' OR status='4') ";
            }
            else {
                $sql .= "WHERE status='".$this->_status."' ";
            }
            $sql .= "ORDER BY date_publi DESC";
            return $this->execQuery($sql);
        }
        catch (PDOException $e) {
            throw new PDOException($e);
        }
    }
    
    private function getNewsById($id) {
        try {
            $sql = "SELECT *
                    FROM news 
                    WHERE id='".$id."'";
            return $this->execOneResultQuery($sql);
        }
        catch (PDOException $e) {
            throw new PDOException($e);
        }
    }
    
    private function getNewsTrad($id) {
        try {
            $sql = "SELECT news_trad.id, id_news, id_lang, title, sub_title, content, langues.langue_abrev
                    FROM news_trad
                    INNER JOIN langues ON langues.id = news_trad.id_lang
                    WHERE news_trad.id_news='".$id."'
                    ORDER BY news_trad.id_lang ASC";
            return $this->execQuery($sql);
        }
        catch (PDOException $e) {
            throw new PDOException($e);
        }
    }
    
    private function getNewsTradByLang($id, $idlang) {
        try {
            $sql = "SELECT *
                    FROM news_trad
                    WHERE id_news='".$id."' AND id_lang='".$idlang."'";
            return $this->execOneResultQuery($sql);
        }
        catch (PDOException $e) {
            throw new PDOException($e);
        }
    }
    
    public function setVisibility($id, $value) {
        try {
            $sql = "UPDATE news 
                    SET status='".$value."' 
                    WHERE id='".$id."'";
            $this->applyOneQuery($sql);
        }
        catch (PDOException $e) {
            throw new PDOException($e);
        }
    }
    
    public function emptyTrash() {
        try {
            $sql = "DELETE n, nt 
                    FROM news AS n
                    JOIN news_trad AS nt ON nt.id_news = n.id
                    WHERE n.status='3'";
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