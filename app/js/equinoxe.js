/*global $, console, alert*/
$(document).ready(function () {
  "use strict";

  //----- Scrolling main menu -----------------------------
  $('nav').on('click', 'li', function() {
    var target = '#' + $(this).attr('target');
    $("html, body").animate({scrollTop:$(target).offset().top-60},500)});
  });

  //----- ISA display three random spec -------------------
  function displayThreeRandomInfo() {
    var emptyArray = [];
    var ids = getTheIds(emptyArray);

    for(var i in ids) {
      $('#isa-info-' + ids[i]).hide();
    }
  }

  function getRandomNumber(max) {
    return Math.floor((Math.random() * max) + 1);
  }

  function getTheIds(ids) {
    var nextId = getRandomNumber(5);
    if(ids.indexOf(nextId) === -1) {
      ids.push(nextId);
      if(ids.length < 2) {
        getTheIds(ids);
      }
    }
    else {
      getTheIds(ids);
    }
    return ids;
  }

  displayThreeRandomInfo();

  $(document).foundation();

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
  //  columnWidth: 500,
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