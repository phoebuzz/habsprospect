<?php
defined('ABSPATH') or die("No direct access permitted");

	// ajax call load share buttons
	function ssbp_lazy_callback() {
		
		// initiate ssbp button class
		$ssbpButtons = new ssbpShareButtons;
		
		// the buttons!
		echo $ssbpButtons->get_ssbp_buttons($_POST['ssbpurl'], $_POST['ssbptitle'], $_POST['ssbpsharetext'], $_POST['ssbpshorturl']);
		
		// if total share count type is chosen
		if($ssbpButtons->arrSettings['ssbp_counters_type'] == 'total' && $ssbpButtons->arrSettings['ssbp_counters_enabled'] == 'Y') {
		
			// if the minimum share count has been met
			if($ssbpButtons->ssbpTotalShareCount >= intval($ssbpButtons->arrSettings['ssbp_min_shares']))
			{
				// add total share count
				echo '<span class="ssbp-total-shares"><b>'.ssbp_format_number($ssbpButtons->ssbpTotalShareCount).'</b></span>';
			}
		}

		// exit so zero is not returned
		exit;
	}
	
	// format the returned number
	function ssbp_format_number($intNumber) {
		
		// if the number is greater than or equal to 1000
		if($intNumber >= 1000) {
		
			// divide by 1000 and add k
			$intNumber = round(($intNumber / 1000), 1).'k';
		}
		
		// return the number
		return $intNumber;
	}
	
// the main share buttons class
class ssbpShareButtons {
	
	// declare variables
	public $htmlShareButtons = '';
	public $booShowShareCount = false;
	public $arrSettings;
	public $strPageTitle;
	public $urlCurrentPage;
	
	// count variables
	public $ssbpTotalShareCount = 0;
	public $ssbpFacebookShareCount = 0;
	public $ssbpGoogleShareCount = 0;
	public $ssbpLinkedinShareCount = 0;
	public $ssbpPinterestShareCount = 0;
	public $ssbpRedditShareCount = 0;
	public $ssbpStumbleUponShareCount = 0;
	public $ssbpTwitterShareCount = 0;
	public $ssbpVKShareCount = 0;
	
	// construct buttons function
	public function ssbpShareButtons() {
		
		// get ssbp settings
		$this->arrSettings = get_ssbp_settings();
	}
	
	// the buttons themselves
	public function get_ssbp_buttons($urlCurrentPage, $strPageTitle, $strShareText, $urlShortened = '') {
	
		// variables
		$this->strPageTitle = $strPageTitle;
		$this->urlCurrentPage = $urlCurrentPage;
		$this->urlShortened = $urlShortened;

		// share text is above or left
		if($this->arrSettings['ssbp_text_placement'] == 'above' || $this->arrSettings['ssbp_text_placement'] == 'left')
		{
			
			// share text
			$this->htmlShareButtons .= ($strShareText != '' ? '<span class="ssbp-share-text">'.stripslashes_deep($strShareText).'</span>' : NULL);
			
			// share text is above
			if($this->arrSettings['ssbp_text_placement'] == 'above' && $strShareText != '') {

				// add a line break
				$this->htmlShareButtons .= '<br />';
			}
		}
		
		// explode saved include list and add to a new array
		$this->arrSelectedSSBP = explode(',', $this->arrSettings['ssbp_selected_buttons']);
		
		// check if array is not empty
		if ($this->arrSettings['ssbp_selected_buttons'] != '') {
		
			// for each included button
			foreach ($this->arrSelectedSSBP as $strSelected) {
			
				// prepare function name
				$strGetButton = 'ssbp_' . $strSelected;
			
				// add a list item for each selected option
				$this->$strGetButton();
			}
		}
		
		// share text is right or below
		if($this->arrSettings['ssbp_text_placement'] == 'right' || $this->arrSettings['ssbp_text_placement'] == 'below') {
		
			// share text is below
			if($this->arrSettings['ssbp_text_placement'] == 'below' && $strShareText != '') {

				// add a line break
				$this->htmlShareButtons .= '<br />';
			}
			
			// share text
			$this->htmlShareButtons .= ($strShareText != '' ? '<span class="ssbp-share-text">'.stripslashes_deep($strShareText).'</span>' : NULL);
		}
		
		// return share buttons
		return $this->htmlShareButtons;
	}
	
