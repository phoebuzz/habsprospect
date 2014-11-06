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
		<div class="large-8 columns">
			<h1 class="page-title"><?php _e( 'Not Found', 'themeboy' ); ?></h1>

			<div class="page-content">
				<p><?php _e( 'It looks like nothing was found at this location. Maybe try a search?', 'twentyfourteen' ); ?></p>

				<?php get_search_form(); ?>
			</div><!-- .page-content -->
		</div><!-- .columns -->

		<div class="large-4 columns">
			<?php get_sidebar( 'content' ); ?>
			<?php get_sidebar(); ?>
		</div><!-- .columns -->

	</div><!-- .row -->
</div><!-- #content -->

<?php get_footer();
