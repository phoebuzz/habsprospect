<?php
if ( ! defined( 'ABSPATH' ) ) exit;

/**
 * Functions
 */

/**
 * Compatibility
 * Declare SportsPress support
 */
if ( ! function_exists( 'tb_sportspress_support' ) ) {
	function tb_sportspress_support() {
		add_theme_support( 'sportspress' );
	}
}

if ( ! function_exists( 'tb_position_object_types' ) ) {
	function tb_position_object_types ( $a ) {
		$a[] = 'attachment';
		return $a;
	}
}
if ( ! function_exists( 'tb_menu_clean' ) ) {
	function tb_menu_clean() {
		global $submenu;

	    // Remove "Positions" links from Media submenu
		if ( isset( $submenu['upload.php'] ) ):
			$submenu['upload.php'] = array_filter( $submenu['upload.php'], 'tb_submenu_remove_positions' );
		endif;
	}
}

if ( ! function_exists( 'tb_submenu_remove_positions' ) ) {
	function tb_submenu_remove_positions( $arr = array() ) {
		return $arr[0] != __( 'Positions', 'sportspress' );
	}
}
