<?php
/**
 * The main template file
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
			<?php do_action('themeboy_before_content'); ?>
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
			<?php do_action('themeboy_before_pagination'); ?>
			<?php endif; ?>
			<?php if ( function_exists('tb_pagination') ) { tb_pagination(); } else if ( is_paged() ) { ?>
				<nav id="post-nav">
					<div class="post-previous"><?php next_posts_link( __( '&larr; Older posts', 'themeboy' ) ); ?></div>
					<div class="post-next"><?php previous_posts_link( __( 'Newer posts &rarr;', 'themeboy' ) ); ?></div>
				</nav>
			<?php } ?>
			<?php do_action('themeboy_after_content'); ?>
		</div><!-- .columns -->

		<div class="large-4 columns">
			<?php get_sidebar( 'content' ); ?>
			<?php get_sidebar(); ?>
		</div><!-- .columns -->

	</div><!-- .row -->
</div><!-- #content -->

<?php get_footer();
