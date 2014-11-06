<?php
/**
 * Player Gallery
 *
 * @package WordPress
 * @subpackage Premier
 * @since Premier 1.0
 * @version 1.1
 */

if ( ! defined( 'ABSPATH' ) ) exit; // Exit if accessed directly

$defaults = array(
	'id' => get_the_ID(),
	'number' => -1,
	'grouping' => null,
	'orderby' => 'default',
	'order' => 'ASC',
	'itemtag' => 'dl',
	'icontag' => 'dt',
	'captiontag' => 'dd',
	'columns' => 3,
	'size' => 'thumbnail',
	'show_all_players_link' => false,
	'link_posts' => get_option( 'sportspress_list_link_players', 'yes' ) == 'yes' ? true : false,
);

extract( $defaults, EXTR_SKIP );

if ( $columns == 2 )
	$class = 'medium-6 small-6 columns left';
elseif ( $columns == 1 )
	$class = 'large-12 columns left';
else
	$class = 'large-4 medium-4 small-6 columns left  data-animation-delay="0.1s" data-animation="fadeIn" style="-webkit-animation: 0.9s 0.1s;"';

$list = new SP_Player_List( $id );
$data = $list->data();

// Remove the first row to leave us with the actual data
unset( $data[0] );

if ( $grouping === null || $grouping === 'default' ):
	$grouping = $list->grouping;
endif;

if ( $orderby == 'default' ):
	$orderby = $list->orderby;
	$order = $list->order;
else:
	$list->priorities = array(
		array(
			'key' => $orderby,
			'order' => $order,
		),
	);
	uasort( $data, array( $list, 'sort' ) );
endif;

if ( is_int( $number ) && $number > 0 )
	$limit = $number;

if ( !isset( $limit ) && $grouping === 'position' )
	sp_get_template( 'player-list-positions.php', array( 'id' => $id ) );
?>
<div class="player-list-players">
	<?php
	if ( $grouping === 'position' ):
		$groups = get_terms( 'sp_position', array( 'orderby' => 'slug' ) );
	else:
		$group = new stdClass();
		$group->term_id = null;
		$group->name = null;
		$group->slug = null;
		$groups = array( $group );
	endif;

	foreach ( $groups as $group ):
		$i = 0;

		if ( ! empty( $group->name ) ):
		?>
		<div class="row">
			<div class="large-12 columns">
				<a name="group-<?php echo $group->slug; ?>" id="group-<?php echo $group->slug; ?>"></a>
				<h3 class="player-group-name"><?php echo $group->name; ?></h3>
			</div>
		</div><!-- .row -->
		<?php endif; ?>
		
		<div class="row">
			<?php foreach( $data as $player_id => $performance ): if ( empty( $group->term_id ) || has_term( $group->term_id, 'sp_position', $player_id ) ): ?>
			<?php
				if ( isset( $limit ) && $i >= $limit ) continue;
				
				$caption = get_the_title( $player_id );
				$caption = trim( $caption );

			    sp_get_template( 'player-gallery-thumbnail.php', array(
			    	'id' => $player_id,
			    	'class' => $class,
			    	'performance' => $performance,
			    	'itemtag' => $itemtag,
			    	'icontag' => $icontag,
			    	'captiontag' => $captiontag,
			    	'caption' => $caption,
			    	'size' => $size,
			    	'link_posts' => $link_posts,
			    ) );

				$i++;

			endif; endforeach;
			?>
		</div><!-- .row -->
	<?php endforeach; ?>
</div><!-- .player-list-players -->
<?php
if ( $show_all_players_link )
	echo '<a class="sp-player-list-link sp-view-all-link" href="' . get_permalink( $id ) . '">' . __( 'View all players', 'sportspress' ) . '</a>';
