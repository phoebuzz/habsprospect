<?php
defined('ABSPATH') or die("No direct access permitted");

function ssbp_admin_dashboard($arrSettings) {

	// variables
	$htmlShareButtonsDash = '';

	// header
	$htmlShareButtonsDash .= '<div class="wrap">';
		$htmlShareButtonsDash .= '<div id="ssbp-header">';
		
			//logo
			$htmlShareButtonsDash .= '<div id="ssbp-logo">';
				$htmlShareButtonsDash .= '<a href="http://www.simplesharebuttons.com" target="_blank"><img src="' . plugins_url() . '/simple-share-buttons-plus/images/simplesharebuttons.png' . '" class="ssbp-logo-img" /></a>';
			$htmlShareButtonsDash .= '</div>';
			
		// close header
		$htmlShareButtonsDash .= '</div>';
		
		// open welcome panel
		$htmlShareButtonsDash .= '<div class="welcome-panel ssbp-section">';
		$htmlShareButtonsDash .= '<div class="welcome-panel-content">';
		
			// video setup div
			$htmlShareButtonsDash .= '<div id="ssbp-setup">';
				$htmlShareButtonsDash .= '<h2 class="ssbp-setup">'.SSBP_LANG_SIMPLE_SETUP.'</h2>';
				$htmlShareButtonsDash .= '<div class="video-container">';
			    	$htmlShareButtonsDash .= '<iframe width="560" height="315" src="//www.youtube.com/embed/fXUJoSSKlIE?rel=0&vq=hd720" frameborder="0" allowfullscreen></iframe>';
				$htmlShareButtonsDash .= '</div>';
				$htmlShareButtonsDash .= '<p class="description">'.SSBP_LANG_WATCH_VIDEO.'</p>';
			$htmlShareButtonsDash .= '</div>';
			
			// support div
			$htmlShareButtonsDash .= '<div id="ssbp-support">';
				$htmlShareButtonsDash .= '<h2 class="ssbp-support">'.SSBP_LANG_SUPPORT.'</h2>';
				$htmlShareButtonsDash .= '<p>'.SSBP_LANG_SUPPORT_DESC1.'</p>';
				$htmlShareButtonsDash .= '<p>'.SSBP_LANG_SUPPORT_DESC2.'</p>';
				$htmlShareButtonsDash .= '<p><span class="button button-primary support-details-btn" style="margin-right:20px;">'.SSBP_LANG_SELECT_SUPPORT.'</span>';
				$htmlShareButtonsDash .= '<a href="https://simplesharebuttons.com/forums/forum/simple-share-buttons-plus" target="_blank"><span class="button button-primary">'.SSBP_LANG_VISIT_SUPPORT.'</span></a></p>';
				
				// hidden support details
				$htmlShareButtonsDash .= '<div id="ssbp-support-details">';
					$htmlShareButtonsDash .= ssbp_support_details($arrSettings);
				$htmlShareButtonsDash .= '</div>';
			$htmlShareButtonsDash .= '</div>';
		
		// close welcome panel
		$htmlShareButtonsDash .= '</div>';
		$htmlShareButtonsDash .= '</div>';
		
	//close wrap
	$htmlShareButtonsDash .= '</div>';
	
	echo $htmlShareButtonsDash;
}

function ssbp_support_details($arrSettings) {
	
	// variables
	$htmlSupportDetails = '';
	
	// open textarea
	$htmlSupportDetails = '<textarea id="ssbp-support-textarea" rows="5">';
				
		// get wordpress version
		$wp_version = get_bloginfo('version');
		$htmlSupportDetails .= 'WordPress Version: '.$wp_version . '|';
		
		// get theme details	
		$my_theme = wp_get_theme();
		$htmlSupportDetails .= 'Theme: '.$my_theme->get('Name') . "| Theme Version: " . $my_theme->get('Version') . '|';
	
		// output ssbp settings
		$htmlSupportDetails .= 'Before/After: '.$arrSettings['ssbp_before_or_after'].'|';
		$htmlSupportDetails .= 'Pages: '.$arrSettings['ssbp_pages'].'|';
		$htmlSupportDetails .= 'Posts: '.$arrSettings['ssbp_posts'].'|';
		$htmlSupportDetails .= 'Cats/Archs: '.$arrSettings['ssbp_cats_archs'].'|';
		$htmlSupportDetails .= 'Homepage: '.$arrSettings['ssbp_homepage'].'|';
		$htmlSupportDetails .= 'Excerpts: '.$arrSettings['ssbp_excerpts'].'|';
		
		// other plugins installed
		$all_plugins = get_plugins();
		
		// loop through and output
		foreach($all_plugins AS $arrPlugin) {
			
			// add to textarea
			$htmlSupportDetails .= $arrPlugin['Name'].': '.$arrPlugin['Version'].'|';
		}
	
	// close text area	
	$htmlSupportDetails .= '</textarea>';
	
	// echo details
	return $htmlSupportDetails;
}

function ssbp_admin_panel($arrSettings, $htmlSettingsSaved) {

	// variables
	$htmlShareButtonsForm = '';
	
	// header
	$htmlShareButtonsForm .= '<div class="wrap">';
		$htmlShareButtonsForm .= '<div id="ssbp-header">';
		
			//logo
			$htmlShareButtonsForm .= '<div id="ssbp-logo">';
				$htmlShareButtonsForm .= '<a href="http://www.simplesharebuttons.com" target="_blank"><img src="' . plugins_url() . '/simple-share-buttons-plus/images/simplesharebuttons.png' . '" class="ssbp-logo-img" /></a>';
			$htmlShareButtonsForm .= '</div>';
			
		// close header
		$htmlShareButtonsForm .= '</div>';
		
		// html form
		$htmlShareButtonsForm .= '<div class="welcome-panel ssbp-section">';
		$htmlShareButtonsForm .= '<div class="welcome-panel-content">';
		
			// show settings saved message if set
			(isset($htmlSettingsSaved) ? $htmlShareButtonsForm .= $htmlSettingsSaved : NULL);
			
			// start form
			$htmlShareButtonsForm .= '<form method="post">';
			$htmlShareButtonsForm .= '<input type="hidden" name="ssbp_options" />';
			
				//------ BASIC TAB -------//
				$htmlShareButtonsForm .= '<div id="ssbp_settings_basic">';
					$htmlShareButtonsForm .= '<h2 class="ssbp-heading-setup">'.SSBP_LANG_BUTTONS_SETUP.'</h2>';
					$htmlShareButtonsForm .= '<table class="form-table">';
						$htmlShareButtonsForm .= '<tr valign="top">';
							$htmlShareButtonsForm .= '<th scope="row" style="width: 150px;"><label for="ssbp_use_ssba">'.SSBP_LANG_USE_SSBA.':</label></th>';
							$htmlShareButtonsForm .= '<td>';
							$htmlShareButtonsForm .= SSBP_LANG_YES.'&nbsp;<input type="checkbox" name="ssbp_use_ssba" id="ssbp_use_ssba" ' . ($arrSettings['ssbp_use_ssba'] == 'Y'  ? 'checked' : NULL) . ' value="Y" style="margin-right: 10px;" />';
							$htmlShareButtonsForm .= '<p class="description">'.SSBP_LANG_USE_SSBA_DESC.'</p></td>';
						$htmlShareButtonsForm .= '</tr>';
						$htmlShareButtonsForm .= '<tr valign="top">';
							$htmlShareButtonsForm .= '<th scope="row" style="width: 150px;"><label>'.SSBP_LANG_LOCATION.':</label></th>';
							$htmlShareButtonsForm .= '<td style="font-size: 12px;">';
							$htmlShareButtonsForm .= SSBP_LANG_HOMEPAGE.'&nbsp;<input type="checkbox" name="ssbp_homepage" id="ssbp_homepage" ' 	 	. ($arrSettings['ssbp_homepage'] 	== 'Y'   ? 'checked' : NULL) . ' value="Y" style="margin-right: 10px;" />';
							$htmlShareButtonsForm .= SSBP_LANG_PAGES.'&nbsp;<input type="checkbox" name="ssbp_pages" id="ssbp_pages" ' 		 		. ($arrSettings['ssbp_pages'] 		== 'Y'   ? 'checked' : NULL) . ' value="Y" style="margin-right: 10px;" />';
							$htmlShareButtonsForm .= SSBP_LANG_POSTS.'&nbsp;<input type="checkbox" name="ssbp_posts" id="ssbp_posts" ' 		 		. ($arrSettings['ssbp_posts'] 		== 'Y'   ? 'checked' : NULL) . ' value="Y" style="margin-right: 10px;" />';
							$htmlShareButtonsForm .= SSBP_LANG_CATEGORIES.'&nbsp;<input type="checkbox" name="ssbp_cats_archs" id="ssbp_cats_archs" '	. ($arrSettings['ssbp_cats_archs']	== 'Y'   ? 'checked' : NULL) . ' value="Y" style="margin-right: 10px;" />';
							$htmlShareButtonsForm .= SSBP_LANG_EXCERPTS.'&nbsp;<input type="checkbox" name="ssbp_excerpts" id="ssbp_excerpts" '	. ($arrSettings['ssbp_excerpts']	== 'Y'   ? 'checked' : NULL) . ' value="Y" style="margin-right: 10px;" />';
							$htmlShareButtonsForm .= '<p class="description">'.SSBP_LANG_LOCATION_DESC.'</p></td>';
						$htmlShareButtonsForm .= '</tr>';
						$htmlShareButtonsForm .= '<tr valign="top">';
							$htmlShareButtonsForm .= '<th scope="row" style="width: 150px;"><label for="ssbp_before_or_after">'.SSBP_LANG_PLACEMENT.':&nbsp;</label></th>';
							$htmlShareButtonsForm .= '<td><select name="ssbp_before_or_after" id="ssbp_before_or_after">';
							$htmlShareButtonsForm .= '<option ' . ($arrSettings['ssbp_before_or_after'] == 'after' 	? 'selected="selected"' : NULL) . ' value="after">'.SSBP_LANG_AFTER.'</option>';
							$htmlShareButtonsForm .= '<option ' . ($arrSettings['ssbp_before_or_after'] == 'before' ? 'selected="selected"' : NULL) . ' value="before">'.SSBP_LANG_BEFORE.'</option>';
							$htmlShareButtonsForm .= '<option ' . ($arrSettings['ssbp_before_or_after'] == 'both' 	? 'selected="selected"' : NULL) . ' value="both">'.SSBP_LANG_BOTH.'</option>';
							$htmlShareButtonsForm .= '</select>';
							$htmlShareButtonsForm .= '<p class="description">'.SSBP_LANG_PLACEMENT_DESC.'</p></td>';
						$htmlShareButtonsForm .= '</tr>';
							$htmlShareButtonsForm .= '<tr valign="top">';
							$htmlShareButtonsForm .= '<th scope="row" style="width: 150px;"><label for="ssbp_share_text">'.SSBP_LANG_SHARE_TEXT.':&nbsp;</label></th>';
							$htmlShareButtonsForm .= '<td><input type="text" name="ssbp_share_text" id="ssbp_share_text" value="' . $arrSettings['ssbp_share_text'] . '" />';
							$htmlShareButtonsForm .= '<p class="description">'.SSBP_LANG_SHARE_TEXT_DESC.'</p></td>';
						$htmlShareButtonsForm .= '</tr>';
						$htmlShareButtonsForm .= '<tr valign="top">';
							$htmlShareButtonsForm .= '<th scope="row" style="width: 150px;"><label for="ssbp_lazy_load">'.SSBP_LANG_LAZY_LOADING.':</label></th>';
							$htmlShareButtonsForm .= '<td>';
							$htmlShareButtonsForm .= SSBP_LANG_YES.'&nbsp;<input type="checkbox" name="ssbp_lazy_load" id="ssbp_lazy_load" ' . ($arrSettings['ssbp_lazy_load'] == 'Y'  ? 'checked' : NULL) . ' value="Y" style="margin-right: 10px;" />';
							$htmlShareButtonsForm .= '<p class="description">'.SSBP_LANG_LAZY_LOADING_DESC.'</p></td>';
						$htmlShareButtonsForm .= '</tr>';
					$htmlShareButtonsForm .= '</table>';
					
									// --------- DRAG AND DROP AREA ------------ //
					$htmlShareButtonsForm .= '<div id="ssbp-drag-drop">';
					$htmlShareButtonsForm .= '<table class="form-table">';
						$htmlShareButtonsForm .= '<tr valign="top">';
							$htmlShareButtonsForm .= '<th scope="row" style="width: 160px !important;"><label for="ssbp_choices">'.SSBP_LANG_INCLUDE.':</label></th>';
							$htmlShareButtonsForm .= '<td class="ssbp-include-list available">';
								$htmlShareButtonsForm .= '<span class="include-heading">'.SSBP_LANG_AVAILABLE.'</span>';
								$htmlShareButtonsForm .= '<center><ul id="ssbpsort1" class="connectedSortable">';
								 $htmlShareButtonsForm .= getAvailableSSBP($arrSettings['ssbp_selected_buttons']);
								$htmlShareButtonsForm .= '</ul></center>';
							$htmlShareButtonsForm .= '</td>';
							$htmlShareButtonsForm .= '<td class="ssbp-include-list chosen">';
								$htmlShareButtonsForm .= '<span class="include-heading">'.SSBP_LANG_SELECTED.'</span>';
								$htmlShareButtonsForm .= '<center><ul id="ssbpsort2" class="connectedSortable">';
								$htmlShareButtonsForm .= getSelectedSSBP($arrSettings['ssbp_selected_buttons']);
								$htmlShareButtonsForm .= '</ul></center>';
							$htmlShareButtonsForm .= '</td>';
						$htmlShareButtonsForm .= '</tr>';
						$htmlShareButtonsForm .= '<tr valign="top">';
							$htmlShareButtonsForm .= '<th scope="row" style="width: 100px !important;"></th>';
							$htmlShareButtonsForm .= '<td colspan=2>';
								$htmlShareButtonsForm .= '<p class="description">'.SSBP_LANG_INCLUDE_DESC.'</p>';
							$htmlShareButtonsForm .= '</td>';
						$htmlShareButtonsForm .= '</tr>';
					$htmlShareButtonsForm .= '</table>';
					$htmlShareButtonsForm .= '</div>';
				$htmlShareButtonsForm .= '</div>';
				$htmlShareButtonsForm .= '<input type="hidden" name="ssbp_selected_buttons" id="ssbp_selected_buttons" />';
				
			// save button
			$htmlShareButtonsForm .= '<table class="form-table">';
					$htmlShareButtonsForm .= '<tr valign="top">';
						$htmlShareButtonsForm .= '<td><input type="submit" value="'.SSBP_LANG_SAVE_CHANGES.'" id="submit" class="button button-primary"/></td>';
					$htmlShareButtonsForm .= '</tr>';
				$htmlShareButtonsForm .= '</table>';
			$htmlShareButtonsForm .= '</form>';
			
		// close form cell and open author one
		$htmlShareButtonsForm .= '</td><td style="vertical-align: top;">';					
									
		// close welcome panel
		$htmlShareButtonsForm .= '</div>';
		$htmlShareButtonsForm .= '</div>';
		
	//close wrap
	$htmlShareButtonsForm .= '</div>';
	
	echo $htmlShareButtonsForm;
}

