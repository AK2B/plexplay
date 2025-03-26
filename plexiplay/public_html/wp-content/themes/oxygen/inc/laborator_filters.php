<?php
/**
 *	Oxygen WordPress Theme
 *	
 *	Laborator.co
 *	www.laborator.co 
 */


# WooCommerce Styles
add_filter( 'woocommerce_enqueue_styles', '__return_false' );


# Page Title optimized for better seo
add_filter('wp_title', 'filter_wp_title');

function filter_wp_title( $title )
{
	global $page, $paged;
	
	$separator = '-';
	
	if ( is_feed() )
		return $title;
	
	$site_description = get_bloginfo( 'description' );
	
	$filtered_title = $title . get_bloginfo( 'name' );
	$filtered_title .= ( ! empty( $site_description ) && ( is_home() || is_front_page() ) ) ? ' '.$separator.' ' . $site_description: '';
	$filtered_title .= ( 2 <= $paged || 2 <= $page ) ? ' '.$separator.' ' . sprintf( __( 'Page %s', TD), max( $paged, $page ) ) : '';
	
	return $filtered_title;
}


# Laborator Theme Options Translate
add_filter('admin_menu', 'laborator_add_menu_classes', 100);

function laborator_add_menu_classes($items)
{
	global $submenu;
	
	foreach($submenu as $menu_id => $sub)
	{
		if($menu_id == 'laborator_options')
		{
			$submenu[$menu_id][0][0] = __('Theme Options', TD);
		}
	}

	return $submenu;
}


# Excerpt Length & More
add_filter('excerpt_length', create_function('', 'return '.(get_data('blog_sidebar_position') == 'Hide' ? 80 : 38).';'));
add_filter('excerpt_more', create_function('', 'return "&hellip;";'));



# Render Comment Fields
function laborator_comment_fields($fields)
{
	foreach($fields as $field_type => $field_html)
	{
		preg_match("/<label(.*?)>(.*?)\<\/label>/", $field_html, $html_label);
		preg_match("/<input(.*?)\/>/", $field_html, $html_input);
		
		$html_label = strip_tags($html_label[2]);
		$html_input = $html_input[0];
		
		$html_input = str_replace("<input", '<input class="form-control" placeholder="'.esc_attr($html_label).'" ', $html_input);
		$html_label = str_replace('*', '<span class="red">*</span>', $html_label);
		
		$fields[$field_type] = "
		<div class=\"col-lg-4 mobile-padding\">
			<label>" . $html_label . "</label>
			{$html_input}
		</div>";
	}
	
	
	return $fields;
}



# Body Class
add_filter('body_class', 'laborator_body_class');

function laborator_body_class($classes)
{	
	if(get_data('sidebar_menu_position') === "0")
		$classes[] = 'right-sidebar';
	
	if(in_array(HEADER_TYPE, array(2,3,4)))
	{
		$classes[] = 'oxygen-top-menu';
		
		if(HEADER_TYPE == 3)
			$classes[] = 'top-header-flat';
			
		if(HEADER_TYPE == 4)
			$classes[] = 'top-header-center';
		
		$classes[] = 'ht-' . HEADER_TYPE;
		
		if(get_data('cart_ribbon_position'))
		{
			$classes[] = 'ribbon-left';
		}
	}
	else
	if(HEADER_TYPE == 1)
	{
		$classes[] = 'oxygen-sidebar-menu ht-1';
	}
	
	if(get_data('header_sticky_menu'))
	{
		$classes[] = 'sticky-menu';
	}
	
	if( ! get_data('cart_ribbon_show'))
	{
		$classes[] = 'cart-ribbon-hidden';
	}
	
	if(is_catalog_mode())
	{
		$classes[] = 'catalog-mode-only';
		
		if(catalog_mode_hide_prices())
		{
			$classes[] = 'catalog-mode-hide-prices';
		}
	}
	
	return $classes;
}


# Add Do-shortcode for text widgets
add_filter('widget_text', 'widget_text_do_shortcodes');

function widget_text_do_shortcodes($text)
{
	return do_shortcode($text);
}



# Shortcode for Social Networks [lab_social_networks]
add_shortcode('lab_social_networks', 'shortcode_lab_social_networks');

