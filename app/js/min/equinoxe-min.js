$(document).ready(function(){"use strict";function o(o){return Math.floor(Math.random()*o+1)}function n(t){var e=o(5);return-1===t.indexOf(e)?(t.push(e),t.length<2&&n(t)):n(t),t}function t(){var o=[],t=n(o),e;for(e in t)$("#isa-info-"+t[e]).hide()}function e(){var o=new google.maps.LatLng(46.51734,6.56282),n={zoom:17,center:o,scrollwheel:!1,mapTypeControl:!0,zoomControl:!0,zoomControlOptions:{style:google.maps.ZoomControlStyle.SMALL,position:google.maps.ControlPosition.LEFT_TOP},scaleControl:!0},t="img/map-marker.png",e='<div class="map-info"><h5>Equinoxe MIS Development</h5></div>',i=new google.maps.InfoWindow({content:e});if(/iPhone|iPod|iPad|Linux/.test(navigator.platform))var l=new google.maps.Map(document.getElementById("google-map-mobile"),n);else var l=new google.maps.Map(document.getElementById("google-map"),n);var a=new google.maps.Marker({position:o,map:l,icon:t,title:"Equinoxe MIS Development"});google.maps.event.addListener(a,"click",function(){i.open(l,a)})}function i(){var o=$(window).width();640>=o?$("body").addClass("mobile"):$("body").removeClass("mobile")}function l(){$("#langues").slideUp(200)}function a(){$("#langues").slideDown(200)}function s(o){var n=o.offset().left,t="50px";$("#langues").is(":visible")?l():a(),$("#langues").css("top",t),$("#langues").css("left",n-15)}function c(){$("[class*=data-event-]").show(),$("[class*=inscription-event-]").hide()}function r(o){$(".data-event-"+o).hide(),$(".inscription-event-"+o).show()}function d(){i(),$(document).foundation(),f.init()}$("nav").on("click","li",function(){var o="#"+$(this).attr("target");$("html, body").animate({scrollTop:$(o).offset().top-60},500)}),$("#alerte-seminaire").on("click","a",function(){var o="#"+$(this).attr("target");$("html, body").animate({scrollTop:$(o).offset().top-60},500)}),t(),$("input").focus(function(){$(this).nextAll("label").addClass("on")}),$("input").focusout(function(){$(this).val().length<1&&$(this).nextAll("label").removeClass("on")}),google.maps.event.addDomListener(window,"load",e),$(window).scroll(function(){var o=$(document).scrollTop();l(),0!==o?$("body").addClass("scroll"):$("body").removeClass("scroll")}),$(window).resize(function(){l()}),$("#floating-action-button").on("click",function(){$("html, body").animate({scrollTop:0},"100")}),$("body").on("click",function(){l()}),$("#langues-btn").on("click",function(){return s($(this)),!1}),$("#langues-btn-mobile").on("click",function(){return s($(this)),!1}),$("#contact-btn").on("click",function(){$("body").addClass("show-contact-panel")}),$("#close-contact-panel").on("click",function(){$("body").removeClass("show-contact-panel")});var u=document.getElementById("contact-panel"),m=new Hammer(u),f=new WOW({boxClass:"wow",animateClass:"animated",offset:0,mobile:!1,live:!0});m.on("swipeleft",function(){$("body").removeClass("show-contact-panel")}),$(".inscription-event").on("click",function(){var o=$(this).attr("event-code");r(o)}),$(".tab-title").on("click",function(){c()}),$(".inscr-form-cancel").on("click",function(){c()});var p=$("#clients-slide").flickity({wrapAround:!0,freeScroll:!0,contain:!0,prevNextButtons:!1,autoPlay:2e3,imagesLoaded:!0,cellAlign:"center",pageDots:!1}),g=$("#news-masonry");g.masonry({itemSelector:".article",isFitWidth:!0}),d(),$(window).resize(function(){i()}),$(document).foundation()});