$(document).ready(function() {
    //Boutons de l'interface
    $('#listing-articles').delegate('.sub-tool', 'click', function() {
        var ToDO = $(this).attr('role');
        
        if(ToDO == 'open_del_box') {
            var Id = $(this).attr('alt');
            $('.pop-box').slideUp('fast');
            $('#del_' + Id).slideDown('fast');
	}
        
        //Supprimer un article
        if(ToDO == 'del-article') {
            var Id = $(this).attr('alt');    
            $.ajax({
                type:"POST",
                url:"modules/articles/module.ajax.php",
                data: { action : "delArticle", id : Id }
            }).done(function(result) {
                //$('#listing-articles').empty().append(result);
                location.href = 'dashboard.php?module=articles';
            });
        }        
    });
    
    //Nouvel article
    $('a#new-article').on('click', function() {
        console.log('Nouvel article');
        $.ajax({
            type:"POST",
            url:"modules/articles/module.ajax.php",
            data: { action : "resetArticle" }
        }).done(function() {
            location.href = 'dashboard.php?module=articles&page=creation&gerer=articles';
        });
    });

    $('.master-switch').on('click', function() {
        var Id          = $(this).attr('id');
        var NewValue    = $(this).attr('alt');
        var Element     = $(this).attr('role');
        $.ajax({
            type:"POST",
            url:"modules/articles/module.ajax.php",
            data: { action : "masterSwitch", id : Id, new_value : NewValue, element : Element }
        }).done(function(result) {
            $('#' + Element + '_' + Id).empty().append(result);
        });
    });
    
    $('#listing-articles').delegate('.switch-lang', 'click', function() {
        var idArt    = $(this).attr('art');
        var idLang   = $(this).attr('lang');
        var NewValue = $(this).attr('alt');
        $.ajax({
            type:"POST",
            url:"modules/articles/module.ajax.php",
            data: { action : "langSwitch", idart : idArt, idlang : idLang, new_value : NewValue }
        }).done(function(result) {
            $('#switch-lang-' + idArt).empty().append(result);
        });
    });
    
    //Filter les pages par catégories
    $('#select-cat').on('change', function() {
        var Id = $(this).val();
        $('#ajax-loader').show();
        $.ajax({
            type:"POST",
            url:"modules/articles/module.ajax.php",
            data: { action : "filterPages", id : Id }
        }).done(function(result) {
            $('#select-pages-content').empty().append(result);
            $('#ajax-loader').hide();
        });
    });
    
    //Masque du sélecteur de pages
    $('#select-pages').hide();
    
    //Chargement des articles par pages
    $('#select-pages-content').on('change', '#select-pages', function() {
       var idPage = $(this).val();
       if(idPage == 'allbycat') {
           var idCat = $('#select-cat').val();
       }
       else {
           var idCat = 'all';
       }
       $('#ajax-loader').show();
       $.ajax({
            type:"POST",
            url:"modules/articles/module.ajax.php",
            data: { action : "getArtByPage", idpage : idPage, idcat : idCat }
        }).done(function(result) {
            //location.href = 'dashboard.php?module=articles';
            $('#listing-articles').empty().append(result);
            $('#ajax-loader').hide();
            reorderWidgets();
        });
    });
    
    //Définition de la variable de session pour la lange
    $('#select-id-lang').on('change', function() {
        var idLang = $(this).val();
        var idArt  = $(this).attr('role');
       $.ajax({
            type:"POST",
            url:"modules/articles/module.ajax.php",
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
            url:"modules/articles/module.ajax.php",
            data: { action : "setVarPage", idpage : idPage }
        });
    });
    
    //Liste réordonable
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
                                url: "modules/articles/module.ajax.php",
                                data: { action : "reorderArticles", lst_ids : ListIDs }
                        });
                }
        });
        $('ul.sortable').disableSelection(); // on désactive la possibilité au navigateur de faire des sélections
    }
    
    $('#lst_all_medias').delegate('#modalPreviewButton', 'click', function() {
        console.log('Preview');
        $("#modalPreview").reveal();
    });
    /*
    $("#modalPreviewButton").on('click',function() {
        console.log('Preview');
        $("#modalPreview").reveal();
    });
    */
});

/***** TINY MCE *****/
tinymce.init({
    selector: "textarea#create-article",
    theme: "modern",
    plugins: [
         "addmediaimgs addmediadocs addmediavids advlist autolink link lists charmap print preview hr anchor pagebreak spellchecker",
         "searchreplace wordcount visualblocks visualchars insertdatetime nonbreaking",
         "save table contextmenu directionality template paste textcolor"
   ],
   content_css: "../css/foundation.min.css, ./css/tinymce.display.css",
   toolbar: "insertfile undo redo | styleselect | bold italic | alignleft aligncenter alignright alignjustify | bullist numlist outdent indent | forecolor backcolor | template image code media", 
   style_formats: [
        {title: 'H3', block: 'h3'},
        {title: 'H4', block: 'h4'},
        {title: 'Légende', inline: 'em', styles: {color: '#6b6b6b'}}
    ],
    templates: [ 
        {title: '1 colonnes fluides', description: 'Block-grid', url: 'templates/templates.php?type=fluide&col=1'},
        {title: '2 colonnes fluides', description: 'Block-grid', url: 'templates/templates.php?type=fluide&col=2'},
        {title: '3 colonnes fluides', description: 'Block-grid', url: 'templates/templates.php?type=fluide&col=3'},
        {title: '4 colonnes fluides', description: 'Block-grid', url: 'templates/templates.php?type=fluide&col=4'},
        {title: '2 colonnes (petite - grande)', description: 'Columns', url: 'templates/templates.php?type=2colonnes-pg'},
        {title: '2 colonnes (grande - petite)', description: 'Columns', url: 'templates/templates.php?type=2colonnes-gp'}
    ]
    
    /* Exemples style_formats
    {title: 'Red header', block: 'h1', styles: {color: '#ff0000'}},
    {title: 'Example 1', inline: 'span', classes: 'example1'},
    {title: 'Example 2', inline: 'span', classes: 'example2'},
    {title: 'Table styles'},
    {title: 'Table row 1', selector: 'tr', classes: 'tablerow1'}
    */
 }); 