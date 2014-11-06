<?php get_header(); ?>

<section class="content">

	<?php get_template_part('inc/page-title'); ?>
	
	<div class="pad group">		
		
		<?php if ((category_description() != '') && !is_paged()) : ?>
			<div class="notebox">
				<?php echo category_description(); ?>
			</div>
		<?php endif; ?>

		<?php 
			global $post;

			$args = array( 'post_type' => 'players', 'posts_per_page' => 40 );
			$loop = new WP_Query( $args );
		 ?>

		<?php while ( $loop->have_posts() ) : $loop->the_post(); ?>
		
				<?php get_template_part('listing-player'); ?>
		
		<?php endwhile; ?>
		
	</div><!--/.pad-->
	
</section><!--/.content-->

<?php get_sidebar(); ?>

<?php get_footer(); ?>