function ssbp_admin_styling($arrSettings, $htmlSettingsSaved) {

	// variables
	$htmlShareButtonsForm = '';

	// show settings saved message if set
	(isset($htmlSettingsSaved) ? $htmlShareButtonsForm .= $htmlSettingsSaved : NULL);
			
	// header
	$htmlShareButtonsForm .= '<div class="wrap">';
		$htmlShareButtonsForm .= '<div id="ssbp-header">';
		
			//logo
			$htmlShareButtonsForm .= '<div id="ssbp-logo">';
				$htmlShareButtonsForm .= '<a href="http://www.simplesharebuttons.com" target="_blank"><img src="' . plugins_url() . '/simple-share-buttons-plus/images/simplesharebuttons.png' . '" class="ssbp-logo-img" /></a>';
			$htmlShareButtonsForm .= '</div>';
			
		// close header
		$htmlShareButtonsForm .= '</div>';
		
		// html form
		$htmlShareButtonsForm .= '<div class="welcome-panel ssbp-section">';
		$htmlShareButtonsForm .= '<div class="welcome-panel-content">';
			
			// start form
			$htmlShareButtonsForm .= '<form method="post">';
			$htmlShareButtonsForm .= '<input type="hidden" name="ssbp_options" />';
				
			//------ STYLING TAB ------//
			
			//----- STYLING SETTINGS DIV ------//
			$htmlShareButtonsForm .= '<div id="ssbp_settings_styling">';
				$htmlShareButtonsForm .= '<h2 class="ssbp-heading-styling">'.SSBP_LANG_STYLE_SETTINGS.'</h2>';

				// div for default styles option
				$htmlShareButtonsForm .= '<div>';
					$htmlShareButtonsForm .= '<table class="form-table">';
							$htmlShareButtonsForm .= '<tr valign="top">';
								$htmlShareButtonsForm .= '<th scope="row" style="width: 150px;"><label for="ssbp_default_style">'.SSBP_LANG_DEFAULT_STYLE.':&nbsp;</label></th>';
								$htmlShareButtonsForm .= '<td><select name="ssbp_default_style" id="ssbp_default_style">';
								$htmlShareButtonsForm .= '<option ' . ($arrSettings['ssbp_default_style'] == ''   ? 'selected="selected"' : NULL) . ' value="">None</option>';
								$htmlShareButtonsForm .= '<option ' . ($arrSettings['ssbp_default_style'] == '1' ? 'selected="selected"' : NULL) . ' value="1">'.SSBP_LANG_DEFAULT_STYLE_1.'</option>';
								$htmlShareButtonsForm .= '<option ' . ($arrSettings['ssbp_default_style'] == '2' ? 'selected="selected"' : NULL) . ' value="2">'.SSBP_LANG_DEFAULT_STYLE_2.'</option>';
								$htmlShareButtonsForm .= '<option ' . ($arrSettings['ssbp_default_style'] == '3' ? 'selected="selected"' : NULL) . ' value="3">'.SSBP_LANG_DEFAULT_STYLE_3.'</option>';
								$htmlShareButtonsForm .= '<option ' . ($arrSettings['ssbp_default_style'] == '4' ? 'selected="selected"' : NULL) . ' value="4">'.SSBP_LANG_DEFAULT_STYLE_4.'</option>';
								$htmlShareButtonsForm .= '<option ' . ($arrSettings['ssbp_default_style'] == '5' ? 'selected="selected"' : NULL) . ' value="5">'.SSBP_LANG_DEFAULT_STYLE_5.'</option>';
								$htmlShareButtonsForm .= '<option ' . ($arrSettings['ssbp_default_style'] == '6' ? 'selected="selected"' : NULL) . ' value="6">'.SSBP_LANG_DEFAULT_STYLE_6.'</option>';
								$htmlShareButtonsForm .= '<option ' . ($arrSettings['ssbp_default_style'] == '7' ? 'selected="selected"' : NULL) . ' value="7">'.SSBP_LANG_DEFAULT_STYLE_7.'</option>';
								$htmlShareButtonsForm .= '<option ' . ($arrSettings['ssbp_default_style'] == '8' ? 'selected="selected"' : NULL) . ' value="8">'.SSBP_LANG_DEFAULT_STYLE_8.'</option>';
								$htmlShareButtonsForm .= '<option ' . ($arrSettings['ssbp_default_style'] == '9' ? 'selected="selected"' : NULL) . ' value="9">'.SSBP_LANG_DEFAULT_STYLE_9.'</option>';
								$htmlShareButtonsForm .= '<option ' . ($arrSettings['ssbp_default_style'] == '10' ? 'selected="selected"' : NULL) . ' value="10">10. Static, flat, white, share bar</option>';
								$htmlShareButtonsForm .= '<option ' . ($arrSettings['ssbp_default_style'] == '11' ? 'selected="selected"' : NULL) . ' value="11">11. Responsive, flat, white share bar - 4 OR 8 BUTTONS ONLY</option>';
								$htmlShareButtonsForm .= '</select>';
								$htmlShareButtonsForm .= '<p class="description">'.SSBP_LANG_DEFAULT_STYLE_DESC.'</p></td>';
							$htmlShareButtonsForm .= '</tr>';
							
						$htmlShareButtonsForm .= '</table>';
					$htmlShareButtonsForm .= '</div>';
					
				$htmlShareButtonsForm .= '<div class="ssbp_default_styles" '.($arrSettings['ssbp_default_style'] == '' ? 'style="display: none;"' : NULL).'>';
					$htmlShareButtonsForm .= '<table class="form-table">';
						$htmlShareButtonsForm .= '<tr valign="top">';
							$htmlShareButtonsForm .= '<th scope="row" style="width: 150px;"></th>';
							$htmlShareButtonsForm .= '<td>';
								$htmlShareButtonsForm .= '<p class="ssbp-important"><b>If your WordPress installation is in a subdirectory</b> - In order to take advantage of the minified CSS files that SSBP Preset Styles utilise, you must ensure that you have made copies of the three sprite images and placed them in the following location: <b>http://yourdomain.com/wp-content/plugins/simple-share-buttons-plus/images/</b></p>';
							$htmlShareButtonsForm .= '</td>';
						$htmlShareButtonsForm .= '</tr>';
						$htmlShareButtonsForm .= '<tr valign="top">';
							$htmlShareButtonsForm .= '<th scope="row" style="width: 150px;"><label for="ssbp_additional_css">'.SSBP_LANG_ADDITIONAL_CSS.':&nbsp;</label></th>';
							$htmlShareButtonsForm .= '<td>';
							$htmlShareButtonsForm .= '<textarea name="ssbp_additional_css" id="ssbp_additional_css" rows="20" cols="50">' . $arrSettings['ssbp_additional_css'] . '</textarea>';
							$htmlShareButtonsForm .= '<p class="description">'.SSBP_LANG_ADDITIONAL_CSS_DESC.'</p>';
							$htmlShareButtonsForm .= '</td></tr>';
					$htmlShareButtonsForm .= '</table>';
				$htmlShareButtonsForm .= '</div>';

				// wrapper for anything outside of the default settings area
				$htmlShareButtonsForm .= '<div id="ssbp_non_default" '.($arrSettings['ssbp_default_style'] != '' ? 'style="display: none;"' : NULL).'>';
			
					// toggle setting options
					$htmlShareButtonsForm .= '<div id="ssbp_toggle_styling" style="margin: 10px 0 20px;">';
					$htmlShareButtonsForm .= SSBP_LANG_CSS_TOGGLE.'</a>.';
					$htmlShareButtonsForm .= '</div>';
				
					// normal settings options
					$htmlShareButtonsForm .= '<div id="ssbp_normal_settings" '.($arrSettings['ssbp_custom_styles'] != '' ? 'style="display: none;"' : NULL).'>';
						$htmlShareButtonsForm .= '<table class="form-table">';
							$htmlShareButtonsForm .= '<tr valign="top">';
								$htmlShareButtonsForm .= '<th scope="row" style="width: 150px;"><label for="ssbp_custom_images">'.SSBP_LANG_CUSTOM_IMAGES.'</label></th>';
								$htmlShareButtonsForm .= '<td>';
								$htmlShareButtonsForm .= SSBP_LANG_YES.'&nbsp;<input type="checkbox" name="ssbp_custom_images" id="ssbp_custom_images" ' . ($arrSettings['ssbp_custom_images'] == 'Y'  ? 'checked' : NULL) . ' value="Y" style="margin-right: 10px;" />';
								$htmlShareButtonsForm .= '<p class="description">'.SSBP_LANG_CUSTOM_IMAGES_DESC.'</p></td>';
							$htmlShareButtonsForm .= '</tr>';
							$htmlShareButtonsForm .= '<tr valign="top" class="ssbp_custom_image" '.($arrSettings['ssbp_custom_images'] != 'Y' ? 'style="display: none;"' : NULL).'>';
								$htmlShareButtonsForm .= '<th scope="row" style="width: 150px;"><label for="ssbp_image_width">'.SSBP_LANG_IMAGE_WIDTH.':&nbsp;</label></th>';
								$htmlShareButtonsForm .= '<td><input type="number" style="width: 80px;" name="ssbp_image_width" id="ssbp_image_width" value="' . $arrSettings['ssbp_image_width'] . '"><span class="description">px</span>';
								$htmlShareButtonsForm .= '</input>';
								$htmlShareButtonsForm .= '<p class="description">'.SSBP_LANG_IMAGE_WIDTH_DESC.'</p></td>';
							$htmlShareButtonsForm .= '</tr>';
							$htmlShareButtonsForm .= '<tr valign="top" class="ssbp_custom_image" '.($arrSettings['ssbp_custom_images'] != 'Y' ? 'style="display: none;"' : NULL).'>';
								$htmlShareButtonsForm .= '<th scope="row" style="width: 150px;"><label for="ssbp_image_height">'.SSBP_LANG_IMAGE_HEIGHT.':&nbsp;</label></th>';
								$htmlShareButtonsForm .= '<td><input type="number" style="width: 80px;" name="ssbp_image_height" id="ssbp_image_height" value="' . $arrSettings['ssbp_image_height'] . '"><span class="description">px</span>';
								$htmlShareButtonsForm .= '</input>';
								$htmlShareButtonsForm .= '<p class="description">'.SSBP_LANG_IMAGE_HEIGHT_DESC.'</p></td>';
							$htmlShareButtonsForm .= '</tr>';
							$htmlShareButtonsForm .= '<tr valign="top" class="ssbp_custom_image" '.($arrSettings['ssbp_custom_images'] != 'Y' ? 'style="display: none;"' : NULL).'>';
								$htmlShareButtonsForm .= '<th scope="row" style="width: 150px;"><label for="ssbp_image_padding">'.SSBP_LANG_IMAGE_PADDING.':&nbsp;</label></th>';
								$htmlShareButtonsForm .= '<td><input type="number" style="width: 80px;" name="ssbp_image_padding" id="ssbp_image_padding" value="' . $arrSettings['ssbp_image_padding'] . '"><span class="description">px</span>';
								$htmlShareButtonsForm .= '</input>';
								$htmlShareButtonsForm .= '<p class="description">'.SSBP_LANG_IMAGE_PADDING_DESC.'</p></td>';
							$htmlShareButtonsForm .= '</tr>';
							
							//----- CUSTOM IMAGES -------//
							$htmlShareButtonsForm .= '<tr class="ssbp_custom_image" valign="top" '.($arrSettings['ssbp_custom_images'] != 'Y' ? 'style="display: none;"' : NULL).'>';
							$htmlShareButtonsForm .= '<th scope="row" style="width: 120px;"><label>Buffer:</label></th>';
							$htmlShareButtonsForm .= '<td>';
							$htmlShareButtonsForm .= '<input id="ssbp_custom_buffer" type="text" size="50" name="ssbp_custom_buffer" value="' . (isset($arrSettings['ssbp_custom_buffer']) ? $arrSettings['ssbp_custom_buffer'] : NULL)  . '" />';
							$htmlShareButtonsForm .= '<input id="upload_buffer_button" data-ssbp-input="ssbp_custom_buffer" class="button customUpload" type="button" value="'.SSBP_LANG_UPLOAD_IMAGE.'" />';
							$htmlShareButtonsForm .= '</td>';
						$htmlShareButtonsForm .= '</tr>';
						$htmlShareButtonsForm .= '<tr class="ssbp_custom_image" valign="top" '.($arrSettings['ssbp_custom_images'] != 'Y' ? 'style="display: none;"' : NULL).'>';
							$htmlShareButtonsForm .= '<th scope="row" style="width: 120px;"><label>Diggit:</label></th>';
							$htmlShareButtonsForm .= '<td>';
							$htmlShareButtonsForm .= '<input id="ssbp_custom_diggit" type="text" size="50" name="ssbp_custom_diggit" value="' . (isset($arrSettings['ssbp_custom_diggit']) ? $arrSettings['ssbp_custom_diggit'] : NULL)  . '" />';
							$htmlShareButtonsForm .= '<input id="upload_diggit_button" data-ssbp-input="ssbp_custom_diggit" class="button customUpload" type="button" value="'.SSBP_LANG_UPLOAD_IMAGE.'" />';
							$htmlShareButtonsForm .= '</td>';
						$htmlShareButtonsForm .= '</tr>';
						$htmlShareButtonsForm .= '<tr class="ssbp_custom_image" valign="top" '.($arrSettings['ssbp_custom_images'] != 'Y' ? 'style="display: none;"' : NULL).'>';
							$htmlShareButtonsForm .= '<th scope="row" style="width: 120px;"><label>Email:</label></th>';
							$htmlShareButtonsForm .= '<td>';
							$htmlShareButtonsForm .= '<input id="ssbp_custom_email" type="text" size="50" name="ssbp_custom_email" value="' . (isset($arrSettings['ssbp_custom_email']) ? $arrSettings['ssbp_custom_email'] : NULL)  . '" />';
							$htmlShareButtonsForm .= '<input id="upload_email_button" data-ssbp-input="ssbp_custom_email" class="button customUpload" type="button" value="'.SSBP_LANG_UPLOAD_IMAGE.'" />';
							$htmlShareButtonsForm .= '</td>';
						$htmlShareButtonsForm .= '</tr>';
						$htmlShareButtonsForm .= '<tr class="ssbp_custom_image" valign="top" '.($arrSettings['ssbp_custom_images'] != 'Y' ? 'style="display: none;"' : NULL).'>';
							$htmlShareButtonsForm .= '<th scope="row" style="width: 120px;"><label>Facebook:</label></th>';
							$htmlShareButtonsForm .= '<td>';
							$htmlShareButtonsForm .= '<input id="ssbp_custom_facebook" type="text" size="50" name="ssbp_custom_facebook" value="' . (isset($arrSettings['ssbp_custom_facebook']) ? $arrSettings['ssbp_custom_facebook'] : NULL)  . '" />';
							$htmlShareButtonsForm .= '<input id="upload_facebook_button" data-ssbp-input="ssbp_custom_facebook" class="button customUpload" type="button" value="'.SSBP_LANG_UPLOAD_IMAGE.'" />';
							$htmlShareButtonsForm .= '</td>';
						$htmlShareButtonsForm .= '</tr>';
						$htmlShareButtonsForm .= '<tr class="ssbp_custom_image" valign="top" '.($arrSettings['ssbp_custom_images'] != 'Y' ? 'style="display: none;"' : NULL).'>';
							$htmlShareButtonsForm .= '<th scope="row" style="width: 120px;"><label>Flattr:</label></th>';
							$htmlShareButtonsForm .= '<td>';
							$htmlShareButtonsForm .= '<input id="ssbp_custom_flattr" type="text" size="50" name="ssbp_custom_flattr" value="' . (isset($arrSettings['ssbp_custom_flattr']) ? $arrSettings['ssbp_custom_flattr'] : NULL)  . '" />';
							$htmlShareButtonsForm .= '<input id="upload_flattr_button" data-ssbp-input="ssbp_custom_flattr" class="button customUpload" type="button" value="'.SSBP_LANG_UPLOAD_IMAGE.'" />';
							$htmlShareButtonsForm .= '</td>';
						$htmlShareButtonsForm .= '</tr>';
						$htmlShareButtonsForm .= '<tr class="ssbp_custom_image" valign="top" '.($arrSettings['ssbp_custom_images'] != 'Y' ? 'style="display: none;"' : NULL).'>';
							$htmlShareButtonsForm .= '<th scope="row" style="width: 120px;"><label>Google:</label></th>';
							$htmlShareButtonsForm .= '<td>';
							$htmlShareButtonsForm .= '<input id="ssbp_custom_google" type="text" size="50" name="ssbp_custom_google" value="' . (isset($arrSettings['ssbp_custom_google']) ? $arrSettings['ssbp_custom_google'] : NULL)  . '" />';
							$htmlShareButtonsForm .= '<input id="upload_google_button" data-ssbp-input="ssbp_custom_google" class="button customUpload" type="button" value="'.SSBP_LANG_UPLOAD_IMAGE.'" />';
							$htmlShareButtonsForm .= '</td>';
						$htmlShareButtonsForm .= '</tr>';
						$htmlShareButtonsForm .= '<tr class="ssbp_custom_image" valign="top" '.($arrSettings['ssbp_custom_images'] != 'Y' ? 'style="display: none;"' : NULL).'>';
							$htmlShareButtonsForm .= '<th scope="row" style="width: 120px;"><label>LinkedIn:</label></th>';
							$htmlShareButtonsForm .= '<td>';
							$htmlShareButtonsForm .= '<input id="ssbp_custom_linkedin" type="text" size="50" name="ssbp_custom_linkedin" value="' . (isset($arrSettings['ssbp_custom_linkedin']) ? $arrSettings['ssbp_custom_linkedin'] : NULL)  . '" />';
							$htmlShareButtonsForm .= '<input id="upload_linkedin_button" data-ssbp-input="ssbp_custom_linkedin" class="button customUpload" type="button" value="'.SSBP_LANG_UPLOAD_IMAGE.'" />';
							$htmlShareButtonsForm .= '</td>';
						$htmlShareButtonsForm .= '</tr>';
						$htmlShareButtonsForm .= '<tr class="ssbp_custom_image" valign="top" '.($arrSettings['ssbp_custom_images'] != 'Y' ? 'style="display: none;"' : NULL).'>';
							$htmlShareButtonsForm .= '<th scope="row" style="width: 120px;"><label>Pinterest:</label></th>';
							$htmlShareButtonsForm .= '<td>';
							$htmlShareButtonsForm .= '<input id="ssbp_custom_pinterest" type="text" size="50" name="ssbp_custom_pinterest" value="' . (isset($arrSettings['ssbp_custom_pinterest']) ? $arrSettings['ssbp_custom_pinterest'] : NULL)  . '" />';
							$htmlShareButtonsForm .= '<input id="upload_pinterest_button" data-ssbp-input="ssbp_custom_pinterest" class="button customUpload" type="button" value="'.SSBP_LANG_UPLOAD_IMAGE.'" />';
							$htmlShareButtonsForm .= '</td>';
						$htmlShareButtonsForm .= '</tr>';
						$htmlShareButtonsForm .= '<tr class="ssbp_custom_image" valign="top" '.($arrSettings['ssbp_custom_images'] != 'Y' ? 'style="display: none;"' : NULL).'>';
							$htmlShareButtonsForm .= '<th scope="row" style="width: 120px;"><label>Print:</label></th>';
							$htmlShareButtonsForm .= '<td>';
							$htmlShareButtonsForm .= '<input id="ssbp_custom_print" type="text" size="50" name="ssbp_custom_print" value="' . (isset($arrSettings['ssbp_custom_print']) ? $arrSettings['ssbp_custom_print'] : NULL)  . '" />';
							$htmlShareButtonsForm .= '<input id="upload_print_button" data-ssbp-input="ssbp_custom_print" class="button customUpload" type="button" value="'.SSBP_LANG_UPLOAD_IMAGE.'" />';
							$htmlShareButtonsForm .= '</td>';
						$htmlShareButtonsForm .= '</tr>';
						$htmlShareButtonsForm .= '<tr class="ssbp_custom_image" valign="top" '.($arrSettings['ssbp_custom_images'] != 'Y' ? 'style="display: none;"' : NULL).'>';
							$htmlShareButtonsForm .= '<th scope="row" style="width: 120px;"><label>Reddit:</label></th>';
							$htmlShareButtonsForm .= '<td>';
							$htmlShareButtonsForm .= '<input id="ssbp_custom_reddit" type="text" size="50" name="ssbp_custom_reddit" value="' . (isset($arrSettings['ssbp_custom_reddit']) ? $arrSettings['ssbp_custom_reddit'] : NULL)  . '" />';
							$htmlShareButtonsForm .= '<input id="upload_reddit_button" data-ssbp-input="ssbp_custom_reddit" class="button customUpload" type="button" value="'.SSBP_LANG_UPLOAD_IMAGE.'" />';
							$htmlShareButtonsForm .= '</td>';
						$htmlShareButtonsForm .= '</tr>';
						$htmlShareButtonsForm .= '<tr class="ssbp_custom_image" valign="top" '.($arrSettings['ssbp_custom_images'] != 'Y' ? 'style="display: none;"' : NULL).'>';
							$htmlShareButtonsForm .= '<th scope="row" style="width: 120px;"><label>StumbleUpon:</label></th>';
							$htmlShareButtonsForm .= '<td>';
							$htmlShareButtonsForm .= '<input id="ssbp_custom_stumbleupon" type="text" size="50" name="ssbp_custom_stumbleupon" value="' . (isset($arrSettings['ssbp_custom_stumbleupon']) ? $arrSettings['ssbp_custom_stumbleupon'] : NULL)  . '" />';
							$htmlShareButtonsForm .= '<input id="upload_stumbleupon_button" data-ssbp-input="ssbp_custom_stumbleupon" class="button customUpload" type="button" value="'.SSBP_LANG_UPLOAD_IMAGE.'" />';
							$htmlShareButtonsForm .= '</td>';
						$htmlShareButtonsForm .= '</tr>';
						$htmlShareButtonsForm .= '<tr class="ssbp_custom_image" valign="top" '.($arrSettings['ssbp_custom_images'] != 'Y' ? 'style="display: none;"' : NULL).'>';
							$htmlShareButtonsForm .= '<th scope="row" style="width: 120px;"><label>Tumblr:</label></th>';
							$htmlShareButtonsForm .= '<td>';
							$htmlShareButtonsForm .= '<input id="ssbp_custom_tumblr" type="text" size="50" name="ssbp_custom_tumblr" value="' . (isset($arrSettings['ssbp_custom_tumblr']) ? $arrSettings['ssbp_custom_tumblr'] : NULL)  . '" />';
							$htmlShareButtonsForm .= '<input id="upload_tumblr_button" data-ssbp-input="ssbp_custom_tumblr" class="button customUpload" type="button" value="'.SSBP_LANG_UPLOAD_IMAGE.'" />';
							$htmlShareButtonsForm .= '</td>';
						$htmlShareButtonsForm .= '</tr>';
						$htmlShareButtonsForm .= '<tr class="ssbp_custom_image" valign="top" '.($arrSettings['ssbp_custom_images'] != 'Y' ? 'style="display: none;"' : NULL).'>';
							$htmlShareButtonsForm .= '<th scope="row" style="width: 120px;"><label>Twitter:</label></th>';
							$htmlShareButtonsForm .= '<td>';
							$htmlShareButtonsForm .= '<input id="ssbp_custom_twitter" type="text" size="50" name="ssbp_custom_twitter" value="' . (isset($arrSettings['ssbp_custom_twitter']) ? $arrSettings['ssbp_custom_twitter'] : NULL)  . '" />';
							$htmlShareButtonsForm .= '<input id="upload_twitter_button" data-ssbp-input="ssbp_custom_twitter" class="button customUpload" type="button" value="'.SSBP_LANG_UPLOAD_IMAGE.'" />';
							$htmlShareButtonsForm .= '</td>';
						$htmlShareButtonsForm .= '</tr>';
						$htmlShareButtonsForm .= '<tr class="ssbp_custom_image" valign="top" '.($arrSettings['ssbp_custom_images'] != 'Y' ? 'style="display: none;"' : NULL).'>';
							$htmlShareButtonsForm .= '<th scope="row" style="width: 120px;"><label>VK:</label></th>';
							$htmlShareButtonsForm .= '<td>';
							$htmlShareButtonsForm .= '<input id="ssbp_custom_vk" type="text" size="50" name="ssbp_custom_vk" value="' . (isset($arrSettings['ssbp_custom_vk']) ? $arrSettings['ssbp_custom_vk'] : NULL)  . '" />';
							$htmlShareButtonsForm .= '<input id="upload_vk_button" data-ssbp-input="ssbp_custom_vk" class="button customUpload" type="button" value="'.SSBP_LANG_UPLOAD_IMAGE.'" />';
							$htmlShareButtonsForm .= '<p class="description">'.SSBP_LANG_CUSTOM_IMAGES_DESC2.'</p></td>';
						$htmlShareButtonsForm .= '</tr>';
							
							$htmlShareButtonsForm .= '<tr valign="top">';
								$htmlShareButtonsForm .= '<th scope="row" style="width: 150px;"><label for="ssbp_alignment">Alignment:&nbsp;</label></th>';
								$htmlShareButtonsForm .= '<td><select name="ssbp_alignment" id="ssbp_alignment">';
								$htmlShareButtonsForm .= '<option ' . ($arrSettings['ssbp_alignment'] == 'left'   ? 'selected="selected"' : NULL) . ' value="left">Left</option>';
								$htmlShareButtonsForm .= '<option ' . ($arrSettings['ssbp_alignment'] == 'center' ? 'selected="selected"' : NULL) . ' value="center">Center</option>';
								$htmlShareButtonsForm .= '<option ' . ($arrSettings['ssbp_alignment'] == 'right' ? 'selected="selected"' : NULL) . ' value="right">Right</option>';
								$htmlShareButtonsForm .= '</select>';
								$htmlShareButtonsForm .= '<p class="description">Align your buttons the way you wish</p></td>';
							$htmlShareButtonsForm .= '</tr>';
							$htmlShareButtonsForm .= '<tr valign="top">';
								$htmlShareButtonsForm .= '<th scope="row" style="width: 150px;"><label for="ssbp_icon_color">Icon Colour:&nbsp;</label></th>';
								$htmlShareButtonsForm .= '<td><select name="ssbp_icon_color" id="ssbp_icon_color">';
								$htmlShareButtonsForm .= '<option ' . ($arrSettings['ssbp_icon_color'] == 'white'   ? 'selected="selected"' : NULL) . ' value="white">White</option>';
								$htmlShareButtonsForm .= '<option ' . ($arrSettings['ssbp_icon_color'] == 'black' ? 'selected="selected"' : NULL) . ' value="black">Black</option>';
								$htmlShareButtonsForm .= '<option ' . ($arrSettings['ssbp_icon_color'] == 'color' ? 'selected="selected"' : NULL) . ' value="color">Coloured</option>';
								$htmlShareButtonsForm .= '</select>';
								$htmlShareButtonsForm .= '<p class="description">Pick the icon colour that you want</p></td>';
							$htmlShareButtonsForm .= '</tr>';
							$htmlShareButtonsForm .= '<tr valign="top" class="ssbp_non_custom_image" '.($arrSettings['ssbp_custom_images'] == 'Y' ? 'style="display: none;"' : NULL).'>';
								$htmlShareButtonsForm .= '<th scope="row" style="width: 150px;"><label for="ssbp_size">Button Size:&nbsp;</label></th>';
								$htmlShareButtonsForm .= '<td><select name="ssbp_size" id="ssbp_size">';
								$htmlShareButtonsForm .= '<option ' . ($arrSettings['ssbp_size'] == 'small'   ? 'selected="selected"' : NULL) . ' value="small">Small</option>';
								$htmlShareButtonsForm .= '<option ' . ($arrSettings['ssbp_size'] == 'medium' ? 'selected="selected"' : NULL) . ' value="medium">Medium</option>';
								$htmlShareButtonsForm .= '<option ' . ($arrSettings['ssbp_size'] == 'large' ? 'selected="selected"' : NULL) . ' value="large">Large</option>';
								$htmlShareButtonsForm .= '</select>';
								$htmlShareButtonsForm .= '<p class="description">Pick a button size that fits your website</p></td>';
							$htmlShareButtonsForm .= '</tr>';
							$htmlShareButtonsForm .= '<tr valign="top" class="ssbp_non_custom_image" '.($arrSettings['ssbp_custom_images'] == 'Y' ? 'style="display: none;"' : NULL).'>';
								$htmlShareButtonsForm .= '<th scope="row" style="width: 150px;"><label for="ssbp_button_borders">Button Borders:</label></th>';
								$htmlShareButtonsForm .= '<td>';
								$htmlShareButtonsForm .= 'Yes&nbsp;<input type="checkbox" name="ssbp_button_borders" id="ssbp_button_borders" ' . ($arrSettings['ssbp_button_borders'] == 'Y'  ? 'checked' : NULL) . ' value="Y" style="margin-right: 10px;" />';
								$htmlShareButtonsForm .= '<p class="description">Check this box to add bottom borders</p></td>';
							$htmlShareButtonsForm .= '</tr>';
							$htmlShareButtonsForm .= '<tr valign="top" class="ssbp_non_custom_image" '.($arrSettings['ssbp_custom_images'] == 'Y' ? 'style="display: none;"' : NULL).'>';
								$htmlShareButtonsForm .= '<th scope="row" style="width: 150px;"><label for="ssbp_button_shape">Button Shape:&nbsp;</label></th>';
								$htmlShareButtonsForm .= '<td><select name="ssbp_button_shape" id="ssbp_button_shape">';
									$htmlShareButtonsForm .= '<option ' . ($arrSettings['ssbp_button_shape'] == 'rectangle'  ? 'selected="selected"' : NULL) . ' value="rectangle">Rectangle</option>';
									$htmlShareButtonsForm .= '<option ' . ($arrSettings['ssbp_button_shape'] == 'circle' 			   ? 'selected="selected"' : NULL) . ' value="circle">Circle</option>';
									$htmlShareButtonsForm .= '<option ' . ($arrSettings['ssbp_button_shape'] == 'square'  ? 'selected="selected"' : NULL) . ' value="square">Square</option>';
								$htmlShareButtonsForm .= '</select>';
								
								$htmlShareButtonsForm .= '<p class="description">Choose the button shape you prefer</p></td>';
							$htmlShareButtonsForm .= '</tr>';
							$htmlShareButtonsForm .= '<tr valign="top" class="ssbp_show_btn_txt ssbp_non_custom_image" '.($arrSettings['ssbp_custom_images'] == 'Y' ? 'style="display: none;"' : NULL).'>';
								$htmlShareButtonsForm .= '<th scope="row" style="width: 150px;"><label>Button Text:</label></th>';
								$htmlShareButtonsForm .= '<td>';
								$htmlShareButtonsForm .= 'Show&nbsp;<input type="checkbox" name="ssbp_show_btn_txt" id="ssbp_show_btn_txt" ' . ($arrSettings['ssbp_show_btn_txt'] == 'Y'  ? 'checked' : NULL) . ' value="Y" style="margin-right: 10px;" />';
								$htmlShareButtonsForm .= '<p class="description">Check this box to show button text</p></td>';
							$htmlShareButtonsForm .= '</tr>';
							$htmlShareButtonsForm .= '<tr valign="top" class="ssbp_non_custom_image"  '.($arrSettings['ssbp_custom_images'] == 'Y' ? 'style="display: none;"' : NULL).'>';
								$htmlShareButtonsForm .= '<th scope="row" style="width: 150px;"><label for="ssbp_button_margin">Button Spacing:&nbsp;</label></th>';
								$htmlShareButtonsForm .= '<td><input type="number" style="width: 80px;" name="ssbp_button_margin" id="ssbp_button_margin" value="' . $arrSettings['ssbp_button_margin'] . '"><span class="description">px</span>';
								$htmlShareButtonsForm .= '</input>';
								$htmlShareButtonsForm .= '<p class="description">Set spacing between your buttons</p></td>';
							$htmlShareButtonsForm .= '</tr>';
							$htmlShareButtonsForm .= '<tr valign="top" '.($arrSettings['ssbp_color_main'] != '' ? 'style="display:none;"' : NULL).' class="ssbp_non_custom_image" '.($arrSettings['ssbp_custom_images'] == 'Y' ? 'style="display: none;"' : NULL).'>';
								$htmlShareButtonsForm .= '<td><span id="ssbp_button_custom_colours" class="button button-secondary"/>Choose custom colours</span><td>';
							$htmlShareButtonsForm .= '</tr>';
							$htmlShareButtonsForm .= '<tr valign="top" class="ssbp-custom-colours ssbp_non_custom_image" '.($arrSettings['ssbp_color_main'] == '' || $arrSettings['ssbp_custom_images'] == 'Y' ? 'style="display:none;"' : NULL).'>';
								$htmlShareButtonsForm .= '<th scope="row" style="width: 150px;"><label for="ssbp_color_main">Main Colour:&nbsp;</label></th>';
								$htmlShareButtonsForm .= '<td><input type="text" name="ssbp_color_main" id="ssbp_color_main" value="' . $arrSettings['ssbp_color_main'] . '">';
								$htmlShareButtonsForm .= '</input>';
								$htmlShareButtonsForm .= '<p class="description">Choose a custom colour for your buttons <b>(must be set for custom border/hover to take effect)</b></p></td>';
							$htmlShareButtonsForm .= '</tr>';
							$htmlShareButtonsForm .= '<tr valign="top" class="ssbp-custom-colours ssbp_non_custom_image" '.($arrSettings['ssbp_color_main'] == '' || $arrSettings['ssbp_custom_images'] == 'Y' ? 'style="display:none;"' : NULL).'>';
								$htmlShareButtonsForm .= '<th scope="row" style="width: 150px;"><label for="ssbp_color_border">Button Border Colour:&nbsp;</label></th>';
								$htmlShareButtonsForm .= '<td><input type="text" name="ssbp_color_border" id="ssbp_color_border" value="' . $arrSettings['ssbp_color_border'] . '">';
								$htmlShareButtonsForm .= '</input>';
								$htmlShareButtonsForm .= '<p class="description">Choose a custom colour for the button border <b>(defaults to main colour if left blank)</b></p></td>';
							$htmlShareButtonsForm .= '</tr>';
							$htmlShareButtonsForm .= '<tr valign="top" class="ssbp-custom-colours ssbp_non_custom_image" '.($arrSettings['ssbp_color_main'] == '' || $arrSettings['ssbp_custom_images'] == 'Y' ? 'style="display:none;"' : NULL).'>';
								$htmlShareButtonsForm .= '<th scope="row" style="width: 150px;"><label for="ssbp_color_hover">Button Hover Colour:&nbsp;</label></th>';
								$htmlShareButtonsForm .= '<td><input type="text" name="ssbp_color_hover" id="ssbp_color_hover" value="' . $arrSettings['ssbp_color_hover'] . '">';
								$htmlShareButtonsForm .= '</input>';
								$htmlShareButtonsForm .= '<p class="description">Choose your button colour when hovered over <b>(defaults to main colour if left blank)</b></p></td>';
							$htmlShareButtonsForm .= '</tr>';
							$htmlShareButtonsForm .= '<tr valign="top">';
								$htmlShareButtonsForm .= '<th scope="row" style="width: 150px;"><label for="ssbp_text_placement">Text Placement:&nbsp;</label></th>';
								$htmlShareButtonsForm .= '<td><select name="ssbp_text_placement" id="ssbp_text_placement">';
									$htmlShareButtonsForm .= '<option ' . ($arrSettings['ssbp_text_placement'] == 'above'  	? 'selected="selected"' : NULL) . ' value="above">Above</option>';
									$htmlShareButtonsForm .= '<option ' . ($arrSettings['ssbp_text_placement'] == 'left' 	? 'selected="selected"' : NULL) . ' value="left">Left</option>';
									$htmlShareButtonsForm .= '<option ' . ($arrSettings['ssbp_text_placement'] == 'right'  	? 'selected="selected"' : NULL) . ' value="right">Right</option>';
									$htmlShareButtonsForm .= '<option ' . ($arrSettings['ssbp_text_placement'] == 'below' 	? 'selected="selected"' : NULL) . ' value="below">Below</option>';
								$htmlShareButtonsForm .= '</select>';
								
								$htmlShareButtonsForm .= '<p class="description">Choose where in relation to your buttons you wish your share text to appear</p></td>';
							$htmlShareButtonsForm .= '</tr>';
							$htmlShareButtonsForm .= '<tr valign="top">';
								$htmlShareButtonsForm .= '<th scope="row" style="width: 150px;"><label for="ssbp_font_weight">Font Weight:&nbsp;</label></th>';
								$htmlShareButtonsForm .= '<td><select name="ssbp_font_weight" id="ssbp_font_weight">';
									$htmlShareButtonsForm .= '<option ' . ($arrSettings['ssbp_font_weight'] == 'light'  ? 'selected="selected"' : NULL) . ' value="light">Light</option>';
									$htmlShareButtonsForm .= '<option ' . ($arrSettings['ssbp_font_weight'] == 'normal' ? 'selected="selected"' : NULL) . ' value="normal">Normal</option>';
									$htmlShareButtonsForm .= '<option ' . ($arrSettings['ssbp_font_weight'] == 'bold'  ? 'selected="selected"' : NULL) . ' value="bold">Bold</option>';
								$htmlShareButtonsForm .= '</select>';
								
								$htmlShareButtonsForm .= '<p class="description">Choose the weight of your share text</p></td>';
							$htmlShareButtonsForm .= '</tr>';
							$htmlShareButtonsForm .= '<tr valign="top">';
								$htmlShareButtonsForm .= '<th scope="row" style="width: 150px;"><label for="ssbp_font_family">Font Family:&nbsp;</label></th>';
								$htmlShareButtonsForm .= '<td><select name="ssbp_font_family" id="ssbp_font_family">';
									$htmlShareButtonsForm .= '<option ' . ($arrSettings['ssbp_font_family'] == 'Indie Flower'  ? 'selected="selected"' : NULL) . ' value="Indie Flower">Indie Flower</option>';
									$htmlShareButtonsForm .= '<option ' . ($arrSettings['ssbp_font_family'] == '' 			   ? 'selected="selected"' : NULL) . ' value="">Inherit from my website</option>';
									$htmlShareButtonsForm .= '<option ' . ($arrSettings['ssbp_font_family'] == 'Open Sans'  ? 'selected="selected"' : NULL) . ' value="Open Sans">Open Sans</option>';
									$htmlShareButtonsForm .= '<option ' . ($arrSettings['ssbp_font_family'] == 'Reenie Beanie' ? 'selected="selected"' : NULL) . ' value="Reenie Beanie">Reenie Beanie</option>';
									$htmlShareButtonsForm .= '<option ' . ($arrSettings['ssbp_font_family'] == 'Shadows Into Light' ? 'selected="selected"' : NULL) . ' value="Shadows Into Light">Shadows Into Light</option>';
								$htmlShareButtonsForm .= '</select>';
								
								$htmlShareButtonsForm .= '<p class="description">Choose a font available or inherit the font from your website</p></td>';
							$htmlShareButtonsForm .= '</tr>';
							$htmlShareButtonsForm .= '<tr valign="top">';
								$htmlShareButtonsForm .= '<th scope="row" style="width: 150px;"><label for="ssbp_font_color">Font Colour:&nbsp;</label></th>';
								$htmlShareButtonsForm .= '<td><input type="text" name="ssbp_font_color" id="ssbp_font_color" value="' . $arrSettings['ssbp_font_color'] . '">';
								$htmlShareButtonsForm .= '</input>';
								$htmlShareButtonsForm .= '<p class="description">Choose the colour of your share text</p></td>';
							$htmlShareButtonsForm .= '</tr>';
							$htmlShareButtonsForm .= '<tr valign="top">';
								$htmlShareButtonsForm .= '<th scope="row" style="width: 150px;"><label for="ssbp_font_size">Font Size:&nbsp;</label></th>';
								$htmlShareButtonsForm .= '<td><input type="number" style="width: 80px;" name="ssbp_font_size" id="ssbp_font_size" value="' . $arrSettings['ssbp_font_size'] . '"><span class="description">px</span>';
								$htmlShareButtonsForm .= '</input>';
								$htmlShareButtonsForm .= '<p class="description">Set the size of the share text in pixels</p></td>';
							$htmlShareButtonsForm .= '</tr>';
						$htmlShareButtonsForm .= '</table>';
					$htmlShareButtonsForm .= '</div>';
						
					// custom style field
					$htmlShareButtonsForm .= '<div id="ssbp_option_custom_css" ' . ($arrSettings['ssbp_custom_styles'] == '' ? 'style="display: none;"' : NULL) . '>';
						$htmlShareButtonsForm .= '<table>';
							$htmlShareButtonsForm .= '<tr valign="top">';
								$htmlShareButtonsForm .= '<th scope="row" style="width: 150px;"><label for="ssbp_custom_styles">Custom CSS:&nbsp;</label></th>';
								$htmlShareButtonsForm .= '<td>';
								$htmlShareButtonsForm .= '<textarea name="ssbp_custom_styles" id="ssbp_custom_styles" rows="20" cols="50">' . $arrSettings['ssbp_custom_styles'] . '</textarea>';
							$htmlShareButtonsForm .= '<tr>';
								$htmlShareButtonsForm .= '<td>';
								$htmlShareButtonsForm .= '</td>';
								$htmlShareButtonsForm .= '<td colspan=2>';
									$htmlShareButtonsForm .= '<p class="description">Add your own custom CSS if you wish.</p>';
								$htmlShareButtonsForm .= '</td>';
							$htmlShareButtonsForm .= '</tr>';
						$htmlShareButtonsForm .= '</table>';
					$htmlShareButtonsForm .= '</div>';

				// close non_default
				$htmlShareButtonsForm .= '</div>';
				
			// close styling tab
			$htmlShareButtonsForm .= '</div>';
						
			// save button
			$htmlShareButtonsForm .= '<table class="form-table">';
					$htmlShareButtonsForm .= '<tr valign="top">';
						$htmlShareButtonsForm .= '<td><input type="submit" value="'.SSBP_LANG_SAVE_CHANGES.'" id="submit" class="button button-primary"/></td>';
					$htmlShareButtonsForm .= '</tr>';
				$htmlShareButtonsForm .= '</table>';
			$htmlShareButtonsForm .= '</form>';				
									
		// close welcome panel
		$htmlShareButtonsForm .= '</div>';
		$htmlShareButtonsForm .= '</div>';
		
	//close wrap
	$htmlShareButtonsForm .= '</div>';
	
	echo $htmlShareButtonsForm;
}

