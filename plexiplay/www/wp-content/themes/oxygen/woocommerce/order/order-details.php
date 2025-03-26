<?php
/**
 * Order details
 *
 * @author 		WooThemes
 * @package 	WooCommerce/Templates
 * @version     2.1.0
 */

if ( ! defined( 'ABSPATH' ) ) exit; // Exit if accessed directly

global $woocommerce;

$order = new WC_Order( $order_id );
?>

<div class="row spread-2">

	<div class="col-md-6">
		<div class="white-block block-pad cart-env checkout-cart-env">
			<h4 class="with-divider"><?php _e( 'Order Details', 'woocommerce' ); ?></h4>
			
			<ul class="cart-totals">
			
					<?php
					if ( sizeof( $order->get_items() ) > 0 ) {
			
						foreach( $order->get_items() as $item ) {
							$_product     = apply_filters( 'woocommerce_order_item_product', $order->get_product_from_item( $item ), $item );
							$item_meta    = new WC_Order_Item_Meta( $item['item_meta'], $_product );
			
							?>
							<li class="<?php echo esc_attr( apply_filters( 'woocommerce_order_item_class', 'order_item', $item, $order ) ); ?>">
								<div class="name product-name">
									<?php
										if ( $_product && ! $_product->is_visible() )
											echo apply_filters( 'woocommerce_order_item_name', $item['name'], $item );
										else
											echo apply_filters( 'woocommerce_order_item_name', sprintf( '<a href="%s">%s</a>', get_permalink( $item['product_id'] ), $item['name'] ), $item );
			
										echo apply_filters( 'woocommerce_order_item_quantity_html', ' <strong class="product-quantity">' . sprintf( __('Quantity:', TD) . ' %s', $item['qty'] ) . '</strong>', $item );
			
										$item_meta->display();
			
										if ( $_product && $_product->exists() && $_product->is_downloadable() && $order->is_download_permitted() ) {
			
											$download_files = $order->get_item_downloads( $item );
											$i              = 0;
											$links          = array();
			
											foreach ( $download_files as $download_id => $file ) {
												$i++;
			
												$links[] = '<small><a href="' . esc_url( $file['download_url'] ) . '">' . sprintf( __( 'Download file%s', 'woocommerce' ), ( count( $download_files ) > 1 ? ' ' . $i . ': ' : ': ' ) ) . esc_html( $file['name'] ) . '</a></small>';
											}
			
											#echo '<br/>' . implode( '<br/>', $links );
										}
									?>
								</div>
								<div class="value product-total">
									<?php echo $order->get_formatted_line_subtotal( $item ); ?>
								</div>
							</li>
							<?php
			
							if ( in_array( $order->status, array( 'processing', 'completed' ) ) && ( $purchase_note = get_post_meta( $_product->id, '_purchase_note', true ) ) ) {
								?>
								<li class="product-purchase-note one-line">
									<div class="name"><?php echo apply_filters( 'the_content', $purchase_note ); ?></div>
								</li>
								<?php
							}
						}
					}
			
					do_action( 'woocommerce_order_items_table', $order );
					?>
					
				<?php
					if ( $totals = $order->get_order_item_totals() ) $i=0; $l = count($totals) - 1; foreach ( $totals as $total ) :
						?>
						<li class="<?php echo $i == 0 ? 'subtotal' : ($l == $i ? 'total' : ''); ?>">
							<div class="name"><?php echo $total['label']; ?></div>
							<div class="value"><?php echo $total['value']; ?></div>
						</li>
						<?php
						$i++;
					endforeach;
				?>
			</ul>
		
			<?php do_action( 'woocommerce_order_details_after_order_table', $order ); ?>
			
		</div>
	</div>


	<div class="col-md-6">
	
		<div class="white-block block-pad">
			<h4 class="with-divider"><?php _e( 'Customer details', 'woocommerce' ); ?></h4>
			<dl class="customer_details">
			<?php
				if ( $order->billing_email ) echo '<dt>' . __( 'Email:', 'woocommerce' ) . '</dt><dd>' . $order->billing_email . '</dd>';
				if ( $order->billing_phone ) echo '<dt>' . __( 'Telephone:', 'woocommerce' ) . '</dt><dd>' . $order->billing_phone . '</dd>';
			
				// Additional customer details hook
				do_action( 'woocommerce_order_details_after_customer_details', $order );
			?>
			</dl>
		</div>
		
		<?php if ( get_option( 'woocommerce_ship_to_billing_address_only' ) === 'no' && get_option( 'woocommerce_calc_shipping' ) !== 'no' ) : ?>

			<div class="white-block block-pad">
				<h4 class="with-divider"><?php _e( 'Billing Address', 'woocommerce' ); ?></h4>
		
				<address><p>
					<?php
						if ( ! $order->get_formatted_billing_address() ) _e( 'N/A', 'woocommerce' ); else echo $order->get_formatted_billing_address();
					?>
				</p></address>
	
			</div>
		
		<?php endif; ?>
		
		<?php if ( get_option( 'woocommerce_ship_to_billing_address_only' ) === 'no' && get_option( 'woocommerce_calc_shipping' ) !== 'no' ) : ?>

			<div class="white-block block-pad">
				
				<h4 class="with-divider"><?php _e( 'Shipping Address', 'woocommerce' ); ?></h4>
				<address><p>
					<?php
						if ( ! $order->get_formatted_shipping_address() ) _e( 'N/A', 'woocommerce' ); else echo $order->get_formatted_shipping_address();
					?>
				</p></address>
			</div>
		
		<?php endif; ?>
		
	</div>


</div>

<div class="clear"></div>
