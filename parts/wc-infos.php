<?php
/**
 *
 * wC Informations & mini-cart
 *
*/
?>
<?php $myaccount_page = get_option( 'woocommerce_myaccount_page_id' );?>
<?php if ( $myaccount_page ) : ?>
	<a href="<?php echo get_permalink( $myaccount_page );?>" class="myacc"><?php _e( 'minha conta', 'odin');?></a>
	<span class="separator">|</span>
<?php endif;?>
<?php if ( function_exists( 'WC' ) ) : ?>
	<a data-href="<?php echo wc_get_cart_url();?>" class="myacc mini-cart-icon" data-toggle="dropdown" role="button" aria-haspopup="true" aria-expanded="false">
		<i class="fa fa-shopping-cart"></i>
		<span class="cart-infos">[<?php echo WC()->cart->get_cart_contents_count();?>]</span>
	</a>
	<?php if ( ! WC()->cart->is_empty() ) : ?>
		<ul class="dropdown-menu cart-dropdown" aria-labelledby="dLabel">
			<div class="col-md-12">
				<div class="col-md-12 text-center">
					<a href="<?php echo wc_get_cart_url();?>" class="btn btn-primary btn-large btn-buy"><?php _e( 'Ver Carrinho', 'odin' );?></a>
				</div><!-- .col-md-12 text-center -->

				<div class="separator"></div><!-- .separator -->
				<?php foreach( WC()->cart->get_cart() as $cart_item ) : ?>
					<?php if ( isset( $cart_item['bundled_by'] ) ) : ?>
						<?php continue;?>
					<?php endif;?>
					<div class="col-md-4 col-xs-12 pull-left img">
						<?php if ( has_post_thumbnail( $cart_item['product_id'] ) ) : ?>
							<?php echo get_the_post_thumbnail( $cart_item['product_id'], 'thumbnail', null );?>
						<?php endif;?>
					</div><!-- .col-md-6 pull-left img -->
					<div class="col-md-7 pull-right col-xs-12">
						<div class="post-title">

							<?php
							// echo 'aqui';
							//
							// print_r($cart_item['data']);
							// die;
							echo apply_filters( 'the_title', $cart_item['data']->get_name() );?>
						</div><!-- .col-md-12 post-title -->
						<div class="qty-infos">
							<?php printf( '%s x %s %s', $cart_item['quantity'], get_woocommerce_currency_symbol(), $cart_item['line_subtotal'] );?>
						</div><!-- .col-md-12 qty-infos -->
					</div><!-- .col-md-6 pull-right -->
					<div class="separator"></div><!-- .separator -->
				<?php endforeach;?>
				<div class="post-title"><?php printf( __( 'Total de itens adicionados: <span>%s</span>', 'odin'), WC()->cart->get_cart_contents_count() );?></div><!-- .post-title -->
				<div class="post-title"><?php printf( __( 'Total: <span>%s</span>', 'odin'), WC()->cart->get_cart_subtotal() );?>
				</div><!-- .post-title -->
				<div class="separator"></div><!-- .separator -->
				<!-- <div class="post-title"> -->
					<?php
					// printf( __( 'TOTAL: <span class="big">%s</span>', 'odin'), WC()->cart->cart_contents_total );?>
				<!-- </div> -->
				<!-- .post-title -->

			</div><!-- .col-md-12 -->
  		</ul>
  	<?php endif;?>
<?php endif;?>
