$(document).ready(function() {
    //------ Variables globales ---------------------------
    urlAjaxModule = './modules/documents/ajax.php';
    
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
    
    $('.listing').on('click', '.btn', function() {
        var todo = $(this).attr('role');
        var idItem = $(this).attr('item');
        if(todo === 'media-lock') {
            $.post(urlAjaxModule, {a: 'changePrivacy', idItem: idItem, newValue: '1' })
            .done(function(result) {
                $('#wrapper-gestion').empty().append(result);
            });
        }
        if(todo === 'media-unlock') {
            $.post(urlAjaxModule, {a: 'changePrivacy', idItem: idItem, newValue: '0' })
            .done(function(result) {
                $('#wrapper-gestion').empty().append(result);
            });
        }
        if(todo === 'media-share') {
            $.post(urlAjaxModule, {a: 'loadClient', idItem: idItem })
            .done(function(result) {
                $('#Container').empty().append(result);
                initMixItUp();
                moveOverlayedPanel('17px');
            });
        }
    });
    
    $('#module-wrapper').on('click', '.fa-arrow-left', function() {
        moveOverlayedPanel('-1500px');
    });
    
    function moveOverlayedPanel(value) {
        $('.overlayed-panel').animate({'left' : value}, 'fast');
    }
    
    //----- Editeur ---------------------------------------
    $('#wrapper-adding').on('change', 'select', function() {
        ($(this).val() !== 'xxx' ? $('#file-uploader').slideDown('fast') : $('#file-uploader').slideUp('fast'));
    });
    
    //----- Mix It Up -------------------------------------
    function initMixItUp() {
        $('#Container').mixItUp();
        $('#Container').mixItUp('destroy', true);
    }
    
    $('#Container').on('click', '.row', function() {
        if($(this).is('.active')) {
            $(this).removeClass('active');
            updateLinkedState($(this).attr('data-idclient'), $(this).attr('data-idmedia'), '0');
        }
        else {
            $(this).addClass('active');
            updateLinkedState($(this).attr('data-idclient'), $(this).attr('data-idmedia'), '1');
        }
    });
    
    function updateLinkedState(idclient, idmedia, value) {
        if(value === '0') {
            $.post(urlAjaxModule, {a: 'unbindClientToMedia', idclient: idclient, idmedia: idmedia });
        }
        else {
            $.post(urlAjaxModule, {a: 'bindClientToMedia', idclient: idclient, idmedia: idmedia });
        }
    }
    
    function removeAccent(str) {
        var accent = [
            /[\300-\306]/g, /[\340-\346]/g, // A, a
            /[\310-\313]/g, /[\350-\353]/g, // E, e
            /[\314-\317]/g, /[\354-\357]/g, // I, i
            /[\322-\330]/g, /[\362-\370]/g, // O, o
            /[\331-\334]/g, /[\371-\374]/g, // U, u
            /[\321]/g, /[\361]/g, // N, n
            /[\307]/g, /[\347]/g, // C, c
        ];
        var noaccent = ['A','a','E','e','I','i','O','o','U','u','N','n','C','c'];
        
        for(var i = 0; i < accent.length; i++){
            str = str.replace(accent[i], noaccent[i]);
        }
        return str.toLowerCase();
    }
    
    $('#wrapper-sharing').on('keyup', '#search-client', function() {
        var inputText = $(this).val().toLowerCase();
        var $matching = $();
        $('#Container').mixItUp();
        
        if(inputText.length > 0) {
            $('.mix').each(function() {
                if($(this).attr('class').toLowerCase().match(removeAccent(inputText))) {
                    $matching = $matching.add(this);
                }
                else {
                    $matching = $matching.not(this);
                }
            });
            $('#Container').mixItUp('filter', $matching);
        }
        else {
            $('#Container').mixItUp('filter', 'all');
        }
    });
    
//    $(".tool-search input[type='text']").keyup(function(){
//        // Delay function invoked to make sure user stopped typing
//        delay(function(){
//            inputText = $(".tool-search input[type='text']").val().toLowerCase();
//            // Check to see if input field is empty
//            if ((inputText.length) > 0) {            
//                $('.mix').each(function() {
//                    var $this = $(this);
//                    
//                    // add item to be filtered out if input text matches items inside the title   
//                    if($this.attr('class').toLowerCase().match(inputText)) {
//                        $matching = $matching.add(this);
//                    } else {
//                        // removes any previously matched item
//                        $matching = $matching.not(this);
//                    }
//                });
//                $('.item-list ul').mixItUp('filter', $matching);
//            } else {
//                // resets the filter to show all item if input is empty
//                $('.item-list ul').mixItUp('filter', 'all');
//            }
//        }, 200 );
//    });
    
    //------ Upload de fichiers -------------------------------------
    // variables
    var dropArea = document.getElementById('dropArea');
    var count = document.getElementById('count');
    var destinationUrl = document.getElementById('url');
    var result = document.getElementById('result');
    var list = [];
    var totalSize = 0;
    var totalProgress = 0;
    
    // initialisation
    (function(){

        // gestionnaires
        function initHandlers() {
            dropArea.addEventListener('drop', handleDrop, false);
            dropArea.addEventListener('dragover', handleDragOver, false);
        }

        // affichage de la progression
        function drawProgress(progress) {
            var canvasW = Math.floor(progress*100);
            var valueProgress = '';
            
            (canvasW < 100 ? valueProgress = currentProgress + ' %' : valueProgress = 'Transfère terminée');
            
            $('#progress-bar').show().css({'width' : canvasW + '%'});
            $('#progress-bar').html(valueProgress);
            
            if(canvasW === 100) {
                // FadeOut de la bar de progression
                $('#progress-bar').delay(3000).fadeOut('fast');
            }
        }

        // survol lors du déplacement
        function handleDragOver(event) {
            event.stopPropagation();
            event.preventDefault();

            dropArea.className = 'hover';
        }

        // glisser déposer
        function handleDrop(event) {
            event.stopPropagation();
            event.preventDefault();

            processFiles(event.dataTransfer.files);
        }

        // traitement du lot de fichiers
        function processFiles(filelist) {
            if (!filelist || !filelist.length || list.length) return;

            totalSize = 0;
            totalProgress = 0;
            result.textContent = '';

            for (var i = 0; i < filelist.length && i < 1; i++) {
                list.push(filelist[i]);
                totalSize += filelist[i].size;
            }
            uploadNext();
        }

        // à la fin, traiter le fichier suivant
        function handleComplete(size) {
            totalProgress += size;
            drawProgress(totalProgress / totalSize);
            uploadNext();
        }

        // mise à jour de la progression
        function handleProgress(event) {
            var progress = totalProgress + event.loaded;
            drawProgress(progress / totalSize);
        }

        // transfert du fichier
        function uploadFile(file, status) {
            // création de l'objet XMLHttpRequest
            var xhr = new XMLHttpRequest();
            xhr.open('POST', destinationUrl.value);
            xhr.onload = function() {
                result.innerHTML += this.responseText;
                handleComplete(file.size);
            };
            xhr.onerror = function() {
                result.textContent = this.responseText;
                handleComplete(file.size);
            };
            xhr.upload.onprogress = function(event) {
                handleProgress(event);
            }
            xhr.upload.onloadstart = function(event) {
            }

            // création de l'objet FormData
            var formData = new FormData();
            formData.append('myfile', file);
            xhr.send(formData);
            
            $('input[name="file_name"]').val(file.name);
        }

        // transfert du fichier suivant
        function uploadNext() {
            if (list.length) {
                //count.textContent = list.length - 1;
                dropArea.className = 'uploading';

                var nextFile = list.shift();
                if (nextFile.size >= 20971520) { // 256 kb 262144
                    result.innerHTML += '<div class="f">Fichier trop gros (dépassement de la taille maximale)</div>';
                    handleComplete(nextFile.size);
                } else {
                    uploadFile(nextFile, status);
                }
            } else {
                dropArea.className = '';
            }
        }

        initHandlers();
    })();
});