function ssbp_admin_counters($arrSettings, $htmlSettingsSaved) {

	// variables
	$htmlShareButtonsForm = '';

	// header
	$htmlShareButtonsForm .= '<div class="wrap">';
		$htmlShareButtonsForm .= '<div id="ssbp-header">';
		
			//logo
			$htmlShareButtonsForm .= '<div id="ssbp-logo">';
				$htmlShareButtonsForm .= '<a href="http://www.simplesharebuttons.com" target="_blank"><img src="' . plugins_url() . '/simple-share-buttons-plus/images/simplesharebuttons.png' . '" class="ssbp-logo-img" /></a>';
			$htmlShareButtonsForm .= '</div>';
			
		// close header
		$htmlShareButtonsForm .= '</div>';
		
		// open welcome panel
		$htmlShareButtonsForm .= '<div class="welcome-panel ssbp-section">';
		$htmlShareButtonsForm .= '<div class="welcome-panel-content">';
	
			// show settings saved message if set
			(isset($htmlSettingsSaved) ? $htmlShareButtonsForm .= $htmlSettingsSaved : NULL);
			
			// start form
			$htmlShareButtonsForm .= '<form method="post">';
			$htmlShareButtonsForm .= '<input type="hidden" name="ssbp_options" />';
		
			//------ COUNTERS TAB ------//
			
			$htmlShareButtonsForm .= '<div id="ssbp_settings_counters">';
				$htmlShareButtonsForm .= '<h2 class="ssbp-heading-counters">Counter Settings</h2>';
				$htmlShareButtonsForm .= '<table class="form-table">';
					$htmlShareButtonsForm .= '<tr valign="top">';
						$htmlShareButtonsForm .= '<th scope="row" style="width: 150px;"><label for="ssbp_counters_enabled">Enable share counts:</label></th>';
						$htmlShareButtonsForm .= '<td>';
						$htmlShareButtonsForm .= 'Yes&nbsp;<input type="checkbox" name="ssbp_counters_enabled" id="ssbp_counters_enabled" ' . ($arrSettings['ssbp_counters_enabled'] == 'Y'  ? 'checked' : NULL) . ' value="Y" style="margin-right: 10px;" />';
						$htmlShareButtonsForm .= '<p class="description">Check this box to enable public share counts <b>(load time will be increased)</b></p></td>';
					$htmlShareButtonsForm .= '</tr>';
					$htmlShareButtonsForm .= '<tr valign="top">';
						$htmlShareButtonsForm .= '<th scope="row" style="width: 150px;"><label for="ssbp_counters_type">Type:&nbsp;</label></th>';
						$htmlShareButtonsForm .= '<td><select name="ssbp_counters_type" id="ssbp_counters_type">';
						$htmlShareButtonsForm .= '<option ' . ($arrSettings['ssbp_counters_type'] == 'total'   ? 'selected="selected"' : NULL) . ' value="total">Total</option>';
						$htmlShareButtonsForm .= '<option ' . ($arrSettings['ssbp_counters_type'] == 'each' ? 'selected="selected"' : NULL) . ' value="each">Each</option>';
						$htmlShareButtonsForm .= '</select>';
						$htmlShareButtonsForm .= '<p class="description">Select the type of counters you prefer</p></td>';
					$htmlShareButtonsForm .= '</tr>';
					$htmlShareButtonsForm .= '<tr valign="top">';
							$htmlShareButtonsForm .= '<th scope="row" style="width: 150px;"><label for="ssbp_min_shares">Minimum Shares:&nbsp;</label></th>';
							$htmlShareButtonsForm .= '<td><input type="number" style="width: 80px;" name="ssbp_min_shares" id="ssbp_min_shares" value="' . $arrSettings['ssbp_min_shares'] . '">';
							$htmlShareButtonsForm .= '</input>';
							$htmlShareButtonsForm .= '<p class="description">Set the minimum number of shares required before showing share counts</p></td>';
						$htmlShareButtonsForm .= '</tr>';
							$htmlShareButtonsForm .= '<th scope="row" style="width: 150px;"><label for="ssbp_count_timeout">Count Timeout:&nbsp;</label></th>';
							$htmlShareButtonsForm .= '<td><input type="number" style="width: 80px;" name="ssbp_count_timeout" id="ssbp_count_timeout" value="' . $arrSettings['ssbp_count_timeout'] . '">';
							$htmlShareButtonsForm .= '</input>';
							$htmlShareButtonsForm .= '<p class="description">The maximum number of seconds to try and fetch share counts. Gradually set this number higher if your server is not retrieving share counts consistently.</p></td>';
						$htmlShareButtonsForm .= '</tr>';
						$htmlShareButtonsForm .= '<tr>';
							$htmlShareButtonsForm .= '<th scope="row" style="width: 150px;"><label for="ssbp_count_cache">Count Caching:&nbsp;</label></th>';
							$htmlShareButtonsForm .= '<td><input type="number" style="width: 80px;" name="ssbp_count_cache" id="ssbp_count_cache" value="' . $arrSettings['ssbp_count_cache'] . '">';
							$htmlShareButtonsForm .= '</input>';
							$htmlShareButtonsForm .= '<p class="description">The number of <b>seconds</b> to cache share counts for.</p></td>';
						$htmlShareButtonsForm .= '</tr>';
						$htmlShareButtonsForm .= '<tr valign="top">';
							$htmlShareButtonsForm .= '<th scope="row" style="width: 150px;"><label for="ssbp_share_api">SSB API (Beta):</label></th>';
							$htmlShareButtonsForm .= '<td>';
							$htmlShareButtonsForm .= 'Yes&nbsp;<input type="checkbox" name="ssbp_share_api" id="ssbp_share_api" ' . ($arrSettings['ssbp_share_api'] == 'Y'  ? 'checked' : NULL) . ' value="Y" style="margin-right: 10px;" />';
							$htmlShareButtonsForm .= '<p class="description">If your buttons are incorrectly displaying zero share counts for Facebook, check this box to retrieve counts via the <b><a href="https://simplesharebuttons.com/api/" target="_blank">SSBP API</a></b>. <b>Only applies to Facebook share counts, valid licenses only</b></p></td>';
					$htmlShareButtonsForm .= '</tr>';

				$htmlShareButtonsForm .= '</table>';
			$htmlShareButtonsForm .= '</div>';
			
			// save button
			$htmlShareButtonsForm .= '<table class="form-table">';
					$htmlShareButtonsForm .= '<tr valign="top">';
						$htmlShareButtonsForm .= '<td><input type="submit" value="'.SSBP_LANG_SAVE_CHANGES.'" id="submit" class="button button-primary"/></td>';
					$htmlShareButtonsForm .= '</tr>';
				$htmlShareButtonsForm .= '</table>';
			$htmlShareButtonsForm .= '</form>';
		
		// close welcome panel
		$htmlShareButtonsForm .= '</div>';
		$htmlShareButtonsForm .= '</div>';
		
	//close wrap
	$htmlShareButtonsForm .= '</div>';
	
	echo $htmlShareButtonsForm;
}

