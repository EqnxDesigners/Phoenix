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

class Events extends DB {
    /* TRAITS */
    use Trait_datetime, Trait_renderhtml, Trait_traduction;
    
	/* ATTRIBUTS */
	private $_lang;
	private $_idlang;
	
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
	
	/* SETTER */
	public function setLang($lang)		            { $this->_lang = $lang; }
	public function setIdLang($idlang)		        { $this->_idlang = $idlang; }
    
    /* INITTER */
    public function initLangues() {
        return new Langues();
    }
	
    /* METHODES */
    public function reloadListing() {
        return $this->getLstEvents();
    }

    public function buildEventTabs() {
        $this->cleanOldEvents();
        try {
            $Events = $this->getEventsToCome();
            $result = '<ul class="tabs vertical" data-tab>';
            foreach($Events as $k => $event) {
                $result .= '<li class="tab-title';
                $result .= ($k === 0 ? ' active">' : '">');
                $result .= '<a href="#panelEvent'.$k.'" title="panel">'.stripslashes($event->title).'<span>'.$this->displayTxtDate($event->date, $this->_lang).'</span></a>';
                $result .= '</li>';
            }
            $result .= '</ul>';
        }
        catch(PDOException $e) {
            throw new PDOException($e);
        }
        return $result;
    }

    public function buildEventDetails() {
        try {
            $Events = $this->getEventsToCome();
            $result = '<div class="tabs-content">';
            foreach($Events as $k => $event) {
                $result .= '<div class="row content';
                $result .= ($k === 0 ? ' active" id="panelEvent'.$k.'">' : '" id="panelEvent'.$k.'">');
                    $result .= '<div class="row data-event-'.$event->code.'">';
                        $result .= '<div class="small-12 columns event-details">';
                            $result .= '<div class="small-12 columns">';
                                $result .= '<h4>'.$event->title.'</h4>';
                                $result .= '<span class="date">'.$this->displayTxtDate($event->date, $this->_lang).'</span>';
                            $result .= '</div>';
                            $result .= '<div class="small-12 columns">';
                                $result .= $this->getEventText($event);
                            $result .= '</div>';
                        $result .= '</div>';

                        $result .= '<div class="small-12 columns action-inscription">';
                            if($event->status === '1') {
                                $result .= '<a class="inscription-event" event-code="'.$event->code.'" title="inscription event">'.$this->getBtnText($event).'<span class="icon icon-shape-fleche-droite"></span></a>';
                            }
                        $result .= '</div>';
                    $result .= '</div>';
                $result .= '</div>';
            }
            $result .= '</div>';

            if($event->status === '1') {
                $result .= '<div class="row inscription-event-'.$event->code.'" style="display:none;">';
                    $result .= '<div class="small-12 columns event-details">';
                        $result .= '<h4>Inscription à <strong>'.$event->title.'</strong></h4>';
                        $result .= '<form class="inscription-form">';
                            $result .= '<div class="row">';
                                $result .= '<div class="small-12 medium-6 columns">';
                                    $result .= '<div class="group">';
                                        $result .= '<input type="text" name="nom" form-code="event-'.$event->code.'"/>';
                                        $result .= '<label>'.$this->getFormInscrTxt('FORM-INSCR-NAME-LABEL')->text.'</label>';
                                    $result .= '</div>';
                                $result .= '</div>';
                                $result .= '<div class="small-12  medium-6 columns">';
                                    $result .= '<div class="group">';
                                        $result .= '<input type="email" name="email" form-code="event-'.$event->code.'"/>';
                                        $result .= '<label>'.$this->getFormInscrTxt('FORM-INSCR-EMAIL-LABEL').'</label>';
                                    $result .= '</div>';
                                $result .= '</div>';
                                $result .= '<div class="small-12 columns">';
                                    $result .= '<textarea name="message" rows="5" placeholder="'.$this->getFormInscrTxt('FORM-INSCR-MSG-PLACEHOLDER').'" form-code="event-'.$event->code.'"></textarea>';
                                $result .= '</div>';
                                $result .= '</div>';
                                $result .= '<div class="row hidden">';
                                    $result .= '<input type="hidden" name="eventName" value="'.$event->title.'" form-code="event-'.$event->code.'"/>';
                                    $result .= '<input type="hidden" name="eventDate" value="le '.$this->displayTxtDate($event->date, $this->_lang).' à '.$event->hour.'" form-code="event-'.$event->code.'"/>';
                                    $result .= '<input type="hidden" name="eventPlace" value="'.$this->getFormInscrTxt('FORM-INSCR-LIEU').'" form-code="event-'.$event->code.'"/>';
                                $result .= '</div>';
                                $result .= '<div class="row">';
                                    $result .= '<div class="small-12 medium-6 columns text-center">';
                                        $result .= '<input type="button" value="'.$this->getFormInscrTxt('FORM-INSCR-BTN-CANCEL').'" class="button inscr-form-cancel"/>';
                                    $result .= '</div>';
                                $result .= '<div class="small-12 medium-6 columns text-center">';
                                    $result .= '<input type="button" value="'.$this->getFormInscrTxt('FORM-INSCR-BTN-SEND').'" class="button send-form" form-code="event-'.$event->code.'"/>';
                                    $result .= '<span class="send-spinner" style="display:none;">';
                                        $result .= '<div class="bounce1"></div>';
                                        $result .= '<div class="bounce2"></div>';
                                        $result .= '<div class="bounce3"></div>';
                                    $result .= '</span>';
                                $result .= '</div>';
                            $result .= '</div>';
                        $result .= '</form>';
                    $result .= '</div>';
                $result .= '</div>';
            }
        }
        catch(PDOException $e) {
            throw new PDOException($e);
        }
        return $result;
    }

