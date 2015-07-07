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

class Traductions extends DB {
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
        return $this->getLstTrads();
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

//    public function buildEditForm($id) {
//        $result = '';
//        $Event = $this->getEventById($id);
//        $result .= '<form name="form_edit_event" action="modules/events/ajax.php" method="post" enctype="multipart/form-data">';
//            $result .= '<div class="row">';
//                $result .= '<div class="small-6 columns" id="form-trad-wrapper">';
//                    $result .= '<input type="text" name="event-title" value="'.$Event->title.'" placeholder="Titre">';
//                $result .= '</div>';
//                $result .= '<div class="small-6 columns" id="form-trad-wrapper">';
//                    $result .= '<input type="text" name="date-event" class="datepicker" value="'.$this->convertDateTimeToDate($Event->date).'" placeholder="Date">';
//                $result .= '</div>';
//                $result .= '<div class="small-1 columns" id="form-trad-wrapper">';
//                    $result .= '<input type="text" name="event-hour" value="'.$this->getHourOrMinute($Event->hour).'" placeholder="Heure">';
//                $result .= '</div>';
//                $result .= '<div class="small-1 columns text-center">&nbsp;h&nbsp;</div>';
//                $result .= '<div class="small-1 columns end">';
//                    $result .= '<input type="text" name="event-min" value="'.$this->getHourOrMinute($Event->hour, 'm').'" placeholder="Minute">';
//                $result .= '</div>';
//            $result .= '</div>';
//            $result .= '<div class="row">';
//                $result .= '<div class="small-6 columns" id="form-trad-wrapper">';
//                    $result .= '<input type="hidden" name="id-event" value="'.$Event->id.'">';
//                    $result .= '<input type="submit" class="button success expand" name="edit-event" value="Mettre à jour">';
//                $result .= '</div>';
//            $result .= '</div>';
//        $result .= '</form>';
//        return $result;
//    }

/*
 * $Langue = $this->initLangues();
 *
 * foreach($Langue->getLangs() as $k => $lang) {
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
 */
    
    public function getLstTrads() {
        try {
            $allTrads = $this->getTrads();
            $result = '<ul>';
                $result .= $this->getListingHeader();
            if($allTrads) {
                foreach($allTrads as $K => $trad) {
                    $result .= $this->buildListingLine($trad);
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
        $Langue = $this->initLangues();

        $result = '<li class="row lst-header">';
            $result .= '<div class="small-3 columns">Code</div>';
            foreach($Langue->getLangs() as $k => $lang) {
                $result .= '<div class="small-2 columns">'.$lang->langue.'</div>';
            }
            $result .= '<div class="small-1 columns">&nbsp;</div>';
        $result .= '</li>';
        return $result;
    }
    
    private function buildListingLine($trad) {
        $Langue = $this->initLangues();

        $result  = '<li class="row">';
            $result .= '<div class="small-2 columns">'.$trad->code.'</div>';
//            $result .= '<div class="small-3 columns">'.$this->displayDate($trad->date).'</div>';
//            $result .= '<div class="small-2 columns">'.$trad->hour.'</div>';
            //$result .= '<div class="small-3 columns toolbox text-right">'.$this->buildToolBox($trad).'</div>';
        $result .= '</li>';
        return $result;
    }
    
    private function buildToolBox($item) {
        $result = '';
        if($item->status != '0') {
            $result .= '&nbsp;<i class="fa fa-pencil btn" title="Editer" role="event-edit" item="' . $item->id . '"></i>';
        }
        if($item->status === '0') {
            $result .= '&nbsp;<i class="fa fa-close no-btn" title="Event terminé" role="event-ended" item="'.$item->id.'"></i>';
        }
        elseif($item->status === '1') {
            $result .= '&nbsp;<i class="fa fa-sign-in btn" title="Inscriptions ouvertes" role="event-open" item="'.$item->id.'"></i>';
        }
        elseif($item->status === '2') {
            $result .= '&nbsp;<i class="fa fa-square-o btn" title="Inscriptions fermées" role="event-closed" item="'.$item->id.'"></i>';
        }
        else {
            $result .= '&nbsp;<i class="fa fa-clock-o btn" title="Event à venir" role="event-comming" item="'.$item->id.'"></i>';
        }
        $result .= '&nbsp;<i class="fa fa-trash-o btn" title="Supprimer" role="event-trash" item="'.$item->id.'"></i>';
        return $result;
    }
    
    public function addTrads($data) {
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

    public function editTrads($data) {
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
    
    private function getTrads() {
        try {
            $sql = "SELECT DISTINCT code
                    FROM misc_trad";
            return $this->execQuery($sql);
        }
        catch (PDOException $e) {
            throw new PDOException($e);
        }
    }
    
    private function getTradsById($id) {
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

    public function delTrad($id) {
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