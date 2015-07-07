$(document).ready(function() {
    //------ Variables globales ---------------------------
    urlAjaxModule = './modules/traductions/ajax.php';
    
    function switchTwoDiv(divToHide, divToShow) {
        $(divToHide).addClass('masked');
        $(divToShow).removeClass('masked');
    }
    
    //----- Toolbox ---------------------------------------
    $('.listing').on('click', '.btn', function() {
        var todo = $(this).attr('role');
        var idItem = $(this).attr('item');
        //if(todo === 'event-comming') {
        //    $.post(urlAjaxModule, {a: 'changeStatus', idItem: idItem, setTo: '1' })
        //        .done(function(result) {
        //            $('#wrapper-gestion').empty().append(result);
        //        });
        //}
        //if(todo === 'event-open') {
        //    $.post(urlAjaxModule, {a: 'changeStatus', idItem: idItem, setTo: '2' })
        //    .done(function(result) {
        //        $('#wrapper-gestion').empty().append(result);
        //    });
        //}
        //if(todo === 'event-closed') {
        //    $.post(urlAjaxModule, {a: 'changeStatus', idItem: idItem, setTo: '3' })
        //    .done(function(result) {
        //        $('#wrapper-gestion').empty().append(result);
        //    });
        //}
        if(todo === 'event-trash') {
            if (confirm("Voulez-vous vraiment supprimer cet event ?")) { // Clic sur OK
                $.post(urlAjaxModule, {a: 'delEvent', idItem: idItem })
                .done(function(result) {
                    $('#wrapper-gestion').empty().append(result);
                });
            }
        }
        //if(todo === 'event-edit') {
        //    $.post(urlAjaxModule, {a: 'editEvent', idItem: idItem })
        //    .done(function(result) {
        //        $('#wrapper-editing').empty().append(result);
        //        $('#wrapper-gestion').hide();
        //        switchTwoDiv('#wrapper-adding', '#wrapper-editing');
        //        $('.datepicker').datepicker($.datepicker.regional["fr"]);
        //        switchTwoDiv('#mnu-gest', '#return-to-gest');
        //    });
        //}
    });
    
    //----- Detecteur d'alertes ---------------------------
    if($('.alert-box').is(':visible')) {
        switchTwoDiv('#wrapper-gestion', '#wrapper-adding');
    }

});

