(function( $ ) {
	'use strict';

	/**
	 * All of the code for your admin-specific JavaScript source
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

	jQuery(document).on('click', '.main-maintenance-checkbox:not(.disabled)', function() {
		jQuery(this).toggleClass('active')
		if ( jQuery(this).find('input').is(':checked') ) {
			jQuery(this).find('input').prop('checked', false);
		} else {
			jQuery(this).find('input').prop('checked', true);
		}
	});

	jQuery('.main-maintenance-checkbox input').each(function() {
		if ( jQuery(this).is(':checked') ) {
			jQuery(this).parent().addClass('active');
		}
	});

	jQuery(document).on('click', '#main-page-headline, #main-page-description', function() {
		jQuery('.text-styling-row').show();
		jQuery('#main-edited-text').val( '#' + jQuery(this).attr('id') );
		jQuery('#main-page-headline, #main-page-description').removeClass('active');
		jQuery(this).addClass('active');

		jQuery('#main-font-size').val( jQuery(this).css('font-size').replace('px', '') );
		jQuery('#main-line-height').val( jQuery(this).css('line-height').replace('px', '') );
		jQuery('#main-font-weight').val( jQuery(this).css('font-weight') );
		jQuery('.wp-colorpicker').wpColorPicker('color', jQuery(this).css('color'));
	});

	jQuery('.wp-colorpicker').wpColorPicker({
		change: function(event, ui) {
			jQuery( jQuery('#main-edited-text').val() ).css( 'color', ui.color.toString() );
		},
		clear: function() {
			jQuery( jQuery('#main-edited-text').val() ).css( 'color', '#fff' );
		}
	});

	jQuery('.main-number-field span').on('click', function() {
		if ( jQuery(this).hasClass('main-number-minus') ) {
			jQuery(this).parent().find('input').val( parseInt( jQuery(this).parent().find('input').val() ) - 1 );
		} else {
			jQuery(this).parent().find('input').val( parseInt( jQuery(this).parent().find('input').val() ) + 1 );
		}
		jQuery(this).parent().find('input').trigger('input');
	});

	jQuery('.main-number-field input').on('input', function() {
		jQuery( jQuery('#main-edited-text').val() ).css( jQuery(this).attr('id').replace('main-', ''), jQuery(this).val() + 'px' );
	});

	jQuery('#main-font-weight').on('change', function() {
		jQuery( jQuery('#main-edited-text').val() ).css( jQuery(this).attr('id').replace('main-', ''), jQuery(this).val() );
	});

	jQuery('.input-wrapper.file-upload a.choose-image').on('click', function() {
		var $wpimageupload = jQuery(this).parent().find('input');
		var $wpdeleteimage = jQuery(this).parent().find('a.delete-image');
		var image = wp.media({ 
            title: 'Upload Image',
            multiple: false
        }).open()
        .on('select', function(e){
            var uploaded_image = image.state().get('selection').first();
            var image_url = uploaded_image.toJSON().url;
            $wpimageupload.val(image_url).trigger('input');
            $wpdeleteimage.removeClass('hidden');
        });
	});

	jQuery(document).on('click', '.save-main-maintenance', function() {
		var main_settings = '{';
		// Text inputs, selects
		jQuery('.main-maintenance-wrapper input[type=text]:not(.profeature), .main-maintenance-wrapper select:not(.text-styling):not(.profeature)').each(function() {
			var input_value = jQuery(this).val();
			if ( typeof jQuery(this).val() == 'string' ) {
				input_value = jQuery(this).val().replace(/"/g, "'");
			}
			main_settings += '"'+jQuery(this).attr('id').replace('main-', '')+'":"'+input_value+'",';
		});
		// Checkboxes
		jQuery('.main-maintenance-wrapper input[type=checkbox]:not(.profeature)').each(function() {
			if ( jQuery(this).is(':checked') ) {
				var checkbox_val = 'true';
			} else {
				var checkbox_val = 'false';
			}
			main_settings += '"'+jQuery(this).attr('id').replace('main-', '')+'":"'+checkbox_val+'",';
		});
		jQuery('#main-page-headline, #main-page-description').each(function() {
			main_settings += '"'+jQuery(this).attr('id').replace('main-', '')+'":"'+jQuery(this).html()+'",';
			main_settings += '"'+jQuery(this).attr('id').replace('main-', '')+'-style":"'+jQuery(this).attr('style')+'",';
		});
		if ( jQuery('#main-background-video').length ) {
			main_settings += '"'+jQuery('#main-background-video').attr('id').replace('main-', '')+'":"'+jQuery('#main-background-video').val()+'",';
		}
		if ( jQuery('#main-countdown').length ) {
			main_settings += '"'+jQuery('#main-countdown').attr('id').replace('main-', '')+'":"'+jQuery('#main-countdown').val()+'",';
		}
		// Analytics
		main_settings += '"google-analytics-code":"'+jQuery('#main-google-analytics-code').val()+'",';
		// Exclude
		main_settings += '"exclude":"'+jQuery('#main-exclude').val().replace(/\n/g, "|")+'",';
		// MailChimp
		if ( jQuery('#main-mailchimp').length ) {
			main_settings += '"mailchimp":'+JSON.stringify(jQuery('#main-mailchimp').val().replace(/"/g, "'")).replace(/\\n/g, '').replace(/\\t/g, '')+',';
		}
		// Access by ip
		if ( jQuery('#main-access-by-ip').length ) {
			main_settings += '"access-by-ip":"'+jQuery('#main-access-by-ip').val().replace(/\n/g, "|")+'",';
		}
		// Template
		if ( jQuery('#maintenance-template').length ) {
			main_settings += '"template":"'+jQuery('.main-fake-select').attr('data-selected')+'",';
		}
		// CSS
		if ( jQuery('#main-maintenance-css').length ) {
			main_settings += '"maintenance-css":"'+jQuery('#main-maintenance-css').val().replace(/"/g, "'")+'",';

		}
		main_settings = main_settings.slice(0, -1);
		main_settings += '}';
		jQuery.ajax({
			type: 'POST',
			url: maintenance_main.ajaxurl,
			data: { 
				'action': 'main_save_maintenance_settings',
				'main_settings': main_settings
			},
			success: function(data) {
				location.reload();
			}
		});
	})

	jQuery(document).on('click', '.main-maintenance-dismiss', function() {
		jQuery.ajax({
			type: 'POST',
			url: maintenance_main.ajaxurl,
			data: { 
				'action': 'main_dismiss_notice'
			},
			success: function(data) {
				jQuery('.main-maintenance-notice').remove();
			}
		});
	});

	jQuery(document).on('click', '.main-fake-select', function() {
		jQuery(this).find('li').each(function() {
			if ( jQuery(this).hasClass('selected') ) {
				jQuery(this).trigger('mouseenter');
			}
		});
		jQuery(this).toggleClass('opened');
		jQuery(this).find('ul').width( jQuery(this).width() + 25 );
		if ( jQuery(this).hasClass('opened') ) {
			jQuery(this).parent().find('#maintenance-template').addClass('opened');
		} else {
			jQuery(this).parent().find('#maintenance-template').removeClass('opened');
		}
		
	});

	jQuery(document).on('click', '.main-fake-select li:not(.cant-select)', function() {
		var selected_element = jQuery(this);
		setTimeout(function() {
			selected_element.parent().parent().attr('data-selected', selected_element.attr('data-value'));
			selected_element.parent().parent().removeClass('opened');
			selected_element.parent().find('li').removeClass('selected');
			selected_element.addClass('selected');
			selected_element.parent().parent().parent().find('#maintenance-template').removeClass('opened');
			jQuery('#main-background-image').attr('value', maintenance_main.img_folder + selected_element.attr('data-value') + '-bg.jpg' );
			if ( selected_element.attr('data-value') == 'style5' ) {
				jQuery('.form-group.second-bg').show();
			} else {
				jQuery('.form-group.second-bg').hide();
			}
		}, 100);
	});

	jQuery(document).on('mouseenter', '.main-fake-select li', function() {
		jQuery(this).parent().parent().parent().find('#maintenance-template').addClass('opened');
		jQuery(this).parent().parent().parent().find('#maintenance-template').css('background', 'url(' + jQuery(this).attr('data-image') + ') no-repeat #fff');
	});

	if ( jQuery('.main-fake-select').attr('data-selected') == 'style5' ) {
		jQuery('.form-group.second-bg').show();
	}

});