	// get buffer button
	function ssbp_buffer() {
	
		// buffer share link
		$this->htmlShareButtons .= '<a href="https://bufferapp.com/add?url='.$this->urlCurrentPage.'&amp;text=' . ($this->arrSettings['ssbp_buffer_text'] != '' ? $this->arrSettings['ssbp_buffer_text'] : NULL) . ' ' . $this->strPageTitle . '" class="ssbp-btn ssbp-buffer" ' .  ($this->arrSettings['ssbp_rel_nofollow'] == 'Y' ? 'rel="nofollow"' : NULL) . ' data-ssbp-title="'.$this->strPageTitle.'" data-ssbp-url="'.$this->urlCurrentPage.'" data-ssbp-site="Buffer">';
		
		// not using custom images
		if($this->arrSettings['ssbp_custom_images'] != 'Y')
			$this->htmlShareButtons .= '<span class="ssbp-text">Buffer</span>';
		else // using custom images
			$this->htmlShareButtons .= '<img src="'.$this->arrSettings['ssbp_custom_buffer'].'" title="Buffer this page" class="ssbp" alt="Buffer this page" />';		

		// close link
		$this->htmlShareButtons .= '</a>';
	}
	
	// get diggit button
	function ssbp_diggit() {
	
		// diggit share link
		$this->htmlShareButtons .= '<a href="http://www.digg.com/submit?url='.$this->urlCurrentPage. '" class="ssbp-btn ssbp-digg" ' .  ($this->arrSettings['ssbp_rel_nofollow'] == 'Y' ? 'rel="nofollow"' : NULL) . ' data-ssbp-title="'.$this->strPageTitle.'" data-ssbp-url="'.$this->urlCurrentPage.'" data-ssbp-site="Digg">';
		
		// not using custom images
		if($this->arrSettings['ssbp_custom_images'] != 'Y')
			$this->htmlShareButtons .= '<span class="ssbp-text">Diggit</span>';
		else // using custom images
			$this->htmlShareButtons .= '<img src="'.$this->arrSettings['ssbp_custom_diggit'].'" title="Digg this page" class="ssbp" alt="Digg this page" />';		

		// close link
		$this->htmlShareButtons .= '</a>';
	}
	
	// get email button
	function ssbp_email() {
	
		// email share link
		$this->htmlShareButtons .= '<a href="mailto:?Subject=' . $this->strPageTitle . '&amp;Body=' . $this->arrSettings['ssbp_email_message'] . '%20' . ($this->urlShortened == '' ? $this->urlCurrentPage : $this->urlShortened)  . '" class="ssbp-btn ssbp-email" data-ssbp-title="'.$this->strPageTitle.'" data-ssbp-url="'.$this->urlCurrentPage.'" data-ssbp-site="Email">';
		
		// not using custom images
		if($this->arrSettings['ssbp_custom_images'] != 'Y')
			$this->htmlShareButtons .= '<span class="ssbp-text">Email</span>';
		else // using custom images
			$this->htmlShareButtons .= '<img src="'.$this->arrSettings['ssbp_custom_email'].'" title="Email this page" class="ssbp" alt="Email this page" />';		

		// close link
		$this->htmlShareButtons .= '</a>';
	}
	
