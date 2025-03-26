<?php
/**
 * Pagination - Show numbered pagination for catalog pages.
 *
 * @author 		WooThemes
 * @package 	WooCommerce/Templates
 * @version     2.0.0
 */

if ( ! defined( 'ABSPATH' ) ) exit; // Exit if accessed directly

global $wp_query;

if ( $wp_query->max_num_pages <= 1 || defined("PAGINATION_SHOWN"))
	return;

define("PAGINATION_SHOWN", true);
?>
<div class="clear"></div>

<div class="row spread-2<?php echo SHOPSIDEBAR ? '' : ' shop-no-sidebar'; ?>">
	<div class="col-md-12">
		<nav class="woocommerce-pagination loop-pagination">
			<?php
				echo paginate_links( apply_filters( 'woocommerce_pagination_args', array(
					'base'         => str_replace( 999999999, '%#%', get_pagenum_link( 999999999 ) ),
					'format'       => '',
					'current'      => max( 1, get_query_var( 'paged' ) ),
					'total'        => $wp_query->max_num_pages,
					'prev_text'    => __('Previous', TD),
					'next_text'    => __('Next', TD),
					'type'         => 'list',
					'end_size'     => 3,
					'mid_size'     => 3
				) ) );
			?>
		</nav>
	</div>
</div>