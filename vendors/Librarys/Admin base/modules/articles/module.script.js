$(document).ready(function() {
    //------ Création d'un article -------------------------------------
    rowId = 0;
    
    function addDomItem(id) {
        var result = '<div class="add-dom-item" id="box-dom-'+id+'"><div class="btn btn-default btn-xs"><span class="glyphicon glyphicon-th-large" target="'+id+'"></span></div></div>';
        return result;
    }
    
    function addLstCol(id) {
        var result = '<div class="add-col" id="box-col-'+id+'"><div class="btn btn-default btn-xs add-col" nbcol="1" target="'+id+'">1</div><div class="btn btn-default btn-xs add-col" nbcol="2" target="'+id+'">2</div><div class="btn btn-default btn-xs add-col" nbcol="3" target="'+id+'">3</div><div class="btn btn-default btn-xs add-col" nbcol="4" target="'+id+'">4</div>|<div class="btn btn-default btn-xs add-col" nbcol="8-4" target="'+id+'">8-4</div><div class="btn btn-default btn-xs add-col" nbcol="4-8" target="'+id+'">4-8</div><div class="btn btn-default btn-xs add-col" nbcol="9-3" target="'+id+'">9-3</div><div class="btn btn-default btn-xs add-col" nbcol="3-9" target="'+id+'">3-9</div></div>';
        return result;
    }
    
    function addAllType(idrow, idcol) {
        var result = '<div class="add-item" id="box-item-'+idrow+'"><div class="btn btn-default btn-xs"><span class="glyphicon glyphicon-bold" trow="'+idrow+'" tcol="'+idcol+'"></span></div><div class="btn btn-default btn-xs"><span class="glyphicon glyphicon-picture" trow="'+idrow+'" tcol="'+idcol+'"></span></div></div>';
        return result;
    }
    
    function initTinyMCE() {
        tinymce.init({selector:'textarea'});
    }
    
    $('#art-editor').on('click', '.glyphicon', function() {
        if($(this).hasClass('glyphicon-plus')) {
            $('#new-art-content').append('<div class="row build" id="row'+rowId+'">' + addDomItem(rowId) + '</div>');
            rowId++;
        }
        if($(this).hasClass('glyphicon-th-large')) {
            var targetId = $(this).attr('target');
            $('#box-dom-' + targetId).remove();
            $('#row' + targetId).append(addLstCol(targetId));
        }
        if($(this).hasClass('glyphicon-bold')) {
            var idrow = $(this).attr('trow');
            var idcol = $(this).attr('tcol');
            $('#col-' + idrow + '-' + idcol).empty().append('<textarea name="txt-'+idrow+'-'+idcol+'" id="txt-'+idrow+'-'+idcol+'"></textarea>');
            initTinyMCE();
        }
        if($(this).hasClass('glyphicon-picture')) {
            $('#medias-box').fadeIn('fast');
            $.post(urlAjax, {a: 'bulidLstMedias', trow: $(this).attr('trow'), tcol: $(this).attr('tcol') })
                .done(function(result) {
                    $('#medias-box').empty().append(result);
                    $('#box-title').empty().append('Bibliothèque');
            });
        }
    });
    
    $('#medias-box').on('click', 'img', function() {
        var idrow = $(this).attr('trow');
        var idcol = $(this).attr('tcol');
        var fname = $(this).attr('fname');
        $('#col-' + idrow + '-' + idcol).empty().append('<img src="../medias/' + fname +'" class="img-preview">');
        $('#medias-box').fadeOut('fast');
        $('#box-title').empty().append('Publier');
    });
    
    $('#medias-box').on('click', '.glyphicon-remove-circle', function() {
        $('#medias-box').fadeOut('fast');
        $('#box-title').empty().append('Publier');
    });
    
    $('#art-editor').on('click', '.add-col', function() {
        var nbCol = $(this).attr('nbcol');
        var targetId = $(this).attr('target');
        if(nbCol == '1') {
            $('#row' + targetId).empty().append('<div class="col-xs-12 build" id="col-'+targetId+'-0">' + addAllType(targetId, '0') + '</div>');
        }
        if(nbCol == '2') {
            $('#row' + targetId).empty();
            for(i=0;i<nbCol;i++) {
                $('#row' + targetId).append('<div class="col-xs-6 build" id="col-'+targetId+'-'+i+'">' + addAllType(targetId, i) + '</div>');
            }
        }
        if(nbCol == '3') {
            $('#row' + targetId).empty();
            for(i=0;i<nbCol;i++) {
                $('#row' + targetId).append('<div class="col-xs-4 build" id="col-'+targetId+'-'+i+'">' + addAllType(targetId, i) + '</div>');
            }
        }
        if(nbCol == '4') {
            $('#row' + targetId).empty();
            for(i=0;i<nbCol;i++) {
                $('#row' + targetId).append('<div class="col-xs-3 build" id="col-'+targetId+'-'+i+'">' + addAllType(targetId, i) + '</div>');
            }
        }
        if(nbCol == '8-4') {
            $('#row' + targetId).empty();
            $('#row' + targetId).append('<div class="col-xs-8 build" id="col-'+targetId+'-0">' + addAllType(targetId, '0') + '</div>');
            $('#row' + targetId).append('<div class="col-xs-4 build" id="col-'+targetId+'-1">' + addAllType(targetId, '1') + '</div>');
        }
        if(nbCol == '4-8') {
            $('#row' + targetId).empty();
            $('#row' + targetId).append('<div class="col-xs-4 build" id="col-'+targetId+'-0">' + addAllType(targetId, '0') + '</div>');
            $('#row' + targetId).append('<div class="col-xs-8 build" id="col-'+targetId+'-1">' + addAllType(targetId, '1') + '</div>');
        }
        if(nbCol == '9-3') {
            $('#row' + targetId).empty();
            $('#row' + targetId).append('<div class="col-xs-9 build" id="col-'+targetId+'-0">' + addAllType(targetId, '0') + '</div>');
            $('#row' + targetId).append('<div class="col-xs-3 build" id="col-'+targetId+'-1">' + addAllType(targetId, '1') + '</div>');
        }
        if(nbCol == '3-9') {
            $('#row' + targetId).empty();
            $('#row' + targetId).append('<div class="col-xs-3 build" id="col-'+targetId+'-0">' + addAllType(targetId, '0') + '</div>');
            $('#row' + targetId).append('<div class="col-xs-9 build" id="col-'+targetId+'-1">' + addAllType(targetId, '1') + '</div>');
        }
    });
});