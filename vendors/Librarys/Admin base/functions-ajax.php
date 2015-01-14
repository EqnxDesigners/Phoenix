<?php
//--------------- Fichier de configuration ---------------
require_once dirname(__DIR__).'/includes/config.inc.php';

//--------------- Class ---------------
require_once dirname(__DIR__).'/class/db.class.php';

//--------------- Functions ---------------
if(isset($_POST['a']) && $_POST['a'] == 'logMeIn') {
    require_once dirname(__DIR__).'/class/users.class.php';
    $user = new Users($_POST['login'], $_POST['password']);
    
    if($user->reqUserInfo()) {
        $user->userLogIn($user->reqUserInfo());
        $result = 'TRUE';
    }
    else {
        $result = 'FALSE';
    }
    echo $result;
}

if(isset($_POST['a']) && $_POST['a'] == 'edit') {
    $class = initTheClass($_POST['module']);
    try {
        echo $class->buildEditForm($_POST['id']);
    }
    catch (PDOException $e) {
        echo 'Erreur : '.$e->getMessage();
    }
}

if(isset($_POST['a']) && ($_POST['a'] == 'hide' || $_POST['a'] == 'show')) {
    $class = initTheClass($_POST['module']);
    try {
        if($_POST['a'] == 'hide') { $class->ajaxShowHideItem($_POST['id'], '0'); }
        if($_POST['a'] == 'show') { $class->ajaxShowHideItem($_POST['id'], '1'); }
        echo $class->ajaxReload();
    }
    catch (PDOException $e) {
        echo 'Erreur : '.$e->getMessage();
    }
}

if(isset($_POST['a']) && ($_POST['a'] == 'isnotmenu' || $_POST['a'] == 'ismenu')) {
    $class = initTheClass($_POST['module']);
    try {
        if($_POST['a'] == 'isnotmenu')  { $class->ajaxIsMenuOrNot($_POST['id'], '0'); }
        if($_POST['a'] == 'ismenu')     { $class->ajaxIsMenuOrNot($_POST['id'], '1'); }
        echo $class->ajaxReload();
    }
    catch (PDOException $e) {
        echo 'Erreur : '.$e->getMessage();
    }
}

if(isset($_POST['a']) && $_POST['a'] == 'delete') {
    $class = initTheClass($_POST['module']);
    try {
        $class->ajaxDelItem($_POST['id']);
        echo $class->ajaxReload();
    }
    catch (PDOException $e) {
        echo 'Erreur : '.$e->getMessage();
    }
}

if(isset($_POST['a']) && $_POST['a'] == 'update') {
    $class = initTheClass($_POST['module']);
    try {
        $class->ajaxEditItem($_POST['data']);
        echo $class->ajaxReload();
    }
    catch (PDOException $e) {
        echo 'Erreur : '.$e->getMessage();
    }
}

if(isset($_POST['a']) && $_POST['a'] == 'reorder') {
    $class = initTheClass($_POST['module']);
    try {
        $class->ajaxReorderItem($_POST['ids']);
    }
    catch (PDOException $e) {
        echo 'Erreur : '.$e->getMessage();
    }
}

if(isset($_POST['a']) && $_POST['a'] == 'addtoeditstack') {
    $class = initTheClass($_POST['module']);
    
    if(!isset($_SESSION['edit-stack'])) {
        $_SESSION['edit-stack'] = array($_POST['id']);
    }
    else {
        array_push($_SESSION['edit-stack'], $_POST['id']);
    }
    
    if(count($_SESSION['edit-stack']) > 0) {
        try {
            echo $class->buildEditBox();
        }
        catch (PDOException $e) {
            echo 'Erreur : '.$e->getMessage();
        }
    }
}

if(isset($_POST['a']) && $_POST['a'] == 'cleareditstack') {
    if(isset($_SESSION['edit-stack'])) {
        $_SESSION['edit-stack'] = array();
        unset($_SESSION['edit-stack']);
    }
}

if(isset($_POST['a']) && $_POST['a'] == 'removefromeditstack') {
    $class = initTheClass($_POST['module']);
    
    unset($_SESSION['edit-stack'][array_search($_POST['id'], $_SESSION['edit-stack'])]);
    $_SESSION['edit-stack'] = array_values($_SESSION['edit-stack']);
    echo $class->buildEditBox();
}

if(isset($_POST['a']) && $_POST['a'] == 'bulidLstMedias') {
    $class = initTheClass('medias');
    
    try {
        echo $class->buildMediasForArticle($_POST['trow'], $_POST['tcol']);
    }
    catch (PDOException $e) {
        echo 'Erreur : '.$e->getMessage();
    }
}

function initTheClass($module) {
    if($module == 'pages') {
        require_once dirname(__DIR__).'/class/pages.class.php';
        $instance = new Pages();
    }
    
    if($module == 'categories') {
        require_once dirname(__DIR__).'/class/categories.class.php';
        $instance = new Categories();
    }
    
    if($module == 'medias') {
        require_once dirname(__DIR__).'/class/medias.class.php';
        $instance = new Medias();
    }
    
    return $instance;
}
?>