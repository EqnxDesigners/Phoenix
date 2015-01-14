/*global $, console, alert, swal*/
$(document).ready(function () {
  'use strict';

  //------ Variables globales ---------------------------
  var urlAjaxFile = './ajax.php';
  
  //------ ETAT INIATIAL ---------------------------
  $('.content-sem-inscr-valid').hide();
  $('.content-sem-inscr-load').hide();
  $('.content-sem-inscr-error').hide();
  $('#sendingButton').hide();
  
  function isValidEmailAddress(emailAddress) {
    var pattern = new RegExp(/^((([a-z]|\d|[!#\$%&'\*\+\-\/=\?\^_`{\|}~]|[\u00A0-\uD7FF\uF900-\uFDCF\uFDF0-\uFFEF])+(\.([a-z]|\d|[!#\$%&'\*\+\-\/=\?\^_`{\|}~]|[\u00A0-\uD7FF\uF900-\uFDCF\uFDF0-\uFFEF])+)*)|((\x22)((((\x20|\x09)*(\x0d\x0a))?(\x20|\x09)+)?(([\x01-\x08\x0b\x0c\x0e-\x1f\x7f]|\x21|[\x23-\x5b]|[\x5d-\x7e]|[\u00A0-\uD7FF\uF900-\uFDCF\uFDF0-\uFFEF])|(\\([\x01-\x09\x0b\x0c\x0d-\x7f]|[\u00A0-\uD7FF\uF900-\uFDCF\uFDF0-\uFFEF]))))*(((\x20|\x09)*(\x0d\x0a))?(\x20|\x09)+)?(\x22)))@((([a-z]|\d|[\u00A0-\uD7FF\uF900-\uFDCF\uFDF0-\uFFEF])|(([a-z]|\d|[\u00A0-\uD7FF\uF900-\uFDCF\uFDF0-\uFFEF])([a-z]|\d|-|\.|_|~|[\u00A0-\uD7FF\uF900-\uFDCF\uFDF0-\uFFEF])*([a-z]|\d|[\u00A0-\uD7FF\uF900-\uFDCF\uFDF0-\uFFEF])))\.)+(([a-z]|[\u00A0-\uD7FF\uF900-\uFDCF\uFDF0-\uFFEF])|(([a-z]|[\u00A0-\uD7FF\uF900-\uFDCF\uFDF0-\uFFEF])([a-z]|\d|-|\.|_|~|[\u00A0-\uD7FF\uF900-\uFDCF\uFDF0-\uFFEF])*([a-z]|[\u00A0-\uD7FF\uF900-\uFDCF\uFDF0-\uFFEF])))\.?$/i);
    return pattern.test(emailAddress);
  }

  function clearForm() {
    $('form').find("input[type=text], textarea").val("");
  }
  
  function validateFormContact() {
    $('span.error').remove();

    var isValid = true,
      regMail = /^([\w-\.]+@([\w-]+\.)+[\w-]{2,4})?$/,
      nom = $('input[name="nom"]').val(),
      prenom = $('input[name="prenom"]').val(),
      email = $('input[name="email"]').val(),
      message = $('textarea[name="message"]').val(),
      testNom = regMail.test(nom);
        
    // si nom vide
    if (!nom) {
      $('input[name="nom"]').after('<span class="error">Nom manquant</span>');
      isValid = false;
    }
    
    // si prenom vide
    if (!prenom) {
      $('input[name="prenom"]').after('<span class="error">Prénom manquant</span>');
      isValid = false;
    }
    
    // si message vide
    if (!message) {
      $('textarea[name="message"]').after('<span class="error">Votre message est vide</span>');
      isValid = false;
    }

    // si mail vide
    if (!email) {
      $('input[name="email"]').after('<span class="error">Email manquant</span>');
      isValid = false;
    } else {

      // test validité de l'email
      if (isValidEmailAddress(email) === false) {
        $('input[name="email"]').after('<span class="error">Email erroné</span>');
        isValid = false;
      }
    }

    return isValid;
  }

  function validateFormInscr() {
    $('span.error').remove();

    var isValid = true,
      regMail = /^([\w-\.]+@([\w-]+\.)+[\w-]{2,4})?$/,
      nom = $('input[name="nom"]').val(),
      prenom = $('input[name="prenom"]').val(),
      email = $('input[name="email"]').val(),
      testNom = regMail.test(nom),
      event = $('input[name="event"]').val(),
      eventDate = $('input[name="eventDate"]').val(),
      eventPlace = $('input[name="eventPlace"]').val();

    // si nom vide
    if (!nom) {
      $('input[name="nom"]').after('<span class="error">Nom manquant</span>');
      isValid = false;
    }
    // si prenom vide
    if (!prenom) {
      $('input[name="prenom"]').after('<span class="error">Prénom manquant</span>');
      isValid = false;
    }

    // si mail vide
    if (!email) {
      $('input[name="email"]').after('<span class="error">Email manquant</span>');
      isValid = false;
    } else {

      // test validité de l'email
      if (isValidEmailAddress(email) === false) {
        $('input[name="email"]').after('<span class="error">Email erroné</span>');
        isValid = false;
      }
    }

    return isValid;
  }
  
  function sendFormInscr() {
    var nom = $('input[name="nom"]').val(),
      prenom = $('input[name="prenom"]').val(),
      email = $('input[name="email"]').val(),
      event = $('input[name="event"]').val(),
      eventDate = $('input[name="eventDate"]').val(),
      eventPlace = $('input[name="eventPlace"]').val();
    
    $.ajax({
      url: urlAjaxFile, // Le nom du fichier
      type: "POST", // La méthode
      data: {a : 'sendMailInscr', nom: nom, prenom: prenom, email : email, event: event, eventDate : eventDate, eventPlace : eventPlace }
    })
      .done(function (msg) {
        if (msg === 'true') {
          $('.content-sem-inscr-load').hide();
          $('.content-sem-inscr-valid').fadeIn().delay(2400).fadeOut();
          clearForm();
        }
      })
      .fail(function (msg) {
        $('.content-sem-inscr-load').hide();
        $('.content-sem-inscr-error').fadeIn().delay(2400).fadeOut();
      });
  }
  
  function sendFormContact() {
    var nom = $('input[name="nom"]').val(),
      prenom = $('input[name="prenom"]').val(),
      email = $('input[name="email"]').val(),
      message = $('textarea[name="message"]').val();
    
    $.ajax({
      url: urlAjaxFile, // Le nom du fichier
      type: "POST", // La méthode
      data: {a : 'sendMailContact', nom: nom, prenom: prenom, email : email, message : message }
    })
      .done(function (msg) {
        if (msg === 'true') {
//          console.log('envoyé');
          $('.sending').removeClass('sending');
          
          swal({
            title: "Message envoyé",
            text: "Nous vous répondrons dans les plus brefs délais.",
            type: "success",
            confirmButtonText: "Ok"
          });
          
          // VIDER LE FORMULAIRE
          clearForm();
        }
      })
      .fail(function (msg) {
        $('.sending').removeClass('sending');
      
        swal({
          title: "Erreur lors de l'envoi du message",
          text: "Réessayer plus tard, si le promlème persiste, merci de nous contacter par mail à l'adresse info@eqnx.ch.",
          type: "error",
          confirmButtonText: "Ok"
        });
      });
  }


  $('#seminaireForm').on('click', function () {
    // si le formulaire est valide
    if (validateFormInscr() === true) {
      sendFormInscr();
      $('.content-sem-inscr').hide();
      $('.content-sem-inscr-load').fadeIn();
    }
  });
  
  $('#contactForm').on('click', function () {
    // si le formulaire est valide
    if (validateFormContact() === true) {
      sendFormContact();
      $(this).parent('div').addClass('sending');
    }
  });

});