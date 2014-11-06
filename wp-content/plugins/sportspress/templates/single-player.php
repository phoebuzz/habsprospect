<?php
/**
 * Player Statistics
 *
 * @author 		ThemeBoy
 * @package 	SportsPress/Templates
 * @version     1.3
 */

get_header(); ?>


<?php while ( have_posts() ) : the_post(); ?>
<?php

	// Store the short code in a variable.
	$var = do_shortcode( '[ssbp] ' );
	echo $var;

	$player = new SP_Player( $post );

	$show_nationality_flags = get_option( 'sportspress_player_show_flags', 'yes' ) == 'yes' ? true : false;

	$number = get_post_meta( $post->ID, 'sp_number', true );
	$nationality = get_post_meta( $post->ID, 'sp_nationality', true );
	$metrics_before = $player->metrics( true );
	$metrics_after = $player->metrics( false );
	$positions = get_the_terms( $post->ID, 'sp_position' );
	$leagues = get_the_terms( $post->ID, 'sp_league' );
	$current_team = get_post_meta( $post->ID, 'sp_current_team', true );
	
	$country_name = tb_array_value( SP()->countries->countries, $nationality, null );

	$common = array();

	$common[ __( 'Nationality', 'sportspress' ) ] = $country_name ? ( $show_nationality_flags ? '<img src="' . plugin_dir_url( SP_PLUGIN_FILE ) . '/assets/images/flags/' . strtolower( $nationality ) . '.png" alt="' . $nationality . '"> ' : '' ) . $csountry_name : '&mdash;';

	$data = array_merge( $metrics_before, $common, $metrics_after );

	if ( $positions )
		$infobox_classes = 'large-9';
	else
		$infobox_classes = 'large-9';
?>

<div class="infinity team-name">
	<div class="row">
		<div class="small-9 columns">
			<h2>
				<a><?php the_title(); ?></a>
				<a class="number">#<?php echo $number; ?></a>
			</h2>

		</div>
		<div class="small-3 columns">
			<a class="team-logo"><?php echo get_the_post_thumbnail( $current_team, 'sportspress-fit-thumbnail' ); ?></a>
		</div>
	</div>
</div><!-- .infinity -->

<div id="content" class="site-content" role="main">
	<div class="player-main">
		<div class="row">
			<div class="large-3 medium-6 columns">
				<div class="player-photo">
					<?php the_post_thumbnail( ) ); ?>
				</div>
				<?php
				if ( $positions ):
					foreach( $positions as $position ):
						$args = array(
							'post_type' => 'attachment',
							'post_status' => 'any',
							'posts_per_page' => -1,
							'tax_query' => array(
								array(
									'taxonomy' => 'sp_position',
									'field' => 'id',
									'terms' => $position->term_id,
								),
							),
						);
						$attachments = get_posts( $args );

						?>
						<div class="player-position">
							<?php
							foreach( $attachments as $attachment ):
								echo wp_get_attachment_image() );
							endforeach;
							?>
							<h5 class="image-caption"><?php echo $position->name; ?></h5>
						</div>
						<?php
					endforeach;
				endif;
				?>
			</div><!-- .columns -->

			<div class="<?php echo $infobox_classes; ?> columns">
				<div class="infobox">
					<div class="row">
						<?php

							global $post;

							// load all 'category' terms for the post
							$terms = get_the_terms($post->ID, 'sp_league');

							// we will use the first term to load ACF data from
							if( !empty($terms) )
							{
								$term = array_pop($terms);

								$custom_field = get_field('logo_league', $term );

							}

						?>

						<?php if ( $custom_field ) : ?>
							<div class="league-logo">
								<img class="l-logo" src="<? echo $custom_field; ?>" alt="">
							</div>
						<?php endif; ?>
						<?php foreach ( $data as $label => $value ): if ( $value == null ) continue; ?>
							<div class="large-6 medium-3 columns">
								<small><?php echo $label; ?></small>
								<h4><?php echo $value; ?></h4>
							</div>
						<?php endforeach; ?>
					</div>
				</div>
			</div><!-- .columns -->
		</div><!-- .row -->
	</div><!-- .player-main -->

	<div class="row">
		<?php if ( get_the_content() ): ?>
		<div class="large-12 columns player-profile">
			<div class="infobox">
				<div class="columns">
					<h2><?php _e( 'Profile', 'themeboy' ); ?></h2>
				</div>
				<div class="large-6 columns">
					<div class="entry-content">
						
					</div>
				</div>
				<div class="large-6 columns">
					<div class="entry-content">
						
					</div>
				</div>
			</div>
		</div><!-- .columns -->
		<?php endif; ?>
		<div class="<?php echo get_the_content() ? 'large-6' : 'large-12'; ?> columns">
			<?php sp_get_template( 'player-statistics.php' ); ?>
			<?php if ( has_excerpt() ): ?>
			<div class="sp-excerpt">
				<?php echo apply_filters( 'the_content', get_the_excerpt() ); ?>
			</div>
			<?php endif; ?>
		</div><!-- .columns -->
		<div class="large-12 columns">
			<?php if ( get_field('ep_parser') ) :
				 $parser = get_field('ep_parser');
			?>

						<h2><?php _e( 'Statistics', 'themeboy' ); ?></h2>
						<?
							$rss = new SimpleXMLElement('http://eliteprospects.com/rss_player_stats.php?player='. $parser .'', null, true);
							foreach($rss->xpath('channel/item') as $item)
							{
							  echo  utf8_decode($item->description);
							}
						?>

			<?php endif; ?>
		</div>
	</div><!-- .row -->
</div><!-- #content -->
<?php endwhile; ?>

<?php get_footer();
