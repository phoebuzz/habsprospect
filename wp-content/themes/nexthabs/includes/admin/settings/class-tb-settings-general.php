<?php
/**
 * Theme General Settings
 *
 * @package WordPress
 * @subpackage Premier
 * @since Premier 1.0
 */

if ( ! defined( 'ABSPATH' ) ) exit; // Exit if accessed directly

if ( ! class_exists( 'TB_Settings_General' ) ) :

/**
 * TB_Admin_Settings_General
 */
class TB_Settings_General extends TB_Settings_Page {

	/**
	 * Constructor
	 */
	public function __construct() {
		$this->id    = 'general';
		$this->label = __( 'General', 'themeboy' );

		add_filter( 'themeboy_settings_tabs_array', array( $this, 'add_settings_page' ), 20 );
		add_action( 'themeboy_settings_' . $this->id, array( $this, 'output' ) );
		add_action( 'themeboy_admin_field_country', array( $this, 'country_setting' ) );
		add_action( 'themeboy_settings_save_' . $this->id, array( $this, 'save' ) );

		add_action( 'themeboy_admin_field_frontend_styles', array( $this, 'frontend_styles_setting' ) );
	}

	/**
	 * Get settings array
	 *
	 * @return array
	 */
	public function get_settings() {

		return apply_filters( 'themeboy_general_settings', array(

			array( 'title' => __( 'General Options', 'themeboy' ), 'type' => 'title', 'desc' => '', 'id' => 'general_options' ),

			array( 'type' => 'sectionend', 'id' => 'general_options' ),

			array( 'title' => __( 'Styles and Scripts', 'themeboy' ), 'type' => 'title', 'desc' => '', 'id' => 'script_styling_options' ),

			array( 'type' 		=> 'frontend_styles' ),

			array(
				'title' 	=> __( 'Custom CSS', 'themeboy' ),
				'id' 		=> 'themeboy_custom_css',
				'css' 		=> 'width:100%; height: 130px;',
				'type' 		=> 'textarea',
			),

			array(
				'title'     => __( 'Scripts', 'themeboy' ),
				'desc' 		=> __( 'Responsive tables', 'themeboy' ),
				'id' 		=> 'themeboy_enable_responsive_tables',
				'default'	=> 'yes',
				'type' 		=> 'checkbox',
				'checkboxgroup'	=> 'start',
				'desc_tip'	=> __( 'This will enable a script allowing the tables to be responsive.', 'themeboy' ),
			),

			array(
				'desc' 		=> __( 'Sortable tables', 'themeboy' ),
				'id' 		=> 'themeboy_enable_sortable_tables',
				'default'	=> 'yes',
				'type' 		=> 'checkbox',
				'checkboxgroup'		=> '',
				'desc_tip'	=> __( 'This will enable a script allowing the tables to be sortable.', 'themeboy' ),
			),

			array(
				'desc' 		=> __( 'Live countdowns', 'themeboy' ),
				'id' 		=> 'themeboy_enable_live_countdowns',
				'default'	=> 'yes',
				'type' 		=> 'checkbox',
				'checkboxgroup'		=> 'end',
				'desc_tip'	=> __( 'This will enable a script allowing the countdowns to be animated.', 'themeboy' ),
			),

			array( 'type' => 'sectionend', 'id' => 'script_styling_options' ),

		)); // End general settings
	}

