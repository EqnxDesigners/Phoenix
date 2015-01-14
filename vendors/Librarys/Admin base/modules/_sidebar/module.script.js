$(document).ready(function() {
    //Boutons de l'interface
    $('#assigned-widgets-content').delegate('.tool', 'click', function() {
        var ToDO = $(this).attr('role');
        
        //Ouverture des del-box
        if(ToDO == 'open_del_box') {
            console.log('Ouverture de la del box');
            $('.pop-box').slideUp('fast');
            var Id = $(this).attr('alt');
            $('#del_' + Id).slideDown('fast');
        }
        
        //Supprimer un article
        if(ToDO == 'remove-widget') {
            var idWidget = $(this).attr('alt');
            var idPage   = $(this).attr('idpage');
            $.ajax({
                type:"POST",
                url:"modules/sidebar/module.ajax.php",
                data: { action : "delWidget", idwidget : idWidget, idpage : idPage }
            }).done(function(result) {
                $('#assigned-widgets-content').empty().append(result);
                reorderWidgets();
            });
        }
    });
    
    //Master switch
    $('#assigned-widgets').delegate('.master-switch', 'click', function() {
        var Id          = $(this).attr('id');
        var NewValue    = $(this).attr('alt');
        var Element     = $(this).attr('role');
        $.ajax({
            type:"POST",
            url:"modules/sidebar/module.ajax.php",
            data: { action : "masterSwitch", id : Id, new_value : NewValue, element : Element }
        }).done(function(result) {
            $('#' + Element + '_' + Id).empty().append(result);
        });
    });
    
    //Sélectionner une page
    $('.page-selector').on('click', function() {
        var idPage = $(this).attr('role');
        $('.notifier').empty();
        $('#notifier-' + idPage).append('<img src="imgs/bton_valid_green.png">');
        $('#helper').empty().append('Ajoutez des widgets');
        $.ajax({
            type:"POST",
            url:"modules/sidebar/module.ajax.php",
            data: { action : "getWidgets", idpage : idPage }
        }).done(function(result) {
            var Values = result.split('@');
            $('#list-widgets-content').empty().append(Values[0]);
            $('#assigned-widgets-content').empty().append(Values[1]);
            reorderWidgets();
        });
    });
    
    //Ajouter un widget
    $('#list-widgets').delegate('.widget-selector', 'click', function() {
        var idPage = $(this).attr('alt');
        var idWidget = $(this).attr('role');
        $.ajax({
            type:"POST",
            url:"modules/sidebar/module.ajax.php",
            data: { action : "addWidgets", idpage : idPage, idwidget : idWidget }
        }).done(function(result) {
            $('#assigned-widgets-content').empty().append(result);
            reorderWidgets();
        });
    });
    
    function reorderWidgets() {
        $('ul.sortable').sortable({
                axis: "y",
                items: "li:not(.no_drag)",
                placeholder : '.placeholder',                       // stylise le placeholder
                forcePlaceholderSize : true,                        // force le redimensionnement du placeholder
                opacity : 0.8,                                      // réduit l'opacité lors du déplacement
                update: function() {                                // callback quand l'ordre de la liste est changé
                        var ListIDs;
                        $('ul.sortable li').each(function() {
                                var id = $(this).attr('role');
                                ListIDs = ListIDs + id;
                        });
                        $.ajax({
                                type: "POST",
                                url: "modules/sidebar/module.ajax.php",
                                data: { action : "reorderWidgets", lst_ids : ListIDs }
                        });
                }
        });
        $('ul.sortable').disableSelection(); // on désactive la possibilité au navigateur de faire des sélections
    }
});    
    /*
    $('.switch-lang').on('click', function() {
        var idArt    = $(this).attr('art');
        var idLang   = $(this).attr('lang');
        var NewValue = $(this).attr('alt');
        $.ajax({
            type:"POST",
            url:"modules/sidebar/module.ajax.php",
            data: { action : "langSwitch", idart : idArt, idlang : idLang, new_value : NewValue }
        }).done(function(result) {
            $('#switch-lang-' + idArt).empty().append(result);
        });
    })
    
    //Chargement des articles par pages
    $('#select-pages').on('change', function() {
       var idPage = $(this).val();
       $('#ajax-loader').show();
       $.ajax({
            type:"POST",
            url:"modules/sidebar/module.ajax.php",
            data: { action : "getArtByPage", idpage : idPage }
        }).done(function() {
            location.href = 'dashboard.php?module=articles';
        });
    });
    
    //Définition de la variable de session pour la lange
    $('#select-id-lang').on('change', function() {
        var idLang = $(this).val();
        var idArt  = $(this).attr('role');
       $.ajax({
            type:"POST",
            url:"modules/sidebar/module.ajax.php",
            data: { action : "setVarLang", idlang : idLang, idart : idArt }
        }).done(function(result) {
            if(result != '') {
                location.href = 'dashboard.php?module=articles&page=edition&gerer=articles&id_art=' + result;
            }
            else {
                location.href = 'dashboard.php?module=articles&page=creation&gerer=articles';
            }
        });
    });
    
    //Définition de la variable de session pour la page
    $('#select-id-pages').on('change', function() {
        var idPage = $(this).val();
       $.ajax({
            type:"POST",
            url:"modules/sidebar/module.ajax.php",
            data: { action : "setVarPage", idpage : idPage }
        });
    });
    
    //Drag & drop des widgets
    $('#list-widget li').draggable({
        appendTo: 'body',
        helper: 'clone'
    });
    $('#listing-widgets ol').droppable({
        activeClass: 'ui-state-default',
        hoverClass: 'ui-state-hover',
        accept: ':not(.ui-sort-helper)',
        drop: function(event, ui) {
            $(this).find('placeholder').remove();
            $('<li></li>').text(ui.draggable.text()).appendTo(this);
        }
    }).sortable({
        items:'li:not(.placeholder)',
        sort: function() {
            $(this).removeClass('ui-state-default');
        }
    });
    
    //Liste réordonable
    $('ul.sortable').sortable({
            axis: "y",
            items: "li:not(.no_drag)",
            placeholder : '.placeholder',                       // stylise le placeholder
            forcePlaceholderSize : true,                        // force le redimensionnement du placeholder
            opacity : 0.8,                                      // réduit l'opacité lors du déplacement
            update: function() {                                // callback quand l'ordre de la liste est changé
                    var ListIDs;
                    $('ul.sortable li').each(function() {
                            var id = $(this).attr('role');
                            ListIDs = ListIDs + id;
                    });
                    $.ajax({
                            type: "POST",
                            url: "modules/sidebar/module.ajax.php",
                            data: { action : "reorderWidgets", lst_ids : ListIDs }
                    });
            }
    });
    $('ul.sortable').disableSelection(); // on désactive la possibilité au navigateur de faire des sélections*/
