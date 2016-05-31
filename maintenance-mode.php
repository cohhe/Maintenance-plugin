<?php

/**
 * The plugin bootstrap file
 *
 * This file is read by WordPress to generate the plugin information in the plugin
 * admin area. This file also includes all of the dependencies used by the plugin,
 * registers the activation and deactivation functions, and defines a function
 * that starts the plugin.
 *
 * @link              http://cohhe.com
 * @since             1.0
 * @package           maitenance_func
 *
 * @wordpress-plugin
 * Plugin Name:       Maintenance mode
 * Plugin URI:        http://cohhe.com/
 * Description:       This plugin adds maintenance mode functionality to your page
 * Version:           1.0
 * Author:            Cohhe
 * Author URI:        https://cohhe.com/
 * License:           GPL-2.0+
 * License URI:       http://www.gnu.org/licenses/gpl-2.0.txt
 * Text Domain:       maintenance-mode
 * Domain Path:       /languages
 */

// If this file is called directly, abort.
if ( ! defined( 'WPINC' ) ) {
	die;
}

/**
 * The code that runs during plugin activation.
 * This action is documented in includes/class-maitenance-functionality-activator.php
 */
function maitenance_activate_maitenance_func() {
	require_once plugin_dir_path( __FILE__ ) . 'includes/class-maitenance-functionality-activator.php';
	maitenance_func_Activator::maitenance_activate();
}

/**
 * The code that runs during plugin deactivation.
 * This action is documented in includes/class-maitenance-functionality-deactivator.php
 */
function maitenance_deactivate_maitenance_func() {
	require_once plugin_dir_path( __FILE__ ) . 'includes/class-maitenance-functionality-deactivator.php';
	maitenance_func_Deactivator::maitenance_deactivate();
}

register_activation_hook( __FILE__, 'maitenance_activate_maitenance_func' );
register_deactivation_hook( __FILE__, 'maitenance_deactivate_maitenance_func' );

/**
 * The core plugin class that is used to define internationalization,
 * admin-specific hooks, and public-facing site hooks.
 */
define('maitenance_PLUGIN', plugin_dir_path( __FILE__ ));
define('maitenance_PLUGIN_URI', plugin_dir_url( __FILE__ ));
define('maitenance_PLUGIN_MENU_PAGE', 'wp-maintenance');
define('maitenance_PLUGIN_SUBMENU_PAGE', 'maintenance-mode-list');
define('maitenance_PLUGIN_MENU_PAGE_URL', get_admin_url() . 'admin.php?page=' . maitenance_PLUGIN_MENU_PAGE);
define('maitenance_PLUGIN_SUBMENU_PAGE_URL', get_admin_url() . 'admin.php?page=' . maitenance_PLUGIN_SUBMENU_PAGE);
require plugin_dir_path( __FILE__ ) . 'includes/class-maitenance-functionality.php';


/**
 * Begins execution of the plugin.
 *
 * Since everything within the plugin is registered via hooks,
 * then kicking off the plugin from this point in the file does
 * not affect the page life cycle.
 *
 * @since    1.0.0
 */
function run_maitenance_func() {

	$plugin = new maitenance_func();
	$plugin->maitenance_run();

}
run_maitenance_func();

function main_register_maintenance_menu_page() {
	add_menu_page(
		__( 'Maintenance', 'maintenance-mode' ),
		__( 'Maintenance', 'maintenance-mode' ),
		'manage_options',
		maitenance_PLUGIN_MENU_PAGE,
		'',
		'',
		6
	);

	add_submenu_page(
		maitenance_PLUGIN_MENU_PAGE,
		__('Add New', 'maintenance-mode'),
		__('Add New', 'maintenance-mode'),
		'manage_options',
		maitenance_PLUGIN_MENU_PAGE,
		'main_maintenance_settings'
	);
}
add_action( 'admin_menu', 'main_register_maintenance_menu_page' );

function main_get_settings() {
	$settings = array(
		'maintenance-status' => 'false',
		'background-image' => plugin_dir_url( __FILE__ ).'public/images/default-bg.png',
		'background-blur' => 'false',
		'maintenance-logo' => '',
		'maintenance-retina' => 'false',
		'robots' => 'noindex',
		'google-analytics' => 'false',
		'google-analytics-code' => '',
		'exclude' => '',
		'page-title' => 'Maintenance',
		'page-headline' => 'We\'re under maintenance',
		'page-headline-style' => '',
		'page-description' => 'We are currently working on our website. Stay tuned for more information.<br>Subscribe to our newsletter to stay updated on our progress.',
		'page-description-style' => '',
		'social-networks' => 'false',
		'social-target' => 'new',
		'social-github' => '',
		'social-dribbble' => '',
		'social-twitter' => '',
		'social-facebook' => '',
		'social-pinterest' => '',
		'social-gplus' => '',
		'social-linkedin' => '',
		);

	return json_encode($settings);
}

