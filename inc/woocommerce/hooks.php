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
	//$fields[ 'billing']['billing_company']['required'] = true;

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
/* muda texto do botão de ir pro checkout */

add_filter( 'woocommerce_order_button_text', 'woo_custom_order_button_text' );

function woo_custom_order_button_text() {
    return __( 'Fechar Pedido', 'woocommerce' );
}
add_filter( 'woocommerce_shipping_package_name', 'custom_shipping_package_name' );
function custom_shipping_package_name( $name ) {
  return 'Frete';
}
function adiciona_limpa_carrinho() {
	?>
	<div class="col-md-12 cart-links">
		<?php if ( ! wp_is_mobile() ) : ?>
			<div class="col-md-12 pull-left">
				<div class="col-md-6">
					<a href="<?php echo home_url();?>" class="btn btn-cart-link">
						<?php _e( 'Continuar comprando', 'odin' );?>
					</a>
				</div>
				<div class="col-md-6">
					<?php $empty_cart_url = WC()->cart->get_cart_url . '?empty_cart=true';?>
					<a href="<?php echo wp_nonce_url( $empty_cart_url, 'empty_cart' );?>" class="btn btn-cart-link" id="cart-empty-link" data-confirm="<?php esc_attr_e( 'Clique em OK para esvaziar o carrinho de compras e retornar para página inicial', 'odin' );?>">
						<?php _e( 'Esvaziar Carrinho', 'odin' );?>
					</a>
				</div>
			</div><!-- .pull-left -->
		<?php else : ?>
			<div class="col-md-6 pull-left">
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
	<?php
}
add_action( 'woocommerce_after_cart', 'adiciona_limpa_carrinho' );

// ---------------------------------------------
// Display Only 3 Cross Sells instead of default 4

add_filter( 'woocommerce_cross_sells_total', 'bbloomer_change_cross_sells_product_no' );

function bbloomer_change_cross_sells_product_no( $columns ) {
	return 4;
}

// tira imagens de itens de bundle products
add_filter( 'woocommerce_cart_item_thumbnail', 'no_image_for_bundle', 10, 3 );
function no_image_for_bundle(  $product_get_image, $cart_item, $cart_item_key  ) {
	if ($cart_item['bundled_by']) {
		return ;
	}
	else{return $product_get_image;}


}
// adiciona o link para abrir bundles filhos
add_action( 'woocommerce_after_cart_item_name', 'bundle_child_link', 10, 2);
function bundle_child_link($cart_item, $cart_item_key) {
	// print_r($cart_item);
	// die;
	if ($cart_item['bundled_items']) {
		?>
		<div><a data-key="<?php echo $cart_item_key ?>" class=" button open-bundle-links" href="#open-bundle-links">Ver itens</a></div>
		<?php
	}
}
function key_on_class( $class, $values, $values_key ) {
        $class .= ' '.$values['bundled_by'];
    return $class;
}
add_filter( 'woocommerce_cart_item_class', 'key_on_class', 10, 3 );

// adiciona campo no dashboard do my_account
add_action( 'woocommerce_account_dashboard', 'altera_myaccount_dashboard', 10);

function altera_myaccount_dashboard()
{
	$user = wp_get_current_user();
	$fields = Brasa_WC_Extra_Fields::get_instance()->get_billing_fields();
	?>
	<section class="billing-data">
		<h4 class="titleDP">
			<?php _e( 'Dados Pessoais', 'odin' );?>
		</h4>
		<?php foreach( $fields as $key => $name ) : ?>
			<div class="each-item col-md-12">

				<div class="pull-left title">
					<?php echo $name;?>
				</div><!-- .col-md-5 pull-left title -->
				<div class="pull-right data">
					<?php if ( $key == 'email' ) : ?>
						<?php $value = $user->user_email;?>
					<?php else : ?>
						<?php $value = get_user_meta( $user->ID, $key, true );?>
						<?php
							if ( ! $value ) $value = '';
							if ($key == 'billing_phone' && FALSE ) {
								$value_array = explode('-', $value);
								$value = "(".$value_array[1].")". " " .$value_array[2]. "-". $value_array[3] ;
							}
						?>
					<?php endif;?>
					<?php echo apply_filters( 'the_title', $value );?>
				</div><!-- .col-md-5 pull-right data -->
			</div><!-- .each-item -->
		<?php endforeach;?>
		<div class="text-right pull-right text-right col-md-8 btt-clas-btt">
			<a href="<?php echo get_permalink( get_option('woocommerce_myaccount_page_id') ); ?>/edit-account" class="btn btn-primary btn-cart-link">
				<?php _e( 'Editar', 'odin' );?>
			</a>
		</div><!-- .text-right -->
	</section><!-- .col-md-10 pull-left billing-data -->
	<?php
}


/**
 * Add order again button in my orders actions.
 *
 * @param  array $actions
 * @param  WC_Order $order
 * @return array
 */
function cs_add_order_again_to_my_orders_actions( $actions, $order ) {
	if ( $order->has_status( 'completed' ) ) {
		$actions['order-again'] = array(
			'url'  => wp_nonce_url( add_query_arg( 'order_again', $order->id ) , 'woocommerce-order_again' ),
			'name' => __( 'Recomprar', 'woocommerce' )
		);
	}
	return $actions;
}
add_filter( 'woocommerce_my_account_my_orders_actions', 'cs_add_order_again_to_my_orders_actions', 50, 2 );
