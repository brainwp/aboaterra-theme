<?php
/**
 * Review order table
 *
 * This template can be overridden by copying it to yourtheme/woocommerce/checkout/review-order.php.
 *
 * HOWEVER, on occasion WooCommerce will need to update template files and you
 * (the theme developer) will need to copy the new files to your theme to
 * maintain compatibility. We try to do this as little as possible, but it does
 * happen. When this occurs the version of the template file will be bumped and
 * the readme will list any important changes.
 *
 * @see 	    http://docs.woothemes.com/document/template-structure/
 * @author 		WooThemes
 * @package 	WooCommerce/Templates
 * @version     2.3.0
 */

if ( ! defined( 'ABSPATH' ) ) {
	exit;
}
?>
<div class="col-md-12 review-order-section">
	<div class="row" id="product-list">
		<?php get_template_part( 'parts/checkout-product-list' );?>
	</div><!-- .row -->
		<div class="row">
			<div class="col-md-12 cart-subtotal">
				<h5 class="section-info"><?php _e( 'Sub-total', 'odin');?></h5><!-- .section-info -->
				<span id="checkout-subtotal">
					<?php wc_cart_totals_subtotal_html(); ?>
				</span>
			</div><!-- .col-md-12 cart-subtotal -->

			<div class="col-md-12 cart-subtotal delivery" style="display:none;">
				<h5 class="section-info"><?php _e( 'Frete', 'odin');?></h5><!-- .section-info -->
				<span class="amount"></span>
			</div><!-- .col-md-12 cart-subtotal -->

			<?php foreach ( WC()->cart->get_coupons() as $code => $coupon ) : ?>
				<div class="col-md-12 coupon title">
					<?php wc_cart_totals_coupon_label( $coupon ); ?>
				</div><!-- .col-md-12 cart-subtotal -->
				<div class="col-md-12 coupon price">
					<?php wc_cart_totals_coupon_html( $coupon );?>
				</div><!-- .col-md-12 cart-subtotal -->
			<?php endforeach; ?>

		<?php foreach ( WC()->cart->get_fees() as $fee ) : ?>
			<div class="col-md-12 fee title">
				<?php echo esc_html( $fee->name ); ?>
			</div><!-- .col-md-12 cart-subtotal -->
			<div class="col-md-12 fee price">
				<?php wc_cart_totals_fee_html( $fee ); ?>
			</div><!-- .col-md-12 cart-subtotal -->

		<?php endforeach; ?>
		<?php if ( wc_tax_enabled() && 'excl' === WC()->cart->tax_display_cart ) : ?>
			<?php if ( 'itemized' === get_option( 'woocommerce_tax_total_display' ) ) : ?>
				<?php foreach ( WC()->cart->get_tax_totals() as $code => $tax ) : ?>
					<div class="col-md-12 total">
						<?php echo esc_html( $tax->label ); ?>
						<?php echo wp_kses_post( $tax->formatted_amount ); ?>
					</div><!-- .col-md-12 total -->
				<?php endforeach; ?>
			<?php else : ?>
				<div class="col-md-12 total">
					<?php echo esc_html( WC()->countries->tax_or_vat() ); ?>
					<?php wc_cart_totals_taxes_total_html(); ?>
				</div><!-- .col-md-12 total -->
			<?php endif; ?>
		<?php endif; ?>
		<?php do_action( 'woocommerce_review_order_before_order_total' ); ?>

			<div class="col-md-12 total" id="checkout-total">
				<?php _e( 'Total:', 'odin');?>
				<?php wc_cart_totals_order_total_html(); ?>
			</div><!-- .col-md-12 total -->
		<?php do_action( 'woocommerce_review_order_after_order_total' ); ?>
	</div><!-- .row -->
</div><!-- .col-md-12 review-order-section -->
