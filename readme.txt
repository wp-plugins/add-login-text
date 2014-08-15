=== Add Login Text ===
Tags: admin, login custom, text, dev, client
Requires at least: 3.5
Tested up to: 3.9
Contributors: jp2112
Donate link: https://www.paypal.com/cgi-bin/webscr?cmd=_s-xclick&hosted_button_id=7EX9NB9TLFHVW
Stable tag: trunk
License: GPLv2 or later
License URI: http://www.gnu.org/licenses/gpl-2.0.html

Display custom text (or links) on the admin login screen.

== Description ==

Add Login Text lets you customize the login screen by adding additional text above the login form. Great for developers working on client sites who want to include support links, bylines, mission statements or MOTD.

Use it for:

<ul>
<li>Welcome message</li>
<li>Copyright statements/credits</li>
<li>Link to support forum</li>
<li>Link to your other products</li>
</ul>

Or maybe you are just a regular guy who wants to put something on the login screen. Put a link to your site or whatever you want to see.

For changing the WP logo on the login screen, use a plugin like http://wordpress.org/plugins/login-logo/ instead.

<h3>If you need help with this plugin</h3>

If this plugin breaks your site or just flat out does not work, please go to <a href="http://wordpress.org/plugins/add-login-text/#compatibility">Compatibility</a> and click "Broken" after verifying your WordPress version and the version of the plugin you are using.

Then, create a thread in the <a href="http://wordpress.org/support/plugin/add-login-text">Support</a> forum with a description of the issue. Make sure you are using the latest version of WordPress and the plugin before reporting issues, to be sure that the issue is with the current version and not with an older version where the issue may have already been fixed.

<strong>Please do not use the <a href="http://wordpress.org/support/view/plugin-reviews/add-login-text">Reviews</a> section to report issues or request new features.</strong>

== Installation ==

1. Upload plugin file through the WordPress interface.
2. Activate the plugin through the 'Plugins' menu in WordPress.
3. Go to Settings &raquo; Add Login Text, configure plugin.
4. To test, log out and then go to your login screen, you should see the text there.

== Frequently Asked Questions ==

= How do I use the plugin? =

Go to Settings &raquo; Add Login Text and enter the text you want to see on the login screen. Make sure the "enabled" checkbox is checked.

= I entered some text but don't see anything on the page. =

Are you using another plugin that is also trying to edit the login screen?

Are you using any CSS that might be hiding parts of the login screen?

Are you caching your admin pages?

= How can I style the output? =

The output is wrapped in div tags with class name "alt-login-text". Use this class in your local stylesheet to style the output how you want.

= I don't want the admin CSS. How do I remove it? =

Add this to your functions.php:

`remove_action('admin_head', 'insert_alt_admin_css');`

== Screenshots ==

1. Plugin settings page (note the custom text entered)
2. The login screen (the text from the settings page is here)

== Changelog ==

= 0.0.9 =
- updated .pot file and readme

= 0.0.8 =
- updated validation code

= 0.0.7 =
- permanent fix for Undefined Index issue
- admin CSS and page updates

= 0.0.6 =
- code fix

= 0.0.5 = 
- code fix
- updated support tab

= 0.0.4 =
- code optimizations
- plugin settings page is now tabbed

= 0.0.3 =
- fix 2 for wp_kses

= 0.0.2 =
- fix for wp_kses

= 0.0.1 =
- created
- verified compatibility with WP 3.9

== Upgrade Notice ==

= 0.0.9 =
- updated .pot file and readme

= 0.0.8 =
- fix for undefined index when form first loads

= 0.0.7 =
- permanent fix for Undefined Index issue; admin CSS and page updates

= 0.0.6 =
- code fix

= 0.0.5 = 
- code fix; updated support tab

= 0.0.4 =
- code optimizations; plugin settings page is now tabbed

= 0.0.3 =
- fix 2 for wp_kses

= 0.0.2 =
- fix for wp_kses

= 0.0.1 =
created, verified compatibility with WP 3.9