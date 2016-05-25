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
		global $wpdb;
		$settings = get_option('main_maintenance_settings');
		
		if ( !$settings ) {
			update_option('main_maintenance_settings', main_get_settings());
		}

		$main_notice = get_option('main_maintenance_rating_notice');
		
		if ( !$main_notice ) {
			update_option('main_maintenance_rating_notice', time());
		}

		$template_table  = $wpdb->prefix . 'maintenance_plugin_templates';
		$charset_collate = $wpdb->get_charset_collate();

		$template_sql = "CREATE TABLE IF NOT EXISTS $template_table (
				  `ID` int(9) NOT NULL AUTO_INCREMENT,
				  `template` text NOT NULL,
				  `template_html` text NOT NULL,
				  PRIMARY KEY (`ID`)
				) $charset_collate;";

		require_once( ABSPATH . 'wp-admin/includes/upgrade.php' );
		dbDelta( $template_sql );

		// Default template
		$default_html = '{main_maintenance_logo}<div class=\"maintenance-inner\"><div class=\"maintenance-title\" data-content=\"title\"></div>{main_maintenance_countdown}<p class=\"maintenance-description\" data-content=\"description\"></p>{main_maintenance_social}{main_maintenance_mailchimp}</div>';
		if ( !$wpdb->query('SELECT * FROM ' . $template_table . ' WHERE template="default"') ) {
			$wpdb->query('INSERT INTO ' . $template_table . ' (template,template_html) VALUES ("default","'.$default_html.'")');
		} else {
			$wpdb->query('UPDATE ' . $template_table . ' SET template_html="'.$default_html.'" WHERE template="default"');
		}

		// Style2 template
		$style2_html = '<div class=\"maintenance-inner\">{main_maintenance_logo}{main_maintenance_countdown}<p class=\"maintenance-description\" data-content=\"description\"></p>{main_maintenance_mailchimp}{main_maintenance_social}</div>';
		if ( !$wpdb->query('SELECT * FROM ' . $template_table . ' WHERE template="style2"') ) {
			$wpdb->query('INSERT INTO ' . $template_table . ' (template,template_html) VALUES ("style2","'.$style2_html.'")');
		} else {
			$wpdb->query('UPDATE ' . $template_table . ' SET template_html="'.$style2_html.'" WHERE template="style2"');
		}

		// Style3 template
		$style3_html = '<div class=\"maintenance-inner\">{main_maintenance_logo}<div class=\"maintenance-title\" data-content=\"title\"></div><p class=\"maintenance-description\" data-content=\"description\"></p>{main_maintenance_mailchimp}{main_maintenance_countdown}{main_maintenance_social}</div>';
		if ( !$wpdb->query('SELECT * FROM ' . $template_table . ' WHERE template="style3"') ) {
			$wpdb->query('INSERT INTO ' . $template_table . ' (template,template_html) VALUES ("style3","'.$style3_html.'")');
		} else {
			$wpdb->query('UPDATE ' . $template_table . ' SET template_html="'.$style3_html.'" WHERE template="style3"');
		}

		// Style4 template
		$style4_html = '<div class=\"maintenance-inner\">{main_maintenance_social}{main_maintenance_logo}<div class=\"maintenance-title\" data-content=\"title\"></div><p class=\"maintenance-description\" data-content=\"description\"></p>{main_maintenance_countdown}{main_maintenance_mailchimp}</div>';
		if ( !$wpdb->query('SELECT * FROM ' . $template_table . ' WHERE template="style4"') ) {
			$wpdb->query('INSERT INTO ' . $template_table . ' (template,template_html) VALUES ("style4","'.$style4_html.'")');
		} else {
			$wpdb->query('UPDATE ' . $template_table . ' SET template_html="'.$style4_html.'" WHERE template="style4"');
		}

		// Style5 template
		$style5_html = '<div class=\"maintenance-inner\"><div class=\"main-left-side\">{main_maintenance_logo}<p class=\"maintenance-description\" data-content=\"description\"></p>{main_maintenance_countdown}</div><div class=\"main-right-side\">{main_maintenance_mailchimp}{main_maintenance_social}</div></div>';
		if ( !$wpdb->query('SELECT * FROM ' . $template_table . ' WHERE template="style5"') ) {
			$wpdb->query('INSERT INTO ' . $template_table . ' (template,template_html) VALUES ("style5","'.$style5_html.'")');
		} else {
			$wpdb->query('UPDATE ' . $template_table . ' SET template_html="'.$style5_html.'" WHERE template="style5"');
		}

		// Style6 template
		$style6_html = '<div class=\"maintenance-inner\"><div class=\"main-left-side\">{main_maintenance_logo}<div class=\"maintenance-title\" data-content=\"title\"></div><p class=\"maintenance-description\" data-content=\"description\"></p>{main_maintenance_countdown}</div><div class=\"main-right-side\">{main_maintenance_mailchimp}{main_maintenance_social}</div></div>';
		if ( !$wpdb->query('SELECT * FROM ' . $template_table . ' WHERE template="style6"') ) {
			$wpdb->query('INSERT INTO ' . $template_table . ' (template,template_html) VALUES ("style6","'.$style6_html.'")');
		} else {
			$wpdb->query('UPDATE ' . $template_table . ' SET template_html="'.$style6_html.'" WHERE template="style6"');
		}

		// Style7 template
		$style7_html = '<div class=\"maintenance-inner\">{main_maintenance_logo}<div class=\"maintenance-title\" data-content=\"title\"></div><p class=\"maintenance-description\" data-content=\"description\"></p>{main_maintenance_countdown}{main_maintenance_mailchimp}{main_maintenance_social}</div>';
		if ( !$wpdb->query('SELECT * FROM ' . $template_table . ' WHERE template="style7"') ) {
			$wpdb->query('INSERT INTO ' . $template_table . ' (template,template_html) VALUES ("style7","'.$style7_html.'")');
		} else {
			$wpdb->query('UPDATE ' . $template_table . ' SET template_html="'.$style7_html.'" WHERE template="style7"');
		}

		// Style8 template
		$style8_html = '<div class=\"maintenance-inner\">{main_maintenance_logo}<div class=\"maintenance-title\" data-content=\"title\"></div></p>{main_maintenance_countdown}{main_maintenance_mailchimp}{main_maintenance_social}</div>';
		if ( !$wpdb->query('SELECT * FROM ' . $template_table . ' WHERE template="style8"') ) {
			$wpdb->query('INSERT INTO ' . $template_table . ' (template,template_html) VALUES ("style8","'.$style8_html.'")');
		} else {
			$wpdb->query('UPDATE ' . $template_table . ' SET template_html="'.$style8_html.'" WHERE template="style8"');
		}

		// Style9 template
		$style9_html = '<div class=\"maintenance-inner\">{main_maintenance_logo}<div class=\"maintenance-title\" data-content=\"title\"></div><p class=\"maintenance-description\" data-content=\"description\"></p></p>{main_maintenance_countdown}{main_maintenance_mailchimp}{main_maintenance_social}</div>';
		if ( !$wpdb->query('SELECT * FROM ' . $template_table . ' WHERE template="style9"') ) {
			$wpdb->query('INSERT INTO ' . $template_table . ' (template,template_html) VALUES ("style9","'.$style9_html.'")');
		} else {
			$wpdb->query('UPDATE ' . $template_table . ' SET template_html="'.$style9_html.'" WHERE template="style9"');
		}

		// Style10 template
		$style10_html = '<div class=\"maintenance-inner\">{main_maintenance_logo}<div class=\"maintenance-title\" data-content=\"title\"></div>{main_maintenance_countdown}<p class=\"maintenance-description\" data-content=\"description\"></p>{main_maintenance_social}{main_maintenance_mailchimp}</div>';
		if ( !$wpdb->query('SELECT * FROM ' . $template_table . ' WHERE template="style10"') ) {
			$wpdb->query('INSERT INTO ' . $template_table . ' (template,template_html) VALUES ("style10","'.$style10_html.'")');
		} else {
			$wpdb->query('UPDATE ' . $template_table . ' SET template_html="'.$style10_html.'" WHERE template="style10"');
		}

		// Style11 template
		$style11_html = '<div class=\"maintenance-inner\">{main_maintenance_logo}<div class=\"maintenance-title\" data-content=\"title\"></div><p class=\"maintenance-description\" data-content=\"description\"></p>{main_maintenance_countdown}{main_maintenance_social}{main_maintenance_mailchimp}</div>';
		if ( !$wpdb->query('SELECT * FROM ' . $template_table . ' WHERE template="style11"') ) {
			$wpdb->query('INSERT INTO ' . $template_table . ' (template,template_html) VALUES ("style11","'.$style11_html.'")');
		} else {
			$wpdb->query('UPDATE ' . $template_table . ' SET template_html="'.$style11_html.'" WHERE template="style11"');
		}

	}

}
