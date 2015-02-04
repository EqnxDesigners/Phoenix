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
        $(this).next('label').addClass('on');
    });

    $('input').focusout(function () {
        if ($(this).val().length < 1) {
            $(this).next('label').removeClass('on');
        }
    });

  //----- Google Map --------------------------------------
    function initialize() {
    //46.517376, 6.562770
        var myOptions = {
                center: new google.maps.LatLng(46.517376, 6.562770),
                zoom: 17,
                panControl: false,
                zoomControl: false,
                scaleControl: false,
                mapTypeControl: true,
                mapTypeId: google.maps.MapTypeId.ROADMAP
            },
            map = new google.maps.Map(document.getElementById("google-map"), myOptions),
            mapMobile = new google.maps.Map(document.getElementById("google-map-mobile"), myOptions);

    //var image = 'images/map_marker.png';
    //var myLatLng = new google.maps.LatLng(46.167654, 6.108538);
    //var expoMarker = new google.maps.Marker({
    //  position: myLatLng,
    //  map: map,
    //  icon: image
    //});
    }
    initialize();
    
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

  //----- Material Design ---------------------------------
  

  //$(document).foundation({
  //  accordion: {
  //    // specify the class used for accordion panels
  //    content_class: 'content',
  //    // specify the class used for active (or open) accordion panels
  //    active_class: 'active',
  //    // allow multiple accordion panels to be active at the same time
  //    multi_expand: true,
  //    // allow accordion panels to be closed by clicking on their headers
  //    // setting to false only closes accordion panels when another is opened
  //    toggleable: true
  //  }
  //});

  //$("#newsEqnx").masonry({
  //  columnWidth: 200,
  //  itemSelector: '.new',
  //  gutter: 10
  //});

//  $("#docsEqnx").masonry({
//    columnWidth: 500,
//    itemSelector: '.doc',
//    gutter: 10
//  });
  
  //$('#docsEqnx').mixItUp();

  //$('.slick-eqnx').slick({
  //  autoplay: true,
  //  autoplaySpeed: 3000,
  //  dots: false,
  //  speed: 1000,
  //  fade: true,
  //  touchMove: true
  //});

  //$('.slick-eqnx-diapo').slick({
  //  autoplay: true,
  //  autoplaySpeed: 3000,
  //  dots: true,
  //  speed: 1000,
  //  arrows: false,
  //  touchMove: true
  //});

  

  //$('#show-form').on('click', function () {
  //  if( /iPad|iPhone/i.test(navigator.userAgent) ) {
  //    $('.content-sem').hide();
  //    $('.content-sem-inscr').show();
  //  }else{
  //    $('.content-sem').hide();
  //    $('.content-sem').removeClass('animated flipInX');
  //    $('.content-sem-inscr').show();
  //    $('.content-sem-inscr').addClass('animated flipInX');
  //  }
  //});
  
  //$('#close-form').on('click', function () {
  //  if( /iPad|iPhone/i.test(navigator.userAgent) ) {
  //    $('.content-sem-inscr').hide();
  //    $('.content-sem').show();
  //  }else{
  //    $('.content-sem-inscr').hide();
  //    $('.content-sem-inscr').removeClass('animated flipInX');
  //    $('.content-sem').show();
  //    $('.content-sem').addClass('animated flipInX');
  //  }
  //});

  //var bodyEl = $('body'),
  //  content = $('.content-wrap'),
  //  openbtn = $('#burgerNav'),
  //  closebtn = $('#close-button'),
  //  isOpen = false;

//  function toggleMenu() {
//    if (isOpen) {
//      bodyEl.removeClass('show-menu');
////      bodyEl.removeClass('stopScroll');
//    } else {
//      bodyEl.addClass('show-menu');
////      bodyEl.addClass('stopScroll');
//    }
//    isOpen = !isOpen;
//  }

  //function initEvents() {
  //  openbtn.on('click', toggleMenu);
  //  if (closebtn) {
  //    closebtn.on('click', toggleMenu);
  //  }
  //  //FORMULAIRE
  //  $('.content-sem-inscr').hide();
  //  // close the menu element if the target it´s not the menu element or one of its descendants..
  //  content.on('click', function (ev) {
  //    var target = ev.target;
  //    if (isOpen) {
  //      toggleMenu();
  //    }
  //  });
  //}

  //function init() {
  //  initEvents();
  //}

  //init();
});

//----- Foundation ----------------------------------------
//$(document).foundation();

//$(document).foundation({
//  equalizer : {
//    // Specify if Equalizer should make elements equal height once they become stacked.
//    equalize_on_stack: false
//  }
//});