/*
 * Elenanorabioso Library
 * http://www.elenanorabioso.com
*/

/*jslint unparam: true, browser: true, indent: 2 */

(function ($) {

(function (window, document, undefined) {
  'use strict';

  window.Elenanorabioso = {
    name : 'Elenanorabioso',

    version : '1.0',
  },

  $.fn.elenanorabioso = function () {
  	// YOUR CODE HERE
    
    // Search button and form
    $('.search-button').click(function() {
	 	if($(this).hasClass('active')) {
			$(this).removeClass('active');
			$('.search-area').hide();
		} else {
			$(this).addClass('active');
			$('.search-area').show();
			$('#s').focus();
		}
		return false;
	});
	
	var s = $('#s').attr('placeholder');
	if(s!=='') {
		$('.search-button').addClass('active');
		$('.search-area').show();
	}
		
	$('.gallery').magnificPopup({
		delegate: 'a', // child items selector, by clicking on it popup will open
		type: 'image',
		fixedContentPos: true, // fix problem of gallery with android
		gallery: {
			enabled: true, // set to true to enable gallery
			preload: [0,2], // read about this option in next Lazy-loading section
			navigateByImgClick: true,
			arrowMarkup: '<button title="%title%" type="button" class="mfp-arrow mfp-arrow-%dir%"></button>', // markup of an arrow button
			tPrev: 'Anterior', // title for left button
			tNext: 'Siguiente', // title for right button
			tCounter: '' // markup of counter
			//tCounter: '<span class="mfp-counter">%curr% of %total%</span>' // markup of counter
		},
		image: {
			titleSrc: 'title' // options for image content type
		}
		// other options
	});
  };

}(this, this.document));

})(libFuncName);

/**
 * Código para poner fixed el menú
 var margentop;
var margenleft;

///- Dejo la edici�n de estilos din�mica, en vez de un cambio de clases de los elementos porque va m�s fluido as� (no mucho m�s, pero algo es algo) - 
$(document).ready(function() {
    var offset = $('#LogoCabecera').offset();
    margentop = offset.top;
    margenleft = offset.left;
    Posicion();
    $(window).scroll(function() { Posicion(); });
});



function Posicion() {
    //script que modifica el comportamiento de un elemento en funci�n del scroll de la p�gina.
    //pone una posici�n absoluta al logo y edita sus estilos
    var elemento = window.document.getElementById("LogoCabecera"); //elemento a cambiar
    var marco = window.document.getElementById("MarcoLogoCabecera");//marco que contiene el elemento a cambiar
    var relleno = window.document.getElementById("BloqueRelleno");//bloque de relleno: el que ocupa el espacio que deja el elemento al cambiar su posici�n a fixed
    var fondoblanco = window.document.getElementById("FondoBlanco");//fondo blanco para el logo: la imagen es transparente
    var sombra = window.document.getElementById("SombraLogo");//sombreado inferior del logo. Carga una imagen de archivo y se posiciona de forma absoluta
    if ($(window.document).scrollTop() >= margentop) {
        //$('#LogoCabecera').removeClass('LogoCabeceraNoScroll').addClass('LogoCabeceraScroll');
        //$('#MarcoLogoCabecera').removeClass('MarcoLogoCabeceraNoScroll').addClass('MarcoLogoCabeceraScroll');
	    
	    elemento.style.position='fixed';
	    elemento.style.margin = '0px';
	    elemento.style.top = '0px';
	    elemento.style.left = '0px';
	    elemento.style.height = '90px';
	    elemento.style.overflow = 'hidden';
	    elemento.style.width = '100%';
	    //marco.style.paddingBottom = '5px';
	    //marco.style.borderBottom = 'solid 1.5px #004688';
	    fondoblanco.style.paddingBottom = '5px';
	    relleno.style.display = 'block';
	    sombra.style.display = 'block';
	    //elemento.style.width = $('document').width() + 'px';
	    //elemento.style.left = margenleft + 'px';
	    //marco.style.backgroundColor = 'white';
	    //marco.style.margin = '0 auto';
	    //elemento.style.zIndex = '1';
	    //marco.style.outline = 'solid 5px #FFFFFF';
	}
	else
	{
	    //$('#LogoCabecera').removeClass('LogoCabeceraScroll').addClass('LogoCabeceraNoScroll');
	    //$('#MarcoLogoCabecera').removeClass('MarcoLogoCabeceraScroll').addClass('MarcoLogoCabeceraNoScroll');
	    
	    elemento.style.position = 'static';
	    elemento.style.marginTop = '5px';
	    elemento.style.width = '971px';
	    elemento.style.height = '73px';
	    //elemento.borderBottomColor = 'white';
	    marco.style.border = '0px';
	    marco.style.padding = '0px';
	    fondoblanco.style.paddingBottom = '0px';
	    relleno.style.display = 'none';
	    sombra.style.display = 'none';
	    //marco.style.margin = '0';
	    //marco.style.outline = '0';
	    //elemento.style.top=margentop+'px';
	}
};
*/