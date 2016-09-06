<?php
/**
 * Order details
 *
 * This template can be overridden by copying it to yourtheme/woocommerce/order/order-details.php.
 *
 * HOWEVER, on occasion WooCommerce will need to update template files and you (the theme developer).
 * will need to copy the new files to your theme to maintain compatibility. We try to do this.
 * as little as possible, but it does happen. When this occurs the version of the template file will.
 * be bumped and the readme will list any important changes.
 *
 * @see 	    http://docs.woothemes.com/document/template-structure/
 * @author  WooThemes
 * @package WooCommerce/Templates
 * @version 9.9.9
 */

if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

$order = wc_get_order( $order_id );

$show_purchase_note    = $order->has_status( apply_filters( 'woocommerce_purchase_note_order_statuses', array( 'completed', 'processing' ) ) );
$show_customer_details = is_user_logged_in() && $order->get_user_id() === get_current_user_id();
?>
<h2><?php _e( 'Order Details', 'woocommerce' ); ?></h2>

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

			$_product = wc_get_product( $cart_item[ 'item_meta'][ '_product_id'][0] );
			$product_id = $cart_item[ 'item_meta'][ '_product_id'][0];

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
 							<input type="text" value="<?php echo esc_attr( $cart_item[ 'item_meta']['_qty'][0] );?>" />
						</div><!-- .buttons-qty -->

					</td>
					<td class="product-price" data-title="<?php _e( 'Price', 'woocommerce' ); ?>">
						<?php
							echo apply_filters( 'woocommerce_cart_item_price', wc_price( $cart_item[ 'item_meta']['_line_total'][0] ), $cart_item, $cart_item_key );
						?>
					</td>
					<td class="product-subtotal" data-title="<?php _e( 'Total', 'woocommerce' ); ?>">
						<?php
							echo apply_filters( 'woocommerce_cart_item_subtotal', wc_price( $cart_item[ 'item_meta']['_line_subtotal'][0] ), $cart_item, $cart_item_key );
						?>
					</td>
				</tr>
				<?php
			}
		}
	?>
	</tbody>
	<tfoot>
		<?php
			foreach ( $order->get_order_item_totals() as $key => $total ) {
				?>
				<tr>
					<th scope="row"><?php echo $total['label']; ?></th>
					<td><?php echo $total['value']; ?></td>
				</tr>
				<?php
			}
		?>
	</tfoot>
</table>

<?php do_action( 'woocommerce_order_details_after_order_table', $order ); ?>

<?php if ( $show_customer_details ) : ?>
	<?php wc_get_template( 'order/order-details-customer.php', array( 'order' =>  $order ) ); ?>
<?php endif; ?>
