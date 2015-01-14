$(document).ready(function() {
    $('#linked-imgs').delegate('.sub-tool', 'click', function(e) {
        var LinkTo = $(this).attr('linkto');          
        $.ajax({
            type:"POST",
            url:"modules/news/module.ajax.php",
            data: { action : "showLstMedia", linkto : LinkTo }
        }).success(function(result) {
            $('#lst-medias-images').empty().append(result);
        });
        e.preventDefault;
    });
    
    $('#lst-medias-images').delegate('.sub-tool', 'click', function(e) {          
        //if($(this).attr('linkto') == '1') {
            $('#img-slide').val($(this).attr('idmedia'));
            $('#slide-vignette').attr('src', $(this).parents('li').find('img').attr('src'));
        /*}
        else {
            $('#img-news').val($(this).attr('idmedia'));
            $('#news-vignette').attr('src', $(this).parents('li').find('img').attr('src'));
        }*/
        e.preventDefault;
    });
    
    $('#lst-news').delegate('.sub-tool', 'click', function(e) {
        var BtonAction = $(this).attr('role');
        
        if(BtonAction == 'open-del-box') {
            var Id = $(this).attr('alt');
            $('#del_' + Id).slideDown('fast');
        }
        
        if(BtonAction == 'del-news') {
            var Id = $(this).attr('alt');
            $.ajax({
                type:"POST",
                url:"modules/news/module.ajax.php",
                data: { action : "delNews", id : Id }
            }).done(function(result) {
                $('#lst-news').empty().append(result);
            });
        }
        e.preventDefault;
    });
    
    //Master switch
    $('#lst-news').delegate('.master-switch', 'click', function(e) {
        var Id          = $(this).attr('id');
        var NewValue    = $(this).attr('alt');
        var Element     = $(this).attr('role');
        $.ajax({
            type:"POST",
            url:"modules/news/module.ajax.php",
            data: { action : "masterSwitch", id : Id, new_value : NewValue, element : Element }
        }).done(function(result) {
            $('#' + Element + '_' + Id).empty().append(result);
        });
        e.preventDefault;
    });
    
    
    
    
    
    
    
    
    
    
    
    
    
    
    
    
    
    
    
    
    
    
    
    
    
    
    
    
    
    
    //Gestion des médias
    $('.sub-tool').on('click', function(e) {
        var BtonAction = $(this).attr('role');

        //Overture de l'ajout de format
        if(BtonAction == 'open-add-format') {
            $('#add-format').slideDown('fast');
        }

        //Ouverture de la création d'un slideshow
        if(BtonAction == 'open-add-slide') {            
            $('#add-slideshow').slideDown('fast');
        }
        
        //Ouverture des del-box
        if(BtonAction == 'open-del-box') {
            $('.pop-box').slideUp('fast');
            var Id = $(this).attr('alt');
            $('#del_' + Id).slideDown('fast');
        }
        
        //Suppression d'un média
        if(BtonAction == 'del-media') {
            var Id = $(this).attr('alt');
            var Type = $(this).attr('rel');
            $.ajax({
                type:"POST",
                url:"modules/medias/module.ajax.php",
                data: { action : "delMedia", id : Id, type : Type }
            }).success(function(result) {
                //$('#lst-all-medias').empty().append(result);
                //$('#lst-sub-medias').empty();
                location.href = 'dashboard.php?module=medias';
            });
        }
        
        //Affichage des détails d'un média
        if(BtonAction == 'view-adds') {  
            var Id = $(this).attr('alt');
            $.ajax({
                type:"POST",
                url:"modules/medias/module.ajax.php",
                data: { action : "getSubMedia", id : Id }
            }).done(function(result) {
                $('#lst-sub-medias').empty().append(result);
                $.ajax({
                    type:"POST",
                    url:"modules/medias/module.ajax.php",
                    data: { action : "getMediaInfo", id : Id }
                }).done(function(result) {
                    var Values = result.split("#");
                    $('#id-selected-media').val(Id);
                    $('#img-titre').val(Values[0]);
                    $('#img-alt').val(Values[1]);
                    $('#img-legende').val(Values[2]);
                    $('#lst-options-medias').show();
                });                
            });
        }
        e.preventDefault;
    });
    
    

    //Upload de médias
    $('#media-file').on('change', function() {
        //Récupération du nom du fichier et de l'extension
        var fileName = getFileName($(this).val());
        var fileExt  = getExtension(fileName).toLowerCase();

        //Fermeture des options
        $('.pop-box').hide();
        $('#vid-thumb').add('#vid-preview').empty();

        //Test si le fichier est une image ou un document
        if(isImg(fileExt)) {
            //Affichage des options
            addOptions($(this).val(), 'img');

            //Renseignement du type de média
            $('#type-media').val('1');

            //Affichage des prévisualisation
            $('#img-thumb').empty().append('<img src="' + $(this).val() + '">');
            $('#medias-preview').show();
        }
        else if(isDoc(fileExt)) {
            //Affichage des options
            addOptions($(this).val(), 'doc');

            //Renseignement du type de média
            $('#type-media').val('3');
        }
        else {
            $('#alert-box').empty().append('Type de fichier non reconnu...').slideDown('fast');
        }
    });

    //Affichage des img-dummy
    $('li.select-img-format').on('click', function() {
        if($(this).children('span').is('.checked')) {
            $('#img-thumb').empty();
        }
        else {
            var Dims = $(this).attr('role').split("x");
            $('#img-thumb').empty().append('<div class="img-dummy" style="width:'+Dims[0]+'px; height:'+Dims[1]+'px;">'+Dims[0]+'x'+Dims[1]+' px</div>');
            $('#medias-preview').show();
        }
    });

    function addOptions(filePath, fileType) {
        var altValue = getFileName(filePath);
        var titleValue = getLegende(altValue);                
        $('#' + fileType + '-alt').attr('value', altValue);
        $('#' + fileType + '-titre').attr('value', titleValue);
        $('#' + fileType + '-legende').attr('value', '...');
        $('#options-' + fileType + '-content').slideDown('fast');
    }

    function addVidOptions(values, VidUrl) {
        var Values = values.split("#"); 
        $('#vid-titre').attr('value', Values[0]);
        $('#vid-alt').attr('value', Values[0]);
        $('#vid-legende').attr('value', Values[1]);
        $('#vid-thumb').empty().append('<img src="http://i.ytimg.com/vi/' + Values[2] + '/default.jpg" />');
        $('#vid-preview').empty().append('<iframe width="560" height="315" src="http://www.youtube.com/embed/' + getVidYoutubeId(VidUrl) + '" frameborder="0" allowfullscreen></iframe>');
        $('#medias-preview').show();
        $('#options-vid-content').slideDown('fast');
    }

    function isImg(e) {
        if(e == '.jpg' || e == '.png' || e == '.gif') {
            return true;
        }
    }

    function isDoc(e) {
        if(e == '.pdf' || e == '.doc' || e == '.docx' || e == '.xls' || e == '.xlsx' || e == '.zip' || e == '.rar') {
            return true;
        }
    }

    function getFileName(str) {
        var pos = str.lastIndexOf("\\") + 1;
        return str.substring(pos, 100);
    }

    function getLegende(str) {
        var pos = str.lastIndexOf(".");
        return str.substring(0, pos);
    }

    function getExtension(str) {
        var pos = str.lastIndexOf(".");
        return str.substring(pos);
    }

    function getVidYoutubeId(str) {
        var pos = str.lastIndexOf("/");
        return str.substring(pos);
    }
});

