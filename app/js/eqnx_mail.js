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
    
    function checkNom(formCode) {
        var nom = $('input[name="nom"][form-code="' + formCode + '"]').val();
        // Test Nom
        if (!nom) {
            $('input[name="nom"][form-code="' + formCode + '"]').after('<span class="error">Nom manquant</span>');
            return false;
        } else {
            return true;
        }
    }
    
    function checkMail(formCode) {
        var email = $('input[name="email"][form-code="' + formCode + '"]').val();
        // Test Mail
        if (!email) {
            $('input[name="email"][form-code="' + formCode + '"]').after('<span class="error">Email manquant</span>');
            return false;
        } else {
            if (isValidEmailAddress(email) === false) {
                $('input[name="email"][form-code="' + formCode + '"]').after('<span class="error">Email erroné</span>');
                return false;
            } else {
                return true;
            }
        }
    }
    
    function checkMessage(formCode) {
        var message = $('textarea[name="message"][form-code="' + formCode + '"]').val();
        // Test message
        if (!message) {
            $('textarea[name="message"][form-code="' + formCode + '"]').after('<span class="error">Votre message est vide</span>');
            return false;
        } else {
            return true;
        }
    }


    function validateForm(formCode) {
        $('span.error').remove();
        
        var isValid = true;
        
        if (checkNom(formCode) !== true) {
            isValid = false;
        }

        if (checkMail(formCode) !== true) {
            isValid = false;
        }

        
        if (formCode.contains('contact')) {
            // FORMULAIRE DE CONTACT
            if (checkMessage(formCode) !== true) {
                isValid = false;
            }
        }
    
        return isValid;
    }

    
    function sendForm(formCode) {
        
        var nom,
            email,
            message,
            eventName,
            eventDate,
            eventPlace;
        
        nom = $('input[name="nom"][form-code="' + formCode + '"]').val();
        email = $('input[name="email"][form-code="' + formCode + '"]').val();
        
        if (formCode.contains('contact')) {
            // FORMULAIRE DE CONTACTs    
            message = $('textarea[name="message"][form-code="' + formCode + '"]').val();
            
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
        
        if (formCode.contains('event')) {
            // FORMULAIRE D'INSCRIPTION AU EVENT            
            eventName = $('input[name="eventName"][form-code="' + formCode + '"]').val();
            eventDate = $('input[name="eventDate"][form-code="' + formCode + '"]').val();
            eventPlace = $('input[name="eventPlace"][form-code="' + formCode + '"]').val();
            
            $.ajax({
                url: urlAjaxFile, // Le nom du fichier
                type: "POST", // La méthode
                data: {a : 'sendMailInscr', nom: nom, email : email, event: eventName, eventDate : eventDate, eventPlace : eventPlace }
            })
                .done(function (msg) {
                    if (msg === 'true') {
                        $('.sending').removeClass('sending');
                        
                        swal({
                            title: "Inscription envoyée",
                            text: "Vous allez recevoir sous peu un email de confirmation,",
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
                        title: "Erreur lors de l'envoi de l'inscription",
                        text: "Réessayer plus tard, si le promlème persiste, merci de nous contacter par mail à l'adresse info@eqnx.ch.",
                        type: "error",
                        confirmButtonText: "Ok"
                    });
                });
            
        }
    }
    
    $('.send-form').on('click', function () {
        var formCode = $(this).attr('form-code');
        if (validateForm(formCode) === true) {
            sendForm(formCode);
            $(this).parent('div').addClass('sending');
        }
        
    });

});