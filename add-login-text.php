<?php
/*
Plugin Name: Add Login Text
Plugin URI: http://www.jimmyscode.com/wordpress/add-login-text/
Description: Add text to the WordPress login screen.
Version: 0.0.6
Author: Jimmy Pe&ntilde;a
Author URI: http://www.jimmyscode.com/
License: GPLv2 or later
*/

	define('ALT_PLUGIN_NAME', 'Add Login Text');
	// plugin constants
	define('ALT_VERSION', '0.0.6');
	define('ALT_SLUG', 'add-login-text');
	define('ALT_LOCAL', 'altlt');
	define('ALT_OPTION', 'altlt');
	define('ALT_OPTIONS_NAME', 'altlt_options');
	define('ALT_PERMISSIONS_LEVEL', 'manage_options');
	define('ALT_PATH', plugin_basename(dirname(__FILE__)));
	/* default values */
	define('ALT_DEFAULT_ENABLED', true);
	define('ALT_DEFAULT_TEXT', '');
	/* option array member names */
	define('ALT_DEFAULT_ENABLED_NAME', 'enabled');
	define('ALT_DEFAULT_TEXT_NAME', 'texttoadd');
	
	// oh no you don't
	if (!defined('ABSPATH')) {
		wp_die(__('Do not access this file directly.', alt_get_local()));
	}

	// localization to allow for translations
	add_action('init', 'ALT_translation_file');
	function ALT_translation_file() {
		$plugin_path = alt_get_path() . '/translations';
		load_plugin_textdomain(alt_get_local(), '', $plugin_path);
	}
	// tell WP that we are going to use new options
	// also, register the admin CSS file for later inclusion
	add_action('admin_init', 'ALT_options_init');
	function ALT_options_init() {
		register_setting(ALT_OPTIONS_NAME, alt_get_option(), 'ALT_validation');
		register_ALT_admin_style();
	}
	// validation function
	function ALT_validation($input) {
		// sanitize textarea
		if (!empty($input)) {
			$input[ALT_DEFAULT_TEXT_NAME] = wp_kses_post(force_balance_tags($input[ALT_DEFAULT_TEXT_NAME]));
		}
		return $input;
	} 

	// add Settings sub-menu
	add_action('admin_menu', 'ALT_plugin_menu');
	function ALT_plugin_menu() {
		add_options_page(ALT_PLUGIN_NAME, ALT_PLUGIN_NAME, ALT_PERMISSIONS_LEVEL, alt_get_slug(), 'ALT_page');
	}
	// plugin settings page
	// http://planetozh.com/blog/2009/05/handling-plugins-options-in-wordpress-28-with-register_setting/
	function ALT_page() {
		// check perms
		if (!current_user_can(ALT_PERMISSIONS_LEVEL)) {
			wp_die(__('You do not have sufficient permission to access this page', alt_get_local()));
		}
		?>
		<div class="wrap">
			<h2 id="plugintitle"><img src="<?php echo plugins_url(alt_get_path() . '/images/login.png'); ?>" title="" alt="" height="64" width="64" align="absmiddle" /> <?php echo ALT_PLUGIN_NAME; _e(' by ', alt_get_local()); ?><a href="http://www.jimmyscode.com/">Jimmy Pe&ntilde;a</a></h2>
			<div><?php _e('You are running plugin version', alt_get_local()); ?> <strong><?php echo ALT_VERSION; ?></strong>.</div>

			<?php /* http://code.tutsplus.com/tutorials/the-complete-guide-to-the-wordpress-settings-api-part-5-tabbed-navigation-for-your-settings-page--wp-24971 */ ?>
			<?php $active_tab = (!empty($_GET['tab']) ? $_GET['tab'] : 'settings'); ?>
			<h2 class="nav-tab-wrapper">
			  <a href="?page=<?php echo alt_get_slug(); ?>&tab=settings" class="nav-tab <?php echo $active_tab == 'settings' ? 'nav-tab-active' : ''; ?>"><?php _e('Settings', alt_get_local()); ?></a>
				<a href="?page=<?php echo alt_get_slug(); ?>&tab=support" class="nav-tab <?php echo $active_tab == 'support' ? 'nav-tab-active' : ''; ?>"><?php _e('Support', alt_get_local()); ?></a>
			</h2>

			<form method="post" action="options.php">
				<?php settings_fields(ALT_OPTIONS_NAME); ?>
				<?php $options = alt_getpluginoptions(); ?>
				<?php update_option(alt_get_option(), $options); ?>
				<?php if ($active_tab == 'settings') { ?>
					<h3 id="settings"><img src="<?php echo plugins_url(alt_get_path() . '/images/settings.png'); ?>" title="" alt="" height="61" width="64" align="absmiddle" /> <?php _e('Plugin Settings', alt_get_local()); ?></h3>
					<table class="form-table" id="theme-options-wrap">
						<tr valign="top"><th scope="row"><strong><label title="<?php _e('Is plugin enabled? Uncheck this to turn it off temporarily.', alt_get_local()); ?>" for="<?php echo alt_get_option(); ?>[<?php echo ALT_DEFAULT_ENABLED_NAME; ?>]"><?php _e('Plugin enabled?', alt_get_local()); ?></label></strong></th>
							<td><input type="checkbox" id="<?php echo alt_get_option(); ?>[<?php echo ALT_DEFAULT_ENABLED_NAME; ?>]" name="<?php echo alt_get_option(); ?>[<?php echo ALT_DEFAULT_ENABLED_NAME; ?>]" value="1" <?php checked('1', $options[ALT_DEFAULT_ENABLED_NAME]); ?> /></td>
						</tr>
						<tr valign="top"><td colspan="2"><?php _e('Is plugin enabled? Uncheck this to turn it off temporarily.', alt_get_local()); ?></td></tr>
						<tr valign="top"><th scope="row"><strong><label title="<?php _e('Enter custom login text', alt_get_local()); ?>" for="<?php echo alt_get_option(); ?>[<?php echo ALT_DEFAULT_TEXT_NAME; ?>]"><?php _e('Enter custom login text', alt_get_local()); ?></label></strong></th>
							<td><textarea rows="12" cols="75" id="<?php echo alt_get_option(); ?>[<?php echo ALT_DEFAULT_TEXT_NAME; ?>]" name="<?php echo alt_get_option(); ?>[<?php echo ALT_DEFAULT_TEXT_NAME; ?>]"><?php echo $options[ALT_DEFAULT_TEXT_NAME]; ?></textarea></td>
						</tr>
						<tr valign="top"><td colspan="2"><?php _e('Type the custom text you want to display on the admin login screen. HTML allowed.', alt_get_local()); ?></td></tr>
					</table>
					<?php submit_button(); ?>
				<?php } else { ?>
					<h3 id="support"><img src="<?php echo plugins_url(alt_get_path() . '/images/support.png'); ?>" title="" alt="" height="64" width="64" align="absmiddle" /> <?php _e('Support', alt_get_local()); ?></h3>
					<div class="support">
						<?php echo alt_getsupportinfo(alt_get_slug(), alt_get_local()); ?>
					</div>
				<?php } ?>
			</form>
		</div>
		<?php }

	// main function and filter
	add_filter('login_message', 'alt_login_message');
	function alt_login_message($default) {
		$options = alt_getpluginoptions();
		if (!empty($options)) {
			$enabled = (bool)$options[ALT_DEFAULT_ENABLED_NAME];
		} else {
			$enabled = ALT_DEFAULT_ENABLED;
		}
		if ($enabled) {
			if (!empty($options)) {
				$tta = $options[ALT_DEFAULT_TEXT_NAME];
			} else {
				$tta = ALT_DEFAULT_TEXT;
			}
			if ($tta !== ALT_DEFAULT_TEXT) {
				return '<div class="alt-login-text">' . $tta . '</div>';
			} else { // plugin enabled but nothing entered?
				return $default;
			}
		} else { // plugin disabled, show whatever was there before
			return $default;
		}
	}
	
	// show admin messages to plugin user
	add_action('admin_notices', 'alt_showAdminMessages');
	function alt_showAdminMessages() {
		// http://wptheming.com/2011/08/admin-notices-in-wordpress/
		global $pagenow;
		if (current_user_can(ALT_PERMISSIONS_LEVEL)) { // user has privilege
			if ($pagenow == 'options-general.php') { // we are on Settings menu
				if (!empty($_GET['page'])) {
					if ($_GET['page'] == alt_get_slug()) { // we are on this plugin's settings page
						$options = alt_getpluginoptions();
						if (!empty($options)) {
							$enabled = (bool)$options[ALT_DEFAULT_ENABLED_NAME];
							if (!$enabled) {
								echo '<div id="message" class="error">' . ALT_PLUGIN_NAME . ' ' . __('is currently disabled.', alt_get_local()) . '</div>';
							}
						}
					}
				}
			} // end page check
		} // end privilege check
	} // end admin msgs function
	// enqueue admin CSS if we are on the plugin options page
	add_action('admin_head', 'insert_alt_admin_css');
	function insert_alt_admin_css() {
		global $pagenow;
		if (current_user_can(ALT_PERMISSIONS_LEVEL)) { // user has privilege
			if ($pagenow == 'options-general.php') { // we are on Settings menu
				if (!empty($_GET['page'])) {
					if ($_GET['page'] == alt_get_slug()) { // we are on this plugin's settings page
						alt_admin_styles();
					}
				}
			}
		}
	}
	// add helpful links to plugin page next to plugin name
	// http://bavotasan.com/2009/a-settings-link-for-your-wordpress-plugins/
	// http://wpengineer.com/1295/meta-links-for-wordpress-plugins/
	add_filter('plugin_action_links_' . plugin_basename(__FILE__), 'alt_plugin_settings_link');
	add_filter('plugin_row_meta', 'alt_meta_links', 10, 2);
	
	function alt_plugin_settings_link($links) {
		return alt_settingslink($links, alt_get_slug(), alt_get_local());
	}
	function alt_meta_links($links, $file) {
		if ($file == plugin_basename(__FILE__)) {
			$links = array_merge($links,
			array(
				sprintf(__('<a href="http://wordpress.org/support/plugin/%s">Support</a>', alt_get_local()), alt_get_slug()),
				sprintf(__('<a href="http://wordpress.org/extend/plugins/%s/">Documentation</a>', alt_get_local()), alt_get_slug()),
				sprintf(__('<a href="http://wordpress.org/plugins/%s/faq/">FAQ</a>', alt_get_local()), alt_get_slug())
			));
		}
		return $links;	
	}
	// enqueue/register the admin CSS file
	function alt_admin_styles() {
		wp_enqueue_style('alt_admin_style');
	}
	function register_alt_admin_style() {
		wp_register_style('alt_admin_style',
			plugins_url(alt_get_path() . '/css/admin.css'),
			array(),
			ALT_VERSION . "_" . date('njYHis', filemtime(dirname(__FILE__) . '/css/admin.css')),
			'all');
	}
	// when plugin is activated, create options array and populate with defaults
	register_activation_hook(__FILE__, 'alt_activate');
	function alt_activate() {
		$options = alt_getpluginoptions();
		update_option(alt_get_option(), $options);

		// delete option when plugin is uninstalled
		register_uninstall_hook(__FILE__, 'uninstall_ALT_plugin');
	}
	function uninstall_ALT_plugin() {
		delete_option(alt_get_option());
	}
		
	// generic function that returns plugin options from DB
	// if option does not exist, returns plugin defaults
	function alt_getpluginoptions() {
		return get_option(alt_get_option(), 
			array(
				ALT_DEFAULT_ENABLED_NAME => ALT_DEFAULT_ENABLED, 
				ALT_DEFAULT_TEXT_NAME => ALT_DEFAULT_TEXT
			));
	}

	function alt_settingslink($linklist, $slugname = '', $localname = '') {
		$settings_link = sprintf( __('<a href="options-general.php?page=%s">Settings</a>', $localname), $slugname);
		array_unshift($linklist, $settings_link);
		return $linklist;
	}
	// encapsulate these and call them throughout the plugin instead of hardcoding the constants everywhere
	function alt_get_slug() { return ALT_SLUG; }
	function alt_get_local() { return ALT_LOCAL; }
	function alt_get_option() { return ALT_OPTION; }
	function alt_get_path() { return ALT_PATH; }
	
	function alt_getsupportinfo($slugname = '', $localname = '') {
		$output = __('Do you need help with this plugin? Check out the following resources:', $localname);
		$output .= '<ol>';
		$output .= '<li>' . sprintf( __('<a href="http://wordpress.org/extend/plugins/%s/">Documentation</a>', $localname), $slugname) . '</li>';
		$output .= '<li>' . sprintf( __('<a href="http://wordpress.org/plugins/%s/faq/">FAQ</a><br />', $localname), $slugname) . '</li>';
		$output .= '<li>' . sprintf( __('<a href="http://wordpress.org/support/plugin/%s">Support Forum</a><br />', $localname), $slugname) . '</li>';
		$output .= '<li>' . sprintf( __('<a href="http://www.jimmyscode.com/wordpress/%s">Plugin Homepage / Demo</a><br />', $localname), $slugname) . '</li>';
		$output .= '<li>' . sprintf( __('<a href="http://wordpress.org/extend/plugins/%s/developers/">Development</a><br />', $localname), $slugname) . '</li>';
		$output .= '<li>' . sprintf( __('<a href="http://wordpress.org/plugins/%s/changelog/">Changelog</a><br />', $localname), $slugname) . '</li>';
		$output .= '</ol>';
		
		$output .= sprintf( __('If you like this plugin, please <a href="http://wordpress.org/support/view/plugin-reviews/%s/">rate it on WordPress.org</a>', $localname), $slugname);
		$output .= sprintf( __(' and click the <a href="http://wordpress.org/plugins/%s/#compatibility">Works</a> button. ', $localname), $slugname);
		$output .= '<br /><br /><br />';
		$output .= __('Your donations encourage further development and support. ', $localname);
		$output .= '<a href="https://www.paypal.com/cgi-bin/webscr?cmd=_s-xclick&hosted_button_id=7EX9NB9TLFHVW"><img src="https://www.paypalobjects.com/en_US/i/btn/btn_donate_LG.gif" alt="Donate with PayPal" title="Support this plugin" width="92" height="26" /></a>';
		$output .= '<br /><br />';
		return $output;
	}
?>