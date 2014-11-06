<?php
/**
 * The Template for displaying all single posts
 *
 * @package WordPress
 * @subpackage Premier
 * @since Premier 1.0
 */

get_header(); ?>

<div id="content" class="site-content" role="main">
	<div class="row">
		<div class="large-8 medium-7 columns">

			<?php
				// Start the Loop.

				while ( have_posts() ) : the_post();

					do_action('themeboy_before_content');

					/*
					 * Include the post format-specific template for the content. If you want to
					 * use this in a child theme, then include a file called called content-___.php
					 * (where ___ is the post format) and that will be used instead.
					 */
					get_template_part( 'content', get_post_format() );

					// If comments are open or we have at least one comment, load up the comment template.
					if ( comments_open() || get_comments_number() ) {
						comments_template();
					}

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

		<div class="large-4 medium-5 columns">
			<?php get_sidebar( 'content' ); ?>
			<?php get_sidebar(); ?>
		</div><!-- .columns -->

	</div><!-- .row -->
</div><!-- #content -->

<?php get_footer();
