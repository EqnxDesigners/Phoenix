$(document).ready(function() {
    //------ Check login ----------------------------------
    checkIfLogged();
    securityCheck();
    
    //------ Variables globales ---------------------------
    urlAjax = './functions-ajax.php';
    
    //----- Logout ----------------------------------------
    $('#top-bar').on('click', '.fa', function() {
        if($(this).attr('role') === 'logout') {
            $.post(urlAjax, {a: 'logMeOut' })
            .done(function() {
                sessionStorage.clear();
                location.href = 'index_spip.php';
            });
        }
    });
    
    //----- Login -----------------------------------------
    //Login en taper "Enter"
    $(document).on('keyup', function(e) {
        if(e.keyCode == 13) {
            logIn();
        }
    });
    
    //Login au clique
    $('#login-box').on('click', '#log-me-in', function() {
        logIn();
    });
    
    function logIn() {
        if($('#user_login').val().length != 0 && $('#user_password').val().length != 0) {
            $.post(urlAjax, {a: 'logMeIn', user_login: $('#user_login').val(), user_password: $('#user_password').val() })
            .done(function(result) {
                if(result === 'FALSE') {
                    $('#form_login').prepend('<div data-alert class="alert-box alert radius">Incorrect !</div>');
                    hideAlert();
                }    
                else {
                    sessionStorage.setItem('logged', 'true');
                    secureSynch();
                    location.href = 'index_spip.php';
                }
            })
            .fail(function() {
                $('#form_login').prepend('<div data-alert class="alert-box alert radius">Une erreur est survenue...</div>');
                hideAlert();
            });
        }
        else {
            $('#form_login').prepend('<div data-alert class="alert-box alert radius">Identifiant & Mot de passe !</div>');
            hideAlert();
        }
    }
    
    //----- Secure Synch ----------------------------------
    function checkIfLogged() {
        if(sessionStorage.getItem('logged') === 'true') {
            startSecureSynch();
        }
    }
    
    function securityCheck() {
        if(sessionStorage.getItem('secureKey') === 'true') {
            $.post(urlAjax, { a: 'securityCheck', token: sessionStorage.getItem('secureKey') })
            .done(function(result) {
                if(result === 'FALSE') {
                    $.post(urlAjax, {a: 'logMeOut' })
                    .done(function() {
                        sessionStorage.clear();
                        location.href = 'index_spip.php';
                    });
                }
            });
        }
    }
    
    function startSecureSynch() {
        intervalID = setInterval(secureSynch, 30000);
    }
    
    function secureSynch() {
        $.post(urlAjax, { a: 'secureSynch' })
        .done(function(result) {
            sessionStorage.setItem('secureKey', result);
        });
    }
    
    //----- Divers ----------------------------------------
    function hideAlert() {
        $('.alert-box').delay(3000).slideUp('fast'); 
    }
    
    //-----------------------------------------------------
    //----- Modules globals -------------------------------
    //-----------------------------------------------------
    
    //----- Menu module -----------------------------------
    $('nav').on('click', '.btn', function() {
        var todo = $(this).attr('role');
        if(todo === 'add') {
            switchTwoDiv('#mnu-gest', '#return-to-gest');
            switchTwoDiv('#wrapper-gestion', '#wrapper-adding');
        }
        if(todo === 'back-to-gest') {
            switchTwoDiv('#return-to-gest', '#mnu-gest');
            if(!$('#wrapper-adding').hasClass('masked')) {
                $('#wrapper-adding').addClass('masked');
            }
            if(!$('#wrapper-editing').hasClass('masked')) {
                $('#wrapper-editing').addClass('masked');
            }
            $('#wrapper-gestion').show();
        }
    });
    
    //----- Toolbox ---------------------------------------
    $('.listing').on('click', '.btn', function() {
        var todo = $(this).attr('role');
        var idItem = $(this).attr('item');
        if(todo === 'edit') {
            switchTwoDiv('#mnu-gest', '#return-to-gest');
            $.post(urlAjax, {a: 'editItem', idItem: idItem })
            .done(function(result) {
                $('#wrapper-editing').empty().append(result);
                $('#wrapper-gestion').hide();
                switchTwoDiv('#wrapper-adding', '#wrapper-editing');
            });
        }
        if(todo === 'trash') {
            if (confirm("Voulez-vous vraiment supprimer cet élément ?")) { // Clic sur OK
                $.post(urlAjax, {a: 'deleteItem', idItem: idItem })
                .done(function(result) {
                    $('#wrapper-gestion').empty().append(result);
                });
            }
        }
        if(todo === 'disable') {
            $.post(urlAjax, {a: 'changeVisibility', idItem: idItem, newValue: '0' })
            .done(function(result) {
                $('#wrapper-gestion').empty().append(result);
            });
        }
        if(todo === 'enable') {
            $.post(urlAjax, {a: 'changeVisibility', idItem: idItem, newValue: '1' })
            .done(function(result) {
                $('#wrapper-gestion').empty().append(result);
            });
        }
    });
    
    function switchTwoDiv(divToHide, divToShow) {
        $(divToHide).addClass('masked');
        $(divToShow).removeClass('masked');
    }
    
});

//----- Foundation ----------------------------------------
$(document).foundation();