	// get facebook button
	function ssbp_facebook() {
	
		// facebook share link
		$this->htmlShareButtons .= '<a href="http://www.facebook.com/sharer.php?u='.$this->urlCurrentPage.'" class="ssbp-btn ssbp-facebook" ' .  ($this->arrSettings['ssbp_rel_nofollow'] == 'Y' ? ' rel="nofollow"' : NULL) .' data-ssbp-title="'.$this->strPageTitle.'" data-ssbp-url="'.$this->urlCurrentPage.'" data-ssbp-site="Facebook">';
		
		// not using custom images
		if($this->arrSettings['ssbp_custom_images'] != 'Y')
			$this->htmlShareButtons .= '<span class="ssbp-text">Facebook</span>';
		else // using custom images
			$this->htmlShareButtons .= '<img src="'.$this->arrSettings['ssbp_custom_facebook'].'" title="Share this on Facebook" class="ssbp" alt="Share this on Facebook" />';		

		// close link
		$this->htmlShareButtons .= '</a>';
		
		// if share counts are enabled
		if($this->arrSettings['ssbp_counters_enabled'] == 'Y') {

			// unique facebook key for this URL
			$key = 'ssbp_fb_'.md5($this->urlCurrentPage);

			// get transient if set
			$this->ssbpFacebookShareCount = get_transient($key);

			// if no transient
			if( ! $this->ssbpFacebookShareCount) {
			
				// if using ssbp api
				if($this->arrSettings['ssbp_share_api'] == 'Y')
				{
					// retrieve our license key from the DB
					$ssbpLicense_key = trim( get_option( 'ssbp_license_key' ) );
					
					// check license key is there
					if($ssbpLicense_key && $ssbpLicense_key != '')
					{
						$this->ssbpFacebookShareCount = 0;
					}

					// encryption key
					$ssbpKey = 'j7PYc7+iLtkVsHgltSQKC5781ljciwfwBAc1'.date('Ym');
			
					$ssbpLicense_key = base64_encode(mcrypt_encrypt(MCRYPT_RIJNDAEL_256, md5($ssbpKey), $ssbpLicense_key, MCRYPT_MODE_CBC, md5(md5($ssbpKey))));

					// get results from ssbp api
					$htmlSSBPAPI = wp_remote_post('https://simplesharebuttons.com/api/', array(
																		'method' => 'POST',
																		'timeout' => 4,
																		'body' => array(
																					'url' => $this->urlCurrentPage,
																					'license' => $ssbpLicense_key,
																					'action' => 'facebook_share_count'
																					)
																		));

					// check there was an error
					if(is_wp_error($htmlSSBPAPI))
					{
						$this->ssbpFacebookShareCount = 0;
					}
					else
					{
						// decode
						$arrSSBPAPI = json_decode($htmlSSBPAPI['body'], true);
	
						// check the response was successful
						if($arrSSBPAPI['status'] == 'success' && isset($arrSSBPAPI['share_count']))
						{
							$this->ssbpFacebookShareCount = $arrSSBPAPI['share_count'];
							
							// transient timeout minimum for ssbp api
							$ssbpCache = (intval($this->arrSettings['ssbp_count_cache']) > 600 ? $this->arrSettings['ssbp_count_cache'] : 600);
							
							// set transient
							set_transient($key,  $this->ssbpFacebookShareCount, $ssbpCache);
						}	
						else
						{
							$this->ssbpFacebookShareCount = 0;
						}
					}									
				}
				
				else
				{
					// get results from facebook and return the number of shares
				    $htmlFacebookShareDetails = wp_remote_get('http://graph.facebook.com/' . $this->urlCurrentPage, array( 'timeout' => $this->arrSettings['ssbp_count_timeout']));
				    
				    // if no error
				    if( ! is_wp_error($htmlFacebookShareDetails))
				    {
					    $arrFacebookShareDetails = json_decode($htmlFacebookShareDetails['body'], true);
					    $intFacebookShareCount =  (isset($arrFacebookShareDetails['shares']) ? $arrFacebookShareDetails['shares'] : 0);
					    $this->ssbpFacebookShareCount = ($intFacebookShareCount ) ? $intFacebookShareCount : '0';
	
					    // set transient
					    set_transient($key,  $this->ssbpFacebookShareCount, $this->arrSettings['ssbp_count_cache']);
				    }
				    else // there was an error
				    {
					    $this->ssbpFacebookShareCount = 0;
				    }
				}
			}
		    
		    // if each share count type is chosen
			if($this->arrSettings['ssbp_counters_type'] == 'each' && $this->ssbpFacebookShareCount >= intval($this->arrSettings['ssbp_min_shares'])) {
			
				// add total share count
				$this->htmlShareButtons .= '<span class="ssbp-total-shares ssbp-total-facebook-shares ssbp-each-share">'.ssbp_format_number($this->ssbpFacebookShareCount).'</span>';
			}
		    
		    // add the facebook share count to the total
		    $this->ssbpTotalShareCount = ($this->ssbpTotalShareCount + $this->ssbpFacebookShareCount);
		}
	}
	
	// get flattr button
	function ssbp_flattr() {
	
		// check for dedicated flattr URL
		if ($this->arrSettings['ssbp_flattr_url'] != '') {
		
			// update url to specified URL
			$this->urlCurrentPage = $this->arrSettings['ssbp_flattr_url'];
		}
	
		// flattr share link
		$this->htmlShareButtons .= '<a href="https://flattr.com/submit/auto?user_id=' . $this->arrSettings['ssbp_flattr_user_id'] . '&amp;title=' . $this->strPageTitle . '&amp;url=' . $this->urlCurrentPage . '" class="ssbp-btn ssbp-flattr" ' .  ($this->arrSettings['ssbp_rel_nofollow'] == 'Y' ? 'rel="nofollow"' : NULL) . ' data-ssbp-title="'.$this->strPageTitle.'" data-ssbp-url="'.$this->urlCurrentPage.'" data-ssbp-site="Flattr">';
		
		// not using custom images
		if($this->arrSettings['ssbp_custom_images'] != 'Y')
			$this->htmlShareButtons .= '<span class="ssbp-text">Flattr</span>';
		else // using custom images
			$this->htmlShareButtons .= '<img src="'.$this->arrSettings['ssbp_custom_flattr'].'" title="Flattr this" class="ssbp" alt="Flattr this" />';

		// close link
		$this->htmlShareButtons .= '</a>';
	}
	
