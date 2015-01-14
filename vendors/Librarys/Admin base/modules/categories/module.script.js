$(document).ready(function() {
    //------ Formulaire d'édition d'une catégorie -------------------------------------
    $('#edit-form').on('click', 'input[type="submit"]', function() {
        $.post(urlAjax, {a: 'update', module: 'categories', data: $('#form_edit').serializeArray() })
            .done(function(result) {
                $('#listing').empty().append(result);
                $('#edit-form').hide();
                applyDeployement();
        });
    });
});