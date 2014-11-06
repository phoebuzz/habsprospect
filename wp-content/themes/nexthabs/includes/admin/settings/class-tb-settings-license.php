<?php
/**
 * Theme License Settings
 *
 * @package WordPress
 * @subpackage Premier
 * @since Premier 1.0
 */

if ( ! defined( 'ABSPATH' ) ) exit; // Exit if accessed directly

if ( ! class_exists( 'TB_Settings_License' ) ) :

/**
 * TB_Settings_License
 */
class TB_Settings_License extends TB_Settings_Page {

	/**
	 * Constructor
	 */
	public function __construct() {
		$this->id    = 'license';
		$this->label = __( 'License', 'themeboy' );

		add_filter( 'themeboy_settings_tabs_array', array( $this, 'add_settings_page' ), 20 );
		add_action( 'themeboy_settings_' . $this->id, array( $this, 'output' ) );
		add_action( 'themeboy_admin_field_activate', array( $this, 'activate_setting' ) );
		add_action( 'themeboy_settings_save_' . $this->id, array( $this, 'save' ) );
	}

	/**
	 * Get settings array
	 *
	 * @return array
	 */
	public function get_settings() {

		return apply_filters( 'themeboy_license_settings', array(

			array( 'title' => __( 'Theme License Options', 'themeboy' ), 'type' => 'title', 'id' => 'license_options' ),

			array(
				'title'   => __( 'License Key', 'themeboy' ),
				'desc'    => __( 'Enter your license key', 'themeboy' ),
				'id'      => 'tb_theme_license_key',
				'default' => '',
				'type'    => 'text',
				'class'   => 'regular-text',
			),

			array( 'type' => 'activate' ),

			array( 'type' => 'sectionend', 'id' => 'license_options' ),

		) ); // End license settings
	}

	/**
	 * Activate settings
	 *
	 * @access public
	 * @return void
	 */
	public function activate_setting() {
		$license 	= get_option( 'tb_theme_license_key' );
		$status 	= get_option( 'tb_theme_license_key_status' );
		if ( false !== $license ) {
		?>
			<tr valign="top">
				<th scope="row" valign="top">
					<?php _e('Activate License'); ?>
				</th>
				<td>
					<?php if( $status !== false && $status == 'valid' ) { ?>
						<span style="color:green;"><?php _e('active'); ?></span>
						<?php wp_nonce_field( 'tb_nonce', 'tb_nonce' ); ?>
						<input type="submit" class="button-secondary" name="tb_theme_license_deactivate" value="<?php _e( 'Deactivate License', 'themeboy' ); ?>"/>
					<?php } else {
						wp_nonce_field( 'tb_nonce', 'tb_nonce' ); ?>
						<input type="submit" class="button-secondary" name="tb_theme_license_activate" value="<?php _e( 'Activate License', 'themeboy' ); ?>"/>
					<?php } ?>
				</td>
			</tr>
		<?php
		}
	}
}

endif;

return new TB_Settings_License();