	// get google+ button
	function ssbp_google() {
	
		// google share link
		$this->htmlShareButtons .= '<a href="https://plus.google.com/share?url='.$this->urlCurrentPage. '" class="ssbp-btn ssbp-google" ' .  ($this->arrSettings['ssbp_rel_nofollow'] == 'Y' ? 'rel="nofollow"' : NULL) . ' data-ssbp-title="'.$this->strPageTitle.'" data-ssbp-url="'.$this->urlCurrentPage.'" data-ssbp-site="Google+">';
		
		// not using custom images
		if($this->arrSettings['ssbp_custom_images'] != 'Y')
			$this->htmlShareButtons .= '<span class="ssbp-text">Google+</span>';
		else // using custom images
			$this->htmlShareButtons .= '<img src="'.$this->arrSettings['ssbp_custom_google'].'" title="Share this on Google+" class="ssbp" alt="Share this on Google+" />';

		// close link
		$this->htmlShareButtons .= '</a>';
		
		// if share counts are enabled
		if($this->arrSettings['ssbp_counters_enabled'] == 'Y') {

			// unique google key for this URL
			$key = 'ssbp_gp_'.md5($this->urlCurrentPage);

			// get transient if set
			$this->ssbpGoogleShareCount = get_transient($key);

			// if no transient
			if( ! $this->ssbpGoogleShareCount) {
			
				$args = array(
		            'method' => 'POST',
		            'headers' => array(
		                // setup content type to JSON 
		                'Content-Type' => 'application/json'
		            ),
		            // setup POST options to Google API
		            'body' => json_encode(array(
		                'method' => 'pos.plusones.get',
		                'id' => 'p',
		                'method' => 'pos.plusones.get',
		                'jsonrpc' => '2.0',
		                'key' => 'p',
		                'apiVersion' => 'v1',
		                'params' => array(
		                    'nolog'=>true,
		                    'id'=> $this->urlCurrentPage,
		                    'source'=>'widget',
		                    'userId'=>'@viewer',
		                    'groupId'=>'@self'
		                ) 
		             )),
		             // disable checking SSL sertificates               
		            'sslverify'=>false
		        );
		     
			    // retrieves JSON with HTTP POST method for current URL  
			    $json_string = wp_remote_post("https://clients6.google.com/rpc", $args);
			     
			    if (is_wp_error($json_string)){
			        // return zero if response is error                             
			        $this->ssbpGoogleShareCount = "0";             
			    } else {        
			        $json = json_decode($json_string['body'], true);
	                 
			        // return count of Google +1 for requsted URL
			        $this->ssbpGoogleShareCount = intval( $json['result']['metadata']['globalCounts']['count'] );

			        // set transient
		   			set_transient($key,  $this->ssbpGoogleShareCount, $this->arrSettings['ssbp_count_cache']);
			    }
			}

		    // add the google share count to the total
			$this->ssbpTotalShareCount = ($this->ssbpTotalShareCount + $this->ssbpGoogleShareCount);
		    
		    // if each share count type is chosen
			if($this->arrSettings['ssbp_counters_type'] == 'each' && $this->ssbpGoogleShareCount >= intval($this->arrSettings['ssbp_min_shares'])) {
			
				// add total share count
				$this->htmlShareButtons .= '<span class="ssbp-total-shares ssbp-total-google-shares ssbp-each-share">'.ssbp_format_number($this->ssbpGoogleShareCount).'</span>';
			}
		}
	}
	
	// get linkedin button
	function ssbp_linkedin() {
	
		// linkedin share link
		$this->htmlShareButtons .= '<a href="http://www.linkedin.com/shareArticle?mini=true&amp;url='.$this->urlCurrentPage. '" class="ssbp-btn ssbp-linkedin" ' .  ($this->arrSettings['ssbp_rel_nofollow'] == 'Y' ? 'rel="nofollow"' : NULL) . ' data-ssbp-title="'.$this->strPageTitle.'" data-ssbp-url="'.$this->urlCurrentPage.'" data-ssbp-site="LinkedIn">';
		
		// not using custom images
		if($this->arrSettings['ssbp_custom_images'] != 'Y')
			$this->htmlShareButtons .= '<span class="ssbp-text">Linkedin</span>';
		else // using custom images
			$this->htmlShareButtons .= '<img src="'.$this->arrSettings['ssbp_custom_linkedin'].'" title="Share this on Linkedin" class="ssbp" alt="Share this on Linkedin" />';

		// close link
		$this->htmlShareButtons .= '</a>';
		
		// if share counts are enabled
		if($this->arrSettings['ssbp_counters_enabled'] == 'Y') {

			// unique linkedin key for this URL
			$key = 'ssbp_li_'.md5($this->urlCurrentPage);

			// get transient if set
			$this->ssbpLinkedinShareCount = get_transient($key);

			// if no transient
			if( ! $this->ssbpLinkedinShareCount) {
			
				// get results from linkedin and return the number of shares		    
			    $htmlLinkedinShareDetails = wp_remote_get('http://www.linkedin.com/countserv/count/share?url=' . $this->urlCurrentPage, array( 'timeout' => $this->arrSettings['ssbp_count_timeout']));
				$htmlLinkedinShareDetails = str_replace('IN.Tags.Share.handleCount(', '', $htmlLinkedinShareDetails);
			    $htmlLinkedinShareDetails = str_replace(');', '', $htmlLinkedinShareDetails);
			    $arrLinkedinShareDetails = json_decode($htmlLinkedinShareDetails['body'], true);
			    $intLinkedinShareCount =  $arrLinkedinShareDetails['count'];
			    $this->ssbpLinkedinShareCount =  ($intLinkedinShareCount ) ? $intLinkedinShareCount : '0';

			    // set transient
		    	set_transient($key,  $this->ssbpLinkedinShareCount, $this->arrSettings['ssbp_count_cache']);
			}
		    
		    // if each share count type is chosen
			if($this->arrSettings['ssbp_counters_type'] == 'each' && $this->ssbpLinkedinShareCount >= intval($this->arrSettings['ssbp_min_shares'])) {
			
				// add total share count
				$this->htmlShareButtons .= '<span class="ssbp-total-shares ssbp-total-linkedin-shares ssbp-each-share">'.ssbp_format_number($this->ssbpLinkedinShareCount).'</span>';
			}
		    
		    // add the linkedin share count to the total
		    $this->ssbpTotalShareCount = ($this->ssbpTotalShareCount + $this->ssbpLinkedinShareCount);
		}
	}
	
