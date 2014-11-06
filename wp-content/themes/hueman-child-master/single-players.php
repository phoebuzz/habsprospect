<?php get_header(); ?>

<?php

	global $post;

	// load all 'category' terms for the post
	$terms = get_the_terms($post->ID, 'teams');
	$flags = get_the_terms($post->ID, 'nationalities');
	$positions = get_the_terms($post->ID, 'positions');

	$positions_slugs = array();

	foreach( $positions as $position ) {
	    $positions_slugs[] = $position->slug; // save the slugs in an array
	}

	// we will use the first term to load ACF data from
	if( !empty($terms) )
	{
		$term = array_pop($terms);

		$team_logo = get_field('team_logo', $term );

        $size = "";
        wp_get_attachment_image( $team_logo, $size );

	}
	// we will use the first term to load ACF data from
	if( !empty($flags) )
	{
		$flags = array_pop($flags);

		$player_flag = get_field('nationality_flag', $flags );

	}

?>
<section id="player-profile" class="content">
	
	<?php get_template_part('inc/page-title'); ?>
	
	<div class="pad group">
		
		<?php while ( have_posts() ): the_post(); ?>
			<article <?php post_class(); ?>>	
				<div class="post-inner group">

					<div class="player-intro">

						<h1 class="post-title">

							<?php the_title(); ?>
						
							<?php if ( get_field('number') ) : ?>
								<span><?php the_field('number'); ?></span>
								<span class="position"><?php echo $positions_slugs[0]; ?></span>
							<?php endif; ?>
						</h1>

						<?php if ( $player_flag ) : ?>
							<img src="<?php echo $player_flag; ?>" alt="">
						<?php endif; ?>	
						
					</div>

					<div class="player-card">

						<div class="player-team-overlay-container">
							<?php if ( $team_logo ) : ?>
								   <?= wp_get_attachment_image( $team_logo, $size ); ?>
							<?php endif; ?>					
						</div>

						<?php if ( has_post_thumbnail() ) : ?>
			   				<div class="player-thumb"><?php the_post_thumbnail('thumb-small'); ?></div>
			   			<?php endif; ?>


			   			<!--Player Metrics-->	

						<div class="profile-wrap">

						<?php get_template_part('assets/player-metrics'); ?>

		   				</div>

	   				</div>

					<?php if( get_post_format() ) { get_template_part('inc/post-formats'); } ?>


					<!--Player Profile-->	
					
					<div class="entry">	
						<div class="entry-inner">

						<h2>Profile</h2>
						<?php the_content(); ?>
						<?php wp_link_pages(array('before'=>'<div class="post-pages">'.__('Pages:','hueman'),'after'=>'</div>')); ?>
					 

						</div>
						<div class="clear"></div>				
					</div><!--/.entry-->
					
					<div class="clear"></div>

					<!--Player Profile-->	
					<div class="entry">	
						<div class="entry-inner">
							<h2><?php _e( 'Statistics', 'hueman' ); ?></h2>
						</div>
					</div>
					<div class="ep-parser">						
						<?php if ( get_field('elite_parser') ) :
							 $parser = get_field('elite_parser');
						?>
							<?
								$rss = new SimpleXMLElement('http://eliteprospects.com/rss_player_stats.php?player='. $parser .'', null, true);
								foreach($rss->xpath('channel/item') as $item)
								{
								  echo  utf8_decode($item->description);
								}
							?>

						<?php endif; ?>
					</div>		
					
				</div><!--/.post-inner-->	
			</article><!--/.post-->				
		<?php endwhile; ?>
		
		<div class="clear"></div>
		
		<?php the_tags('<p class="post-tags"><span>'.__('Tags:','hueman').'</span> ','','</p>'); ?>
		
		<?php if ( ( ot_get_option( 'author-bio' ) != 'off' ) && get_the_author_meta( 'description' ) ): ?>
			<div class="author-bio">
				<div class="bio-avatar"><?php echo get_avatar(get_the_author_meta('user_email'),'128'); ?></div>
				<p class="bio-name"><?php the_author_meta('display_name'); ?></p>
				<p class="bio-desc"><?php the_author_meta('description'); ?></p>
				<div class="clear"></div>
			</div>
		<?php endif; ?>
		
		<?php if ( ot_get_option( 'post-nav' ) == 'content') { get_template_part('inc/player-nav'); } ?>
		
		
	</div><!--/.pad-->
	
</section><!--/.content-->

<?php get_sidebar(); ?>

<?php get_footer(); ?>