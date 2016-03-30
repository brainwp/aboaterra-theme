 <?php
/**
 * wooCommerce get products
 *
 * @package odin
 * @since 2.2.0
 */
?>
<section class="col-md-12 woocommerce-query woocommerce">
	<div class="container">
		<div class="row">
			<div class="col-md-12 section-title-bg">
				<h2 class="section-title">
					<?php echo apply_filters( 'the_title', get_theme_mod( 'mais-pedidos-title', 'Mais pedidos' ) );?>
				</h2><!-- .section-title -->
			</div><!-- .col-md-12 section-title-bg -->
			<div class="col-md-12">
				<?php $args = array(
						'post_type' => 'product',
						'posts_per_page' => get_theme_mod( 'mais-pedidos-per-page', 8 )
					);
				$tags = get_theme_mod( 'mais-pedidos-tag', false );
				if ( $tags !== false && is_array( $tags ) && ! empty( $tags ) ) :
					$args['tax_query'] = array(
						array(
							'taxonomy' => 'product_tag',
							'field'    => 'term_id',
							'terms'    => $tags
						),
					);
				endif;
				$query = new WP_Query( $args );
				?>
				<?php if ( $query->have_posts() ) : ?>
					<?php woocommerce_product_loop_start(); ?>
					<?php while( $query->have_posts() ) : $query->the_post();?>
						<?php wc_get_template_part( 'content', 'product' ); ?>
					<?php endwhile;?>
					<?php woocommerce_product_loop_end(); ?>
				<?php endif;?>

			</div><!-- .col-md-12 -->
		</div><!-- .row -->
	</div><!-- .container -->
</section><!-- .col-md-12 woocommerce-query -->