	// get pinterest button
	function ssbp_pinterest() {
	
		// pinterest share link
		$this->htmlShareButtons .= "<a href='javascript:void((function()%7Bvar%20e=document.createElement(&apos;script&apos;);e.setAttribute(&apos;type&apos;,&apos;text/javascript&apos;);e.setAttribute(&apos;charset&apos;,&apos;UTF-8&apos;);e.setAttribute(&apos;src&apos;,&apos;//assets.pinterest.com/js/pinmarklet.js?r=&apos;+Math.random()*99999999);document.body.appendChild(e)%7D)());' class='ssbp-btn ssbp-pinterest' data-ssbp-title='".$this->strPageTitle."' data-ssbp-url=".$this->urlCurrentPage." data-ssbp-site='Pinterest'>";
		
		// not using custom images
		if($this->arrSettings['ssbp_custom_images'] != 'Y')
			$this->htmlShareButtons .= '<span class="ssbp-text">Pinterest</span>';
		else // using custom images
			$this->htmlShareButtons .= '<img src="'.$this->arrSettings['ssbp_custom_pinterest'].'" title="Pin this page" class="ssbp" alt="Pin this page" />';

		// close link
		$this->htmlShareButtons .= '</a>';
		
		// if share counts are enabled
		if($this->arrSettings['ssbp_counters_enabled'] == 'Y') {

			// unique pinterest key for this URL
			$key = 'ssbp_pi_'.md5($this->urlCurrentPage);

			// get transient if set
			$this->ssbpPinterestShareCount = get_transient($key);

			// if no transient
			if( ! $this->ssbpPinterestShareCount) {
			
				// get results from pinterest and return the number of shares		    
			    $htmlPinterestShareDetails = wp_remote_get('http://api.pinterest.com/v1/urls/count.json?url=' . $this->urlCurrentPage, array( 'timeout' => $this->arrSettings['ssbp_count_timeout']));

			    $htmlPinterestShareDetails = str_replace('receiveCount(', '', $htmlPinterestShareDetails);
			    $htmlPinterestShareDetails = str_replace(')', '', $htmlPinterestShareDetails);
			    $arrPinterestShareDetails = json_decode($htmlPinterestShareDetails['body'], true);
			    $intPinterestShareCount =  $arrPinterestShareDetails['count'];
			    $this->ssbpPinterestShareCount = ($intPinterestShareCount ) ? $intPinterestShareCount : '0';

			    // set transient
		    	set_transient($key,  $this->ssbpPinterestShareCount, $this->arrSettings['ssbp_count_cache']);
			}
		    
		    // if each share count type is chosen
			if($this->arrSettings['ssbp_counters_type'] == 'each' && $this->ssbpPinterestShareCount >= intval($this->arrSettings['ssbp_min_shares'])) {
			
				// add total share count
				$this->htmlShareButtons .= '<span class="ssbp-total-shares ssbp-total-pinterest-shares ssbp-each-share">'.ssbp_format_number($this->ssbpPinterestShareCount).'</span>';
			}
		    
		    // add the pinterest share count to the total
		    $this->ssbpTotalShareCount = ($this->ssbpTotalShareCount + $this->ssbpPinterestShareCount);
		}
	}
	
