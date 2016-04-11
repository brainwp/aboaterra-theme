<?php
/**
 * Content recent blog posts
 *
 */
?>
<article class="col-md-4 recent-posts">
	<a href="<?php the_permalink();?>">
		<div class="image">
			<?php the_post_thumbnail( 'medium' );?>
		</div><!-- .image -->
		<div class="col-md-12 text-center">
			<h3 class="the-title"><?php the_title();?></h3><!-- .the-title -->
		</div><!-- .col-md-12 text-center -->
		<div class="col-md-12 the-content">
			<?php the_excerpt();?>
		</div><!-- .col-md-12 the-content -->
	</a>
</article><!-- .col-md-4 -->
