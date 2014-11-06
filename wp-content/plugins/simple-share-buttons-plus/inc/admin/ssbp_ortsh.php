<?php
defined('ABSPATH') or die("No direct access permitted");

function ssbp_ortsh_dashboard($arrSettings, $htmlSettingsSaved)
{
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
			
				//------ ORTSH TAB -------//
				$htmlShareButtonsForm .= '<h2 class="ssbp-heading-ortsh">ort.sh</h2>';
				$htmlShareButtonsForm .= '<table class="form-table">';
					$htmlShareButtonsForm .= '<tr valign="top">';
						$htmlShareButtonsForm .= '<th scope="row" style="width: 150px;"><label for="ssbp_ortsh_enabled">Enable ort.sh:</label></th>';
						$htmlShareButtonsForm .= '<td>';
						$htmlShareButtonsForm .= SSBP_LANG_YES.'&nbsp;<input type="checkbox" name="ssbp_ortsh_enabled" id="ssbp_ortsh_enabled" ' . ($arrSettings['ssbp_ortsh_enabled'] == 'Y'  ? 'checked' : NULL) . ' value="Y" style="margin-right: 10px;" />';
						$htmlShareButtonsForm .= '<p class="description">Enable URL shortening via <b><a href="http://ort.sh" target="_blank">ort.sh</a></b>. <b>Valid licenses only</b></p></td>';
					$htmlShareButtonsForm .= '</tr>';
				$htmlShareButtonsForm .= '</table>';
					
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
		
		// if ortsh is enabled
		if($arrSettings['ssbp_ortsh_enabled'] == 'Y')
		{
		
			// ortsh urls
			$htmlShareButtonsForm .= '<div class="welcome-panel ssbp-section">';
			$htmlShareButtonsForm .= '<div class="welcome-panel-content">';
			
				// get ortsh urls data ready
				$ortshURLs = get_ortsh_urls();
			
				// the container to replace with content
				$htmlShareButtonsForm .= '<div class="ssbp-total-container"><h2 class="ssbp-heading-ortsh">ort.sh URLs</h2>';	
					
					// start table
					$htmlShareButtonsForm .= '<table class="ssbp-latest-shares">';
					
						// table headings
						$htmlShareButtonsForm .= '<tr>';
							$htmlShareButtonsForm .= '<th>Post/Page</th>';
							$htmlShareButtonsForm .= '<th>Full URL</th>';
							$htmlShareButtonsForm .= '<th>ort.sh URL</th>';
						$htmlShareButtonsForm .= '</tr>';
						
						// if no ortsh urls are there yet
						if(count($ortshURLs) == 0)
						{
							$htmlShareButtonsForm .= '<tr>';
								$htmlShareButtonsForm .= '<td colspan="3">No ort.sh URLs are currently set. Once enabled they are created when each post/page is visited.</td>';
							$htmlShareButtonsForm .= '</tr>';
						}
						else
						{
							// loop through each ortsh url
							foreach($ortshURLs as $ortshURL)
							{
								//json decode the data
								$ortshURL = json_decode($ortshURL->option_value);
	
								// new row
								$htmlShareButtonsForm .= '<tr>';
	
									// output the details for each
									$htmlShareButtonsForm .= '<td>'.$ortshURL->title.'</td>';
									$htmlShareButtonsForm .= '<td><a href="'.$ortshURL->url.'" target="_blank">'.$ortshURL->url.'</a></td>';
									$htmlShareButtonsForm .= '<td><input class="ssbp-ortsh-input-url" type="text" value="http://ort.sh/'.$ortshURL->ortsh_key.'" /></td>';
								
								// close row
								$htmlShareButtonsForm .= '</tr>';
							}
						}			
					
					// close table
					$htmlShareButtonsForm .= '</table>';
					
				// close urls div
				$htmlShareButtonsForm .= '</div>';					
										
			// close welcome panel
			$htmlShareButtonsForm .= '</div>';
			$htmlShareButtonsForm .= '</div>';
		}

		// html form
		$htmlShareButtonsForm .= '<div class="welcome-panel ssbp-section">';
		$htmlShareButtonsForm .= '<div class="welcome-panel-content">';
		
			// the container to replace with content
			$htmlShareButtonsForm .= '<div class="ssbp-total-container"><h2 class="ssbp-heading-ortsh-stats">ort.sh Stats</h2>';	
				$htmlShareButtonsForm .= '<div class="centerme" style="margin-bottom:50px;"><h2>Coming Soon...</h2><p class="description">All visits in the meantime will be stored!</p></div>';	
			$htmlShareButtonsForm .= '</div>';					
									
		// close welcome panel
		$htmlShareButtonsForm .= '</div>';
		$htmlShareButtonsForm .= '</div>';
		
	//close wrap
	$htmlShareButtonsForm .= '</div>';
	
	echo $htmlShareButtonsForm;
}

// get ortsh urls
function get_ortsh_urls()
{
	// globals
	global $wpdb;
	
	// query the db for current ssbp settings
	$objOrtsh = $wpdb->get_results("SELECT option_value
										 FROM $wpdb->options 
										WHERE option_name LIKE 'ortsh_%'");

	// return
	return $objOrtsh;	
}