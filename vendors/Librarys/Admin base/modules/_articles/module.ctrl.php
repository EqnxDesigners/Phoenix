<?php
//ini_set('display_errors', '1');
//
//Nouvelle instance de la class
$module = new ARTICLES();

//Gestion d'affichage des pages
if(!isset($_GET['page'])) {
	$page_to_load   = 'gestion.php';
	$elem_to_manage = 'articles';
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
        if($_SESSION['page'] == 'all' || $_SESSION['page'] == 'allbycat') {
            $_SESSION['page'] = $module->getIdPageFromArt($_SESSION['id_article']);
        }
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
    //echo $_POST['article'];
    //echo '<br>******************************************<br>';
    //echo $module->updateImgLink($_POST['article']);
    //Mise à jour de la date
    majArticle($_SESSION['id_article']);
    if(isset($_POST['for-all-lang'])) {
        foreach($module->getLstLangues() as $lang) {
            if(!$module->checkIfArticleRecorded($_SESSION['id_article'], $lang['id'])) {
                $success = insertArticleTrad($lang['id'], addslashes($_POST['titre']), $module->updateImgLink($_POST['article']), '1');
            }
            else {
                mysql_query("UPDATE lay_articles SET id_page = '".$_POST['id_page']."' WHERE id='".$_SESSION['id_article']."'");
                $success = majArticleTrad($_SESSION['id_article'], $lang['id'], addslashes($_POST['titre']), $module->updateImgLink($_POST['article']));
            }
        }
    }
    else {
        mysql_query("UPDATE lay_articles SET id_page = '".$_POST['id_page']."' WHERE id='".$_SESSION['id_article']."'");
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

/*
//Ajout d'un article
if(isset($_POST['rec_article']) || isset($_POST['add_article'])) {
    if($_POST['id_page'] != 'all') {
        //Traitement du contenu de l'article
        $_POST['article'] = $module->updateImgLink($_POST['article']);
        
        if(!isset($_SESSION['id_article'])) {
            //Définition du statut
            if(isset($_POST['rec_article'])) {
                $active = '2';
                $recorded = 'Votre article a bien été enregistré...';
            }
            if(isset($_POST['add_article'])) {
                $active = '1';
                $success = 'Votre article a bien été publié...';
            }

            //Date de publication
            $post_date = date("y-m-d H:m:s");
            
            //Insertion de l'article
            mysql_query("INSERT INTO lay_articles VALUES ('','".$_POST['id_page']."','".$post_date."','".$post_date."','".$module->getArticleLastSort($_POST['id_page'])."','".$active."')");
            $_SESSION['id_article'] = mysql_insert_id();
            //Insertion de la traduction
            if(isset($_POST['for-all-lang'])) {
                $lst_lang = $module->getLstLangues();
                foreach($lst_lang as $lang) {
                    mysql_query("INSERT INTO trad_articles VALUES ('','".$_SESSION['id_article']."','".$lang['id']."','".$_POST['titre']."','".$_POST['article']."')");
                }
            }
            else {
                mysql_query("INSERT INTO trad_articles VALUES ('','".$_SESSION['id_article']."','".$_POST['id_lang']."','".$_POST['titre']."','".$_POST['article']."')");
            }
        }
        else {
            if(!$module->checkIfArticleRecorded($_SESSION['id_article'], $_POST['id_lang'])) {
                //Définition du statut
                if(isset($_POST['rec_article'])) {
                    $active = '2';
                    $recorded = 'Votre article a bien été enregistré...';
                }
                if(isset($_POST['add_article'])) {
                    $active = '1';
                    $success = 'Votre article a bien été publié...';
                }
                if(isset($_POST['for-all-lang'])) {
                    $lst_lang = $module->getLstLangues();
                    foreach($lst_lang as $lang) {
                        if(!$module->checkIfArticleRecorded($_SESSION['id_article'], $lang['id'])) {
                            mysql_query("INSERT INTO trad_articles VALUES ('','".$_SESSION['id_article']."','".$lang['id']."','".$_POST['titre']."','".$_POST['article']."')");
                        }
                    }
                }
                else {
                    mysql_query("INSERT INTO trad_articles VALUES ('','".$_SESSION['id_article']."','".$_POST['id_lang']."','".$_POST['titre']."','".$_POST['article']."')");
                }
            }
            else {
                $recorded = 'Cet article a déjà été enregistré dans cette langue...';
            }
        }
    }
    else {
        $alert = 'Vous devez sélectionner une page.';
    }
}
*/
/*
//Liste de toutes les news;
$lst_news = $mod_class->getAllRowsNewsOrderByDesc();

//Récupérer une news
if(isset($_GET['id_news'])) {
	$news = $mod_class->getNewsById($_GET['id_news']);
}

//Ajouter une new
if(isset($_POST['add_news'])) {
	$lst_lang = $mod_class->getLangues();
	
	$date_time = date("Y-m-d G:i:s");
	
	//Insertion de la news de base
	mysql_query("INSERT INTO cte_actualites VALUES ('','".$date_time."','1')");
	$id_actu = mysql_insert_id();
	
	foreach($lst_lang as $lang) {
		mysql_query("INSERT INTO trad_actualites VALUES ('','".$id_actu."','".$lang['langue']."','".addslashes($_POST['titre_'.$lang['langue']])."','".addslashes($_POST['contenu_'.$lang['langue']])."')");
	}
	
	//Redirection
	header("location: ?module=".$_SESSION['module']."");
}

//Editer une news
if(isset($_POST['edit_news'])) {
	$lst_lang = $mod_class->getLangues();
	
	foreach($lst_lang as $lang) {
		mysql_query("UPDATE trad_actualites SET titre='".$_POST['titre_'.$lang['langue']]."' WHERE id_actu = '".$_POST['id_news']."' AND lang = '".$lang['langue']."'");
		mysql_query("UPDATE trad_actualites SET actualite='".$_POST['contenu_'.$lang['langue']]."' WHERE id_actu = '".$_POST['id_news']."' AND lang = '".$lang['langue']."'");
	}
	
	//Redirection
	header("location: ?module=".$_SESSION['module']."");
}

//Supprimer une news
if(isset($_GET['action']) && $_GET['action'] == 'del_news') {
	mysql_query("DELETE FROM cte_actualites WHERE id = '".$_GET['id']."'");
	mysql_query("DELETE FROM trad_actualites WHERE id_actu = '".$_GET['id']."'");
	
	//Redirection
	header("location: ?module=".$_SESSION['module']."");
}
 * 
 */
?>