function main_maintenance_settings() {
	if ( !current_user_can('manage_options') )  {
		wp_die( __('You do not have sufficient permissions to access this page.', 'maintenance-mode') );
	}

	$main_maintenance_settings = (array)json_decode(get_option('main_maintenance_settings'));

	?>
		<div class="main-maintenance-wrapper">
			<div class="container-fluid">
				<a href="javascript:void(0)" class="btn btn-primary btn-lg save-main-maintenance">Save settings</a>
				<div class="row">
					<div class="col-sm-6">
						<div class="white-box">
							<h2>Maintenance configuration</h2>
							<p class="text-muted m-b-30 font-13">You'll be able to configure all your needed maintenance settings here.</p>
							<div class="form-group clearfix">
								<label for="pm-image-to-url" class="control-label col-md-3">Maintenance status</label>
								<div class="input-wrapper col-md-9">
									<div class="main-maintenance-checkbox">
										<span></span>
										<input type="checkbox" id="main-maintenance-status" <?php echo ( isset($main_maintenance_settings['maintenance-status']) && $main_maintenance_settings['maintenance-status'] == 'true' ? 'checked' : '' ); ?>>
									</div>
								</div>
							</div>
							<?php do_action('main_maintenance_config_top'); ?>
							<?php if ( !function_exists('run_maintenancepro_func') ) { ?>
								<div class="form-group clearfix">
									<div class="form-group clearfix main-grayed">
										<label for="pm-image-to-url" class="control-label col-md-3 main-maintenance-locked">Login form</label>
										<div class="input-wrapper col-md-9">
											<div class="main-maintenance-checkbox disabled">
												<span></span>
												<input type="checkbox" id="main-profeature9">
											</div>
										</div>
									</div>
								</div>
							<?php } ?>
							<div class="form-group clearfix">
								<label for="pm-image-to-url" class="control-label col-md-3">Robots Meta Tag</label>
								<div class="input-wrapper col-md-9">
									<select id="main-robots" class="form-control">
										<option value="index" <?php echo ( isset($main_maintenance_settings['robots']) && $main_maintenance_settings['robots'] == 'index' ? 'selected' : '' ); ?>>index,follow</option>
										<option value="noindex" <?php echo ( isset($main_maintenance_settings['robots']) && $main_maintenance_settings['robots'] == 'noindex' ? 'selected' : '' ); ?>>noindex/nofollow</option>
									</select>
								</div>
							</div>
							<div class="form-group clearfix">
								<label for="pm-image-to-url" class="control-label col-md-3">Exclude</label>
								<div class="input-wrapper col-md-9">
									<textarea id="main-exclude" class="form-control"><?php echo (isset($main_maintenance_settings['exclude']) && $main_maintenance_settings['exclude'] != ''?str_replace('|', PHP_EOL, $main_maintenance_settings['exclude']):'feed'.PHP_EOL.'wp-login'.PHP_EOL.'login'); ?></textarea>
									<p class="text-muted font-13">You're able to exclude feeds, pages or IPs from maintenance mode. Add one exclude option per line!</p>
								</div>
							</div>
							<div class="">
								<div class="form-group clearfix">
									<label for="pm-image-to-url" class="control-label col-md-3">Enable google analytics?</label>
									<div class="input-wrapper col-md-9">
										<div class="main-maintenance-checkbox">
											<span></span>
											<input type="checkbox" id="main-google-analytics" <?php echo ( isset($main_maintenance_settings['google-analytics']) && $main_maintenance_settings['google-analytics'] == 'true' ? 'checked' : '' ); ?>>
										</div>
									</div>
								</div>
								<div class="form-group clearfix">
									<label for="pm-image-to-url" class="control-label col-md-3">Analytics tracking code</label>
									<div class="input-wrapper col-md-9">
										<textarea id="main-google-analytics-code" class="form-control"><?php echo (isset($main_maintenance_settings['google-analytics-code']) && $main_maintenance_settings['google-analytics-code'] != '' ? $main_maintenance_settings['google-analytics-code'] : ''); ?></textarea>
									</div>
								</div>
							</div>
						</div>
						<div class="white-box">
							<h2>Maintenance texts</h2>
							<p class="text-muted m-b-30 font-13">Here you can style and change your maintenance texts.</p>
							<div class="form-group clearfix">
								<label for="pm-image-to-url" class="control-label col-md-3">Page headline</label>
								<div class="input-wrapper col-md-9">
									<div id="main-page-headline" class="form-control" spellcheck="false" contenteditable="true" style="<?php echo (isset($main_maintenance_settings['page-headline-style'])?$main_maintenance_settings['page-headline-style']:''); ?>"><?php echo (isset($main_maintenance_settings['page-headline'])?$main_maintenance_settings['page-headline']:''); ?></div>
								</div>
							</div>
							<div class="form-group clearfix">
								<label for="pm-image-to-url" class="control-label col-md-3">Page description</label>
								<div class="input-wrapper col-md-9">
									<div id="main-page-description" class="form-control textarea" spellcheck="false" contenteditable="true" style="<?php echo (isset($main_maintenance_settings['page-description-style'])?$main_maintenance_settings['page-description-style']:''); ?>"><?php echo (isset($main_maintenance_settings['page-description'])?$main_maintenance_settings['page-description']:''); ?></div>
								</div>
							</div>
							<?php do_action('main_maintenance_text_style_bottom'); ?>
							<div class="form-group text-styling-row">
								<input type="hidden" id="main-edited-text" value="">
								<div class="col-md-3">
									<h4>Text color</h4>
									<input type="text" id="main-color" class="text-styling wp-colorpicker" value="">
								</div>
								<div class="col-md-3">
									<h4>Text size</h4>
									<div class="main-number-field">
										<span class="main-number-minus">-</span>
										<input type="number" id="main-font-size" class="form-control text-styling" value="">
										<span class="main-number-plus">+</span>
									</div>
								</div>
								<div class="col-md-3">
									<h4>Text line height</h4>
									<div class="main-number-field">
										<span class="main-number-minus">-</span>
										<input type="number" id="main-line-height" class="form-control text-styling" value="">
										<span class="main-number-plus">+</span>
									</div>
								</div>
								<div class="col-md-3">
									<h4>Text style</h4>
									<select id="main-font-weight" class="form-control text-styling">
										<option value="400">Normal</option>
										<option value="300">Light</option>
										<option value="bold">Bold</option>
									</select>
								</div>
								<div class="clearfix"></div>
							</div>
						</div>
						<?php do_action('main_maintenance_first_column_bottom'); ?>
						<?php if ( !function_exists('run_maintenancepro_func') ) { ?>
								<div class="white-box">
									<h2>Access controls</h2>
									<p class="text-muted m-b-30 font-13">Here you can control who can access your site.</p>
									<div class="form-group bypass-url clearfix main-grayed">
										<label for="pm-image-to-url" class="control-label col-md-3 main-maintenance-locked">Bypass url</label>
										<div class="input-wrapper col-md-9">
											<?php echo '<b>'.get_home_url().'/</b>'; ?><input type="text" id="main-profeature1" class="form-control profeature" value="" disabled>
										</div>
									</div>
									<div class="form-group clearfix main-grayed">
										<label for="pm-image-to-url" class="control-label col-md-3 main-maintenance-locked">Bypass expires</label>
										<div class="input-wrapper col-md-9">
											<input type="text" id="main-profeature2" class="form-control profeature" value="" disabled>
										</div>
									</div>
									<div class="form-group clearfix main-grayed">
										<label for="pm-image-to-url" class="control-label col-md-3 main-maintenance-locked">Access by IP</label>
										<div class="input-wrapper col-md-9">
											<textarea id="main-profeature3" class="form-control profeature" disabled></textarea>
										</div>
									</div>
									<div class="form-group clearfix main-grayed">
										<label for="pm-image-to-url" class="control-label col-md-3 main-maintenance-locked">Access by Role</label>
										<div class="input-wrapper col-md-9">
											<select id="main-profeature4" class="form-control profeature" multiple disabled>
												<option value="1">Anyone logged in</option>
												<option value="2">Administrator</option>
												<option value="3">Editor</option>
												<option value="4">Author</option>
												<option value="5">Contributor</option>
												<option value="6">Subscriber</option>
											</select>
										</div>
									</div>
								</div>
						<?php } ?>
					</div>
					<div class="col-sm-6">
						<div class="white-box">
							<h2>Maintenance mode style</h2>
							<p class="text-muted m-b-30 font-13">Here you'll be able to change what appears on your front page.</p>
							<?php do_action('main_maintenance_looks_top'); ?>
							<?php if ( !function_exists('run_maintenancepro_func') ) { ?>
								<div class="form-group clearfix main-grayed">
									<label for="pm-image-to-url" class="control-label col-md-3 main-maintenance-locked">Maintenance template</label>
									<div class="input-wrapper file-upload col-md-9">
										<div class="main-fake-select" data-selected="default">
											<ul>
												<li data-value="default" data-image="" class="selected">Default</li>
												<li data-value="style2" data-image="" class="cant-select">Style 2 - PRO version only</li>
												<li data-value="style3" data-image="" class="cant-select">Style 3 - PRO version only</li>
												<li data-value="style4" data-image="" class="cant-select">Style 4 - PRO version only</li>
												<li data-value="style5" data-image="" class="cant-select">Style 5 - PRO version only</li>
												<li data-value="style6" data-image="" class="cant-select">Style 6 - PRO version only</li>
												<li data-value="style7" data-image="" class="cant-select">Style 7 - PRO version only</li>
												<li data-value="style8" data-image="" class="cant-select">Style 8 - PRO version only</li>
												<li data-value="style9" data-image="" class="cant-select">Style 9 - PRO version only</li>
												<li data-value="style10" data-image="" class="cant-select">Style 10 - PRO version only</li>
												<li data-value="style11" data-image="" class="cant-select">Style 11 - PRO version only</li>
											</ul>
										</div>
									</div>
								</div>
								<div class="form-group clearfix main-grayed">
									<label for="pm-image-to-url" class="control-label col-md-3 main-maintenance-locked">Background video</label>
									<div class="input-wrapper file-upload col-md-9">
										<a href="javascript:void(0)" class="choose-image">Choose video</a>
										<input type="text" id="main-profeature5" class="form-control" value="" disabled>
										<p class="text-muted font-13">If a video is added, the background image is going to be overwritten with a video.</p>
									</div>
								</div>
								<div class="form-group clearfix main-grayed">
									<label for="pm-image-to-url" class="control-label col-md-3 main-maintenance-locked">Background animation</label>
									<div class="input-wrapper file-upload col-md-9">
										<select id="main-profeature6" class="form-control">
											<option value="none" selected>None</option>
											<option value="profeature1">Interactive lines</option>
											<option value="profeature2">Raising bubbles</option>
											<option value="profeature3">Spewing triangles</option>
											<option value="profeature4">Rotating lines</option>
										</select>
									</div>
								</div>
							<?php } ?>
							<div class="form-group clearfix">
								<label for="pm-image-to-url" class="control-label col-md-3">Background image</label>
								<div class="input-wrapper file-upload col-md-9">
									<a href="javascript:void(0)" class="choose-image">Choose image</a>
									<input type="text" id="main-background-image" class="form-control" value="<?php echo (isset($main_maintenance_settings['background-image'])?$main_maintenance_settings['background-image']:''); ?>" disabled>
								</div>
							</div>
							<div class="form-group clearfix">
								<label for="pm-image-to-url" class="control-label col-md-3">Background image blur effect</label>
								<div class="input-wrapper col-md-9">
									<div class="main-maintenance-checkbox">
										<span></span>
										<input type="checkbox" id="main-background-blur" <?php echo ( isset($main_maintenance_settings['background-blur']) && $main_maintenance_settings['background-blur'] == 'true' ? 'checked' : '' ); ?>>
									</div>
								</div>
							</div>
							<div class="form-group clearfix">
								<label for="pm-image-to-url" class="control-label col-md-3">Logo</label>
								<div class="input-wrapper file-upload col-md-9">
									<a href="javascript:void(0)" class="choose-image">Choose image</a>
									<input type="text" id="main-maintenance-logo" class="form-control" value="<?php echo (isset($main_maintenance_settings['maintenance-logo'])?$main_maintenance_settings['maintenance-logo']:''); ?>">
								</div>
							</div>
							<div class="form-group clearfix">
								<label for="pm-image-to-url" class="control-label col-md-3">Is logo retina ready?</label>
								<div class="input-wrapper col-md-9">
									<div class="main-maintenance-checkbox">
										<span></span>
										<input type="checkbox" id="main-maintenance-retina" <?php echo ( isset($main_maintenance_settings['maintenance-retina']) && $main_maintenance_settings['maintenance-retina'] == 'true' ? 'checked' : '' ); ?>>
									</div>
								</div>
							</div>
							<div class="form-group clearfix">
								<label for="pm-image-to-url" class="control-label col-md-3">Page title</label>
								<div class="input-wrapper col-md-9">
									<input type="text" id="main-page-title" class="form-control" value="<?php echo (isset($main_maintenance_settings['page-title'])?$main_maintenance_settings['page-title']:''); ?>">
								</div>
							</div>
							<?php do_action('main_maintenance_looks_bottom'); ?>
							<?php if ( !function_exists('run_maintenancepro_func') ) { ?>
								<div class="form-group clearfix">
									<div class="form-group clearfix main-grayed">
										<label for="pm-image-to-url" class="control-label col-md-3 main-maintenance-locked">MailChimp form</label>
										<div class="input-wrapper col-md-9">
											<textarea id="main-profeature7" class="form-control" disabled></textarea>
											<p class="text-muted font-13">Want to display your MailChimp signup form at the front page? Add it here!</p>
										</div>
									</div>
								</div>
								<div class="form-group clearfix">
									<div class="form-group clearfix main-grayed">
										<label for="pm-image-to-url" class="control-label col-md-3 main-maintenance-locked">Countdown till</label>
										<div class="input-wrapper col-md-9">
											<input type="text" id="main-profeature8" class="form-control" value="" disabled>
											<p class="text-muted font-13">Whant your visitorn to know when your site is going to be back? Add a countdown to your page!</p>
										</div>
									</div>
								</div>
							<?php } ?>
						</div>
						<div class="white-box clearfix">
							<h2>Social networks</h2>
							<div class="form-group clearfix">
								<label for="pm-image-to-url" class="control-label col-md-3">Enable social networks?</label>
								<div class="input-wrapper col-md-9">
									<div class="main-maintenance-checkbox">
										<span></span>
										<input type="checkbox" id="main-social-networks" <?php echo ( isset($main_maintenance_settings['social-networks']) && $main_maintenance_settings['social-networks'] == 'true' ? 'checked' : '' ); ?>>
									</div>
								</div>
							</div>
							<div class="form-group clearfix">
								<label for="pm-image-to-url" class="control-label col-md-3">Link targets</label>
								<div class="input-wrapper col-md-9">
									<select id="main-social-target" class="form-control">
										<option value="new" <?php echo ( isset($main_maintenance_settings['social-target']) && $main_maintenance_settings['social-target'] == 'new' ? 'selected' : '' ); ?>>New page</option>
										<option value="same" <?php echo ( isset($main_maintenance_settings['social-target']) && $main_maintenance_settings['social-target'] == 'same' ? 'selected' : '' ); ?>>Same page</option>
									</select>
								</div>
							</div>
							<div class="form-group clearfix">
								<label for="pm-image-to-url" class="control-label col-md-3">Github</label>
								<div class="input-wrapper col-md-9">
									<input type="text" id="main-social-github" class="form-control" value="<?php echo (isset($main_maintenance_settings['social-github'])?$main_maintenance_settings['social-github']:''); ?>">
								</div>
							</div>
							<div class="form-group clearfix">
								<label for="pm-image-to-url" class="control-label col-md-3">Dribbble</label>
								<div class="input-wrapper col-md-9">
									<input type="text" id="main-social-dribbble" class="form-control" value="<?php echo (isset($main_maintenance_settings['social-dribbble'])?$main_maintenance_settings['social-dribbble']:''); ?>">
								</div>
							</div>
							<div class="form-group clearfix">
								<label for="pm-image-to-url" class="control-label col-md-3">Twitter</label>
								<div class="input-wrapper col-md-9">
									<input type="text" id="main-social-twitter" class="form-control" value="<?php echo (isset($main_maintenance_settings['social-twitter'])?$main_maintenance_settings['social-twitter']:''); ?>">
								</div>
							</div>
							<div class="form-group clearfix">
								<label for="pm-image-to-url" class="control-label col-md-3">Facebook</label>
								<div class="input-wrapper col-md-9">
									<input type="text" id="main-social-facebook" class="form-control" value="<?php echo (isset($main_maintenance_settings['social-facebook'])?$main_maintenance_settings['social-facebook']:''); ?>">
								</div>
							</div>
							<div class="form-group clearfix">
								<label for="pm-image-to-url" class="control-label col-md-3">Pinterest</label>
								<div class="input-wrapper col-md-9">
									<input type="text" id="main-social-pinterest" class="form-control" value="<?php echo (isset($main_maintenance_settings['social-pinterest'])?$main_maintenance_settings['social-pinterest']:''); ?>">
								</div>
							</div>
							<div class="form-group clearfix">
								<label for="pm-image-to-url" class="control-label col-md-3">Google+</label>
								<div class="input-wrapper col-md-9">
									<input type="text" id="main-social-gplus" class="form-control" value="<?php echo (isset($main_maintenance_settings['social-gplus'])?$main_maintenance_settings['social-gplus']:''); ?>">
								</div>
							</div>
							<div class="form-group clearfix">
								<label for="pm-image-to-url" class="control-label col-md-3">LinkedIn</label>
								<div class="input-wrapper col-md-9">
									<input type="text" id="main-social-linkedin" class="form-control" value="<?php echo (isset($main_maintenance_settings['social-linkedin'])?$main_maintenance_settings['social-linkedin']:''); ?>">
								</div>
							</div>
						</div>
					</div>
				</div>
			</div>
		</div>
		
	<?php
}

