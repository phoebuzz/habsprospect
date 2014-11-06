<?php
defined('ABSPATH') or die("No direct access permitted");

	// activate ssbp function
	function ssbp_activate() {
	
		// insert default options for ssbp
		add_option('ssbp_version', 				'0.4.2');
		add_option('ssbp_install_date', 		date('dS F Y'));
		add_option('ssbp_ortsh_enabled', 		'');
		add_option('ssbp_use_ssba', 			'');
		add_option('ssbp_lazy_load', 			'Y');
		add_option('ssbp_pages',				'');
		add_option('ssbp_posts',				'');
		add_option('ssbp_cats_archs',			'');
		add_option('ssbp_homepage',				'');
		add_option('ssbp_excerpts',				'');
		add_option('ssbp_before_or_after', 		'after');
		add_option('ssbp_alignment', 			'left');
		add_option('ssbp_custom_styles', 		'');
		add_option('ssbp_button_percent', 		'');
		add_option('ssbp_email_message', 		'');
		add_option('ssbp_rel_nofollow', 		'');
		add_option('ssbp_twitter_text', 		'');
		add_option('ssbp_twitter_tags', 		'');
		add_option('ssbp_twitter_username',		'');
		add_option('ssbp_buffer_text', 			'');
		add_option('ssbp_flattr_user_id', 		'');
		add_option('ssbp_flattr_url', 			'');
		add_option('ssbp_show_btn_txt',			'N');
		add_option('ssbp_default_style',		'');
		add_option('ssbp_additional_css',		'');
		add_option('ssbp_button_shape',			'rectangle');
		add_option('ssbp_size',					'medium');
		add_option('ssbp_icon_color',			'white');
		add_option('ssbp_counters_enabled',		'');
		add_option('ssbp_share_api',			'');
		add_option('ssbp_counters_type',		'total');
		add_option('ssbp_min_shares',			'0');
		add_option('ssbp_count_timeout',		'4');
		add_option('ssbp_count_cache',			'600');
		add_option('ssbp_count_protocol',		'');
		add_option('ssbp_button_borders',		'Y');
		add_option('ssbp_button_margin',		'5');

		//bity
		add_option('ssbp_bitly_login',			'');
		add_option('ssbp_bitly_api_key',		'');
		
		// custom post types
		add_option('ssbp_disabled_types',		'');

		// meta defaults
		add_option('ssbp_meta_enabled', '');
		add_option('ssbp_meta_title', '');
		add_option('ssbp_meta_description', '');
		add_option('ssbp_meta_image', '');
		
		// share text
		add_option('ssbp_text_placement',		'above');
		add_option('ssbp_widget_text',			'');
		add_option('ssbp_share_text', 			'');
		add_option('ssbp_font_family', 			'Indie Flower');
		add_option('ssbp_font_color',			'');	
		add_option('ssbp_font_size',			'20');
		add_option('ssbp_font_weight',			'normal');
		
		// include
		add_option('ssbp_selected_buttons', 	'');
		
		// custom colours
		add_option('ssbp_color_main', 			'');
		add_option('ssbp_color_border', 		'');
		add_option('ssbp_color_hover',			'');
		
		// custom images
		add_option('ssbp_custom_images', 		'');
		add_option('ssbp_image_width', 			'32');
		add_option('ssbp_image_height', 		'32');
		add_option('ssbp_image_padding', 		'5');
		add_option('ssbp_custom_buffer', 		'');
		add_option('ssbp_custom_diggit', 		'');
		add_option('ssbp_custom_email', 		'');
		add_option('ssbp_custom_google', 		'');
		add_option('ssbp_custom_facebook', 		'');
		add_option('ssbp_custom_flattr', 		'');
		add_option('ssbp_custom_linkedin', 	  	'');
		add_option('ssbp_custom_pinterest', 	'');
		add_option('ssbp_custom_print', 		'');
		add_option('ssbp_custom_reddit', 	  	'');
		add_option('ssbp_custom_stumbleupon', 	'');
		add_option('ssbp_custom_tumblr', 		'');
		add_option('ssbp_custom_twitter', 		'');
		add_option('ssbp_custom_vk', 			'');

		// add ssbp tracking table
		ssbp_add_table();
	}
	
	// add ssbp tracking table
	function ssbp_add_table() {
		
		// wpdb global
		global $wpdb;
		
		// use prefix to ssbp table name
		$table_name = $wpdb->prefix . 'ssbp_tracking';
		
		// prepare sql
		$sql = "CREATE TABLE $table_name (
				  id mediumint(9) NOT NULL AUTO_INCREMENT,
				  title text NOT NULL,
				  url VARCHAR(90) NOT NULL,
				  site VARCHAR(90) NOT NULL,
				  ip VARCHAR(15) DEFAULT NULL,
				  datetime DATETIME NOT NULL,
				  UNIQUE KEY id (id)
				);";

		// include wp upgrade functionality and add table
		require_once( ABSPATH . 'wp-admin/includes/upgrade.php' );
		dbDelta( $sql );
	}
	
	// the upgrade function
	function upgrade_ssbp($arrSettings) {

		// if version is before 0.1.0
		if($arrSettings['ssbp_version'] < '0.1.0') {

			// counters added
			// added in 0.1.0
			add_option('ssbp_counters_enabled',		'');
			add_option('ssbp_counters_type',		'total');
			add_option('ssbp_button_borders',		'Y');
		}
		
		// square option added = change shape to select
		// previously (v <= 0.1.2) it was nothing or circle checkbox
		if($arrSettings['ssbp_version'] <= '0.1.2') {
			
			// if circle buttons were selected
			if($arrSettings['ssbp_circle_buttons'] == 'Y') {
				
				// add button shape accordingly
				add_option('ssbp_button_shape', 'circle');
				
			} else { // old default was rectangle
			
				// add button shape set to rectangle (the default)
				add_option('ssbp_button_shape', 'rectangle');
			}
		}
		
		// added in 0.1.4
		if($arrSettings['ssbp_version'] < '0.1.4') {
			
			// old school styling options
			add_option('ssbp_text_placement', 'above');
			add_option('ssbp_button_margin', '5');
			add_option('ssbp_font_weight', 'normal');
		}

		// lower than 0.1.6
		if($arrSettings['ssbp_version'] < '0.1.6') {
		
			// added in 0.1.6
			add_option('ssbp_lazy_load', 'Y');
		}
		
		// lower than 0.1.7
		if($arrSettings['ssbp_version'] < '0.1.7') {

			// meta added in 0.1.7
			add_option('ssbp_meta_enabled', '');
			add_option('ssbp_meta_title', '');
			add_option('ssbp_meta_descripton', '');
			add_option('ssbp_meta_image', '');
		}

		// lower than 0.1.7
		if($arrSettings['ssbp_version'] < '0.1.7') {
		
			// added in 0.1.8
			add_option('ssbp_icon_color',		'white');
			add_option('ssbp_default_style',	'');
			add_option('ssbp_additional_css',	'');
			add_option('ssbp_rel_nofollow',		'');
		}
		
		// lower than 0.2.0
		if($arrSettings['ssbp_version'] < '0.2.0') 
		{
			// added in 0.2.0
			add_option('ssbp_use_ssba',			'');
			add_option('ssbp_bitly_login',		'');
			add_option('ssbp_bitly_api_key',	'');
			add_option('ssbp_disabled_types',	'');

			// add new geoip field
			ssbp_add_geoip();
		}
		
		// lower than 0.2.1
		if($arrSettings['ssbp_version'] < '0.2.1')
		{
			// added in 0.2.1
			add_option('ssbp_min_shares',	 '0');
			add_option('ssbp_count_timeout', '4');
		}

		// lower than 0.3.0
		if($arrSettings['ssbp_version'] < '0.3.0')
		{
			// new in 0.3.0
			add_option('ssbp_count_cache',	'600');
		}
		
		// lower than 0.3.1
		if($arrSettings['ssbp_version'] < '0.3.1')
		{
			// new in 0.3.1
			add_option('ssbp_count_protocol',	'');
		}

		// lower than 0.4.1
		if($arrSettings['ssbp_version'] < '0.4.1')
		{
			// new in 0.4.0
			add_option('ssbp_ortsh_enabled', '');
			add_option('ssbp_share_api', '');
			
			// ensure encoding of tracking table is unicode
			ssbp_tracking_unicode();
		}
		
		// lower than 0.4.2
		if($arrSettings['ssbp_version'] < '0.4.2')
		{
			// new in 0.4.1
			// ensure encoding of tracking table is unicode
			ssbp_tracking_unicode();
			
			// new in 0.4.2
			// delete all ortsh to fix those that don't contain full json encoded info
			delete_ortsh_data();
			// add twitter username/via
			add_option('ssbp_twitter_username', '');
	
			// set new version number
			update_option('ssbp_version', '0.4.2');
		}
	}
	
	// make ssbp tracking table unicode
	function delete_ortsh_data() {
		
		// wpdb global
		global $wpdb;
		
		// hide errors in case
		$wpdb->hide_errors();
		
		// use prefix to ssbp table name
		$table_name = $wpdb->prefix . 'options';
		
		// include wp upgrade functionality and add field
		require_once( ABSPATH . 'wp-admin/includes/upgrade.php' );
		
		// prepare and run sql
		$sql = "DELETE FROM $table_name WHERE option_name LIKE 'ortsh_%';";
		$wpdb->query($sql);
	}
	

	// make ssbp tracking table unicode
	function ssbp_tracking_unicode() {
		
		// wpdb global
		global $wpdb;
		
		// hide errors in case
		$wpdb->hide_errors();
		
		// use prefix to ssbp table name
		$table_name = $wpdb->prefix . 'ssbp_tracking';
		
		// include wp upgrade functionality and add field
		require_once( ABSPATH . 'wp-admin/includes/upgrade.php' );
		
		// prepare and run sql
		$sql = "alter table $table_name convert to character set utf8 collate utf8_unicode_ci;";
		$wpdb->query($sql);
	}
	
	// alter ssbp tracking table
	function ssbp_add_geoip() {
		
		// wpdb global
		global $wpdb;
		
		// hide errors in case the column already exists
		$wpdb->hide_errors();
		
		// use prefix to ssbp table name
		$table_name = $wpdb->prefix . 'ssbp_tracking';
		
		// include wp upgrade functionality and add field
		require_once( ABSPATH . 'wp-admin/includes/upgrade.php' );
		
		// prepare and run sql
		$sql = "ALTER IGNORE TABLE $table_name ADD geoip VARCHAR(85);";
		$wpdb->query($sql);

		// set to utf8 unicode
		ssbp_tracking_unicode();
	}
		
	// uninstall ssbp
	function ssbp_uninstall() {
		
		//if uninstall not called from WordPress exit
		if (defined('WP_UNINSTALL_PLUGIN')) {
			exit();
		}

		// delete all options
		delete_option('ssbp_version');
		delete_option('ssbp_install_date');
		delete_option('ssbp_ortsh_enabled');
		delete_option('ssbp_use_ssba');
		delete_option('ssbp_lazy_load');
		delete_option('ssbp_pages');
		delete_option('ssbp_posts');
		delete_option('ssbp_cats_archs');
		delete_option('ssbp_homepage');
		delete_option('ssbp_excerpts');
		delete_option('ssbp_before_or_after');
		delete_option('ssbp_custom_styles');
		delete_option('ssbp_button_percent');
		delete_option('ssbp_email_message');
		delete_option('ssbp_rel_nofollow');
		delete_option('ssbp_twitter_text');
		delete_option('ssbp_twitter_tags');
		delete_option('ssbp_twitter_username');
		delete_option('ssbp_buffer_text');
		delete_option('ssbp_flattr_user_id');
		delete_option('ssbp_flattr_url');
		delete_option('ssbp_show_share_count');
		delete_option('ssbp_share_count_once');
		delete_option('ssbp_show_btn_txt');
		delete_option('ssbp_default_style');
		delete_option('ssbp_additional_css');
		delete_option('ssbp_button_shape');
		delete_option('ssbp_size');
		delete_option('ssbp_icon_color');
		delete_option('ssbp_counters_enabled');
		delete_option('ssbp_share_api');
		delete_option('ssbp_counters_type');
		delete_option('ssbp_min_shares');
		delete_option('ssbp_count_timeout');
		delete_option('ssbp_count_cache');
		delete_option('ssbp_count_protocol');
		delete_option('ssbp_button_borders');
		delete_option('ssbp_button_margin');

		// bitly
		delete_option('ssbp_bitly_login');
		delete_option('ssbp_bitly_api_key');
		
		// custom post types
		delete_option('ssbp_disabled_types');

		// meta defaults
		delete_option('ssbp_meta_enabled');
		delete_option('ssbp_meta_title');
		delete_option('ssbp_meta_description');
		delete_option('ssbp_meta_image');
		
		// share text
		delete_option('ssbp_share_text');
		delete_option('ssbp_widget_text');
		delete_option('ssbp_text_placement');
		delete_option('ssbp_font_family');
		delete_option('ssbp_font_color');	
		delete_option('ssbp_font_size');
		delete_option('ssbp_font_weight');
		
		// include
		delete_option('ssbp_selected_buttons');
		
		// custom colours
		delete_option('ssbp_color_main');
		delete_option('ssbp_color_border');
		delete_option('ssbp_color_hover');
		
		// custom images
		delete_option('ssbp_custom_images');
		delete_option('ssbp_image_width');
		delete_option('ssbp_image_height');
		delete_option('ssbp_image_padding');
		delete_option('ssbp_custom_buffer');
		delete_option('ssbp_custom_diggit');
		delete_option('ssbp_custom_email');
		delete_option('ssbp_custom_google');
		delete_option('ssbp_custom_facebook');
		delete_option('ssbp_custom_flattr');
		delete_option('ssbp_custom_linkedin');
		delete_option('ssbp_custom_pinterest');
		delete_option('ssbp_custom_print');
		delete_option('ssbp_custom_reddit');
		delete_option('ssbp_custom_stumbleupon');
		delete_option('ssbp_custom_tumblr');
		delete_option('ssbp_custom_twitter');
		delete_option('ssbp_custom_vk');
		
		// remove table
		ssbp_remove_table();
	}
	
	// remove ssbp tracking table
	function ssbp_remove_table() {
		
		// wpdb global
		global $wpdb;
		
		// use prefix to ssbp table name
		$table_name = $wpdb->prefix . 'ssbp_tracking';
		
		// prepare sql
		$sql = "DROP TABLE $table_name;";
		
		// delete table
		$wpdb->query($wpdb->prepare($sql));
	}