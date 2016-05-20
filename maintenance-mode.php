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
							<h3>Maintenance configuration</h3>
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
									<textarea id="main-exclude" class="form-control"><?php echo (isset($main_maintenance_settings['exclude']) && $main_maintenance_settings['exclude'] != ''?str_replace('|', PHP_EOL, $main_maintenance_settings['exclude']):''); ?></textarea>
									<p class="text-muted m-b-30 font-13">You're able to exclude feeds, pages or IPs from maintenance mode. Add one exclude option per line!</p>
								</div>
							</div>
							<div class="">
								<h5><b>Google analytics</b></h5>
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
									<label for="pm-image-to-url" class="control-label col-md-3">Tracking code</label>
									<div class="input-wrapper col-md-9">
										<textarea id="main-google-analytics-code" class="form-control"><?php echo (isset($main_maintenance_settings['google-analytics-code']) && $main_maintenance_settings['google-analytics-code'] != '' ? $main_maintenance_settings['google-analytics-code'] : ''); ?></textarea>
									</div>
								</div>
							</div>
						</div>
						<div class="white-box">
							<h3>Maintenance texts</h3>
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
							<div class="form-group text-styling-row">
								<input type="hidden" id="main-edited-text" value="">
								<div class="col-md-3">
									<h5>Text color</h5>
									<input type="number" id="main-color" class="text-styling wp-colorpicker" value="">
								</div>
								<div class="col-md-3">
									<h5>Text size</h5>
									<div class="main-number-field">
										<span class="main-number-minus">-</span>
										<input type="number" id="main-font-size" class="form-control text-styling" value="">
										<span class="main-number-plus">+</span>
									</div>
								</div>
								<div class="col-md-3">
									<h5>Text line height</h5>
									<div class="main-number-field">
										<span class="main-number-minus">-</span>
										<input type="number" id="main-line-height" class="form-control text-styling" value="">
										<span class="main-number-plus">+</span>
									</div>
								</div>
								<div class="col-md-3">
									<h5>Text style</h5>
									<select id="main-font-style" class="form-control text-styling">
										<option value="normal">Normal</option>
										<option value="italic">Italic</option>
									</select>
								</div>
								<div class="clearfix"></div>
							</div>
						</div>
					</div>
					<div class="col-sm-6">
						<div class="white-box">
							<h3>Maintenance mode looks</h3>
							<p class="text-muted m-b-30 font-13">Here you'll be able to change what appears on your front page.</p>
							<?php do_action('main_maintenance_looks_top'); ?>
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
							<div class="form-group clearfix">
								<h5><b>Social networks</b></h5>
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
							<?php do_action('main_maintenance_looks_bottom'); ?>
						</div>
					</div>
				</div>
			</div>
		</div>
		
	<?php
}

