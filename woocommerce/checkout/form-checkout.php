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
	<div class="row">
			<form name="checkout" method="post" class="checkout woocommerce-checkout" action="<?php echo esc_url( wc_get_checkout_url() ); ?>" enctype="multipart/form-data">

				<?php do_action( 'woocommerce_checkout_before_customer_details' ); ?>
				<div class="col-md-4 checkout-column">
					<h3 class="section-title"><?php _e( 'Dados pessoais', 'odin');?></h3><!-- .section-title -->
					<div class="col-md-12 section-block">
						<?php do_action( 'woocommerce_checkout_billing' ); ?>
						<div class="col-md-12 text-center">
							<a href="#delivery-col" class="btn btn-next btn-animation-next">
								<?php _e( 'Ir para entrega' );?>
							</a>
						</div><!-- .col-md-12 text-center -->
					</div><!-- .col-md-12 section-block -->
				</div><!-- .col-md-4 -->
				<div class="col-md-4 checkout-col" id="delivery-col">
					<div id="customer-details">
						<h3 class="section-title"><?php _e( 'Entrega', 'odin');?></h3><!-- .section-title -->
						<div class="col-md-12 section-block">
							<?php do_action( 'woocommerce_checkout_shipping' ); ?>
							<?php if ( WC()->cart->needs_shipping() && WC()->cart->show_shipping() ) : ?>

								<?php do_action( 'woocommerce_review_order_before_shipping' ); ?>

								<?php wc_cart_totals_shipping_html(); ?>

								<?php do_action( 'woocommerce_review_order_after_shipping' ); ?>
							<?php endif; ?>
							<div class="col-md-12 text-center">
								<a href="#payment-block" class="btn btn-next btn-animation-next">
									<?php _e( 'Ir para o pagamento' );?>
								</a>
							</div><!-- .col-md-12 text-center -->
						</div>
					</div><!-- #customer-details -->
					<h3 class="section-title"><?php _e( 'Pagamento', 'odin');?></h3><!-- .section-title -->
					<div class="col-md-12 section-block" id="payment-block">
						<?php woocommerce_checkout_payment();?>
					</div><!-- .col-md-12 section-block -->
				</div><!-- .col-md-4 -->
				<div class="col-md-4 checkout-column">
					<h3 class="section-title"><?php _e( 'Resumo do pedido', 'odin');?></h3><!-- .section-title -->
					<div id="order_review" class="woocommerce-checkout-review-order col-md-12">
						<?php do_action( 'woocommerce_checkout_before_order_review' ); ?>
						<?php do_action( 'woocommerce_checkout_order_review' ); ?>
						<?php do_action( 'woocommerce_checkout_after_order_review' ); ?>
						<?php get_template_part( 'parts/form-coupon-checkout' );?>
						<div class="form-row place-order pull-right">
							<noscript>
								<?php _e( 'Since your browser does not support JavaScript, or it is disabled, please ensure you click the <em>Update Totals</em> button before placing your order. You may be charged more than the amount stated above if you fail to do so.', 'woocommerce' ); ?>
								<br/><input type="submit" class="button alt" name="woocommerce_checkout_update_totals" value="<?php esc_attr_e( 'Update totals', 'woocommerce' ); ?>" />
							</noscript>

							<?php wc_get_template( 'checkout/terms.php' ); ?>

							<?php do_action( 'woocommerce_review_order_before_submit' ); ?>
							<?php $order_button_text = __( 'Finalizar compra', 'odin' );?>
							<?php echo apply_filters( 'woocommerce_order_button_html', '<input type="submit" class="button alt" name="woocommerce_checkout_place_order" id="place_order" value="' . esc_attr( $order_button_text ) . '" data-value="' . esc_attr( $order_button_text ) . '" />' ); ?>

							<?php do_action( 'woocommerce_review_order_after_submit' ); ?>

							<?php wp_nonce_field( 'woocommerce-process_checkout' ); ?>
						</div>

					</div>
				</div><!-- .col-md-4 -->
				<?php do_action( 'woocommerce_checkout_after_customer_details' ); ?>
			</form>

			<?php do_action( 'woocommerce_after_checkout_form', $checkout ); ?>
	</div><!-- .row -->
</div><!-- .col-md-12 form-checkout -->
