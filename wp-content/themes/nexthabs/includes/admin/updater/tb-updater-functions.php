<?php
/**
 * @package WordPress
 * @subpackage Premier
 */

define( 'TB_STORE_URL', 'http://themeboy.com' );
define( 'TB_THEME_NAME', 'premier' );

/***********************************************
* This is our updater
***********************************************/

if ( !class_exists( 'TB_Theme_Updater' ) ) {
	// Load our custom theme updater
	include( dirname( __FILE__ ) . '/class-tb-theme-updater.php' );
}

function tb_sample_theme_updater() {

	$license = trim( get_option( 'tb_theme_license_key' ) );

	$tb_updater = new TB_Theme_Updater( array(
			'remote_api_url' 	=> TB_STORE_URL, 		// Our store URL
			'version' 			=> '0.9', 				// The current theme version we are running
			'license' 			=> $license, 			// The license key
			'item_name' 		=> TB_THEME_NAME,		// The name of this theme
			'author'			=> 'ThemeBoy'			// The author's name
		)
	);
}
add_action( 'admin_init', 'tb_sample_theme_updater' );


/***********************************************
* Add our menu item
***********************************************/

function tb_theme_license_menu() {
	add_theme_page( 'Theme License', 'Theme License', 'manage_options', 'themename-license', 'tb_theme_license_page' );
}
add_action('admin_menu', 'tb_theme_license_menu');



/***********************************************
* Sample settings page, substitute with yours
***********************************************/

function tb_theme_license_page() {
	$license 	= get_option( 'tb_theme_license_key' );
	$status 	= get_option( 'tb_theme_license_key_status' );
	?>
	<div class="wrap">
		<h2><?php _e('Theme License Options'); ?></h2>
		<form method="post" action="options.php">

			<?php settings_fields('tb_theme_license'); ?>

			<table class="form-table">
				<tbody>
					<tr valign="top">
						<th scope="row" valign="top">
							<?php _e('License Key'); ?>
						</th>
						<td>
							<input id="tb_theme_license_key" name="tb_theme_license_key" type="text" class="regular-text" value="<?php echo esc_attr( $license ); ?>" />
							<label class="description" for="tb_theme_license_key"><?php _e('Enter your license key'); ?></label>
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
									<?php wp_nonce_field( 'tb_nonce', 'tb_nonce' ); ?>
									<input type="submit" class="button-secondary" name="tb_theme_license_deactivate" value="<?php _e('Deactivate License'); ?>"/>
								<?php } else {
									wp_nonce_field( 'tb_nonce', 'tb_nonce' ); ?>
									<input type="submit" class="button-secondary" name="tb_theme_license_activate" value="<?php _e('Activate License'); ?>"/>
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

function tb_theme_register_option() {
	// creates our settings in the options table
	register_setting('tb_theme_license', 'tb_theme_license_key', 'tb_theme_sanitize_license' );
}
add_action('admin_init', 'tb_theme_register_option');


/***********************************************
* Gets rid of the local license status option
* when adding a new one
***********************************************/

function tb_theme_sanitize_license( $new ) {
	$old = get_option( 'tb_theme_license_key' );
	if( $old && $old != $new ) {
		delete_option( 'tb_theme_license_key_status' ); // new license has been entered, so must reactivate
	}
	return $new;
}

/***********************************************
* Illustrates how to activate a license key.
***********************************************/

function tb_theme_activate_license() {

	if( isset( $_POST['tb_theme_license_activate'] ) ) {
	 	if( ! check_admin_referer( 'tb_nonce', 'tb_nonce' ) )
			return; // get out if we didn't click the Activate button

		global $wp_version;

		$license = trim( get_option( 'tb_theme_license_key' ) );

		$api_params = array(
			'edd_action' => 'activate_license',
			'license' => $license,
			'item_name' => urlencode( TB_THEME_NAME )
		);

		$response = wp_remote_get( add_query_arg( $api_params, TB_STORE_URL ), array( 'timeout' => 15, 'sslverify' => false ) );

		if ( is_wp_error( $response ) )
			return false;

		$license_data = json_decode( wp_remote_retrieve_body( $response ) );

		// $license_data->license will be either "active" or "inactive"

		if ( is_object( $license_data ) )
			update_option( 'tb_theme_license_key_status', $license_data->license );

	}
}
add_action('admin_init', 'tb_theme_activate_license');

/***********************************************
* Illustrates how to deactivate a license key.
* This will decrease the site count
***********************************************/

function tb_theme_deactivate_license() {

	// listen for our activate button to be clicked
	if( isset( $_POST['tb_theme_license_deactivate'] ) ) {

		// run a quick security check
	 	if( ! check_admin_referer( 'tb_nonce', 'tb_nonce' ) )
			return; // get out if we didn't click the Activate button

		// retrieve the license from the database
		$license = trim( get_option( 'tb_theme_license_key' ) );


		// data to send in our API request
		$api_params = array(
			'edd_action'=> 'deactivate_license',
			'license' 	=> $license,
			'item_name' => urlencode( TB_THEME_NAME ) // the name of our product in EDD
		);

		// Call the custom API.
		$response = wp_remote_get( add_query_arg( $api_params, TB_STORE_URL ), array( 'timeout' => 15, 'sslverify' => false ) );

		// make sure the response came back okay
		if ( is_wp_error( $response ) )
			return false;

		// decode the license data
		$license_data = json_decode( wp_remote_retrieve_body( $response ) );

		// $license_data->license will be either "deactivated" or "failed"
		if( $license_data->license == 'deactivated' )
			delete_option( 'tb_theme_license_key_status' );

	}
}
add_action('admin_init', 'tb_theme_deactivate_license');



/***********************************************
* Illustrates how to check if a license is valid
***********************************************/

function tb_theme_check_license() {

	global $wp_version;

	$license = trim( get_option( 'tb_theme_license_key' ) );

	$api_params = array(
		'edd_action' => 'check_license',
		'license' => $license,
		'item_name' => urlencode( TB_THEME_NAME )
	);

	$response = wp_remote_get( add_query_arg( $api_params, TB_STORE_URL ), array( 'timeout' => 15, 'sslverify' => false ) );

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