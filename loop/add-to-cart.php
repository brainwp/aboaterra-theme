<?php
/**
 * Loop Add to Cart
 *
 * This template can be overridden by copying it to yourtheme/woocommerce/loop/add-to-cart.php.
 *
 * HOWEVER, on occasion WooCommerce will need to update template files and you
 * (the theme developer) will need to copy the new files to your theme to
 * maintain compatibility. We try to do this as little as possible, but it does
 * happen. When this occurs the version of the template file will be bumped and
 * the readme will list any important changes.
 *
 * @see 	    https://docs.woocommerce.com/document/template-structure/
 * @package 	WooCommerce/Templates
 * @version     3.3.0
 */
 add_filter( 'single_add_to_cart_text', 'cs_add_to_cart_text' );
if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

global $product;
if ( ! isset( $quantity ) ) {
	$quantity = 1;
}
if ( isset( $class ) ) {
	$class .= ' ajax_add_to_cart';
}
else {
	$class = ' ajax_add_to_cart';
}

?>
<div class="add-to-cart-container">
	<div class="buttons-qty col-md-8 pull-left col-xs-12">
		<span>+</span>
 		<input data-id="<?php echo $product->get_id();?>" type="text" value="<?php echo esc_attr( $quantity );?>" />
 		<span>-</span>
	</div><!-- .buttons-qty -->
	<div class="col-md-4 cart-btn">
		<?php
		echo apply_filters( 'woocommerce_loop_add_to_cart_link',
			sprintf( '<a rel="nofollow" href="%s" data-quantity="%s" data-product_id="%s" data-product_sku="%s" class="%s col-xs-12">%s</a>',
				esc_url( $product->add_to_cart_url() ),
				esc_attr( $quantity ),
				esc_attr( $product->get_id() ),
				esc_attr( $product->get_sku() ),
				esc_attr( isset( $class ) ? $class : 'button' ),
				'<i class="fa fa-shopping-cart hhgg col-xs-12"></i>'
			),
			$product );
		?>
	</div><!-- .col-md-8 pull-right -->
</div><!-- .add-to-cart-container -->