function shortcode_lab_social_networks($atts = array(), $content = '')
{
	$social_order = get_data('social_order');
	
	$social_order_list = array(
		"fb"  => array("title" => "Facebook", 	"icon" => "entypo-facebook"),
		"tw"  => array("title" => "Twitter", 		"icon" => "entypo-twitter"),
		"lin" => array("title" => "LinkedIn", 	"icon" => "entypo-linkedin"),
		"yt"  => array("title" => "YouTube", 		"icon" => "entypo-play"),
		"vm"  => array("title" => "Vimeo", 		"icon" => "entypo-vimeo"),
		"drb" => array("title" => "Dribbble", 	"icon" => "entypo-dribbble"),
		"ig"  => array("title" => "Instagram", 	"icon" => "entypo-instagram"),
		"pi"  => array("title" => "Pinterest", 	"icon" => "entypo-pinterest"),
		"gp"  => array("title" => "Google+", 		"icon" => "entypo-gplus"),
		"vk"  => array("title" => "VKontakte", 	"icon" => "entypo-vkontakte"),
	);
	
	
	$html = '<ul class="social-networks">';
	
	foreach($social_order['visible'] as $key => $title)
	{
		if($key == 'placebo')
			continue;
		
		$sn = $social_order_list[$key];
			
		$html .= '<li>';
			$html .= '<a href="'.get_data("social_network_link_{$key}").'" target="_blank" class="icon-'.(str_replace('entypo-', 'social-', $sn['icon'])).'">';
				$html .= '<i class="'.$sn['icon'].'"></i>';
			$html .= '</a>';
		$html .= '</li>';
	}
	
	$html .= '</ul>';
	
	
	return $html;
	
}


# Filter to Replace default css class for vc_row shortcode and vc_column
add_filter('vc_shortcodes_css_class', 'laborator_css_classes_for_vc', 10, 2);

function laborator_css_classes_for_vc($class_string, $tag)
{
	global $atts_values;
	
	if($tag == 'vc_row' || $tag == 'vc_row_inner')
	{
		$class_string = str_replace(array('wpb_row vc_row-fluid'), array('row'), $class_string);
		
		# No Margin Row
		if(isset($atts_values['add_default_margin']) && $atts_values['add_default_margin'] == 'yes')
		{
			$class_string .= ' with-margin';
		}
		
		# Block background
		if(isset($atts_values['block_with_background']) && $atts_values['block_with_background'] == 'yes')
		{
			$class_string .= ' block-bg';
		}
	}
	elseif($tag == 'vc_column' || $tag == 'vc_column_inner')
	{
		if(preg_match("/vc_span(\d+)/", $class_string, $matches))
		{
			$span_columns = $matches[1];
			
			$col_type = $tag == 'vc_column' ? 'sm' : 'md';
			
			$class_string = str_replace($matches[0], "col-{$col_type}-{$span_columns}", $class_string);
		}
	}
	elseif($tag == 'vc_column_text')
	{
		# Block background
		if(isset($atts_values['block_with_background']) && $atts_values['block_with_background'] == 'yes')
		{
			$class_string .= ' block-bg';
		}
	}
	elseif($tag == 'vc_button')
	{
		$class_string = str_replace(array('wpb_button', 'wpb_button', 'wpb_btn'), array('btn', '', 'btn'), $class_string);
		
		# Bordered Button
		if(isset($atts_values['bordered']) && $atts_values['bordered'] == 'yes')
		{
			$class_string .= ' btn-bordered';
		}
	}
	elseif($tag == 'vc_widget_sidebar')
	{
		$class_string .= ' shop_sidebar';
	}
	elseif($tag == 'vc_text_separator')
	{
		$subtitle = isset($atts_values['subtitle']) ? $atts_values['subtitle'] : '';
		$accent_color = isset($atts_values['accent_color']) && $atts_values['accent_color'] ? $atts_values['accent_color'] : '';
		
		if(isset($atts_values['separator_style']))
			$class_string .= ' ' . $atts_values['separator_style'] . ($accent_color ? (" custom-color-" . str_replace('#', '', $accent_color)) : '');
		
		if($subtitle)
		{
			#$class_string .= '" data-subtitle="' . esc_attr($subtitle);
			$class_string .= ' __' . str_replace(' ', '-', $subtitle) . '__';
		}
	}
	
	return $class_string;
}


# Visual Composer Mapper
add_filter('lab_vc_map_attrs', 'lab_vc_map_params');

