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
    });
    
    //----- Editeur ---------------------------------------
    $('#wrapper-adding').on('change', 'select', function() {
        console.log($(this).val());
        ($(this).val() !== 'xxx' ? $('#file-uploader').slideDown('fast') : $('#file-uploader').slideUp('fast'));
    });
    
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