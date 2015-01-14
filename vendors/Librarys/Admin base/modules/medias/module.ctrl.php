<?php
//------ Ajouter une categorie -----------------------------------------------
if(isset($_POST['add-item'])) {
    if(strlen($_FILES['media-file']['name']) > 0) {
        unset($alert_add);
        
        require_once '../class/files.class.php';
        require_once '../class/medias.class.php';
        $file = new FILES();
        $media = new Medias();
        $url_dest = '../medias/';

        if($_FILES['media-file']['type'] == 'application/pdf') {
            try {
                $sFileName = $file->UploadFile($_FILES['media-file'], $url_dest);
                try {
                    $id_media = $media->addItem($sFileName);
                    header("location: ".$_SERVER['HTTP_REFERER']);
                }
                catch (Exception $ex) {
                    $alert_add = $e->getMessage();
                }
            }
            catch (Exception $e) {
                $alert_add = $e->getMessage();
            }
        }
        elseif($_FILES['media-file']['type'] == 'image/jpeg' || $_FILES['media-file']['type'] == 'image/png' || $_FILES['media-file']['type'] == 'image/gif') {
            $img_size = getimagesize($_FILES['media-file']['tmp_name']);
            $img_size_med   = $media->getNewSize($img_size['0'], 70).'X'.$media->getNewSize($img_size['1'], 70);
            $img_size_small = $media->getNewSize($img_size['0'], 40).'X'.$media->getNewSize($img_size['1'], 40);
            try {
                $sFileName = $file->UploadFile($_FILES['media-file'], $url_dest);
                try {
                    $id_media = $media->addItem($sFileName);
                    try {
                        $file_name_medium = $file->UploadFile($_FILES['media-file'], $url_dest, $img_size_med);
                        try {
                            $media->addItem($file_name_medium, $id_media, 'medium');
                            try {
                                $file_name_small = $file->UploadFile($_FILES['media-file'], $url_dest, $img_size_small);
                                try {
                                    $media->addItem($file_name_small, $id_media, 'small');
                                    try {
                                        $file_name_thumb = $file->UploadFile($_FILES['media-file'], $url_dest, '100X100');
                                        try {
                                            $media->addItem($file_name_thumb, $id_media, 'thumb');
                                            header("location: ".$_SERVER['HTTP_REFERER']);
                                        }
                                        catch (Exception $e) {
                                            $alert_add = $e->getMessage();
                                        }
                                    }
                                    catch (Exception $e) {
                                        $alert_add = $e->getMessage();
                                    }
                                }
                                catch (Exception $e) {
                                    $alert_add = $e->getMessage();
                                }
                            }
                            catch (Exception $e) {
                                $alert_add = $e->getMessage();
                            }
                                        }
                        catch (Exception $e) {
                            $alert_add = $e->getMessage();
                        }
                                }
                    catch (Exception $e) {
                        $alert_add = $e->getMessage();
                    }
                }
                catch (Exception $e) {
                    $alert_add = $e->getMessage();
                }
            }
            catch (Exception $e) {
                $alert_add = $e->getMessage();
            }
        }
        else {
            $alert_add = 'Format de fichier non supporté';
        }
    }
    else {
        $alert_add = 'Sélectionner un fichier...';
    }
}
?>