$(document).ready(function() {
    //------ Informations -------------------------------------------
    //(/iPhone|iPod|iPad|Linux/.test(navigator.platform))
    //(/iPhone|iPod|iPad|Android/.test(navigator.userAgent))
    
    //------ Variables globales -------------------------------------
    urlAjax = 'functions-ajax.php';
    
    //----- Mobile -------------------------------------------------------------
    if ((/iPhone|iPod|iPad|Linux/.test(navigator.platform))) {
        //----- Mise en page premier scree -------------------------------------------------------------
        var viewportH = $(window).height() + 22;
        $('.mobile-viewport').css({'min-height' : viewportH});
    }
    
    //------ Facebook -----------------------------------------------------------
    $('.fb-like-box').attr('data-width', $('.fb-like-box').parent().width());
    
    //----- Commande en ligne -------------------------------------------------------------
    $('#lst-products').on('click', 'img, .glyphicon-plus-sign', function() {
        if($(this).attr('prod-data') == '5') {
            addToCmd('menu', $(this).attr('idprod'));
            changeStep('1');
        }
        if($(this).attr('prod-data') == '1' || $(this).attr('prod-data') == '2') {
            addToCmd('sandwich', $(this).attr('idprod'));
            changeStep('2');
        }
        if($(this).attr('prod-data') == '6') {
            addToCmd('boisson', $(this).attr('idprod'));
            changeStep('3');
        }
        if($(this).attr('prod-data') == '4') {
            addToCmd('dessert', $(this).attr('idprod'));
            changeStep('4');
            displayValidButton();
        }
        loadLstProd($(this).attr('next-type-prod'));
    });
    
    $('#cmd-resume').on('click', 'img', function() {
        if($(this).attr('prevstep').length != 0) {
            loadLstProd($(this).attr('prevstep'));
        }
    });
    
    $('#cmd-steps').on('click', '.glyphicon', function() {
        if($(this).hasClass('glyphicon-ok')) {
            changeStep('4');
            loadLstProd('end-cmd');
        }
        if($(this).hasClass('glyphicon-remove')) {
            $.post(urlAjax, {a: 'cancelCmd' })
            .done(function(result) {
                $('#lst-products').empty().append(result);
                resetCmdInterface();
            });
        }
    });
    
    function addToCmd(index, id) {
        $.ajax({
            dataType: "json",
            type: "POST",
            url: urlAjax,
            data: { a: 'addToCmd', index: index, idprod: id }
        }).success(function(json) {
            if(index == 'menu')     { displayImg('#cmd-resume-bunch', json.img, '5'); }
            if(index == 'sandwich') { displayImg('#cmd-resume-sand', json.img, json.backstep); }
            if(index == 'boisson')  { displayImg('#cmd-resume-boisson', json.img, '6'); }
            if(index == 'dessert')  { displayImg('#cmd-resume-dessert', json.img, '4'); }
        }).error(function(x, textStatus, errorThrown) {
            console.log('ERREUR');
            console.log(x);
            console.log(textStatus);
            console.log(errorThrown);
        });
    }
    
    function displayImg(slot, img, backstep) {
        $(slot).empty().append('<img src="images/products/' + img + '" class="img-circle" prevstep="' + backstep + '">');
    }
    
    function displayValidButton() {
        $('#cmd-validation').fadeIn('slow');
    }
    
    function loadLstProd(prod) {
        if(prod === 'end-cmd') {
            $.post(urlAjax, {a: 'loadValidLogin' })
            .done(function(result) {
                $('#lst-products').empty().append(result);
            });
        }
        else if(prod === 'subscribe') {
            $.post(urlAjax, {a: 'loadSubscribForm' })
            .done(function(result) {
                $('#lst-products').empty().append(result);
            });
        }
        else {
            $.post(urlAjax, {a: 'loadLstProd', prod: prod })
            .done(function(result) {
                $('#lst-products').empty().append(result);
            });
        }
    }
    
    function changeStep(step) {
        $('#cmd-steps-img').attr('src', 'images/cmd_step0' + step + '.png');
    }
    
    function resetCmdInterface() {
        $('#cmd-pending').remove();
        displayImg('#cmd-resume-bunch', 'no_prod.png', '5');
        displayImg('#cmd-resume-sand', 'no_prod.png', '5');
        displayImg('#cmd-resume-boisson', 'no_prod.png', '6');
        displayImg('#cmd-resume-dessert', 'no_prod.png', '4');
        $('#cmd-validation').hide();
        changeStep('0');
    }
    
    //Reload de commande
    if($('#cmd-pending').length > 0) {
        reloadPreview();
    }
    
    function reloadPreview() {
        $.ajax({
            dataType: "json",
            type: "POST",
            url: urlAjax,
            data: { a: 'recuppendingcmd' }
        }).success(function(json) {
            var backsand
            if(json.menu == '13') { backsand = '1'; }
            if(json.menu == '14') { backsand = '2'; }
            
            if(json.menu) {
                getCmdImg('#cmd-resume-bunch',json.menu, '5');
                changeStep('1');
            }
            
            if(json.sandwich) {
                getCmdImg('#cmd-resume-sand', json.sandwich, backsand);
                changeStep('2');
            }
            
            if(json.boisson) {
                getCmdImg('#cmd-resume-boisson', json.boisson, '6');
                changeStep('3');
            }
            
            if(json.dessert) {
                getCmdImg('#cmd-resume-dessert', json.dessert, '4');
                changeStep('4');
                displayValidButton();
                loadLstProd('end-cmd');
            }
        }).error(function(x, textStatus, errorThrown) {
            console.log('ERREUR');
            console.log(x);
            console.log(textStatus);
            console.log(errorThrown);
        });
    }
    
    function getCmdImg(slot, id, backstep) {
        $.post(urlAjax, {a: 'getCmdImg', idprod: id })
        .done(function(img) {
            if(img.indexOf('.jpg') == -1) {
                displayImg(slot, 'no_prod.png', backstep);
            }
            else {
                displayImg(slot, img, backstep);
            }
        });
    }
    
    //----- Login / Sign in / Valide / Annule / Logout --------------------------------------------------------
    $('#lst-products').on('click', 'a', function() {
        if($(this).attr('id') == 'btn-login') {
            logIn();
        }
        if($(this).attr('id') == 'btn-logout') {
            logOut();
        }
        if($(this).attr('id') == 'btn-subscribe') {
            $('#cmd-preview').hide();
            loadLstProd('subscribe');
        }
        if($(this).attr('id') == 'btn-cancel-sub') {
            loadLstProd('end-cmd');
        }
        if($(this).attr('id') == 'btn-cancel') {
            $.post(urlAjax, {a: 'cancelCmd' })
            .done(function(result) {
                $('#lst-products').empty().append(result);
                resetCmdInterface();
            });
        }
        if($(this).attr('id') == 'btn-valide') {
            $.post(urlAjax, {a: 'valideCmd' })
            .done(function(result) {
                $('#lst-products').empty().append(result);
            });
        }
    });
    
    $(document).on('keyup', function(e) {
        if(e.keyCode == 13) {
            logIn();
        }
    });
    
    var user = function() {
        this.prenom = '';
        this.nom = '';
        this.email = '';
        this.telephone = '';
        this.password = '';
    }
    
    accomptForm = new user();
    
    $('#lst-products').on('change, keyup', '#subscribe-form', function() {
        var statPrenom = true;
        var statNom = true;
        var statEmail = true;
        var statTel = true;
        var statPassword = true;
        var statPasswordConf = false;
        
        if($('#prenom').val().length == 0) { statPrenom = false; }
        if($('#nom').val().length == 0) { statNom = false; }
        if($('#email').val().length == 0) { statEmail = false; }
        if(!verifSyntaxMail($('#email').val())) { statEmail = false; }
        if($('#telephone').val().length == 0) { statTel = false; }
        if($('#password').val().length == 0) { statPassword = false; }
        if($('#password').val() === $('#password_conf').val()) { statPasswordConf = true; }
        
        if(statPrenom === true && statNom === true && statEmail === true && statTel === true && statPassword === true && statPasswordConf === true) {
            $('#btn-signin').removeAttr('disabled');
            
            accomptForm.prenom = $('#prenom').val();
            accomptForm.nom = $('#nom').val();
            accomptForm.email = $('#email').val();
            accomptForm.telephone = $('#telephone').val();
            accomptForm.password = $('#password').val();
        }
        else {
            $('#btn-signin').attr('disabled', 'disabled');
        }
    });
    
    $('#lst-products').on('click', '#btn-signin', function() {
        $.post(urlAjax, {a: 'creatAccompt', prenom: accomptForm.prenom, nom: accomptForm.nom, email: accomptForm.email, telephone: accomptForm.telephone, password: accomptForm.password })
        .done(function() {
            loadLstProd('end-cmd');
        });
    });
    
    function logIn() {
        if($('#user_login').val().length != 0 && $('#user_password').val().length != 0) {
            $.post(urlAjax, {a: 'logMeIn', user_login: $('#user_login').val(), user_password: $('#user_password').val() })
            .done(function(result) {
                if(result != 'FALSE') {
                    loadLstProd('end-cmd');
                }
                else {
                    $('#login-form').prepend('<div class="alert alert-danger">Incorrect !</div>');
                    hideAlert();
                }
            })
            .fail(function() {
                $('#login-form').prepend('<div class="alert alert-danger">Une erreur est survenue...</div>');
                hideAlert();
            });
        }
        else {
            $('#login-form').prepend('<div class="alert alert-danger">Identifiant & Mot de passe !</div>');
            hideAlert();
        }
    }
    
    function logOut() {
        $.post(urlAjax, {a: 'logMeOut' })
        .done(function() {
            loadLstProd('end-cmd');
        });
    }
    
    function verifSyntaxMail(mail) {
        var reg = new RegExp('^[a-z0-9]+([_|\.|-]{1}[a-z0-9]+)*@[a-z0-9]+([_|\.|-]{1}[a-z0-9]+)*[\.]{1}[a-z]{2,6}$', 'i');
        return(reg.test(mail));
    }
    
    function hideAlert() {
        $('.alert').delay(3000).slideUp('fast'); 
    }

    //----- Navigation -------------------------------------------------------------
    $('.nav').on('click', 'a', function() {
        var target = '#' + $(this).attr('target');
        var offset;
        if ((/iPhone|iPod|iPad|Linux/.test(navigator.platform))) {
            offset = 40;
        }
        else {
            offset = 0;
        }
        if($(this).attr('target') == 'home') { offset = 60; }
        $('html, body').animate({scrollTop: ($(target).offset().top) - offset}, 500);
        console.log('Cliquer sur : ' + $(this).attr('target'));
    });

    $('img.price').on('click', function() {
        var target = '#' + $(this).attr('target');
        $('html, body').animate({scrollTop: ($(target).offset().top)}, 500);
    });

    $('img.concours-img').on('click', function() {
        var target = '#' + $(this).attr('target');
        $('html, body').animate({scrollTop: ($(target).offset().top)}, 500);
    });

    //----- Affichage des photos de produits -------------------------------------------------------------
    $('#a-la-carte').on('click', 'img', function() {
        $('#prodImg #theImg').attr('src',$(this).attr('src'));
        $('#prodImg #myModalLabel').empty().append($(this).attr('prod-name'));
    });
});
