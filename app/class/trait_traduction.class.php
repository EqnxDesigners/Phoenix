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

    public function getTrad($code, $lang) {
        try {
            return $this->reqTrad($code, $lang)->text;
        }
        catch (PDOException $e) {
            throw new PDOException($e);
        }
    }

    public function getTradWithParams($code, $lang, $params) {
        try {
            return $this->replaceParams($this->reqTrad($code, $lang)->text, $params);
        }
        catch (PDOException $e) {
            throw new PDOException($e);
        }
    }

    private function replaceParams($txt, $params) {
        $search = array();
        foreach($params as $k => $param) {
            array_push($search, "%%PARAM".$k."%%");
        }
        return str_replace($search, $params, $txt);
    }

    private function reqTrad($code, $lang) {
        try {
            $sql = "SELECT text
                    FROM misc_trad
                    WHERE code='".$code."' AND id_lang='".$lang."'";
            return $this->execOneResultQuery($sql);
        }
        catch (PDOException $e) {
            throw new PDOException($e);
        }
    }
}
?>