function lab_vc_map_params($attributes)
{
	if(isset($attributes['params']) && count($attributes['params']))
	{
		$last_index = count($attributes['params'])-1;
		
		if($attributes['params'][$last_index]['type'] == 'css_editor')
		{
			$css_editor = $attributes['params'][$last_index];
			unset($attributes['params'][$last_index]);
		}
	}
	
	
	switch($attributes['base'])
	{
		case "vc_row":
			$attributes['params'][] = array(
				"type" => 'checkbox',
				"heading" => 'Block with Background',
				"param_name" => "block_with_background",
				"description" => "Make this block with background.",
				"value" => array('Yes' => 'yes')
			);
			
			$attributes['params'][] = array(
				"type" => 'checkbox',
				"heading" => 'Add Default Margin',
				"param_name" => "add_default_margin",
				"description" => "Add the default margin for the elements container.",
				"value" => array('Yes' => 'yes')
			);
			break;
			
		case "vc_column_text":
			$attributes['params'][] = array(
				"type" => 'checkbox',
				"heading" => 'Block with Background',
				"param_name" => "block_with_background",
				"description" => "Make this block with background.",
				"value" => array('Yes' => 'yes')
			);
			break;
		
		case "vc_message":
			$attributes['params']                        = param_remove_from_array($attributes['params'], 'style');
			$color_index                                 = param_get_index($attributes['params'], 'color');			
			$attributes['params'][$color_index]['value'] = array_merge($attributes['params'][$color_index]['value'], array('Default' => 'default', 'Default Black' => 'default-black', 'Blank' => 'blank'));
			break;
		
		case "vc_button":
			$attributes['params']                        = param_remove_from_array($attributes['params'], 'icon');
			$color_index                                 = param_get_index($attributes['params'], 'color');
			$attributes['params'][$color_index]['value'] = array('Default' => 'btn-default', 'Black' => 'btn-black', 'Green' => 'btn-green', 'Blue' => 'btn-blue', 'Dark Red' => 'btn-dark-red');
			
			// Bordered Option
			$attributes['params'][] = array(
				"type" => 'checkbox',
				"heading" => 'Bordered',
				"param_name" => "bordered",
				"description" => "Remove the background and show only border.",
				"value" => array('Yes' => 'yes')
			);
			
			$bordered_index = param_get_index($attributes['params'], 'bordered');
			move_array_index_after($attributes['params'], $bordered_index, $color_index);
			break;
		
		case "vc_text_separator":
			#print_r($attributes);exit;
			$attributes['params'] = param_remove_from_array($attributes['params'], 'color');
			#$attributes['params'] = param_remove_from_array($attributes['params'], 'title_align');
			$attributes['params'] = param_remove_from_array($attributes['params'], 'style');
			$attributes['params'] = param_remove_from_array($attributes['params'], 'el_width');
			
			# Separator Style
			$attributes['params'][] = array(
				"type" => "dropdown",
				"heading" => __("Separator Style", TD),
				"param_name" => "separator_style",
				"value" => array(
					"Double Bordered Thick"	=> 'double-bordered-thick',
					"Double Bordered Thin"	 => 'double-bordered-thin',
					"Double Bordered"		  => 'double-bordered',
					"One Line Border"		  => 'one-line-border',
				),
				"description" => __("Select separator style", TD)
			);
			
			$title_index = param_get_index($attributes['params'], 'title');
			$separator_style_index = param_get_index($attributes['params'], 'separator_style');

			move_array_index_after($attributes['params'], $separator_style_index, $title_index);
			
			# Subtitle
			$attributes['params'][] = array(
				"type" => "textfield",
				"heading" => __("Sub Title", TD),
				"param_name" => "subtitle",
				"description" => __("You can apply subtitle but its optional.", TD),
				"value" => ""
			);
			
			$subtitle_index = param_get_index($attributes['params'], 'subtitle');
			move_array_index_after($attributes['params'], $subtitle_index, $title_index);
			break;
	}
	
	
	if(isset($css_editor))
	{
		$attributes['params'][] = $css_editor;
	}
	
	return $attributes;
}



# Skin Compiler
add_filter('of_options_before_save', 'lab_custom_skin_compiler');

function lab_custom_skin_compiler($data)
{
	if(isset($data['use_custom_skin']) && $data['use_custom_skin'])
	{
		try
		{
			custom_skin_compile(array(
				'link-color'		=> $data['custom_skin_main_color'],
				'menu-link'		 => $data['custom_skin_menu_link_color'],
				'background-color'  => $data['custom_skin_background_color'],
			));
		}
		catch(Exception $e){}
	}
	
	return $data;
}


# Catalog Mode
if(is_catalog_mode())
{
	add_filter('get_data_cart_ribbon_show', create_function('', 'return false;'));
}



# Testimonial Thumbnail
if(function_exists('add_theme_support'))
{
	add_filter('manage_posts_columns', 'laborator_testimonial_featured_image_column', 5);
	add_filter('manage_pages_columns', 'laborator_testimonial_featured_image_column', 5);
 
	add_action('manage_posts_custom_column', 'laborator_testimonial_featured_image_column_content', 5, 2);
	add_action('manage_pages_custom_column', 'laborator_testimonial_featured_image_column_content', 5, 2);
}
function laborator_testimonial_featured_image_column($columns)
{
	if(get('post_type') == 'testimonial')
	{	
		$columns_new = array(
			'cb' => $columns['cb'],
			'testimonial_featured_image' =>  __('Image', TD)
		);
		
		$columns = array_merge($columns_new, $columns);
	}
	
	return ($columns);
}

function laborator_testimonial_featured_image_column_content($column_name, $id)
{
	if($column_name === 'testimonial_featured_image')
	{
		echo '<center>';
		
		if(has_post_thumbnail())
		{
			echo laborator_show_img(get_the_id(), 48, 48, 1);
		}
		else
		{
			echo "<small>No Image</small>";
		}
		
		echo '</center>';
	}
}


// Post Thumbnail Remove height and width
add_filter('post_thumbnail_html', 'remove_thumbnail_dimensions', 10, 3);

function remove_thumbnail_dimensions($html, $post_id, $post_image_id)
{
	return remove_wh($html);
}