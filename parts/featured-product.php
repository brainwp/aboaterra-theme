<?php
/**
 *
 * Produto destacado (livro)
 *
*/
?>
<div class="col-md-12 featured-product">
	<?php if ( $value = get_theme_mod( 'featured_product_thumb' ) ) : ?>
		<div class="col-md-4 image">
			<img src="<?php echo $value;?>" />
		</div><!-- .col-md-4 image -->
	<?php endif;?>
	<div class="col-md-6 content">
		<?php if ( $value = get_theme_mod( 'featured_product_title' ) ) : ?>
			<h4>
				<?php echo apply_filters( 'the_title', $value );?>
			</h4>
		<?php endif;?>
		<?php if ( $value = get_theme_mod( 'featured_product_content' ) ) : ?>
			<?php echo apply_filters( 'the_content', $value );?>
		<?php endif;?>
		<div class="col-md-12 links">
			<?php if ( $value = get_theme_mod( 'featured_product_readmore' ) ) : ?>
				<a class="btn-cart-link" href="<?php echo esc_url( $value );?>">
					<?php _e( 'Saiba mais', 'odin' );?>
				</a>
			<?php endif;?>
			<?php if ( $value = get_theme_mod( 'featured_product_buy' ) ) : ?>
				<a class="btn-buy" href="<?php echo esc_url( $value );?>">
					<?php _e( 'Comprar', 'odin' );?>
				</a>
			<?php endif;?>
		</div><!-- .col-md-12 links -->
	</div><!-- .col-md-6 content -->
</div><!-- .col-md-12 featured-product -->