	// get print button
	function ssbp_print() {
	
		// linkedin share link
		$this->htmlShareButtons .= '<a href="#" class="ssbp-btn ssbp-print" onclick="window.print()" data-ssbp-title="'.$this->strPageTitle.'" data-ssbp-url="'.$this->urlCurrentPage.'" data-ssbp-site="Print">';
		
		// not using custom images
		if($this->arrSettings['ssbp_custom_images'] != 'Y')
			$this->htmlShareButtons .= '<span class="ssbp-text">Print</span>';
		else // using custom images
			$this->htmlShareButtons .= '<img src="'.$this->arrSettings['ssbp_custom_print'].'" title="Print this page" class="ssbp" alt="Print this page" />';		

		// close link
		$this->htmlShareButtons .= '</a>';
	}
	
	// get reddit button
	function ssbp_reddit() {
	
		// reddit share link
		$this->htmlShareButtons .= '<a href="http://reddit.com/submit?url='.$this->urlCurrentPage. '&amp;title=' . $this->strPageTitle . '" class="ssbp-btn ssbp-reddit" ' .  ($this->arrSettings['ssbp_rel_nofollow'] == 'Y' ? 'rel="nofollow"' : NULL) . ' data-ssbp-title="'.$this->strPageTitle.'" data-ssbp-url="'.$this->urlCurrentPage.'" data-ssbp-site="Reddit">';
		
		// not using custom images
		if($this->arrSettings['ssbp_custom_images'] != 'Y')
			$this->htmlShareButtons .= '<span class="ssbp-text">Reddit</span>';
		else // using custom images
			$this->htmlShareButtons .= '<img src="'.$this->arrSettings['ssbp_custom_reddit'].'" title="Share this on Reddit" class="ssbp" alt="Share this on Reddit" />';		

		// close link
		$this->htmlShareButtons .= '</a>';
		
		// if share counts are enabled
		if($this->arrSettings['ssbp_counters_enabled'] == 'Y') {

			// unique reddit key for this URL
		$key = 'ssbp_ri_'.md5($this->urlCurrentPage);

		// get transient if set
		$this->ssbpRedditShareCount = get_transient($key);

		// if no transient
		if( ! $this->ssbpRedditShareCount) {
			
			// get results from reddit and return the number of shares
		    $htmlRedditShareDetails = wp_remote_get('http://www.reddit.com/api/info.json?url=' . $this->urlCurrentPage, array( 'timeout' => $this->arrSettings['ssbp_count_timeout']));
			$arrRedditResult = json_decode($htmlRedditShareDetails['body'], true);
		    $intRedditShareCount = (isset($arrRedditResult['data']['children']['0']['data']['score']) ? $arrRedditResult['data']['children']['0']['data']['score'] : 0);
		    $this->ssbpRedditShareCount = ($intRedditShareCount ) ? $intRedditShareCount : '0';

		    // set transient
	    	set_transient($key,  $this->ssbpRedditShareCount, $this->arrSettings['ssbp_count_cache']);
		}
		    
		    // if each share count type is chosen
			if($this->arrSettings['ssbp_counters_type'] == 'each' && $this->ssbpRedditShareCount >= intval($this->arrSettings['ssbp_min_shares'])) {
			
				// add total share count
				$this->htmlShareButtons .= '<span class="ssbp-total-shares ssbp-total-reddit-shares ssbp-each-share">'.ssbp_format_number($this->ssbpRedditShareCount).'</span>';
			}
		    
		    // add the reddit share count to the total
		    $this->ssbpTotalShareCount = ($this->ssbpTotalShareCount + $this->ssbpRedditShareCount);
		}
	}
	
