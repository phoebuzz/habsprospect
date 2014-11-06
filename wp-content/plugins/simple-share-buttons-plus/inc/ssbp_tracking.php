<?php
defined('ABSPATH') or die("No direct access permitted");

	// tracking page 
	function ssbp_tracking() {
	
		// check if user has the rights to manage options
		if ( !current_user_can( 'manage_options' ) )  {
		
			// permissions message
			wp_die( __('You do not have sufficient permissions to access this page.'));
		}

		// query the db for current ssbp settings
		$arrSettings = get_ssbp_settings();

		// --------- TRACKING PANEL ------------ //
		ssbp_admin_tracking($arrSettings);
	}
	
	// ajax call to save to tracking table
	function ssbp_tracking_callback() {
		
		// global db
		global $wpdb;
		
		// get ssbp table name
		$table_name = $wpdb->prefix . 'ssbp_tracking';
		
		$wpdb->insert($table_name, array(
										 'title' => $_POST['title'],
										 'url' => $_POST['url'],
										 'site' => $_POST['site'],
										 'ip' => $_SERVER['REMOTE_ADDR'],
										 'datetime' => date('Y-m-d H:i:s'),
										 ));
		return true;
	}
	
	// ajax call to save to tracking table
	function ssbp_standard_callback() {
		
		// global db
		global $wpdb;
		
		// get ssbp table name
		$table_name = $wpdb->prefix . 'ssbp_tracking';
		
		$wpdb->insert($table_name, array(
										 'title' => $_POST['title'],
										 'url' => $_POST['url'],
										 'site' => $_POST['site'],
										 'ip' => $_SERVER['REMOTE_ADDR'],
										 'datetime' => date('Y-m-d H:i:s'),
										 ));
		return true;
	}