function main_get_content() {
	global $wpdb;

	// SETTINGS
	$main_maintenance_settings = (array)json_decode(get_option('main_maintenance_settings'));
	$main_template = (isset($main_maintenance_settings['template'])?$main_maintenance_settings['template']:'default');
	$template = $wpdb->get_results('SELECT template_html FROM '.$wpdb->prefix.'maintenance_plugin_templates WHERE template="' . $main_template . '"');

	$wp_scripts = new WP_Scripts();
	$jquery_src = ( !empty($wp_scripts->registered['jquery-core']) ? home_url($wp_scripts->registered['jquery-core']->src) : '//ajax.googleapis.com/ajax/libs/jquery/1.11.1/jquery.min.js' );

	if (
		$main_maintenance_settings['maintenance-status'] == 'true' &&
		!strstr($_SERVER['PHP_SELF'], 'wp-cron.php') &&
		!strstr($_SERVER['PHP_SELF'], 'wp-login.php') &&
		!strstr($_SERVER['PHP_SELF'], 'wp-admin/') &&
		!strstr($_SERVER['PHP_SELF'], 'async-upload.php') &&
		!strstr($_SERVER['PHP_SELF'], 'upgrade.php') &&
		!strstr($_SERVER['PHP_SELF'], '/plugins/') &&
		!strstr($_SERVER['PHP_SELF'], '/xmlrpc.php') &&
		!main_check_user_role() &&
		!main_check_exclude()
	) {
		// HEADER STUFF
		$protocol = !empty($_SERVER['SERVER_PROTOCOL']) && in_array($_SERVER['SERVER_PROTOCOL'], array('HTTP/1.1', 'HTTP/1.0')) ? $_SERVER['SERVER_PROTOCOL'] : 'HTTP/1.0';
		$charset = get_bloginfo('charset') ? get_bloginfo('charset') : 'UTF-8';

		nocache_headers();
		ob_start();
		header("Content-type: text/html; charset=$charset");
		header("$protocol 503 Service Unavailable", TRUE, 503);
		?>

		
		<link rel="stylesheet" id="maintenance-css" href="<?php echo plugin_dir_url( __FILE__ ).'/public/css/maitenance-functionality-public.css'; ?>" type="text/css" media="all">
		<link href='https://fonts.googleapis.com/css?family=Merriweather:300,400,700|Montserrat:300,400,700|Open+Sans:300,400,700|Roboto:300,400,700|Lato:300,400,700|Aldrich:400|Raleway:600|Iceberg:400' rel='stylesheet' type='text/css'>
		<?php do_action('main_maintenance_head'); ?>
		<?php
		?>
		<script src="<?php echo $jquery_src; ?>" type="text/javascript"></script>
		<script type="text/javascript">
			jQuery(document).ready(function($) {
				<?php if ( $main_maintenance_settings['background-blur'] == 'true' ) { ?>
					$(window).on("backstretch.after", function (e, instance, index) {
						jQuery('.backstretch').addClass('blurred');
					});
				<?php } ?>
				<?php if ( $main_maintenance_settings['google-analytics'] == 'true' ) {
					echo $main_maintenance_settings['google-analytics-code'];
				} ?>
			});
		</script>
		<?php if ( $main_maintenance_settings['background-image'] != '' ) { ?>
			<style type="text/css">body{background: url(<?php echo $main_maintenance_settings['background-image']; ?>) no-repeat;background-size:cover;background-position:center;}</style>
		<?php } ?>
		<?php do_action('main_maintenance_footer'); ?>
		<script type="text/preloaded" id="main-template-data"><?php main_get_template( $main_template ); ?></script>
		<script type="text/javascript">
		/* <![CDATA[ */
		var ajax_login_object = {"ajaxurl":"http:\/\/localhost\/clean\/wp-admin\/admin-ajax.php","redirecturl":"http:\/\/localhost\/snaptube","loadingmessage":"Sending user info, please wait...","registermessage":"A password will be emailed to you for future use"};
		/* ]]> */
		</script>
		<script src="<?php echo plugin_dir_url( __FILE__ ).'/public/js' ?>/maitenance-functionality-public.js" type="text/javascript"></script>
		<title><?php echo $main_maintenance_settings['page-title']; ?></title>
		<meta name="robots" content="<?php echo ($main_maintenance_settings['robots']=='noindex'?'noindex, nofollow':'index, follow'); ?>">
		<div class="maintenance-wrapper template-<?php echo (isset($main_maintenance_settings['template'])?$main_maintenance_settings['template']:'default')?>">
			<?php if ( isset($main_maintenance_settings['animation']) && $main_maintenance_settings['animation'] != 'none' ) { ?>
				<canvas id="main-animation-canvas"></canvas>
			<?php } ?>
			<?php main_prepare_html( $template['0'], $main_maintenance_settings ); ?>
			<?php if ( isset($main_maintenance_settings['maintenance-login']) && $main_maintenance_settings['maintenance-login'] == 'true' && !is_user_logged_in() ) { ?>
			<div class="main-maintenance-login">
				<h1><?php _e('Login', 'vh'); ?></h1>
				<span class="main-maintenance-login-open"></span>
				<?php wp_login_form( array('label_username'=>'Username', 'label_password'=>'Password') ); ?>
				<a href="<?php echo wp_lostpassword_url(); ?>" class="forgot_password"><?php _e( 'Forgot password', 'vh' ); ?></a>
			</div>
			<?php } ?>
		</div>
		<?php do_action('main_maintenance_video'); ?>

		<?php
		
		ob_flush();
		?>
		
		
		<?php
		exit();
	}	
}
add_action('init', 'main_get_content');

