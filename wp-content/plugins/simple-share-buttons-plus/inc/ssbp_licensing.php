<?php
//set_site_transient( 'update_plugins', null );
include( dirname( __FILE__ ) . '/EDD_SL_Plugin_Updater.php' );

define('SSBP_SL_STORE_URL', 'http://www.simplesharebuttons.com');
define('SSBP_SL_ITEM_NAME', 'Simple Share Buttons Plus');

function ssbp_sl_plugin_updater() {

	// retrieve our license key from the DB
	$license_key = trim( get_option( 'ssbp_license_key' ) );
	
	// setup the updater
	$ssbp_updater = new SSB_SL_Plugin_Updater( SSBP_SL_STORE_URL, SSBP_FILE, array( 
			'version' 	=> '0.4.2', 		// current version number
			'license' 	=> $license_key, 	// license key (used get_option above to retrieve from DB)
			'item_name' => SSBP_SL_ITEM_NAME, 	// name of this plugin
			'author' 	=> 'David Neal',  // author of this plugin
			'url'       => home_url()
		)
	);
}
add_action( 'admin_init', 'ssbp_sl_plugin_updater' );

function ssbp_activate_license() {
 
	// listen for our activate button to be clicked
	if( isset( $_POST['ssbp_license_activate'] ) ) {
 
		// run a quick security check 
	 	if( ! check_admin_referer( 'ssbp_activate_nonce', 'ssbp_activate_nonce' ) ) 	
			return; // get out if we didn't click the Activate button
 
		// retrieve the license from the database
		$license = trim( get_option( 'ssbp_license_key' ) );
 
		// data to send in our API request
		$api_params = array( 
			'edd_action'=> 'activate_license', 
			'license' 	=> $license, 
			'item_name' => urlencode( SSBP_SL_ITEM_NAME ), // the name of our product in EDD,
			'url'       => home_url()
		);
		
		// Call the custom API.
		$response = wp_remote_get( add_query_arg( $api_params, SSBP_SL_STORE_URL ) );

		// make sure the response came back okay
		if ( is_wp_error( $response ) )
			return false;
 
		// decode the license data
		$license_data = json_decode( wp_remote_retrieve_body( $response ) );
		
		// $license_data->license will be either "active" or "inactive"
 
		update_option( 'ssbp_license_status', $license_data->license );
 
	}
}

add_action('admin_init', 'ssbp_activate_license');

function ssbp_licensing() {
	$license 	= get_option( 'ssbp_license_key' );
	$status 	= get_option( 'ssbp_license_status' );
	?>
	<div class="wrap">
		<h2><?php _e('Plugin License Options'); ?></h2>
		<form method="post" action="options.php">
		
			<?php settings_fields('ssbp_license'); ?>
			
			<table class="form-table">
				<tbody>
					<tr valign="top">	
						<th scope="row" valign="top">
							<?php _e('License Key'); ?>
						</th>
						<td>
							<input id="ssbp_license_key" name="ssbp_license_key" type="text" class="regular-text" value="<?php esc_attr_e( $license ); ?>" />
							<label class="description" for="ssbp_license_key"><?php _e('Enter your license key'); ?></label>
						</td>
					</tr>
					<?php if( false !== $license ) { ?>
						<tr valign="top">	
							<th scope="row" valign="top">
								<?php _e('Activate License'); ?>
							</th>
							<td>
								<?php if( $status !== false && $status == 'valid' ) { ?>
									<span style="color:green;"><?php _e('active'); ?></span>
								<?php } else {
									wp_nonce_field( 'ssbp_activate_nonce', 'ssbp_activate_nonce' ); ?>
									<input type="submit" class="button-secondary" name="ssbp_license_activate" value="<?php _e('Activate License'); ?>"/>
								<?php } ?>
							</td>
						</tr>
					<?php } ?>
				</tbody>
			</table>	
			<?php submit_button(); ?>
		
		</form>
	<?php
}
 
function ssbp_register_option() {
	// creates our settings in the options table
	register_setting('ssbp_license', 'ssbp_license_key', 'ssbp_sanitize_license' );
}
add_action('admin_init', 'ssbp_register_option');
 
function ssbp_sanitize_license( $new ) {
	$old = get_option( 'ssbp_license_key' );
	if( $old && $old != $new ) {
		delete_option( 'ssbp_license_status' ); // new license has been entered, so must reactivate
	}
	return $new;
}

function ssbp_deactivate_license() {

	// listen for our activate button to be clicked
	if( isset( $_POST['edd_license_deactivate'] ) ) {

		// run a quick security check 
	 	if( ! check_admin_referer( 'edd_sample_nonce', 'edd_sample_nonce' ) ) 	
			return; // get out if we didn't click the Activate button

		// retrieve the license from the database
		$license = trim( get_option( 'edd_sample_license_key' ) );
			

		// data to send in our API request
		$api_params = array( 
			'edd_action'=> 'deactivate_license', 
			'license' 	=> $license, 
			'item_name' => urlencode( SSBP_SL_ITEM_NAME ), // the name of our product in EDD
			'url'       => home_url()
		);
		
		// Call the custom API.
		$response = wp_remote_get( add_query_arg( $api_params, SSBP_SL_STORE_URL ), array( 'timeout' => 15, 'sslverify' => false ) );

		// make sure the response came back okay
		if ( is_wp_error( $response ) )
			return false;

		// decode the license data
		$license_data = json_decode( wp_remote_retrieve_body( $response ) );
		
		// $license_data->license will be either "deactivated" or "failed"
		if( $license_data->license == 'deactivated' )
			delete_option( 'edd_sample_license_status' );

	}
}
add_action('admin_init', 'ssbp_deactivate_license');

function ssbp_check_license() {

	global $wp_version;

	$license = trim( get_option( 'edd_sample_license_key' ) );
		
	$api_params = array( 
		'edd_action' => 'check_license', 
		'license' => $license, 
		'item_name' => urlencode( SSBP_SL_ITEM_NAME ),
		'url'       => home_url()
	);

	// Call the custom API.
	$response = wp_remote_get( add_query_arg( $api_params, SSBP_SL_STORE_URL ), array( 'timeout' => 15, 'sslverify' => false ) );


	if ( is_wp_error( $response ) )
		return false;

	$license_data = json_decode( wp_remote_retrieve_body( $response ) );

	if( $license_data->license == 'valid' ) {
		echo 'valid'; exit;
		// this license is still valid
	} else {
		echo 'invalid'; exit;
		// this license is no longer valid
	}
}