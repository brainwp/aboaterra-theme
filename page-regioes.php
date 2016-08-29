<?php
/**
 * The template for displaying all pages.
 *
 * This is the template that displays all pages by default.
 * Please note that this is the WordPress construct of pages and that other
 * 'pages' on your WordPress site will use a different template.
 *
 * Template name: Página Regiões não atendidas
 *
 * @package Odin
 * @since 2.2.0
 */

get_header(); ?>
	<?php
	// Start the Loop.
	while ( have_posts() ) : the_post();
	?>
	<div class="col-md-12" id="page-regioes">
		<div class="container">
			<div class="row">
				<main id="content" class="col-md-6 pull-right col-sm-12 col-xs-12" tabindex="-1" role="main">
					<?php the_content();?>
				</main><!-- #main -->
				<div class="col-md-4 pull-left error-box">
					<a href="#" class="btn btn-primary btn-large btn-buy btn-show-element" data-element="#show-cep">
						<?php _e( 'Alterar CEP', 'odin' );?>
					</a>
					<div class="col-md-12 clear"></div><!-- .col-md-12 clear -->
					<div class="col-md-12" id="show-cep" style="display:none;">
						<?php $label = __( 'CEP', 'odin' );?>
						<?php $loading_txt = __( 'Carregando..', 'odin' );?>
						<?php $redirect_success = get_home_url();?>
						<?php $redirect_error = '';?>
						<?php if ( $value = get_theme_mod( 'delivery_error_redirect', false ) ) : ?>
							<?php $redirect_error = $value;?>
						<?php endif;?>
						<?php echo do_shortcode( sprintf( '[brasa_check_delivery label="%s" button_load_text="%s" redirect_success="%s" redirect_error="%s"]', $label, $loading_txt, $redirect_success, $redirect_error ) );?>
					</div><!-- #show-cep.col-md-12 text-center -->
					<?php if ( $value = get_post_meta( get_the_ID(), 'regioes_error', true ) ) : ?>
						<div class="col-md-12 error-msg">
							<?php echo apply_filters( 'the_content', $value );?>
						</div><!-- .col-md-12 error-msg -->
					<?php endif;?>
					<a href="<?php echo home_url();?>" class="btn btn-primary btn-large btn-cart-link">
						<?php _e( 'Continuar Comprando', 'odin' );?>
					</a>
				</div><!-- .col-md-4 pull-left error-box -->
			</div><!-- .row -->
		</div><!-- .container -->
	</div><!-- .col-md-12 -->
	<?php endwhile;?>
<?php
get_footer();
