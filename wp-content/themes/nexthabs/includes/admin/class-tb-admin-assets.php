<?php
/**
 * Load assets.
 *
 * @package WordPress
 * @subpackage Premier
 * @since Premier 1.0
 */

if ( ! defined( 'ABSPATH' ) ) exit; // Exit if accessed directly

if ( ! class_exists( 'TB_Admin_Assets' ) ) :

/**
 * TB_Admin_Assets Class
 */
class TB_Admin_Assets {

	/**
	 * Hook in tabs.
	 */
	public function __construct() {
		add_action( 'admin_enqueue_scripts', array( $this, 'admin_styles' ) );
	}

	/**
	 * Enqueue styles
	 */
	public function admin_styles() {
		global $wp_scripts;

		// Sitewide menu CSS
		wp_enqueue_style( 'themeboy-admin-menu-styles', get_template_directory_uri() . '/css/menu.css', array(), time() );

		$screen = get_current_screen();

		if ( in_array( $screen->id, array( 'widgets' ) ) ) {
			//wp_enqueue_style( 'themeboy-admin-widgets-styles', get_template_directory_uri() . '/assets/css/widgets.css', array(), time() );
		}

		do_action( 'themeboy_admin_css' );
	}
}

endif;

return new TB_Admin_Assets();
