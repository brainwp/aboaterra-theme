<?php
/**
 *
 * checkout product list
 *
*/
do_action( 'woocommerce_review_order_before_cart_contents' );

	foreach ( WC()->cart->get_cart() as $cart_item_key => $cart_item ) {
		$_product     = apply_filters( 'woocommerce_cart_item_product', $cart_item['data'], $cart_item, $cart_item_key );
		if ( isset( $cart_item['bundled_by'] ) ) {
			continue;
		}

			if ( $_product && $_product->exists() && $cart_item['quantity'] > 0 && apply_filters( 'woocommerce_checkout_cart_item_visible', true, $cart_item, $cart_item_key ) ) {
					?>
				<a class="each-product-checkout" href="<?php echo get_permalink( $_product->id );?>">
					<div class="col-xs-2 thumbnail">
						<?php echo get_the_post_thumbnail( $_product->id );?>
					</div><!-- .col-md-2 -->
					<div class="col-xs-6 name">
						<?php echo apply_filters( 'woocommerce_cart_item_name', $_product->get_title(), $cart_item, $cart_item_key ) . '&nbsp;'; ?>
						<?php echo apply_filters( 'woocommerce_checkout_cart_item_quantity', ' <strong class="product-quantity">' . sprintf( '&times; %s', $cart_item['quantity'] ) . '</strong>', $cart_item, $cart_item_key ); ?>
						<?php echo WC()->cart->get_item_data( $cart_item ); ?>
					</div><!-- .col-md-6 -->
					<div class="col-xs-4 price">
						<?php echo apply_filters( 'woocommerce_cart_item_subtotal', WC()->cart->get_product_subtotal( $_product, $cart_item['quantity'] ), $cart_item, $cart_item_key ); ?>
					</div><!-- .col-md-12 price -->
				</a>
				<?php
				}
	}
	do_action( 'woocommerce_review_order_after_cart_contents' );
?>