function main_check_search_bots() {
	$is_search_bots = false;

	$bots = apply_filters('wpmm_search_bots', array(
		'Abacho' => 'AbachoBOT',
		'Accoona' => 'Acoon',
		'AcoiRobot' => 'AcoiRobot',
		'Adidxbot' => 'adidxbot',
		'AltaVista robot' => 'Altavista',
		'Altavista robot' => 'Scooter',
		'ASPSeek' => 'ASPSeek',
		'Atomz' => 'Atomz',
		'Bing' => 'bingbot',
		'BingPreview' => 'BingPreview',
		'CrocCrawler' => 'CrocCrawler',
		'Dumbot' => 'Dumbot',
		'eStyle Bot' => 'eStyle',
		'FAST-WebCrawler' => 'FAST-WebCrawler',
		'GeonaBot' => 'GeonaBot',
		'Gigabot' => 'Gigabot',
		'Google' => 'Googlebot',
		'ID-Search Bot' => 'IDBot',
		'Lycos spider' => 'Lycos',
		'MSN' => 'msnbot',
		'MSRBOT' => 'MSRBOT',
		'Rambler' => 'Rambler',
		'Scrubby robot' => 'Scrubby',
		'Yahoo' => 'Yahoo'
	));

	$is_search_bots = (bool) preg_match('~(' . implode('|', array_values($bots)) . ')~i', $_SERVER['HTTP_USER_AGENT']);

	return $is_search_bots;
}