function ssbp_admin_meta($arrSettings, $htmlSettingsSaved) {

	// variables
	$htmlShareButtonsForm = '';
	
	// header
	$htmlShareButtonsForm .= '<div class="wrap">';
		$htmlShareButtonsForm .= '<div id="ssbp-header">';
		
			//logo
			$htmlShareButtonsForm .= '<div id="ssbp-logo">';
				$htmlShareButtonsForm .= '<a href="http://www.simplesharebuttons.com" target="_blank"><img src="' . plugins_url() . '/simple-share-buttons-plus/images/simplesharebuttons.png' . '" class="ssbp-logo-img" /></a>';
			$htmlShareButtonsForm .= '</div>';
			
		// close header
		$htmlShareButtonsForm .= '</div>';
		
		// html form
		$htmlShareButtonsForm .= '<div class="welcome-panel ssbp-section">';
		$htmlShareButtonsForm .= '<div class="welcome-panel-content">';
		
			// show settings saved message if set
			(isset($htmlSettingsSaved) ? $htmlShareButtonsForm .= $htmlSettingsSaved : NULL);
			
			// start form
			$htmlShareButtonsForm .= '<form method="post">';
			$htmlShareButtonsForm .= '<input type="hidden" name="ssbp_options" />';
			
			//------ META TAB ------//
			
			$htmlShareButtonsForm .= '<div id="ssbp_settings_meta">';
				$htmlShareButtonsForm .= '<h2 class="ssbp-heading-meta">Meta Tag Settings</h2>';
				$htmlShareButtonsForm .= '<p>If enabled, Simple Share Buttons Plus will add a number of meta fields to the head of your webpages. Please note that some themes/SEO plugins also offer this functionality, <b>please check this if results aren\'t as expected</b>.</p><p>Please also note that Facebook caches webpage details on each share click, until updated using the <a href="https://developers.facebook.com/tools/debug/" target="_blank">Facebook debugger</a></p>';
				$htmlShareButtonsForm .= '<table class="form-table">';
					$htmlShareButtonsForm .= '<tr valign="top">';
							$htmlShareButtonsForm .= '<th scope="row" style="width: 150px;"><label for="ssbp_meta_enabled">Enable Meta:</label></th>';
							$htmlShareButtonsForm .= '<td>';
							$htmlShareButtonsForm .= 'Yes&nbsp;<input type="checkbox" name="ssbp_meta_enabled" id="ssbp_meta_enabled" ' . ($arrSettings['ssbp_meta_enabled'] == 'Y'  ? 'checked' : NULL) . ' value="Y" style="margin-right: 10px;" />';
							$htmlShareButtonsForm .= '<p class="description">Enable SSBP\'s meta functionality</p></td>';
						$htmlShareButtonsForm .= '</tr>';
				$htmlShareButtonsForm .= '<tr valign="top">';
						$htmlShareButtonsForm .= '<th scope="row" style="width: 150px;"><label>Default Title:</label></th>';
						$htmlShareButtonsForm .= '<td><input type="text" name="ssbp_meta_title" size="50" id="ssbp_meta_title" value="' . $arrSettings['ssbp_meta_title'] . '" />';
						$htmlShareButtonsForm .= '<p class="description">Add a default share description</p></td>';
					$htmlShareButtonsForm .= '</tr>';
					$htmlShareButtonsForm .= '<tr class="ssbp_meta_description" valign="top">';
						$htmlShareButtonsForm .= '<th scope="row" style="width: 120px;"><label>Default Description:</label></th>';
						$htmlShareButtonsForm .= '<td>';
						$htmlShareButtonsForm .= '<textarea name="ssbp_meta_description" id="ssbp_meta_description" rows="4" cols="50">' . $arrSettings['ssbp_meta_description'] . '</textarea>';
						$htmlShareButtonsForm .= '<p class="description">Add a default share description</p></td>';
					$htmlShareButtonsForm .= '</tr>';
					$htmlShareButtonsForm .= '<tr class="ssbp_custom_image" valign="top">';
						$htmlShareButtonsForm .= '<th scope="row" style="width: 120px;"><label>Default Image:</label></th>';
						$htmlShareButtonsForm .= '<td>';
						$htmlShareButtonsForm .= '<input id="ssbp_meta_image" type="text" size="50" name="ssbp_meta_image" value="' . (isset($arrSettings['ssbp_meta_image']) ? $arrSettings['ssbp_meta_image'] : NULL)  . '" />';
						$htmlShareButtonsForm .= '<input id="upload_meta_button" data-ssbp-input="ssbp_meta_image" class="button customUpload" type="button" value="'.SSBP_LANG_UPLOAD_IMAGE.'" />';
						$htmlShareButtonsForm .= '<p class="description">Add a default share image</p></td>';
					$htmlShareButtonsForm .= '</tr>';
				$htmlShareButtonsForm .= '</table>';
			$htmlShareButtonsForm .= '</div>';
			
			// save button
			$htmlShareButtonsForm .= '<table class="form-table">';
					$htmlShareButtonsForm .= '<tr valign="top">';
						$htmlShareButtonsForm .= '<td><input type="submit" value="'.SSBP_LANG_SAVE_CHANGES.'" id="submit" class="button button-primary"/></td>';
					$htmlShareButtonsForm .= '</tr>';
				$htmlShareButtonsForm .= '</table>';
			$htmlShareButtonsForm .= '</form>';
			
		// close form cell and open author one
		$htmlShareButtonsForm .= '</td><td style="vertical-align: top;">';					
									
		// close welcome panel
		$htmlShareButtonsForm .= '</div>';
		$htmlShareButtonsForm .= '</div>';
		
	//close wrap
	$htmlShareButtonsForm .= '</div>';
	
	echo $htmlShareButtonsForm;
}

