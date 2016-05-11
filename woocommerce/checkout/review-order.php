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
	<div class="row">
			<?php
			do_action( 'woocommerce_review_order_before_cart_contents' );

			foreach ( WC()->cart->get_cart() as $cart_item_key => $cart_item ) {
				$_product     = apply_filters( 'woocommerce_cart_item_product', $cart_item['data'], $cart_item, $cart_item_key );

				if ( $_product && $_product->exists() && $cart_item['quantity'] > 0 && apply_filters( 'woocommerce_checkout_cart_item_visible', true, $cart_item, $cart_item_key ) ) {
					?>
					<a class="each-product-checkout" href="<?php echo get_permalink( $_product->id );?>">
						<div class="col-md-2 thumbnail">
							<?php echo get_the_post_thumbnail( $_product->id );?>
						</div><!-- .col-md-2 -->
						<div class="col-md-6 name">
							<?php echo apply_filters( 'woocommerce_cart_item_name', $_product->get_title(), $cart_item, $cart_item_key ) . '&nbsp;'; ?>
							<?php echo apply_filters( 'woocommerce_checkout_cart_item_quantity', ' <strong class="product-quantity">' . sprintf( '&times; %s', $cart_item['quantity'] ) . '</strong>', $cart_item, $cart_item_key ); ?>
							<?php echo WC()->cart->get_item_data( $cart_item ); ?>
						</div><!-- .col-md-6 -->
						<div class="col-md-4 price">
							<?php echo apply_filters( 'woocommerce_cart_item_subtotal', WC()->cart->get_product_subtotal( $_product, $cart_item['quantity'] ), $cart_item, $cart_item_key ); ?>
						</div><!-- .col-md-12 price -->
					</a>
					<?php
				}
			}

			do_action( 'woocommerce_review_order_after_cart_contents' );
			?>

		</div><!-- .row -->
		<div class="row">
			<div class="col-md-12 cart-subtotal">
				<h5 class="section-info"><?php _e( 'Sub-total', 'odin');?></h5><!-- .section-info -->
				<?php wc_cart_totals_subtotal_html(); ?>
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

		<?php //do_action( 'woocommerce_review_order_before_order_total' ); ?>

			<div class="col-md-12 total">
				<?php _e( 'Total:', 'odin');?>
				<?php wc_cart_totals_order_total_html(); ?>
			</div><!-- .col-md-12 total -->
		<?php do_action( 'woocommerce_review_order_after_order_total' ); ?>

	</div><!-- .row -->
</div><!-- .col-md-12 review-order-section -->
