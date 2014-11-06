<?php
/**
 * The Template for displaying all single events
 *
 * @package WordPress
 * @subpackage Premier
 * @since Premier 1.0
 * @version 1.0
 */

get_header(); ?>

<?php while ( have_posts() ) : the_post(); ?>
<?php
	$event = new SP_Event( $id );
	$status = $event->status();
	$options = get_option( 'sportspress' );
	$main_result = get_option( 'sportspress_primary_result', null );

	$teams = array_unique( array_filter( get_post_meta( $id, 'sp_team' ) ) );
	$results = (array)get_post_meta( $id, 'sp_results', true );
	$leagues = get_the_terms( $id, 'sp_league' );
	$seasons = get_the_terms( $id, 'sp_season' );
	$venues = get_the_terms( $id, 'sp_venue' );

	if ( $leagues ):
		$league = array_pop( $leagues );
	endif;

	if ( $seasons ):
		$season = array_pop( $seasons );
	endif;

	$venue = null;
	if ( $venues ):
		$venue = array_pop( $venues );
	endif;

	$has_results = (boolean)array_filter( $results, 'array_filter' );
?>
<div class="infinity event-info">
	<div class="row">
		<div class="small-6 columns">
			<h4 class="date">
				<span class="icon-calendar-fill"></span>
				<?php the_date(); ?>
			</h4>
		</div>
		<div class="small-6 columns">
			<h4 class="right">
				<?php
				if ( isset( $league ) ):
					echo $league->name;
				elseif ( ! is_array( $teams ) || ! sizeof( $teams ) ):
					echo '<span class="icon-clock"></span>';
					the_time();
				endif;
				?>
			</h4>
		</div>
	</div>
</div><!-- .infinity -->
<?php if ( is_array( $teams ) && sizeof( $teams ) ): ?>
<div class="infinity event-teams">
	<div class="row">
		<?php
		if ( is_array( $teams ) ): foreach ( $teams as $team_id ):
			$abbreviation = get_post_meta( $team_id, 'sp_abbreviation', true );
			$team_name = $abbreviation ? $abbreviation : get_the_title( $team_id );
			$team_main_result = null;
			if ( isset( $results[ $team_id ] ) ):
				$team_results = $results[ $team_id ];
				if ( isset( $team_results['outcome'] ) ):
					$outcome_slug = $team_results['outcome'];
					unset( $team_results['outcome'] );
				else:
					$outcome_slug = null;
				endif;
				if ( is_array( $outcome_slug ) ):
					end( $outcome_slug );
					$outcome_slug = prev( $outcome_slug );
				endif;
				if ( $main_result ):
					if ( array_key_exists( $main_result, $team_results ) ):
						$team_main_result = $team_results[ $main_result ];
						unset( $team_results[ $main_result ] );
					else:
						$team_main_result = null;
					endif;
				else:
					$team_main_result = array_pop( $team_results );
					if ( $team_main_result == null ):
						$outcomes = sportspress_get_var_labels( 'sp_outcome' );
						$team_main_result = tb_array_value( $outcomes, $outcome_slug, null );
					endif;
				endif;
			endif;

			$labels = sportspress_get_var_labels( 'sp_result' );
		?>
		<div class="small-6 columns">
			<div class="team-logo"><a href="<?php echo get_post_permalink( $team_id ); ?>"><?php echo get_the_post_thumbnail( $team_id, 'sportspress-fit-thumbnail' ); ?></a></div>
			<h3 class="team-name<?php if ( $team_main_result != null ): ?> with-result<?php endif; ?>"><a href="<?php echo get_permalink( $team_id ); ?>"><?php echo $team_name; ?></a></h3>
			<?php if ( $team_main_result != null ): ?>
			<span class="team-result"><?php echo $team_main_result; ?></span>
			<?php endif; ?>
			<?php if ( count( $teams ) <= 2 && isset( $team_results ) && is_array( $team_results ) && array_filter( $team_results, 'tb_array_null_filter' ) && sizeof( $team_results ) > 1 ): ?>
			<div class="team-results">
				<div class="small-block-grid-<?php echo sizeof( $team_results ); ?>">
					<?php foreach( $team_results as $label => $result ): ?>
					<li>
						<?php echo tb_array_value( $labels, $label, '&nbsp;' ); ?>
						<span><?php echo $result != null ? $result : '&nbsp;'; ?></span>
					</li>
					<?php endforeach; ?>
				</div>
			</div>
			<?php endif; ?>
		</div>
		<?php endforeach; endif; ?>
	</div><!-- .row -->

	<?php if ( ! $has_results ): ?>
	<div class="row">
		<div class="large-4 medium-6 large-offset-4 medium-offset-3 columns">
			<h2 class="event-time"><?php echo '<span class="icon-clock"></span>'; the_time(); ?><?php sp_get_template( 'countdown.php', array( 'id' => get_the_ID() ) ); ?></h2>
		</div>
	</div><!-- .row -->
	<?php endif; ?>
