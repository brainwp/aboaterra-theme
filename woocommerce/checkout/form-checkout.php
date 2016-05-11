<?php
/**
 * Checkout Form
 *
 * This template can be overridden by copying it to yourtheme/woocommerce/checkout/form-checkout.php.
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

wc_print_notices();

do_action( 'woocommerce_before_checkout_form', $checkout );

// If checkout registration is disabled and not logged in, the user cannot checkout
if ( ! $checkout->enable_signup && ! $checkout->enable_guest_checkout && ! is_user_logged_in() ) {
	echo apply_filters( 'woocommerce_checkout_must_be_logged_in_message', __( 'You must be logged in to checkout.', 'woocommerce' ) );
	return;
}

?>
<div class="col-md-12 form-checkout">
	<div class="container">
		<div class="row">
			<form name="checkout" method="post" class="checkout woocommerce-checkout" action="<?php echo esc_url( wc_get_checkout_url() ); ?>" enctype="multipart/form-data">

				<?php do_action( 'woocommerce_checkout_before_customer_details' ); ?>
				<div class="col-md-4">
					<h3 class="section-title"><?php _e( 'Dados pessoais', 'odin');?></h3><!-- .section-title -->
					<div class="col-md-12 section-block">
						<?php do_action( 'woocommerce_checkout_billing' ); ?>
					</div><!-- .col-md-12 section-block -->
				</div><!-- .col-md-4 -->
				<div class="col-md-4">
					<div id="customer-details">
						<h3 class="section-title"><?php _e( 'Entrega', 'odin');?></h3><!-- .section-title -->
						<div class="col-md-12 section-block">
							<?php do_action( 'woocommerce_checkout_shipping' ); ?>
							<?php if ( WC()->cart->needs_shipping() && WC()->cart->show_shipping() ) : ?>

								<?php do_action( 'woocommerce_review_order_before_shipping' ); ?>

								<?php wc_cart_totals_shipping_html(); ?>

								<?php do_action( 'woocommerce_review_order_after_shipping' ); ?>

							<?php endif; ?>
						</div>
					</div><!-- #customer-details -->
					<h3 class="section-title"><?php _e( 'Pagamento', 'odin');?></h3><!-- .section-title -->
					<div class="col-md-12 section-block">
						<?php woocommerce_checkout_payment();?>
					</div><!-- .col-md-12 section-block -->
				</div><!-- .col-md-4 -->
				<div class="col-md-4">
					<h3 class="section-title"><?php _e( 'Resumo do pedido', 'odin');?></h3><!-- .section-title -->
					<div id="order_review" class="woocommerce-checkout-review-order col-md-12">
						<?php do_action( 'woocommerce_checkout_before_order_review' ); ?>
						<?php do_action( 'woocommerce_checkout_order_review' ); ?>
						<?php do_action( 'woocommerce_checkout_after_order_review' ); ?>
						<?php woocommerce_checkout_coupon_form();?>
					</div>
				</div><!-- .col-md-4 -->
				<?php do_action( 'woocommerce_checkout_after_customer_details' ); ?>
			</form>

			<?php do_action( 'woocommerce_after_checkout_form', $checkout ); ?>
		</div><!-- .row -->
	</div><!-- .container -->
</div><!-- .col-md-12 form-checkout -->
