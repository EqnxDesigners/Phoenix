/*global $, WOW, google, Hammer, jQuery*/
$(document).ready(function () {
    "use strict";

    //----- Scrolling main menu -----------------------------
    $('nav').on('click', 'li', function () {
        var target = '#' + $(this).attr('target');
        $("html, body").animate({scrollTop: $(target).offset().top - 60}, 500);
    });

    function getRandomNumber(max) {
        return Math.floor((Math.random() * max) + 1);
    }
    
    function getTheIds(ids) {
        var nextId = getRandomNumber(5);
        if (ids.indexOf(nextId) === -1) {
            ids.push(nextId);
            if (ids.length < 2) {
                getTheIds(ids);
            }
        } else {
            getTheIds(ids);
        }
        return ids;
    }
    
    //----- ISA display three random spec -------------------
    function displayThreeRandomInfo() {
        var emptyArray = [],
            ids = getTheIds(emptyArray),
            i;

        for (i in ids) {
            $('#isa-info-' + ids[i]).hide();
        }
    }

    displayThreeRandomInfo();

    //------ Formulaire -----------------------------------
    $('input').focus(function () {
        $(this).nextAll('label').addClass('on');
    });

    $('input').focusout(function () {
        if ($(this).val().length < 1) {
            $(this).nextAll('label').removeClass('on');
        }
    });

  //----- Google Map --------------------------------------    
    function initialize() {
        var myLatlng = new google.maps.LatLng(46.51734, 6.56282);
        var mapOptions = {
            zoom: 17,
            center: myLatlng,
            scrollwheel: false,
            mapTypeControl: true,
            zoomControl: true,
            zoomControlOptions: {
                style: google.maps.ZoomControlStyle.SMALL,
                position: google.maps.ControlPosition.LEFT_TOP
            },
            scaleControl: true
//            streetViewControl: true,
//            streetViewControlOptions: {
//                position: google.maps.ControlPosition.LEFT_TOP
//            }
        }
        var image = 'img/map-marker.png';
        
        var contentString = '<div class="map-info"><h5>Equinoxe MIS Development</h5></div>';
        
        var infowindow = new google.maps.InfoWindow({
            content: contentString
        });
        
        var marker = new google.maps.Marker({
            position: myLatlng,
            map: map,
            icon: image,
            title: 'Equinoxe MIS Development'
        });
        
        var map = new google.maps.Map(document.getElementById('google-map'), mapOptions);
        marker.setMap(map);
        
        var mapMobile = new google.maps.Map(document.getElementById('google-map-mobile'), mapOptions);
        
        marker.setMap(map);
        marker.setMap(mapMobile);
        
        google.maps.event.addListener(marker, 'click', function() {
            infowindow.open(map, marker);
        });
    }

    google.maps.event.addDomListener(window, 'load', initialize);
    
    // ALINE
    
    /*
   *    Change la navigation en fonction du support (taille de l'écran, mobile ou desktop)
   */
    function setNavigation() {
        var width = $(window).width();
        if (width <= 640) {
            //$("#desktop-nav").hide();
            //$('#mobile-nav').show();
            $('body').addClass('mobile');
            //$('#contact-panel').show();
        } else {
            //$("#desktop-nav").show();
            //$('#mobile-nav').hide();
            $('body').removeClass('mobile');
            //$('#contact-panel').hide();
        }
    }

    function hideLangues() {
        $('#langues').slideUp(200);
    }
    function showLangues() {
        $('#langues').slideDown(200);
    }

    /*
   *    Détecte si la page est scrollée pour réduire la taille du header et cacher les langues si c'est ouvert
   */
    $(window).scroll(function () {
        var position = $(document).scrollTop();
        hideLangues();
        if (position !== 0) {
            $('body').addClass('scroll');
        } else {
            $('body').removeClass('scroll');
        }
    });

    /*
   *    Détecte si la page est redimensionnée et cache les langues
   */
    $(window).resize(function () {
        hideLangues();
    });

    /*
   *    Remonte en haut de page si le bouton flottant d'action est cliqué (mobile exclu)
   */
    $('#floating-action-button').on('click', function () {
        $("html, body").animate({scrollTop: 0}, '100');
    });

    /*
   *    Affiche & Cache le menu des langues
   */
    function toggleLangueMenu(elem) {
        //$('#langues').slideToggle(200);

        var positionBtnLeft = elem.offset().left,
            //            positionBtnTop = elem.offset().top,
            //positionLanguesTop = positionBtnTop + elem.height();
            positionLanguesTop = '50px';


        if ($('#langues').is(':visible')) {
            hideLangues();
        } else {
            showLangues();
        }

        //$('#langues').css('top', positionLanguesTop + 5);
        $('#langues').css('top', positionLanguesTop);
        $('#langues').css('left', positionBtnLeft - 15);
    }

    $('body').on('click', function () {
        hideLangues();
    });

    $('#langues-btn').on('click', function () {
        toggleLangueMenu($(this));
        return false;
    });

    $('#langues-btn-mobile').on('click', function () {
        toggleLangueMenu($(this));
        return false;
    });

    /*
   *    Affiche & Cache le menu flottant de contact (mobile exclu)
   */
    $('#contact-btn').on('click', function () {
        $('body').addClass('show-contact-panel');
    });

    $('#close-contact-panel').on('click', function () {
        $('body').removeClass('show-contact-panel');
    });

    // touch gestion
    var contactPanelElem = document.getElementById('contact-panel'),
        cp = new Hammer(contactPanelElem),
        wow = new WOW({
            boxClass:     'wow',
            animateClass: 'animated',
            offset:       0,
            mobile:       false,
            live:         true
        });

    // Swipe left on Contact panel
    cp.on("swipeleft", function () {
        $('body').removeClass('show-contact-panel');
    });


    // Inscription aux events
    function hideInscriptions() {
        $("[class*=data-event-]").show();
        $("[class*=inscription-event-]").hide();
    }
    
    function showInscription(eventCode) {
        $('.data-event-' + eventCode).hide();
        $('.inscription-event-' + eventCode).show();
    }

    $('.inscription-event').on('click', function () {
        var eventCode = $(this).attr('event-code');
        showInscription(eventCode);
    });
    
    $('.tab-title').on('click', function () {
        hideInscriptions();
    });
    
    $('.inscr-form-cancel').on('click', function () {
        hideInscriptions();
    });
    
    // Flickity
    $('#clients-slide').flickity({
        // options
        wrapAround: true,
        freeScroll: true,
        contain: true,
        prevNextButtons: false,
        autoPlay: 2000,
        imagesLoaded: true,
        cellAlign: 'center',
        pageDots: false
    });
    
    
    // Masonry
    var $container = $('#news-masonry');
    // initialize
    $container.masonry({
//        gutter: 10,
        itemSelector: '.new',
        columnWidth: function( 1232 ) {
            return containerWidth / 2;
        }
    });
    
    // INIT EVENTS
    function init() {
        setNavigation();
        $(document).foundation();
        wow.init();
    }

    init();

    $(window).resize(function () {
        setNavigation();
    });

  //----- Foundation --------------------------------------
    $(document).foundation();

  
});