    private function getEventText($event) {
        if($this->_lang === 'fr') {
            if($event->status === '1') {
                $result = "<p>Notre prochain séminaire aura lieu le ".$this->displayTxtDayFromDate($event->date, $this->_lang)." ".$this->displayTxtDate($event->date, $this->_lang)." à $event->hour.<br>Nous vous donnons rendez-vous à l'EPFL Innovation Park, 1er étage du bâtiment C dans la salle <strong>Neptune</strong>.</p>";
                $result .= "<p>La liste des sujets présentés sera publiée 10 jours avant le séminaire.</p>";
            }
            elseif($event->status === '2') {
                $result = "<p>Les inscriptions sont momentanément fermées. Pour plus d'information, merci de nous constacter par e-mail ou téléphone.</p>";
            }
            else {
                $result = "<p>Toutes les informations vous seront communiquées ultérieurement...</p>";
            }
        }
        elseif($this->_lang === 'en') {
            if($event->status === '1') {
                $result = "<p>Our next seminar will take place on the ".$this->displayTxtDayFromDate($event->date, $this->_lang)." ".$this->displayTxtDate($event->date, $this->_lang)." at $event->hour AM.<br>We will meet at the EPFL Innovation Park, in the <strong>Neptune</strong> auditorium at the 1st floor of the Building C.</p>";
                $result .= "<p>The list of presented topics will be published 10 days before the seminar.</p>";
            }
            elseif($event->status === '2') {
                $result = "<p>Registration are temporarly closed. For more informations, please contact us by email or phone.</p>";
            }
            else {
                $result = "<p>Further information will be communicated later...</p>";
            }
        }
        elseif($this->_lang === 'it') {
            if($event->status === '1') {
                $result = "<p>Il nostro prossimo seminario si terrà ".$this->displayTxtDayFromDate($event->date, $this->_lang)." ".$this->displayTxtDate($event->date, $this->_lang)." alle $event->hour.<br>Vi diamo appuntamento all'Innovation Park dell'EPFL, Stabile C, primo piano sala <strong>Neptune</strong>.</p>";
                $result .= "<p>La lista delle presentazioni sarà pubblicata 10 giorni prima del seminario.</p>";
            }
            elseif($event->status === '2') {
                $result = "<p>La registrazione è momentaneamente chiuso. Per ulteriori informazioni, vi ringrazio constacter via email o telefono.</p>";
            }
            else {
                $result = "<p>Tutte le informazioni relative al seminario saranno communicate ulteriormente...</p>";
            }
        }
        else {
            if($event->status === '1') {
                $result = "<p>Unser nächste IS-Academia Seminar wird am ".$this->displayTxtDayFromDate($event->date, $this->_lang)." den ".$this->displayTxtDate($event->date, $this->_lang)." um $event->hour stattfinden.<br> Treffpunkt : Innovation Park EPFL, 1. Stock (Gebäude C), Konferenzzimmer <strong>Neptune</strong>.</p>";
                $result .= "<p>Die vorgesehene Themen werden 10 Tage vor dem Seminar veröffentlicht.</p>";
            }
            elseif($event->status === '2') {
                $result = "<p>Das Einschreibefenster ist zu. Für weitere Auskünfte stehen wir Ihnen per Telefon oder E-Mail zur Verfügung.</p>";
            }
            else {
                $result = "<p>Detaillierte Informationen werden später kommuniziert...</p>";
            }
        }
        return $result;
    }

