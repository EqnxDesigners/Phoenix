$(document).ready(function() {
    //------ Formulaire d'édition d'une catégorie -------------------------------------
    /*$('#edit-form').on('click', 'input[type="submit"]', function() {
        $.post(urlAjax, {a: 'update', module: 'categories', data: $('#form_edit').serializeArray() })
            .done(function(result) {
                $('#listing').empty().append(result);
                $('#edit-form').hide();
                applyDeployement();
        });
    });*/
    
    //------ Mise en page -------------------------------------
    $(".library").css({"min-height":$(window).height()-40});
    
    //------ Interactions -------------------------------------
    $('#listing').on('click', '.indicator', function() {
        if($(this).hasClass('active')) {
            $(this).removeClass('active');
        }
        else {
            $(this).addClass('active');
            $.post(urlAjax, {a: 'addtoeditstack', module: 'medias', id: $(this).attr('iditem') })
                .done(function(result) {
                    $('#edit-medias').empty().append(result);
            });
        }
    });
    
    $('#edit-medias').on('click', '.glyphicon', function() {
        if($(this).hasClass('glyphicon-minus')) {
            id = $(this).attr('iditem');
            $.post(urlAjax, {a: 'removefromeditstack', module: 'medias', id: id })
                .done(function(result) {
                    $('#edit-medias').empty().append(result);
                    $('.indicator').each(function() {
                        if($(this).attr('iditem') == id) {
                            $(this).removeClass('active');
                        }
                    });
            });
        }
        
        if($(this).hasClass('glyphicon-zoom-in')) {
            window.location.href = '../medias/' + $(this).attr('nameitem');
        }
    });
    
    $('#edit-medias').on('click', 'a.clear-stack', function() {
        $.post(urlAjax, {a: 'cleareditstack' })
            .done(function() {
                $('#edit-medias').empty();
                $('.indicator').removeClass('active');
            });
    });
    
    //------ Upload de fichiers -------------------------------------
    // variables
    var dropArea = document.getElementById('dropArea');
    var canvas = document.querySelector('canvas');
    var context = canvas.getContext('2d');
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
            context.clearRect(0, 0, canvas.width, canvas.height); // effacer le canvas

            context.beginPath();
            context.strokeStyle = '#4B9500';
            context.fillStyle = '#4B9500';
            context.fillRect(0, 0, progress * 500, 20);
            context.closePath();

            // affichage de la progression (mode texte)
            context.font = '16px Verdana';
            context.fillStyle = '#000';
            context.fillText('Progression : ' + Math.floor(progress*100) + ' %', 50, 15);
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

            for (var i = 0; i < filelist.length && i < 10; i++) {
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
        }

        // transfert du fichier suivant
        function uploadNext() {
            if (list.length) {
                count.textContent = list.length - 1;
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