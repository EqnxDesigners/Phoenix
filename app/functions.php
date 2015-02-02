<?php
//------ Fonctions -----------------------------------------
function setCurrentPage() {
    if(isset($_GET['page'])) {
        $_SESSION['current']['page'] = $_GET['page'];
    }
    else {
        $_SESSION['current']['page'] = DEFAULT_PAGE;
    }
}

function setCurrentLang() {
    if(isset($_GET['lang'])) {
        $_SESSION['current']['lang'] = $_GET['lang'];
    }
    else {
        $_SESSION['current']['lang'] = 'fr';
    }
}

function display_form_inscr_semin() {
    $lay = new Layouts();
    if($lay->checkBoolOpt('FORM_INSCR_SEMIN')) {
        include_once dirname(__FILE__).'/includes/forminscr.inc.php';
    }
}

function getDefaultTrad() {
    $lang = new Langues();
    $file = 'trad_'.$_SESSION['current']['lang'].'.ini';
    $_SESSION['trad'] = $lang->getTradIni($file);
}

function getCurrentUrl($lang) {
    return $lang.'/'.$_SESSION['current']['page'];
}

function buildUrl($page) {
    return $_SESSION['current']['lang'].'/'.$page;
}

function writeParagraphe($paragraphe, $section, $ref) {
    if($paragraphe === '%%UL-'.$ref.'-LI%%') {
        $result = '<ul>';
        foreach($_SESSION['trad'][$section][$ref] as $line) {
            $result .= '<li>'.$line.'</li>';
        }
        $result .= '</ul>';
    }
    else {
        $result = '<p>'.$paragraphe.'</p>';
    }
    echo $result;
}

function the_news() {
    $news = new News();
    try {
        echo $news->displayNews();
    }
    catch (PDOException $e) {
        echo 'ERROR : '.$e.'<br>';
    }
}

function the_last_news() {
    $news = new News();
    try {
        echo $news->displayLastNews();
    }
    catch (PDOException $e) {
        echo 'ERROR : '.$e.'<br>';
    }
}
?>