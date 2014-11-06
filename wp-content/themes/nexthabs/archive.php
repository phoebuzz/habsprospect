<?php
/**
 * The template for displaying Archive pages
 *
 * @package WordPress
 * @subpackage Premier
 * @since Premier 1.0
 */

get_header(); ?>

<div id="content" class="site-content" role="main">
	<div class="row">
		<div class="large-8 columns">
			<?php if ( have_posts() ) : ?>
			<div class="row">
				<div class="post-gallery">
					<ul class="latest-posts-orbit" data-orbit data-options="stack_on_small:true;bullets_container_class:orbit-bullets;navigation_arrows:false;timer:false;slide_number:false;">
						<li>
						<?php $i = 0; while ( have_posts() ) : the_post(); ?>
							<?php if ( $i &&  $i % 2 == 0 ): ?>
							</li><li>
							<?php endif; ?>
							<div class="medium-6 columns">
								<?php get_template_part( 'content', get_post_format() ); ?>
							</div>
						<?php $i++; endwhile; ?>
						</li>
					</ul>
				</div><!-- .post-gallery -->
			</div><!-- .row -->
			<?php else : ?>
			<?php get_template_part( 'content', 'none' ); ?>
			<?php endif; ?>
			<?php
			global $wp_query;
			$num_posts = $wp_query->found_posts;
			?>
		</div><!-- .columns -->

		<div class="large-4 columns">
			<?php get_sidebar( 'content' ); ?>
			<?php get_sidebar(); ?>
		</div><!-- .columns -->

	</div><!-- .row -->
</div><!-- #content -->

<?php get_footer();
