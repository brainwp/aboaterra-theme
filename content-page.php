<?php
/**
 * The template used for displaying page content.
 *
 * @package Odin
 * @since 2.2.0
 */
$entry_content_class = '';
if ( is_page_template( 'page-contato.php' ) ) {
	$entry_content_class = 'col-md-5 pull-left col-xs-12';
}
?>
<article id="post-<?php the_ID(); ?>" <?php post_class(); ?>>
	<?php the_title( '<header class="entry-header"><h1 class="entry-title">', '</h1></header><!-- .entry-header -->' ); ?>

	<div class="entry-content <?php echo $entry_content_class;?>">
		<?php
			the_content();
			wp_link_pages( array(
				'before'      => '<div class="page-links"><span class="page-links-title">' . __( 'Pages:', 'odin' ) . '</span>',
				'after'       => '</div>',
				'link_before' => '<span>',
				'link_after'  => '</span>',
			) );
		?>
	</div><!-- .entry-content -->
	<?php if ( $value = get_post_meta( get_the_ID(), 'right_content', true ) ) : ?>
		<div class="col-md-6 pull-right right-content">
			<?php echo apply_filters( 'the_content', $value );?>
		</div><!-- .col-md-6 pull-right right-content -->
	<?php endif;?>
	<?php if ( is_page_template( 'page-contato.php' ) ) : ?>
	<div class="entry-content acompanhe">
		<h1 class="entry-title">
			<?php _e( 'Quer acompanhar nosso dia-dia aqui na roça? Siga nosso instagram e facebook!', 'odin' );?>
		</h1><!-- .entry-title -->
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
	</div>
	<?php endif;?>
</article><!-- #post-## -->
