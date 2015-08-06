=== Plugin Name ===
Contributors: aliakro
Donate link: https://www.paypal.com/cgi-bin/webscr?cmd=_s-xclick&hosted_button_id=J3C968CUGDV6U
Tags: shortcode, variable, php, text, html, parameter, javascript, embed, reuse
Requires at least: 4.2.0
Tested up to: 4.2.2
Stable tag: 1.2
License: GPLv2 or later
License URI: http://www.gnu.org/licenses/gpl-2.0.html

Create your own shortcodes and assign text, html, etc to them. Use these across your site and only change in one place.

== Description ==

Do you want to use the same snippet throughout your site but only have to change the value in one location? If so, this plugin maybe just what you need.

You can create your own Shortcodes and assign text, HTML, JavaScript, etc to it. You will then be given a shortcode such as:

[shortcode-variables slug="your-slug-name"]

You can embed this shortcode throughout your site and it will render the same content. Simply update the Shortcode Variable in Tools > Shortcode Variables and it will change throughout the site!

Comes with the following premade shortcodes:

[shortcode-variables slug="sc-todays-date"]	Displays today's date. Default is UK format (DD/MM/YYYY). Format can be changed by adding the parameter format="m/d/Y" onto the shortcode. Format syntax is based upon PHP date: http://php.net/manual/en/function.date.php
[shortcode-variables slug="sc-site-title"]	Displays the site title.
[shortcode-variables slug="sc-site-url"]	Displays the site URL.
[shortcode-variables slug="sc-page-title"]	Displays the page title.
[shortcode-variables slug="sc-admin-email"]	Displays the admin email address.

Features:

- Insert the same piece of data, HTML, text, etc throughout your site and change in only one place.
- TinyMCE editor
- Place other WordPress shortcodes within yours
- Comes with a range of pre-made shortcodes

Languages supported:

- English (UK)
- Need a translation? Email us: email@YeKen.uk

* Developed by YeKen.uk *

Paypal Donate: email@YeKen.uk

== Installation ==

1. Login into Wordpress Admin Panel
2. Goto Plugins > Add New
3. Search for "Shortcode Variables"
4. Click Install now and activate plugin
5. Goto Settings > Shortcode Variables

== Frequently Asked Questions ==

= How do I add / edit / delete Shortcode Variables =

Login into Wordpress Admin Panel and goto Settings > Shortcode Variables

== Screenshots ==

1. View all shortcode variables created.
2. Add a new shortcode variable
3. Edit an existing shortcode variable
4. Using the shortcode variables into a page
5. Shortcode variables rendered in a page

== Changelog ==

= 1.2 =

* Added Premade shortcodes and framework to add additional ones
* Added Top Level menu item to support two sub pages. One for user defined shortcodes and another for premade shortcodes.

= 1.1 =
* Added caching to SQL queries. Therefore making shortcode rendering faster and reduce load on mySQL.
* TinyMCE editor for editing shortcode content.
* You can now specify other shortcodes within your shortcode variables.
* Readme.txt fixes

= 1.0 =
* Initial Release
