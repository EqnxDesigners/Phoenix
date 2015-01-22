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
    
    //----- Validation du mot de passe --------------------
    $('#validation-pwd').on('keyup', '#mdp-conf', function() {
        if($('#mdp-ref').val() !== $(this).val()) {
            $(this).add('#mdp-ref').removeClass('match').addClass('notmatch');
            $('#valide-account').attr('disabled', 'disabled');
        }
        else {
            $(this).add('#mdp-ref').removeClass('notmatch').addClass('match');
            //$('#valide-account').prop('disabled', false);
            $('#valide-account').removeAttr('disabled');
        }
    });
    
    //Validation du compte
    $('#verif-box').on('click', '#valide-account', function() {
        //Regarde que les champs obligatoires soient saisi
        var alerte = '';
        var ReadyToSend = true;
        
        if($('input[name="email"]').val().length !== 0) {
            if($('input[name="societe"]').val().length === 0) {
                if($('input[name="nom"]').val().length === 0 && $('input[name="prenom"]').val().length === 0) {
                    alerte = 'Une societe, un nom ou un prénom est obligatoire';
                    ReadyToSend = false;
                }
            }
        }
        else {
            alerte = 'Une e-mail valide est obligatoire';
            ReadyToSend = false;
        }
        
        if(ReadyToSend) {
            var data = {};
            $('#form_valid input, #form_valid select').each(function() {
                data[this.name] = this.value;
            });
            $.post(urlAjax, {a: 'valideClient', data: data })
            .done(function(result) {
                if(result === 'TRUE') {
                    location.href = 'index.php';
                }    
                else {
                    $('#form_valid').prepend('<div data-alert class="alert-box alert radius">Une erreur est survenue !</div>');
                    hideAlert();
                }
            })
            .fail(function() {
                $('#form_valid').prepend('<div data-alert class="alert-box alert radius">Une erreur est survenue...</div>');
                hideAlert();
            });
        }
        else {
            $('#form_valid').prepend('<div data-alert class="alert-box alert radius">' + alerte + '</div>');
            hideAlert();
        }
    });
    
    //-----------------------------------------------------
    //----- MyEqnx globals --------------------------------
    //-----------------------------------------------------
   
    //----- Mix it up -------------------------------------
    $('#docsMyEqnx').mixItUp();
    $('#videosMyEqnx').mixItUp();
    
    
    //----- Search input -------------------------------------
    var inputText;
    var $matching = $();

    var delay = (function(){
        var timer = 0;
        return function(callback, ms){
            clearTimeout (timer);
            timer = setTimeout(callback, ms);
        };
    })();

    $(".tool-search input[type='text']").keyup(function(){
        // Delay function invoked to make sure user stopped typing
        delay(function(){
            inputText = $(".tool-search input[type='text']").val().toLowerCase();
            // Check to see if input field is empty
            if ((inputText.length) > 0) {            
                $('.mix').each(function() {
                    var $this = $(this);

                    // add item to be filtered out if input text matches items inside the title   
                    if($this.attr('class').toLowerCase().match(inputText)) {
                        $matching = $matching.add(this);
                    } else {
                        // removes any previously matched item
                        $matching = $matching.not(this);
                    }
                });
                $('.item-list ul').mixItUp('filter', $matching);
            } else {
                // resets the filter to show all item if input is empty
                $('.item-list ul').mixItUp('filter', 'all');
            }
        }, 200 );
    });
    
    $('#myEqnx-menu a').on('click', function (){
        $('#myEqnx-menu li').removeClass('active');
        $(this).parent('li').addClass('active');
    });

    
});


//----- Foundation ----------------------------------------
$(document).foundation();