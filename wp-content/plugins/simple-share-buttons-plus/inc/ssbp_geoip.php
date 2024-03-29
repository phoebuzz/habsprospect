<?php
defined('ABSPATH') or die("No direct access permitted");

error_reporting(0);

// get the main stats section for geoip
class ssbg_stats {
	
	// variables
	public $ssbgGeoIP;
	public $jsonGeoIPs = array();
	
	// main construct function
	// adds geoip to the db where needed
	function __construct() {
	
		// wpdb functionality
		global $wpdb;
		
		// the table we'll be querying
		$wpdb->ssbp_tracking = $wpdb->prefix.'ssbp_tracking';

		// get the exisiting geoip data
		$resultsGeoIP = $wpdb->get_results("SELECT id, ip, geoip FROM $wpdb->ssbp_tracking WHERE geoip = '' OR geoip IS NULL", ARRAY_A);

		// loop through each row
		foreach($resultsGeoIP as $geoip) {
		
			// if the ip is development
			if($geoip['ip'] == '127.0.0.1') {
			
				// set to development
				$this->ssbgGeoIP = json_encode(array(
											'country' => 'localhost',
											'code' => 'localhost',
											));
			
			} else { // not local
			
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
																			'ip' => $geoip['ip']
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
				
				// re-encode it in the format needed
				$this->ssbgGeoIP = json_encode(array(
												'country' => $geoipCountry,
												'code' => $geoipCode,
												));
			}

			// update the record in the table
			$wpdb->update($wpdb->ssbp_tracking, array('geoip' => $this->ssbgGeoIP), array('id' => $geoip['id']));
		}
	}
	
	// calculate top countries
	function ssbg_top_five() {
		
		// wpdb functionality
		global $wpdb;
		
		// the table we'll be querying
		$wpdb->ssbp_tracking = $wpdb->prefix . 'ssbp_tracking';
	
		// get the geoip totals
		$resultTopFive = $wpdb->get_results("SELECT count(*) AS total_shares, geoip FROM $wpdb->ssbp_tracking WHERE ip != '127.0.0.1' GROUP BY geoip ORDER BY total_shares DESC LIMIT 5", ARRAY_A);
		
		// return the data
		return $resultTopFive;
	}

	// get the pie chart data
	function ssbg_pie_data() {

		// wpdb functionality
		global $wpdb;
		
		// the table we'll be querying
		$wpdb->ssbp_tracking = $wpdb->prefix . 'ssbp_tracking';
	
		// get the geoip totals
		$resultPieData = $wpdb->get_results("SELECT count(*) AS total_shares, geoip FROM $wpdb->ssbp_tracking WHERE ip != '127.0.0.1' AND geoip IS NULL || geoip != '' GROUP BY geoip ORDER BY total_shares DESC LIMIT 101", ARRAY_A);

		// return the data
		return $resultPieData;
	}
}