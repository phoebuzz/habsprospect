<?php
if ( ! defined( 'ABSPATH' ) ) {
	exit; // Exit if accessed directly
}

/**
 * Theme Admin.
 *
 * @class 		TB_Admin 
 * @author 		ThemeBoy
 * @package 	WordPress
 * @subpackage 	Premier
 * @since 		Premier 1.0
 */
class TB_Admin {

	/**
	 * Constructor
	 */
	public function __construct() {
		add_action( 'init', array( $this, 'includes' ) );
	}

	/**
	 * Include any classes we need within admin.
	 */
	public function includes() {
		include( 'class-tb-admin-menus.php' );
		include( 'class-tb-admin-assets.php' );
		include( 'updater/tb-updater-functions.php' );
	}
}

return new TB_Admin();