	// get stumbleupon button
	function ssbp_stumbleupon() {
	
		// stumbleupon share link
		$this->htmlShareButtons .= '<a href="http://www.stumbleupon.com/submit?url='.$this->urlCurrentPage. '&amp;title=' . $this->strPageTitle . '" class="ssbp-btn ssbp-stumbleupon" ' .  ($this->arrSettings['ssbp_rel_nofollow'] == 'Y' ? 'rel="nofollow"' : NULL) . ' data-ssbp-title="'.$this->strPageTitle.'" data-ssbp-url="'.$this->urlCurrentPage.'" data-ssbp-site="StumbleUpon">';
		
		// not using custom images
		if($this->arrSettings['ssbp_custom_images'] != 'Y')
			$this->htmlShareButtons .= '<span class="ssbp-text">Stumble</span>';
		else // using custom images
			$this->htmlShareButtons .= '<img src="'.$this->arrSettings['ssbp_custom_stumbleupon'].'" title="StumbleUpon this page" class="ssbp" alt="StumbleUpon this page" />';		

		// close link
		$this->htmlShareButtons .= '</a>';
		
		// if share counts are enabled
		if($this->arrSettings['ssbp_counters_enabled'] == 'Y') {

			// unique stumbleupon key for this URL
			$key = 'ssbp_su_'.md5($this->urlCurrentPage);

			// get transient if set
			$this->ssbpStumbleUponShareCount = get_transient($key);

			// if no transient
			if( ! $this->ssbpStumbleUponShareCount) {
			
				// get results from stumbleupon and return the number of shares		    
			    $htmlStumbleUponShareDetails = wp_remote_get('http://www.stumbleupon.com/services/1.01/badge.getinfo?url=' . $this->urlCurrentPage, array( 'timeout' => $this->arrSettings['ssbp_count_timeout']));
			    $arrStumbleUponResult = json_decode($htmlStumbleUponShareDetails['body'], true);
			    $intStumbleUponShareCount = (isset($arrStumbleUponResult['result']['views']) ? $arrStumbleUponResult['result']['views'] : 0);
			    $this->ssbpStumbleUponShareCount = ($intStumbleUponShareCount ) ? $intStumbleUponShareCount : '0';

			    // set transient
		    	set_transient($key,  $this->ssbpStumbleUponShareCount, $this->arrSettings['ssbp_count_cache']);
			}
		    
		    // if each share count type is chosen
			if($this->arrSettings['ssbp_counters_type'] == 'each' && $this->ssbpStumbleUponShareCount >= intval($this->arrSettings['ssbp_min_shares'])) {
			
				// add total share count
				$this->htmlShareButtons .= '<span class="ssbp-total-shares ssbp-total-stumbleupon-shares ssbp-each-share">'.ssbp_format_number($this->ssbpStumbleUponShareCount).'</span>';
			}
		    
		    // add the reddit share count to the total
		    $this->ssbpTotalShareCount = ($this->ssbpTotalShareCount + $this->ssbpStumbleUponShareCount);
		}
	}
	
	// get tumblr button
	function ssbp_tumblr() {
	
		// check if http:// is included
		if (preg_match('[http://]', $this->urlCurrentPage)) {
		
			// remove http:// from URL
			$this->urlCurrentPage = str_replace('http://', '', $this->urlCurrentPage);			
		} else if (preg_match('[https://]', $this->urlCurrentPage)) { // check if https:// is included
		
			// remove http:// from URL
			$this->urlCurrentPage = str_replace('https://', '', $this->urlCurrentPage);			
		}
	
		// strip http:// or https:// from URL (tumblr doesn't work with this set)
		$this->urlCurrentPage =  str_replace("http://", '', $this->urlCurrentPage);  
	
		// tumblr share link
		$this->htmlShareButtons .= '<a href="http://www.tumblr.com/share/link?url='.$this->urlCurrentPage. '&amp;name=' . $this->strPageTitle . '" class="ssbp-btn ssbp-tumblr" ' .  ($this->arrSettings['ssbp_rel_nofollow'] == 'Y' ? 'rel="nofollow"' : NULL) . ' data-ssbp-title="'.$this->strPageTitle.'" data-ssbp-url="'.$this->urlCurrentPage.'" data-ssbp-site="Tumblr">';
		
		// not using custom images
		if($this->arrSettings['ssbp_custom_images'] != 'Y')
			$this->htmlShareButtons .= '<span class="ssbp-text">tumblr</span>';
		else // using custom images
			$this->htmlShareButtons .= '<img src="'.$this->arrSettings['ssbp_custom_tumblr'].'" title="Share this on tumblr" class="ssbp" alt="Share this on tumblr" />';		

		// close link
		$this->htmlShareButtons .= '</a>';
	}
	
