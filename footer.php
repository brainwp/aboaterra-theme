<?php
/**
 * The template for displaying the footer.
 *
 * Contains footer content and the closing of the
 * #main div element.
 *
 * @package Odin
 * @since 2.2.0
 */
?>
<footer id="footer-default">
	<div class="container">
		<div class="row">
			<div class="col-md-12 image">
				<?php if ( $value = get_theme_mod( 'footer-image', false ) ) : ?>
					<img src="<?php echo esc_url( $value );?>" alt="<?php bloginfo( 'name' );?>" />
				<?php endif;?>
			</div><!-- .col-md-12 image -->
			<?php if ( is_active_sidebar( 'footer-sidebar' ) ) : ?>
				<div class="col-md-3 footer-sidebar">
					<?php dynamic_sidebar( 'footer-sidebar' );?>
				</div><!-- .col-md-3 footer-sidebar -->
			<?php endif;?>
			<div class="col-md-3 footer-sidebar">
				<?php dynamic_sidebar( 'footer-sidebar-2' );?>
				<?php if ( $value = get_theme_mod( 'phone', false ) ) : ?>
					<div class="col-md-12 icons-footer">
						<i class="fa fa-phone"></i>
						<a class="phone icon"><?php echo apply_filters( 'the_title', $value );?></a>
					</div><!-- .col-md-12 -->
				<?php endif; ?>
				<?php if ( $value = get_theme_mod( 'whatsapp', false ) ) : ?>
					<div class="col-md-12">
						<i class="fa fa-whatsapp"></i>
						<a class="whatsapp icon"><?php echo apply_filters( 'the_title', $value );?></a>
					</div><!-- .col-md-12 -->
				<?php endif; ?>
			</div><!-- .col-md-3 footer-sidebar -->
			<div class="col-md-3 footer-sidebar">
				<div class="col-md-12">
					<?php _e( 'Redes Sociais', 'odin' );?>
				</div><!-- .col-md-12 -->
				<div class="col-md-12">
					<?php if ( $value = get_theme_mod( 'facebook', false ) ) : ?>
						<a href="<?php echo esc_url( $value );?>" class="rounded-icon">
							<i class="fa fa-facebook"></i>
						</a>
					<?php endif;?>
					<?php if ( $value = get_theme_mod( 'instagram', false ) ) : ?>
						<a href="<?php echo esc_url( $value );?>" class="rounded-icon">
							<i class="fa fa-instagram"></i>
						</a>
					<?php endif;?>
				</div><!-- .col-md-12 -->
				<div class="col-md-12">
					<?php dynamic_sidebar( 'footer-sidebar-3' );?>
				</div><!-- .col-md-12 -->
			</div><!-- .col-md-3 footer-sidebar -->
			<?php if ( is_active_sidebar( 'footer-sidebar-4' ) ) : ?>
				<div class="col-md-3 footer-sidebar">
					<?php dynamic_sidebar( 'footer-sidebar-4' );?>
				</div><!-- .col-md-3 footer-sidebar -->
			<?php endif;?>
		</div><!-- .row -->
	</div><!-- .container -->
</footer><!-- #footer-default.col-md-12 -->
<?php wp_footer(); ?>
<?php if ( $value = get_theme_mod( 'code_close_body', false ) ) : ?>
	<?php echo html_entity_decode( $value );?>
<?php endif;?>
</body>
</html>
