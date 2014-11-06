<?php
defined('ABSPATH') or die("No direct access permitted");

	// main settings 
	function ssbp_settings() {
	
		// check if user has the rights to manage options
		if ( !current_user_can( 'manage_options' ) )  {
		
			// permissions message
			wp_die( __('You do not have sufficient permissions to access this page.'));
		}
		
		// variables
		$htmlSettingsSaved = '';
		
		// check for submitted form
		if (isset($_POST['ssbp_options'])) {

			// ssba
			update_option('ssbp_use_ssba', 			(isset($_POST['ssbp_use_ssba']) ? $_POST['ssbp_use_ssba'] : NULL));

			// how
			update_option('ssbp_lazy_load', 			(isset($_POST['ssbp_lazy_load']) ? $_POST['ssbp_lazy_load'] : NULL));

			// where
			update_option('ssbp_pages', 				(isset($_POST['ssbp_pages']) ? $_POST['ssbp_pages'] : NULL));
			update_option('ssbp_posts', 				(isset($_POST['ssbp_posts']) ? $_POST['ssbp_posts'] : NULL));
			update_option('ssbp_cats_archs', 			(isset($_POST['ssbp_cats_archs']) ? $_POST['ssbp_cats_archs'] : NULL));
			update_option('ssbp_homepage', 				(isset($_POST['ssbp_homepage']) ? $_POST['ssbp_homepage'] : NULL));	
			update_option('ssbp_excerpts', 				(isset($_POST['ssbp_excerpts']) ? $_POST['ssbp_excerpts'] : NULL));	
			update_option('ssbp_before_or_after', 		(isset($_POST['ssbp_before_or_after']) ? $_POST['ssbp_before_or_after'] : NULL));

			// what
			update_option('ssbp_share_text', 			(isset($_POST['ssbp_share_text']) ? stripslashes_deep($_POST['ssbp_share_text']) : NULL));
			update_option('ssbp_selected_buttons', 		(isset($_POST['ssbp_selected_buttons']) ? $_POST['ssbp_selected_buttons'] : NULL));

			// show settings saved message
			$htmlSettingsSaved = '<div class="ssbp-share-count ssbp-updated"><p><strong>Your settings have been saved</strong></p></div>';
		}

		// query the db for current ssbp settings
		$arrSettings = get_ssbp_settings();

		// --------- ADMIN PANEL ------------ //
		ssbp_admin_panel($arrSettings, $htmlSettingsSaved);
	}
	
	// styling settings 
	function ssbp_styling() {
	
		// check if user has the rights to manage options
		if ( !current_user_can( 'manage_options' ) )  {
		
			// permissions message
			wp_die( __('You do not have sufficient permissions to access this page.'));
		}
		
		// variables
		$htmlSettingsSaved = '';
		
		// check for submitted form
		if (isset($_POST['ssbp_options'])) {

			// button styling
			update_option('ssbp_default_style', 		(isset($_POST['ssbp_default_style']) ? $_POST['ssbp_default_style'] : NULL));
			update_option('ssbp_additional_css', 		(isset($_POST['ssbp_additional_css']) ? $_POST['ssbp_additional_css'] : NULL));
			update_option('ssbp_icon_color', 			(isset($_POST['ssbp_icon_color']) ? $_POST['ssbp_icon_color'] : NULL));
			update_option('ssbp_size', 					(isset($_POST['ssbp_size']) ? $_POST['ssbp_size'] : NULL));
			update_option('ssbp_custom_styles', 		(isset($_POST['ssbp_custom_styles']) ? $_POST['ssbp_custom_styles'] : NULL));
			update_option('ssbp_button_borders', 		(isset($_POST['ssbp_button_borders']) ? $_POST['ssbp_button_borders'] : NULL));
			update_option('ssbp_button_margin', 		(isset($_POST['ssbp_button_margin']) ? $_POST['ssbp_button_margin'] : NULL));
			update_option('ssbp_button_shape', 			(isset($_POST['ssbp_button_shape']) ? $_POST['ssbp_button_shape'] : NULL));
			update_option('ssbp_alignment', 			(isset($_POST['ssbp_alignment']) ? $_POST['ssbp_alignment'] : NULL));
			update_option('ssbp_show_btn_txt',			(isset($_POST['ssbp_show_btn_txt']) ? $_POST['ssbp_show_btn_txt'] : NULL));
			update_option('ssbp_text_placement',		(isset($_POST['ssbp_text_placement']) ? $_POST['ssbp_text_placement'] : NULL));
			update_option('ssbp_font_family', 			$_POST['ssbp_font_family']);	
			update_option('ssbp_font_color', 			$_POST['ssbp_font_color']);	
			update_option('ssbp_font_size', 			$_POST['ssbp_font_size']);
			update_option('ssbp_font_weight', 			$_POST['ssbp_font_weight']);

			// custom colours
			update_option('ssbp_color_main', 			(isset($_POST['ssbp_color_main']) ? $_POST['ssbp_color_main'] : NULL));
			update_option('ssbp_color_border', 			(isset($_POST['ssbp_color_border']) ? $_POST['ssbp_color_border'] : NULL));
			update_option('ssbp_color_hover',			(isset($_POST['ssbp_color_hover']) ? $_POST['ssbp_color_hover'] : NULL));
			
			// custom images
			update_option('ssbp_custom_images',			(isset($_POST['ssbp_custom_images']) ? $_POST['ssbp_custom_images'] : NULL));
			update_option('ssbp_image_width',			(isset($_POST['ssbp_image_width']) ? $_POST['ssbp_image_width'] : NULL));
			update_option('ssbp_image_height',			(isset($_POST['ssbp_image_height']) ? $_POST['ssbp_image_height'] : NULL));
			update_option('ssbp_image_padding',			(isset($_POST['ssbp_image_padding']) ? $_POST['ssbp_image_padding'] : NULL));
			update_option('ssbp_custom_buffer',			(isset($_POST['ssbp_custom_buffer']) ? $_POST['ssbp_custom_buffer'] : NULL));
			update_option('ssbp_custom_diggit',			(isset($_POST['ssbp_custom_diggit']) ? $_POST['ssbp_custom_diggit'] : NULL));
			update_option('ssbp_custom_email',			(isset($_POST['ssbp_custom_email']) ? $_POST['ssbp_custom_email'] : NULL));
			update_option('ssbp_custom_google',			(isset($_POST['ssbp_custom_google']) ? $_POST['ssbp_custom_google'] : NULL));
			update_option('ssbp_custom_facebook',		(isset($_POST['ssbp_custom_facebook']) ? $_POST['ssbp_custom_facebook'] : NULL));
			update_option('ssbp_custom_flattr',			(isset($_POST['ssbp_custom_flattr']) ? $_POST['ssbp_custom_flattr'] : NULL));
			update_option('ssbp_custom_linkedin',		(isset($_POST['ssbp_custom_linkedin']) ? $_POST['ssbp_custom_linkedin'] : NULL));
			update_option('ssbp_custom_pinterest',		(isset($_POST['ssbp_custom_pinterest']) ? $_POST['ssbp_custom_pinterest'] : NULL));
			update_option('ssbp_custom_print',			(isset($_POST['ssbp_custom_print']) ? $_POST['ssbp_custom_print'] : NULL));
			update_option('ssbp_custom_reddit',			(isset($_POST['ssbp_custom_reddit']) ? $_POST['ssbp_custom_reddit'] : NULL));
			update_option('ssbp_custom_stumbleupon',	(isset($_POST['ssbp_custom_stumbleupon']) ? $_POST['ssbp_custom_stumbleupon'] : NULL));
			update_option('ssbp_custom_tumblr',			(isset($_POST['ssbp_custom_tumblr']) ? $_POST['ssbp_custom_tumblr'] : NULL));
			update_option('ssbp_custom_twitter',		(isset($_POST['ssbp_custom_twitter']) ? $_POST['ssbp_custom_twitter'] : NULL));
			update_option('ssbp_custom_vk',				(isset($_POST['ssbp_custom_vk']) ? $_POST['ssbp_custom_vk'] : NULL));

			// show settings saved message
			$htmlSettingsSaved = '<div class="ssbp-share-count ssbp-updated"><p><strong>Your settings have been saved</strong></p></div>';
		}

		// query the db for current ssbp settings
		$arrSettings = get_ssbp_settings();

		// --------- STYLING PANEL ------------ //
		ssbp_admin_styling($arrSettings, $htmlSettingsSaved);
	}
	
	// counter settings 
	function ssbp_counters() {
	
		// check if user has the rights to manage options
		if ( !current_user_can( 'manage_options' ) )  {
		
			// permissions message
			wp_die( __('You do not have sufficient permissions to access this page.'));
		}
		
		// variables
		$htmlSettingsSaved = '';
		
		// check for submitted form
		if (isset($_POST['ssbp_options'])) {
		
			// toggle share buttons
			update_option('ssbp_counters_enabled', 	(isset($_POST['ssbp_counters_enabled']) ? $_POST['ssbp_counters_enabled'] : NULL));
			update_option('ssbp_counters_type', 	(isset($_POST['ssbp_counters_type']) ? $_POST['ssbp_counters_type'] : NULL));
			update_option('ssbp_min_shares', 		(isset($_POST['ssbp_min_shares']) ? $_POST['ssbp_min_shares'] : NULL));
			update_option('ssbp_count_timeout', 	(isset($_POST['ssbp_count_timeout']) ? $_POST['ssbp_count_timeout'] : NULL));
			update_option('ssbp_count_cache', 		(isset($_POST['ssbp_count_cache']) ? $_POST['ssbp_count_cache'] : NULL));
			update_option('ssbp_share_api', 		(isset($_POST['ssbp_share_api']) ? $_POST['ssbp_share_api'] : NULL));

			// show settings saved message
			$htmlSettingsSaved = '<div class="ssbp-share-count ssbp-updated"><p><strong>Your settings have been saved</strong></p></div>';
		}

		// query the db for current ssbp settings
		$arrSettings = get_ssbp_settings();

		// --------- COUNTERS PANEL ------------ //
		ssbp_admin_counters($arrSettings, $htmlSettingsSaved);
	}

	// meta settings 
	function ssbp_meta() {
	
		// check if user has the rights to manage options
		if ( !current_user_can( 'manage_options' ) )  {
		
			// permissions message
			wp_die( __('You do not have sufficient permissions to access this page.'));
		}
		
		// variables
		$htmlSettingsSaved = '';
		
		// check for submitted form
		if (isset($_POST['ssbp_options'])) {

			// update existing ssbp settings
			update_option('ssbp_meta_enabled', 		(isset($_POST['ssbp_meta_enabled']) ? $_POST['ssbp_meta_enabled'] : NULL));
			update_option('ssbp_meta_title', 		stripslashes_deep($_POST['ssbp_meta_title']));
			update_option('ssbp_meta_description', 	stripslashes_deep($_POST['ssbp_meta_description']));
			update_option('ssbp_meta_image', 		stripslashes_deep($_POST['ssbp_meta_image']));

			// show settings saved message
			$htmlSettingsSaved = '<div class="ssbp-share-count ssbp-updated"><p><strong>Your settings have been saved</strong></p></div>';
		}

		// query the db for current ssbp settings
		$arrSettings = get_ssbp_settings();

		// --------- META PANEL ------------ //
		ssbp_admin_meta($arrSettings, $htmlSettingsSaved);
	}
	
	// advanced settings 
	function ssbp_advanced() {
	
		// check if user has the rights to manage options
		if ( !current_user_can( 'manage_options' ) )  {
		
			// permissions message
			wp_die( __('You do not have sufficient permissions to access this page.'));
		}
		
		// variables
		$htmlSettingsSaved = '';
		
		// check for submitted form
		if (isset($_POST['ssbp_options'])) {

			// update existing ssbp settings
			update_option('ssbp_bitly_login', 			stripslashes_deep($_POST['ssbp_bitly_login']));
			update_option('ssbp_bitly_api_key', 		stripslashes_deep($_POST['ssbp_bitly_api_key']));
			update_option('ssbp_rel_nofollow', 			(isset($_POST['ssbp_rel_nofollow']) ? stripslashes_deep($_POST['ssbp_rel_nofollow']) : NULL));
			
			update_option('ssbp_widget_text', 			stripslashes_deep($_POST['ssbp_widget_text']));
			update_option('ssbp_email_message', 		stripslashes_deep($_POST['ssbp_email_message']));
			update_option('ssbp_twitter_username', 		stripslashes_deep(str_replace('@', '', $_POST['ssbp_twitter_username'])));
			update_option('ssbp_twitter_text', 			stripslashes_deep($_POST['ssbp_twitter_text']));
			update_option('ssbp_twitter_tags', 			stripslashes_deep($_POST['ssbp_twitter_tags']));
			update_option('ssbp_buffer_text', 			stripslashes_deep($_POST['ssbp_buffer_text']));
			update_option('ssbp_flattr_user_id', 		stripslashes_deep($_POST['ssbp_flattr_user_id']));
			update_option('ssbp_flattr_url', 			stripslashes_deep($_POST['ssbp_flattr_url']));

			// show settings saved message
			$htmlSettingsSaved = '<div class="ssbp-share-count ssbp-updated"><p><strong>Your settings have been saved</strong></p></div>';
		}

		// query the db for current ssbp settings
		$arrSettings = get_ssbp_settings();

		// --------- ADVANCED PANEL ------------ //
		ssbp_admin_advanced($arrSettings, $htmlSettingsSaved);
	}

	// custom post type settings 
	function ssbp_post_types() {
	
		// check if user has the rights to manage options
		if ( !current_user_can( 'manage_options' ) )  {
		
			// permissions message
			wp_die( __('You do not have sufficient permissions to access this page.'));
		}
		
		// variables
		$htmlSettingsSaved = '';
		
		// check for submitted form
		if (isset($_POST['ssbp_options'])) {

			// update existing ssbp settings
			update_option('ssbp_disabled_types', (isset($_POST['ssbp_disabled_types']) ? implode(',', $_POST['ssbp_disabled_types']) : NULL));

			// show settings saved message
			$htmlSettingsSaved = '<div class="ssbp-share-count ssbp-updated"><p><strong>Your settings have been saved</strong></p></div>';
		}

		// query the db for current ssbp settings
		$arrSettings = get_ssbp_settings();

		// --------- CUSTOM POST TYPES PANEL ------------ //
		ssbp_admin_post_types($arrSettings, $htmlSettingsSaved);
	}
	
	// ortsh dashboard 
	function ssbp_ortsh() {
	
		// check if user has the rights to manage options
		if ( !current_user_can( 'manage_options' ) )  {
		
			// permissions message
			wp_die( __('You do not have sufficient permissions to access this page.'));
		}
		
		// variables
		$htmlSettingsSaved = '';
		
		// check for submitted form
		if (isset($_POST['ssbp_options'])) {

			// update existing ssbp settings
			update_option('ssbp_ortsh_enabled', stripslashes_deep($_POST['ssbp_ortsh_enabled']));

			// show settings saved message
			$htmlSettingsSaved = '<div class="ssbp-share-count ssbp-updated"><p><strong>Your settings have been saved</strong></p></div>';
		}

		// query the db for current ssbp settings
		$arrSettings = get_ssbp_settings();

		// --------- ORTSH DASHBOARD ------------ //
		ssbp_ortsh_dashboard($arrSettings, $htmlSettingsSaved);
	}