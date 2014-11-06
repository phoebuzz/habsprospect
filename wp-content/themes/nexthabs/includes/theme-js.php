<?php
if ( ! defined( 'ABSPATH' ) ) exit;

/**
 * Theme JS
 *
 * Functions used to enqueue or otherwise directly related to javascript.
 *
 * @since   3.0
 * @author 	ThemeBoy
 */

/**
 * Add script.
 *
 * Enqueue various scripts
 *
 * @since  	3.0
 * @return 	void
 * @uses   	wp_enqueue_script()
 * @author 	ThemeBoy
 */
if ( ! function_exists( 'tb_add_javascript' ) ) {
	function tb_add_javascript() {
		// Enqueue third party scripts
		wp_enqueue_script( 'modernizr', get_template_directory_uri() . '/js/modernizr/modernizr.min.js', array(), '2.7.2', false );

		// Enqueue scripts
    	wp_enqueue_script( 'themeboy', get_template_directory_uri() . '/js/scripts.min.js', array('jquery'), time(), true );

		do_action( 'tb_add_javascript' );
	} // End tb_add_javascript()
}
