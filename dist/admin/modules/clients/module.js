$(document).ready(function() {
    //------ Variables globales ---------------------------
    urlAjaxModule = './modules/config/ajax.php';
    
    //----- Menu module -----------------------------------
    $('nav').on('click', '.btn', function() {
        var todo = $(this).attr('role');
        if(todo === 'add') {
            switchTwoDiv('#mnu-gest', '#return-to-gest');
            switchTwoDiv('#wrapper-display', '#wrapper-adding');
        }
        if(todo === 'back-to-gest') {
            switchTwoDiv('#return-to-gest', '#mnu-gest');
            switchTwoDiv('#wrapper-adding', '#wrapper-display');
        }
    });
    
    function switchTwoDiv(divToHide, divToShow) {
        $(divToHide).addClass('masked');
        $(divToShow).removeClass('masked');
    }
    
    //----- Editeur ---------------------------------------
});