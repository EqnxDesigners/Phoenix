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

//function classAutoLoad() {
//    $result = array();
//    $directory = dirname(__FILE__).'/class/';
//
//    if (is_dir($directory)) {
//        if ($dh = opendir($directory)) {
//            while (($file = readdir($dh)) !== false) {
//                if($file!='..' && $file!='.' && $file!='.DS_Store') {
//                    array_push($result, $file);
//                }
//            }
//            closedir($dh);
//        }
//    }
//    foreach($result as $k => $class) {
//        require_once dirname(__FILE__).'/class/'.$class;
//    }
//}

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
        display_alertes();
        include_once dirname(__FILE__).'/includes/index-isa.inc.php';
        include_once dirname(__FILE__).'/includes/index-news.inc.php';
        include_once dirname(__FILE__).'/includes/index-events.inc.php';
        include_once dirname(__FILE__).'/includes/index-support.inc.php';
    }
}

function display_alertes() {
    $Layout = new Layouts();

    if($Layout->checkBoolOpt('DISPLAY_VIDEOS_ALERT')) {
        include_once dirname(__FILE__).'/includes/alertes.inc.php';
    }

    if($Layout->checkBoolOpt('DISPLAY_JOB_ALERT')) {
        include_once dirname(__FILE__).'/includes/alerte-job.inc.php';
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

function getMultiLineTexte($section, $ref, $class='') {
    if(isset($_SESSION['trad'][$section][$ref])) {
        foreach($_SESSION['trad'][$section][$ref] as $k => $txt) {
//            echo '<p>'.$txt.'</p>';
            writeParagraphe($txt, $section, $ref, $class);
        }
    }
}

function writeParagraphe($paragraphe, $section, $ref, $class) {
    if($paragraphe === '%%UL-'.$ref.'-LI%%') {
        $result = '<ul>';
        foreach($_SESSION['trad'][$section][$ref] as $line) {
            $result .= '<li>'.$line.'</li>';
        }
        $result .= '</ul>';
    }
    else {
        $result = '<p class="'.$class.'">'.$paragraphe.'</p>';
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