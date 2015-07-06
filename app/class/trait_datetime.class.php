<?php
trait Trait_datetime {
    
    public function displayDate($date) {
        if($date === '0000-00-00 00:00:00') {
            $result = '...';
        }
        else {
            $objDate = new DateTime($date);
            $result = $objDate->format('d.m.Y');
        }
        return $result;
    }

    public function displayTxtDate($date, $lang) {
        if($date === '0000-00-00 00:00:00') {
            $result = '...';
        }
        else {
            ($lang === 'de' ? $format = "%d. %B %Y" : $format = "%d %B %Y");
            $result = strftime($format, strtotime($this->buildTmpDate($date, $lang)));
        }
        return $result;
    }

    public function displayTxtDayFromDate($date, $lang) {
        if($date === '0000-00-00 00:00:00') {
            $result = '...';
        }
        else {
            $result = strftime("%A", strtotime($this->buildTmpDate($date, $lang)));
        }
        return $result;
    }
    
    public function setDateTime($date) {
        if(strlen($date) === 0) {
            $result = $this->setDateTimeNull();
        }
        else {
            $objDate = new DateTime($date);
            $result = $objDate->format('Y-m-d').' '.$this->setTimeNow();
        }
        return $result;
    }
    
    public function setDateTimeNow() {
        return date('Y-m-d H:m:s');
    }
        
    public function setDateTimeNull() {
        return '0000-00-00 00:00:00';
    }
    
    public function setTimeNow() {
        return date('H:m:s');
    }
    
    public function convertDateTimeToDate($date) {
        $split = explode(' ', $date);
        $objDate = explode('-', $split[0]);
        return $objDate[2].'.'.$objDate[1].'.'.$objDate[0];
    }

    private function buildTmpDate($date, $lang) {
        $local = $lang.'_'.strtoupper($lang);
        $objDate = new DateTime($date);
        setlocale(LC_TIME, $local);
        return $objDate->format('d F Y');
    }
}