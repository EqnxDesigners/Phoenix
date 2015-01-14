<?php
// fixe le niveau de rapport d'erreur
if (version_compare(phpversion(), '5.3.0', '>=') == 1)
    error_reporting(E_ALL & ~E_NOTICE & ~E_DEPRECATED);
else
    error_reporting(E_ALL & ~E_NOTICE);

function bytesToSize1024($bytes, $precision = 2) {
    $unit = array('B','KB','MB');
    return @round($bytes / pow(1024, ($i = floor(log($bytes, 1024)))), $precision).' '.$unit[$i];
}

if (isset($_FILES['myfile'])) {
    $sFileName = $_FILES['myfile']['name'];
    $sFileType = $_FILES['myfile']['type'];
    $sFileSize = bytesToSize1024($_FILES['myfile']['size'], 1);
    
    //------ Uplaod des fichier --------------------------------------
    include_once '../../../includes/config.inc.php';
    require_once '../../../class/db.class.php';
    require_once '../../../class/files.class.php';
    require_once '../../../class/medias.class.php';
    $file = new FILES();
    $media = new Medias();
    $url_dest = '../../../medias/';
    
    if($sFileType == 'application/pdf') {
        try {
            $sFileName = $file->UploadFile($_FILES['myfile'], $url_dest);
            try {
                $id_media = $media->addItem($sFileName, '0', 'file');
                echo '<div class="s">Le fichier : '.$sFileName.' a été correctement transféré.</div>';
            }
            catch (Exception $e) {
                echo '<div class="f">'.$e->getMessage().'</div>';
            }
        }
        catch (Exception $e) {
            echo '<div class="f">'.$e->getMessage().'</div>';
        }
    }
    elseif($sFileType == 'image/jpeg' || $sFileType == 'image/png' || $sFileType == 'image/gif') {
        $img_size = getimagesize($_FILES['myfile']['tmp_name']);
        $img_size_med   = $media->getNewSize($img_size['0'], 70).'X'.$media->getNewSize($img_size['1'], 70);
        $img_size_small = $media->getNewSize($img_size['0'], 40).'X'.$media->getNewSize($img_size['1'], 40);
        try {
            $sFileName = $file->UploadFile($_FILES['myfile'], $url_dest);
            try {
                $id_media = $media->addItem($sFileName);
                try {
                    $file_name_medium = $file->UploadFile($_FILES['myfile'], $url_dest, $img_size_med);
                    try {
                        $media->addItem($file_name_medium, $id_media, 'medium');
                        try {
                            $file_name_small = $file->UploadFile($_FILES['myfile'], $url_dest, $img_size_small);
                            try {
                                $media->addItem($file_name_small, $id_media, 'small');
                                try {
                                    $file_name_thumb = $file->UploadFile($_FILES['myfile'], $url_dest, '100X100');
                                    try {
                                        $media->addItem($file_name_thumb, $id_media, 'thumb');
                                        echo '<div class="s">Le fichier : '.$sFileName.' a été correctement transféré.</div>';
                                    }
                                    catch (Exception $e) {
                                        echo '<div class="f">'.$e->getMessage().'</div>';
                                    }
                                }
                                catch (Exception $e) {
                                    echo '<div class="f">'.$e->getMessage().'</div>';
                                }
                            }
                            catch (Exception $e) {
                                echo '<div class="f">'.$e->getMessage().'</div>';
                            }
                        }
                        catch (Exception $e) {
                            echo '<div class="f">'.$e->getMessage().'</div>';
                        }
                                    }
                    catch (Exception $e) {
                        echo '<div class="f">'.$e->getMessage().'</div>';
                    }
                            }
                catch (Exception $e) {
                    echo '<div class="f">'.$e->getMessage().'</div>';
                }
            }
            catch (Exception $e) {
                echo '<div class="f">'.$e->getMessage().'</div>';
            }
        }
        catch (Exception $e) {
            echo '<div class="f">'.$e->getMessage().'</div>';
        }
    }
    else {
        echo '<div class="f">Format de fichier non supporté</div>';
    }
}
else {
    echo '<div class="f">Une erreur s\'est produite</div>';
}
?>