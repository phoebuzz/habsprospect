<?php
/**
 * Handle frontend forms
 *
 * @class 		SP_Frontend_Scripts
 * @version		1.1.4
 * @package		SportsPress/Classes
 * @category	Class
 * @author 		ThemeBoy
 */
class SP_Frontend_Scripts {

	/**
	 * Constructor
	 */
	public function __construct () {
		add_action( 'wp_enqueue_scripts', array( $this, 'load_scripts' ) );
		add_action( 'wp_print_scripts', array( $this, 'check_jquery' ), 25 );
	}

	/**
	 * Get styles for the frontend
	 * @return array
	 */
	public static function get_styles() {
		return apply_filters( 'sportspress_enqueue_styles', array(
			'sportspress-general' => array(
				'src'     => str_replace( array( 'http:', 'https:' ), '', SP()->plugin_url() ) . '/assets/css/sportspress.css',
				'deps'    => '',
				'version' => SP_VERSION,
				'media'   => 'all'
			),
		));
	}

	/**
	 * Register/queue frontend scripts.
	 *
	 * @access public
	 * @return void
	 */
	public function load_scripts() {
		global $typenow;
		// Scripts
		wp_enqueue_script( 'jquery' );
		wp_enqueue_script( 'jquery-datatables', plugin_dir_url( SP_PLUGIN_FILE ) .'assets/js/jquery.dataTables.min.js', array( 'jquery' ), '1.9.4', true );
		wp_enqueue_script( 'jquery-countdown', plugin_dir_url( SP_PLUGIN_FILE ) .'assets/js/jquery.countdown.min.js', array( 'jquery' ), '2.0.2', true );
		wp_enqueue_script( 'sportspress', plugin_dir_url( SP_PLUGIN_FILE ) .'assets/js/sportspress.js', array( 'jquery' ), time(), true );

		if ( is_singular( 'sp_event' ) || is_tax( 'sp_venue' ) ):
			wp_enqueue_script( 'google-maps', 'https://maps.googleapis.com/maps/api/js?v=3.exp&sensor=false', array(), '3.exp', true );
			wp_enqueue_script( 'sp-maps', plugin_dir_url( SP_PLUGIN_FILE ) .'assets/js/sp-maps.js', array( 'jquery', 'google-maps' ), time(), true );
			wp_localize_script( 'sp-maps', 'vars', array( 'map_type' => strtoupper( get_option( 'sportspress_map_type', 'ROADMAP' ) ) ) );
		endif;

		// Localize scripts.
		wp_localize_script( 'sportspress', 'localized_strings', array( 'days' => __( 'days', 'sportspress' ), 'hrs' => __( 'hrs', 'sportspress' ), 'mins' => __( 'mins', 'sportspress' ), 'secs' => __( 'secs', 'sportspress' ), 'previous' => __( 'Previous', 'sportspress' ), 'next' => __( 'Next', 'sportspress' ) ) );

		// CSS Styles
    	wp_enqueue_style( 'dashicons' );
		$enqueue_styles = $this->get_styles();

		if ( $enqueue_styles ):
			add_action( 'wp_print_scripts', array( $this, 'custom_css' ), 30 );
			foreach ( $enqueue_styles as $handle => $args )
				wp_enqueue_style( $handle, $args['src'], $args['deps'], $args['version'], $args['media'] );
		endif;
	}

	/**
	 * SP requires jQuery 1.8 since it uses functions like .on() for events and .parseHTML.
	 * If, by the time wp_print_scrips is called, jQuery is outdated (i.e not
	 * using the version in core) we need to deregister it and register the
	 * core version of the file.
	 *
	 * @access public
	 * @return void
	 */
	public function check_jquery() {
		global $wp_scripts;

		// Enforce minimum version of jQuery
		if ( ! empty( $wp_scripts->registered['jquery']->ver ) && ! empty( $wp_scripts->registered['jquery']->src ) && 0 >= version_compare( $wp_scripts->registered['jquery']->ver, '1.8' ) ) {
			wp_deregister_script( 'jquery' );
			wp_register_script( 'jquery', '/wp-includes/js/jquery/jquery.js', array(), '1.8' );
			wp_enqueue_script( 'jquery' );
		}
	}

	/**
	 * Output custom CSS.
	 *
	 * @access public
	 * @return void
	 */
	public function custom_css() {
		$enabled = get_option( 'sportspress_enable_frontend_css', 'yes' );
		$custom = get_option( 'sportspress_custom_css', null );

		$align = get_option( 'sportspress_table_text_align', 'default' );
		$padding = get_option( 'sportspress_table_padding', null );

		$offset = get_option( 'sportspress_header_offset', '' );
		if ( $offset === '' ) {
			$template = get_option( 'template' );
			$offset = ( 'twentyfourteen' == $template ? 48 : 0 );
		}

		$colors = (array) get_option( 'sportspress_frontend_css_colors', array() );

		// Defaults
		if ( empty( $colors['primary'] ) ) $colors['primary'] = '#00a69c';
		if ( empty( $colors['background'] ) ) $colors['background'] = '#f4f4f4';
		if ( empty( $colors['text'] ) ) $colors['text'] = '#363f48';
		if ( empty( $colors['heading'] ) ) $colors['heading'] = '#ffffff';
		if ( empty( $colors['link'] ) ) $colors['link'] = '#00a69c';
		
		echo '<style type="text/css">.sp-data-table tbody a,.sp-data-table tbody a:hover,.sp-calendar tbody a,.sp-calendar tbody a:hover{background:none;}';

		if ( $enabled == 'yes' && sizeof( $colors ) > 0 ) {
			echo ' /* SportsPress Frontend CSS */ ';

			if ( isset( $colors['primary'] ) )
				echo '.sp-data-table th,.sp-calendar th,.sp-data-table tfoot,.sp-calendar tfoot,.sp-button{background:' . $colors['primary'] . ' !important}.sp-data-table tbody a,.sp-calendar tbody a{color:' . $colors['primary'] . ' !important}';

			if ( isset( $colors['background'] ) )
				echo '.sp-data-table tbody,.sp-calendar tbody{background: ' . $colors['background'] . ' !important}';

			if ( isset( $colors['text'] ) )
				echo '.sp-data-table tbody,.sp-calendar tbody{color: ' . $colors['text'] . ' !important}';

			if ( isset( $colors['heading'] ) )
				echo '.sp-data-table th,.sp-data-table th a,.sp-data-table tfoot,.sp-data-table tfoot a,.sp-calendar th,.sp-calendar th a,.sp-calendar tfoot,.sp-calendar tfoot a,.sp-button{color: ' . $colors['heading'] . ' !important}';

			if ( isset( $colors['link'] ) )
				echo '.sp-data-table tbody a,.sp-data-table tbody a:hover,.sp-calendar tbody a:focus{color: ' . $colors['link'] . ' !important}';
		}

		if ( $align != 'default' )
			echo '.sp-data-table th,.sp-data-table td{text-align: ' . $align . ' !important}';

		if ( $padding != null )
			echo '.sp-data-table th,.sp-data-table td{padding: ' . $padding . 'px !important}';

		if ( $offset != 0 )
			echo ' @media only screen and (min-width: 40.063em) {.sp-header{top: ' . $offset . 'px}}';

		if ( ! empty( $custom ) )
			echo ' /* SportsPress Custom CSS */ ' . $custom;
		
		echo '</style>';
	}
}

new SP_Frontend_Scripts();