function main_check_user_role() {
	$user = wp_get_current_user();
	$is_allowed = false;
	$main_maintenance_settings = (array)json_decode(get_option('main_maintenance_settings'));

	// if ( is_super_admin() ) {
	// 	$is_allowed = true;
	// }

	if ( isset($main_maintenance_settings['access-by-role']) ) {
		$allowed = explode(',', $main_maintenance_settings['access-by-role']);
		if ( array_intersect($allowed, $user->roles ) ) {
			$is_allowed = true;
		}

		if ( $main_maintenance_settings['access-by-role'] == 'logged-in' && is_user_logged_in() ) {
			$is_allowed = true;
		}
	}

	return $is_allowed;
}

function main_check_exclude() {
	$is_excluded = false;
	$main_maintenance_settings = (array)json_decode(get_option('main_maintenance_settings'));

	if ( $main_maintenance_settings['exclude'] != '' ) {
		$excludes = explode('|', $main_maintenance_settings['exclude']);
		if ( isset($main_maintenance_settings['bypass-url']) && $main_maintenance_settings['bypass-url'] != '' ) {
			$excludes[] = $main_maintenance_settings['bypass-url'];
		}
		if ( !empty($excludes) ) {
			foreach ($excludes as $exclude_item) {
				if ((!empty($_SERVER['REMOTE_ADDR']) && strstr($_SERVER['REMOTE_ADDR'], $exclude_item)) || (!empty($_SERVER['REQUEST_URI']) && strstr($_SERVER['REQUEST_URI'], $exclude_item))) {
					$is_excluded = true;
					$main_maintenance_settings = (array)json_decode(get_option('main_maintenance_settings'));
					if ( $exclude_item == $main_maintenance_settings['bypass-url'] ) {
						$bypass_expire = ( isset($main_maintenance_settings['bypass-expires']) ? $main_maintenance_settings['bypass-expires'] : '172800' );
						setcookie('main_maintenance_bypass', 'bypass', time() + (int)$bypass_expire, '/', false);
					}
					break;
				}
			}
		}
	}
	if ( isset($main_maintenance_settings['bypass-url']) && $main_maintenance_settings['bypass-url'] != '' ) {
		$excludes = array( $main_maintenance_settings['bypass-url'] );
		if ( !empty($excludes) ) {
			foreach ($excludes as $exclude_item) {
				if ((!empty($_SERVER['REMOTE_ADDR']) && strstr($_SERVER['REMOTE_ADDR'], $exclude_item)) || (!empty($_SERVER['REQUEST_URI']) && strstr($_SERVER['REQUEST_URI'], $exclude_item))) {
					$is_excluded = true;
					$main_maintenance_settings = (array)json_decode(get_option('main_maintenance_settings'));
					$bypass_expire = ( isset($main_maintenance_settings['bypass-expires']) ? $main_maintenance_settings['bypass-expires'] : '172800' );
					setcookie('main_maintenance_bypass', 'bypass', time() + (int)$bypass_expire, '/', false);
					break;
				}
			}
		}
		if ( isset($_COOKIE['main_maintenance_bypass']) && $_COOKIE['main_maintenance_bypass'] == 'bypass' ) {
			$is_excluded = true;
		}
	}
	if ( isset($main_maintenance_settings['access-by-ip']) && $main_maintenance_settings['access-by-ip'] != '' ) {
		$exclude_ip = explode('|', $main_maintenance_settings['access-by-ip']);
		if ( !empty($exclude_ip) ) {
			foreach ($exclude_ip as $ip_value) {
				if ( !empty($_SERVER['REMOTE_ADDR']) && strstr($_SERVER['REMOTE_ADDR'], $ip_value) ) {
					$is_excluded = true;
					break;
				}
			}
		}
	}

	return $is_excluded;
}

