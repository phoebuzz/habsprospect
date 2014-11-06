<?php
defined('ABSPATH') or die("No direct access permitted");

	// main settings 
	function ssbp_dashboard() {
	
		// check if user has the rights to manage options
		if ( !current_user_can( 'manage_options' ) )  {
		
			// permissions message
			wp_die( __('You do not have sufficient permissions to access this page.'));
		}

		// query the db for current ssbp settings
		$arrSettings = get_ssbp_settings();

		// --------- ADMIN DASHBOARD ------------ //
		ssbp_admin_dashboard($arrSettings);
	}

	// add settings link on plugin page
	function ssbp_settings_link($links) { 
	
		// add to plugins links
		array_unshift($links, '<a href="admin.php?page=simple-share-buttons-plus">Get started</a>'); 
		
		// return all links
		return $links; 
	}

	// include js files and upload script
	function ssbp_admin_scripts() {
	
		// ready available with wp
		wp_enqueue_script('media-upload');
		wp_enqueue_script('thickbox');
		wp_enqueue_script('wp-color-picker');
		wp_enqueue_script('jquery-ui-sortable');
		wp_enqueue_script('jquery-ui');
		
		// ssbp unique
		wp_register_script('ssbp-js', plugins_url('../js/ssbp_admin.js', __FILE__ ));
		wp_enqueue_script('ssbp-js');
		wp_register_script('ssbp-countup', plugins_url('../js/ssbp_countup.js', __FILE__ ));
		wp_enqueue_script('ssbp-countup');
		
		// google charts for tracking 
		wp_register_script('ssbpCharts', 'https://www.google.com/jsapi');
		wp_enqueue_script( 'ssbpCharts');
		
		// if we're viewing the tracking page
		if(isset($_GET['page']) && $_GET['page'] == 'simple-share-buttons-tracking') {
			
			// admin ajax post
			wp_enqueue_script('ssbp_total_shares_callback', plugins_url( '../js/ssbp_tracking_ajax.js' , __FILE__ ), array('jquery'), 1.0, true);
			wp_localize_script( 'ssbp_total_shares_callback', 'ssbpTotal', array());
			
			wp_enqueue_script('ssbp_top_three_callback', plugins_url( '../js/ssbp_tracking_ajax.js' , __FILE__ ), array('jquery'), 1.0, true);
			wp_localize_script( 'ssbp_top_three_callback', 'ssbpTop', array());
			
			// admin ajax post
			wp_enqueue_script('ssbp_latest_shares_callback', plugins_url( '../js/ssbp_tracking_ajax.js' , __FILE__ ), array('jquery'), 1.0, true);
			wp_localize_script( 'ssbp_latest_shares_callback', 'ssbpLatest', array());

			// admin ajax post
			wp_enqueue_script('ssbp_geoip_stats_callback', plugins_url( '../js/ssbp_tracking_ajax.js' , __FILE__ ), array('jquery'), 1.0, true);
			wp_localize_script( 'ssbp_geoip_stats_callback', 'ssbpGeoIP', array());
		}
	}
	
	// include styles for the ssbp admin panel
	function ssbp_admin_styles() {
	
		// admin styles
		wp_enqueue_style('thickbox');
		wp_enqueue_style('wp-color-picker');
		wp_register_style('ssbp-styles', plugins_url('../css/style.css', __FILE__ ));
		wp_enqueue_style('ssbp-styles');
	}
	
	// menu settings
	function ssbp_menu() {
	
		// add menu page
		add_object_page( 'Simple Share Buttons Plus', 'Share Buttons', 'manage_options', 'simple-share-buttons-plus', 'ssbp_dashboard', 'dashicons-plus');
		add_submenu_page( 'Simple Share Buttons Plus', 'Share Buttons', 'manage_options', 'simple-share-buttons-plus', 'ssbp_dashboard');
		add_submenu_page( 'simple-share-buttons-plus', 'Setup', 'Setup', 'manage_options', 'simple-share-buttons-setup', 'ssbp_settings');
		add_submenu_page( 'simple-share-buttons-plus', 'Styling', 'Styling', 'manage_options', 'simple-share-buttons-styling', 'ssbp_styling');
		add_submenu_page( 'simple-share-buttons-plus', 'Counters', 'Counters', 'manage_options', 'simple-share-buttons-counters', 'ssbp_counters');
		add_submenu_page( 'simple-share-buttons-plus', 'Meta Tags', 'Meta Tags', 'manage_options', 'simple-share-buttons-meta', 'ssbp_meta');
		add_submenu_page( 'simple-share-buttons-plus', 'Post Types', 'Post Types', 'manage_options', 'simple-share-buttons-post_types', 'ssbp_post_types');
		add_submenu_page( 'simple-share-buttons-plus', 'Advanced', 'Advanced', 'manage_options', 'simple-share-buttons-advanced', 'ssbp_advanced');
		add_submenu_page( 'simple-share-buttons-plus', 'Tracking', 'Tracking', 'manage_options', 'simple-share-buttons-tracking', 'ssbp_tracking');
		add_submenu_page( 'simple-share-buttons-plus', 'ort.sh', 'ort.sh', 'manage_options', 'simple-share-buttons-ortsh', 'ssbp_ortsh');
		add_submenu_page( 'simple-share-buttons-plus', 'License', 'License', 'manage_options', 'simple-share-buttons-license', 'ssbp_licensing');
		
		// query the db for current ssbp settings
		$arrSettings = get_ssbp_settings();
		
		// run the upgrade function
		upgrade_ssbp($arrSettings);		
	}
	
	// add latest stats to dashboard
	function ssbp_add_dashboard_widgets() {

		wp_add_dashboard_widget(
	                 'ssbp_dashboard_widget',         // Widget slug.
	                 'Simple Share Buttons Stats',    // Title.
	                 'ssbp_dashboard_widget_function' // Display function.
	        );	
	}
	add_action( 'wp_dashboard_setup', 'ssbp_add_dashboard_widgets' );

	/**
	 * Create the function to output the contents of our Dashboard Widget.
	 */
	function ssbp_dashboard_widget_function() {
		
		// include the admin panel functions
		include_once (plugin_dir_path(__FILE__) . 'ssbp_admin_panel.php');

		// Display whatever it is you want to show.
		echo ssbp_dashboard_stats();
	}