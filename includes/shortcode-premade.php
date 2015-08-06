<?php

defined('ABSPATH') or die("Jog on!");

function sh_cd_is_shortcode_preset($slug)
{
	if (!empty($slug) && array_key_exists($slug, sh_cd_shortcode_presets())) {
		return true;
	}

	return false;

}

function sh_cd_shortcode_presets()
{
	return array(

		'sc-todays-date' => 'Displays today\'s date. Default is UK format (DD/MM/YYYY). Format can be changed by adding the parameter format="m/d/Y" onto the shortcode. Format syntax is based upon PHP date: <a href="http://php.net/manual/en/function.date.php" target="_blank">http://php.net/manual/en/function.date.php</a>',
		'sc-site-title' => 'Displays the site title.',
		'sc-site-url' => 'Displays the site URL.',
		'sc-page-title' => 'Displays the page title.',
		'sc-admin-email' => 'Displays the admin email address.'
		);
}

function sh_cd_render_shortcode_presets($shortcode_args)
{
	$slug = $shortcode_args['slug'];

	switch ($slug) {
		case 'sc-todays-date':
			return sh_cd_render_todays_date($shortcode_args['format']);
			break;
		case 'sc-site-url':
			return site_url();
			break;
		case 'sc-page-title':
			return the_title('', '', true);
			break;
		case 'sc-site-title':
			return bloginfo( 'name');
			break;
		case 'sc-admin-email':
			return bloginfo( 'admin_email');
			break;
	
		default:
			# code...
			break;
	}


}


function sh_cd_render_todays_date($format)
{
	if (false == $format) {
		$format = 'd/m/Y';
	}

	return date($format);
}