</div><!-- .infinity -->
<?php endif; ?>

<?php if ( $venue ): ?>
	<?php
 	$t_id = $venue->term_id;
	$venue_meta = get_option( "taxonomy_$t_id" );
	$address = sportspress_array_value( $venue_meta, 'sp_address', null );
	$latitude = sportspress_array_value( $venue_meta, 'sp_latitude', null );
	$longitude = sportspress_array_value( $venue_meta, 'sp_longitude', null );
	?>
	<div class="infinity event-venue">
		<div class="row">
			<div class="medium-4 columns">
				<h4 class="date">
					<?php
				    $term_link = get_term_link( $venue->term_id, 'sp_venue' );
				    ?>
					<?php if ( ! is_wp_error( $term_link ) ): ?>
						<a href="<?php echo $term_link; ?>"><span class="icon-location"></span><?php echo $venue->name; ?></a>
					<?php else: ?>
						<span class="icon-location"></span><?php echo $venue->name; ?>
					<?php endif; ?>
				</h4>
			</div>
			<div class="medium-8 columns">
				<h4 class="right">
					<?php
					echo $address;
					?>
				</h4>
			</div>
		</div>
	</div><!-- .infinity -->
	<?php if ( ! $has_results && $latitude != null && $longitude != null ): ?>
	<div class="sp-google-map" data-address="<?php echo $address; ?>" data-latitude="<?php echo $latitude; ?>" data-longitude="<?php echo $longitude; ?>"></div>
	<?php endif; ?>
<?php endif; ?>

<div id="content" class="site-content" role="main">
	<?php sp_get_template( 'event-performance.php', array( 'id' => $id ) ); ?>
	<article id="post-<?php the_ID(); ?>" <?php post_class(); ?>>
		<div class="row">
			<?php $has_thumbnail = has_post_thumbnail(); ?>
			<?php if ( $has_thumbnail ): ?>
			<div class="large-6 large-push-6 columns">
				<?php the_post_thumbnail( 'themeboy-standard-thumbnail', array( 'class' => 'fill-image event-article-thumbnail' ) ); ?>
				<?php sp_get_template( 'event-video.php' ); ?>
				<?php if ( has_excerpt() ): ?>
				<div class="sp-excerpt">
					<?php echo apply_filters( 'the_content', get_the_excerpt() ); ?>
				</div>
				<?php endif; ?>
			</div><!-- .columns -->
			<?php endif; ?>
			<div class="<?php if ( $has_thumbnail ): ?>large-6 large-pull-6<?php else: ?>large-8 large-centered<?php endif; ?> columns">
				<?php if ( get_the_content() ): ?>
				<div class="infobox">
					<div class="entry-content">
						<h2>
							<?php
							if ( $event->status() == 'results' ):
								_e( 'Recap', 'sportspress' );
							else:
								_e( 'Preview', 'sportspress' );
							endif;
							?>
						</h2>
						<?php the_content(); ?>
					</div>
				</div>
				<?php endif; ?>
				<?php
				// If comments are open or we have at least one comment, load up the comment template.
				if ( comments_open() || get_comments_number() ) {
					comments_template();
				}
				?>
			</div><!-- .columns -->
		</div><!-- .row -->
	</div><!-- article -->
<?php endwhile; ?>

<?php get_footer();
