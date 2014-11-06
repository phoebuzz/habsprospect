<?php
/*
Plugin Name: Simple Share Buttons Plus
Plugin URI: http://www.simplesharebuttons.com/plus
Description: One of the most advanced WordPress share button plugins available.
Version: 0.4.2
Author: David S. Neal
Author URI: http://www.davidsneal.co.uk/
License: GPLv2

Copyright 2014 Simple Share Buttons admin@simplesharebuttons.com

This program is distributed in the hope that it will be useful,
but WITHOUT ANY WARRANTY; without even the implied warranty of
MERCHANTABILITY or FITNESS FOR A PARTICULAR PURPOSE.

//                 __         __      
//                /\ \       /\ \     
//    ____    ____\ \ \____  \_\ \___ 
//   /',__\  /',__\\ \ '__`\/\___  __\
//  /\__, `\/\__, `\\ \ \_\ \/__/\ \_/
//  \/\____/\/\____/ \ \_,__/   \ \_\ 
//   \/___/  \/___/   \/___/     \/_/ 
//                                    
//                                       
*/

	// if debug isn't set to true
	if(WP_DEBUG !== true){
		// turn error reporting off
		error_reporting(0);
	}
	
	// make sure we have settings ready
	// this has been introduced to exclude from excerpts
	$arrSettings = get_ssbp_settings();
	
	// set constant ready for updates
	define( 'SSBP_FILE', __FILE__ );
	
//======================================================================
// 		INCLUDES
//======================================================================

	// language
	include_once (plugin_dir_path(__FILE__) . '/lang/english.php');
	
	// admin side functions
	include_once (plugin_dir_path(__FILE__) . '/inc/ssbp_licensing.php');
	include_once (plugin_dir_path(__FILE__) . '/inc/ssbp_admin_bits.php');
	include_once (plugin_dir_path(__FILE__) . '/inc/ssbp_admin_panel.php');
	include_once (plugin_dir_path(__FILE__) . '/inc/ssbp_admin_save.php');
	include_once (plugin_dir_path(__FILE__) . '/inc/ssbp_database.php');
	include_once (plugin_dir_path(__FILE__) . '/inc/ssbp_tracking.php');
	include_once (plugin_dir_path(__FILE__) . '/inc/ssbp_geoip.php');
	
	// admin panels (more to be separated this way)
	include_once (plugin_dir_path(__FILE__) . '/inc/admin/ssbp_ortsh.php');
	
	// frontend side functions
	include_once (plugin_dir_path(__FILE__) . '/inc/ssbp_buttons.php');
	include_once (plugin_dir_path(__FILE__) . '/inc/ssbp_styles.php');
	include_once (plugin_dir_path(__FILE__) . '/inc/ssbp_widget.php');
	
	// the main share buttons class that is called via AJAX
	include_once (plugin_dir_path(__FILE__) . '/inc/ssbp_lazy.php');
	
	// if meta is enabled
	if($arrSettings['ssbp_meta_enabled'] == 'Y') {
	
		// the the meta file
		include_once (plugin_dir_path(__FILE__) . '/inc/ssbp_meta.php');
	}

	
//======================================================================
// 		ADMIN HOOKS
//======================================================================
	
	// register/uninstall
	register_activation_hook( __FILE__,'ssbp_activate');
	register_uninstall_hook(__FILE__,'ssbp_uninstall');
	
	// add filter hook for plugin action links
	add_filter('plugin_action_links_' . plugin_basename(__FILE__), 'ssbp_settings_link' );
	
	// add menu to dashboard
	add_action( 'admin_menu', 'ssbp_menu' );
	
	// check if viewing an ssbp admin page
	if (is_admin()) {
	
		// add the registered scripts
		add_action('admin_print_styles', 'ssbp_admin_styles');
		add_action('admin_print_scripts', 'ssbp_admin_scripts');
	}
	
	// add ssbp to available widgets
	add_action( 'widgets_init', create_function( '', 'register_widget( "ssbp_widget" );' ) );
	
	// add share buttons to content and/or excerpts
	add_filter( 'the_content', 'ssbp_show_share_buttons');	
	
	// if we wish to add to excerpts
	if($arrSettings['ssbp_excerpts'] == 'Y') {
		
		// add a hook
		add_filter( 'the_excerpt', 'ssbp_show_share_buttons');
	}
	
	// register the ajax action tracking
	add_action( 'wp_ajax_ssbp_total_shares', 'ssbp_total_shares_callback' );
	add_action( 'wp_ajax_ssbp_top_three', 'ssbp_top_three_callback' );
	add_action( 'wp_ajax_ssbp_latest_shares', 'ssbp_latest_shares_callback' );
	add_action( 'wp_ajax_ssbp_past_week', 'ssbp_past_week_callback' );
	add_action( 'wp_ajax_ssbp_geoip_stats', 'ssbp_geoip_stats_callback' );
	
	// if the export csv function has been run
	if(is_admin() && isset($_POST['ssvp_export']))
	{
		// export csv
		ssbp_export_csv();		
	}


//======================================================================
// 		FRONTEND HOOKS
//======================================================================

	// if option is set to use free version shortcode
	if($arrSettings['ssbp_use_ssba'] == 'Y') {

		// use old shortcode for new functions
		add_shortcode( 'ssba', 'ssbp_buttons' );
		add_shortcode( 'ssba_hide', 'ssbp_hide' );
	
	} else { // using new shortcode

		// register shortcode [ssbp] to show [ssbp_hide]
		add_shortcode( 'ssbp', 'ssbp_buttons' );
		add_shortcode( 'ssbp_hide', 'ssbp_hide' );
	}
	
	// a default style is selected
	if($arrSettings['ssbp_default_style'] != '') {
	
		// add the hook to include default css
		add_action( 'wp_enqueue_scripts', 'ssbp_default_styles' );
	}
	
	// add CSS to the head if needed
	add_action( 'wp_head', 'get_ssbp_style' );

	// if meta is enabled
	if($arrSettings['ssbp_meta_enabled'] == 'Y') {
	
		// add meta details to the head
		add_action( 'wp_head', 'get_ssbp_meta' );
	}
	
	// if lazy load is enabled
	if($arrSettings['ssbp_lazy_load'] == 'Y') {
  
		// register the ajax action for lazy load
		add_action( 'wp_ajax_ssbp_lazy', 'ssbp_lazy_callback' );
		add_action( 'wp_ajax_nopriv_ssbp_lazy', 'ssbp_lazy_callback' );
		
		// register the ajax action for tracking
		add_action( 'wp_ajax_nopriv_ssbp_tracking', 'ssbp_tracking_callback' );
		add_action( 'wp_ajax_ssbp_tracking', 'ssbp_tracking_callback' );
	
	} else { //not lazy loading
	
		// register the ajax action for tracking
		add_action( 'wp_ajax_nopriv_ssbp_standard', 'ssbp_standard_callback' );
		add_action( 'wp_ajax_ssbp_standard', 'ssbp_standard_callback' );
	}


//======================================================================
// 		GET SSBP SETTINGS
//======================================================================

	// return ssbp settings
	function get_ssbp_settings() {
	
		// globals
		global $wpdb;
		
		// query the db for current ssbp settings
		$arrSettings = $wpdb->get_results("SELECT option_name, option_value
											 FROM $wpdb->options 
											WHERE option_name LIKE 'ssbp_%'");
											
		// loop through each setting in the array
		foreach ($arrSettings as $setting) {
		
			// add each setting to the array by name
			$arrSettings[$setting->option_name] =  $setting->option_value;
		}
	
		// return
		return $arrSettings;	
	}
?>