<?php $terms = get_the_terms( $post->ID, 'leagues' ); 

if ( $terms && ! is_wp_error( $terms ) ) : 

	$leagues_links = array();

	foreach ( $terms as $term ) {
		$leagues_links[] = $term->name;

		$logo_league = get_field('logo_league', $term );

		$size = "logo-thumb";
        wp_get_attachment_image( $logo_league, $size );
	}
						
	$leagues_on = join( ", ", $leagues_links );
?>

<?php endif; ?>

	<div class="post-inner post-hover players-list">

		<div class="post-thumbnail">
			<?php if ( $logo_league ) : ?>
				   <?= wp_get_attachment_image( $logo_league, $size ); ?>
			<?php endif; ?>	
			<a href="<?php the_permalink(); ?>" title="<?php the_title(); ?>">
				<?php if ( has_post_thumbnail() ): ?>
					<?php the_post_thumbnail(); ?>
				<?php elseif ( ot_get_option('placeholder') != 'off' ): ?>
					<img src="<?php echo get_template_directory_uri(); ?>/img/thumb-medium.png" alt="<?php the_title(); ?>" />
				<?php endif; ?>
			</a>
		</div><!--/.post-thumbnail-->

		<h2 class="post-title">
			<a href="<?php the_permalink(); ?>" rel="bookmark" title="<?php the_title(); ?>"><?php the_title(); ?></a>
		</h2><!--/.post-title-->

	</div><!--/.post-inner-->	