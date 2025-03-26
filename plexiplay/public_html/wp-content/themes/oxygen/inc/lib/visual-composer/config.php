<?php	
/**
 * Laborator Visual Composer Settings
 *
 * Developed by: Arlind Nushi (www.arlindnushi.com)
 *
 * www.laborator.co
 *
 * File Date: 22/04/2014
 *
 */

global $composer_settings;


/* ! Layout Elements */

$curr_dir = dirname(__FILE__);

/* Register Own Param Types */
#get_template_part('inc/lib/visual-composer/param-types/skillsbars/skillsbars_param_type');
#get_template_part('inc/lib/visual-composer/param-types/listrows/listrows_param_type');
#get_template_part('inc/lib/visual-composer/param-types/metroelementoptions/metroelementoptions_param_type');
include_once($curr_dir . '/param-types/fontelloicon/fontelloicon_param_type.php');


/* Shortcodes */
add_action('init', 'laborator_vc_shortcodes');

function laborator_vc_shortcodes()
{
	global $curr_dir;
	
	include_once($curr_dir . '/laborator-shortcodes/laborator_banner.php');
	include_once($curr_dir . '/laborator-shortcodes/laborator_banner2.php');
	include_once($curr_dir . '/laborator-shortcodes/laborator_featuretab.php');
	include_once($curr_dir . '/laborator-shortcodes/laborator_blog.php');
	include_once($curr_dir . '/laborator-shortcodes/laborator_testimonials.php');
	
	if(in_array('woocommerce/woocommerce.php', apply_filters('active_plugins', get_option( 'active_plugins'))))
	{
		include_once($curr_dir . '/laborator-shortcodes/laborator_products.php');
		include_once($curr_dir . '/laborator-shortcodes/laborator_products_carousel.php');
		include_once($curr_dir . '/laborator-shortcodes/laborator_lookbook.php');
	}
}

/* Admin Styles */
add_action('admin_enqueue_scripts', 'laborator_vc_styles');

function laborator_vc_styles()
{
	
	$laborator_vc_style = THEMEURL . 'inc/lib/visual-composer/assets/laborator_vc_main.css';
	
	wp_enqueue_style('laborator_vc_main', $laborator_vc_style);
}