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
	
	// end search button and form
	
	// Gallery
	//var options = {},
	//instance = PhotoSwipe.attach( window.document.querySelectorAll('.gallery a'), options );
	//var options = {};
	//$(".gallery a").photoSwipe(options);


  };

}(this, this.document));

})(libFuncName);

// TODO Gallery (FIXIT)
(function(window, PhotoSwipe){
	document.addEventListener('DOMContentLoaded', function(){
		var options = {},
			instance = PhotoSwipe.attach( window.document.querySelectorAll('.gallery a'), options );
	}, false);
}(window, window.Code.PhotoSwipe));