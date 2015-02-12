<?php
//------ Fonctions -----------------------------------------
function setCurrentPage() {
    setCurrentLang();
    if(isset($_GET['page'])) {
        $_SESSION['current']['page'] = $_GET['page'];
    }
    else {
        $_SESSION['current']['page'] = DEFAULT_PAGE;
    }
    displayCurrentPage();
}

function setCurrentLang() {
    if(isset($_GET['lang'])) {
        $_SESSION['current']['lang'] = $_GET['lang'];
    }
    else {
        $_SESSION['current']['lang'] = 'fr';
    }
    getCurrentTrad();
}

function displayCurrentPage() {
    if($_SESSION['current']['page'] === 'isacademia') {
        include_once dirname(__FILE__).'/includes/isa.inc.php';
    }
    elseif($_SESSION['current']['page'] === 'news') {
        include_once dirname(__FILE__).'/includes/news.inc.php';
    }

    elseif($_SESSION['current']['page'] === 'equinoxe') {
        include_once dirname(__FILE__).'/includes/qui.inc.php';
    }

    else {
        include_once dirname(__FILE__).'/includes/slideshow.inc.php';

        include_once dirname(__FILE__).'/includes/alertes.inc.php';
        include_once dirname(__FILE__).'/includes/alerte-job.inc.php';

        include_once dirname(__FILE__).'/includes/index-isa.inc.php';
        include_once dirname(__FILE__).'/includes/index-news.inc.php';
        include_once dirname(__FILE__).'/includes/index-events.inc.php';
        include_once dirname(__FILE__).'/includes/index-support.inc.php';
    }
}

function display_form_inscr_semin() {
    $lay = new Layouts();
    if($lay->checkBoolOpt('FORM_INSCR_SEMIN')) {
        include_once dirname(__FILE__).'/includes/forminscr.inc.php';
    }
}

function getCurrentTrad() {
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

function getTexte($section, $ref) {
    if(isset($_SESSION['trad'][$section][$ref])) {
        echo $_SESSION['trad'][$section][$ref];
    }
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