<?php
/**
 * League Table
 *
 * @author 		ThemeBoy
 * @package 	SportsPress/Templates
 * @version     1.3
 */

if ( ! defined( 'ABSPATH' ) ) exit; // Exit if accessed directly

$defaults = array(
	'id' => get_the_ID(),
	'number' => -1,
	'columns' => null,
	'highlight' => null,
	'show_full_table_link' => false,
	'show_team_logo' => get_option( 'sportspress_table_show_logos', 'yes' ) == 'yes' ? true : false,
	'link_posts' => get_option( 'sportspress_link_teams', 'no' ) == 'yes' ? true : false,
	'sortable' => get_option( 'sportspress_enable_sortable_tables', 'yes' ) == 'yes' ? true : false,
	'scrollable' => get_option( 'sportspress_enable_scrollable_tables', 'yes' ) == 'yes' ? true : false,
	'responsive' => get_option( 'sportspress_enable_responsive_tables', 'yes' ) == 'yes' ? true : false,
	'paginated' => get_option( 'sportspress_table_paginated', 'yes' ) == 'yes' ? true : false,
	'rows' => get_option( 'sportspress_table_rows', 10 ),
);

extract( $defaults, EXTR_SKIP );

if ( ! isset( $highlight ) ) $highlight = get_post_meta( $id, 'sp_highlight', true );

$output = '<h4 class="sp-table-caption">' . get_the_title( $id ) . '</h4>';

$output .= '<div class="sp-table-wrapper' . ( $scrollable ? ' sp-scrollable-table-wrapper' : '' ) . '">';

$output .= '<table class="sp-league-table sp-data-table' . ( $responsive ? ' sp-responsive-table' : '' ) . ( $sortable ? ' sp-sortable-table' : '' ) . ( $paginated ? ' sp-paginated-table' : '' ) . '" data-sp-rows="' . $rows . '">' . '<thead>' . '<tr>';

$table = new SP_League_Table( $id );

$data = $table->data();

// The first row should be column labels
$labels = $data[0];

// Remove the first row to leave us with the actual data
unset( $data[0] );

if ( ! $columns )
	$columns = get_post_meta( $id, 'sp_columns', true );

if ( ! is_array( $columns ) )
	$columns = explode( ',', $columns );

$output .= '<th class="data-rank">' . __( 'Pos', 'sportspress' ) . '</th>';

foreach( $labels as $key => $label ):
	if ( ! is_array( $columns ) || $key == 'name' || in_array( $key, $columns ) )
		$output .= '<th class="data-' . $key . '">' . $label . '</th>';
endforeach;

$output .= '</tr>' . '</thead>' . '<tbody>';

$i = 0;
$start = 0;

if ( intval( $number ) > 0 ):
	$limit = $number;

	// Trim table to center around highlighted team
	if ( $highlight && sizeof( $data ) > $limit && array_key_exists( $highlight, $data ) ):
		
		// Number of teams in the table
		$size = sizeof( $data );

		// Position of highlighted team in the table
		$key = array_search( $highlight, array_keys( $data ) );

		// Get starting position
		$start = $key - ceil( $limit / 2 ) + 1;
		if ( $start < 0 ) $start = 0;

		// Trim table using starting position
		$trimmed = array_slice( $data, $start, $limit, true );

		// Move starting position if we are too far down the table
		if ( sizeof( $trimmed ) < $limit && sizeof( $trimmed ) < $size ):
			$offset = $limit - sizeof( $trimmed );
			$start -= $offset;
			if ( $start < 0 ) $start = 0;
			$trimmed = array_slice( $data, $start, $limit, true );
		endif;

		// Replace data
		$data = $trimmed;
	endif;
endif;

// Loop through the teams
foreach ( $data as $team_id => $row ):

	if ( isset( $limit ) && $i >= $limit ) continue;

	$name = sp_array_value( $row, 'name', null );
	if ( ! $name ) continue;

	// Generate tags for highlighted team
	$before = $after = $class = '';
	if ( $highlight == $team_id ):
		$before = '<strong>';
		$after = '</strong>';
		$class = ' highlighted';
	endif;

	$output .= '<tr class="' . ( $i % 2 == 0 ? 'odd' : 'even' ) . $class . '">';

	// Rank
	$output .= '<td class="data-rank">' . $before . ( $start + 1 ) . $after . '</td>';

	$name_class = '';

	if ( $show_team_logo ):
		if ( has_post_thumbnail( $team_id ) ):
			$logo = get_the_post_thumbnail( $team_id, 'sportspress-fit-icon' );
			$name = '<span class="team-logo">' . $logo . '</span>' . $before . $name . $after;
			$name_class .= ' has-logo';
		endif;
	endif;

	if ( $link_posts ):
		$permalink = get_post_permalink( $team_id );
		$name = '<a href="' . $permalink . '">' . $name . '</a>';
	endif;

	$output .= '<td class="data-name' . $name_class . '">' . $name . '</td>';

	foreach( $labels as $key => $value ):
		if ( $key == 'name' )
			continue;
		if ( ! is_array( $columns ) || in_array( $key, $columns ) )
			$output .= '<td class="data-' . $key . '">' . $before . sp_array_value( $row, $key, '&mdash;' ) . $after . '</td>';
	endforeach;

	$output .= '</tr>';

	$i++;
	$start++;

endforeach;

$output .= '</tbody>' . '</table>';

$output .= '</div>';

if ( $show_full_table_link )
	$output .= '<a class="sp-league-table-link sp-view-all-link" href="' . get_permalink( $id ) . '">' . __( 'View full table', 'sportspress' ) . '</a>';

?>
<div class="sp-template sp-template-league-table">
	<?php echo $output; ?>
</div>