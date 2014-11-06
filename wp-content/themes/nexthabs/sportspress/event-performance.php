<?php
/**
 * Event Performance
 *
 * @package WordPress
 * @subpackage Premier
 * @since Premier 1.0
 * @version 1.3.2
 */

if ( ! defined( 'ABSPATH' ) ) exit; // Exit if accessed directly

if ( ! isset( $id ) )
	$id = get_the_ID();

$event = new SP_Event( $id );

$teams = (array)get_post_meta( $id, 'sp_team', false );
$teams = array_unique( array_filter( $teams ) );
$staff = (array)get_post_meta( $id, 'sp_staff', false );

$status = $event->status();
$stats = (array)get_post_meta( $id, 'sp_players', true );
if ( $status == 'results' ):
	$performance_labels = sp_get_var_labels( 'sp_performance' );
else:
	$performance_labels = array();
endif;

$link_posts = get_option( 'sportspress_event_link_players', 'yes' ) == 'yes' ? true : false;
$sortable = get_option( 'sportspress_enable_sortable_tables', 'yes' ) == 'yes' ? true : false;
$responsive = get_option( 'sportspress_enable_responsive_tables', 'yes' ) == 'yes' ? true : false;

$performance = $event->performance();

// The first row should be column labels
$labels = $performance[0];

// Remove the first row to leave us with the actual data
unset( $performance[0] );

