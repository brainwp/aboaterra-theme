<?php
/**
 * The template for displaying all pages.
 *
 * This is the template that displays all pages by default.
 * Please note that this is the WordPress construct of pages and that other
 * 'pages' on your WordPress site will use a different template.
 *
 * Template name: Página Cestas
 *
 * @package Odin
 * @since 2.2.0
 */

get_header(); ?>
	<?php the_post_thumbnail( 'full', array( 'class' => 'full-page-thumbnail') );?>
	<div class="container">
		<div class="row">
			<main id="content" class="col-md-12" tabindex="-1" role="main">
				<header>
					<div class="col-md-12">
						<?php while( have_posts() ) : the_post();?>
							<?php the_content();?>
						<?php endwhile;?>
					</div><!-- .col-md-12 -->
				</header>
				<div class="col-md-12 woocommerce">
					<?php $args = array(
						'post_type'			=> 'product',
						'product_cat'		=> 'cesta',
						'posts_per_page'	=> 500
					);
					$query = new WP_Query( $args );
					?>
					<ul class="products">
						<?php if ( $query->have_posts() ) : while( $query->have_posts() ) : $query->the_post();?>
							<?php wc_get_template_part( 'content', 'product' ); ?>
						<?php endwhile; wp_reset_postdata(); endif;?>
					</ul><!-- .products -->
				</div><!-- .woocommerce -->
				<div class="col-md-12 links">
					<div class="col-md-8 col-xs-12">
						<?php if ( $value = get_post_meta( get_the_ID(), 'link_1_txt', true ) ) : ?>
							<div class="col-md-5 col-xs-12 each-link">
								<?php echo apply_filters( 'the_title', $value );?>
								<?php $link = '#';?>
								<?php if ( $value = get_post_meta( get_the_ID(), 'link_1', true ) ) : ?>
									<?php $link = $value;?>
								<?php endif;?>
								<a href="<?php echo esc_url( $value );?>" class="btn btn-primary btn-large btn-buy">
									<?php _e( 'Clique aqui', 'odin' );?>
								</a>
							</div><!-- .col-md-5 each-link -->
						<?php endif;?>
						<?php if ( $value = get_post_meta( get_the_ID(), 'link_2_txt', true ) ) : ?>
							<div class="col-md-5 col-xs-12 each-link pull-right">
								<?php echo apply_filters( 'the_title', $value );?>
								<?php $link = '#';?>
								<?php if ( $value = get_post_meta( get_the_ID(), 'link_2', true ) ) : ?>
									<?php $link = $value;?>
								<?php endif;?>
								<a href="<?php echo esc_url( $value );?>" class="btn btn-primary btn-large btn-buy">
									<?php _e( 'Clique aqui', 'odin' );?>
								</a>
							</div><!-- .col-md-5 each-link -->
						<?php endif;?>
					</div><!-- .col-md-10 col-xs-12 -->
				</div><!-- .col-md-12 links -->
			</main><!-- #main -->
		</div><!-- .row -->
	</div><!-- .container -->
<?php
get_footer();