function ssbp_admin_post_types($arrSettings, $htmlSettingsSaved) {

	// variables
	$htmlShareButtonsForm = '';
	
	// header
	$htmlShareButtonsForm .= '<div class="wrap">';
		$htmlShareButtonsForm .= '<div id="ssbp-header">';
		
			//logo
			$htmlShareButtonsForm .= '<div id="ssbp-logo">';
				$htmlShareButtonsForm .= '<a href="http://www.simplesharebuttons.com" target="_blank"><img src="' . plugins_url() . '/simple-share-buttons-plus/images/simplesharebuttons.png' . '" class="ssbp-logo-img" /></a>';
			$htmlShareButtonsForm .= '</div>';
			
		// close header
		$htmlShareButtonsForm .= '</div>';
		
		// html form
		$htmlShareButtonsForm .= '<div class="welcome-panel ssbp-section">';
		$htmlShareButtonsForm .= '<div class="welcome-panel-content">';
		
			// show settings saved message if set
			(isset($htmlSettingsSaved) ? $htmlShareButtonsForm .= $htmlSettingsSaved : NULL);
			
			// start form
			$htmlShareButtonsForm .= '<form method="post">';
			$htmlShareButtonsForm .= '<input type="hidden" name="ssbp_options" />';
			
			//------ CUSTOM POST TYPES TAB ------//
			
			$htmlShareButtonsForm .= '<div id="ssbp_settings_advanced">';
				$htmlShareButtonsForm .= '<h2 class="ssbp-heading-post-types">Disable Post Types</h2>';
				$htmlShareButtonsForm .= '<table class="form-table">';

				// fetch all post types
				$post_types = get_post_types( '', 'names' );

				// create an array of post types to ignore
				$arrIgnoreTypes = array(
										'post',
										'page',
										'attachment',
										'revision',
										'nav_menu_item',
										);

				// create a count
				$countPostTypes = 0;

				// loop through them
				foreach ( $post_types as $post_type )
				{

					// skip those we don't want
					if(in_array($post_type, $arrIgnoreTypes))
						continue;

					// add to counter
					$countPostTypes++;

					$htmlShareButtonsForm .= '<tr valign="top">';
					  	$htmlShareButtonsForm .= '<td>';
							$htmlShareButtonsForm .= '<input type="checkbox" name="ssbp_disabled_types[]" '. (in_array($post_type, explode(',', $arrSettings['ssbp_disabled_types'])) ? 'checked' : NULL) . ' value="'.$post_type.'" style="margin-right: 10px;" />&nbsp;'.$post_type.'</td>';
					$htmlShareButtonsForm .= '</tr>';
				}

				// if there are no relevant custom post types
				if($countPostTypes == 0)
				{
					$htmlShareButtonsForm .= '<tr valign="top">';
						$htmlShareButtonsForm .= '<td><p class="description">No relevant custom post types found</p></td>';
					$htmlShareButtonsForm .= '</tr>';
				}
				else // we have some custom post types
				{
					$htmlShareButtonsForm .= '<tr valign="top">';
						$htmlShareButtonsForm .= '<td><p class="description">Check which custom posts you do <b>NOT</b> wish to display share buttons on</p></td>';
					$htmlShareButtonsForm .= '</tr>';

						$htmlShareButtonsForm .= '</table>';
					$htmlShareButtonsForm .= '</div>';
					
					// save button
					$htmlShareButtonsForm .= '<table class="form-table">';
						$htmlShareButtonsForm .= '<tr valign="top">';
							$htmlShareButtonsForm .= '<td><input type="submit" value="'.SSBP_LANG_SAVE_CHANGES.'" id="submit" class="button button-primary"/></td>';
						$htmlShareButtonsForm .= '</tr>';
					$htmlShareButtonsForm .= '</table>';
				}

				
			$htmlShareButtonsForm .= '</form>';			
									
		// close welcome panel
		$htmlShareButtonsForm .= '</div>';
		$htmlShareButtonsForm .= '</div>';
		
	//close wrap
	$htmlShareButtonsForm .= '</div>';
	
	echo $htmlShareButtonsForm;
}

