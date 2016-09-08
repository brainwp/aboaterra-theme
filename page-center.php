<?php
/**
 * The template for displaying all pages.
 *
 * This is the template that displays all pages by default.
 * Please note that this is the WordPress construct of pages and that other
 * 'pages' on your WordPress site will use a different template.
 *
 * Template name: Página centralizada
 *
 * @package Odin
 * @since 2.2.0
 */

get_header(); ?>
	<div class="col-md-12" id="page-center">
		<div class="container">
			<div class="row">
				<main id="content" class="col-md-9 col-sm-12 col-xs-12" tabindex="-1" role="main">

				<?php
					// Start the Loop.
					while ( have_posts() ) : the_post();

						// Include the page content template.
						get_template_part( 'content', 'page' );

						// If comments are open or we have at least one comment, load up the comment template.
						if ( comments_open() || get_comments_number() ) :
							comments_template();
						endif;
					endwhile;
				?>
				</main><!-- #main -->
			</div><!-- .row -->
		</div><!-- .container -->
	</div><!-- .col-md-12 -->
<?php
get_footer();