    private function getFormInscrTxt($code) {
        try {
            $sql = "SELECT text
                    FROM events_trad
                    WHERE code='".$code."' AND id_lang='".$this->_idlang."'";
            return $this->execOneResultQuery($sql);
        }
        catch (PDOException $e) {
            throw new PDOException($e);
        }
    }

    private function getLabelText($label) {
        if($this->_lang === 'fr') {
            ($label === '1' ? $result = "Nom prénom" : $result = "E-mail");
        }
        elseif($this->_lang === 'en') {
            ($label === '1' ? $result = "Name, First name" : $result = "E-mail");
        }
        elseif($this->_lang === 'it') {
            ($label === '1' ? $result = "Cognome Nome" : $result = "E-mail");
        }
        else {
            ($label === '1' ? $result = "Name Vorname" : $result = "E-mail");
        }
        return $result;
    }

    private function getBtnText() {
        if($this->_lang === 'fr') {
            $result = "Inscription";
        }
        elseif($this->_lang === 'en') {
            $result = "Registration";
        }
        elseif($this->_lang === 'it') {
            $result = "Registrazione";
        }
        else {
            $result = "Anmeldung";
        }
        return $result;
    }

//    public function displayNews($currentPage, $max = 6) {
//        try {
//            if($allNews = $this->getNewsToDisplay($currentPage, $max)) {
//                $result = '';
//                foreach($allNews as $k => $news) {
//
//
//                    $result .= '<div class="article">';
//                        if($news->imageUrl !== NULL){
//                            $result .= '<div class="image" style="background-image:url(img/img-news/'.$news->imageUrl.');"></div>';
//                        }
//                        $result .= '<div class="content">';
//                            $result .= '<div class="header">';
//                                $result .= '<span class="date">'.$this->displayDate($news->date_update).'</span>';
//                                $result .= '<h1>'.$news->title.'</h1>';
//                                $result .= '<h2>'.$news->sub_title.'</h2>';
//                            $result .= '</div>';
//                            $result .= '<div class="body multiplecolumns">';
//                                $result .= $news->content;
//                            $result .= '</div>';
//                        $result .= '</div>';
//                    $result .= '</div>';
//                }
//            }
//            else {
//                $result = '<div class="new" style="width:100%">';
//                    $result .= '<div class="content">';
//                        $result .= '<div class="row">';
//                            $result .= '<div class="small-12 columns">';
//                                $result .= 'Aucune news pour le moment...';
//                            $result .= '</div>';
//                        $result .= '</div>';
//                    $result .= '</div>';
//                $result .= '</div>';
//            }
//        }
//        catch (PDOException $e) {
//            throw new PDOException($e);
//        }
//        return $result;
//    }

//    public function displayLastNews($max = 2) {
//        try {
//            if($allNews = $this->getNewsToDisplay(0, $max)) {
//                $nbcol = 12 / $max;
//                $result = '';
//                foreach($allNews as $k => $news) {
//                    $result .= '<div class="small-12 medium-'.$nbcol.' columns article" data-equalizer-watch>';
//                        if($news->imageUrl !== NULL){
//                            $result .= '<div class="image" style="background-image:url(img/img-news/'.$news->imageUrl.');"></div>';
//                        }
//                        $result .= '<div class="content">';
//                            $result .= '<div class="header">';
//                                $result .= '<span class="date">'.$this->displayDate($news->date_update).'</span>';
//                                $result .= '<h1>'.$news->title.'</h1>';
//                                $result .= '<h2>'.$news->sub_title.'</h2>';
//                            $result .= '</div>';
//                            $result .= '<div class="body multiplecolumns">';
//                                $result .= $news->content;
//                            $result .= '</div>';
//                        $result .= '</div>';
//                    $result .= '</div>';
//                }
//            }
//        }
//        catch (PDOException $e) {
//            throw new PDOException($e);
//        }
//        return $result;
//    }

//    public function getPagination($currentPage, $max = 6) {
//        $nbPage = ceil(count($this->getNewsToDisplay()) / $max);
//        $numPage = 1;
//        $result = '';
//
//        if($nbPage > 1) {
//            $lastPage = $currentPage - 1;
//            $nextPage = $currentPage + 1;
//
//            $result .= '<ul class="pag">';
//            $result .= ($nbPage > 1 && $currentPage != '1' ? '<li class="fleche prev"><a href="'.$_SESSION['current']['lang'].'/news-'.$lastPage.'"><img src="img/fleche-bleue-prev.png" alt="prev" /></a></li>' : '<li>&nbsp;</li>');
//            for($i=0;$i<$nbPage;$i++) {
//                $result .= '<li';
//                $result .= ($currentPage == $numPage ? ' class="active">' : '>');
//                $result .= '<a href="'.$_SESSION['current']['lang'].'/news-'.$numPage.'">'.$numPage.'</a>';
//                $result .= '</li>';
//                $numPage++;
//            }
//            $result .= ($nbPage > 1 && $currentPage < $nbPage ? '<li class="fleche next"><a href="'.$_SESSION['current']['lang'].'/news-'.$nextPage.'"><img src="img/fleche-bleue-next.png" alt="next" /></a></li>' : '<li>&nbsp;</li>' );
//            $result .= '</ul>';
//        }
//
//        return $result;
//    }
    
//    private function getNewsToDisplay($currentPage = 0, $max = 9999999) {
//        try {
//            $sql = "SELECT news.id AS idnews, date_publi, date_start, date_end, date_update, title, sub_title, content, imageUrl
//                    FROM news
//                    INNER JOIN news_trad ON news.id = news_trad.id_news
//                    WHERE news.status='1' ";
//            $sql .= ($this->_lang === 'fr' || $this->_lang === 'en' ? "AND news_trad.id_lang = '".$this->_idlang."' " : "AND news_trad.id_lang = '".$this->_idlang."' OR news_trad.id_lang = 'en' ");
//            if($currentPage === 0 || $currentPage == '1') {
//                $sql .= "ORDER BY news.date_publi DESC LIMIT ".$max;
//            }
//            else {
//                $sqlMin = ($currentPage - 1) * $max;
//                $sqlMax = $sqlMin + $max;
//                $sql .= "ORDER BY news.date_publi DESC LIMIT ".$sqlMin.", ".$sqlMax;
//            }
//            return $this->execQuery($sql);
//        }
//        catch (PDOException $e) {
//            throw new PDOException($e);
//        }
//    }
    
