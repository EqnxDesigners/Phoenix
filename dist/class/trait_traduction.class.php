<?php
trait Trait_traduction {
    
//    public function getTradPlaceholder($name) {
//        $trad = $this->getModuleTradIni();
//        var_dump($trad);
//        return $trad[$name]['placeholder'];
//    }
    
    public function getModuleTradIni($module) {
        $path = dirname(__DIR__).'/admin/modules/'.$module.'/translate.ini';
        return parse_ini_file($path, true);
    }
}
?>