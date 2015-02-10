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
        $('form').find("input[type=text], input[type=email], textarea").val("");
        $('label').removeClass('on');
    }
  
    function validateFormContact(mobile) {
        $('span.error').remove();
        
        if (mobile === false) {
            var inputNom = 'nom',
                inputEmail = 'email',
                inputMessage = 'message';
        } else {
            var inputNom = 'nom-mobile',
                inputEmail = 'email-mobile',
                inputMessage = 'message-mobile';
        }
                
        var nom = $('input[name="'+ inputNom +'"]').val(),
            email = $('input[name="'+ inputEmail +'"]').val(),
            message = $('textarea[name="'+ inputMessage +'"]').val(),
            isValid = true,
            regMail = /^([\w-\.]+@([\w-]+\.)+[\w-]{2,4})?$/,
            testNom = regMail.test(nom);
        
        // si nom vide
        if (!nom) {
            $('input[name="'+ inputNom +'"]').after('<span class="error">Nom manquant</span>');
            isValid = false;
        }

        // si message vide
        if (!message) {
            $('textarea[name="'+ inputMessage +'"]').after('<span class="error">Votre message est vide</span>');
            isValid = false;
        }

        // si mail vide
        if (!email) {
            $('input[name="'+ inputEmail +'"]').after('<span class="error">Email manquant</span>');
            isValid = false;
        } else {

            // test validité de l'email
            if (isValidEmailAddress(email) === false) {
                $('input[name="'+ inputEmail +'"]').after('<span class="error">Email erroné</span>');
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
                    $('.content-sem-inscr-valid').fadeIn().delay(5000).fadeOut();
                    clearForm();
                }
            })
            .fail(function (msg) {
                $('.content-sem-inscr-load').hide();
                $('.content-sem-inscr-error').fadeIn().delay(5000).fadeOut();
            });
    }
  
    function sendFormContact(mobile) {
        
        if (mobile === false) {
            var nom = $('input[name="nom"]').val(),
                email = $('input[name="email"]').val(),
                message = $('textarea[name="message"]').val();
        } else {
            var nom = $('input[name="nom-mobile"]').val(),
                email = $('input[name="email-mobile"]').val(),
                message = $('textarea[name="message-mobile"]').val();
        }
    
        $.ajax({
            url: urlAjaxFile, // Le nom du fichier
            type: "POST", // La méthode
            data: {a : 'sendMailContact', nom: nom,  email : email, message : message }
        })
            .done(function (msg) {
                if (msg === 'true') {
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
  
    $('#contact-form').on('click', function () {
        // si le formulaire est valide
        var mobile = false;
        if (validateFormContact(mobile) === true) {
            sendFormContact(mobile);
            $(this).parent('div').addClass('sending');
        }
    });
    $('#contact-form-mobile').on('click', function () {
        // si le formulaire est valide
        var mobile = true;
        if (validateFormContact(mobile) === true) {
            sendFormContact(mobile);
            $(this).parent('div').addClass('sending');
        }
    });

});