/***** TINY MCE *****/
tinymce.init({
    selector: "textarea",
    theme: "modern",
    height : 450,
    plugins: [
         "advlist autolink link lists charmap print preview hr anchor pagebreak spellchecker",
         "searchreplace wordcount visualblocks visualchars insertdatetime nonbreaking",
         "contextmenu directionality paste "
   ],
   content_css: "../css/foundation.min.css, ./css/tinymce.display.css",
   toolbar: "bold underline italic | alignleft aligncenter alignright | bullist numlist outdent indent", 
   style_formats: [
        {title: 'H3', block: 'h3'},
        {title: 'H4', block: 'h4'},
        {title: 'Légende', inline: 'em', styles: {color: '#6b6b6b'}}
    ],
    templates: [ 
        {title: '1 colonnes fluides', description: 'Block-grid', url: 'templates/templates.php?type=fluide&col=1'},
        {title: '2 colonnes fluides', description: 'Block-grid', url: 'templates/templates.php?type=fluide&col=2'},
        {title: '3 colonnes fluides', description: 'Block-grid', url: 'templates/templates.php?type=fluide&col=3'},
        {title: '4 colonnes fluides', description: 'Block-grid', url: 'templates/templates.php?type=fluide&col=4'}
    ]
    
    /* Exemples style_formats
    {title: 'Red header', block: 'h1', styles: {color: '#ff0000'}},
    {title: 'Example 1', inline: 'span', classes: 'example1'},
    {title: 'Example 2', inline: 'span', classes: 'example2'},
    {title: 'Table styles'},
    {title: 'Table row 1', selector: 'tr', classes: 'tablerow1'}
    */
 });