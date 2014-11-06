<?php
defined('ABSPATH') or die("No direct access permitted");
	
	// get and show share buttons
	function ssbp_show_share_buttons($content, $booShortCode = FALSE, $atts = '') {
	
		// globals
		global $post;
		
		// variables
		$htmlContent = $content;
		$htmlShareButtons = '';
		$strIsWhatFunction = '';
		$pattern = get_shortcode_regex();

		// ssbp_hide shortcode is in the post content and instance is not called by shortcode ssbp
		if (preg_match_all( '/'. $pattern .'/s', $post->post_content, $matches )
			&& array_key_exists( 2, $matches )
			&& in_array('ssbp_hide', $matches[2]) 
			&& $booShortCode == FALSE) {
			
			// exit the function returning the content without the buttons
			return $content;
		}

		// get ssbp settings
		$arrSettings = get_ssbp_settings();

		// if option is set to use free version shortcode
		if($arrSettings['ssbp_use_ssba'] == 'Y') {

			// ssba_hide shortcode is in the post content and instance is not called by shortcode ssba
			if (preg_match_all( '/'. $pattern .'/s', $post->post_content, $matches )
				&& array_key_exists( 2, $matches )
				&& in_array('ssba_hide', $matches[2]) 
				&& $booShortCode == FALSE) {
				
				// exit the function returning the content without the buttons
				return $content;
			}
		}
		
		// if post types are not wanted
		if($arrSettings['ssbp_disabled_types'] != '') {
			
			// check if the current post type is not wanted
			if(in_array(get_post_type( get_the_ID()), explode(',', $arrSettings['ssbp_disabled_types'])))
				return $content; 
		}

		// placement on pages/posts/categories/archives/homepage
		if ((!is_home() && !is_front_page() && is_page() && $arrSettings['ssbp_pages'] == 'Y') || (is_single() && $arrSettings['ssbp_posts'] == 'Y') || (is_category() && $arrSettings['ssbp_cats_archs'] == 'Y') || (is_archive() && $arrSettings['ssbp_cats_archs'] == 'Y') || ((is_home() || is_front_page() ) && $arrSettings['ssbp_homepage'] == 'Y') || $booShortCode == TRUE || is_search()) {
						
			// ssbp comment
			$htmlShareButtons = '<!-- Simple Share Buttons Plus (v0.4.2) simplesharebuttons.com/plus -->';
				
			// ssbp wrap
			$htmlShareButtons .= '<div class="ssbp-wrap">';
			
				// if widget
				if (isset($atts['widget']) && $atts['widget'] == 'Y')
					// use widget share text
					$strShareText = $arrSettings['ssbp_widget_text'];
				else 								
					// use normal share text
					$strShareText = $arrSettings['ssbp_share_text'];
				
				// if running standard
				if ($booShortCode == FALSE) {
	
					// use wordpress functions for page/post details
					$urlCurrentPage = get_permalink($post->ID);
					$strPageTitle = esc_attr( strip_tags( get_the_title($post->ID) ));
	
				} else { // using shortcode
	
						// set page URL and title as set by user or get if needed
						$urlCurrentPage = (isset($atts['url']) ? $atts['url'] : ssbp_current_url());
						$strPageTitle = (isset($atts['title']) ? $atts['title'] : get_the_title());
				}
		
				// if ortsh is enabled
				if($arrSettings['ssbp_ortsh_enabled'] == 'Y')
				{
					// retrieve our license key from the DB
					$ssbpLicense_key = trim( get_option( 'ssbp_license_key' ) );
					
					// check license key is there
					if($ssbpLicense_key && $ssbpLicense_key != '')
					{
						// shorten the URL
						$urlShortened = ssbp_ortsh_shorten($ssbpLicense_key, $urlCurrentPage, $strPageTitle);
					}
				}
				// if both bitly details are set
				elseif($arrSettings['ssbp_bitly_login'] != '' && $arrSettings['ssbp_bitly_api_key'] != '')
				{
					// shorten the URL
					$urlShortened = ssbp_bitly_shorten($arrSettings['ssbp_bitly_login'], $arrSettings['ssbp_bitly_api_key'], $urlCurrentPage);
				}

				// if post type is download (EDD clashes)
				if(get_post_type( get_the_ID()) == "download") {
					
					// check for and remove added text
				    preg_match_all("/>(.*?)>/", $strPageTitle, $matches);
				    $title =  $matches[0][0];
				    $title = ltrim($title, '>');
				    $title = rtrim ($title, '</span>');
				    $strPageTitle = $title;
				}
				
				// ssbp div
				$htmlShareButtons .= '<div class="ssbp-container" data-ssbp-share-text="'.$strShareText.'" data-ssbp-url="'.$urlCurrentPage.'" data-ssbp-title="'.$strPageTitle.'" data-ssbp-short-url="'.$urlShortened.'">';
				
				// if lazy load is not enabled
				if($arrSettings['ssbp_lazy_load'] != 'Y') {

					// initiate ssbp button class
					$ssbpButtons = new ssbpShareButtons;
					
					// the buttons!
					$htmlShareButtons.= $ssbpButtons->get_ssbp_buttons($urlCurrentPage, $strPageTitle, $strShareText, $urlShortened);
					
					// if total share count type is chosen
					if($ssbpButtons->arrSettings['ssbp_counters_type'] == 'total' && $ssbpButtons->arrSettings['ssbp_counters_enabled'] == 'Y') {
					
						// add total share count
						$htmlShareButtons.= '<span class="ssbp-total-shares"><b>'.ssbp_format_number($ssbpButtons->ssbpTotalShareCount).'</b></span>';
					}
				}
				
				// close container div
				$htmlShareButtons.= '</div>';
				
			// close wrap div
			$htmlShareButtons.= '</div>';
			
			// if not using shortcode
			if ($booShortCode == FALSE) {
			
				// switch for placement of ssbp
				switch ($arrSettings['ssbp_before_or_after']) {
				
					case 'before': // before the content
					$htmlContent = $htmlShareButtons . $content;
					break;
					
					case 'after': // after the content
					$htmlContent = $content . $htmlShareButtons;
					break;
					
					case 'both': // before and after the content
					$htmlContent = $htmlShareButtons . $content . $htmlShareButtons;
					break;
				}
			}
			
			// if using shortcode
			else {
			
				// just return buttons
				$htmlContent = $htmlShareButtons;
			}
		}
		
		// return content and share buttons
		return $htmlContent;
	}

	

	// shortcode for adding buttons
	function ssbp_buttons($atts) {
	
		// get buttons - NULL for $content, TRUE for shortcode flag
		$htmlShareButtons = ssbp_show_share_buttons(NULL, TRUE, $atts);
		
		//return buttons
		return $htmlShareButtons;
	}
	
	// shortcode for hiding buttons
	function ssbp_hide($content) {

	}
	
	// get URL function
	function ssbp_current_url() {
	
		// add http
		$urlCurrentPage = 'http';

		// add s to http if required
		if (isset($_SERVER["HTTPS"]) && $_SERVER["HTTPS"] == "on") {$urlCurrentPage .= "s";}

		// add colon and forward slashes
		$urlCurrentPage .= "://".$_SERVER["SERVER_NAME"].$_SERVER["REQUEST_URI"];

		// return url
		return $urlCurrentPage;
	}
	
	// shorten url with ortsh
	function ssbp_ortsh_shorten($ssbpLicense_key, $urlLong, $strPageTitle)
	{
		// try to get the ortshened key
		$ssbpOrtshURL = get_option('ortsh_'.md5($urlLong));

		// if this URL hasn't already been ortshened
		if( ! $ssbpOrtshURL)
		{
			// encryption key
			$ssbpKey = '14h4zgXG238Y7zTh9ElEVU1oy1254FkX4321'.date('Ym');
	
			// securely encrypt the license key
			$ssbpLicense_key = base64_encode(mcrypt_encrypt(MCRYPT_RIJNDAEL_256, md5($ssbpKey), $ssbpLicense_key, MCRYPT_MODE_CBC, md5(md5($ssbpKey))));

			// get results from ortsh
			$htmlOrtsh = wp_remote_post('http://ort.sh/create', array(
																'method' => 'POST',
																'timeout' => 3,
																'body' => array(
																			'url' => $urlLong,
																			'license' => $ssbpLicense_key,
																			'title' => $strPageTitle
																			)
																));
															
			// check there was an error
			if( is_wp_error($htmlOrtsh))
				return $urlLong; // return urllong so we can still load buttons
			
			// decode
			$arrOrtsh = json_decode($htmlOrtsh['body'], true);

			// check the response was successful
			if($arrOrtsh['status'] == 'success' && isset($arrOrtsh['ortsh_key']))
			{
				// prepare data
				$arrOrtshData = array(
									'url' => $urlLong,
									'title' => $strPageTitle,
									'ortsh_key' => $arrOrtsh['ortsh_key']
								);

				// save ortsh data
				add_option('ortsh_'.md5($urlLong), json_encode($arrOrtshData));
				
				// prepare ortsh url
				$urlShort = 'http://ort.sh/'.$arrOrtsh['ortsh_key'];
				
				// return ortsh url
				return $urlShort;
			}	
			else
			{
				return $urlLong;
			}
		}
		else
		{
			// decode and prepare the url
			$objOrtsh = json_decode($ssbpOrtshURL);
			$urlShort = 'http://ort.sh/'.$objOrtsh->ortsh_key;

			// return the url
			return $urlShort;
		}
	}
	
	// shorten URL with bit.ly
	function ssbp_bitly_shorten($ssbpBitlyLogin, $ssbpBitlyAPIKey, $urlLong)
	{
		// try to get the bitly url
		$ssbpBitlyURL = get_option('ssbp_bl_'.md5($urlLong));

		// if this URL hasn't already been shortened
		if( ! $ssbpBitlyURL)
		{
			// get results from bitly
			$hmtlBitly = wp_remote_get('http://api.bit.ly/v3/shorten?login='.$ssbpBitlyLogin.'&apiKey='.$ssbpBitlyAPIKey.'&longUrl=' . $urlLong, array( 'timeout' => 3));
			$arrBitly = json_decode($hmtlBitly['body'], true);

			// check a URL is returned
			if(isset($arrBitly['data']['url']))
			{
				$urlShort =  $arrBitly['data']['url'];
				add_option('ssbp_bl_'.md5($urlLong), $urlShort);
				return $urlShort;
			}	
			else
			{
				return $urlLong;
			}
		}
		else
		{
			return $ssbpBitlyURL;
		}
	}