    private function reqIdLang() {
        try {
            $sql = "SELECT id FROM langues WHERE langue_abrev='".$this->_lang."'";
            return $this->execOneResultQuery($sql);
        }
        catch (PDOException $e) {
            throw new PDOException($e);
        }
    }

    public function buildEditForm($id) {
        $result = '';
        $Event = $this->getEventById($id);
        $result .= '<form name="form_edit_event" action="modules/events/ajax.php" method="post" enctype="multipart/form-data">';
            $result .= '<div class="row">';
                $result .= '<div class="small-6 columns" id="form-trad-wrapper">';
                    $result .= '<input type="text" name="event-title" value="'.$Event->title.'" placeholder="Titre">';
                $result .= '</div>';
                $result .= '<div class="small-6 columns" id="form-trad-wrapper">';
                    $result .= '<input type="text" name="date-event" class="datepicker" value="'.$this->convertDateTimeToDate($Event->date).'" placeholder="Date">';
                $result .= '</div>';
                $result .= '<div class="small-1 columns" id="form-trad-wrapper">';
                    $result .= '<input type="text" name="event-hour" value="'.$this->getHourOrMinute($Event->hour).'" placeholder="Heure">';
                $result .= '</div>';
                $result .= '<div class="small-1 columns text-center">&nbsp;h&nbsp;</div>';
                $result .= '<div class="small-1 columns end">';
                    $result .= '<input type="text" name="event-min" value="'.$this->getHourOrMinute($Event->hour, 'm').'" placeholder="Minute">';
                $result .= '</div>';
            $result .= '</div>';
            $result .= '<div class="row">';
                $result .= '<div class="small-6 columns" id="form-trad-wrapper">';
                    $result .= '<input type="hidden" name="id-event" value="'.$Event->id.'">';
                    $result .= '<input type="submit" class="button success expand" name="edit-event" value="Mettre à jour">';
                $result .= '</div>';
            $result .= '</div>';
        $result .= '</form>';
        return $result;
    }
    
