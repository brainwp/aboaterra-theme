<?php
/**
 * Order details
 *
 * This template can be overridden by copying it to yourtheme/woocommerce/order/order-details.php.
 *
 * HOWEVER, on occasion WooCommerce will need to update template files and you
 * (the theme developer) will need to copy the new files to your theme to
 * maintain compatibility. We try to do this as little as possible, but it does
 * happen. When this occurs the version of the template file will be bumped and
 * the readme will list any important changes.
 *
 * @see 	https://docs.woocommerce.com/document/template-structure/
 * @author  WooThemes
 * @package WooCommerce/Templates
 * @version 3.5.2
 */

if ( ! defined( 'ABSPATH' ) ) {
	exit;
}
if ( ! $order = wc_get_order( $order_id ) ) {
	return;
}

$show_purchase_note    = $order->has_status( apply_filters( 'woocommerce_purchase_note_order_statuses', array( 'completed', 'processing' ) ) );
$show_customer_details = is_user_logged_in() && $order->get_user_id() === get_current_user_id();
?>
<h2><?php _e( 'Order details', 'woocommerce' ); ?></h2>

<table class="shop_table shop_table_responsive cart" cellspacing="0">
	<thead>
		<tr>
			<th class="product-thumbnail">&nbsp;</th>
			<th class="product-name"><?php _e( 'Product', 'woocommerce' ); ?></th>
			<th class="product-quantity"><?php _e( 'Quantity', 'woocommerce' ); ?></th>
			<th class="product-price"><?php _e( 'Preço unitário', 'odin' ); ?></th>
			<th class="product-subtotal"><?php _e( 'Preço total', 'odin' ); ?></th>
		</tr>
	</thead>
	<tbody>
		<?php do_action( 'woocommerce_before_cart_contents' ); ?>
		<?php
		foreach( $order->get_items() as $cart_item_key => $cart_item ) {
			if ( isset( $cart_item['bundled_by'] ) ) {
				continue;
			}

			$_product = $cart_item->get_product() ;

			$product_id = $_product->get_id();

			if ( $_product && apply_filters( 'woocommerce_cart_item_visible', true, $cart_item, $cart_item_key ) ) {
				$product_permalink = apply_filters( 'woocommerce_cart_item_permalink', $_product->is_visible() ? $_product->get_permalink( $cart_item ) : '', $cart_item, $cart_item_key );
				?>
				<tr class="<?php echo esc_attr( apply_filters( 'woocommerce_cart_item_class', 'cart_item', $cart_item, $cart_item_key ) ); ?>">

					<td class="product-thumbnail">
						<?php
							echo get_the_post_thumbnail( $_product->id, 'thumbnail' );
						?>
					</td>

					<td class="product-name" data-title="<?php _e( 'Product', 'woocommerce' ); ?>">
						<?php
							if ( ! $product_permalink ) {
								echo apply_filters( 'woocommerce_cart_item_name', $_product->get_title(), $cart_item, $cart_item_key ) . '&nbsp;';
							} else {
								echo apply_filters( 'woocommerce_cart_item_name', sprintf( '<a href="%s">%s</a>', esc_url( $product_permalink ), $_product->get_title() ), $cart_item, $cart_item_key );
							}
							?>

							<?php if ( $_product->product_type == 'yith_bundle' ) : ?>
								<div class="bundle-items">
									<?php $i = 0;?>
									<?php $item = '';?>
									<?php foreach( $_product->bundle_data as $bundle_item ) : ?>
										<?php if ( $i == 0 ) : ?>
											<?php $item .= get_the_title( $bundle_item[ 'product_id' ] );?>
										<?php else : ?>
											<?php $item .= ', ' . get_the_title( $bundle_item[ 'product_id' ] );?>
										<?php endif;?>
										<?php $i++;?>
									<?php endforeach;?>
									<?php echo $item;?>
								</div><!-- .bundle-items -->
							<?php endif;?>
							<?php
							// Backorder notification
							if ( $_product->backorders_require_notification() && $_product->is_on_backorder( $cart_item['quantity'] ) ) {
								echo '<p class="backorder_notification">' . esc_html__( 'Available on backorder', 'woocommerce' ) . '</p>';
							}
						?>
					</td>

					<td class="product-quantity" data-title="<?php _e( 'Quantity', 'woocommerce' ); ?>">
						<div class="buttons-qty">
 							<input type="text" value="<?php echo esc_attr( $cart_item->get_quantity() ); ?>" disabled />
						</div><!-- .buttons-qty -->

					</td>
					<td class="product-price" data-title="<?php _e( 'Price', 'woocommerce' ); ?>">
						<?php

							echo apply_filters( 'woocommerce_cart_item_price', wc_price( $_product->get_price()  ), $cart_item, $cart_item_key );
						?>
					</td>
					<td class="product-subtotal" data-title="<?php _e( 'Total', 'woocommerce' ); ?>">
						<?php
							echo apply_filters( 'woocommerce_cart_item_subtotal', wc_price( $cart_item->get_subtotal() ), $cart_item, $cart_item_key );
						?>
					</td>
				</tr>
				<?php
			}
		}
	?>
	</tbody>
</table>
<div class="col-md-12">
	<div class="col-md-8 pull-right totals">
		<?php foreach ( $order->get_order_item_totals() as $key => $total ) : ?>
			<div class="col-md-12 each-total <?php echo esc_attr( sanitize_title( $total[ 'label' ] ) );?>">
				<div class="col-md-7 col-xs-12 pull-left list-data text-right">
					<?php echo $total['label']; ?>
				</div><!-- .col-md-6 pull-left list-data -->
				<div class="col-md-5 col-xs-12 pull-right list-price text-right">
					<?php echo $total['value']; ?>
				</div><!-- .col-md-6 pull-right list-price -->
			</div><!-- .col-md-12 each-total -->
		<?php endforeach; ?>
	</div><!-- .col-md-5 pull-right totals -->
</div><!-- .col-md-12 -->
<?php do_action( 'woocommerce_order_details_after_order_table', $order ); ?>

<?php if ( $show_customer_details ) : ?>
	<?php wc_get_template( 'order/order-details-customer.php', array( 'order' =>  $order ) ); ?>
<?php endif; ?>