function ssbp_admin_advanced($arrSettings, $htmlSettingsSaved) {

	// variables
	$htmlShareButtonsForm = '';
	
	// header
	$htmlShareButtonsForm .= '<div class="wrap">';
		$htmlShareButtonsForm .= '<div id="ssbp-header">';
		
			//logo
			$htmlShareButtonsForm .= '<div id="ssbp-logo">';
				$htmlShareButtonsForm .= '<a href="http://www.simplesharebuttons.com" target="_blank"><img src="' . plugins_url() . '/simple-share-buttons-plus/images/simplesharebuttons.png' . '" class="ssbp-logo-img" /></a>';
			$htmlShareButtonsForm .= '</div>';
			
		// close header
		$htmlShareButtonsForm .= '</div>';
		
		// html form
		$htmlShareButtonsForm .= '<div class="welcome-panel ssbp-section">';
		$htmlShareButtonsForm .= '<div class="welcome-panel-content">';
		
			// show settings saved message if set
			(isset($htmlSettingsSaved) ? $htmlShareButtonsForm .= $htmlSettingsSaved : NULL);
			
			// start form
			$htmlShareButtonsForm .= '<form method="post">';
			$htmlShareButtonsForm .= '<input type="hidden" name="ssbp_options" />';
			
			//------ ADVANCED TAB ------//
			
			$htmlShareButtonsForm .= '<div id="ssbp_settings_advanced">';
				$htmlShareButtonsForm .= '<h2 class="ssbp-heading-advanced">Advanced Settings</h2>';
				$htmlShareButtonsForm .= '<table class="form-table">';
					$htmlShareButtonsForm .= '<tr valign="top">';
						$htmlShareButtonsForm .= '<th scope="row" style="width: 150px;"><label>Bitly Login:</label></th>';
						$htmlShareButtonsForm .= '<td><input type="text" name="ssbp_bitly_login" style="width: 250px;" id="ssbp_bitly_login" value="' . $arrSettings['ssbp_bitly_login'] . '" />';
						$htmlShareButtonsForm .= '<p class="description">Enter your Bitly login to shorten your URLs</p></td>';
					$htmlShareButtonsForm .= '</tr>';
					$htmlShareButtonsForm .= '<tr valign="top">';
						$htmlShareButtonsForm .= '<th scope="row" style="width: 150px;"><label for="ssbp_bitly_api_key">Bitly API Key:&nbsp;</label></th>';
						$htmlShareButtonsForm .= '<td><input type="text" name="ssbp_bitly_api_key" style="width: 250px;" id="ssbp_bitly_api_key" value="' . $arrSettings['ssbp_bitly_api_key'] . '" />';
						$htmlShareButtonsForm .= '<p class="description">Enter your Bitly API Key, from your <a href="https://bitly.com/a/create_oauth_app" target="_blank">registered application</a></p></td>';
					$htmlShareButtonsForm .= '</tr>';
					$htmlShareButtonsForm .= '<tr valign="top">';
						$htmlShareButtonsForm .= '<th scope="row" style="width: 150px;"><label for="ssbp_rel_nofollow">Nofollow</label></th>';
							$htmlShareButtonsForm .= '<td>';
								$htmlShareButtonsForm .= 'Yes&nbsp;<input type="checkbox" name="ssbp_rel_nofollow" id="ssbp_rel_nofollow" ' . ($arrSettings['ssbp_rel_nofollow'] == 'Y'  ? 'checked' : NULL) . ' value="Y" style="margin-right: 10px;" />';
								$htmlShareButtonsForm .= '<p class="description">Check this box to add nofollow to links</p></td>';
					$htmlShareButtonsForm .= '</tr>';
					$htmlShareButtonsForm .= '<tr valign="top">';
						$htmlShareButtonsForm .= '<th scope="row" style="width: 150px;"><label>Widget text:</label></th>';
						$htmlShareButtonsForm .= '<td><input type="text" name="ssbp_widget_text" style="width: 250px;" id="ssbp_widget_text" value="' . $arrSettings['ssbp_widget_text'] . '" />';
						$htmlShareButtonsForm .= '<p class="description">Add custom share text when used as a widget</p></td>';
					$htmlShareButtonsForm .= '</tr>';
					$htmlShareButtonsForm .= '<tr valign="top">';
						$htmlShareButtonsForm .= '<th scope="row" style="width: 150px;"><label for="ssbp_email_message">Email Text:&nbsp;</label></th>';
						$htmlShareButtonsForm .= '<td><input type="text" name="ssbp_email_message" style="width: 250px;" id="ssbp_email_message" value="' . $arrSettings['ssbp_email_message'] . '" />';
						$htmlShareButtonsForm .= '<p class="description">Add some text included in the email when people share that way</p></td>';
					$htmlShareButtonsForm .= '</tr>';
					$htmlShareButtonsForm .= '<tr valign="top">';
						$htmlShareButtonsForm .= '<th scope="row" style="width: 150px;"><label for="ssbp_twitter_username">Twitter Username:&nbsp;</label></th>';
						$htmlShareButtonsForm .= '<td><input type="text" name="ssbp_twitter_username" style="width: 250px;" id="ssbp_twitter_username" value="' . $arrSettings['ssbp_twitter_username'] . '" />';
						$htmlShareButtonsForm .= '<p class="description">Add your username to tweets, will appear as "via @fairtoshare" for example. <b>No need to add the @ sign</b>.</p></td>';
					$htmlShareButtonsForm .= '</tr>';
					$htmlShareButtonsForm .= '<tr valign="top">';
						$htmlShareButtonsForm .= '<th scope="row" style="width: 150px;"><label for="ssbp_twitter_text">Twitter Text:&nbsp;</label></th>';
						$htmlShareButtonsForm .= '<td><input type="text" name="ssbp_twitter_text" style="width: 250px;" id="ssbp_twitter_text" value="' . $arrSettings['ssbp_twitter_text'] . '" />';
						$htmlShareButtonsForm .= '<p class="description">Add some custom text for when people share via Twitter</p></td>';
					$htmlShareButtonsForm .= '</tr>';
					$htmlShareButtonsForm .= '<tr valign="top">';
						$htmlShareButtonsForm .= '<th scope="row" style="width: 150px;"><label for="ssbp_twitter_tags">Twitter Hashtags:&nbsp;</label></th>';
						$htmlShareButtonsForm .= '<td><input type="text" name="ssbp_twitter_tags" style="width: 250px;" id="ssbp_twitter_tags" value="' . $arrSettings['ssbp_twitter_tags'] . '" />';
						$htmlShareButtonsForm .= '<p class="description">Add hashtags for when people share via Twitter, comma-separated</p></td>';
					$htmlShareButtonsForm .= '</tr>';
					$htmlShareButtonsForm .= '<tr valign="top">';
						$htmlShareButtonsForm .= '<th scope="row" style="width: 150px;"><label for="ssbp_flattr_user_id">Flattr User ID:&nbsp;</label></th>';
						$htmlShareButtonsForm .= '<td><input type="text" name="ssbp_flattr_user_id" id="ssbp_flattr_user_id" style="width: 250px;" value="' . $arrSettings['ssbp_flattr_user_id'] . '" />';
						$htmlShareButtonsForm .= '<p class="description">Enter your Flattr ID, e.g. davidsneal</p></td>';
					$htmlShareButtonsForm .= '</tr>';
					$htmlShareButtonsForm .= '<tr valign="top">';
						$htmlShareButtonsForm .= '<th scope="row" style="width: 150px;"><label for="ssbp_flattr_url">Flattr URL:&nbsp;</label></th>';
						$htmlShareButtonsForm .= '<td><input type="text" name="ssbp_flattr_url" style="width: 250px;" id="ssbp_flattr_url" value="' . $arrSettings['ssbp_flattr_url'] . '" />';
						$htmlShareButtonsForm .= '<p class="description">This option is perfect for dedicated sites, e.g. http://www.simplesharebuttons.com</p></td>';
					$htmlShareButtonsForm .= '</tr>';
					$htmlShareButtonsForm .= '<tr valign="top">';
						$htmlShareButtonsForm .= '<th scope="row" style="width: 150px;"><label for="ssbp_buffer_text">Custom Buffer Text:&nbsp;</label></th>';
						$htmlShareButtonsForm .= '<td><input type="text" name="ssbp_buffer_text" style="width: 250px;" id="ssbp_buffer_text" value="' . $arrSettings['ssbp_buffer_text'] . '" />';
						$htmlShareButtonsForm .= '<p class="description">Add some custom text for when people share via Buffer</p></td>';
					$htmlShareButtonsForm .= '</tr>';
				$htmlShareButtonsForm .= '</table>';
			$htmlShareButtonsForm .= '</div>';
			
			// save button
			$htmlShareButtonsForm .= '<table class="form-table">';
					$htmlShareButtonsForm .= '<tr valign="top">';
						$htmlShareButtonsForm .= '<td><input type="submit" value="'.SSBP_LANG_SAVE_CHANGES.'" id="submit" class="button button-primary"/></td>';
					$htmlShareButtonsForm .= '</tr>';
				$htmlShareButtonsForm .= '</table>';
			$htmlShareButtonsForm .= '</form>';
			
		// close form cell and open author one
		$htmlShareButtonsForm .= '</td><td style="vertical-align: top;">';					
									
		// close welcome panel
		$htmlShareButtonsForm .= '</div>';
		$htmlShareButtonsForm .= '</div>';
		
	//close wrap
	$htmlShareButtonsForm .= '</div>';
	
	echo $htmlShareButtonsForm;
}

function ssbp_dashboard_stats() {
	
	// google chart stuff!
	$htmlDashboard = "<script src='https://www.google.com/jsapi'></script>";
	$htmlDashboard .= "<script type='text/javascript'>";
	$htmlDashboard .= "function resizeCharts () {
						    // redraw charts, dashboards, etc here
						    chart.draw(data, options);
						}
						jQuery(window).resize(resizeCharts);";
	$htmlDashboard .= "</script>";
	$htmlDashboard .= "<script type='text/javascript'>
							      google.load('visualization', '1', {packages:['corechart']});
							      google.setOnLoadCallback(drawChart);
							      function drawChart() {
							        var data = google.visualization.arrayToDataTable([
							          ['Date', 'Shares'],";
			$htmlDashboard .= ssbpShareCountGraph();
			$htmlDashboard .= " ]);";
							
			$htmlDashboard .= "var options = {
												chartArea: {
										            height: '80%',
										            width: '100%'
										        },
										        width: '100%',
										        height: '100%',
												title: '',
									        	legend: {position: 'none'},
hAxis: { textPosition: 'none' },
vAxis: { textPosition: 'none' },
									        };
							
							        var chart = new google.visualization.LineChart(document.getElementById('chart_div'));
							        chart.draw(data, options);
							      }
						    </script>";
	   
	// output the share graph
	$htmlDashboard .= '<div id="chart_wrap"><div id="chart_div"></div></div>';
	
	// text below graph
	$htmlDashboard .= '<p class="description">Your daily share stats for the past week, hover over to see how many.</p>';
			
	return $htmlDashboard;
}

