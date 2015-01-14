<?php
//Includes et instanciations
include_once '../../../includes/config.inc.php';
include_once '../../../class/db.class.php';
include_once 'module.class.php';
$db = new DB();
$module = new NEWS();


//Action des master switch
if(isset($_POST['action']) && $_POST['action'] == 'masterSwitch') {
    //$module = new MEDIAS('images');
    mysql_query("UPDATE lay_news SET active = '".$_POST['new_value']."' WHERE id = '".$_POST['id']."'");	
    echo $module->getMasterSwitch($_POST['id'], $_POST['new_value'], $_POST['element']);
}

//Affichage des médias
if(isset($_POST['action']) && $_POST['action'] == 'showLstMedia') {
    echo $module->getLayoutMedias($_POST['linkto']);
}

//Supprimer une news
if(isset($_POST['action']) && $_POST['action'] == 'delNews') {
    mysql_query("DELETE FROM lay_news_medias WHERE id_news = '".$_POST['id']."'");
    mysql_query("DELETE FROM lay_news WHERE id = '".$_POST['id']."'");
    echo $module->getLayoutNews();
}



















//Affichage des sous-médias
if(isset($_POST['action']) && $_POST['action'] == 'getSubMedia') {
    echo $module->getLayoutSubMedias($_POST['id']);
}

//Affichage des données d'un sous-médias
if(isset($_POST['action']) && $_POST['action'] == 'getMediaInfo') {
    $media = $module->getMediasInfos($_POST['id']);
    echo $media['0']['titre'].'#'.$media['0']['alt'].'#'.$media['0']['legende'];
}

//Supprimer un format prédéfinit
if(isset($_POST['action']) && $_POST['action'] == 'delFormat') {
    mysql_query("DELETE FROM lib_imgs_formats WHERE id = '".$_POST['id']."'");
    echo $module->getLayoutFormats();
}

//Supprimer un média
if(isset($_POST['action']) && $_POST['action'] == 'delMedia') {
    //Suppression des sous-média liés
    if($module->getLstAllSubMedias($_POST['id'])) {
        foreach($module->getLstAllSubMedias($_POST['id']) as $media) {
            if(unlink('../../../medias/images/'.$module->getSubFileName($media['id']))) {    
                mysql_query("DELETE FROM lib_medias_adds WHERE id = '".$media['id']."'");
            }
        }
    }
    //Suppression du média
    if($_POST['type'] == '1') {
        if(unlink('../../../medias/images/'.$module->getFileName($_POST['id']))) {    
            mysql_query("DELETE FROM lib_medias WHERE id = '".$_POST['id']."'");
        }
    }
    if($_POST['type'] == '2') {
        mysql_query("DELETE FROM lib_medias WHERE id = '".$_POST['id']."'");
    }
    if($_POST['type'] == '3') {
        if(unlink('../../../medias/docs/'.$module->getFileName($_POST['id']))) {    
            mysql_query("DELETE FROM lib_medias WHERE id = '".$_POST['id']."'");
        }
    }
    //echo $module->getLayoutMedias();
}

//Supprimer un sous-média
if(isset($_POST['action']) && $_POST['action'] == 'delSubMedia') {
    $id_media = $module->getParentMediaId($_POST['id']);    
    if(unlink('../../../medias/images/'.$module->getSubFileName($_POST['id']))) {    
        mysql_query("DELETE FROM lib_medias_adds WHERE id = '".$_POST['id']."'");
    }    
    echo $module->getLayoutSubMedias($id_media);
}

//Récupérer les infos d'une video Youtube
if(isset($_POST['action']) && $_POST['action'] == 'getVidsInfos') {
    //Récupération de l'ID de la vidéo
    $split = explode("/", $_POST['url']);
    $id = $split[count($split)-1];
    
    //Parsing du XML
    $xml = @file_get_contents("http://gdata.youtube.com/feeds/api/videos/".$id);     
    $sxml = simplexml_load_string($xml);
    
    //Test de la légende
    if($sxml->description != '') {
        $legende = $sxml->description;
    }
    else {
        $legende =  '...';
    }
    //Renvoi d'une chaine de caractère
    echo $sxml->title.'#'.$legende.'#'.$id;
}

//Supprimer un slideshow
if(isset($_POST['action']) && $_POST['action'] == 'delSlideShow') {
    mysql_query("DELETE FROM lay_slideshows_imgs WHERE id_slide='".$_POST['id']."'");
    mysql_query("DELETE FROM lay_slideshows WHERE id='".$_POST['id']."'");
    echo $module->getLayoutSlideShow();
}

//Affiche les images pour le slide
if(isset($_POST['action']) && $_POST['action'] == 'showLstImgs') {
    echo $module->getLayoutMedias('1', 'slide');
}

//Affiche le contenu du slideshow sélectionné
if(isset($_POST['action']) && $_POST['action'] == 'showSelectedSlide') {
    echo $module->getSelectedSlideContent($_POST['id']);
}

//Ajouter une image à un slideshow
if(isset($_POST['action']) && $_POST['action'] == 'addImgToSlide') {
    mysql_query("INSERT INTO lay_slideshows_imgs (id_slide, id_media, sort) VALUES ('".$_POST['id_slide']."','".$_POST['id_image']."','".$module->getLastSort($_POST['id_slide'])."')");
    echo $module->getSelectedSlideContent($_POST['id_slide']);
}

//Enlever une image à un slideshow
if(isset($_POST['action']) && $_POST['action'] == 'removeImgFromSlide') {
    mysql_query("DELETE FROM lay_slideshows_imgs WHERE id='".$_POST['id_image']."'");
    echo $module->getSelectedSlideContent($_POST['id_slide']);
}

//Réorganisation des articles
if(isset($_POST['action']) && $_POST['action'] == 'reorderImgs') {
    //Nettoyage de la chaine transmise
    $lst_ids = $module->cleanLstIds($_POST['lst_ids']);
    //Ordinateur
    $new_order = 1;

    //Réordination de la liste
    foreach($lst_ids as $id) {
        //echo $id.' : '.$new_order.'<br>';
        mysql_query("UPDATE `lay_slideshows_imgs` SET `sort`='".$new_order."' WHERE `lay_slideshows_imgs`.`id` ='".$id."'");
        $new_order++;
    }
}
?>