function main_save_maintenance() {
	$main_settings = ( isset($_POST['main_settings']) ? str_replace('\\', '', $_POST['main_settings']) : '' );
	update_option( 'main_maintenance_settings', $main_settings );

	die(0);
}
add_action( 'wp_ajax_nopriv_main_save_maintenance_settings', 'main_save_maintenance' );
add_action( 'wp_ajax_main_save_maintenance_settings', 'main_save_maintenance' );

function sample_admin_notice__success() {
	$user = wp_get_current_user();
	?>
	<div class="main-maintenance-notice">
		<span class="main-notice-left">
			<img src="<?php echo maitenance_PLUGIN_URI; ?>admin/images/logo-square.png" alt="">
		</span>
		<div class="main-notice-center">
			<p>Hi there, <?php echo $user->data->display_name; ?>, we noticed that you've been using our Maintenance mode plugin for a while now.</p>
			<p>We spent many hours developing this free plugin for you and we would appriciate if you supported us by rating our plugin!</p>
		</div>
		<div class="main-notice-right">
			<a href="#" class="button button-primary button-large main-maintenance-rate">Rate at WordPress</a>
			<a href="javascript:void(0)" class="button button-large preview main-maintenance-dismiss">No, thanks</a>
		</div>
		<div class="clearfix"></div>
	</div>
	<?php
}
if ( get_option('main_maintenance_rating_notice') != 'hide' && time() - get_option('main_maintenance_rating_notice') > 432000 ) {
	add_action( 'admin_notices', 'sample_admin_notice__success' );
}