function ssbp_admin_tracking($arrSettings) {

	// if the truncate function has been run
	if (isset($_POST['_wpnonce']) && wp_verify_nonce($_POST['_wpnonce'], 'ssbp_truncate_tracking'))
	{	
		// truncate the table
		ssbp_truncate_tracking();		
	}

	// variables
	$htmlShareButtonsForm = '';
	
	// header
	$htmlShareButtonsForm .= '<div class="wrap">';
		$htmlShareButtonsForm .= '<div id="ssbp-header">';
		
			//logo
			$htmlShareButtonsForm .= '<div id="ssbp-logo">';
				$htmlShareButtonsForm .= '<a href="http://www.simplesharebuttons.com" target="_blank"><img src="' . plugins_url() . '/simple-share-buttons-plus/images/simplesharebuttons.png' . '" class="ssbp-logo-img" /></a>';
			$htmlShareButtonsForm .= '</div>';
			
		// close header
		$htmlShareButtonsForm .= '</div>';
		
		// html form
		$htmlShareButtonsForm .= '<div class="welcome-panel ssbp-section">';
		$htmlShareButtonsForm .= '<div class="welcome-panel-content">';
			
			// the container to replace with content
			$htmlShareButtonsForm .= '<div class="ssbp-total-container"><h2>Total Shares</h2>';	
				$htmlShareButtonsForm .= '<div class="centerme"><img src="' . plugins_url() . '/simple-share-buttons-plus/images/loading.gif"></div>';	
			$htmlShareButtonsForm .= '</div>';	
									  
		// close off this section
		$htmlShareButtonsForm .= '</div>';
		$htmlShareButtonsForm .= '</div>';
		
		// html form
		$htmlShareButtonsForm .= '<div class="welcome-panel ssbp-section">';
		$htmlShareButtonsForm .= '<div class="welcome-panel-content">';
		
			// the container to replace with content
			$htmlShareButtonsForm .= '<div class="ssbp-top-container"><h2>Top Pages/Posts</h2>';	
				$htmlShareButtonsForm .= '<div class="centerme"><img src="' . plugins_url() . '/simple-share-buttons-plus/images/loading.gif"></div>';	
			$htmlShareButtonsForm .= '</div>';	
			
			
			// close off this section
			$htmlShareButtonsForm .= '</div>';
			$htmlShareButtonsForm .= '</div>';
			
			// html form
			$htmlShareButtonsForm .= '<div class="welcome-panel ssbp-section">';
			$htmlShareButtonsForm .= '<div class="welcome-panel-content">';
			
				// the container to replace with content
				$htmlShareButtonsForm .= '<div class="ssbp-latest-container"><h2>Share History</h2>';	
					$htmlShareButtonsForm .= '<div class="centerme"><img src="' . plugins_url() . '/simple-share-buttons-plus/images/loading.gif"></div>';	
				$htmlShareButtonsForm .= '</div>';
			
			// close off this section
			$htmlShareButtonsForm .= '</div>';
			$htmlShareButtonsForm .= '</div>';
			
			// html form
			$htmlShareButtonsForm .= '<div class="welcome-panel ssbp-section">';
			$htmlShareButtonsForm .= '<div class="welcome-panel-content" style="overflow:hidden;">';
			
				// google chart stuff!
				$htmlShareButtonsForm .= "<script src='https://www.google.com/jsapi'></script>";
				$htmlShareButtonsForm .= "<script type='text/javascript'>";
				$htmlShareButtonsForm .= "function resizeCharts () {
									    // redraw charts, dashboards, etc here
									    chart.draw(data, options);
									}
									jQuery(window).resize(resizeCharts);";
				$htmlShareButtonsForm .= "</script>";
				$htmlShareButtonsForm .= "<script type='text/javascript'>
										      google.load('visualization', '1', {packages:['corechart']});
										      google.setOnLoadCallback(drawChart);
										      function drawChart() {
										        var data = google.visualization.arrayToDataTable([
										          ['Date', 'Shares'],";
						$htmlShareButtonsForm .= ssbpShareCountGraph();
						$htmlShareButtonsForm .= " ]);";
										
						$htmlShareButtonsForm .= "var options = {
															chartArea: {
													            height: '80%',
													            width: '100%'
													        },
													        width: '100%',
													        height: '100%',
															title: '',
												        	legend: {position: 'none'},
			hAxis: { textPosition: 'none' },
			vAxis: { textPosition: 'none' },
												        };
										
										        var chart = new google.visualization.LineChart(document.getElementById('chart_div'));
										        chart.draw(data, options);
										      }
									    </script>";
							
				// past week heading
				$htmlShareButtonsForm .= '<h2>Shares this Week</h2>';
				
				// output the share graph
				$htmlShareButtonsForm .= '<div id="chart_wrap"><div id="chart_div"></div></div>';
				
				// text below graph
				$htmlShareButtonsForm .= '<br/><p class="description">Your daily share stats for the past week, hover over to see how many for each day.</p>';
		
		// close welcome panel
		$htmlShareButtonsForm .= '</div>';
		$htmlShareButtonsForm .= '</div>';
		
		// html form
		$htmlShareButtonsForm .= '<div class="welcome-panel ssbp-section">';
		$htmlShareButtonsForm .= '<div class="welcome-panel-content">';
			
			// the container to replace with content
			$htmlShareButtonsForm .= '<div class="ssbp-geoip-container"><h2>GeoIP Stats</h2>';	
				$htmlShareButtonsForm .= '<div class="centerme"><img src="' . plugins_url() . '/simple-share-buttons-plus/images/loading.gif"></div>';	
			$htmlShareButtonsForm .= '</div>';
									  
		// close welcome panel
		$htmlShareButtonsForm .= '</div>';
		$htmlShareButtonsForm .= '</div>';
		
	//close wrap
	$htmlShareButtonsForm .= '</div>';
	
	echo $htmlShareButtonsForm;
}

function ssbp_total_shares_callback() {

	// get total share count
	$intTotalShareCount = ssbpTotalShareCount();

	// jquery on click truncate
	echo '<script>
			// when truncate buttons is clicked
			jQuery("#ssbp-truncate-table").click(function(){
			
				if(confirm("Are you sure? This action CANNOT be undone!")) {
			        return true;
			    }
			    return false;
				
			});
		</script>';

	// if there is any data
	if(intval($intTotalShareCount) > 0)
	{
		// truncate table form
		echo '<form method="post">';
			wp_nonce_field('ssbp_truncate_tracking');
			echo '<button class="ssbp-btn ssbp-delete-btn" id="ssbp-truncate-table" style="float:right;">Clear Stats</button>';
		echo '</form>';
		
		// export csv form
		echo '<form method="post" target="_blank">';
			echo '<input type="hidden" name="ssvp_export" />';
			echo '<button class="ssbp-btn" id="ssbp-export-csv" style="float:right;margin-right:10px;">Export CSV</button>';
		echo '</form>';
	}

	// total share data
	echo '<h2>Total Shares <span class="ssbp-share-count" data-from="0" data-to="'.$intTotalShareCount.'">0</span></h2>';
	
			
	// since when
	if( ! $strTruncateDate = get_option('ssbp_truncate_date'))
		echo '<p class="description">...since Simple Share Buttons Plus was installed on '.get_option('ssbp_install_date').'</p>';
	else
		echo '<p class="description">...since the sharing stats were cleared on '.$strTruncateDate.'</p>';
	
	// count to JS
	echo '<script type="text/javascript">
				jQuery(".ssbp-share-count").countTo();
		  </script>';
	
	// exit so no zeros are returned
	exit();
}

function ssbp_top_three_callback() {

	// get data ready for top 3
	$arrTopThree = ssbpTopThree();
	
	// top three heading
	echo '<h2>Top Pages/Posts</h2>';
	
	// place top shares in a div wrapper
	echo '<div id="ssbp-top-shares-wrap">';

		// table for shares
		echo '<table class="ssbp-top-shares">';
	
		echo '<tr>';
			echo '<th>Position</th>';
			echo '<th>Post/Page</th>';
			echo '<th>Number of Shares</th>';
		echo '</tr>';
		
		// start a counter
		$intCount = 0;
		
		// loop through our top three
		foreach($arrTopThree AS $topShare) {
		
			// add to counter
			$intCount++;
			
			$strPadding = ($intCount == 1 ? ' style="padding-top:10px;"' : NULL);
			
			// add each row to our table
			echo '<tr>';
				echo '<td'.$strPadding.'>'.$intCount.'</td>';
				echo '<td'.$strPadding.'><a href="'.$topShare['url'].'">'.urldecode($topShare['title']).'</a></td>';
				echo '<td'.$strPadding.'><span class="ssbp-share-count-small">'.$topShare['total_shares'].'</span></td>';
			echo '</tr>';
		}
	
		// close table
		echo '</table>';
	
	// close div wrapper
	echo '</div>';
	
	// exit so no zeros are returned
	exit();
}

function ssbp_latest_shares_callback() {

	// if deleting a share
	if(isset($_POST['delete']))
		ssbp_delete_share($_POST['delete']);

	// the geoip could take some time
	set_time_limit(0);

	// no error reporting
	error_reporting(0);

	// get data ready for latest shares
	$arrLatestShares = ssbpLatestShares();
	$intTotalShares = ssbpTotalShareCount();

	// reverse latest shares around to display most recent last
	$arrLatestShares = array_reverse($arrLatestShares);
	
	// latest heading
	echo '<div class="ssbp-latest-container"><h2>Share History</h2>';
	
	// create a table for latest shares
	echo '<table class="ssbp-latest-shares">';
		echo '<tr>';
			echo '<th>Post/Page</th>';
			echo '<th>Site</th>';
			echo '<th>Date</th>';
			echo '<th>GeoIP</th>';
			echo '<th></th>';

		// close the heading row
		echo '</tr>';
		
		// loop through our share data
		foreach($arrLatestShares AS $latestShare) {

			// add each row to our table
			echo '<tr>';
				echo '<td><a href="'.$latestShare['url'].'">'.$latestShare['title'].'</a></td>';
				echo '<td>'.$latestShare['site'].'</td>';
				echo '<td>'.$latestShare['datetime'].'</td>';

				// if geoip isn't set yet
				if($latestShare['geoip'] == '' && $latestShare['ip'] != '127.0.0.1') {

					// retrieve our license key from the DB
					$ssbpLicense_key = trim( get_option( 'ssbp_license_key' ) );
					
					// check license key is there
					if($ssbpLicense_key && $ssbpLicense_key != '')
					{
					
						// encryption key
						$ssbpKey = 'j7PYc7+iLtkVsHgltSQKC5781ljciwfwBAc1'.date('Ym');
				
						// securely encrypt the license key
						$ssbpLicense_key = base64_encode(mcrypt_encrypt(MCRYPT_RIJNDAEL_256, md5($ssbpKey), $ssbpLicense_key, MCRYPT_MODE_CBC, md5(md5($ssbpKey))));

						// skip if there's an error for now
						if(is_wp_error($jsonGeoIP = wp_remote_post('https://simplesharebuttons.com/api/', array(
																	'method' => 'POST',
																	'timeout' => 3,
																	'body' => array(
																				'action' => 'plus_geoip',
																				'license' => $ssbpLicense_key,
																				'ip' => $latestShare['ip']
																				)
																	))))
							continue;
					}
					else
					{
						continue;
					}

					// decode and assign to variables
					$arrGeoIP = json_decode($jsonGeoIP['body'], true);
					$geoipCountry = $arrGeoIP['country'];
					$geoipCode = strtolower($arrGeoIP['country_code']);
				
				} else { // geoip is set

					// decode and assign to variables
					$arrGeoIP = json_decode($latestShare['geoip'], true);
					$geoipCountry = $arrGeoIP['country'];
					$geoipCode = strtolower($arrGeoIP['code']);
				}

				// if not localhost
				if($latestShare['ip'] != 'localhost' && $latestShare['ip'] != '127.0.0.1') {
					
					// add the geoip data
					echo '<td><img src="' . plugins_url() . '/simple-share-buttons-plus/images/flags/'.$geoipCode.'.png' . '" class="ssbg-flag ssbg-flag-small" />'.$geoipCountry.'</td>';

				} else { //localhost

					// add the geoip data
					echo '<td><b>Localhost - Testing</b></td>';
				}
				
				// delete option
				echo '<td><span class="ssbp-delete-share" data-ssbp-share-id="'.$latestShare['id'].'">Delete</span></td>';

			// close the row
			echo '</tr>';
		}
	
	// close the table off
	echo '</table>';

	// set new start
	$ssbpCurrentStart = (isset($_POST['start']) ? intval($_POST['start']) : 0);
	$ssbpPreviousStart = $ssbpCurrentStart + 10;
	$ssbpNextStart = $ssbpCurrentStart - 10;

	// calculate start point after delete
	// if there are NO previous share pages available
	if($ssbpPreviousStart > intval($intTotalShares))
	{
		if(intval($intTotalShares) - $ssbpCurrentStart == 1)
		{
			if($intTotalShares == 1)
				$ssbpAfterDeleteStart = 0;
			else
				$ssbpAfterDeleteStart = $ssbpNextStart;
		}
		else
		{
			$ssbpAfterDeleteStart = $ssbpCurrentStart;
		}
	}
	elseif(intval($intTotalShares) - $ssbpCurrentStart == 0)
		{
			$ssbpAfterDeleteStart = 0;
		}
	else
	{
		$ssbpAfterDeleteStart = $ssbpCurrentStart;
	}

	// add css style for loading transparent
	echo '<style>.ssbp-semi-transparent{background: url("' . plugins_url() . '/simple-share-buttons-plus/images/loading.gif") center center no-repeat}</style>';

	// add pagination function
	echo '<script>
			jQuery(document).ready(function(){

				jQuery("#ssbp-previous-shares").click(function(){

					jQuery(".ssbp-latest-shares").addClass("ssbp-semi-transparent").fadeIn(500);

					dataLatest = {
						action: "ssbp_latest_shares",
						start: "'.$ssbpPreviousStart.'"
					}

					jQuery.post(ajaxurl, dataLatest, function(response) {
						// display tracking
						jQuery(".ssbp-latest-container").replaceWith(response).fadeIn(500);
						jQuery(".ssbp-latest-shares").removeClass("ssbp-semi-transparent");
					});
				});

				jQuery("#ssbp-next-shares").click(function(){

					jQuery(".ssbp-latest-shares").addClass("ssbp-semi-transparent").fadeIn(500);

					dataLatest = {
						action: "ssbp_latest_shares",
						start: "'.$ssbpNextStart.'"
					}

					jQuery.post(ajaxurl, dataLatest, function(response) {
						// display tracking
						jQuery(".ssbp-latest-container").replaceWith(response).fadeIn(500);
						jQuery(".ssbp-latest-shares").removeClass("ssbp-semi-transparent");
					});
				});

				jQuery(".ssbp-delete-share").click(function(){

					jQuery(".ssbp-latest-shares").addClass("ssbp-semi-transparent").fadeIn(500);

					var delete_share = jQuery(this).data("ssbp-share-id");

					dataLatest = {
						action: "ssbp_latest_shares",
						start: "'.$ssbpAfterDeleteStart.'",
						delete: delete_share
					}

					jQuery.post(ajaxurl, dataLatest, function(response) {
						// display tracking
						jQuery(".ssbp-latest-container").replaceWith(response).fadeIn(500);
						jQuery(".ssbp-latest-shares").removeClass("ssbp-semi-transparent");
					});
				});

			});
		</script>';

	// if there are previous shares available
	if($ssbpPreviousStart < intval($intTotalShares))
	{
		echo '<button class="ssbp-btn" id="ssbp-previous-shares">Previous</button>';
		$ssbpMarginTop = 'margin-top:-35px;';
	}
		
	// if the start is not 0
	if(isset($_POST['start']) && $_POST['start'] != 0)
		echo '<button class="ssbp-btn" id="ssbp-next-shares" style="float:right;">Next</button>';
		
	// calculate pages
	$intTotalPages = ceil($intTotalShares / 10);
	$intCurrentPage = ceil($ssbpCurrentStart / 10);
	$intCurrentPage = abs($intCurrentPage - $intTotalPages);

	echo '<div style="width:100%;text-align:center;'.$ssbpMarginTop.'"><b>Page '. $intCurrentPage. ' of ' .$intTotalPages.'</b></div>';

	// close div
	echo '</div>';
	
	// exit so no zeros are returned
	exit();
}

