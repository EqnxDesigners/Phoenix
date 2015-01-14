$(document).ready(function() {
    //Sous-menu
    $('#submenu').delegate('a.button', 'click', function() {
        if(getTask($(this)) == 'open-add-media') {
            $('#add-media').slideDown('fast');
        }
    });
    
    //Action dans la liste des médias
    $('#lst-medias').delegate('.media-choose', 'click', function() {
        //Code
        console.log('image sélectionnée ' + getIdElem($(this)));
    });
    
    
    
    
    
    
    
    
    
    
    
    
    
    
    function getTask(t) {
        return $(t).attr('role');
    }
    
    function getIdElem(i) {
        return $(i).attr('alt');
    }
    
    function getMediaDetails(i) {
        $.ajax({
            type:"POST",
            url:"modules/medias/module.ajax.php",
            data: { action : "getMediaDetails", id_elem : i }
        }).success(function(result) {
            $('#media-details').empty().append(result);

        });
    }
    
    
    
    
    
    //Suppression d'un sous-media
    $('#lst-sub-medias').delegate('.sub-tool', 'click', function() {
        var BtonAction = $(this).attr('role');
        
        //Suppression d'un sous-média
        if(BtonAction == 'del-sub-media') {
            var Id = $(this).attr('alt');          
            $.ajax({
                type:"POST",
                url:"modules/medias/module.ajax.php",
                data: { action : "delSubMedia", id : Id }
            }).success(function(result) {
                $('#lst-sub-medias').empty().append(result);
                
            });
        }
        
        //Ouverture des del-box
        if(BtonAction == 'open-del-sub-box') {
            $('.pop-box').slideUp('fast');
            var Id = $(this).attr('alt');
            $('#del-sub_' + Id).slideDown('fast');
        }
        
        //Fermeture des del-box
        if(BtonAction == 'close_pop_box') {
            $('.pop-box').slideUp('fast');
        }
    });
    
    $('#list-formats-content').delegate('.sub-tool', 'click', function() {
        var BtonAction = $(this).attr('role');
        
        //del format prédéfinit
        if(BtonAction == 'del_format') {
            var Id = $(this).attr('alt');
            $.ajax({
                type:"POST",
                url:"modules/medias/module.ajax.php",
                data: { action : "delFormat", id : Id }
            }).success(function(result) {
                $('#list-formats-content').empty().append(result);
                //location.href = 'dashboard.php?module=medias';
            });
        }
    });
    
    $('#lst-slideshows').delegate('.sub-tool', 'click', function() {
        var BtonAction = $(this).attr('role');
        
        //Overture de l'ajout d'un slideshow
        if(BtonAction == 'open-del-slide') {
            var Id = $(this).attr('alt');
            $('.pop-box').slideUp('fast');
            $('#del-slide_' + Id).slideDown('fast');
        }
        
        //Overture de l'ajout de format
        if(BtonAction == 'del-slide') {
            var Id = $(this).attr('alt');
            $.ajax({
                type:"POST",
                url:"modules/medias/module.ajax.php",
                data: { action : "delSlideShow", id : Id }
            }).success(function(result) {
                $('#lst-slideshows').empty().append(result);
                //location.href = 'dashboard.php?module=medias';
            });
        }
        
        //Sélection d'un slide pour édition
        if(BtonAction == 'select-slide') {
            var Id = $(this).attr('alt');
            $('#lst-slideshows').find('li').css({'background' : '#d0d0d0'});
            $(this).parents('li').css({'background' : '#b0ffb6'});
            $.ajax({
                type:"POST",
                url:"modules/medias/module.ajax.php",
                data: { action : "showLstImgs" }
            }).success(function(result) {
                $('#lst-imgs-dispo').empty().append(result);
                $('#lst-imgs-dispo').find('.sub-tool').each(function() {
                    $(this).attr('rel',Id);
                });
            });
            $.ajax({
                type:"POST",
                url:"modules/medias/module.ajax.php",
                data: { action : "showSelectedSlide", id : Id }
            }).success(function(result) {
                $('#lst-imgs-in-slide').empty().append(result);
                reorderWidgets();
            });
        }
    });
    
    $('#lst-imgs-dispo').delegate('.sub-tool', 'click', function() {
        var BtonAction = $(this).attr('role');
        
        if(BtonAction == 'add-pic-to-slide') {
            var IdImage = $(this).attr('alt');
            var IdSlide = $(this).attr('rel');
            $.ajax({
                type:"POST",
                url:"modules/medias/module.ajax.php",
                data: { action : "addImgToSlide", id_image : IdImage, id_slide : IdSlide }
            }).success(function(result) {
                $('#lst-imgs-in-slide').empty().append(result);
                reorderWidgets();
            });
        }
    });
    
    $('#lst-imgs-in-slide').delegate('.sub-tool', 'click', function() {
        var BtonAction = $(this).attr('role');
        
        if(BtonAction == 'remove-pic-from-slide') {
            var IdImage = $(this).attr('alt');
            var IdSlide = $(this).attr('rel');
            $.ajax({
                type:"POST",
                url:"modules/medias/module.ajax.php",
                data: { action : "removeImgFromSlide", id_image : IdImage, id_slide : IdSlide }
            }).success(function(result) {
                $('#lst-imgs-in-slide').empty().append(result);
                reorderWidgets();
            });
        }
        
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

        //Affichage des options d'un vidéo
        if(BtonAction == 'open-vid-options') {
            //Fermeture des options
            $('.pop-box').hide();

            var regex = /^http\:\/\/youtu\.be\/.*$/,
            is_url = regex.test($('#media-url').val());

            if(is_url) {
                var VidUrl = $('#media-url').val();
                $.ajax({
                    type:"POST",
                    url:"modules/medias/module.ajax.php",
                    data: { action : "getVidsInfos", url : VidUrl }
                }).done(function(result) {
                    //Renseignement du type de média
                    $('#type-media').val('2');

                    //Affichage des options
                    addVidOptions(result, VidUrl);
                });
            }
            else {
                $('#alert-box').empty().append('URL incorrecte...').slideDown('fast');
            }
        }
        e.preventDefault;
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
                                url: "modules/medias/module.ajax.php",
                                data: { action : "reorderImgs", lst_ids : ListIDs }
                        });
                }
        });
        $('ul.sortable').disableSelection(); // on désactive la possibilité au navigateur de faire des sélections
    }
    
    //Affichage des médias par type
    $('#media-selector').on('change', function() {
        var typeMedia = $(this).val();
        $.ajax({
            type:"POST",
            url:"modules/medias/module.ajax.php",
            data: { action : "getMediasByType", type : typeMedia }
        }).done(function(result) {
            //Renseignement du type de média
            $('#lst-all-medias').empty().append(result);
        });
    });

    //Master switch
    $('.master-switch').on('click', function() {
        var Id          = $(this).attr('id');
        var NewValue    = $(this).attr('alt');
        var Element     = $(this).attr('role');
        $.ajax({
            type:"POST",
            url:"modules/medias/module.ajax.php",
            data: { action : "masterSwitch", id : Id, new_value : NewValue, element : Element }
        }).done(function(result) {
            $('#' + Element + '_' + Id).empty().append(result);
        });
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