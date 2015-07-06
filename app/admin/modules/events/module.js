$(document).ready(function() {
    //------ Variables globales ---------------------------
    urlAjaxModule = './modules/events/ajax.php';
    
    function switchTwoDiv(divToHide, divToShow) {
        $(divToHide).addClass('masked');
        $(divToShow).removeClass('masked');
    }
    
    //----- Toolbox ---------------------------------------
    $('.listing').on('click', '.btn', function() {
        var todo = $(this).attr('role');
        var idItem = $(this).attr('item');
        if(todo === 'event-comming') {
            $.post(urlAjaxModule, {a: 'changeStatus', idItem: idItem, setTo: '1' })
                .done(function(result) {
                    $('#wrapper-gestion').empty().append(result);
                });
        }
        if(todo === 'event-open') {
            $.post(urlAjaxModule, {a: 'changeStatus', idItem: idItem, setTo: '2' })
            .done(function(result) {
                $('#wrapper-gestion').empty().append(result);
            });
        }
        if(todo === 'event-closed') {
            $.post(urlAjaxModule, {a: 'changeStatus', idItem: idItem, setTo: '3' })
            .done(function(result) {
                $('#wrapper-gestion').empty().append(result);
            });
        }
        if(todo === 'event-trash') {
            if (confirm("Voulez-vous vraiment supprimer cet event ?")) { // Clic sur OK
                $.post(urlAjaxModule, {a: 'delEvent', idItem: idItem })
                .done(function(result) {
                    $('#wrapper-gestion').empty().append(result);
                });
            }
        }
        if(todo === 'event-edit') {
            $.post(urlAjaxModule, {a: 'editEvent', idItem: idItem })
            .done(function(result) {
                $('#wrapper-editing').empty().append(result);
                $('#wrapper-gestion').hide();
                switchTwoDiv('#wrapper-adding', '#wrapper-editing');
                $('.datepicker').datepicker($.datepicker.regional["fr"]);
                switchTwoDiv('#mnu-gest', '#return-to-gest');
            });
        }
    });
    
    //----- Editeur ---------------------------------------
    //$('#wrapper-adding').on('change', 'select', function() {
    //    $.post(urlAjaxModule, {a: 'switchLang', lang: $('#select-lang').val() })
    //    .done(function(result) {
    //        $('.trad-forms').addClass('masked');
    //        $('#trad-form-' + $('#select-lang').val()).removeClass('masked');
    //    });
    //});
    
    //$('#wrapper-editing').on('change', 'select', function() {
    //    $('.trad-forms').addClass('masked');
    //    $('#trad-edit-form-' + $('#select-lang-edit').val()).removeClass('masked');
    //});
    
    //$('.listing').on('click', '.sub-action', function() {
    //    if($(this).is('.fa-plus-square-o')) {
    //        swapClass($(this), false);
    //        showSubRows($(this).attr('tohide'));
    //    }
    //    else {
    //        swapClass($(this), true);
    //        hideSubRows($(this).attr('tohide'));
    //    }
    //});
    
    //function showSubRows(id) {
    //    $('.sub-row-' + id).slideDown('fast');
    //}
    
    //function hideSubRows(id) {
    //    $('.sub-row-' + id).slideUp('fast');
    //}
    
    //function swapClass(that, action) {
    //    if(action) {
    //        $(that).removeClass('fa-minus-square-o').addClass('fa-plus-square-o');
    //    }
    //    else {
    //        $(that).removeClass('fa-plus-square-o').addClass('fa-minus-square-o');
    //    }
    //}
    
    //----- Actions en masse ------------------------------
    //$('#wrapper-gestion').on('click', '#check-toggle', function() {
    //    if($(this).is(':checked')) {
    //        displayActionMasse(true);
    //        $('.check-masse-actions').attr('checked', true);
    //    }
    //    else {
    //        displayActionMasse(false);
    //        $('.check-masse-actions').attr('checked', false);
    //    }
    //});
    
    //$('#wrapper-gestion').on('click', '.check-masse-actions', function() {
    //    var oneSelected = false;
    //    $('.check-masse-actions').each(function() {
    //        if($(this).is(':checked')) {
    //            oneSelected = true;
    //        }
    //    });
    //    if(oneSelected === true) {
    //        displayActionMasse(true);
    //    }
    //    else {
    //        displayActionMasse(false);
    //    }
    //});
    
    //$('#module-wrapper').on('change', '#select-actions-masse', function() {
    //    var setTo = getNewValue($(this).val());
    //    $('.check-masse-actions').each(function() {
    //        if($(this).is(':checked')) {
    //            $.post(urlAjaxModule, {a: 'changeStatus', idItem: $(this).attr('item'), setTo: setTo });
    //        }
    //    });
    //    reloadListing();
    //    displayActionMasse(false);
    //});
    
    //function getNewValue(val) {
    //    switch(val) {
    //        case 'desactiver':
    //            var result = '0';
    //            break;
    //        case 'activer':
    //            var result = '1';
    //            break;
    //        case 'archiver':
    //            var result = '2';
    //            break;
    //        case 'supprimer':
    //            var result = '3';
    //            break;
    //        case 'restaurer':
    //            var result = '1';
    //            break;
    //    }
    //    return result;
    //}
    
    //function reloadListing() {
    //    $.post(urlAjaxModule, {a: 'reloadListing' })
    //    .done(function(result) {
    //        $('#wrapper-gestion').empty().append(result);
    //    });
    //}
    
    //function displayActionMasse(state) {
    //    if(state === true) {
    //        $('.masse-actions').slideDown('fast');
    //    }
    //    else {
    //        $('.masse-actions').slideUp('fast');
    //    }
    //}
});

//----- Datepicker ----------------------------------------
$(function() {
    $('.datepicker').datepicker($.datepicker.regional["fr"]);
});

