<?php
/**
 * Cart totals
 *
 * This template can be overridden by copying it to yourtheme/woocommerce/cart/cart-totals.php.
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
 * @version     3.5.0
 */

if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

?>
<div class="cart_totals <?php if ( WC()->customer->has_calculated_shipping() ) echo 'calculated_shipping'; ?>">

	<?php do_action( 'woocommerce_before_cart_totals' ); ?>

	<table cellspacing="0" class="shop_table_responsive">

		<tr class="cart-subtotal">
			<th><?php _e( 'Subtotal', 'woocommerce' ); ?></th>
			<td data-title="<?php esc_attr_e( 'Subtotal', 'woocommerce' ); ?>"><?php wc_cart_totals_subtotal_html(); ?></td>
		</tr>

		<?php foreach ( WC()->cart->get_coupons() as $code => $coupon ) : ?>
			<tr class="cart-discount coupon-<?php echo esc_attr( sanitize_title( $code ) ); ?>">
				<th><?php wc_cart_totals_coupon_label( $coupon ); ?></th>
				<td data-title="<?php echo esc_attr( wc_cart_totals_coupon_label( $coupon, false ) ); ?>"><?php wc_cart_totals_coupon_html( $coupon ); ?></td>
			</tr>
		<?php endforeach; ?>

		<?php if ( WC()->cart->needs_shipping() && WC()->cart->show_shipping() ) : ?>

			<?php do_action( 'woocommerce_cart_totals_before_shipping' ); ?>
			<?php add_filter( 'woocommerce_shipping_package_name', 'custom_shipping_package_name' );
			function custom_shipping_package_name( $name ) {
			  return 'Frete';
			} ?>
			<?php wc_cart_totals_shipping_html(); ?>

			<?php do_action( 'woocommerce_cart_totals_after_shipping' ); ?>

		<?php endif; ?>

		<?php foreach ( WC()->cart->get_fees() as $fee ) : ?>
			<tr class="fee">
				<th><?php echo esc_html( $fee->name ); ?></th>
				<td data-title="<?php echo esc_attr( $fee->name ); ?>"><?php wc_cart_totals_fee_html( $fee ); ?></td>
			</tr>
		<?php endforeach; ?>

		<?php if ( wc_tax_enabled() && 'excl' === WC()->cart->tax_display_cart ) :
			$taxable_address = WC()->customer->get_taxable_address();
			$estimated_text  = WC()->customer->is_customer_outside_base() && ! WC()->customer->has_calculated_shipping()
					? sprintf( ' <small>(' . __( 'estimated for %s', 'woocommerce' ) . ')</small>', WC()->countries->estimated_for_prefix( $taxable_address[0] ) . WC()->countries->countries[ $taxable_address[0] ] )
					: '';

			if ( 'itemized' === get_option( 'woocommerce_tax_total_display' ) ) : ?>
				<?php foreach ( WC()->cart->get_tax_totals() as $code => $tax ) : ?>
					<tr class="tax-rate tax-rate-<?php echo sanitize_title( $code ); ?>">
						<th><?php echo esc_html( $tax->label ) . $estimated_text; ?></th>
						<td data-title="<?php echo esc_attr( $tax->label ); ?>"><?php echo wp_kses_post( $tax->formatted_amount ); ?></td>
					</tr>
				<?php endforeach; ?>
			<?php else : ?>
				<tr class="tax-total">
					<th><?php echo esc_html( WC()->countries->tax_or_vat() ) . $estimated_text; ?></th>
					<td data-title="<?php echo esc_attr( WC()->countries->tax_or_vat() ); ?>"><?php wc_cart_totals_taxes_total_html(); ?></td>
				</tr>
			<?php endif; ?>
		<?php endif; ?>

		<?php do_action( 'woocommerce_cart_totals_before_order_total' ); ?>

		<tr class="order-total">
			<th><?php _e( 'Total', 'woocommerce' ); ?></th>
			<td data-title="<?php esc_attr_e( 'Total', 'woocommerce' ); ?>"><?php wc_cart_totals_order_total_html(); ?></td>
		</tr>

		<?php do_action( 'woocommerce_cart_totals_after_order_total' ); ?>

	</table>

	<?php do_action( 'woocommerce_after_cart_totals' ); ?>

</div>
<div class="col-md-12 cart-links">
	<?php if ( ! wp_is_mobile() ) : ?>
		<div class="col-md-4 pull-left">
			<a href="<?php echo home_url();?>" class="btn btn-cart-link">
				<?php _e( 'Continuar comprando', 'odin' );?>
			</a>
			<?php $empty_cart_url = WC()->cart->get_cart_url . '?empty_cart=true';?>
			<a href="<?php echo wp_nonce_url( $empty_cart_url, 'empty_cart' );?>" class="btn btn-cart-link" id="cart-empty-link" data-confirm="<?php esc_attr_e( 'Clique em OK para esvaziar o carrinho de compras e retornar para página inicial', 'odin' );?>">
				<?php _e( 'Esvaziar Carrinho', 'odin' );?>
			</a>
		</div><!-- .pull-left -->
		<div class="col-md-4 pull-right text-right">
			<input type="submit" class="button btn btn-cart-link" name="update_cart" value="<?php esc_attr_e( 'Update Cart', 'woocommerce' ); ?>" style="display:none;"/>
			<?php do_action( 'woocommerce_proceed_to_checkout' ); ?>
		</div><!-- .col-md-5 pull-right -->
	<?php else : ?>
		<div class="col-md-12 pull-left">
			<?php do_action( 'woocommerce_proceed_to_checkout' ); ?>
			<a href="<?php echo home_url();?>" class="btn btn-cart-link">
				<?php _e( 'Continuar comprando', 'odin' );?>
			</a>
			<?php $empty_cart_url = WC()->cart->get_cart_url . '?empty_cart=true';?>
			<a href="<?php echo wp_nonce_url( $empty_cart_url, 'empty_cart' );?>" class="btn btn-cart-link" id="cart-empty-link" data-confirm="<?php esc_attr_e( 'Clique em OK para esvaziar o carrinho de compras e retornar para página inicial', 'odin' );?>">
				<?php _e( 'Esvaziar Carrinho', 'odin' );?>
			</a>
			<input type="submit" class="button btn btn-cart-link" name="update_cart" value="<?php esc_attr_e( 'Update Cart', 'woocommerce' ); ?>" style="display:none;"/>
		</div><!-- .pull-left -->
	<?php endif;?>
</div><!-- .col-md-12 cart-links -->
