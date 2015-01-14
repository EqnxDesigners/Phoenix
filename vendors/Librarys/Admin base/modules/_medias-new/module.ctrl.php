<?php
//Gestion d'affichage des pages
if(!isset($_GET['page'])) {
	$page_to_load   = 'gest_images.php';
        $_GET['page'] = 'gest_images';
	$elem_to_manage = 'medias';
        $_GET['gerer'] = 'medias';
}
else {
	$page_to_load   = $_GET['page'].'.php';
	if(isset($_GET['gerer'])) {
            $elem_to_manage = $_GET['gerer'];
        }
        else {
            $_GET['gerer'] = 'medias';
            $elem_to_manage = 'medias';
        }
}

//URL d'envoi des formulaires
$form_url = '?module='.$_SESSION['module'].'&page='.$_GET['page'].'&gerer='.$_GET['gerer'];

//Nouvelle instance de la class
$module = new MEDIAS();

//Ajout d'un format
if(isset($_POST['add_format'])) {
    mysql_query("INSERT INTO lib_imgs_formats VALUES ('','".$_POST['format']."','".$_POST['width']."','".$_POST['height']."')");
    unset($_POST);
}

//Ajouter un médias
if(isset($_POST['add_media'])) {
    if($_POST['type-media'] == '1') {
        //Ajout d'une image
        include_once '../class/files.class.php';
        $file = new FILES();

        //Upload d'une image à l'échelle 1:1
        try {
            $new_file_name = $file->UploadFile($_FILES['file_url'], '../medias/images/');
            try {
                $id_media = $module->addMediaToDb($new_file_name,$_POST['img-titre'],$_POST['img-alt'],$_POST['img-legende'],$_POST['type-media']);
            }
            catch (Exception $e) {
                $alert = $e->getMessage();
            }            
        }
        catch(Exception $e) {
            $alert = $e->getMessage();
        }

        //Upload des images aux formats prédéfinits sélectionnés
        foreach($module->getLstFormats() as $format) {
            if(isset($_POST['format_'.$format['id']])) {
                try {
                    $dimensions = $module->getFormatSize($format['id'], 'width').'X'.$module->getFormatSize($format['id'], 'height');
                    $new_file_name = $file->UploadFile($_FILES['file_url'], '../medias/images/', $dimensions);
                    try {
                        $module->addMediaAddsToDb($id_media,$format['id'],$new_file_name);
                    }
                    catch (Exception $e) {
                        $alert = $e->getMessage();
                    } 
                }
                catch(Exception $e) {
                    $alert = $e->getMessage();
                }
            }
        }

        //Upload d'une image avec un format personnalisé
        if($_POST['custom-width'] != 0 || $_POST['custom-height'] != 0) {
            $dimensions = $_POST['custom-width'].'X'.$_POST['custom-height'];
            try {
                $new_file_name = $file->UploadFile($_FILES['file_url'], '../medias/images/', $dimensions);
                try {
                    $module->addMediaAddsToDb($id_media,'88',$new_file_name);
                }
                catch (Exception $e) {
                    $alert = $e->getMessage();
                }
            }
            catch (Exception $e) {
                $alert = $e->getMessage();
            }
        }

        //Upload de la vignette
        $dimensions = THUMB_SIZE.'X'.THUMB_SIZE;
        try {
            $new_file_name = $file->UploadFile($_FILES['file_url'], '../medias/images/', $dimensions);
             try {
                $module->addMediaAddsToDb($id_media,'99',$new_file_name);
            }
            catch (Exception $e) {
                $alert = $e->getMessage();
            }
        }
        catch (Exception $e) {
            $alert = $e->getMessage();
        }
    }
    elseif($_POST['type-media'] == '3') {
        //Ajout d'un document
        include_once '../class/files.class.php';
        $file = new FILES();        
        try {
            $new_file_name = $file->UploadFile($_FILES['file_url'], '../medias/docs/');
            try {
                $module->addMediaToDb($new_file_name,$_POST['doc-titre'],$_POST['doc-alt'],$_POST['doc-legende'],$_POST['type-media']);
            }
            catch (Exception $e) {
                $alert = $e->getMessage();
            }            
        }
        catch(Exception $e) {
            $alert = $e->getMessage();
        }
    }
    else {
        //Ajout d'une vidéo
        try {
            $module->addVidToDb($_POST['vids_url'],$_POST['vid-titre'],$_POST['vid-alt'],$_POST['vid-legende'],$_POST['type-media']);
        }
        catch(Exception $e) {
            $alert = $e->getMessage();
        }
    }
    if(!isset($alert)) {
        header("location: dashboard.php?module=medias&page=creation&gerer=medias&alert=success");
    }
}

//Editer un média
if(isset($_POST['edit_media'])) {
    try {
        $module->updateMedia($_POST);
    }
     catch (Exception $e) {
         $alert = $e->getMessage();
     }
}

//Ajouter un slideshow
if(isset($_POST['add_slide'])) {
    try {
        $module->addSlideShow($_POST);
        header("location: dashboard.php?module=medias&page=creation&gerer=slideshow&alert=success-slide");
    }
    catch (Exception $e) {
        $alert = $e->getMessage();
    }
}
?>













