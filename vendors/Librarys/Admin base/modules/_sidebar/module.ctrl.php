<?php
ini_set('display_errors', '1');
//
//Nouvelle instance de la class
$module = new SIDEBAR();

//Gestion d'affichage des pages
if(!isset($_GET['page'])) {
	$page_to_load   = 'gestion.php';
	$elem_to_manage = 'Sidebar';
}
else {
	$page_to_load   = $_GET['page'].'.php';
	$elem_to_manage = $_GET['gerer'];
}

//Langue de publication
if(!isset($_SESSION['lang'])) {
    $_SESSION['lang'] = 1;
}

//Page courrante
if(!isset($_SESSION['page'])) {
    $_SESSION['page'] = 'all';
}

//Article à éditer
if(isset($_GET['page']) && $_GET['page'] == 'edition') {
    if(isset($_GET['id_art'])) {
        $_SESSION['id_article'] = $_GET['id_art'];
    }
    else {
        $_SESSION['id_article'] = $_POST['id_art'];
    }
    if(!isset($_SESSION['lang'])) {
        $_SESSION['lang'] = 1;
    }
}

//Ajouter un article
if(isset($_POST['add_article'])) {
    if($_POST['id_page'] != 'all') {
        //Page sélectionnée
        if(!isset($_SESSION['id_article'])) {
            //Pas d'article actif
            //Insertion de l'article
            $_SESSION['id_article'] = insertArticle($_POST['id_page'],
                                                    date("y-m-d H:m:s"),
                                                    date("y-m-d H:m:s"),
                                                    $module->getArticleLastSort($_POST['id_page']),
                                                    '1');
            //Test si la publication dans toutes les langues est acive
            if(isset($_POST['for-all-lang'])) {
                foreach($module->getLstLangues() as $lang) {
                    //Insertion des traductions
                    $success = insertArticleTrad($lang['id'], addslashes($_POST['titre']), $module->updateImgLink($_POST['article']), '1');
                }
            }
            else {
                //Insertion de la traduction
                $success = insertArticleTrad($_SESSION['lang'], addslashes($_POST['titre']), $module->updateImgLink($_POST['article']), '1');
            }
        }
        else {
            //Article actif
            if(isset($_POST['for-all-lang'])) {
                foreach($module->getLstLangues() as $lang) {
                    if(!$module->checkIfArticleRecorded($_SESSION['id_article'], $lang['id'])) {
                        //Si pas déjà insérée
                        //Insertion de la traduction
                        $success = insertArticleTrad($lang['id'], addslashes($_POST['titre']), $module->updateImgLink($_POST['article']), '1');
                    }
                }
            }
            else {
                if(!$module->checkIfArticleRecorded($_SESSION['id_article'], $_SESSION['lang'])) {
                    //Si pas déjà insérée
                    //Insertion de la traduction
                    $success = insertArticleTrad($_SESSION['lang'], addslashes($_POST['titre']), $module->updateImgLink($_POST['article']), '1');
                }
                else {
                    //Si déjà inséré
                    $recorded = 'Cet article a déjà été enregistré dans cette langue...';
                }
            }
        }
    }
    else {
        //Aucune page sélectionnée
        $alert = 'Vous devez sélectionner une page.';
    }
}

