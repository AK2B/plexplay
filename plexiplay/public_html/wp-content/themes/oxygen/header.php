<!DOCTYPE html>
<!--[if lt IE 7 ]><html class="ie ie6" <?php language_attributes(); ?>> <![endif]-->
<!--[if IE 7 ]><html class="ie ie7" <?php language_attributes(); ?>> <![endif]-->
<!--[if IE 8 ]><html class="ie ie8" <?php language_attributes(); ?>> <![endif]-->
<!--[if (gte IE 9)|!(IE)]><!--><html <?php language_attributes(); ?>> <!--<![endif]-->
<head>
	<meta charset="<?php bloginfo( 'charset' ); ?>">
	<title><?php wp_title('|', true, 'right'); ?></title>
	<meta http-equiv="X-UA-Compatible" content="IE=edge,chrome=1" />
	
	<meta name="viewport" content="width=device-width, initial-scale=1, maximum-scale=1, user-scalable=no">
	
	
	
	<?php wp_head(); ?>
	
<!-- Hotjar Tracking Code for www.plexiplay.fr -->
<script>
    (function(f,b){
        var c;
        f.hj=f.hj||function(){(f.hj.q=f.hj.q||[]).push(arguments)};
        f._hjSettings={hjid:31667, hjsv:4};
        c=b.createElement("script");c.async=1;
        c.src="//static.hotjar.com/c/hotjar-"+f._hjSettings.hjid+".js?sv="+f._hjSettings.hjsv;
        b.getElementsByTagName("head")[0].appendChild(c); 
    })(window,document);
</script>

</head>
<body <?php body_class(); ?>>
	<?php if ( function_exists( 'gtm4wp_the_gtm_tag' ) ) { gtm4wp_the_gtm_tag(); } ?>
    	
	<?php if(function_exists('WC')): ?>
		<?php get_template_part('tpls/header-cart'); ?>
	<?php endif; ?>
	
	<?php if( ! defined("NO_HEADER_MENU")): ?>
	<div class="wrapper">
		
		<?php
		
		define("HAS_SLIDER", in_array('revslider/revslider.php', apply_filters('active_plugins', get_option( 'active_plugins'))) && function_exists("register_field_group") && ($revslider_id = get_field('revslider_id')));
		
		# Menu
		if(HEADER_TYPE == 1)
		{
			get_sidebar('menu'); 
		}
		else
		if(in_array(HEADER_TYPE, array(2,3,4)))
		{
			get_sidebar('menu-top');
			
			# Slider
			if(HAS_SLIDER)
			{
				if(is_search())
					echo "<div style='height: 30px;'></div>";
				else
					echo putRevSlider($revslider_id);
			}
		}
		?>
		
		<div class="main<?php echo HEADER_TYPE == 1 && HAS_SLIDER ? ' hide-breadcrumb' : ''; ?>">
		
			<?php get_template_part('tpls/breadcrumb'); ?>
			
			<?php 
			# Slider
			if(HEADER_TYPE == 1 && HAS_SLIDER):

				?>				
				<div class="rev-slider-container row">
					<?php echo putRevSlider($revslider_id); ?>
				</div>
				<?php
				
			endif;
			?>
	
	<?php endif; ?>

			