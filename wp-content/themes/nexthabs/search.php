<?php
/**
 * The Template for displaying search results.
 *
 * @package WordPress
 * @subpackage Premier
 * @since Premier 1.0
 */

get_header(); ?>

<div id="content" class="site-content" role="main">
	<div class="row">
		<div class="large-8 columns">
			<div class="search-results">
				<?php
				if ( have_posts() ):
					// Start the Loop.
					while ( have_posts() ) : the_post();

						do_action('themeboy_before_content');
						
						get_template_part( 'content', 'results' );

						do_action('themeboy_before_pagination');

					endwhile;

				else:

					get_template_part( 'content', 'none' );

				endif;
				?>
				<?php if ( function_exists('tb_pagination') ) { tb_pagination(); } else if ( is_paged() ) { ?>
					<nav id="post-nav">
						<div class="post-previous"><?php next_posts_link( __( '&larr; Older posts', 'themeboy' ) ); ?></div>
						<div class="post-next"><?php previous_posts_link( __( 'Newer posts &rarr;', 'themeboy' ) ); ?></div>
					</nav>
				<?php } ?>
				<?php do_action('themeboy_after_content'); ?>
			</div>
		</div><!-- .columns -->
		<div class="large-4 columns">
			<?php get_sidebar( 'content' ); ?>
			<?php get_sidebar(); ?>
		</div><!-- .columns -->
	</div><!-- .row -->
</div><!-- #content -->

<?php get_footer();