	/**
	 * Save settings
	 */
	public function save() {
		if ( isset( $_POST['themeboy_sport'] ) && ! empty( $_POST['themeboy_sport'] ) && get_option( 'themeboy_sport', null ) != $_POST['themeboy_sport'] ):
			$sport = $_POST['themeboy_sport'];
			TB_Admin_Sports::apply_preset( $sport );
    		update_option( '_tb_needs_welcome', 0 );
		endif;

		$settings = $this->get_settings();
		TB_Admin_Settings::save_fields( $settings );

		if ( isset( $_POST['themeboy_default_country'] ) )
	    	update_option( 'themeboy_default_country', $_POST['themeboy_default_country'] );

	    update_option( 'themeboy_enable_frontend_css', isset( $_POST['themeboy_enable_frontend_css'] ) ? 'yes' : 'no' );

		if ( isset( $_POST['themeboy_frontend_css_primary'] ) ) {

			// Save settings
			$primary 		= ( ! empty( $_POST['themeboy_frontend_css_primary'] ) ) ? tb_format_hex( $_POST['themeboy_frontend_css_primary'] ) : '';
			$heading 		= ( ! empty( $_POST['themeboy_frontend_css_heading'] ) ) ? tb_format_hex( $_POST['themeboy_frontend_css_heading'] ) : '';
			$text 			= ( ! empty( $_POST['themeboy_frontend_css_text'] ) ) ? tb_format_hex( $_POST['themeboy_frontend_css_text'] ) : '';
			$background 	= ( ! empty( $_POST['themeboy_frontend_css_background'] ) ) ? tb_format_hex( $_POST['themeboy_frontend_css_background'] ) : '';
			$alternate 		= ( ! empty( $_POST['themeboy_frontend_css_alternate'] ) ) ? tb_format_hex( $_POST['themeboy_frontend_css_alternate'] ) : '';

			$colors = array(
				'primary' 		=> $primary,
				'heading' 		=> $heading,
				'text' 			=> $text,
				'background' 	=> $background,
				'alternate' 	=> $alternate
			);

			update_option( 'themeboy_frontend_css_colors', $colors );
		}
	}

	/**
	 * Output the frontend styles settings.
	 *
	 * @access public
	 * @return void
	 */
	public function frontend_styles_setting() {
		?><tr valign="top" class="themeboy_frontend_css_colors">
			<th scope="row" class="titledesc">
				<?php _e( 'Frontend Styles', 'themeboy' ); ?>
			</th>
		    <td class="forminp"><?php

				// Get settings
				$colors = array_map( 'esc_attr', (array) get_option( 'themeboy_frontend_css_colors' ) );

				// Defaults
				if ( empty( $colors['primary'] ) ) $colors['primary'] = '#00a69c';
				if ( empty( $colors['heading'] ) ) $colors['heading'] = '#ffffff';
				if ( empty( $colors['text'] ) ) $colors['text'] = '#111111';
				if ( empty( $colors['background'] ) ) $colors['background'] = '#f5f5f5';
	            if ( empty( $colors['alternate'] ) ) $colors['alternate'] = '#f0f0f0';

				// Show inputs
	    		$this->color_picker( __( 'Primary', 'themeboy' ), 'themeboy_frontend_css_primary', $colors['primary'] );
	    		$this->color_picker( __( 'Heading', 'themeboy' ), 'themeboy_frontend_css_heading', $colors['heading'] );
	    		$this->color_picker( __( 'Text', 'themeboy' ), 'themeboy_frontend_css_text', $colors['text'] );
	    		$this->color_picker( __( 'Background', 'themeboy' ), 'themeboy_frontend_css_background', $colors['background'] );
	    		$this->color_picker( __( 'Alternate', 'themeboy' ), 'themeboy_frontend_css_alternate', $colors['alternate'] );

		    ?><br>
			    <label for="themeboy_enable_frontend_css">
					<input name="themeboy_enable_frontend_css" id="themeboy_enable_frontend_css" type="checkbox" value="1" <?php checked( get_option( 'themeboy_enable_frontend_css', 'yes' ), 'yes' ); ?>>
					<?php _e( 'Enable', 'themeboy' ); ?>
				</label>
			</td>
		</tr><?php
	}

	/**
	 * Output a colour picker input box.
	 *
	 * @access public
	 * @param mixed $name
	 * @param mixed $id
	 * @param mixed $value
	 * @param string $desc (default: '')
	 * @return void
	 */
	function color_picker( $name, $id, $value, $desc = '' ) {
		echo '<div class="tb-color-box"><strong>' . esc_html( $name ) . '</strong>
	   		<input name="' . esc_attr( $id ). '" id="' . esc_attr( $id ) . '" type="text" value="' . esc_attr( $value ) . '" class="colorpick" /> <div id="colorPickerDiv_' . esc_attr( $id ) . '" class="colorpickdiv"></div>
	    </div>';
	}
}

endif;

return new TB_Settings_General();
