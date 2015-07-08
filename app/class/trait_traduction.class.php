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

    public function getTrad($code, $lang, $params = null) {
        try {
            $result = $this->prepareTxt($this->reqTrad($code, $lang)->text);
            if($params != null) {
                $result = $this->replaceParams($result, $params);
            }
            return $result;
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

    private function prepareTxt($txt) {
        $result = $this->buildParagraphes($txt);
        $result = $this->addBreakLines($result);
        return $result;
    }

    private function buildParagraphes($txt) {
        $split = explode('##', $txt);

        if(count($split) > 1) {
            $result = '';
            foreach($split as $para) {
                $result .= '<p>';
                $result .= $para;
                $result .= '</p>';
            }
        }
        else {
            $result = $txt;
        }

        return $result;
    }

    private function addBreakLines($txt) {
        $search = array('@@', '<p></p>');
        $replace = array('<br />', '');
        return str_replace($search, $replace, $txt);
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