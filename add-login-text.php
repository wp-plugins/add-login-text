<?php
/*
Plugin Name: Add Login Text
Plugin URI: http://www.jimmyscode.com/wordpress/add-login-text/
Description: Add text to the WordPress login screen.
Version: 0.0.3
Author: Jimmy Pe&ntilde;a
Author URI: http://www.jimmyscode.com/
License: GPLv2 or later
*/

	define('ALT_PLUGIN_NAME', 'Add Login Text');
	// plugin constants
	define('ALT_VERSION', '0.0.3');
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
		wp_die(__('Do not access this file directly.', ALT_LOCAL));
	}

	// delete option when plugin is uninstalled
	register_uninstall_hook(__FILE__, 'uninstall_ALT_plugin');
	function uninstall_ALT_plugin() {
		delete_option(ALT_OPTION);
	}
	// localization to allow for translations
	add_action('init', 'ALT_translation_file');
	function ALT_translation_file() {
		$plugin_path = plugin_basename(dirname(__FILE__) . '/translations');
		load_plugin_textdomain(ALT_LOCAL, '', $plugin_path);
	}
	// tell WP that we are going to use new options
	// also, register the admin CSS file for later inclusion
	add_action('admin_init', 'ALT_options_init');
	function ALT_options_init() {
		register_setting(ALT_OPTIONS_NAME, ALT_OPTION, 'ALT_validation');
		register_ALT_admin_style();
	}
	// validation function
	function ALT_validation($input) {
		// sanitize textarea
		$input[ALT_DEFAULT_TEXT_NAME] = wp_kses_post(force_balance_tags($input[ALT_DEFAULT_TEXT_NAME]));
		return $input;
	} 

	// add Settings sub-menu
	add_action('admin_menu', 'ALT_plugin_menu');
	function ALT_plugin_menu() {
		add_options_page(ALT_PLUGIN_NAME, ALT_PLUGIN_NAME, ALT_PERMISSIONS_LEVEL, ALT_SLUG, 'ALT_page');
	}
	// plugin settings page
	// http://planetozh.com/blog/2009/05/handling-plugins-options-in-wordpress-28-with-register_setting/
	function ALT_page() {
		// check perms
		if (!current_user_can(ALT_PERMISSIONS_LEVEL)) {
			wp_die(__('You do not have sufficient permission to access this page', ALT_LOCAL));
		}
		?>
		<div class="wrap">
			<h2 id="plugintitle"><img src="<?php echo plugins_url(plugin_basename(dirname(__FILE__) . '/images/login.png')) ?>" title="" alt="" height="64" width="64" align="absmiddle" /> <?php echo ALT_PLUGIN_NAME; _e(' by ', ALT_LOCAL); ?><a href="http://www.jimmyscode.com/">Jimmy Pe&ntilde;a</a></h2>
			<div><?php _e('You are running plugin version', ALT_LOCAL); ?> <strong><?php echo ALT_VERSION; ?></strong>.</div>
			<form method="post" action="options.php">
			<?php settings_fields(ALT_OPTIONS_NAME); ?>
			<?php $options = alt_getpluginoptions(); ?>
			<?php update_option(ALT_OPTION, $options); ?>
			<h3 id="settings"><img src="<?php echo plugins_url(plugin_basename(dirname(__FILE__) . '/images/settings.png')) ?>" title="" alt="" height="61" width="64" align="absmiddle" /> <?php _e('Plugin Settings', ALT_LOCAL); ?></h3>
				<?php submit_button(); ?>

				<table class="form-table" id="theme-options-wrap">
					<tr valign="top"><th scope="row"><strong><label title="<?php _e('Is plugin enabled? Uncheck this to turn it off temporarily.', ALT_LOCAL); ?>" for="<?php echo ALT_OPTION; ?>[<?php echo ALT_DEFAULT_ENABLED_NAME; ?>]"><?php _e('Plugin enabled?', ALT_LOCAL); ?></label></strong></th>
						<td><input type="checkbox" id="<?php echo ALT_OPTION; ?>[<?php echo ALT_DEFAULT_ENABLED_NAME; ?>]" name="<?php echo ALT_OPTION; ?>[<?php echo ALT_DEFAULT_ENABLED_NAME; ?>]" value="1" <?php checked('1', $options[ALT_DEFAULT_ENABLED_NAME]); ?> /></td>
					</tr>
					<tr valign="top"><td colspan="2"><?php _e('Is plugin enabled? Uncheck this to turn it off temporarily.', ALT_LOCAL); ?></td></tr>
					
					<tr valign="top"><th scope="row"><strong><label title="<?php _e('Enter custom login text', ALT_LOCAL); ?>" for="<?php echo ALT_OPTION; ?>[<?php echo ALT_DEFAULT_TEXT_NAME; ?>]"><?php _e('Enter custom login text', ALT_LOCAL); ?></label></strong></th>
						<td><textarea rows="12" cols="75" id="<?php echo ALT_OPTION; ?>[<?php echo ALT_DEFAULT_TEXT_NAME; ?>]" name="<?php echo ALT_OPTION; ?>[<?php echo ALT_DEFAULT_TEXT_NAME; ?>]"><?php echo $options[ALT_DEFAULT_TEXT_NAME]; ?></textarea></td>
					</tr>
					<tr valign="top"><td colspan="2"><?php _e('Type the custom text you want to display on the admin login screen. HTML allowed.', ALT_LOCAL); ?></td></tr>
				</table>

				<?php submit_button(); ?>
			</form>
			<hr />
			<h3 id="support"><img src="<?php echo plugins_url(plugin_basename(dirname(__FILE__) . '/images/support.png')) ?>" title="" alt="" height="64" width="64" align="absmiddle" /> Support</h3>
				<div class="support">
				<?php echo '<a href="http://wordpress.org/extend/plugins/' . ALT_SLUG . '/">' . __('Documentation', ALT_LOCAL) . '</a> | ';
					echo '<a href="http://wordpress.org/plugins/' . ALT_SLUG . '/faq/">' . __('FAQ', ALT_LOCAL) . '</a><br />';
					_e('If you like this plugin, please ', ALT_LOCAL);
					echo '<a href="http://wordpress.org/support/view/plugin-reviews/' . ALT_SLUG . '/">';
					_e('rate it on WordPress.org', ALT_LOCAL);
					echo '</a> ';
					_e('and click the ', ALT_LOCAL);
					echo '<a href="http://wordpress.org/plugins/' . ALT_SLUG .  '/#compatibility">';
					_e('Works', ALT_LOCAL);
					echo '</a> ';
					_e('button. For support please visit the ', ALT_LOCAL);
					echo '<a href="http://wordpress.org/support/plugin/' . ALT_SLUG . '">';
					_e('forums', ALT_LOCAL);
					echo '</a>.';
				?>
				<br /><br />
				<a href="https://www.paypal.com/cgi-bin/webscr?cmd=_s-xclick&hosted_button_id=7EX9NB9TLFHVW"><img src="https://www.paypalobjects.com/en_US/i/btn/btn_donate_LG.gif" alt="Donate with PayPal" title="Donate with PayPal" width="92" height="26" /></a>
				</div>
		</div>
		<?php }

	// main function and filter
	add_filter('login_message', 'alt_login_message');
	function alt_login_message($default) {
		$options = alt_getpluginoptions();
		$enabled = $options[ALT_DEFAULT_ENABLED_NAME];
		if ($enabled) {
			$tta = $options[ALT_DEFAULT_TEXT_NAME];
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
				if ($_GET['page'] == ALT_SLUG) { // we are on this plugin's settings page
					$options = alt_getpluginoptions();
					if ($options != false) {
						$enabled = $options[ALT_DEFAULT_ENABLED_NAME];
						if (!$enabled) {
							echo '<div id="message" class="error">' . ALT_PLUGIN_NAME . ' ' . __('is currently disabled.', ALT_LOCAL) . '</div>';
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
				if ($_GET['page'] == ALT_SLUG) { // we are on this plugin's settings page
					alt_admin_styles();
				}
			}
		}
	}
	// add settings link on plugin page
	// http://bavotasan.com/2009/a-settings-link-for-your-wordpress-plugins/
	add_filter('plugin_action_links_' . plugin_basename(__FILE__), 'alt_plugin_settings_link');
	function alt_plugin_settings_link($links) {
		$settings_link = '<a href="options-general.php?page=' . ALT_SLUG . '">' . __('Settings', ALT_LOCAL) . '</a>';
		array_unshift($links, $settings_link);
		return $links;
	}
	// http://wpengineer.com/1295/meta-links-for-wordpress-plugins/
	add_filter('plugin_row_meta', 'alt_meta_links', 10, 2);
	function alt_meta_links($links, $file) {
		$plugin = plugin_basename(__FILE__);
		// create link
		if ($file == $plugin) {
			$links = array_merge($links,
				array(
					'<a href="http://wordpress.org/support/plugin/' . ALT_SLUG . '">' . __('Support', ALT_LOCAL) . '</a>',
					'<a href="http://wordpress.org/extend/plugins/' . ALT_SLUG . '/">' . __('Documentation', ALT_LOCAL) . '</a>',
					'<a href="http://wordpress.org/plugins/' . ALT_SLUG . '/faq/">' . __('FAQ', ALT_LOCAL) . '</a>'
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
			plugins_url(ALT_PATH . '/css/admin.css'),
			array(),
			ALT_VERSION . "_" . date('njYHis', filemtime(dirname(__FILE__) . '/css/admin.css')),
			'all');
	}
	// when plugin is activated, create options array and populate with defaults
	register_activation_hook(__FILE__, 'alt_activate');
	function alt_activate() {
		$options = alt_getpluginoptions();
		update_option(ALT_OPTION, $options);
	}
	// generic function that returns plugin options from DB
	// if option does not exist, returns plugin defaults
	function alt_getpluginoptions() {
		return get_option(ALT_OPTION, 
			array(
				ALT_DEFAULT_ENABLED_NAME => ALT_DEFAULT_ENABLED, 
				ALT_DEFAULT_TEXT_NAME => ALT_DEFAULT_TEXT
			));
	}
?>