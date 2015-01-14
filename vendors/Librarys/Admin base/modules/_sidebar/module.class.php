<?php
class SIDEBAR extends DB {
    public function getLayoutLstPages() {
        if($this->getLstPages()) {
            $result  = '<ul class="unsortable" alt="lst-pages">';
            foreach($this->getLstPages() as $page) {
                $result .= '<li class="page-selector" role="'.$page['id_page'].'" style="cursor:pointer; height:38px;"><div class="row">';
                $result .= '<div class="ten columns"><strong>'.$page['page_name'].'</strong></div>';
                $result .= '<div class="two columns notifier" id="notifier-'.$page['id_page'].'"></div>';
                $result .= '</div>';
                $result .= '</li>'; 
            }
            $result .= '</ul>';
        }
        else {
            $result  = '<ul class="unsortable" alt="lst-pages">';
            $result .= '<li><div class="row">';
            $result .= '<div class="twelve columns">Aucune page...</div>';
            $result .= '</div></li>';
        }
        return $result;
    }
    
    public function getLayoutLstWidgets($idpage) {
        if($this->getLstWidgets()) {
            $result  = '<ul class="unsortable" alt="lst-widget">';
            foreach($this->getLstWidgets() as $widget) {
                $result .= '<li class="widget-selector" role="'.$widget['id'].'" alt="'.$idpage.'" style="cursor:pointer;"><div class="row">';
                $result .= '<div class="ten columns"><strong>'.$widget['widget_name'].'</strong></div>';
                $result .= '<div class="two columns"><img src="imgs/bton_add.png"></div>';
                $result .= '</div>';
                $result .= '</li>';
            }
            $result .= '</ul>';
        }
        else {
            $result  = '<ul class="unsortable" alt="lst-widget">';
            $result .= '<li><div class="row">';
            $result .= '<div class="twelve columns">Aucun widget...</div>';
            $result .= '</div></li>';
        }
        return $result;
    }
    
    public function getLayoutLstAssignedWidgets($idpage) {
        if($this->getLstAssignedWidgets($idpage)) {
            $result  = '<ul class="sortable ui-sortable" alt="lst-assigned-widget">';
            foreach($this->getLstAssignedWidgets($idpage) as $widget) {
                $result .= '<li role="'.$widget['id_assigned_widget'].'#"><div class="row">';
                $result .= '<div class="seven columns"><strong>'.$widget['widget_name'].'</strong></div>';
                $result .= '<div class="three columns text-right">'.$this->getMasterSwitch($widget['id_assigned_widget'], $widget['active'], 'widget').'</div>';
                $result .= '<div class="two columns"><img src="imgs/bton_del.png" class="tool" role="open_del_box" alt="'.$widget['id_assigned_widget'].'"></div>';
                $result .= '</div>';
                //Supprimer un menu
                $result .= '<div class="row pop-box" id="del_'.$widget['id_assigned_widget'].'">';
                $result .= '<div class="twelve columns">Etes-vous sûre de vouloir supprimer ce widget ?<br>
                            <a href="#" class="tool" role="remove-widget" alt="'.$widget['id_assigned_widget'].'" idpage="'.$idpage.'">OUI</a> / <a href="#" class="tool" role="close_pop_box">NON</a></div>';
                $result .= '</div>';
                
                $result .= '</li>';
            }
            $result .= '</ul>';
        }
        else {
            $result  = '<ul class="unsortable" alt="lst-assigned-widget">';
            $result .= '<li><div class="row">';
            $result .= '<div class="twelve columns">Aucun widget...</div>';
            $result .= '</div></li>';
        }
        return $result;
    }
    
    private function getLstPages() {
        $query = "SELECT lay_pages.id AS id_page, page_name, active, title
                    FROM lay_pages
                    INNER JOIN trad_pages ON trad_pages.id_page = lay_pages.id
                    WHERE trad_pages.id_lang = '1'";
        return $result = $this->executeExternalQuery($query);
    }
    
    private function getLstWidgets() {
        $query = "SELECT * FROM lay_widgets ORDER BY widget_name ASC";
        return $result = $this->executeExternalQuery($query);
    }
    
    public function getLstAssignedWidgets($idpage) {
        $query = "SELECT lay_sidebar_content.id AS id_assigned_widget, active, widget_name
                    FROM lay_sidebar_content
                    INNER JOIN lay_widgets ON lay_widgets.id = lay_sidebar_content.id_widget
                    WHERE lay_sidebar_content.id_page='".$idpage."'
                    ORDER BY lay_sidebar_content.sort ASC";
        return $this->executeExternalQuery($query);
    }


    private function getPageNameById($id) {
        $query = mysql_query("SELECT page_name FROM lay_pages WHERE id='".$id."'");
        return mysql_result($query, 0);
    }    
    
    public function getLastSort($idpage) {
        $query = mysql_query("SELECT sort FROM lay_sidebar_content WHERE id_page='".$idpage."' ORDER BY sort DESC LIMIT 1");
        if(mysql_num_rows($query)) {
            $result = mysql_result($query, 0) + 1;
        }
        else {
            $result = '1';
        }
        return $result;
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