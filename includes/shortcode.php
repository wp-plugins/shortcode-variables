<?php

defined('ABSPATH') or die('Jog on!');

function sh_cd_shortcode( $atts )
{
	$shortcode_args = shortcode_atts( array(
        'slug' => false,
        'format' => false
    ), $atts );

	return sh_cd_render_shortcode_from_db($shortcode_args);

}
add_shortcode( SH_CD_SHORTCODE, 'sh_cd_shortcode' );

function sh_cd_render_shortcode_from_db($shortcode_args)
{
	$slug = $shortcode_args['slug'];

	if ($slug != false && !empty($slug))
	{ 
		// Check if a shortcode preset
		if (sh_cd_is_shortcode_preset($slug))
		{
			return sh_cd_render_shortcode_presets($shortcode_args);
		}
		else
		{
			$cached_shortcode = sh_cd_get_cache($slug);

			if ($cached_shortcode != false)
			{			
				// Process other shortcodes
				$cached_shortcode = do_shortcode($cached_shortcode);

				return $cached_shortcode;
			}
			else
			{
				$shortcode = sh_cd_get_shortcode_by_slug($slug);

				if ($shortcode)
				{
					sh_cd_set_cache($slug, $shortcode);

					$shortcode = do_shortcode($shortcode);
					
					return $shortcode;
				}
			}
		}		
	}
}