<?php get_header(); ?>

<section class="content">

<?php get_template_part('inc/page-title'); ?>

	<div class="pad group">

<?php if ( have_posts() ) : ?>

	<div class="post-list group">
		<?php while ( have_posts() ): the_post(); ?>
			<li class="listing-player"><?php get_template_part('listing-player'); ?></li>
		<?php endwhile; ?>
	</div><!--/.post-list-->

	<?php get_template_part('inc/pagination'); ?>
	
<?php endif; ?>

	</div><!--/.pad-->
	
</section><!--/.content-->

<?php get_sidebar(); ?>

<?php get_footer(); ?>
		