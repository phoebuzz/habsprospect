<?php
/**
 * Theme Settings Page/Tab
 *
 * @package WordPress
 * @subpackage Premier
 * @since Premier 1.0
 */

if ( ! defined( 'ABSPATH' ) ) exit; // Exit if accessed directly

if ( ! class_exists( 'TB_Settings_Page' ) ) :

/**
 * TB_Settings_Page
 */
class TB_Settings_Page {

	protected $id    = '';
	protected $label = '';

	/**
	 * Add this page to settings
	 */
	public function add_settings_page( $pages ) {
		$pages[ $this->id ] = $this->label;

		return $pages;
	}

	/**
	 * Get settings array
	 *
	 * @return array
	 */
	public function get_settings() {
		return array();
	}

	/**
	 * Output the settings
	 */
	public function output() {
		$settings = $this->get_settings();

		TB_Admin_Settings::output_fields( $settings );
	}

	/**
	 * Save settings
	 */
	public function save() {
		global $current_section;

		$settings = $this->get_settings();
		TB_Admin_Settings::save_fields( $settings );

		 if ( $current_section )
	    	do_action( 'themeboy_update_options_' . $this->id . '_' . $current_section );
	}
}

endif;
