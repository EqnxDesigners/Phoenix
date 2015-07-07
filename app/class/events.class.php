<?php
/*           
==================================================================
Fichier: events.class.php
Description: Class de gestion des events
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
                                $result .= '<a class="inscription-event" event-code="'.$event->code.'" title="inscription event">'.$this->getTrad('OPEN-INSCR-FORM', $this->_idlang).'<span class="icon icon-shape-fleche-droite"></span></a>';
                            }
                        $result .= '</div>';
                    $result .= '</div>';
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
                                            $result .= '<label>'.$this->getTrad('FORM-INSCR-NAME-LABEL', $this->_idlang).'</label>';
                                        $result .= '</div>';
                                    $result .= '</div>';
                                    $result .= '<div class="small-12  medium-6 columns">';
                                        $result .= '<div class="group">';
                                            $result .= '<input type="email" name="email" form-code="event-'.$event->code.'"/>';
                                            $result .= '<label>'.$this->getTrad('FORM-INSCR-EMAIL-LABEL', $this->_idlang).'</label>';
                                        $result .= '</div>';
                                    $result .= '</div>';
                                    $result .= '<div class="small-12 columns">';
                                        $result .= '<textarea name="message" rows="5" placeholder="'.$this->getTrad('FORM-INSCR-MSG-PLACEHOLDER', $this->_idlang).'" form-code="event-'.$event->code.'"></textarea>';
                                    $result .= '</div>';
                                $result .= '</div>';
                                $result .= '<div class="row hidden">';
                                    $result .= '<input type="hidden" name="eventName" value="'.$event->title.'" form-code="event-'.$event->code.'"/>';
                                    $result .= '<input type="hidden" name="eventDate" value="le '.$this->displayTxtDate($event->date, $this->_lang).' à '.$event->hour.'" form-code="event-'.$event->code.'"/>';
                                    $result .= '<input type="hidden" name="eventPlace" value="'.$this->getTrad('FORM-INSCR-LIEU', $this->_idlang).'" form-code="event-'.$event->code.'"/>';
                                $result .= '</div>';
                                $result .= '<div class="row">';
                                    $result .= '<div class="small-12 medium-6 columns text-center">';
                                        $result .= '<input type="button" value="'.$this->getTrad('FORM-INSCR-BTN-CANCEL', $this->_idlang).'" class="button inscr-form-cancel"/>';
                                    $result .= '</div>';
                                    $result .= '<div class="small-12 medium-6 columns text-center">';
                                        $result .= '<input type="button" value="'.$this->getTrad('FORM-INSCR-BTN-SEND', $this->_idlang).'" class="button send-form" form-code="event-'.$event->code.'"/>';
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
            $result .= '</div>';
        }
        catch(PDOException $e) {
            throw new PDOException($e);
        }
        return $result;
    }

    private function getEventText($event) {
        if($event->status === '1') {
            $result = $this->getTradWithParams('FORM-INSCR-TXT-INSCR', $this->_idlang, array($this->displayTxtDayFromDate($event->date, $this->_lang), $this->displayTxtDate($event->date, $this->_lang), $event->hour));
        }
        elseif($event->status === '2') {
            $result = $this->getTrad('FORM-INSCR-TXT-INSCR-CLOSE', $this->_idlang);
        }
        else {
            $result = $this->getTrad('FORM-INSCR-TXT-FUTUR-EVENT', $this->_idlang);
        }
        return $result;
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

	public function __destruct() {
           
	}
}