function main_get_content() {
	// SETTINGS
	$main_maintenance_settings = (array)json_decode(get_option('main_maintenance_settings'));

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

		<script src="//ajax.googleapis.com/ajax/libs/jquery/1.11.1/jquery.min.js" type="text/javascript"></script>
		<script src="<?php echo plugin_dir_url( __FILE__ ).'/public/js' ?>/jquery.backstretch.min.js" type="text/javascript"></script>
		<?php do_action('main_maintenance_head'); ?>
		<script type="text/javascript">
			jQuery(document).ready(function($) {
				$.backstretch("<?php echo $main_maintenance_settings['background-image']; ?>");
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
		<link rel="stylesheet" id="maintenance-css" href="<?php echo plugin_dir_url( __FILE__ ).'/public/css/maitenance-functionality-public.css'; ?>" type="text/css" media="all">
		<link href='https://fonts.googleapis.com/css?family=Merriweather:400|Montserrat:300,400,700' rel='stylesheet' type='text/css'>
		<title><?php echo $main_maintenance_settings['page-title']; ?></title>
		<meta name="robots" content="<?php echo ($main_maintenance_settings['robots']=='noindex'?'noindex, nofollow':'index, follow'); ?>">
		<div class="maintenance-wrapper">
			<?php if ( $main_maintenance_settings['maintenance-logo'] ) {
				$logo_size_html = '';
				if ( $main_maintenance_settings['maintenance-retina'] == 'true' ) {
					$logo_size = getimagesize( $main_maintenance_settings['maintenance-logo'] );
					$logo_size_html = ' style="height: ' . ($logo_size[1] / 2) . 'px;" height="' . ($logo_size[1] / 2) . '"';
				} ?>
				<div class="maintenance-logo-wrapper">
					<img src="<?php echo $main_maintenance_settings['maintenance-logo']; ?>" alt="logo" id="maintenance-logo"<?php echo $logo_size_html; ?>>
				</div>
			<?php } ?>
			<div class="maintenance-inner">
				<div class="maintenance-title" style="<?php echo $main_maintenance_settings['page-headline-style']; ?>"><?php echo $main_maintenance_settings['page-headline']; ?></div>
				<?php if ( isset($main_maintenance_settings['countdown']) && $main_maintenance_settings['countdown'] != '' ) { ?>
					<div id="main-clock"></div>
				<?php } ?>
				<p class="maintenance-description" style="<?php echo $main_maintenance_settings['page-description-style']; ?>"><?php echo $main_maintenance_settings['page-description']; ?></p>
				<?php if ( $main_maintenance_settings['social-networks'] == 'true' ) { ?>
				<div class="maintenance-buttons">
					<?php if ( $main_maintenance_settings['social-github'] ) { ?>
						<a href="<?php echo $main_maintenance_settings['social-github']; ?>" class="social-icons icon-github" <?php echo ($main_maintenance_settings['social-target']=='new'?'target="_blank"':'') ?>></a>
					<?php } ?>
					<?php if ( $main_maintenance_settings['social-dribbble'] ) { ?>
						<a href="<?php echo $main_maintenance_settings['social-dribbble']; ?>" class="social-icons icon-dribbble" <?php echo ($main_maintenance_settings['social-target']=='new'?'target="_blank"':'') ?>></a>
					<?php } ?>
					<?php if ( $main_maintenance_settings['social-twitter'] ) { ?>
						<a href="<?php echo $main_maintenance_settings['social-twitter']; ?>" class="social-icons icon-twitter" <?php echo ($main_maintenance_settings['social-target']=='new'?'target="_blank"':'') ?>></a>
					<?php } ?>
					<?php if ( $main_maintenance_settings['social-facebook'] ) { ?>
						<a href="<?php echo $main_maintenance_settings['social-facebook']; ?>" class="social-icons icon-facebook" <?php echo ($main_maintenance_settings['social-target']=='new'?'target="_blank"':'') ?>></a>
					<?php } ?>
					<?php if ( $main_maintenance_settings['social-pinterest'] ) { ?>
						<a href="<?php echo $main_maintenance_settings['social-pinterest']; ?>" class="social-icons icon-pinterest-circled" <?php echo ($main_maintenance_settings['social-target']=='new'?'target="_blank"':'') ?>></a>
					<?php } ?>
					<?php if ( $main_maintenance_settings['social-gplus'] ) { ?>
						<a href="<?php echo $main_maintenance_settings['social-gplus']; ?>" class="social-icons icon-gplus" <?php echo ($main_maintenance_settings['social-target']=='new'?'target="_blank"':'') ?>></a>
					<?php } ?>
					<?php if ( $main_maintenance_settings['social-linkedin'] ) { ?>
						<a href="<?php echo $main_maintenance_settings['social-linkedin']; ?>" class="social-icons icon-linkedin-squared" <?php echo ($main_maintenance_settings['social-target']=='new'?'target="_blank"':'') ?>></a>
					<?php } ?>
				</div>
				<?php if ( isset($main_maintenance_settings['mailchimp']) && $main_maintenance_settings['mailchimp'] != '' ) {
					echo '<div class="main-mailchimp-wrapper">' . $main_maintenance_settings['mailchimp'] . '</div>';
				} ?>
				<?php } ?>
			</div>
		</div>
		<?php do_action('main_maintenance_video'); ?>

		<?php
		ob_flush();

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
	$is_allowed = false;

	// if (is_super_admin()) {
	// 	$is_allowed = true;
	// }

	// if (current_user_can('manage_options')) {
	// 	$is_allowed = true;
	// }

	return $is_allowed;
}

function main_check_exclude() {
	$is_excluded = false;
	$main_maintenance_settings = (array)json_decode(get_option('main_maintenance_settings'));

	if ( $main_maintenance_settings['exclude'] ) {
		$excludes = explode('|', $main_maintenance_settings['exclude']);
		if ( !empty($excludes) ) {
			foreach ($excludes as $exclude_item) {
				if ((!empty($_SERVER['REMOTE_ADDR']) && strstr($_SERVER['REMOTE_ADDR'], $exclude_item)) || (!empty($_SERVER['REQUEST_URI']) && strstr($_SERVER['REQUEST_URI'], $exclude_item))) {
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