// delete a single share
function ssbp_delete_share($intID)
{
	// wpdb functionality
	global $wpdb;
	
	// the table we'll be querying
	$wpdb->ssbp_tracking = $wpdb->prefix . 'ssbp_tracking';

	// delete the share
	$wpdb->delete($wpdb->ssbp_tracking, array('id' => $intID));
}

// export csv of share stats
function ssbp_export_csv()
{
	// any errors would crash out
	error_reporting(0);
	
	// wpdb functionality
	global $wpdb;
	
	// the table we'll be querying
	$wpdb->ssbp_tracking = $wpdb->prefix . 'ssbp_tracking';	

	// create file name variable
	$ssbpFilename = 'SSBP Stats - '.date('Y-m-d').'.csv';

	// output headers so that the file is downloaded rather than displayed
	header("Cache-Control: must-revalidate, post-check=0, pre-check=0");
	header('Content-Description: File Transfer');
	header("Content-type: text/csv");
	header("Content-Disposition: attachment; filename=$ssbpFilename");
	header("Expires: 0");
	header("Pragma: public");
	
	$out = fopen('php://output', 'w');
	
	// get the shares
	$resultLatest = $wpdb->get_results("SELECT * FROM $wpdb->ssbp_tracking ORDER BY datetime ASC", ARRAY_A);
	
	// start a counter
	$count = 0;
	
	// loop over the rows, outputting them
	foreach($resultLatest as $row)
	{
		// add to counter
		$count++;

		// if the first row
		if($count == 1)
		{
			$arrHeadings = array(
									'Title',
									'URL',
									'Site',
									'Date',
									'IP',									
									'Country',
								);
			// add to csv
			fputcsv($out, $arrHeadings);
		}
		else
		{
			// decode the geoip data
			$arrGeoData = json_decode($row['geoip']);

			// content array
			$arrContent = array(
									$row['title'],
									$row['url'],
									$row['site'],
									$row['datetime'],
									$row['ip'],									
									(isset($arrGeoData->country) ? $arrGeoData->country : NULL),
								);
		
			// add to csv
			fputcsv($out, $arrContent);
		}
	}
	
	// close and exit, forcing download
	fclose($out);
	exit;
}

// get the top three
function ssbpTopThree() {
	
	// wpdb functionality
	global $wpdb;
	
	// the table we'll be querying
	$wpdb->ssbp_tracking = $wpdb->prefix . 'ssbp_tracking';

	// get the share count
	$resultTopThree = $wpdb->get_results("SELECT count(*) AS total_shares, title, url FROM $wpdb->ssbp_tracking GROUP BY title ORDER BY total_shares DESC", ARRAY_A);
	
	// return results
	return $resultTopThree;
}

// get the total number of posts/pages that have been shared
function ssbpGetSharedPageCount() {

	// wpdb functionality
	global $wpdb;
	
	// the table we'll be querying
	$wpdb->ssbp_tracking = $wpdb->prefix . 'ssbp_tracking';

	// get the share count
	$intTotalSharedPages = $wpdb->get_results("SELECT count(*) AS count FROM $wpdb->ssbp_tracking GROUP BY title");

	// return count
	return count($intTotalSharedPages);
}

// get total share count
function ssbpLatestShares() {
	
	// wpdb functionality
	global $wpdb;
	
	// the table we'll be querying
	$wpdb->ssbp_tracking = $wpdb->prefix . 'ssbp_tracking';

	// which results to get
	$ssbpStart = (isset($_POST['start']) ? $_POST['start'] : '0');

	// get the share count
	$resultLatest = $wpdb->get_results("SELECT * FROM $wpdb->ssbp_tracking ORDER BY datetime DESC LIMIT ".$ssbpStart.",10", ARRAY_A);
	
	// return results
	return $resultLatest;
}

// truncate tracking table
function ssbp_truncate_tracking()
{
	// wpdb functionality
	global $wpdb;
	
	// the table we'll be querying
	$wpdb->ssbp_tracking = $wpdb->prefix . 'ssbp_tracking';

	if($wpdb->query("TRUNCATE TABLE `$wpdb->ssbp_tracking`"))
	{
		update_option('ssbp_truncate_date', date('dS F Y'));
		echo '<div class="ssbp-updated"><p><strong>Successfully cleared sharing stats</p></div>';
	}	
	else
	{
		echo '<div class="ssbp-updated"><p><strong>Failed to clear sharing stats!</p></div>';	
	}
}

// get total share count
function ssbpTotalShareCount() {
	
	// wpdb functionality
	global $wpdb;
	
	// the table we'll be querying
	$wpdb->ssbp_tracking = $wpdb->prefix . 'ssbp_tracking';

	// get the share count
	$intTotalShares = $wpdb->get_row("SELECT COUNT(*) AS count FROM $wpdb->ssbp_tracking");
	
	// return count
	return $intTotalShares->count;
}

// get recent dates and share counts for google graph
function ssbpShareCountGraph() {
	
	// wpdb functionality
	global $wpdb;
	
	// the table we'll be querying
	$wpdb->ssbp_tracking = $wpdb->prefix . 'ssbp_tracking';
	
	// the date we'll start from, a week ago
	$dateStart = date('Y-m-d', strtotime('-6 days'));
	
	// the variable that shall be returned
	$jsShareCounts = '';

	// loop through the last 7 days and get details
	while ($dateStart <= date('Y-m-d')) {
	
		// get the share count
		$intDayShareCount = $wpdb->get_row("SELECT COUNT(*) AS count FROM $wpdb->ssbp_tracking WHERE datetime LIKE '%".$dateStart."%'");
	
		// add the day's share count to our array
		$jsShareCounts .= "['".date('l', strtotime($dateStart))."',  ".$intDayShareCount->count."],";

		// add a day to loop through next
		$dateStart = date('Y-m-d', strtotime($dateStart . '+1 day'));
	}
	
	// return the data we need
	return $jsShareCounts;
}

// get an html formatted of currently selected and ordered buttons
function getSelectedssbp($strSelectedssbp) {

	// variables
	$htmlSelectedList = '';
	$arrSelectedssbp = '';

	// if there are some selected buttons
	if ($strSelectedssbp != '') {
	
		// explode saved include list and add to a new array
		$arrSelectedssbp = explode(',', $strSelectedssbp);
		
		// check if array is not empty
		if ($arrSelectedssbp != '') {
		
			// for each included button
			foreach ($arrSelectedssbp as $strSelected) {
			
				// add a list item for each selected option
				$htmlSelectedList .= '<li class="ssbp-option-'.$strSelected.'" id="' . $strSelected . '">' . $strSelected . '</li>';
			}
		}
	}
	
	// return html list options
	return $htmlSelectedList;
}

// get an html formatted of currently selected and ordered buttons
function getAvailablessbp($strSelectedssbp) {

	// variables
	$htmlAvailableList = '';
	$arrSelectedssbp = '';
	
	// explode saved include list and add to a new array
	$arrSelectedssbp = explode(',', $strSelectedssbp);
	
	// create array of all available buttons
	$arrAllAvailablessbp = array('buffer', 'diggit', 'email', 'facebook', 'flattr', 'google', 'linkedin', 'pinterest', 'print', 'reddit', 'stumbleupon', 'tumblr', 'twitter', 'vk');
	
	// explode saved include list and add to a new array
	$arrAvailablessbp = array_diff($arrAllAvailablessbp, $arrSelectedssbp);
	
	// check if array is not empty
	if ($arrSelectedssbp != '') {
	
		// for each included button
		foreach ($arrAvailablessbp as $strAvailable) {
		
			// add a list item for each available option
			$htmlAvailableList .= '<li class="ssbp-option-'.$strAvailable.'" id="'.$strAvailable.'">'.$strAvailable.'</li>';
		}
	}
	
	// return html list options
	return $htmlAvailableList;
}

// display the main stats section for geoip
function ssbp_geoip_stats_callback() {

	// the geoip could take some time
	set_time_limit(0);

	// init geoip stats
	$ssbgStats = new ssbg_stats;

	// 50% div
	echo '<div style="width:48%; float:left;">';

	    // get the top five countries
		$ssbgTopFive = $ssbgStats->ssbg_top_five();
		
		// create a counter to list top 5
		$intTopFive = 0;

		// top countries heading
		echo '<h2>Top Countries</h2>';

		// open table
		echo '<table class="ssbg-top-five">';
		
			// loop through the top five countries
			foreach($ssbgTopFive as $ssbgTop) {
			
				// add 1 to the count
				$intTopFive++;
			
				// decode the geoip data
				$arrGeoIP = json_decode($ssbgTop['geoip']);

				// open row
				echo '<tr>';
				
					// if viewing the top country
					if($intTopFive == 1) {
						
						// top country
						echo '<td>';
							echo '<img src="' . plugins_url() . '/simple-share-buttons-plus/images/flags/'.$arrGeoIP->code.'.png' . '" class="ssbg-flag ssbg-flag-big" />';
						echo '</td>';
						echo '<td>';
							echo '<h3>1. '.$arrGeoIP->country.'</h3>';
							echo '<p><span class="ssbp-share-count-small">'.$ssbgTop['total_shares'].'</span> total shares</p>';
						echo '</td>';
						
					
					} else { // 2-5
						
						// 2-5 country details
						echo '<td>';
							echo '<p><b>'.$intTopFive.'. '.$arrGeoIP->country.'</b></p>';		
							echo '<p><span class="ssbp-share-count-small">'.$ssbgTop['total_shares'].'</span> total shares</p>';	
						echo '</td>';	
						echo '<td>';
							echo '<img src="' . plugins_url() . '/simple-share-buttons-plus/images/flags/'.$arrGeoIP->code.'.png' . '" class="ssbg-flag ssbg-flag-small" />';
						echo '</td>';		
					}

				// close row
				echo '</tr>';
			}
		
		// close table
		echo '</table>';

	// close div
	echo '</div>';

	// get the data for the countries pie chart
	$ssbgPieData = $ssbgStats->ssbg_pie_data();

	// 50% div
	echo '<div style="width:48%; float:right;">';

		// countries breakdown heading
		echo '<h2>Countries Breakdown</h2>';

		// add JS for the geoip pie chart
		echo '<script type="text/javascript" src="https://www.google.com/jsapi"></script>
		    <script type="text/javascript">
		      google.load("visualization", "1", {packages:["corechart"], "callback": drawChart});
		      google.setOnLoadCallback(drawChart);
		      function drawChart() {
		        var data = google.visualization.arrayToDataTable([
		          ["Country", "Total Shares"],';

		          	// define variable
		        	$strPieData = '';

		          	// loop through the top five countries
					foreach($ssbgPieData as $ssbgPie) {

						// decode the geoip data
						$arrGeoIP = json_decode($ssbgPie['geoip']);

						// add the data needed
						$strPieData .= "['".$arrGeoIP->country."', ".intval($ssbgPie['total_shares'])."],";
					}

					$strPieData = rtrim($strPieData, ",");

					echo $strPieData;
					
		        echo ']);

		        var options = {
		          title: "",
		        };

		        var chart = new google.visualization.PieChart(document.getElementById("piechart"));
		        chart.draw(data, options);
		      }
	    </script>';

	    echo '<div id="pie_wrap"><div id="piechart" style="width:600px;height:400px;"></div></div>';

	// close div
	echo '</div>';

	// exit so no zeros are returned
	exit();
}