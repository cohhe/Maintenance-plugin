<?php

/**
 * Fired during plugin activation
 *
 * @link       http://example.com
 * @since      1.0.0
 *
 * @package    maitenance_func
 * @subpackage maitenance_func/includes
 */

/**
 * Fired during plugin activation.
 *
 * This class defines all code necessary to run during the plugin's activation.
 *
 * @since      1.0.0
 * @package    maitenance_func
 * @subpackage maitenance_func/includes
 * @author     Your Name <email@example.com>
 */
class maitenance_func_Activator {

	/**
	 * Short Description. (use period)
	 *
	 * Long Description.
	 *
	 * @since    1.0.0
	 */
	public static function maitenance_activate() {
		$settings = get_option('main_maintenance_settings');
		
		if ( !$settings ) {
			update_option('main_maintenance_settings', main_get_settings());
		}

		$main_notice = get_option('main_maintenance_rating_notice');
		
		if ( !$main_notice ) {
			update_option('main_maintenance_rating_notice', time());
		}
	}

}
