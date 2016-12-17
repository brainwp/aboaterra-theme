<?php
/**
 * The template for displaying all pages.
 *
 * This is the template that displays all pages by default.
 * Please note that this is the WordPress construct of pages and that other
 * 'pages' on your WordPress site will use a different template.
 *
 * Template name: Página Full Width
 *
 * @package Odin
 * @since 2.2.0
 */

get_header(); ?>
<?php while( have_posts() ) : the_post();?>
	<?php the_post_thumbnail( 'full', array( 'class' => 'full-page-thumbnail') );?>
	<div class="container">
		<div class="row">
			<main id="content" class="col-md-12" tabindex="-1" role="main">
				<header>
					<div class="col-md-12">
						<h1>
							<?php the_title();?>
						</h1>
					</div><!-- .col-md-12 -->
				</header>
				<div class="col-md-12 woocommerce">
					<?php the_content();?>
				</div><!-- .woocommerce -->
			</main><!-- #main -->
		</div><!-- .row -->
	</div><!-- .container -->
	<?php endwhile;?>
<?php
get_footer();