    public function getLstEvents() {
        try {
            $allEvents = $this->getEvents();
            $result = '<ul>';
                $result .= $this->getListingHeader();
            if($allEvents) {
                foreach($allEvents as $K => $event) {
                    $result .= $this->buildListingLine($event);
                }
            }
            else {
                $result .= '<li class="row"><div class="small-12 columns">Aucune Events pour le moment...</div></li>';
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
            $result .= '<div class="small-4 columns">Event</div>';
            $result .= '<div class="small-3 columns">Date</div>';
            $result .= '<div class="small-2 columns">Heure</div>';
            $result .= '<div class="small-3 columns">&nbsp;</div>';
        $result .= '</li>';
        return $result;
    }
    
    private function buildListingLine($event) {
        $result  = '<li class="row">';
        $result .= '<div class="small-4 columns"><strong>'.$event->title.'</strong></div>';
        $result .= '<div class="small-3 columns">'.$this->displayDate($event->date).'</div>';
        $result .= '<div class="small-2 columns">'.$event->hour.'</div>';
        $result .= '<div class="small-3 columns toolbox text-right">'.$this->buildToolBox($event).'</div>';
        $result .= '</li>';
        return $result;
    }
    
    private function buildToolBox($item) {
        $result = '';
        if($item->status != '0') {
            $result .= '&nbsp;<i class="fa fa-pencil btn" role="event-edit" item="' . $item->id . '"></i>';
        }
        if($item->status === '0') {
            $result .= '&nbsp;<i class="fa fa-close no-btn" role="event-ended" item="'.$item->id.'"></i>';
        }
        elseif($item->status === '1') {
            $result .= '&nbsp;<i class="fa fa-sign-in btn" role="event-open" item="'.$item->id.'"></i>';
        }
        elseif($item->status === '2') {
            $result .= '&nbsp;<i class="fa fa-square-o btn" role="event-closed" item="'.$item->id.'"></i>';
        }
        else {
            $result .= '&nbsp;<i class="fa fa-clock-o btn" role="event-comming" item="'.$item->id.'"></i>';
        }
        $result .= '&nbsp;<i class="fa fa-trash-o btn" role="event-trash" item="'.$item->id.'"></i>';
        return $result;
    }
    
    public function addEvent($data) {
        try {
            $sql = "INSERT INTO events (code,title,date,hour,status)
                    VALUES ('".$this->buildEventCode($data['date-event'])."',
                            '".addslashes($data['event-title'])."',
                            '".$this->setDateTime($data['date-event'])."',
                            '".$this->buildEventHour($data['event-hour'], $data['event-min'])."',
                            '3')";
            $this->applyOneQuery($sql);
        }
        catch (PDOException $e) {
            throw new PDOException($e);
        }
    }

    public function editEvent($data) {
        try {
            $sql = "UPDATE events ";
            $sql .= "SET code='".$this->buildEventCode($data['date-event'])."', ";
            $sql .= "title='".addslashes($data['event-title'])."', ";
            $sql .= "date='".$this->setDateTime($data['date-event'])."', ";
            $sql .= "hour='".$this->buildEventHour($data['event-hour'], $data['event-min'])."' ";
            $sql .= "WHERE id='".$data['id-event']."'";
            $this->applyOneQuery($sql);
        }
        catch (PDOException $e) {
            throw new PDOException($e);
        }
    }

    private function buildEventCode($date) {
        $num = explode('.', $date);
        return 'sem'.substr($num['2'], -2).$num['1'].$num['0'];
    }

    private function buildEventHour($heure, $minute) {
        return $heure.'h'.$minute;
    }

    private function getHourOrMinute($time, $item = 'h') {
        $split = explode('h', $time);
        if($item === 'h') {
            $result = $split['0'];
        }
        else {
            $result = $split['1'];
        }
        return $result;
    }
    
//    public function publishNews($data, $fileName) {
//        $Langue = $this->initLangues();
//        try {
//            $lastId = $this->insertNewsMeta($data, $fileName, '1');
//            if(isset($data['idem-all-lang'])) {
//                foreach($Langue->getLangs() as $k => $lang) {
//                    try {
//                        $this->insertNewsTrad($data, $lang, $Langue->getLangByiD($data['select-lang']), $lastId);
//                    }
//                    catch (PDOException $e) {
//                        throw new PDOException($e);
//                    }
//                }
//            }
//            else {
//                foreach($Langue->getLangs() as $k => $lang) {
//                    if(strlen($data['title_'.$lang->langue_abrev]) > 0 && strlen($data['news-editor_'.$lang->langue_abrev]) > 0) {
//                        try {
//                            $this->insertOneNewsTrad($data, $lang, $lastId);
//                        }
//                        catch (PDOException $e) {
//                            throw new PDOException($e);
//                        }
//                    }
//                }
//            }
//        }
//        catch (PDOException $e) {
//            throw new PDOException($e);
//        }
//    }
    
//    public function majNews($data, $fileName) {
//        $Langue = $this->initLangues();
//        if(strlen($data['date-diffusion'] > 0)) {
//            try {
//                $this->updateNewsMetaField('date_start', $this->setDateTime($data['date-diffusion']), $data['id_news']);
//            }
//            catch (PDOException $e) {
//                throw new PDOException($e);
//            }
//        }
//       if(strlen($data['date-revocation'] > 0)) {
//            try {
//                $this->updateNewsMetaField('date_end', $this->setDateTime($data['date-revocation']), $data['id_news']);
//            }
//            catch (PDOException $e) {
//                throw new PDOException($e);
//            }
//        }
//        if($fileName !== 'NULL') {
//            try {
//                if($this->delOldImage($data['id_news'])) {
//                    $this->updateNewsMetaField('imageUrl', $fileName, $data['id_news']);
//                }
//                else {
//                    throw new Exception("Impossible de supprimer l'ancienne image...");
//                }
//            }
//            catch (PDOException $e) {
//                throw new PDOException($e);
//            }
//        }
//        if(isset($data['del-news-img']) && $data['del-news-img'] === '1') {
//            try {
//                if($this->delOldImage($data['id_news'])) {
//                    $this->updateNewsMetaField('imageUrl', 'NULL', $data['id_news']);
//                }
//                else {
//                    throw new Exception("Impossible de supprimer l'ancienne image...");
//                }
//            }
//            catch (PDOException $e) {
//                throw new PDOException($e);
//            }
//        }
//        foreach($Langue->getLangs() as $k => $lang) {
//            if($this->checkIfNewsEntry($data['id_news'], $lang->id)) {
//                //Mise à jour de la news
//                try {
//                    $this->updateNewsTrad($data, $lang);
//                }
//                catch (PDOException $e) {
//                    throw new PDOException($e);
//                }
//            }
//            else {
//                //Test si il y a un titre et du contenu
//                if(strlen($data['title_'.$lang->langue_abrev]) > 0 && strlen($data['news-editor_'.$lang->langue_abrev]) > 0) {
//                    try {
//                        $this->insertNewsTrad($data, $lang, $lang, $data['id_news']);
//                    }
//                    catch (PDOException $e) {
//                        throw new PDOException($e);
//                    }
//                }
//            }
//        }
//        try {
//            $this->updateNewsMetaField('date_update', $this->setDateTimeNow(), $data['id_news']);
//        }
//        catch (PDOException $e) {
//            throw new PDOException($e);
//        }
//    }
          
//    private function updateNewsMetaField($field, $value, $id) {
//        try {
//            $sql = "UPDATE news ";
//            ($value === 'NULL' ? $sql .= "SET ".$field."=NULL " : $sql .= "SET ".$field."='".$value."' ");
//            $sql .= "WHERE id='".$id."'";
//            $this->applyOneQuery($sql);
//        }
//        catch (PDOException $e) {
//            throw new PDOException($e);
//        }
//    }
          
//    private function updateNewsTrad($data, $lang) {
//        try {
//            $sql = "UPDATE news_trad
//                    SET title='".addslashes($data['title_'.$lang->langue_abrev])."',
//                    sub_title='".addslashes($data['sub-title_'.$lang->langue_abrev])."',
//                    content='".addslashes($data['news-editor_'.$lang->langue_abrev])."'
//                    WHERE id_news='".$data['id_news']."' AND id_lang='".$lang->id."'";
//            $this->applyOneQuery($sql);
//        }
//        catch (PDOException $e) {
//            throw new PDOException($e);
//        }
//    }

//    private function delOldImage($id) {
//        try {
//            $oldImageName = $this->getOldImageName($id);
//            if($oldImageName->imageUrl !== NULL) {
//               return unlink('../../../img/img-news/'.$oldImageName->imageUrl);
//            }
//            else {
//                return true;
//            }
//
//        }
//        catch (PDOException $e) {
//            throw new PDOException($e);
//        }
//    }

//    private function getOldImageName($id) {
//        try {
//            $sql = "SELECT imageUrl FROM news WHERE id='".$id."'";
//            return $this->execOneResultQuery($sql);
//        }
//        catch (PDOException $e) {
//            throw new PDOException($e);
//        }
//    }
          
//    private function checkIfNewsEntry($idnews, $idlang) {
//        $sql = "SELECT * FROM news_trad WHERE id_news='".$idnews."' AND id_lang='".$idlang."'";
//        if($this->execOneResultQuery($sql)) {
//            $result = true;
//        }
//        else {
//            $result = false;
//        }
//        return $result;
//    }
    
//    private function insertNewsTrad($data, $lang, $selectedLang, $lastId) {
//        try {
//            $sql = "INSERT INTO news_trad (id_news,id_lang,title,sub_title,content)
//                    VALUES ('".$lastId."',
//                            '".$lang->id."',
//                            '".addslashes($data['title_'.$selectedLang->langue_abrev])."',
//                            '".addslashes($data['sub-title_'.$selectedLang->langue_abrev])."',
//                            '".addslashes($data['news-editor_'.$selectedLang->langue_abrev])."')";
//            $this->applyOneQuery($sql);
//        }
//        catch (PDOException $e) {
//            throw new PDOException($e);
//        }
//    }
    
//    private function insertOneNewsTrad($data, $lang, $lastId) {
//        try {
//            $sql = "INSERT INTO news_trad (id_news,id_lang,title,sub_title,content)
//                    VALUES ('".$lastId."',
//                            '".$lang->id."',
//                            '".addslashes($data['title_'.$lang->langue_abrev])."',
//                            '".addslashes($data['sub-title_'.$lang->langue_abrev])."',
//                            '".addslashes($data['news-editor_'.$lang->langue_abrev])."')";
//            $this->applyOneQuery($sql);
//        }
//        catch (PDOException $e) {
//            throw new PDOException($e);
//        }
//    }
    
//    private function insertNewsMeta($data, $fileName, $status) {
//        try {
//            $dateJour   = $this->setDateTimeNow();
//            $dateStart  = $this->setDateTime($data['date-diffusion']);
//            $dateEnd    = $this->setDateTime($data['date-revocation']);
//
//            $sql = "INSERT INTO news (date_publi,date_start,date_end,date_update,imageUrl,status)
//                        VALUES ('".$dateJour."', '".$dateStart."', '".$dateEnd."', '".$dateJour."', ";
//            if($fileName === 'NULL') {
//                $sql .= " NULL, ";
//            }
//            else {
//                $sql .= " '".$fileName."', ";
//            }
//            $sql .= " '".$status."') ";
//
//            return $this->applyQueryWithLastId($sql);
//        }
//        catch (PDOException $e) {
//            throw new PDOException($e);
//        }
//    }
    
//    private function buildNewsMetasForOneNews($News) {
//        $result = '<div class="row">';
//            $result .= '<div class="small-12 columns">';
//                $result .= $this->buildFormSelectLang($News->id);
//            $result .= '</div>';
//            $result .= '<div class="small-12 columns">';
//                if($News->date_start !== '0000-00-00 00:00:00') {
//                    $result .= '<input type="text" name="date-diffusion" class="datepicker" placeholder="Date de diffusion" value="'.$this->convertDateTimeToDate($News->date_start).'">';
//                }
//                else {
//                    $result .= '<input type="text" name="date-diffusion" class="datepicker" placeholder="Date de diffusion">';
//                }
//            $result .= '</div>';
//            $result .= '<div class="small-12 columns">';
//                if($News->date_end !== '0000-00-00 00:00:00') {
//                    $result .= '<input type="text" name="date-revocation" class="datepicker" placeholder="Date de révocation" value="'.$this->convertDateTimeToDate($News->date_end).'">';
//                }
//                else {
//                    $result .= '<input type="text" name="date-revocation" class="datepicker" placeholder="Date de révocation">';
//                }
//            $result .= '</div>';
//            if($News->imageUrl !== NULL) {
//                $result .= '<div class="small-12 columns">';
//                    $result .= '<label for="news-img">Modifier une image</label>';
//                    $result .= '<input type="file" name="news-img">';
//                $result .= '</div>';
//                $result .= '<div class="small-12 columns">';
//                    $result .= '<img src="../img/img-news/'.$News->imageUrl.'" alt="illustration news" />';
//                $result .= '</div>';
//                $result .= '<div class="small-12 columns">';
//                    $result .= '<input type="checkbox" name="del-news-img" value="1">';
//                    $result .= '<label for="del-news-img">Supprimer l\'image</label>';
//                $result .= '</div>';
//            }
//            else {
//                $result .= '<div class="small-12 columns">';
//                    $result .= '<label for="news-img">Ajouter une image</label>';
//                    $result .= '<input type="file" name="news-img">';
//                $result .= '</div>';
//            }
//            $result .= '<div class="small-12 columns">';
//                $result .= '<input type="hidden" name="id_news" value="'.$News->id.'">';
//                $result .= '<input type="submit" class="button success expand" name="maj-news" value="Mettre à jour">';
//            $result .= '</div>';
//        $result .= '</div>';
//        return $result;
//    }
    
//    public function buildNewsEditForm($id, $idlang=0) {
//        $result = '';
//        $trad = $this->getModuleTradIni('news');
//        $News = $this->getNewsById($id);
//        $result .= '<form name="form_edit_news" action="modules/news/ajax.php" method="post" enctype="multipart/form-data">';
//            $result .= '<div class="row">';
//                $result .= '<div class="small-9 columns" id="form-trad-wrapper">';
//                    $result .= $this->buildTradFieldsForOneNews($id, $trad);
//                $result .= '</div>';
//                $result .= '<div class="small-3 columns">';
//                    $result .= $this->buildNewsMetasForOneNews($News);
//                $result .= '</div>';
//            $result .= '</div>';
//        $result .= '</form>';
//        return $result;
//    }
    
//    private function buildFormSelectLang($idNews) {
//        $Langue = $this->initLangues();
//        $result = '<select name="select-lang" id="select-lang-edit" idItem="'.$idNews.'">';
//        $result .= '<option value="1" selected>Français</option>';
//        foreach($Langue->getLangs() as $k => $lang) {
//            $result .= '<option value="'.$lang->id.'">'.$lang->langue.'</option>';
//        }
//        $result .= '</select>';
//        return $result;
//    }
    
    private function getEvents() {
        try {
            $sql = "SELECT *
                    FROM events
                    ORDER BY date ASC";
            return $this->execQuery($sql);
        }
        catch (PDOException $e) {
            throw new PDOException($e);
        }
    }
    
    private function getEventById($id) {
        try {
            $sql = "SELECT *
                    FROM events
                    WHERE id='".$id."'";
            return $this->execOneResultQuery($sql);
        }
        catch (PDOException $e) {
            throw new PDOException($e);
        }
    }

    private function getEventsToCome() {
        try {
            $sql = "SELECT *
                    FROM events
                    WHERE status<>'0'
                    ORDER BY date ASC";
            return $this->execQuery($sql);
        }
        catch (PDOException $e) {
            throw new PDOException($e);
        }
    }

    private function cleanOldEvents() {
        foreach($this->getEvents() as $k => $event) {
            if($event->date < $this->setDateTimeNow()) {
                $this->setStatus($event->id, '0');
            }
        }
    }
    
//    private function getNewsTrad($id) {
//        try {
//            $sql = "SELECT news_trad.id, id_news, id_lang, title, sub_title, content, langues.langue_abrev
//                    FROM news_trad
//                    INNER JOIN langues ON langues.id = news_trad.id_lang
//                    WHERE news_trad.id_news='".$id."'
//                    ORDER BY news_trad.id_lang ASC";
//            return $this->execQuery($sql);
//        }
//        catch (PDOException $e) {
//            throw new PDOException($e);
//        }
//    }
    
//    private function getNewsTradByLang($id, $idlang) {
//        try {
//            $sql = "SELECT *
//                    FROM news_trad
//                    WHERE id_news='".$id."' AND id_lang='".$idlang."'";
//            return $this->execOneResultQuery($sql);
//        }
//        catch (PDOException $e) {
//            throw new PDOException($e);
//        }
//    }
    
    public function setStatus($id, $value) {
        try {
            $sql = "UPDATE events
                    SET status='".$value."' 
                    WHERE id='".$id."'";
            $this->applyOneQuery($sql);
        }
        catch (PDOException $e) {
            throw new PDOException($e);
        }
    }

    public function delEvent($id) {
        try {
            $sql = "DELETE
                    FROM events
                    WHERE id='".$id."'";
            $this->applyOneQuery($sql);
        }
        catch (PDOException $e) {
            throw new PDOException($e);
        }
    }
    
//    public function emptyTrash() {
//        try {
//            $sql = "DELETE n, nt
//                    FROM news AS n
//                    JOIN news_trad AS nt ON nt.id_news = n.id
//                    WHERE n.status='3'";
//            $this->applyOneQuery($sql);
//        }
//        catch (PDOException $e) {
//            throw new PDOException($e);
//        }
//    }

	public function __destruct() {
           
	}
}