?>
<div class="row">
	<?php
	$i = 0;

	foreach( $teams as $key => $team_id ):
		if ( ! $team_id ) continue;

		$totals = array();

		// Get results for players in the team
		$players = sp_array_between( (array)get_post_meta( $id, 'sp_player', false ), 0, $key );
		$has_players = sizeof( $players ) > 1;

		$data = sp_array_combine( $players, sp_array_value( $performance, $team_id, array() ) );

		$lineup_sub_relation = array();
		if ( is_array( $data ) && sizeof( $data ) ): foreach ( $data as $player_id => $player ):
			if ( sp_array_value( $player, 'status', 'lineup' ) == 'sub' && sp_array_value( $player, 'sub', null ) ):
				$lineup_sub_relation[ $player['sub'] ] = $player_id;
			endif;

			foreach( $labels as $key => $label ):
				if ( $key == 'name' )
					continue;
				if ( $key == 'position' ):
					if ( array_key_exists( $key, $player ) && $player[ $key ] != '' ):
						$position = get_term_by( 'id', $player[ $key ], 'sp_position' );
						$value = $position->name;
					else:
						$value = '&mdash;';
					endif;
				else:
					if ( array_key_exists( $key, $player ) && $player[ $key ] != '' ):
						$value = $player[ $key ];
					else:
						$value = 0;
					endif;
				endif;
				if ( ! array_key_exists( $key, $totals ) ):
					$totals[ $key ] = 0;
				endif;
				$totals[ $key ] += $value;
			endforeach;
		endforeach; endif;

		$team_totals[] = array_merge( $totals, array_filter( sp_array_value( sp_array_value( $performance, $team_id, array() ), 0, array() ) ) );
	?>
	<div class="large-4<?php
	if ( $status != 'results' ):
		if ( $i % 2 == 0 ): ?> large-push-2<?php
		else: ?> large-pull-2<?php
		endif;
	elseif ( count( $teams ) == 2 && $i % 2 == 1 ): ?> large-push-4<?php
	endif; ?> medium-6 columns">
		<div class="event-team-players">
			<h4 class="sp-table-caption"><?php echo get_the_title( $team_id ); ?></h4>
			<?php if ( $has_players ): ?>
				<table class="event-players-table">
					<?php if ( is_array( $data ) && sizeof( $data ) ): ?>
						<tbody>
							<?php foreach ( $data as $player_id => $player ): if ( ! $player_id || sp_array_value( $player, 'status', 'lineup' ) != 'lineup' ) continue; ?>
								<tr class="alt status-<?php echo sp_array_value( $player, 'status' ); ?>">
									<td class="player-number"><?php echo get_post_meta( $player_id, 'sp_number', true ); ?></td>
									<td class="player-name">
										<a href="<?php echo get_post_permalink( $player_id ); ?>"><?php echo get_the_title( $player_id ); ?></a>
										<?php if ( isset( $player['sub'] ) && $player['sub'] ): ?>
											<span data-tooltip class="sub has-tip" title="<?php echo get_the_title( $player['sub'] ); ?>"><div class="dashicons dashicons-arrow-up"></div></span>
										<?php elseif ( array_key_exists( $player_id, $lineup_sub_relation ) ): ?>
											<span data-tooltip class="sub has-tip" title="<?php echo get_the_title( $lineup_sub_relation[ $player_id ] ); ?>"><div class="dashicons dashicons-arrow-down"></div></span>
										<?php endif; ?>
									</td>
								</tr>
							<?php endforeach; ?>
							<?php foreach ( $data as $player_id => $player ): if ( ! $player_id || sp_array_value( $player, 'status', 'lineup' ) != 'sub' ) continue; ?>
								<tr class="alt status-<?php echo sp_array_value( $player, 'status' ); ?>">
									<td class="player-number"><?php echo get_post_meta( $player_id, 'sp_number', true ); ?></td>
									<td class="player-name">
										<a href="<?php echo get_post_permalink( $player_id ); ?>"><?php echo get_the_title( $player_id ); ?></a>
										<?php if ( isset( $player['sub'] ) && $player['sub'] ): ?>
											<span data-tooltip class="sub has-tip" title="<?php echo get_the_title( $player['sub'] ); ?>"><div class="dashicons dashicons-arrow-up"></div></span>
										<?php elseif ( array_key_exists( $player_id, $lineup_sub_relation ) ): ?>
											<span data-tooltip class="sub has-tip" title="<?php echo get_the_title( $lineup_sub_relation[ $player_id ] ); ?>"><div class="dashicons dashicons-arrow-down"></div></span>
										<?php endif; ?>
									</td>
								</tr>
							<?php endforeach; ?>
						</tbody>
					<?php endif; ?>
				</table>
			<?php endif; ?>
		</div>
	</div>
	<?php $i++; endforeach; ?>

	<?php if ( $status == 'results' && count( $teams ) == 2 ): ?>
		<div class="large-4 large-pull-4 medium-6 medium-12 columns">
			<div class="event-team-ratio">
				<?php
				$home = array_shift( $team_totals );
				$away = array_shift( $team_totals );

				foreach ( $performance_labels as $key => $label ):
					if ( ! isset( $home[ $key ] ) || ! isset( $away[ $key ] ) )
						continue;

					$first = empty( $home[ $key ] ) ? 0 : $home[ $key ];
					$last = empty( $away[ $key ] ) ? 0 : $away[ $key ];

					$total = $first + $last;
					if ( $total == 0 ):
						$ratio = 0.5;
					else:
						$ratio = $first / $total;
					endif;
					$percentage = round( $ratio * 100 );
					?>
					<h5><?php echo $label; ?></h5>
					<div class="statistic">
						<div data-tooltip class="bar has-tip smoothbar" title="<?php echo $percentage; ?>%" data-percentage="<?php echo $percentage; ?>"></div>
						<div data-tooltip class="remainder has-tip" title="<?php echo 100-$percentage; ?>%" style="width: <?php echo 100-$percentage; ?>%;"></div>
						<span class="first"><?php echo $first; ?></span>
						<span class="last"><?php echo $last; ?></span>
					</div>
				<?php endforeach; ?>
			</div>
		</div>
	<?php endif; ?>

	<?php if ( false && $status == 'results' && sizeof( $breakdown ) == 2 ): ?>
		<?php
		$args = array(
			'post_type' => 'sp_performance',
			'numberposts' => -1,
			'posts_per_page' => -1,
			'orderby' => 'menu_order',
			'order' => 'ASC',
		);
		$performances = get_posts( $args );

		$home = tb_array_value( reset( $breakdown ), 0, array() );
		$away = tb_array_value( end( $breakdown ), 0, array() );
		?>
		<div class="large-4 large-pull-4 medium-6 medium-12 columns">
			<div class="event-team-ratio">
				<?php foreach ( $performances as $performance ): ?>
					<?php
					if ( ! isset( $home[ $performance->post_name ] ) || ! isset( $away[ $performance->post_name ] ) )
						continue;

					$first = $home[ $performance->post_name ];
					$last = $away[ $performance->post_name ];

					if ( $first == null )
						$first = 0;
					if ( $last == null )
						$last = 0;

					$total = $first + $last;
					if ( $total == 0 ):
						$ratio = 0.5;
					else:
						$ratio = $first / $total;
					endif;
					$percentage = round( $ratio * 100 );
					?>
					<h5><?php echo $performance->post_title; ?></h5>
					<div class="statistic">
						<div data-tooltip class="bar has-tip" title="<?php echo $percentage; ?>%" style="width: <?php echo $percentage; ?>%;"></div>
						<div data-tooltip class="remainder has-tip" title="<?php echo 100-$percentage; ?>%" style="width: <?php echo 100-$percentage; ?>%;"></div>
						<span class="first"><?php echo $first; ?></span>
						<span class="last"><?php echo $last; ?></span>
					</div>
				<?php endforeach; ?>
			</div>
		</div>
	<?php endif; ?>
</div><!-- .row -->
