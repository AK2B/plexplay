<?php
/**
 * Cart totals
 *
 * @author 		WooThemes
 * @package 	WooCommerce/Templates
 * @version     2.1.0
 */

if ( ! defined( 'ABSPATH' ) ) exit; // Exit if accessed directly
?>


	<?php do_action( 'woocommerce_before_cart_totals' ); ?>


		<li class="subtotal">
			<div class="name"><?php _e( 'Cart Subtotal', 'woocommerce' ); ?></div>
			<div class="value"><?php wc_cart_totals_subtotal_html(); ?></div>
		</li>

		<?php foreach ( WC()->cart->get_coupons( 'cart' ) as $code => $coupon ) : ?>
			<li class="cart-discount coupon-<?php echo esc_attr( $code ); ?>">
				<div class="name"><?php wc_cart_totals_coupon_label( $coupon ); ?></div>
				<div class="value"><?php wc_cart_totals_coupon_html( $coupon ); ?></div>
			</li>
		<?php endforeach; ?>

		<?php if ( WC()->cart->needs_shipping() && WC()->cart->show_shipping() ) : ?>

			<?php do_action( 'woocommerce_cart_totals_before_shipping' ); ?>

			<?php wc_cart_totals_shipping_html(); ?>

			<?php do_action( 'woocommerce_cart_totals_after_shipping' ); ?>

		<?php endif; ?>

		<?php foreach ( WC()->cart->get_fees() as $fee ) : ?>
			<li class="fee">
				<div class="name"><?php echo esc_html( $fee->name ); ?></div>
				<div class="value"><?php wc_cart_totals_fee_html( $fee ); ?></div>
			</li>
		<?php endforeach; ?>

		<?php if ( WC()->cart->tax_display_cart == 'excl' ) : ?>
			<?php if ( get_option( 'woocommerce_tax_total_display' ) == 'itemized' ) : ?>
				<?php foreach ( WC()->cart->get_tax_totals() as $code => $tax ) : ?>
					<li class="tax-rate tax-rate-<?php echo sanitize_title( $code ); ?>">
						<div class="name"><?php echo esc_html( $tax->label ); ?></div>
						<div class="value"><?php echo wp_kses_post( $tax->formatted_amount ); ?></div>
					</li>
				<?php endforeach; ?>
			<?php else : ?>
				<li class="tax-total">
					<div class="name"><?php echo esc_html( WC()->countries->tax_or_vat() ); ?></div>
					<div class="value"><?php echo wc_cart_totals_taxes_total_html(); ?></div>
				</li>
			<?php endif; ?>
		<?php endif; ?>

		<?php foreach ( WC()->cart->get_coupons( 'order' ) as $code => $coupon ) : ?>
			<li class="order-discount coupon-<?php echo esc_attr( $code ); ?>">
				<div class="name"><?php wc_cart_totals_coupon_label( $coupon ); ?></div>
				<div class="value"><?php wc_cart_totals_coupon_html( $coupon ); ?></div>
			</li>
		<?php endforeach; ?>

		<?php do_action( 'woocommerce_cart_totals_before_order_total' ); ?>

		<li class="total">
			<div class="name"><?php _e( 'Order Total', 'woocommerce' ); ?></div>
			<div class="value"><?php wc_cart_totals_order_total_html(); ?></div>
		</li>

		<?php do_action( 'woocommerce_cart_totals_after_order_total' ); ?>


	<?php if ( WC()->cart->get_cart_tax() ) : ?>
		<p><small><?php

			$estimated_text = WC()->customer->is_customer_outside_base() && ! WC()->customer->has_calculated_shipping()
				? sprintf( ' ' . __( ' (taxes estimated for %s)', 'woocommerce' ), WC()->countries->estimated_for_prefix() . __( WC()->countries->countries[ WC()->countries->get_base_country() ], 'woocommerce' ) )
				: '';

			printf( __( 'Note: Shipping and taxes are estimated%s and will be updated during checkout based on your billing and shipping information.', 'woocommerce' ), $estimated_text );

		?></small></p>
	<?php endif; ?>

	<?php do_action( 'woocommerce_after_cart_totals' ); ?>