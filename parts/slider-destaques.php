<?php
/**
 * Slider destaques.
 *
 * Generate by Brasa Slider WP plugin
 *
 * @package odin
 * @since 2.2.0
 */
?>
<section class="col-md-12 slider-destaques">
	<div class="container">
		<div class="row">
			<?php $slider_name = 'Slider Destaques';?>
			<?php $slider = get_page_by_title( $slider_name, OBJECT, 'brasa_slider_cpt' );?>
			<?php if ( $slider && is_object( $slider ) && class_exists( 'Brasa_Slider' ) ) : ?>
				<?php $brasa_slider = new Brasa_Slider();?>
				<?php $json = '{"dots": true,"infinite": true,"speed": 3000, "autoplay":true, "autoplaySpeed": 5000, "slidesToShow": 3, "responsive": [ {"breakpoint": 800, "settings": { "slidesToShow": 3, "slidesToScroll": 1 }}]}';?>
				<?php echo $brasa_slider->shortcode( array( 'name' => $slider_name, 'json' => $json  ) );?>
			<?php endif;?>
		</div><!-- .row -->
	</div><!-- .container -->
</section><!-- .col-md-12 slider-destaques -->
