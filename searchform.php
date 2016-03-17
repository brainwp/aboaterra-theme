<?php
/**
 * The template for displaying Search Form.
 *
 * @package Odin
 * @since 2.2.0
 */
?>

<form method="get" id="searchform" class="form-inline" action="<?php echo esc_url( home_url( '/' ) ); ?>" role="search">
	<button><i class="fa fa-search"></i></button>
	<input type="search" class="form-control col-md-12" name="s" id="s" placeholder="<?php _e( 'busque pelo produto', 'odin');?>" />
</form>
