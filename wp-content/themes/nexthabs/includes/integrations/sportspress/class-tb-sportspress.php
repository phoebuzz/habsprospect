<?php
if ( ! defined( 'ABSPATH' ) ) exit;
/**
 * Integrates this theme with the SportsPress plugin
 * http://wordpress.org/plugins/sportspress/
 *
 * @since 		1.0
 * @author 		ThemeBoy
 */

if ( ! defined( 'ABSPATH' ) ) exit; // Exit if accessed directly

if ( ! class_exists( 'TB_SportsPress' ) ) :

/**
 * TB_SportsPress Class
 */
class TB_SportsPress {

	public function __construct() {
		add_filter( 'sportspress_enqueue_styles', array( $this, 'styles' ) );
		add_filter( 'option_sportspress_enable_frontend_css', array( $this, 'disable_frontend_css' ) );
		add_action( 'after_setup_theme', array( $this, 'support' ) );

		add_filter( 'sportspress_position_object_types', array( $this, 'position_object_types' ) );
		add_filter( 'admin_menu', array( $this, 'menu_clean' ), 5 );
		
		remove_action( 'loop_start', 'sportspress_output_venue_map' );

		remove_action( 'sportspress_single_event_content', 'sportspress_output_event_video', 10 );
		remove_action( 'sportspress_single_event_content', 'sportspress_output_event_results', 20 );
		remove_action( 'sportspress_single_event_content', 'sportspress_output_event_details', 30 );
		remove_action( 'sportspress_single_event_content', 'sportspress_output_event_venue', 40 );
		remove_action( 'sportspress_single_event_content', 'sportspress_output_event_performance', 50 );
		remove_action( 'sportspress_single_event_content', 'sportspress_output_br_tag', 100 );

		remove_action( 'sportspress_single_team_content', 'sportspress_output_team_lists', 20 );
		remove_action( 'sportspress_single_team_content', 'sportspress_output_team_tables', 30 );
		remove_action( 'sportspress_single_team_content', 'sportspress_output_br_tag', 100 );
		remove_action( 'sportspress_after_single_team', 'sportspress_output_team_link', 10 );

		remove_action( 'sportspress_single_player_content', 'sportspress_output_player_details', 10 );
		remove_action( 'sportspress_single_player_content', 'sportspress_output_player_statistics', 20 );
		remove_action( 'sportspress_single_player_content', 'sportspress_output_br_tag', 100 );

		remove_action( 'sportspress_single_staff_content', 'sportspress_output_staff_details', 10 );
		remove_action( 'sportspress_single_staff_content', 'sportspress_output_br_tag', 100 );
	}

	/**
	 * Styling
	 * Remove general styles
	 */
	public function styles( $styles = array() ) {
		unset( $styles['sportspress-general'] );
		return $styles;
	}

	/**
	 * Styling
	 * Disable frontend CSS
	 */
	public function disable_frontend_css() {
		return 'no';
	}

	/**
	 * Compatibility
	 * Declare SportsPress support
	 */
	public function support() {
		add_theme_support( 'sportspress' );
	}

	public function position_object_types ( $a ) {
		$a[] = 'attachment';
		return $a;
	}

	public function menu_clean() {
		global $submenu;

	    // Remove "Positions" links from Media submenu
		if ( isset( $submenu['upload.php'] ) ):
			$submenu['upload.php'] = array_filter( $submenu['upload.php'], array( $this, 'remove_positions' ) );
		endif;
	}

	public function remove_positions( $arr = array() ) {
		return $arr[0] != __( 'Positions', 'sportspress' );
	}
}

endif;

new TB_SportsPress;
