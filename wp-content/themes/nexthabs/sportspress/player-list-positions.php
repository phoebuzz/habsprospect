<?php
/**
 * Player Positions
 *
 * @package WordPress
 * @subpackage Premier
 * @since Premier 1.0
 * @version 1.0
 */

if ( ! defined( 'ABSPATH' ) ) exit; // Exit if accessed directly

$team = get_post_meta( $id, 'sp_team', true );
$seasons = get_terms( 'sp_season' );

$players = get_post_meta( $id, 'sp_player', false );
$positions = get_terms( 'sp_position', 'orderby=slug' );

$valid_positions = array();

foreach( $positions as $position ):
	foreach ( $players as $player ):
		if ( has_term( $position->slug, 'sp_position', $player ) ):
			$valid_positions[] = $position;
			break;
		endif;
	endforeach;
endforeach;

if ( count( $valid_positions ) ):
?>
<div class="player-list-positions">
	<div class="row">
		<?php
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
			<div class="medium-4 small-6 columns left">
				<a href="#group-<?php echo $position->slug; ?>" class="smoothscroll">
					<div class="player-position">
						<?php
						foreach( $attachments as $attachment ):
							echo wp_get_attachment_image( $attachment->ID, 'themeboy-square-thumbnail', array( 'class' => 'fill-image' ) );
						endforeach;
						?>
						<h5 class="image-caption"><?php echo $position->name; ?></h5>
					</div>
				</a>
			</div><!-- .columns -->
			<?php
		endforeach;
		?>
	</div><!-- .row -->
</div><!-- .player-list-positions -->
<?php
endif;
/*

<div class="infinity team-name">
	<div class="row">
		<div class="small-12 columns">
			<h2><?php echo get_the_title( $team ); ?> — <?php echo $seasons ? $seasons[0]->name : ''; ?></h2>
			<a href="<?php echo get_post_permalink( $team ); ?>" class="team-logo"><?php echo get_the_post_thumbnail( $team, 'sportspress-fit-thumbnail' ); ?></a>
		</div>
	</div>
</div><!-- .infinity -->
<?php
endif;


<div class="player-list-players">
	<?php
	if ( $positions ):
		foreach( $positions as $position ):
			?>
			<div class="row">
				<div class="large-12 columns">
					<a name="position-<?php echo $position->slug; ?>" id="position-<?php echo $position->slug; ?>"></a>
					<h3 class="player-position-name"><?php echo $position->name; ?></h3>
				</div>
			</div><!-- .row -->
			<div class="row">
			<?php foreach( $players as $player ): if ( has_term( $position->term_id, 'sp_position', $player ) ): ?>
				<div class="large-3 medium-6 small-12 columns left">
					<a href="<?php echo get_permalink( $player ); ?>">
						<div class="player-link">
							<?php
							if( has_post_thumbnail( $player ) ):
								echo get_the_post_thumbnail( $player, 'themeboy-square-thumbnail', array( 'class' => 'fill-image' ) );
							endif;
							?>
							<h5 class="image-caption-alt">
								<?php echo get_the_title( $player ); ?>
								<?php
								$number = get_post_meta( $player, 'sp_number', true );
								if ( $number != null ): ?>
								<span class="player-number"><?php echo $number; ?></span>
								<?php endif; ?>
							</h5>
						</div>
					</a>
				</div><!-- .columns -->
			<?php endif; endforeach; ?>
			</div><!-- .row -->
			<?php
		endforeach;
	endif;
	?>
</div><!-- .player-list-players -->

<div class="player-list-details">
	<div class="row">
		<div class="large-12 columns">
			<?php the_content(); ?>
		</div><!-- .columns -->
	</div><!-- .row -->
</div><!-- .player-list-details -->
</div><!-- #content -->
*/