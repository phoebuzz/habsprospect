<?php
if ( ! defined( 'ABSPATH' ) ) exit;

/**
 * Includes widgets
 *
 * @since   1.0
 * @return 	void
 * @author 	ThemeBoy
 */
function tb_include_widgets() {
	include_once( 'widgets/class-tb-widget-post-slider.php' ); 
	include_once( 'widgets/class-tb-widget-recent-posts.php' );
}
