(function( $ ) {
	'use strict';

	/**
	 * All of the code for your public-facing JavaScript source
	 * should reside in this file.
	 *
	 * Note that this assume you're going to use jQuery, so it prepares
	 * the $ function reference to be used within the scope of this
	 * function.
	 *
	 * From here, you're able to define handlers for when the DOM is
	 * ready:
	 *
	 * $(function() {
	 *
	 * });
	 *
	 * Or when the window is loaded:
	 *
	 * $( window ).load(function() {
	 *
	 * });
	 *
	 * ...and so on.
	 *
	 * Remember that ideally, we should not attach any more than a single DOM-ready or window-load handler
	 * for any particular page. Though other scripts in WordPress core, other plugins, and other themes may
	 * be doing this, we should try to minimize doing that in our own work.
	 */

	
})( jQuery );

jQuery(document).ready(function($) {
	var content_data = jQuery.parseJSON( jQuery('#main-template-data').html() );
	// Add text
	jQuery.each(content_data.texts, function(index, value) {
		jQuery('[data-content='+index+']').html( value );
	});
	// Add style
	jQuery.each(content_data.styles, function(index, value) {
		jQuery('[data-content='+index+']').attr( 'style', value );
	});
});

jQuery(window).load(function() {

});