function main_dismiss_maintenance_notice() {
	update_option('main_maintenance_rating_notice', 'hide');

	die(0);
}
add_action( 'wp_ajax_nopriv_main_dismiss_notice', 'main_dismiss_maintenance_notice' );
add_action( 'wp_ajax_main_dismiss_notice', 'main_dismiss_maintenance_notice' );

function main_get_template( $template ) {
	// SETTINGS
	$main_maintenance_settings = (array)json_decode(get_option('main_maintenance_settings'));

	// switch ( $template ) {
	// 	case 'default':
			$output = array(
				'texts' => array(
					'title' => $main_maintenance_settings['page-headline'],
					'description' => $main_maintenance_settings['page-description']
					),
				'styles' => array(
					'title' => $main_maintenance_settings['page-headline-style'],
					'description' => $main_maintenance_settings['page-description-style']
					)
			);
	// 		break;
	// }

	echo json_encode( $output );
}

function main_get_logo( $main_maintenance_settings ) {
	$output = '';
	if ( $main_maintenance_settings['maintenance-logo'] ) {
		$logo_size_html = '';
		if ( $main_maintenance_settings['maintenance-retina'] == 'true' ) {
			$logo_size = getimagesize( $main_maintenance_settings['maintenance-logo'] );
			$logo_size_html = ' style="height: ' . ($logo_size[1] / 2) . 'px;" height="' . ($logo_size[1] / 2) . '"';
		}

		$output .= '
		<div class="maintenance-logo-wrapper">
			<img src="' . $main_maintenance_settings['maintenance-logo'] . '" alt="logo" id="maintenance-logo" ' . $logo_size_html . '>
		</div>';
	}
	return $output;
}

