<?php
/*
Template Name: Full Width
*/
get_header(); ?>

<div id="content" class="site-content" role="main">
	<div class="row">
		<div class="large-12 columns">

			<?php
				// Start the Loop.
				while ( have_posts() ) : the_post();

					do_action('themeboy_before_content');

					get_template_part( 'content', 'page' );

					do_action('themeboy_before_pagination');

				endwhile;
			?>
			<?php if ( function_exists('tb_pagination') ) { tb_pagination(); } else if ( is_paged() ) { ?>
				<nav id="post-nav">
					<div class="post-previous"><?php next_posts_link( __( '&larr; Older posts', 'themeboy' ) ); ?></div>
					<div class="post-next"><?php previous_posts_link( __( 'Newer posts &rarr;', 'themeboy' ) ); ?></div>
				</nav>
			<?php } ?>
			<?php do_action('themeboy_after_content'); ?>
		</div><!-- .columns -->
	</div><!-- .row -->
</div><!-- #content -->

<?php get_footer();
