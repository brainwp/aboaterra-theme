<?php
/**
 * General functions used to integrate this theme with WooCommerce.
 *
 * @package odin
 */

if ( ! function_exists( 'odin_before_content' ) ) {
	/**
	 * Before Content
	 * Wraps all WooCommerce content in wrappers which match the theme markup
	 * @since   2.2.6
	 * @return  void
	 */
	function odin_before_content() {
		global $post;
		$product = wc_get_product( $post->ID );

		if ( is_singular() && is_object( $product ) && $product->is_type( 'yith_bundle' ) ) : ?>
			<main id="content" class="col-md-10" tabindex="-1" role="main">
		<?php elseif ( is_singular() ): ?>
			<main id="content" class="<?php echo odin_classes_page_sidebar(); ?>" tabindex="-1" role="main">
		<?php else : ?>
			<main id="content" class="col-md-12" tabindex="-1" role="main">
		<?php endif;
	}
}

if ( ! function_exists( 'odin_after_content' ) ) {
	/**
	 * After Content
	 * Closes the wrapping divs
	 * @since   2.2.6
	 * @return  void
	 */
	function odin_after_content() {
		?>
		</main><!-- #main -->
		<?php
	}
}

/**
 * Default loop columns on product archives
 * @return integer products per row
 * @since  2.2.6
 */
function odin_loop_columns() {
	return apply_filters( 'odin_loop_columns', 4 ); // 4 products per row
}

/**
 * Product gallery thumnail columns
 * @return integer number of columns
 * @since  2.2.6
 */
function odin_thumbnail_columns() {
	return intval( apply_filters( 'odin_product_thumbnail_columns', 4 ) );
}

/**
 * Products per page
 * @return integer number of products
 * @since  2.2.6
 */
function odin_products_per_page() {
	return intval( apply_filters( 'odin_products_per_page', 12 ) );
}
/**
 * Get WooCommerce My Account Page URL
 * @return string
 */
function odin_get_my_account_url() {
	$id = get_option( 'woocommerce_myaccount_page_id' );
	if ( $id ) {
		return get_permalink( $id );
	}
	return '#';
}
function woocommerce_button_proceed_to_checkout() {
       $checkout_url = WC()->cart->get_checkout_url();
       ?>
       <a href="<?php echo $checkout_url; ?>" class="checkout-button button alt wc-forward"><?php _e( 'Finalizar Pedido', 'woocommerce' ); ?></a>
       <?php
     }