function main_get_social( $main_maintenance_settings ) {
	$output = '';
	if ( $main_maintenance_settings['social-networks'] == 'true' ) {
	$output .= '
	<div class="maintenance-buttons">';
		if ( $main_maintenance_settings['social-github'] ) {
			$output .= '<a href="' . $main_maintenance_settings['social-github'] . '" class="social-icons icon-github" ' . ($main_maintenance_settings['social-target']=='new'?'target="_blank"':'') . '></a>';
		}
		if ( $main_maintenance_settings['social-dribbble'] ) {
			$output .= '<a href="' . $main_maintenance_settings['social-dribbble'] . '" class="social-icons icon-dribbble" ' . ($main_maintenance_settings['social-target']=='new'?'target="_blank"':'') . '></a>';
		}
		if ( $main_maintenance_settings['social-twitter'] ) {
			$output .= '<a href="' . $main_maintenance_settings['social-twitter'] . '" class="social-icons icon-twitter" ' . ($main_maintenance_settings['social-target']=='new'?'target="_blank"':'') . '></a>';
		}
		if ( $main_maintenance_settings['social-facebook'] ) {
			$output .= '<a href="' . $main_maintenance_settings['social-facebook'] . '" class="social-icons icon-facebook" ' . ($main_maintenance_settings['social-target']=='new'?'target="_blank"':'') . '></a>';
		}
		if ( $main_maintenance_settings['social-pinterest'] ) {
			$output .= '<a href="' . $main_maintenance_settings['social-pinterest'] . '" class="social-icons icon-pinterest-circled" ' . ($main_maintenance_settings['social-target']=='new'?'target="_blank"':'') . '></a>';
		}
		if ( $main_maintenance_settings['social-gplus'] ) {
			$output .= '<a href="' . $main_maintenance_settings['social-gplus'] . '" class="social-icons icon-gplus" ' . ($main_maintenance_settings['social-target']=='new'?'target="_blank"':'') . '></a>';
		}
		if ( $main_maintenance_settings['social-linkedin'] ) {
			$output .= '<a href="' . $main_maintenance_settings['social-linkedin'] . '" class="social-icons icon-linkedin-squared" ' . ($main_maintenance_settings['social-target']=='new'?'target="_blank"':'') . '></a>';
		}
	$output .= '</div>';
	}
	return $output;
}

function main_get_countdown( $main_maintenance_settings ) {
	$output = '';
	if ( isset($main_maintenance_settings['countdown']) && $main_maintenance_settings['countdown'] != '' ) {
		$output .= '<div id="main-clock"></div>';
	}
	return $output;
}

function main_get_mailchimp( $main_maintenance_settings ) {
	$output = '';
	if ( isset($main_maintenance_settings['mailchimp']) && $main_maintenance_settings['mailchimp'] != '' ) {
		$output .= '<div class="main-mailchimp-wrapper">' . $main_maintenance_settings['mailchimp'] . '</div>';
	}
	return $output;
}

function main_prepare_html( $template, $settings ) {
	$output = str_replace('{main_maintenance_logo}', main_get_logo( $settings ), $template->template_html);
	$output = str_replace('{main_maintenance_countdown}', main_get_countdown( $settings ), $output);
	$output = str_replace('{main_maintenance_social}', main_get_social( $settings ), $output);
	$output = str_replace('{main_maintenance_mailchimp}', main_get_mailchimp( $settings ), $output);
	
	echo $output;
}

function main_ajax_login() {

	// First check the nonce, if it fails the function will break
	check_ajax_referer( 'ajax-login-nonce', 'security' );

	// Nonce is checked, get the POST data and sign user on
	$info                  = array();
	$info['user_login']    = $_POST['username'];
	$info['user_password'] = $_POST['password'];
	$info['remember']      = true;

	$user_signon = wp_signon( $info, false );
	if ( is_wp_error($user_signon) ){
		echo json_encode(array('loggedin' => false, 'message' => __('Wrong username or password.', 'vh')));
	} else {
		echo json_encode(array('loggedin' => true, 'message' => __('Login successful, redirecting...', 'vh')));
	}

	die(1);
}
if ( isset($_POST['action']) && $_POST['action'] == 'ajaxlogin' ) {
	main_ajax_login();
}
// add_action( 'wp_ajax_nopriv_ajaxlogin', 'main_ajax_login' );
// add_action( 'wp_ajax_ajaxlogin', 'main_ajax_login' );