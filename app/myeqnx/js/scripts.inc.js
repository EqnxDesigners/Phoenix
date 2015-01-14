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
                location.href = 'index.php';
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
            $.post(urlAjax, {a: 'logClientIn', user_login: $('#user_login').val(), user_password: $('#user_password').val() })
            .done(function(result) {
                if(result === 'FALSE') {
                    $('#form_login').prepend('<div data-alert class="alert-box alert radius">Incorrect !</div>');
                    hideAlert();
                }    
                else {
                    sessionStorage.setItem('clientlogged', 'true');
                    secureSynch();
                    location.href = 'index.php';
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
        if(sessionStorage.getItem('clientlogged') === 'true') {
            startSecureSynch();
        }
    }
    
    function securityCheck() {
        if(sessionStorage.getItem('clientSecureKey') === 'true') {
            $.post(urlAjax, { a: 'securityCheck', token: sessionStorage.getItem('clientSecureKey') })
            .done(function(result) {
                if(result === 'FALSE') {
                    $.post(urlAjax, {a: 'logMeOut' })
                    .done(function() {
                        sessionStorage.clear();
                        location.href = 'index.php';
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
            sessionStorage.setItem('clientSecureKey', result);
        });
    }
    
    //----- Divers ----------------------------------------
    function hideAlert() {
        $('.alert-box').delay(3000).slideUp('fast'); 
    }
    
    //-----------------------------------------------------
    //----- MyEqnx globals --------------------------------
    //-----------------------------------------------------
    
    
});

//----- Foundation ----------------------------------------
$(document).foundation();