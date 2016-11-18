<?php
/**
 * The template for displaying product content within loops
 *
 * This template can be overridden by copying it to yourtheme/woocommerce/content-product.php.
 *
 * HOWEVER, on occasion WooCommerce will need to update template files and you
 * (the theme developer) will need to copy the new files to your theme to
 * maintain compatibility. We try to do this as little as possible, but it does
 * happen. When this occurs the version of the template file will be bumped and
 * the readme will list any important changes.
 *
 * @see     https://docs.woocommerce.com/document/template-structure/
 * @author  WooThemes
 * @package WooCommerce/Templates
 * @version 2.6.1
 */

if ( ! defined( 'ABSPATH' ) ) {
	exit; // Exit if accessed directly
}

global $product;

// Ensure visibility
if ( empty( $product ) || ! $product->is_visible() ) {
	return;
}
?>
<li <?php post_class(); ?>>
	<?php if ( is_page_template( 'page-cestas.php' ) ) : ?>
		<div class="each-cesta-title">
			<?php if ( $value = get_post_meta( get_the_ID(), 'cesta_title', true ) ) : ?>
				<h3>
					<?php $value = nl2br( $value );?>
					<?php echo apply_filters( 'the_title', $value );?>
				</h3>
			<?php endif;?>
		</div><!-- .each-cesta-title -->
	<div class="all-product">
	<?php endif;?>
	<?php
	/**
	 * woocommerce_before_shop_loop_item hook.
	 *
	 * @hooked woocommerce_template_loop_product_link_open - 10
	 */
	do_action( 'woocommerce_before_shop_loop_item' );

	/**
	 * woocommerce_before_shop_loop_item_title hook.
	 *
	 * @hooked woocommerce_show_product_loop_sale_flash - 10
	 * @hooked woocommerce_template_loop_product_thumbnail - 10
	 */
	do_action( 'woocommerce_before_shop_loop_item_title' );
	if ( $product->product_type == 'yith_bundle' && is_page_template( 'page-cestas.php' ) ) :
		echo '<h3>' . count( $product->bundle_data ) . ' '. __( 'Ítens' ) . '</h3>';
	endif;

	/**
	 * woocommerce_shop_loop_item_title hook.
	 *
	 * @hooked woocommerce_template_loop_product_title - 10
	 */
	if ( ! is_page_template( 'page-cestas.php' ) ) {
		do_action( 'woocommerce_shop_loop_item_title' );
	}

	/**
	 * woocommerce_after_shop_loop_item_title hook.
	 *
	 * @hooked woocommerce_template_loop_rating - 5
	 * @hooked woocommerce_template_loop_price - 10
	 */
	do_action( 'woocommerce_after_shop_loop_item_title' );

	/**
	 * woocommerce_after_shop_loop_item hook.
	 *
	 * @hooked woocommerce_template_loop_product_link_close - 5
	 * @hooked woocommerce_template_loop_add_to_cart - 10
	 */
	do_action( 'woocommerce_after_shop_loop_item' );
	?>
	<?php if ( is_page_template( 'page-cestas.php' ) ) : ?>
	</div>
		<?php if ( $value = get_post_meta( get_the_ID(), 'cesta_content', true ) ) : ?>
			<div class="description">
				<?php $value = nl2br( $value );?>
				<?php echo apply_filters( 'the_title', $value ); ?>
			</div><!-- .description -->
		<?php endif;?>
	<?php endif;?>
</li>
