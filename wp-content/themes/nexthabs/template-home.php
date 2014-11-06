<?php
/**
 * Template Name: Home
 *
 * @package WordPress
 * @subpackage Premier
 * @since Premier 1.0
 */

get_header(); ?>

<div id="content" class="site-content" role="main">
	<div class="row">
		<?php if ( is_active_sidebar( 'homepage' ) ) : ?>
		<div id="homepage-widgets" class="homepage-widgets widget-area">
			<?php dynamic_sidebar( 'homepage' ); ?>
		</div><!-- #homepage-widgets -->
		<?php endif; ?>
	</div><!-- .row -->
</div><!-- #content -->

<?php get_footer();
