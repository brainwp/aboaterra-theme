<?php
/**
 * Content each orders list
 *
 */
global $order;
?>
<article class="col-md-12 each-order-list">
	<div class="col-md-5 pull-left list-data">
		<div class="col-md-5">
			<?php _e( 'Número', 'odin' );?>
		</div><!-- .col-md-3 -->
		<div class="col-md-7 pull-right">
			<?php echo $order->get_order_number();?>
		</div><!-- .col-md-9 pull-right -->
		<div class="col-md-5">
			<?php _e( 'Data', 'odin' );?>
		</div><!-- .col-md-3 -->
		<div class="col-md-7 pull-right">
			<time datetime="<?php echo date( 'Y-m-d', strtotime( $order->order_date ) ); ?>" title="<?php echo esc_attr( strtotime( $order->order_date ) ); ?>"><?php echo date_i18n( 'd/m/Y', strtotime( $order->order_date ) ); ?></time>
		</div><!-- .col-md-9 pull-right -->
		<div class="col-md-5">
			<?php _e( 'Total', 'odin' );?>
		</div><!-- .col-md-3 -->
		<div class="col-md-7 pull-right">
			<?php echo $order->get_formatted_order_total();?>
		</div><!-- .col-md-9 pull-right -->
		<div class="col-md-5">
			<?php _e( 'Status', 'odin' );?>
		</div><!-- .col-md-3 -->
		<div class="col-md-7 pull-right status-<?php echo esc_attr( $order->get_status() );?>">
			<?php echo wc_get_order_status_name( $order->get_status() ); ?>
		</div><!-- .col-md-9 pull-right -->
	</div><!-- .col-md-5 pull-left list-data -->
	<div class="col-md-6 pull-right order-buttons bttht">
		<a href="<?php echo $order->get_view_order_url();?>" class="btn btn-primary btn-details btt-ordersS">
			<?php _e( 'Detalhes do pedido', 'odin' );?>
		</a>
		<?php if ( $order->get_status() == 'completed' ) : ?>
			<?php $buy_again_url = wp_nonce_url( add_query_arg( 'order_again', $order->id ) , 'woocommerce-order_again' );?>
			<a href="<?php echo $buy_again_url;?>" class="btn btn-primary btn-order-again">
				<?php _e( 'Recomprar', 'odin' );?>
			</a>
		<?php endif;?>
	</div><!-- .col-md-6 pull-right order-buttons -->
</article><!-- .col-md-12 each-order-list -->
