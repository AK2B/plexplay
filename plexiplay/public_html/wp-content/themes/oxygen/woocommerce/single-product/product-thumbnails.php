<?php
/**
 * Single Product Thumbnails
 *
 * @author 		WooThemes
 * @package 	WooCommerce/Templates
 * @version     2.0.3
 */

if ( ! defined( 'ABSPATH' ) ) exit; // Exit if accessed directly

global $post, $product, $woocommerce, $shown_id;

$attachment_ids = $product->get_gallery_attachment_ids();

if ( $attachment_ids ) {
	
	wp_enqueue_script('owl-carousel');
	wp_enqueue_style('owl-carousel-theme');
	
	if($shown_id)
	{
		$first_attachment_link = wp_get_attachment_url( reset($attachment_ids) );
		$thumbnail_attachment_link = wp_get_attachment_url($shown_id);
		
		if($first_attachment_link != $thumbnail_attachment_link)
			$attachment_ids = array_merge(array($shown_id), $attachment_ids);
	}
	?>
	<div class="thumbnails" id="image-thumbnails-carousel">
		<div class="row">
		<?php
	
			$loop = 0;
			$columns = apply_filters( 'woocommerce_product_thumbnails_columns', 3 );
	
			foreach ( $attachment_ids as $attachment_id ) {
	
				$classes = array('product-thumb', 'zoom', 'col-md-3' );
	
				if ( $loop == 0 || $loop % $columns == 0 )
					$classes[] = 'first';
	
				if ( ( $loop + 1 ) % $columns == 0 )
					$classes[] = 'last';
	
				#$image_link = wp_get_attachment_url( $attachment_id );
				$image = wp_get_attachment_image_src( $attachment_id, apply_filters( 'single_product_small_thumbnail_size', 'shop-thumb-5' ) );
	
				if ( ! $image )
					continue;
	
				#$image       = wp_get_attachment_image_src( $attachment_id, apply_filters( 'single_product_small_thumbnail_size', 'shop_thumbnail' ) );
				
				# start: modified by Arlind Nushi
				#$image = laborator_show_img($image_link, 'shop-thumb-5');
				#$image = laborator_img($image_link, 'shop-thumb-5');
				
				$image = wp_get_attachment_image_src( $attachment_id, apply_filters( 'single_product_small_thumbnail_size', 'shop-thumb-5' ) );
				
				$image = '<img class="lazyOwl" data-src="'.$image[0].'" />';
				
				$image_link = $image[0];
				# end: modified by Arlind Nushi
				
				$image_class = esc_attr( implode( ' ', $classes ) );
				$image_title = esc_attr( get_the_title( $attachment_id ) );
	
				echo apply_filters( 'woocommerce_single_product_image_thumbnail_html', sprintf( '<a href="%s" class="%s" title="%s" data-index="%d" data-rel="prettyPhoto[product-gallery]"><span>%s</span></a>', $image_link, $image_class, $image_title, $loop, $image ), $attachment_id, $post->ID, $image_class );
	
				$loop++;
			}
	
		?>
		</div>
	</div>
	
	<script type="text/javascript">
	<?php
	$auto_play = absint(get_data('shop_single_auto_rotate_image')) * 1000;
	?>
	jQuery(document).ready(function($)
	{
		// Main Image
		var $mis = $("#main-image-slider");
		
		$mis.find(".hidden").removeClass("hidden");
		
		$mis.owlCarousel({
			items: 1,
			navigation: true,
			pagination: false,
			singleItem: true,
			autoHeight: true,
			autoPlay: <?php echo $auto_play == 0 ? 'false' : $auto_play; ?>,
			stopOnHover: true,
			slideSpeed: 400
		});
		
		$mis.find(".woocommerce-main-image").nivoLightbox({
			effect: 'fadeScale'
		});
		
		
		// Thumbnails
		var $thumbs = $("#image-thumbnails-carousel .row");
		
		$thumbs.owlCarousel({
			items: 4,
			lazyLoad: true,
			navigation: true,
			pagination: false,
			itemsMobile: [479,4],
			itemsTablet: [768,4]
		});
		
		var owl = $mis.data('owlCarousel');
		
		$("#image-thumbnails-carousel .product-thumb").each(function(i, el)
		{
			var index = $(el).data('index');
			
			$(el).hoverIntent({
				over: function(){ owl.goTo( index ); },
				out: function(){},
				interval: 420
			});
			
			$(el).click(function(ev)
			{
				ev.preventDefault();
				
				$mis.find("a.woocommerce-main-image").eq(index).trigger('click');
			});
		});
		
		
		// Main Image Zoom
		$mis.find('.zoom-image').on('click', function(ev)
		{	
			ev.preventDefault();
			
			var $this = $(this);
			
			launchFullscreen(document.documentElement);
		});
	});
	</script>
	<?php
}
else
if(has_post_thumbnail())
{
?>
<script type="text/javascript">

	jQuery(document).ready(function($)
	{
		// Main Image
		var $mis = $("#main-image-slider");
		
		$mis.find(".woocommerce-main-image").nivoLightbox({
			effect: 'fadeScale'
		});
	});
	
</script>
<?php
}