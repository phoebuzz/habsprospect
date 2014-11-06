<?php
/**
 * Setup menus in WP admin.
 *
 * @author 		ThemeBoy
 * @category 	Admin
 * @package 	Premier/Admin
 * @version     1.0
 */

if ( ! defined( 'ABSPATH' ) ) exit; // Exit if accessed directly

if ( ! class_exists( 'TB_Admin_Menus' ) ) :

/**
 * TB_Admin_Menus Class
 */
class TB_Admin_Menus {

	/**
	 * Hook in tabs.
	 */
	public function __construct() {
		add_action( 'admin_menu', array( $this, 'admin_menu' ), 9 );
	}

	/**
	 * Add menu item
	 */
	public function admin_menu() {
		global $menu;

	    if ( current_user_can( 'manage_options' ) )
	    	$menu[] = array( '', 'read', 'separator-themeboy', '', 'wp-menu-separator themeboy' );

		$main_page = add_menu_page( __( 'Theme Settings', 'themeboy' ), __( 'ThemeBoy', 'themeboy' ), 'manage_options', 'themeboy', array( $this, 'settings_page' ) );
	}

	/**
	 * Init the settings page
	 */
	public function settings_page() {
		include_once( 'class-tb-admin-settings.php' );
		TB_Admin_Settings::output();
	}

	public function remove_add_new( $arr = array() ) {
		return $arr[0] != __( 'Add New', 'themeboy' );
	}

	public function remove_leagues( $arr = array() ) {
		return $arr[0] != __( 'Leagues', 'themeboy' );
	}

	public function remove_positions( $arr = array() ) {
		return $arr[0] != __( 'Positions', 'themeboy' );
	}

	public function remove_seasons( $arr = array() ) {
		return $arr[0] != __( 'Seasons', 'themeboy' );
	}

	public function remove_venues( $arr = array() ) {
		return $arr[0] != __( 'Venues', 'themeboy' );
	}

	public static function highlight_admin_menu( $p = 'themeboy', $s = 'themeboy' ) {
		global $parent_file, $submenu_file;
		$parent_file = $p;
		$submenu_file = $s;
	}
}

endif;

return new TB_Admin_Menus();