<?php
defined('ABSPATH') or die("No direct access permitted");
	
	function ssbp_default_styles() {

		$strCSSStyle = get_option('ssbp_default_style');
		wp_enqueue_style( 'ssbp_default', plugins_url('../css/default/'.$strCSSStyle.'.min.css', __FILE__) ); 
	}

	// call scripts add function
	add_action( 'wp_enqueue_scripts', 'ssbp_page_scripts' );

	// add scripts for page/post use
	function ssbp_page_scripts() {
	
		// get settings
		$arrSettings = get_ssbp_settings();
		
		// if lazy load is enabled
		if($arrSettings['ssbp_lazy_load'] == 'Y') {
			
			// lazy load stuff
			wp_enqueue_script('ssbp_lazy_callback', plugins_url( '../js/ssbp_lazy.js' , __FILE__ ), array('jquery'), 1.0, true);
			wp_localize_script( 'ssbp_lazy_callback', 'ssbpLazy', array(
		
				// URL to wp-admin/admin-ajax.php to process the request
			    'ajax_url' => admin_url( 'admin-ajax.php' ),
			 
			    // generate a nonce with a unique ID
			    'security' => wp_create_nonce( 'ssbp-lazy-nonce' )
			));
			
			// ajax stuff
			wp_enqueue_script('ssbp_tracking_callback', plugins_url( '../js/ssbp_page.js' , __FILE__ ), array('jquery'), 1.0, true);
			wp_localize_script( 'ssbp_tracking_callback', 'ssbpAjax', array(
		
				// URL to wp-admin/admin-ajax.php to process the request
			    'ajax_url' => admin_url( 'admin-ajax.php' ),
			 
			    // generate a nonce with a unique ID
			    'security' => wp_create_nonce( 'ssbp-ajax-nonce' )
			));

		} else { // not lazy loading
			
			// ajax stuff
			wp_enqueue_script('ssbp_standard_callback', plugins_url( '../js/ssbp_standard.js' , __FILE__ ), array('jquery'), 1.0, true);
			wp_localize_script( 'ssbp_standard_callback', 'ssbpAjax', array(
		
				// URL to wp-admin/admin-ajax.php to process the request
			    'ajax_url' => admin_url( 'admin-ajax.php' ),
			 
			    // generate a nonce with a unique ID
			    'security' => wp_create_nonce( 'ssbp-ajax-nonce' )
			));
		}
		
		// stop here if a default set is selected
		if($arrSettings['ssbp_default_style'] != '')
			return;
		
		// only include CSS if needed
		//if (is_page() && $arrSettings['ssbp_pages'] == 'Y' || is_single() && $arrSettings['ssbp_posts'] == 'Y' || is_category() && $arrSettings['ssbp_cats_archs'] == 'Y' || is_archive() && $arrSettings['ssbp_cats_archs'] == 'Y' || is_home() && $arrSettings['ssbp_homepage'] == 'Y' || $booShortCode == TRUE) { 
		
			// start a switch for fonts
			switch ($arrSettings['ssbp_font_family']) {
				
				case 'Indie Flower':
					// font scripts 
					wp_register_style('ssbpFont', '//fonts.googleapis.com/css?family=Indie+Flower');
					wp_enqueue_style( 'ssbpFont');
				break;
				
				case 'Open Sans':
					// font scripts 
					wp_register_style('ssbpFont', '//fonts.googleapis.com/css?family=Open+Sans');
					wp_enqueue_style( 'ssbpFont');
				break;
				
				case 'Reenie Beanie':
					// font scripts 
					wp_register_style('ssbpFont', '//fonts.googleapis.com/css?family=Reenie+Beanie');
					wp_enqueue_style( 'ssbpFont');
				break;
				
				case 'Shadows Into Light':
					// font scripts 
					wp_register_style('ssbpFont', '//fonts.googleapis.com/css?family=Shadows+Into+Light');
					wp_enqueue_style( 'ssbpFont');
				break;
				
				// no recognised font, do nothing
				default:
				break;
			}	
		//}
		
	}

	// generate style
	function get_ssbp_style() {
	
		// query the db for current ssbp settings
		$arrSettings = get_ssbp_settings();
		
		// a default style is set
		if($arrSettings['ssbp_default_style'] != '') {
		
			// declare variable
			$htmlAdditionalCSS = '';
			
			// if additional css has been set
			if($arrSettings['ssbp_additional_css'] != '') {

				// css style
				$htmlAdditionalCSS .= '<style type="text/css">';
					$htmlAdditionalCSS .= $arrSettings['ssbp_additional_css'];
				$htmlAdditionalCSS .= '</style>';
			}

			// echo it out to the head
			echo $htmlAdditionalCSS;
			
			// add no more css
			return;
		}

		
		// some repeated variables
		$strWidthHeight = 'width:30px; height:30px;';
		$strBackgroundSize = 'background-size:420px 30px;';
		
		if($arrSettings['ssbp_show_btn_txt'] != 'Y')
			$strIconMargin = 'margin: -6px -15px -8px -15px;';
		else
			$strIconMargin = 'margin: -6px 10px -8px -15px;';
		
		$htmlSSBPStyle .= '.ssbp-total-shares:after, .ssbp-total-shares:before {
										right: 100%;
										border: solid transparent;
										content: " ";
										height: 0;
										width: 0;
										position: absolute;
										vertical-align: middle;
										pointer-events: none;
									}
									.ssbp-total-shares:after {
										border-color: rgba(224, 221, 221, 0);
										border-right-color: #f5f5f5;
										border-width: 5px;
										top: 50%;
										margin-top: -5px;
									}
									.ssbp-total-shares:before {
										border-color: rgba(85, 94, 88, 0);
										border-right-color: #e0dddd;
										border-width: 6px;
										top: 50%;
										margin-top: -6px;
									}
									.ssbp-total-shares {
										font: 14px Arial, Helvetica, sans-serif;
										vertical-align: middle;
										padding: 5px;
										-khtml-border-radius: 6px;
										-o-border-radius: 6px;
										-webkit-border-radius: 6px;
										-moz-border-radius: 6px;
										border-radius: 6px;
										position: relative;
										border: 1px solid #e0dddd;
										color: #555e58;
										background: #f5f5f5;
										margin-left: 5px;
									}
									.ssbp-total-shares:after {
										border-right-color: #f5f5f5;
									}
									.ssbp-each-share {
										margin-right:5px;
									}';
		
		// if not custom images
		if($arrSettings['ssbp_custom_images'] != 'Y') {
		
			// if we're hiding the button text
			if($arrSettings['ssbp_show_btn_txt'] != 'Y')
				$htmlSSBPStyle .= '.ssbp-text{display:none;}';
					
				// open ssbp-btn
				$htmlSSBPStyle .= '.ssbp-btn{display:inline-block;margin: 0px '.$arrSettings['ssbp_button_margin'].'px  '.$arrSettings['ssbp_button_margin'].'px 0;font-family: Arial, "Helvetica Neue", Helvetica, sans-serif;font-size: 12px;color: #FFF;text-decoration: none !important;vertical-align: middle;';
					
				// amend css according to button size
				switch($arrSettings['ssbp_size']) {
					
					// small
					case 'small':
					
						if($arrSettings['ssbp_button_shape'] == "circle")
							$htmlSSBPStyle .= "border-radius:50%;-webkit-border-radius:50%;-moz-border-radius:50%;-khtml-border-radius:50%;padding: 5px 15px;";
						elseif($arrSettings['ssbp_button_shape'] == "square")
							$htmlSSBPStyle .= "padding: 5px 15px;";
						else $htmlSSBPStyle .= "padding: 5px 20px;";
						
						if($arrSettings['ssbp_button_borders'] != "Y")
							$htmlSSBPStyle .= "border-bottom:none !important;padding-bottom: 8px;";
					
					break;
					
					// medium
					case 'medium':
					
						if($arrSettings['ssbp_button_shape'] == "circle")
							$htmlSSBPStyle .= "border-radius:50%;-webkit-border-radius:50%;-moz-border-radius:50%;-khtml-border-radius:50%;padding: 10px 20px;";
						elseif($arrSettings['ssbp_button_shape'] == "square")
							$htmlSSBPStyle .= "padding: 10px 20px;";
						else $htmlSSBPStyle .= "padding: 10px 30px;";
						
						if($arrSettings['ssbp_button_borders'] != "Y")
							$htmlSSBPStyle .= "border-bottom:none !important;padding-bottom: 12px;";
					
					break;
					
					// large
					case 'large':
					
						if($arrSettings['ssbp_button_shape'] == "circle")
							$htmlSSBPStyle .= "border-radius:50%;-webkit-border-radius:50%;-moz-border-radius:50%;-khtml-border-radius:50%;padding: 15px 25px;";
						elseif($arrSettings['ssbp_button_shape'] == "square")
							$htmlSSBPStyle .= "padding: 30px 40px 30px !important;";
						else $htmlSSBPStyle .= "padding: 15px 40px;";
						
						if($arrSettings['ssbp_button_borders'] != "Y")
							$htmlSSBPStyle .= "border-bottom:none !important;padding-bottom: 18px;";
					
					break;
				}
				
				// close ssbp-btn
				$htmlSSBPStyle .= '}';

		// set sprite
		$ssbpSprite = '/simple-share-buttons-plus/images/ssbp-sprite-'.$arrSettings['ssbp_icon_color'].'@2x.png';
		
		// no custom color has been set
		if ($arrSettings['ssbp_color_main'] == '') {
			
			// continue with styling
			$htmlSSBPStyle .= ".ssbp-buffer{background-color: #000;border-bottom: 5px solid #191919;text-shadow: 0px -2px #2f2f2f;}
						.ssbp-buffer:before {content:''; background: url('".plugins_url() . $ssbpSprite . "') no-repeat -330px 0;" . $strBackgroundSize . $strWidthHeight." float:left;".$strIconMargin."}
						.ssbp-buffer:hover{color: #FFF;background-color: #2f2f2f;border-bottom: 5px solid #191919;}
						.ssbp-buffer:active{background-color: #191919;}
						
						.ssbp-digg{background-color: #14589E;border-bottom: 5px 	solid #124f8e;text-shadow: 0px -2px #124f8e;}
						.ssbp-digg:before {content:''; background: url('".plugins_url() . $ssbpSprite . "') no-repeat 0 0;" . $strBackgroundSize . $strWidthHeight." float:left;".$strIconMargin."}
						.ssbp-digg:hover{color: #FFF;background-color: #2b68a7 ;border-bottom: 5px solid #14589E;}
						.ssbp-digg:active{background-color: #14589E;}
						
						.ssbp-email{background-color: #787878;border-bottom: 5px solid #6c6c6c;text-shadow: 0px -2px #6c6c6c;}
						.ssbp-email:before {content:''; background: url('".plugins_url() . $ssbpSprite . "') no-repeat -360px 0;" . $strBackgroundSize . $strWidthHeight." float:left;".$strIconMargin."}
						.ssbp-email:hover{color: #FFF;background-color: #858585 ;border-bottom: 5px solid #787878;}
						.ssbp-email:active{background-color: #787878;}
						
						.ssbp-facebook{background-color: #3B5998;border-bottom: 5px solid #355088;text-shadow: 0px -2px #355088;}
						.ssbp-facebook:before {content:''; background: url('".plugins_url() . $ssbpSprite . "') no-repeat -30px 0;" . $strBackgroundSize . $strWidthHeight." float:left;".$strIconMargin."}
						.ssbp-facebook:hover{color: #FFF;background-color: #4e69a2;border-bottom: 5px solid #3B5998;}
						.ssbp-facebook:active{background-color: #3B5998;}
						
						.ssbp-flattr{background-color: #f67c1a;border-bottom: 5px solid #dd6f17;text-shadow: 0px -2px #dd6f17;}
						.ssbp-flattr:before {content:''; background: url('".plugins_url() . $ssbpSprite . "') no-repeat -60px 0;" . $strBackgroundSize . $strWidthHeight." float:left;".$strIconMargin."}
						.ssbp-flattr:hover{color: #FFF;background-color: #f68930;border-bottom: 5px solid #f67c1a;}
						.ssbp-flattr:active{background-color: #f67c1a;}
						
						.ssbp-google{background-color: #E74C3C;border-bottom: 5px solid #BD3E31;text-shadow: 0px -2px #BD3E31;}
						.ssbp-google:before {content:''; background: url('".plugins_url() . $ssbpSprite . "') no-repeat -90px 0;" . $strBackgroundSize . $strWidthHeight." float:left;".$strIconMargin."}
						.ssbp-google:hover{color: #FFF;background-color: #e95d4f;border-bottom: 5px solid #E74C3C;}
						.ssbp-google:active{background-color: #E74C3C;}
						
						.ssbp-linkedin{background-color: #007FB1;border-bottom: 5px solid #00729f;text-shadow: 0px -2px #00729f;}
						.ssbp-linkedin:before {content:''; background: url('".plugins_url() . $ssbpSprite . "') no-repeat -120px 0;" . $strBackgroundSize . $strWidthHeight." float:left;".$strIconMargin."}
						.ssbp-linkedin:hover{color: #FFF;background-color: #198bb8;border-bottom: 5px solid #007FB1;}
						.ssbp-linkedin:active{background-color: #007FB1;}
						
						.ssbp-pinterest{background-color: #CB2027;border-bottom: 5px solid #b61c23;text-shadow: 0px -2px #b61c23;}
						.ssbp-pinterest:before {content:''; background: url('".plugins_url() . $ssbpSprite . "') no-repeat -150px 0;" . $strBackgroundSize . $strWidthHeight." float:left;".$strIconMargin."}
						.ssbp-pinterest:hover{color: #FFF;background-color: #d0363c;border-bottom: 5px solid #CB2027;}
						.ssbp-pinterest:active{background-color: #CB2027;}
						
						.ssbp-print{background-color: #1f6b43;border-bottom: 5px solid #075B2F;text-shadow: 0px -2px #075B2F;}
						.ssbp-print:before {content:''; background: url('".plugins_url() . $ssbpSprite . "') no-repeat -390px 0;" . $strBackgroundSize . $strWidthHeight." float:left;".$strIconMargin."}
						.ssbp-print:hover{color: #FFF;background-color: #357955;border-bottom: 5px solid #1f6b43;}
						.ssbp-print:active{background-color: #1f6b43;}
						
						.ssbp-reddit{background-color: #FF4500;border-bottom: 5px solid #e53e00;text-shadow: 0px -2px #e53e00;}
						.ssbp-reddit:before {content:''; background: url('".plugins_url() . $ssbpSprite . "') no-repeat -180px 0;" . $strBackgroundSize . $strWidthHeight." float:left;".$strIconMargin."}
						.ssbp-reddit:hover{color: #FFF;background-color: #ff5719;border-bottom: 5px solid #FF4500;}
						.ssbp-reddit:active{background-color: #FF4500;}
						
						.ssbp-stumbleupon{background-color: #EB4924;border-bottom: 5px solid #d34120;text-shadow: 0px -2px #d34120;}
						.ssbp-stumbleupon:before {content:''; background: url('".plugins_url() . $ssbpSprite . "') no-repeat -210px 0;" . $strBackgroundSize . $strWidthHeight."  no-repeat -210px 0;float:left;".$strIconMargin."}
						.ssbp-stumbleupon:hover{color: #FFF;background-color: #ed5b39;border-bottom: 5px solid #EB4924;}
						.ssbp-stumbleupon:active{background-color: #EB4924;}
						
						.ssbp-tumblr{background-color: #2C4762;border-bottom: 5px solid #273f58;text-shadow: 0px -2px #273f58;}
						.ssbp-tumblr:before {content:''; background: url('".plugins_url() . $ssbpSprite . "') no-repeat -240px 0;" . $strBackgroundSize . $strWidthHeight." float:left;".$strIconMargin."}
						.ssbp-tumblr:hover{color: #FFF;background-color: #415971;border-bottom: 5px solid #2C4762;}
						.ssbp-tumblr:active{background-color: #2C4762;}
						
						.ssbp-twitter{background-color: #00ACED;border-bottom: 5px solid #009ad5;text-shadow: 0px -2px #009ad5;}
						.ssbp-twitter:before {content:''; background: url('".plugins_url() . $ssbpSprite . "') no-repeat -270px 0;" . $strBackgroundSize . $strWidthHeight." float:left;".$strIconMargin."}
						.ssbp-twitter:hover{color: #FFF;background-color: #19b4ee;border-bottom: 5px solid #00ACED;}
						.ssbp-twitter:active{background-color: #00ACED;}
						
						.ssbp-vk{background-color: #45668e;border-bottom: 5px solid #3e5b7f;text-shadow: 0px -2px #3e5b7f;}
						.ssbp-vk:before {content:''; background: url('".plugins_url() . $ssbpSprite . "') no-repeat -300px 0;" . $strBackgroundSize . $strWidthHeight." float:left;".$strIconMargin."}
						.ssbp-vk:hover{color: #FFF;background-color: #577599;border-bottom: 5px solid #45668e;}
						.ssbp-vk:active{background-color: #45668e;}";
						
				} else { // we're working with custom colours
				
					// assign settings to variables
					// if only border or hover aren't set, use main
					$strColorMain = $arrSettings['ssbp_color_main'];
					$strColorBorder = ($arrSettings['ssbp_color_border'] != '' ? $arrSettings['ssbp_color_border'] : $arrSettings['ssbp_color_main']);
					$strColorHover = ($arrSettings['ssbp_color_hover'] != '' ? $arrSettings['ssbp_color_hover'] : $arrSettings['ssbp_color_main']);
					
					$htmlSSBPStyle .= ".ssbp-buffer{background-color: ".$strColorMain.";border-bottom: 5px solid ".$strColorBorder.";}
						.ssbp-buffer:before {content:''; background: url('".plugins_url() . $ssbpSprite . "') no-repeat -330px 0;" . $strBackgroundSize . $strWidthHeight." float:left;".$strIconMargin."}
						.ssbp-buffer:hover{color: #FFF;background-color: ".$strColorHover.";border-bottom: 5px solid ".$strColorMain.";}
						.ssbp-buffer:active{background-color: ".$strColorMain.";}
						
						.ssbp-digg{background-color: ".$strColorMain.";border-bottom: 5px 	solid ".$strColorBorder.";}
						.ssbp-digg:before {content:''; background: url('".plugins_url() . $ssbpSprite . "') no-repeat 0 0;" . $strBackgroundSize . $strWidthHeight." float:left;".$strIconMargin."}
						.ssbp-digg:hover{color: #FFF;background-color: ".$strColorHover.";border-bottom: 5px solid ".$strColorMain.";}
						.ssbp-digg:active{background-color: ".$strColorMain.";}
						
						.ssbp-email{background-color: ".$strColorMain.";border-bottom: 5px solid ".$strColorBorder.";}
						.ssbp-email:before {content:''; background: url('".plugins_url() . $ssbpSprite . "') no-repeat -360px 0;" . $strBackgroundSize . $strWidthHeight." float:left;".$strIconMargin."}
						.ssbp-email:hover{color: #FFF;background-color: ".$strColorHover.";border-bottom: 5px solid ".$strColorMain.";}
						.ssbp-email:active{background-color: ".$strColorMain.";}
						
						.ssbp-facebook{background-color: ".$strColorMain.";border-bottom: 5px solid ".$strColorBorder.";}
						.ssbp-facebook:before {content:''; background: url('".plugins_url() . $ssbpSprite . "') no-repeat -30px 0;" . $strBackgroundSize . $strWidthHeight." float:left;".$strIconMargin."}
						.ssbp-facebook:hover{color: #FFF;background-color: ".$strColorHover.";border-bottom: 5px solid ".$strColorMain.";}
						.ssbp-facebook:active{background-color: ".$strColorMain.";}
						
						.ssbp-flattr{background-color: ".$strColorMain.";border-bottom: 5px solid ".$strColorBorder.";}
						.ssbp-flattr:before {content:''; background: url('".plugins_url() . $ssbpSprite . "') no-repeat -60px 0;" . $strBackgroundSize . $strWidthHeight." float:left;".$strIconMargin."}
						.ssbp-flattr:hover{color: #FFF;background-color: ".$strColorHover.";border-bottom: 5px solid ".$strColorMain.";}
						.ssbp-flattr:active{background-color: ".$strColorMain.";}
						
						.ssbp-google{background-color: ".$strColorMain.";border-bottom: 5px solid ".$strColorBorder.";}
						.ssbp-google:before {content:''; background: url('".plugins_url() . $ssbpSprite . "') no-repeat -90px 0;" . $strBackgroundSize . $strWidthHeight." float:left;".$strIconMargin."}
						.ssbp-google:hover{color: #FFF;background-color: ".$strColorHover.";border-bottom: 5px solid ".$strColorMain.";}
						.ssbp-google:active{background-color: ".$strColorMain.";}
						
						.ssbp-linkedin{background-color: ".$strColorMain.";border-bottom: 5px solid ".$strColorBorder.";}
						.ssbp-linkedin:before {content:''; background: url('".plugins_url() . $ssbpSprite . "') no-repeat -120px 0;" . $strBackgroundSize . $strWidthHeight." float:left;".$strIconMargin."}
						.ssbp-linkedin:hover{color: #FFF;background-color: ".$strColorHover.";border-bottom: 5px solid ".$strColorMain.";}
						.ssbp-linkedin:active{background-color: ".$strColorMain.";}
						
						.ssbp-pinterest{background-color: ".$strColorMain.";border-bottom: 5px solid ".$strColorBorder.";}
						.ssbp-pinterest:before {content:''; background: url('".plugins_url() . $ssbpSprite . "') no-repeat -150px 0;" . $strBackgroundSize . $strWidthHeight." float:left;".$strIconMargin."}
						.ssbp-pinterest:hover{color: #FFF;background-color: ".$strColorHover.";border-bottom: 5px solid ".$strColorMain.";}
						.ssbp-pinterest:active{background-color: ".$strColorMain.";}
						
						.ssbp-print{background-color: ".$strColorMain.";border-bottom: 5px solid ".$strColorBorder.";}
						.ssbp-print:before {content:''; background: url('".plugins_url() . $ssbpSprite . "') no-repeat -390px 0;" . $strBackgroundSize . $strWidthHeight." float:left;".$strIconMargin."}
						.ssbp-print:hover{color: #FFF;background-color: ".$strColorHover.";border-bottom: 5px solid ".$strColorMain.";}
						.ssbp-print:active{background-color: ".$strColorMain.";}
						
						.ssbp-reddit{background-color: ".$strColorMain.";border-bottom: 5px solid ".$strColorBorder.";}
						.ssbp-reddit:before {content:''; background: url('".plugins_url() . $ssbpSprite . "') no-repeat -180px 0;" . $strBackgroundSize . $strWidthHeight." float:left;".$strIconMargin."}
						.ssbp-reddit:hover{color: #FFF;background-color: ".$strColorHover.";border-bottom: 5px solid ".$strColorMain.";}
						.ssbp-reddit:active{background-color: ".$strColorMain.";}
						
						.ssbp-stumbleupon{background-color: ".$strColorMain.";border-bottom: 5px solid ".$strColorBorder.";}
						.ssbp-stumbleupon:before {content:''; background: url('".plugins_url() . $ssbpSprite . "') no-repeat -210px 0;" . $strBackgroundSize . $strWidthHeight."  no-repeat -210px 0;float:left;".$strIconMargin."}
						.ssbp-stumbleupon:hover{color: #FFF;background-color: ".$strColorHover.";border-bottom: 5px solid ".$strColorMain.";}
						.ssbp-stumbleupon:active{background-color: ".$strColorMain.";}
						
						.ssbp-tumblr{background-color: ".$strColorMain.";border-bottom: 5px solid ".$strColorBorder.";}
						.ssbp-tumblr:before {content:''; background: url('".plugins_url() . $ssbpSprite . "') no-repeat -240px 0;" . $strBackgroundSize . $strWidthHeight." float:left;".$strIconMargin."}
						.ssbp-tumblr:hover{color: #FFF;background-color: ".$strColorHover.";border-bottom: 5px solid ".$strColorMain.";}
						.ssbp-tumblr:active{background-color: #2C4762;}
						
						.ssbp-twitter{background-color: ".$strColorMain.";border-bottom: 5px solid ".$strColorBorder.";}
						.ssbp-twitter:before {content:''; background: url('".plugins_url() . $ssbpSprite . "') no-repeat -270px 0;" . $strBackgroundSize . $strWidthHeight." float:left;".$strIconMargin."}
						.ssbp-twitter:hover{color: #FFF;background-color: ".$strColorHover.";border-bottom: 5px solid ".$strColorMain.";}
						.ssbp-twitter:active{background-color: ".$strColorMain.";}
						
						.ssbp-vk{background-color: ".$strColorMain.";border-bottom: 5px solid ".$strColorBorder.";}
						.ssbp-vk:before {content:''; background: url('".plugins_url() . $ssbpSprite . "') no-repeat -300px 0;" . $strBackgroundSize . $strWidthHeight." float:left;".$strIconMargin."}
						.ssbp-vk:hover{color: #FFF;background-color: ".$strColorHover.";border-bottom: 5px solid ".$strColorMain.";}
						.ssbp-vk:active{background-color: ".$strColorMain.";}";
				}
			} else { // end of non custom images conditional

				$htmlSSBPStyle .= '.ssbp-container img		
									{ 	
										width: ' . $arrSettings['ssbp_image_width'] . 'px !important;
										height: ' . $arrSettings['ssbp_image_height'] . 'px !important;
										padding: ' . $arrSettings['ssbp_image_padding'] . 'px;
										border:  0;
										box-shadow: none !important;
										display: inline !important;
										vertical-align: middle;
									}
									.ssbp-container img:after {
									    content:"\A";
									    position:absolute;
									    width:100%; height:100%;
									    top:0; left:0;
									    background:rgba(0,0,0,0.6);
									    opacity:0;
									    transition: all 0.5s;
									    -webkit-transition: all 0.5s;
									}
									.ssbp-container img:hover:after {
									    opacity:1;
									}';
			}
			
			// share text margin depending on its placement
			switch($arrSettings['ssbp_text_placement']) {
				
				// above
				case 'above':
					$ssbpTextMargin = 'margin:0 0 10px 0;';
					break;
				
				// below
				case 'below':
					$ssbpTextMargin = 'margin:10px 0 0 0;';
					break;
				
				// right
				case 'right':
					$ssbpTextMargin = 'margin:0 0 10px 0;';
					break;
				
				// left
				case 'left':
					$ssbpTextMargin = 'margin:0 15px 0 0;';
					break;
			}
		
			// share text weight as chosen
			switch($arrSettings['ssbp_font_weight']) {
				
				// light
				case 'light':
					$ssbpFontWeight = 'font-weight:light;';
					break;
				
				// normal
				case 'normal':
					$ssbpFontWeight = '';
					break;
				
				// bold
				case 'bold':
					$ssbpFontWeight = 'font-weight:bold;';
					break;
			}
			
			// add default CSS
			$htmlSSBPStyle .= ".ssbp-wrap{text-align:".$arrSettings['ssbp_alignment'].";}.ssbp-share-text{".$ssbpFontWeight . $ssbpTextMargin . ($arrSettings['ssbp_font_family'] != "" ? "font-family:".$arrSettings['ssbp_font_family'].";" : NULL).";font-size:".($arrSettings['ssbp_font_size'] != '' ? $arrSettings['ssbp_font_size'] : 20)."px;color:".$arrSettings['ssbp_font_color']."}";
		
			$htmlSSBPStyle .= ".ssbp-container {margin-bottom:10px;}";
		
			// if custom CSS has been set
			if ($arrSettings['ssbp_custom_styles'] != '') {
		
				// use custom styles
				$htmlSSBPStyle .= $arrSettings['ssbp_custom_styles'];
					
			}

		// strip out spaces to keep tidy
		$htmlSSBPStyle = ssbp_minify_css($htmlSSBPStyle);

		// wrap css in style tags
		$htmlSSBPStyle = '<style type="text/css">'.$htmlSSBPStyle.'</style>';	
		
		// return
		echo $htmlSSBPStyle;
	}

	// minify css on the fly
	function ssbp_minify_css($ssbpCSS)
	{
		// Remove comments
		$ssbpCSS = preg_replace('!/\*[^*]*\*+([^/][^*]*\*+)*/!', '', $ssbpCSS);

		// search and replace arrays
		$ssbpSearch = array(': ',', ',' {','; ',' ;');
		$ssbpReplace = array(':',',','{',';',';');

		// Remove space after colons
		$ssbpCSS = str_replace($ssbpSearch, $ssbpReplace, $ssbpCSS);
		 
		// Remove whitespace
		$ssbpCSS = str_replace(array("\r\n", "\r", "\n", "\t", '  ', '    ', '    '), '', $ssbpCSS);

		// return it
		return $ssbpCSS;
	}