	// get twitter button
	function ssbp_twitter() {
	
		// format the URL into friendly code
		$twitterShareText = urlencode(html_entity_decode($this->strPageTitle . ' ' . $this->arrSettings['ssbp_twitter_text'], ENT_COMPAT, 'UTF-8'));

		// set via if set and replace the @sign just in csase
		$ssbpTwitterVia = ($this->arrSettings['ssbp_twitter_username'] != '' ? '&amp;via='.$this->arrSettings['ssbp_twitter_username'] : NULL);

		// twitter share link
		$this->htmlShareButtons .= '<a href="http://twitter.com/share?url='. ($this->urlShortened == '' ? $this->urlCurrentPage : $this->urlShortened) . '&amp;text='.$twitterShareText.'&amp;hashtags='.$this->arrSettings['ssbp_twitter_tags'].$ssbpTwitterVia.'" class="ssbp-btn ssbp-twitter"' .  ($this->arrSettings['ssbp_rel_nofollow'] == 'Y' ? 'rel="nofollow"' : NULL) . ' data-ssbp-title="'.$this->strPageTitle.'" data-ssbp-url="'.$this->urlCurrentPage.'" data-ssbp-site="Twitter">';
		
		// not using custom images
		if($this->arrSettings['ssbp_custom_images'] != 'Y')
			$this->htmlShareButtons .= '<span class="ssbp-text">Twitter</span>';
		else // using custom images
			$this->htmlShareButtons .= '<img src="'.$this->arrSettings['ssbp_custom_twitter'].'" title="Tweet about this" class="ssbp" alt="Tweet about this" />';		

		// close link
		$this->htmlShareButtons .= '</a>';
		
		// if share counts are enabled
		if($this->arrSettings['ssbp_counters_enabled'] == 'Y') {

			// unique twitter key for this URL
			$key = 'ssbp_tw_'.md5($this->urlCurrentPage);

			// get transient if set
			$this->ssbpTwitterShareCount = get_transient($key);

			// if no transient
			if( ! $this->ssbpTwitterShareCount) {
		
				// get results from twitter and return the number of shares		    
			    $htmlTwitterShareDetails = wp_remote_get('http://urls.api.twitter.com/1/urls/count.json?url=' . $this->urlCurrentPage, array( 'timeout' => $this->arrSettings['ssbp_count_timeout']));
			    
			    // if no error
			    if( ! is_wp_error($htmlTwitterShareDetails))
			    {
				    $arrTwitterShareDetails = json_decode($htmlTwitterShareDetails['body'], true);
				    $intTwitterShareCount =  $arrTwitterShareDetails['count'];
				    $this->ssbpTwitterShareCount = ($intTwitterShareCount ) ? $intTwitterShareCount : '0';

				    // set transient
		    		set_transient($key,  $this->ssbpTwitterShareCount, $this->arrSettings['ssbp_count_cache']);
			    }
			    else // there was an error
			    {
				    $this->ssbpTwitterShareCount = 0;
			    }
			}

		    // if each share count type is chosen
			if($this->arrSettings['ssbp_counters_type'] == 'each' && $this->ssbpTwitterShareCount >= intval($this->arrSettings['ssbp_min_shares'])) {
			
				// add total share count
				$this->htmlShareButtons .= '<span class="ssbp-total-shares ssbp-total-twitter-shares ssbp-each-share">'.ssbp_format_number($this->ssbpTwitterShareCount).'</span>';
			}
		    
		    // add the reddit share count to the total
		    $this->ssbpTotalShareCount = ($this->ssbpTotalShareCount + $this->ssbpTwitterShareCount);
		}
	}
	
	// get vk button
	function ssbp_vk() {
	
		// vk share link
		$this->htmlShareButtons .= '<a href="http://vkontakte.ru/share.php?url='.$this->urlCurrentPage.'" class="ssbp-btn ssbp-vk" ' .  ($this->arrSettings['ssbp_rel_nofollow'] == 'Y' ? 'rel="nofollow"' : NULL) . ' data-ssbp-title="'.$this->strPageTitle.'" data-ssbp-url="'.$this->urlCurrentPage.'" data-ssbp-site="VK">';
		
		// not using custom images
		if($this->arrSettings['ssbp_custom_images'] != 'Y')
			$this->htmlShareButtons .= '<span class="ssbp-text">VK</span>';
		else // using custom images
			$this->htmlShareButtons .= '<img src="'.$this->arrSettings['ssbp_custom_vk'].'" title="Share this on VK" class="ssbp" alt="Share this on VK" />';		

		// close link
		$this->htmlShareButtons .= '</a>';
		
		// if share counts are enabled
		if($this->arrSettings['ssbp_counters_enabled'] == 'Y') {

			// unique vk key for this URL
			$key = 'ssbp_vk_'.md5($this->urlCurrentPage);

			// get transient if set
			$this->ssbpVKShareCount = get_transient($key);

			// if no transient
			if( ! $this->ssbpVKShareCount) {
			
				// get results from vk and return the number of shares		    
			    $htmlVKShareDetails = wp_remote_get('http://vk.com/share.php?act=count&url=' . $this->urlCurrentPage, array( 'timeout' => $this->arrSettings['ssbp_count_timeout']));
			    if (!$htmlVKShareDetails['body']) {
				    $this->ssbpVKShareCount = 0;
			    } else {
				    preg_match('/^VK.Share.count\((\d+),\s+(\d+)\);$/i', $htmlVKShareDetails['body'], $matches);
					$this->ssbpVKShareCount = $matches[2];
			    }

			    // set transient
		    	set_transient($key,  $this->ssbpVKShareCount, $this->arrSettings['ssbp_count_cache']);
		    }

		    // if each share count type is chosen
			if($this->arrSettings['ssbp_counters_type'] == 'each' && $this->ssbpVKShareCount >= intval($this->arrSettings['ssbp_min_shares'])) {
			
				// add total share count
				$this->htmlShareButtons .= '<span class="ssbp-total-shares ssbp-total-vk-shares ssbp-each-share">'.ssbp_format_number($this->ssbpVKShareCount).'</span>';
			}
		    
		    // add the reddit share count to the total
		    $this->ssbpTotalShareCount = ($this->ssbpTotalShareCount + $this->ssbpVKShareCount);
		}
	}
}