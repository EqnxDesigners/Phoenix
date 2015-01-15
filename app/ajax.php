<?php
//----- Fichier de configuration --------------------------
require_once dirname(__FILE__).'/config/config.inc.php';

//----- Class autoload ------------------------------------
require_once dirname(__FILE__).'/class/PHPMailer/PHPMailerAutoload.php';
spl_autoload_register(function($class) {
    require_once dirname(__FILE__).'/class/'.$class.'.class.php';
});

//----- Fonctions AJAX ------------------------------------
if(isset($_POST['a']) && $_POST['a'] === 'sendMailInscr') {
  EnvoiFormulaireInscription($_POST['nom'], $_POST['prenom'], $_POST['email'], $_POST['event'], $_POST['eventDate'], $_POST['eventPlace']);
}

if(isset($_POST['a']) && $_POST['a'] === 'sendMailContact') {
  EnvoiFormulaireContact($_POST['nom'], $_POST['prenom'], $_POST['email'], $_POST['message']);
}

//------ Envoi emails -----------------------------------------

//if(isset($_POST['contactForm'])) { // ajouter le formulaire d'inscription
//  // récupère les données du formulaire
//  $message = $_POST['message'];
//  
//  // envoi des mails
//  EnvoiFormulaireContact($message); 
//}
//

//if(isset($_POST['seminaireForm'])) { // ajouter le formulaire d'inscription
//  // récupère les données du formulaire
//  $event = $_POST['event'];
//  $eventDate = $_POST['eventDate'];
//  $eventPlace = $_POST['eventPlace'];
//  
//  // envoi des mails
//  EnvoiFormulaireInscription($event, $eventDate, $eventPlace); 
//}

/**
*   Envoi du formulaire d'inscription au séminaire 
*   @param event, eventDate, eventPlace
**/
function EnvoiFormulaireInscription($nom, $prenom, $email, $event, $eventDate, $eventPlace){
  $sujet = 'Nouvelle inscription au séminaire d\'information '.$event;
  $sujet_validation = 'Votre inscription au séminaire d\'information '.$event;
  
  $mail_content = file_get_contents(dirname(__FILE__).'/mail_templates/mail_header.html');
  $mail_content .= file_get_contents(dirname(__FILE__).'/mail_templates/mail_content_seminaire.html');
  $mail_content .= file_get_contents(dirname(__FILE__).'/mail_templates/mail_footer.html');
  
  $mail_content_validation = file_get_contents(dirname(__FILE__).'/mail_templates/mail_header.html');
  $mail_content_validation .= file_get_contents(dirname(__FILE__).'/mail_templates/mail_content_seminaire_validation.html');
  $mail_content_validation .= file_get_contents(dirname(__FILE__).'/mail_templates/mail_footer.html');
  
  $mail_content = str_replace("%%%PRENOM%%%", $prenom, $mail_content);
  $mail_content = str_replace("%%%NOM%%%", $nom, $mail_content);
  $mail_content = str_replace("%%%EMAIL%%%", $email, $mail_content);
  $mail_content = str_replace("%%%EVENT%%%", $event, $mail_content);
  
  $mail_content_validation = str_replace("%%%EVENT%%%", $event, $mail_content_validation);
  $mail_content_validation = str_replace("%%%EVENTDATE%%%", $eventDate, $mail_content_validation);
  $mail_content_validation = str_replace("%%%EVENTPLACE%%%", $eventPlace, $mail_content_validation);
  
  $destinataire_email = 'ap@eqnx.ch';
  $destinataire_name = 'Aline Pfänder';
  $destinataire_validation_email = $email;
  $destinataire_validation_name = $prenom.' '.$nom;
  
  if (SendMail($sujet, $mail_content, $destinataire_email, $destinataire_name)) {
    if (SendMail($sujet_validation, $mail_content_validation, $destinataire_validation_email, $destinataire_validation_name)) {
      echo 'true';
    }else{
      echo 'false';
    }
  }else{
    echo 'false';
  }
}

/**
*   Envoi du formulaire de contact
*   @param message
**/
function EnvoiFormulaireContact($nom, $prenom, $email, $message){
  $sujet = 'Un nouveau message reçu depuis le site web';
  $sujet_validation = 'Votre message à Equinoxe MIS Development';
  
  $mail_content = file_get_contents(dirname(__FILE__).'/mail_templates/mail_header.html');
  $mail_content .= file_get_contents(dirname(__FILE__).'/mail_templates/mail_content_contact.html');
  $mail_content .= file_get_contents(dirname(__FILE__).'/mail_templates/mail_footer.html');
  
  $mail_content_validation = file_get_contents(dirname(__FILE__).'/mail_templates/mail_header.html');
  $mail_content_validation .= file_get_contents(dirname(__FILE__).'/mail_templates/mail_content_contact_validation.html');
  $mail_content_validation .= file_get_contents(dirname(__FILE__).'/mail_templates/mail_footer.html');
  
  $mail_content = str_replace("%%%PRENOM%%%", $prenom, $mail_content);
  $mail_content = str_replace("%%%NOM%%%", $nom, $mail_content);
  $mail_content = str_replace("%%%EMAIL%%%", $email, $mail_content);
  $mail_content = str_replace("%%%MESSAGE%%%", $message, $mail_content);
  
  $mail_content_validation = str_replace("%%%MESSAGE%%%", $message, $mail_content_validation);
  
  $destinataire_email = 'ap@eqnx.ch';
  $destinataire_name = 'Aline Pfänder';
  $destinataire_validation_email = $email;
  $destinataire_validation_name = $prenom.' '.$nom;
  
  if (SendMail($sujet, $mail_content, $destinataire_email, $destinataire_name)) {
    if(SendMail($sujet_validation, $mail_content_validation, $destinataire_validation_email, $destinataire_validation_name)){
      echo 'true';
    }else{
      echo 'false';
    }
  }else{
    echo 'false';
  }
  
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
  $mail->Username = "liline4@gmail.com";
  $mail->Password = "Francine.01";
  
  $mail->AddAddress($for_email, $for_name);
  
  $mail->Subject= $subject;
  $mail->msgHTML($content);
  
  if (!$mail->send()) {
    return false;
  }else{
     return true;
  }
}
?>