//Enregistrer un article
if(isset($_POST['rec_article'])) {
    if($_POST['id_page'] != 'all') {
        //Page sélectionnée
        if(!isset($_SESSION['id_article'])) {
            //Pas d'article actif
            //Insertion de l'article
            $_SESSION['id_article'] = insertArticle($_POST['id_page'],
                                                    date("y-m-d H:m:s"),
                                                    date("y-m-d H:m:s"),
                                                    $module->getArticleLastSort($_POST['id_page']),
                                                    '2');
            //Test si la publication dans toutes les langues est acive
            if(isset($_POST['for-all-lang'])) {
                foreach($module->getLstLangues() as $lang) {
                    //Insertion des traductions
                    $success = insertArticleTrad($lang['id'], addslashes($_POST['titre']), $module->updateImgLink($_POST['article']), '1');
                }
            }
            else {
                //Insertion de la traduction
                $success = insertArticleTrad($_SESSION['lang'], addslashes($_POST['titre']), $module->updateImgLink($_POST['article']), '1');
            }
        }
        else {
            //Article actif
            //Mise à jour de la date
            majArticle($_SESSION['id_article']);
            if(isset($_POST['for-all-lang'])) {
                foreach($module->getLstLangues() as $lang) {
                    if(!$module->checkIfArticleRecorded($_SESSION['id_article'], $lang['id'])) {
                        $success = insertArticleTrad($lang['id'], addslashes($_POST['titre']), $module->updateImgLink($_POST['article']), '1');
                    }
                    else {
                        $success = majArticleTrad($_SESSION['id_article'], $lang['id'], addslashes($_POST['titre']), $module->updateImgLink($_POST['article']));
                    }
                }
            }
            else {
                if(!$module->checkIfArticleRecorded($_SESSION['id_article'], $_SESSION['lang'])) {
                    //Insertion de la traduction
                    $success = insertArticleTrad($_SESSION['lang'], addslashes($_POST['titre']), $module->updateImgLink($_POST['article']), '1');
                }
                else {
                    //Mise à jour de la traduction
                    $success = majArticleTrad($_SESSION['id_article'], $_SESSION['lang'], addslashes($_POST['titre']), $module->updateImgLink($_POST['article']));
                }
            }
        }
    }
    else {
        //Aucune page sélectionnée
        $alert = 'Vous devez sélectionner une page.';
    }
}

//Mise à jour d'un article
if(isset($_POST['maj_article'])) {
    //Mise à jour de la date
    majArticle($_SESSION['id_article']);
    if(isset($_POST['for-all-lang'])) {
        foreach($module->getLstLangues() as $lang) {
            if(!$module->checkIfArticleRecorded($_SESSION['id_article'], $lang['id'])) {
                $success = insertArticleTrad($lang['id'], addslashes($_POST['titre']), $module->updateImgLink($_POST['article']), '1');
            }
            else {
                $success = majArticleTrad($_SESSION['id_article'], $lang['id'], addslashes($_POST['titre']), $module->updateImgLink($_POST['article']));
            }
        }
    }
    else {
        $success = majArticleTrad($_SESSION['id_article'], $_SESSION['lang'], addslashes($_POST['titre']), $module->updateImgLink($_POST['article']));
    }
}

function insertArticle($idpage, $postdate, $modifdate, $sort, $active) {
    mysql_query("INSERT INTO lay_articles VALUES ('',
                                                    '".$idpage."',
                                                    '".$postdate."',
                                                    '".$modifdate."',
                                                    '".$sort."',
                                                    '".$active."')");
    return mysql_insert_id();
}

function insertArticleTrad($idlang, $titre, $article, $active) {
    mysql_query("INSERT INTO trad_articles VALUES ('',
                                                    '".$_SESSION['id_article']."',
                                                    '".$idlang."',
                                                    '".$titre."',
                                                    '".$article."',
                                                    '".$active."')");
    return 'Votre article a bien été publié...';
}

function majArticle($idarticle) {
    mysql_query("UPDATE lay_articles SET modif_date = '".date("y-m-d H:m:s")."' WHERE id_article='".$idarticle."'");
}

function majArticleTrad($idarticle, $idlang, $titre, $article) {
    mysql_query("UPDATE trad_articles SET titre = '".$titre."' WHERE id_article='".$idarticle."' AND id_lang='".$idlang."'");
    mysql_query("UPDATE trad_articles SET article = '".$article."' WHERE id_article='".$idarticle."' AND id_lang='".$idlang."'");
    return 'Votre article a bien été mis à jour...';
}
?>