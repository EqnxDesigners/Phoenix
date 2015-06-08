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
    $_SESSION['current']['meta_description'] = getCurrentPageMetaDescription($_SESSION['current']['page']);
}

function getCurrentPageTitle($page) {
    switch($page) {
        case 'home':
            $result = getSilentTexte('mainmenu', 'label_accueil');
            break;
        case 'equinoxe':
            $result = getSilentTexte('mainmenu', 'label_qui');
            break;
        case 'isacademia':
            $result = getSilentTexte('mainmenu', 'label_is-academia');
            break;
        case 'news':
            $result = getSilentTexte('mainmenu', 'label_news');
            break;
        default:
            $result = getSilentTexte('mainmenu', 'label_accueil');
    }
    return $result;
}

function getCurrentPageMetaDescription($page) {
    switch($page) {
        case 'home':
            $result = getSilentTexte('home-isa', 'page_descr');
            break;
        case 'equinoxe':
            $result = getSilentTexte('qui', 'page_descr');
            break;
        case 'isacademia':
            $result = getSilentTexte('isa', 'page_descr');
            break;
        case 'news':
            $result = getSilentTexte('news', 'page_descr');
            break;
        default:
            $result = getSilentTexte('home-isa', 'page_descr');
    }
    return $result;
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

function the_title() {
    if($_SESSION['current']['page'] === 'home' || $_SESSION['current']['page'] === 'accueil') {
        $result = PAGE_TITLE.'&nbsp;|&nbsp;'.getCurrentPageTitle($_SESSION['current']['page']);
    }
    else {
        $result = getCurrentPageTitle($_SESSION['current']['page']).'&nbsp;|&nbsp;'.PAGE_TITLE;
    }
    echo $result;
}

function classAutoLoad() {
    $DbClass = array();
    $Traits = array();
    $AllClass = array();
    $directory = dirname(__FILE__).'/class/';

    if (is_dir($directory)) {
        if ($dh = opendir($directory)) {
            while (($file = readdir($dh)) !== false) {
                if($file!='..' && $file!='.' && $file!='.DS_Store') {
                    if($file === 'db.class.php') {
                        array_push($DbClass, $file);
                    }
                    elseif(preg_match('/trait_/i', $file)) {
                        array_push($Traits, $file);
                    }
                    else {
                        if($file !== 'PHPMailer') {
                            array_push($AllClass, $file);
                        }
                    }
                }
            }
            closedir($dh);
        }
    }

    requireClass($DbClass);
    requireClass($Traits);
    requireClass($AllClass);
}

function requireClass($LstClass) {
    foreach($LstClass as $k => $class) {
        require_once dirname(__FILE__).'/class/'.$class;
    }
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
        display_alertes();
        include_once dirname(__FILE__).'/includes/index-isa.inc.php';
        include_once dirname(__FILE__).'/includes/index-news.inc.php';
        displayEvents();
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

    if($Layout->checkBoolOpt('DISPLAY_SEMINAIRE_ALERT')) {
        include_once dirname(__FILE__).'/includes/alertes-semi.inc.php';
    }
    if($Layout->checkBoolOpt('DISPLAY_NEWSLETTER_ALERT')) {
        include_once dirname(__FILE__).'/includes/alerte-newsletter.inc.php';
    }
}

function displayAlertJob() {
    $Layout = new Layouts();

    if($Layout->checkBoolOpt('DISPLAY_JOB_ALERT')) {
        include_once dirname(__FILE__).'/includes/alerte-job.inc.php';
    }
}

function displaySelectLang() {
    $Layout = new Layouts();

    if($Layout->checkBoolOpt('DISPLAY_SELECT_LANG')) {
        $result ='<li><span class="icon icon-shape-planete" id="langues-btn"></span></li>';
    }
    else {
        $result ='';
    }
    echo $result;
}

function displaySelectLangMobile() {
    $Layout = new Layouts();

    if($Layout->checkBoolOpt('DISPLAY_SELECT_LANG')) {
        $result ='<span class="icon icon-shape-planete" id="langues-btn-mobile"></span>';
    }
    else {
        $result ='';
    }
    echo $result;
}

function displayEvents() {
    $Layout = new Layouts();

    if($Layout->checkBoolOpt('DISPLAY_EVENTS')) {
        include_once dirname(__FILE__).'/includes/index-events.inc.php';
    }
}

function getCurrentTrad() {
    $lang = new Langues();
    $file = 'trad_'.$_SESSION['current']['lang'].'.ini';
    $_SESSION['trad'] = $lang->getTradIni($file);
}

function getCurrentUrl($lang) {
    return $lang.'/'.getCurrentPageName();
}

function getCurrentPageName() {
    $str = $_SERVER['QUERY_STRING'];
    $start = strpos($str, '=') + 1;
    $end = strpos($str, '&');
    $length = $end - $start;
    return substr($str, $start, $length);
}

function buildUrl($page) {
    return $_SESSION['current']['lang'].'/'.$page;
}

function getTexte($section, $ref) {
    if(isset($_SESSION['trad'][$section][$ref])) {
        echo $_SESSION['trad'][$section][$ref];
    }
}

function getSilentTexte($section, $ref) {
    if(isset($_SESSION['trad'][$section][$ref])) {
        return $_SESSION['trad'][$section][$ref];
    }
}

function getIniValue($section, $ref) {
    if(isset($_SESSION['trad'][$section][$ref])) {
        return $_SESSION['trad'][$section][$ref];
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

function the_news($currentPage) {
    $news = new News();
    try {
        echo $news->displayNews($currentPage);
    }
    catch (PDOException $e) {
        echo 'ERROR : '.$e.'<br>';
    }
}

function the_news_mobile() {
    $news = new News();
    try {
        echo $news->displayNews(1, 10);
    }
    catch (PDOException $e) {
        echo 'ERROR : '.$e.'<br>';
    }
}

function news_pagination($currentPage) {
    $news = new News();
    try {
        echo $news->getPagination($currentPage);
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