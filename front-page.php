<?php
/**
 * The template for displaying home
 *
 * @package Odin
 * @since 2.2.0
 */
get_header(); ?>
	<section class="home-slider">
		<?php $slider_name = 'Home Slider';?>
		<?php $slider = get_page_by_title( $slider_name, OBJECT, 'brasa_slider_cpt' );?>
		<?php if ( $slider && is_object( $slider ) && class_exists( 'Brasa_Slider' ) ) : ?>
			<?php $brasa_slider = new Brasa_Slider();?>
			<?php echo $brasa_slider->shortcode( array( 'name' => $slider_name, 'size' => 'full' ) );?>
		<?php endif;?>
	</section><!-- .col-md-12 home-slider -->
	<?php get_template_part( '/parts/slider', 'destaques' );?>
	<div class="col-md-12">
		<div class="container">
			<div class="row">
				<?php dynamic_sidebar( 'home-email-sidebar' ); ?>
			</div><!-- .row -->
		</div><!-- .container -->
	</div><!-- .col-md-12 -->
	<div class="col-md-12">
		<div class="container">
			<div class="row">
				<?php dynamic_sidebar( 'home-produtos-sidebar' ); ?>
			</div><!-- .row -->
		</div><!-- .container -->
	</div><!-- .col-md-12 -->
<?php
get_footer( 'shop' );
