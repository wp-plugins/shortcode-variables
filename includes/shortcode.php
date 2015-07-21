<?php

defined('ABSPATH') or die('Jog on!');

function sh_cd_shortcode( $atts )
{
	$a = shortcode_atts( array(
        'slug' => false
    ), $atts );

	return sh_cd_render_shortcode_from_db($a['slug']);

}
add_shortcode( SH_CD_SHORTCODE, 'sh_cd_shortcode' );

function sh_cd_render_shortcode_from_db($slug)
{
	if ($slug != false && !empty($slug))
	{
		$shortcode = sh_cd_get_shortcode_by_slug($slug);

		if ($shortcode)
		{
			return $shortcode;
		}
	}
}