$(document).ready(function() {
    //------ Renseignement automatique des champs -------------------------------------
    $('.pop-form').on('blur', 'input[name*="menu"]', function() {
        //console.log($(this).val());
        console.log(getLangSuffix($(this).attr('name')));
        $('input[name="title' + getLangSuffix($(this).attr('name')) + '"]').val($(this).val());
        $('input[name="url' + getLangSuffix($(this).attr('name')) + '"]').val(getURL($(this).val()));
    });
    
    function getLangSuffix(str) {
        return str.substring(str.length-3);
    }
    
    function getURL(str) {
        str=str.toLowerCase();
        
        var regAccentA = new RegExp('[àâä]', 'gi');
        var regAccentE = new RegExp('[éèêë]', 'gi');
        var regAccentI = new RegExp('[ïî]', 'gi');
        var regAccentO = new RegExp('[öô]', 'gi');
        var regAccentU = new RegExp('[ùüû]', 'gi');
        var regAccentAp = new RegExp("[']", "gi");
        var regAccentSp = new RegExp("[ ]", "gi");
        
        str = str.replace(regAccentA, 'a');
        str = str.replace(regAccentE, 'e');
        str = str.replace(regAccentI, 'i');
        str = str.replace(regAccentO, 'o');
        str = str.replace(regAccentU, 'u');
        str = str.replace(regAccentAp, '-');
        str = str.replace(regAccentSp, '-');
        
        return str;
    }
    
    //------ Formulaire d'édition d'une page -------------------------------------
    $('#edit-form').on('click', 'input[type="submit"]', function() {
        $.post(urlAjax, {a: 'update', module: 'pages', data: $('#form_edit').serializeArray() })
            .done(function(result) {
                $('#listing').empty().append(result);
                $('#edit-form').hide();
                applyDeployement();
                isSortable('pages');
        });
    });
});