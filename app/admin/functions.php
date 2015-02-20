<?php
//------ Fonctions -----------------------------------------
function clearUser() {
    $_SESSION = array();
    unset($_SESSION);
    session_unset();
    session_destroy();
    include_once dirname(__FILE__).'/login.php';
}

function displayModule($module = NULL) {
    if($module === NULL) {
        include_once dirname(__FILE__).'/modules/'.DEFAULT_MODULE.'/index.php';
        $_SESSION['current_module'] = DEFAULT_MODULE;
    }
    else {
        include_once dirname(__FILE__).'/modules/'.$module.'/index.php';
        $_SESSION['current_module'] = $module;
    }
}

function the_top_bar() {
    $layout = new Layouts();
    $layout->buildTopBar();
}

function the_main_menu($module = NULL) {
    $layout = new Layouts();
    $layout->buildMainMenu($module);
}

function classAutoLoad() {
    $DbClass = array();
    $Traits = array();
    $AllClass = array();
    $directory = dirname(__DIR__).'/class/';

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
        require_once dirname(__DIR__).'/class/'.$class;
    }
}
?>