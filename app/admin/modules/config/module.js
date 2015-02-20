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
    $('.listing').on('click', 'input[type="checkbox"]', function() {
        var value = ($(this).is(':checked') ? '1' : '0');
        $.post(urlAjaxModule, {a: 'updateOptionValue', value: value, id: $(this).attr('ref') });
    });
    
    $('.listing').on('blur', 'input[type="text"]', function() {
        if($(this).attr('target') === 'value') {
            $.post(urlAjaxModule, {a: 'updateOptionValue', value: $(this).val(), id: $(this).attr('ref') });
        }
        if($(this).attr('target') === 'code') {
            var value = $(this).val();
            var id = $(this).attr('ref');
            $.post(urlAjaxModule, {a: 'updateOptionCode', value: value, id: id })
            .done(function(result) {
                $('#code-' + id).parent().empty().append(result);
            });
        }
    });
    
    $('.listing').on('click', '.code', function() {
        var value = $(this).html();
        var id = $(this).attr('ref');
        $(this).removeClass('code').empty().append('<input type="text" value="' + value + '" ref="' + id + '" id="code-' + id + '" target="code">');
    });
    
    $('#wrapper-adding').on('change', 'select.type-var-select', function() {
        if($(this).val() === 'str') {
            $('#var_value').empty().append('<input type="text" name="value_var">');
        }
        if($(this).val() === 'bool') {
            $('#var_value').empty().append('<div class="switch tiny round"><input name="value_var" id="value_var_bool" type="checkbox"><label for="value_var_bool"></label></div>');
        }
    });
});