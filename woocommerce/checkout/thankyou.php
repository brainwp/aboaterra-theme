<?php
/**
 * Thankyou page
 *
 * This template can be overridden by copying it to yourtheme/woocommerce/checkout/thankyou.php.
 *
 * HOWEVER, on occasion WooCommerce will need to update template files and you
 * (the theme developer) will need to copy the new files to your theme to
 * maintain compatibility. We try to do this as little as possible, but it does
 * happen. When this occurs the version of the template file will be bumped and
 * the readme will list any important changes.
 *
 * @see 	    https://docs.woocommerce.com/document/template-structure/
 * @author 		WooThemes
 * @package 	WooCommerce/Templates
 * @version     2.2.0
 */


if ( ! defined( 'ABSPATH' ) ) {
	exit;
}


if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

if ( $order ) : ?>
	<?php if ( $order->has_status( 'failed' ) ) : ?>

		<p class="woocommerce-thankyou-order-failed"><?php _e( 'Unfortunately your order cannot be processed as the originating bank/merchant has declined your transaction. Please attempt your purchase again.', 'woocommerce' ); ?></p>

		<p class="woocommerce-thankyou-order-failed-actions">
			<a href="<?php echo esc_url( $order->get_checkout_payment_url() ); ?>" class="button pay"><?php _e( 'Pay', 'woocommerce' ) ?></a>
			<?php if ( is_user_logged_in() ) : ?>
				<a href="<?php echo esc_url( wc_get_page_permalink( 'myaccount' ) ); ?>" class="button pay"><?php _e( 'My Account', 'woocommerce' ); ?></a>
			<?php endif; ?>
		</p>

	<?php else : ?>

	<div class="thank">

		<p class="woocommerce-thankyou-order-received"><?php echo apply_filters( 'woocommerce_thankyou_order_received_text', __( 'Agradecemos por escolher A Boa Terra!' ), $order ); ?></p>
		<p class="quote">"Saúde para você e vida para o planeta"</p>

		<div class="thankyou col-md-7">
			<div class="orderd"><?php _e( 'Pedido Número:', 'woocommerce' ); ?></div>
			<div class="oder-number"><?php echo $order->get_order_number(); ?></div>
		</div>
		<div class="tY">
			<div class="uH">Que tal acompanhar o que acontece aqui na roça!?</div>
			<div class="socialM">
					<?php if ( $value = get_theme_mod( 'facebook', false ) ) : ?>
						<a href="<?php echo esc_url( $value );?>" class="rounded-icon">
							<i class="fa fa-facebook"></i>
						</a>
					<?php endif;?>
					<?php if ( $value = get_theme_mod( 'instagram', false ) ) : ?>
						<a href="<?php echo esc_url( $value );?>" class="rounded-icon">
							<i class="fa fa-instagram"></i>
						</a>
					<?php endif;?>
			</div>
		</div>

	</div>


	<?php endif; ?>

	<?php do_action( 'woocommerce_thankyou_' . $order->payment_method, $order->id ); ?>
	<?php do_action( 'woocommerce_thankyou', $order->id ); ?>

<?php else : ?>

	<p class="woocommerce-thankyou-order-received"><?php echo apply_filters( 'woocommerce_thankyou_order_received_text', __( 'Thank you. Your order has been received.', 'woocommerce' ), null ); ?></p>

<?php endif; ?>
