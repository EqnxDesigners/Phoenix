$(document).ready(function() {
    //------ Variables globales ---------------------------
    urlAjaxModule = './modules/news/ajax.php';
    
    function switchTwoDiv(divToHide, divToShow) {
        $(divToHide).addClass('masked');
        $(divToShow).removeClass('masked');
    }
    
    // TEST
//    $.ajax({
//        dataType: "json",
//        type: "POST",
//        url: urlAjaxModule,
//        data: { a: 'test' }
//    })
//    .done(function(json) {
//        console.log('RESULTAT DE LA REQUETE');
//        console.log(json.title_1.placeholder);
//    })
//    .error(function(x, textStatus, errorThrown) {
//        console.log('ERREUR');
//        console.log(x);
//        console.log(textStatus);
//        console.log(errorThrown);
//    })
//    .always(function() {
//        console.log( "complete" );
//    });
    // #TEST
    
    //----- Menu module -----------------------------------
    $('nav').on('click', '.btn', function() {
        var todo = $(this).attr('role');
        if(todo === 'display-news' || todo === 'display-archives' || todo === 'display-trash') {
            var status = getStatusValue(todo);
            $.post(urlAjaxModule, {a: 'displayOtherNews', status: status })
            .done(function(result) {
                $('#wrapper-gestion').empty().append(result);
                buildMasseActionsMenu(status);
                displayActionMasse(false);
                displayEmptyTrash(todo);
            });
        }
    });
    
    $('nav').on('click', '.empty-trash', function() {
        //----- Vider la corbeille ------------------------
        if (confirm("Voulez-vous vraiment vider la corbeille ?")) { // Clic sur OK
           $.post(urlAjaxModule, {a: 'emptyTrash' })
            .done(function() {
                reloadListing();
                $('.empty-trash').hide();
            });
        }
    });
    
    function getStatusValue(todo) {
        switch(todo) {
            case 'display-news':
                var result = '0';
                break;
            case 'display-archives':
                var result = '2';
                break;
            case 'display-trash':
                var result = '3';
                break;
        }
        return result;
    }
    
    function buildMasseActionsMenu(status) {
        $.post(urlAjaxModule, {a: 'buildMasseActionsMenu', status: status })
        .done(function(result) {
            $('.masse-actions').empty().append(result);
        });
    }
    
    function displayEmptyTrash(todo) {
        if(todo === 'display-trash') {
            $('.empty-trash').show();
        }
        else {
            $('.empty-trash').hide();
        }
    }
    
    //----- Toolbox ---------------------------------------
    $('.listing').on('click', '.btn', function() {
        var todo = $(this).attr('role');
        var idItem = $(this).attr('item');
        if(todo === 'news-enable') {
            $.post(urlAjaxModule, {a: 'changeStatus', idItem: idItem, setTo: '1' })
            .done(function(result) {
                $('#wrapper-gestion').empty().append(result);
            });
        }
        if(todo === 'news-disable') {
            $.post(urlAjaxModule, {a: 'changeStatus', idItem: idItem, setTo: '0' })
            .done(function(result) {
                $('#wrapper-gestion').empty().append(result);
            });
        }
        if(todo === 'news-archives') {
            $.post(urlAjaxModule, {a: 'changeStatus', idItem: idItem, setTo: '2' })
            .done(function(result) {
                $('#wrapper-gestion').empty().append(result);
            });
        }
        if(todo === 'news-trash') {
            $.post(urlAjaxModule, {a: 'changeStatus', idItem: idItem, setTo: '3' })
            .done(function(result) {
                $('#wrapper-gestion').empty().append(result);
            });
        }
        if(todo === 'news-restore') {
            $.post(urlAjaxModule, {a: 'changeStatus', idItem: idItem, setTo: '1' })
            .done(function(result) {
                $('#wrapper-gestion').empty().append(result);
            });
        }
        if(todo === 'news-edit') {
            $.post(urlAjaxModule, {a: 'loadSelectedNews', idItem: idItem })
            .done(function(result) {
                $('#wrapper-editing').empty().append(result);
                $('#wrapper-gestion').hide();
                switchTwoDiv('#wrapper-adding', '#wrapper-editing');
                $('.datepicker').datepicker($.datepicker.regional["fr"]);
                switchTwoDiv('#mnu-gest', '#return-to-gest');
                tinymce.execCommand('mceAddEditor', false, 'news-editor_fr');
                tinymce.execCommand('mceAddEditor', false, 'news-editor_de');
                tinymce.execCommand('mceAddEditor', false, 'news-editor_en');
                tinymce.execCommand('mceAddEditor', false, 'news-editor_it');
            });
        }
    });
    
    //----- Editeur ---------------------------------------
    $('#wrapper-adding').on('change', 'select', function() {
        $.post(urlAjaxModule, {a: 'switchLang', lang: $('#select-lang').val() })
        .done(function(result) {
            $('.trad-forms').addClass('masked');
            $('#trad-form-' + $('#select-lang').val()).removeClass('masked');
        });
    });
    
    $('#wrapper-editing').on('change', 'select', function() {
        $('.trad-forms').addClass('masked');
        $('#trad-edit-form-' + $('#select-lang-edit').val()).removeClass('masked');
    });
    
    
    
    $('.listing').on('click', '.sub-action', function() {
        if($(this).is('.fa-plus-square-o')) {
            swapClass($(this), false);
            showSubRows($(this).attr('tohide'));
        }
        else {
            swapClass($(this), true);
            hideSubRows($(this).attr('tohide'));
        }
    });
    
    function showSubRows(id) {
        $('.sub-row-' + id).slideDown('fast');
    }
    
    function hideSubRows(id) {
        $('.sub-row-' + id).slideUp('fast');
    }
    
    function swapClass(that, action) {
        if(action) {
            $(that).removeClass('fa-minus-square-o').addClass('fa-plus-square-o');
        }
        else {
            $(that).removeClass('fa-plus-square-o').addClass('fa-minus-square-o');
        }
    }
    
    //----- Actions en masse ------------------------------
    $('#wrapper-gestion').on('click', '#check-toggle', function() {
        if($(this).is(':checked')) {
            displayActionMasse(true);
            $('.check-masse-actions').attr('checked', true);
        }
        else {
            displayActionMasse(false);
            $('.check-masse-actions').attr('checked', false);
        }
    });
    
    $('#wrapper-gestion').on('click', '.check-masse-actions', function() {
        var oneSelected = false;
        $('.check-masse-actions').each(function() {
            if($(this).is(':checked')) {
                oneSelected = true;
            }
        });
        if(oneSelected === true) {
            displayActionMasse(true);
        }
        else {
            displayActionMasse(false);
        }
    });
    
    $('#module-wrapper').on('change', '#select-actions-masse', function() {
        var setTo = getNewValue($(this).val());
        $('.check-masse-actions').each(function() {
            if($(this).is(':checked')) {
                $.post(urlAjaxModule, {a: 'changeStatus', idItem: $(this).attr('item'), setTo: setTo });
            }
        });
        reloadListing();
        displayActionMasse(false);
    });
    
    function getNewValue(val) {
        switch(val) {
            case 'desactiver':
                var result = '0';
                break;
            case 'activer':
                var result = '1';
                break;
            case 'archiver':
                var result = '2';
                break;
            case 'supprimer':
                var result = '3';
                break;
            case 'restaurer':
                var result = '1';
                break;
        }
        return result;
    }
    
    function reloadListing() {
        $.post(urlAjaxModule, {a: 'reloadListing' })
        .done(function(result) {
            $('#wrapper-gestion').empty().append(result);
        });
    }
    
    function displayActionMasse(state) {
        if(state === true) {
            $('.masse-actions').slideDown('fast');
        }
        else {
            $('.masse-actions').slideUp('fast');
        }
    }
});

//----- Datepicker ----------------------------------------
$(function() {
    $('.datepicker').datepicker($.datepicker.regional["fr"]);
});

//----- TinyMCE -------------------------------------------
tinymce.init({
    selector:'.extend-text',
    language : 'fr_FR',
    menubar : false,
    height : 400,
    plugins: [
        "advlist autolink link image lists charmap print preview hr anchor pagebreak spellchecker",
        "searchreplace wordcount visualblocks visualchars code fullscreen insertdatetime media nonbreaking",
        "save table contextmenu directionality emoticons template paste textcolor"
    ],
    toolbar: "styleselect | bold underline italic | undo redo | alignleft aligncenter alignright alignjustify | bullist numlist outdent indent | link unlink | quote code image | forecolor backcolor"
});