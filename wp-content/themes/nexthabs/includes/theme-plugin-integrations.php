<?php
if ( ! defined( 'ABSPATH' ) ) exit;

/**
 * Checks if plugins are activated and loads logic accordingly.
 * @uses  class_exists() detect if a class exists
 * @uses  function_exists() detect if a function exists
 * @uses  defined() detect if a constant is defined
 */

/**
 * SportsPress
 * @link http://wordpress.org/plugins/sportspress/
 */
if ( is_sportspress_activated() ) {
	require_once( get_template_directory() . '/includes/integrations/sportspress/class-tb-sportspress.php' );
	require_once( get_template_directory() . '/includes/integrations/sportspress/tb-sportspress-functions.php' );
}
