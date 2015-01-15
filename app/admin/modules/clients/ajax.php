<?php
//----- Fichier de configuration --------------------------
require_once dirname(__DIR__).'/../../config/config.inc.php';

//----- Class ---------------------------------------------
require_once dirname(__DIR__).'/../../class/PHPMailer/PHPMailerAutoload.php';
spl_autoload_register(function($class) {
    require_once dirname(__DIR__).'/../../class/'.$class.'.class.php';
});

//------ Formulaire ---------------------------------------
if(isset($_POST['publish'])) {
    $ReadyToPost = true;
    unset($alert);
    if(strlen($_POST['societe']) < 1) {
        if(strlen($_POST['nom']) < 1 && strlen($_POST['prenom']) < 1) {
            $ReadyToPost = false;
            $alert = 'Une société, un nom ou un prénom doit être spécifié...';
        }
    }
    if($ReadyToPost) {
        try {
            $Client = new Clients();
            if(buildAvertissementMail($Client->addClient($_POST))) {
                //echo "LE MAIL EST PARTI ET LE CLIENT CREE";
                header("location: ../../index.php?module=".$_SESSION['current_module']);
            }
            else {
                $alert = 'Un problème est survenu à l\'envoi du mail';
                //echo $alert;
                header("location: ../../index.php?module=".$_SESSION['current_module']."&alert=".$alert);
            }
        }
        catch (PDOException $e) {
            $alert = 'ERREUR : '.$e;
            header("location: ../../index.php?module=".$_SESSION['current_module']."&alert=".$alert);
        }
    }
    else {
        header("location: ../../index.php?module=".$_SESSION['current_module']."&alert=".$alert);
    }
}

if(isset($_POST['majitem'])) {
    $ReadyToPost = true;
    unset($alert);
    if(strlen($_POST['societe']) < 1) {
        if(strlen($_POST['nom']) < 1 && strlen($_POST['prenom']) < 1) {
            $ReadyToPost = false;
            $alert = 'Une société, un nom ou un prénom doit être spécifié...';
        }
    }
    if($ReadyToPost) {
        try {
            $Client = new Clients();
            $Client->updateClient($_POST);
            header("location: ../../index.php?module=".$_SESSION['current_module']);
        }
        catch (PDOException $e) {
            $alert = 'ERREUR : '.$e;
            header("location: ../../index.php?module=".$_SESSION['current_module']."&alert=".$alert);
        }
    }
    else {
        header("location: ../../index.php?module=".$_SESSION['current_module']."&alert=".$alert);
    }
}

function buildAvertissementMail($token) {
    $sujet = 'Votre compte MyEqnx a été créé.';
    
    $mail_content = file_get_contents(dirname(__DIR__).'/../../mail_templates/mail_header.html');
    $mail_content .= file_get_contents(dirname(__DIR__).'/../../mail_templates/mail_content_creation_compte.html');
    $mail_content .= file_get_contents(dirname(__DIR__).'/../../mail_templates/mail_footer.html');

    $mail_content = str_replace("%%%TOKEN%%%", $token, $mail_content);

    $destinataire_email = 'jc@eqnx.ch';
    $destinataire_name = 'Jérôme Clerc';

    return SendMail($sujet, $mail_content, $destinataire_email, $destinataire_name);
}

function SendMail($subject, $content, $for_email, $for_name){
    $mail = new PHPMailer;
    
    $mail->CharSet = 'UTF-8';
    $mail->ClearAllRecipients();
    
    // SMTP
    $mail->isSMTP();
    $mail->SMTPDebug = 0;
    $mail->Debugoutput = 'html';
    $mail->Host = 'smtp.gmail.com';
    $mail->Port = 587;
    $mail->SMTPSecure = 'tls';
    $mail->SMTPAuth = true;
    $mail->Username = "jc.dreamescape@gmail.com";
    $mail->Password = "dr94Y?22";
    $mail->AddAddress($for_email, $for_name);
    $mail->Subject= $subject;
    $mail->msgHTML($content);
    
    return (!$mail->send() ? false : true);
}
?>
