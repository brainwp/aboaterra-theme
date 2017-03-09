<?php
/**
 * odin WooCommerce hooks
 *
 * @package odin
 */

/**
 * Remove native styles
 *
 */
// add_filter( 'woocommerce_enqueue_styles', '__return_empty_array' );

/**
 * Content wrapper before and after
 * @see  odin_before_content()
 * @see  odin_after_content()
 * @since  2.2.6
 */
remove_action( 'woocommerce_before_main_content', 'woocommerce_output_content_wrapper', 10 );
remove_action( 'woocommerce_after_main_content', 'woocommerce_output_content_wrapper_end', 10 );
add_action( 'woocommerce_before_main_content', 'odin_before_content', 10 );
add_action( 'woocommerce_after_main_content', 'odin_after_content', 10 );

/**
 * Remove sidebar
 *
 * Tip:
 * Case you use this action, change template page for full-width style in inc/woocommerce/template-tags.php
 *
 * @see woocommerce_sidebars
 * @since  2.2.6
 */
// remove_action( 'woocommerce_sidebar', 'woocommerce_get_sidebar', 10 );

/**
 * Breadcrumb
 *
 * Use:
 * do_action( 'odin_content_top' ); on anywhere for show the breadcrumb
 *
 * @see woocommerce_breadcrumb
 * @since  2.2.6
 */
remove_action( 'woocommerce_before_main_content', 'woocommerce_breadcrumb', 20, 0 );
add_action( 'odin_content_top', 'woocommerce_breadcrumb', 10 );

/**
 * Filters
 * @see  odin_thumbnail_columns()
 * @see  odin_products_per_page()
 * @see  odin_loop_columns()
 * @since  2.2.6
 */
add_filter( 'woocommerce_product_thumbnails_columns', 	'odin_thumbnail_columns' );;
add_filter( 'loop_shop_per_page', 						'odin_products_per_page' );
add_filter( 'loop_shop_columns', 						'odin_loop_columns' );

/**
 * Show link to cart in single product
 * @return write
 */
function show_cart_link_after_btn() {
	printf( '<a href="%s" class="btn btn-primary btn-cart-link">%s</a>', WC()->cart->get_cart_url(), __( 'Finalizar compra', 'odin' ) );
}
add_action( 'woocommerce_after_add_to_cart_button', 'show_cart_link_after_btn' );
/**
 * Show input qty on single product
 * @return write
 */
function show_select_qty_btn_single() {
	global $product;
	$qty = ( isset( $_POST['quantity'] ) ? wc_stock_amount( $_POST['quantity'] ) : 1 );
	if ( ! $product->is_sold_individually() ) {
		echo '<div class="buttons-qty">';
		echo '<span>+</span>';
 		echo '<input class="single-product" data-id="' . $product->id . '" type="text" value="' . $qty . '" />';
 		echo '<span>-</span>';
 		echo '</div>';
	}
}
add_action( 'woocommerce_before_add_to_cart_button', 'show_select_qty_btn_single' );

// remove related products
remove_action( 'woocommerce_after_single_product_summary', 'woocommerce_output_related_products', 20);

// remove payment from review section on checkout
remove_action( 'woocommerce_checkout_order_review', 'woocommerce_checkout_payment', 20 );

function change_woocommerce_pagination_text( $args ) {
	$args['prev_text'] = '<';
	$args['next_text'] = '>';
	return $args;
}
add_filter( 'woocommerce_pagination_args', 'change_woocommerce_pagination_text' );
/**
 * Redirect to my account page on login failed
 * @param string $username
 * @return null
 */
function redirect_to_my_account_on_fail( $username ) {
	wc_add_notice( __( 'Ocorreu um erro ao fazer login: Verifique suas credenciais e tente novamente.', 'odin' ), 'error' );
	wp_redirect( odin_get_my_account_url() . '?login_failed=true' );
	exit;
}
add_action( 'wp_login_failed', 'redirect_to_my_account_on_fail' );

function aboaterra_remove_reviews( $tabs ) {
	unset( $tabs['reviews'] );
	return $tabs;
}
add_filter( 'woocommerce_product_tabs', 'aboaterra_remove_reviews', 98 );

// remove order again button after order items table
remove_action( 'woocommerce_order_details_after_order_table', 'woocommerce_order_again_button' );

/**
 * update mini cart on header
 * @return null
 */
function wc_update_header_cart() {
	get_template_part( 'parts/wc-infos' );
	wp_die();
}
add_action( 'wp_ajax_update_header_cart', 'wc_update_header_cart' );
add_action( 'wp_ajax_nopriv_update_header_cart', 'wc_update_header_cart' );
/**
 * Remove billing company field from checkout
 * @param array $fields
 * @return array
 */
function remove_billing_company_wc_checkout( $fields ) {
	unset( $fields[ 'billing']['billing_company'] );
	return $fields;
}
add_filter( 'woocommerce_checkout_fields' , 'remove_billing_company_wc_checkout' );

/**
 * Button for empty WC cart
 * @return type
 */
function aboaterra_empty_cart() {
	if ( ! isset( $_GET[ 'empty_cart'] ) ) {
		return;
	}
	if ( ! wp_verify_nonce( $_REQUEST[ '_wpnonce' ], 'empty_cart' ) ) {
		return;
	}
	WC()->cart->empty_cart();
	wp_redirect( home_url() );
	exit;
}
add_action( 'init', 'aboaterra_empty_cart', 9999 );
/**
 * Remove WooCommerce wc-checkout js
 */
function aboaterra_remove_woocommerce_scripts() {
	if ( is_checkout() ) {
		wp_deregister_script( 'wc-checkout' );
		wp_dequeue_script( 'wc-checkout' );
	}
}
add_action( 'wp_head', 'aboaterra_remove_woocommerce_scripts', 9999 );
