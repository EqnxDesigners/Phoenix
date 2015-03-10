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
    require_once dirname(__DIR__).'/../../config/config.inc.php';

    //----- Class ---------------------------------------------
    require_once dirname(__DIR__).'/../../class/PHPMailer/PHPMailerAutoload.php';
    spl_autoload_register(function($class) {
        require_once dirname(__DIR__).'/../../class/'.$class.'.class.php';
    });
    
    $file = new Files();
    $url_dest = '../../../myeqnx/documents/';
    
    if($sFileType == 'application/pdf') {
        try {
            $sFileName = $file->UploadFile($_FILES['myfile'], $url_dest);
//            $Media = new Medias();
//            try {
//                $id_media = $media->addItem($sFileName, '0', 'file');
//                header("location: ../../index.php?module=".$_SESSION['current_module']);
//            }
//            catch (Exception $e) {
//                echo '<div class="f">'.$e->getMessage().'</div>';
//            }
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