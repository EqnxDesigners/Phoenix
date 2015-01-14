$(document).ready(function() {
    //Gestion des catégories
    $('#lst_all_cats').delegate('.tool', 'click', function() {
        var BtonAction = $(this).attr('role');

        //Suppression d'une catégorie
        if (BtonAction == 'del-cat') {
            var Id = $(this).attr('alt');
            $.ajax({
                type: "POST",
                url: "modules/default/module.ajax.php",
                data: {action: "delCat", id: Id}
            }).done(function(result) {
                $('#lst_all_cats').empty().append(result);
            });
        }
        
        // Edition
        if (BtonAction == 'open_edit_box') {
            var Id = $(this).attr('alt');
            $('.pop-box').slideUp('fast');
            $('#edit_' + Id).slideDown('fast');
        }

        if (BtonAction == 'open_del_box') {
            var Id = $(this).attr('alt');
            $('.pop-box').slideUp('fast');
            $('#del_' + Id).slideDown('fast');
        }
        
        //Ouverture de l'ajout d'une sous-categorie
        if (BtonAction == 'open-add-sub-cat') {
            var Id = $(this).attr('alt');
            $('#add_cat_' + Id).slideDown('fast');
        }

        //Ouverture de l'ajout d'une categorie
        if (BtonAction == 'open-add-cat') {
            $('#add_cat').slideDown('fast');
        }
        
        
    });

    //Gestion des pages
    $('#lst_all_pages').delegate('.tool', 'click', function() {
        var BtonAction = $(this).attr('role');
        
        //Suppression d'une page
        if (BtonAction == 'del_page') {
            var Id = $(this).attr('alt');
            $.ajax({
                type: "POST",
                url: "modules/default/module.ajax.php",
                data: {action: "delPage", id: Id}
            }).done(function(result) {
                $('#lst_all_pages').empty().append(result);
            });
        }
        
        
        // Suppression
        if (BtonAction == 'open_del_box') {
            var Id = $(this).attr('alt');
            $('.pop-box').slideUp('fast');
            $('#del_' + Id).slideDown('fast');
        }
        // Edition
        if (BtonAction == 'open_edit_box') {
            var Id = $(this).attr('alt');
            $('.pop-box').slideUp('fast');
            $('#edit_' + Id).slideDown('fast');
        }
        // Close pop-box
        if (BtonAction == 'close_pop_box') {
            $('.pop-box').slideUp('fast');
        }
    });

    //Gestion du menu principal
    $('#lst_all_menus').delegate('.tool', 'click', function() {
        var BtonAction = $(this).attr('role');
        
        //Suppression d'une langue
        if (BtonAction == 'del-mainmenu') {
            var Id = $(this).attr('alt');
            $.ajax({
                type: "POST",
                url: "modules/default/module.ajax.php",
                data: {action: "delMenu", id: Id}
            }).done(function(result) {
                $('#lst_all_menus').empty().append(result);
            });
        }
       
        // Suppression
        if (BtonAction == 'open_del_box') {
            var Id = $(this).attr('alt');
            $('.pop-box').slideUp('fast');
            $('#del_' + Id).slideDown('fast');
        }
        // Edition
        if (BtonAction == 'open_edit_box') {
            var Id = $(this).attr('alt');
            $('.pop-box').slideUp('fast');
            $('#edit_' + Id).slideDown('fast');
        }
        // Close pop-box
        if (BtonAction == 'close_pop_box') {
            $('.pop-box').slideUp('fast');
        }
        
        //Ouverture de l'ajout d'un menu
        if (BtonAction == 'open-add-menu') {
            $('#add_menu').slideDown('fast');
        }
        
        //Ouverture de l'ajout d'un sous-menu
        if (BtonAction == 'open-add-sub-menu') {
            var Id = $(this).attr('alt');
            $('#add_sub_' + Id).slideDown('fast');
        }
        
        //Ouverture de l'ajout d'un sous-menu
        if (BtonAction == 'open_link_box') {
            var Id = $(this).attr('alt');
            $('#link_' + Id).slideDown('fast');
        }
    });

    //Gestion des langues
    $('#lst_all_langues').delegate('.tool', 'click', function() {
        var BtonAction = $(this).attr('role');

        //Suppression d'un menu
        if (BtonAction == 'del-langue') {
            var Id = $(this).attr('alt');
            $.ajax({
                type: "POST",
                url: "modules/default/module.ajax.php",
                data: {action: "delLang", id: Id}
            }).done(function(result) {
                $('#lst_all_langues').empty().append(result);
            });
        }
        

        if (BtonAction == 'open_del_box') {
            var Id = $(this).attr('alt');
            $('.pop-box').slideUp('fast');
            $('#del_' + Id).slideDown('fast');
        }
        
        //Ouverture de l'ajout d'une langue
        if (BtonAction == 'open-add-lang') {
            $('#add_lang').slideDown('fast');
        }
    });

    //Gestion des utilisateurs
    $('#lst_all_users').delegate('.tool', 'click', function() {
        var BtonAction = $(this).attr('role');

        //Suppression d'un user
        if (BtonAction == 'del-user') {
            var Id = $(this).attr('alt');
            $.ajax({
                type: "POST",
                url: "modules/default/module.ajax.php",
                data: {action: "delUser", id: Id}
            }).done(function(result) {
                $('#lst_all_users').empty().append(result);
            });
        }

        if (BtonAction == 'open_del_box') {
            var Id = $(this).attr('alt');
            $('.pop-box').slideUp('fast');
            $('#del_' + Id).slideDown('fast');
        }
        
        //Ouverture de l'ajout d'un user
        if (BtonAction == 'open-add-user') {
            $('#add_user').slideDown('fast');
        }
    });

    //Boutons de l'interface
    $('.tool').on('click', function() {
        var ToDO = $(this).attr('role');

        //Suppression d'une page
        /*if (ToDO == 'del_page') {
            var Id = $(this).attr('alt');
            $.ajax({
                type: "POST",
                url: "modules/default/module.ajax.php",
                data: {action: "delPage", id: Id}
            }).done(function(result) {
                $('#lst_all_pages').empty().append(result);
            });
        }*/

        //Suppression d'un menu
        /*if (ToDO == 'del-langue') {
            var Id = $(this).attr('alt');
            $.ajax({
                type: "POST",
                url: "modules/default/module.ajax.php",
                data: {action: "delLang", id: Id}
            }).done(function(result) {
                $('#lst_all_langues').empty().append(result);
            });
        }*/

        //Suppression d'une langue
        /*if (ToDO == 'del-mainmenu') {
            var Id = $(this).attr('alt');
            $.ajax({
                type: "POST",
                url: "modules/default/module.ajax.php",
                data: {action: "delMenu", id: Id}
            }).done(function(result) {
                $('#lst_all_menus').empty().append(result);
            });
        }*/

        //Suppression d'un user
        /*if (ToDO == 'del-user') {
            var Id = $(this).attr('alt');
            $.ajax({
                type: "POST",
                url: "modules/default/module.ajax.php",
                data: {action: "delUser", id: Id}
            }).done(function(result) {
                $('#lst_all_users').empty().append(result);
            });
        }*/

       

        //Ouverture de l'ajout d'un menu
        /*if (ToDO == 'open-add-menu') {
            $('#add_menu').slideDown('fast');
        }*/

        //Ouverture de l'ajout d'une langue
        /*if (ToDO == 'open-add-lang') {
            $('#add_lang').slideDown('fast');
        }*/

        //Ouverture de l'ajout d'un user
        /*if (ToDO == 'open-add-user') {
            $('#add_user').slideDown('fast');
        }*/

        //Ouverture de l'ajout d'un sous-menu
        /*if (ToDO == 'open-add-sub-menu') {
            var Id = $(this).attr('alt');
            $('#add_sub_' + Id).slideDown('fast');
        }*/

        //Ouverture de l'ajout d'un sous-menu
        /*if (ToDO == 'open_link_box') {
            var Id = $(this).attr('alt');
            $('#link_' + Id).slideDown('fast');
        }*/
    });

    $('#liste').on('click','.master-switch', function() {
        var Id = $(this).attr('id');
        var NewValue = $(this).attr('alt');
        var Element = $(this).attr('role');
        $.ajax({
            type: "POST",
            url: "modules/default/module.ajax.php",
            data: {action: "masterSwitch", id: Id, new_value: NewValue, element: Element}
        }).done(function(result) {
            $('#' + Element + '_' + Id).empty().append(result);
        });
    });

    //Affichage des pages par catégorie
    $('#sort-by-cat').on('click', function() {
        var Id = $(this).val();
        $.ajax({
            type: "POST",
            url: "modules/default/module.ajax.php",
            data: {action: "sortPageByCat", id: Id}
        }).done(function(result) {
            $('#lst_all_pages').empty().append(result);
        });
    });

    //Changement de valeur d'un option
    $('input.field-option-value').on('change', function() {
        var idOption = $(this).attr('alt');
        var NewValue = $(this).val();
        $.ajax({
            type: "POST",
            url: "modules/default/module.ajax.php",
            data: {action: "changeOptionValue", idoption: idOption, newvalue: NewValue}
        }).done(function() {
            $('input#option-' + Id).val(NewValue);
        });
    });

    //Préformatage de l'URL d'un lien
    $('input.field_menu_name').on('change', function() {
        var Lang = $(this).attr('alt');
        var MnuName = $(this).val();
        $.ajax({
            type: "POST",
            url: "modules/default/module.ajax.php",
            data: {action: "formatMnuUrl", mnuname: MnuName}
        }).done(function(result) {
            $('input#url_' + Lang).val(result);
        });
    });

    //Liste réordonable
    $('ul.sortable').sortable({
        axis: "y",
        items: "li:not(.no_drag)",
        placeholder: '.placeholder', // stylise le placeholder
        forcePlaceholderSize: true, // force le redimensionnement du placeholder
        opacity: 0.8, // réduit l'opacité lors du déplacement
        update: function() {                                // callback quand l'ordre de la liste est changé
            var ListIDs;
            var IdMenuParent = $(this).attr('alt');
            $('ul.sortable li').each(function() {
                var id = $(this).attr('role');
                ListIDs = ListIDs + id;
            });
            $.ajax({
                type: "POST",
                url: "modules/default/module.ajax.php",
                data: {action: "reorderMenu", lst_ids: ListIDs, id_parent: IdMenuParent}
            }).done(function() {
                location.href = 'dashboard.php?module=default&page=gestion&gerer=mainmenu';
                //$('#lst_all_menus').empty().append(result);
                //$('ul.sortable').each(function() {
                //    $(this).addClass('ui-sortable');
                //});
                //$('ul.sortable').disableSelection(); // on désactive la possibilité au navigateur de faire des sélections
            });
        }
    });
    $('ul.sortable').disableSelection(); // on désactive la possibilité au navigateur de faire des sélections
});