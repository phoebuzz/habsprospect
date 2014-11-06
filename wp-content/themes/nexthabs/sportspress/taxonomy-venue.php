<?php
/**
 * The template for displaying a Venue
 *
 * @package WordPress
 * @subpackage Premier
 * @since Premier 1.0
 * @version 1.0
 */

get_header(); ?>

<?php
$venue = get_term_by( 'slug', get_query_var( 'term' ), 'sp_venue' );
$t_id = $venue->term_id;
$venue_meta = get_option( "taxonomy_$t_id" );
$address = sportspress_array_value( $venue_meta, 'sp_address', null );
$latitude = sportspress_array_value( $venue_meta, 'sp_latitude', null );
$longitude = sportspress_array_value( $venue_meta, 'sp_longitude', null );

$primary_result = get_option( 'sportspress_primary_result', null );
$link_teams = get_option( 'sportspress_calendar_link_teams', 'no' ) == 'yes' ? true : false;
$paginated = true;
?>
<div class="infinity event-venue">
	<div class="row">
		<div class="small-4 columns">
			<h4 class="date">
				<span class="icon-location"></span><?php echo $venue->name; ?>
			</h4>
		</div>
		<div class="small-8 columns">
			<h4 class="right">
				<?php echo $address; ?>
			</h4>
		</div>
	</div>
</div><!-- .infinity -->
<?php if ( $latitude != null && $longitude != null ): ?>
<div class="sp-google-map sp-venue-map" data-address="<?php echo $address; ?>" data-latitude="<?php echo $latitude; ?>" data-longitude="<?php echo $longitude; ?>"></div>
<?php endif; ?>

<div id="content" class="site-content" role="main">
	<div class="row">
		<div class="large-8 columns">
			<?php if ( have_posts() ) : ?>
				<div class="sp-table-wrapper">
					<table class="sp-event-blocks sp-data-table<?php if ( $paginated ) { ?> sp-paginated-table<?php } ?>" data-sp-rows="<?php echo $rows; ?>">
						<thead><tr><th></th></tr></thead> <?php # Required for DataTables ?>
						<tbody>
							<?php
							$i = 0;
							while ( have_posts() ): the_post();

								$results = get_post_meta( get_the_ID(), 'sp_results', true );

								$teams = array_unique( get_post_meta( get_the_ID(), 'sp_team' ) );
								$logos = array();
								$main_results = array();

								$j = 0;
								foreach( $teams as $team ):
									$j++;
									if ( has_post_thumbnail ( $team ) ):
										if ( $link_teams ):
											$logo = '<a href="' . get_post_permalink( $team ) . '" title="' . get_the_title( $team ) . '">' . get_the_post_thumbnail( $team, 'sportspress-fit-icon', array( 'class' => 'team-logo logo-' . ( $j % 2 ? 'odd' : 'even' ) ) ) . '</a>';
										else:
											$logo = get_the_post_thumbnail( $team, 'sportspress-fit-icon', array( 'class' => 'team-logo logo-' . ( $j % 2 ? 'odd' : 'even' ) ) );
										endif;
										$logos[] = $logo;
									endif;
									$team_results = sp_array_value( $results, $team, null );

									if ( $primary_result ):
										$team_result = sp_array_value( $team_results, $primary_result, null );
									else:
										if ( is_array( $team_results ) ):
											end( $team_results );
											$team_result = prev( $team_results );
										else:
											$team_result = null;
										endif;
									endif;
									if ( $team_result != null )
										$main_results[] = $team_result;

								endforeach;
								?>
								<tr class="sp-row sp-post<?php echo ( $i % 2 == 0 ? ' alternate' : '' ); ?>">
									<td>
										<?php echo implode( $logos, ' ' ); ?>
										<time class="event-date"><?php echo get_the_time( get_option( 'date_format' ), get_the_ID() ); ?></time>
										<?php if ( get_post_status( get_the_ID() ) == 'future' ): ?>
											<h5 class="event-time"><?php echo get_the_time( get_option( 'time_format' ), get_the_ID() ); ?></h5>
										<?php else: ?>
											<h5 class="event-results"><?php echo implode( $main_results, ' - ' ); ?></h5>
										<?php endif; ?>
										<h3 class="event-title"><a href="<?php echo get_post_permalink( get_the_ID() ); ?>"><?php echo get_the_title( get_the_ID() ); ?></a></h3>
									</td>
								</tr>
								<?php
								$i++;
							endwhile;
							?>
						</tbody>
					</table>
				</div>
			<?php else : ?>
			<?php get_template_part( 'content', 'none' ); ?>
			<?php endif; ?>
		</div><!-- .columns -->

		<div class="large-4 columns">
			<?php get_sidebar( 'content' ); ?>
			<?php get_sidebar(); ?>
		</div><!-- .columns -->

	</div><!-- .row -->
</div><!-- #content -->

<?php get_footer();
