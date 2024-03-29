<?php
/**
 * Plugin Name: SportsPress
 * Plugin URI: http://themeboy.com/sportspress/
 * Description: Manage your club and its players, staff, events, league tables, and player lists.
 * Version: 1.3.2
 * Author: ThemeBoy
 * Author URI: http://themeboy.com
 * Requires at least: 3.8
 * Tested up to: 4.0
 *
 * Text Domain: sportspress
 * Domain Path: /languages/
 *
 * @package SportsPress
 * @category Core
 * @author ThemeBoy
 */
if ( ! defined( 'ABSPATH' ) ) {
	exit; // Exit if accessed directly
}

if ( ! class_exists( 'SportsPress' ) ) :

/**
 * Main SportsPress Class
 *
 * @class SportsPress
 * @version	1.3.2
 */
final class SportsPress {

	/**
	 * @var string
	 */
	public $version = '1.3.2';

	/**
	 * @var SporsPress The single instance of the class
	 * @since 0.7
	 */
	protected static $_instance = null;

	/**
	 * @var SP_Countries $countries
	 */
	public $countries = null;

	/**
	 * @var SP_Formats $formats
	 */
	public $formats = null;

	/**
	 * @var array
	 */
	public $text = array();

	/**
	 * Main SportsPress Instance
	 *
	 * Ensures only one instance of SportsPress is loaded or can be loaded.
	 *
	 * @since 0.7
	 * @static
	 * @see SP()
	 * @return SportsPress - Main instance
	 */
	public static function instance() {
		if ( is_null( self::$_instance ) ) {
			self::$_instance = new self();
		}
		return self::$_instance;
	}

	/**
	 * Cloning is forbidden.
	 *
	 * @since 0.7
	 */
	public function __clone() {
		_doing_it_wrong( __FUNCTION__, __( 'Cheatin&#8217; huh?', 'sportspress' ), '0.7' );
	}

	/**
	 * Unserializing instances of this class is forbidden.
	 *
	 * @since 0.7
	 */
	public function __wakeup() {
		_doing_it_wrong( __FUNCTION__, __( 'Cheatin&#8217; huh?', 'sportspress' ), '0.7' );
	}

	/**
	 * SportsPress Constructor.
	 * @access public
	 * @return SportsPress
	 */
	public function __construct() {
		// Auto-load classes on demand
		if ( function_exists( "__autoload" ) ) {
			spl_autoload_register( "__autoload" );
		}

		spl_autoload_register( array( $this, 'autoload' ) );

		// Define constants
		$this->define_constants();

		// Include required files
		$this->includes();

		// Hooks
		add_filter( 'plugin_action_links_' . plugin_basename( __FILE__ ), array( $this, 'action_links' ) );
		add_action( 'widgets_init', array( $this, 'include_widgets' ) );
		add_action( 'init', array( $this, 'init' ), 0 );
		add_action( 'init', array( 'SP_Shortcodes', 'init' ) );
		add_action( 'after_setup_theme', array( $this, 'setup_environment' ) );

		// Loaded action
		do_action( 'sportspress_loaded' );
	}

	/**
	 * Show action links on the plugin screen.
	 *
	 * @param mixed $links
	 * @return array
	 */
	public function action_links( $links ) {
		return array_merge( array(
			'<a href="' . admin_url( 'admin.php?page=sportspress' ) . '">' . __( 'Settings', 'sportspress' ) . '</a>',
			'<a href="' . apply_filters( 'sportspress_docs_url', 'http://sportspresspro.com/docs/' ) . '">' . __( 'Docs', 'sportspress' ) . '</a>',
			'<a href="' . apply_filters( 'sportspress_pro_url', 'http://sportspresspro.com/pricing/' ) . '">' . __( 'Upgrade', 'sportspress' ) . '</a>',
		), $links );
	}

	/**
	 * Auto-load SP classes on demand to reduce memory consumption.
	 *
	 * @param mixed $class
	 * @return void
	 */
	public function autoload( $class ) {
		$path  = null;
		$class = strtolower( $class );
		$file = 'class-' . str_replace( '_', '-', $class ) . '.php';

		if ( strpos( $class, 'sp_shortcode_' ) === 0 ) {
			$path = $this->plugin_path() . '/includes/shortcodes/';
		} elseif ( strpos( $class, 'sp_meta_box' ) === 0 ) {
			$path = $this->plugin_path() . '/includes/admin/post-types/meta-boxes/';
		} elseif ( strpos( $class, 'sp_admin' ) === 0 ) {
			$path = $this->plugin_path() . '/includes/admin/';
		}

		if ( $path && is_readable( $path . $file ) ) {
			include_once( $path . $file );
			return;
		}

		// Fallback
		if ( strpos( $class, 'sp_' ) === 0 ) {
			$path = $this->plugin_path() . '/includes/';
		}

		if ( $path && is_readable( $path . $file ) ) {
			include_once( $path . $file );
			return;
		}
	}

	/**
	 * Define SP Constants.
	 */
	private function define_constants() {
		define( 'SP_PLUGIN_FILE', __FILE__ );
		define( 'SP_VERSION', $this->version );

		if ( ! defined( 'SP_TEMPLATE_PATH' ) ) {
			define( 'SP_TEMPLATE_PATH', $this->template_path() );
		}

		if ( ! defined( 'SP_DELIMITER' ) ) {
			define( 'SP_DELIMITER', '|' );
		}
	}

	/**
	 * Include required core files used in admin and on the frontend.
	 */
	private function includes() {
		include_once( 'includes/sp-core-functions.php' );
		include_once( 'includes/class-sp-install.php' );

		if ( is_admin() ) {
			include_once( 'includes/admin/class-sp-admin.php' );
		}

		if ( defined( 'DOING_AJAX' ) ) {
			$this->ajax_includes();
		}

		if ( ! is_admin() || defined( 'DOING_AJAX' ) ) {
			$this->frontend_includes();
		}

		// Post types
		include_once( 'includes/class-sp-post-types.php' );						// Registers post types

		// Include abstract classes
		include_once( 'includes/abstracts/abstract-sp-custom-post.php' );		// Custom posts

		// Classes (used on all pages)
		include_once( 'includes/class-sp-countries.php' );						// Defines continents and countries
		include_once( 'includes/class-sp-formats.php' );						// Defines custom post type formats
		
		// Include template functions making them pluggable by plugins and themes.
		include_once( 'includes/sp-template-functions.php' );

		// Include template hooks in time for themes to remove/modify them
		include_once( 'includes/sp-template-hooks.php' );

		// WPML-related localization hooks
		include_once( 'includes/class-sp-wpml.php' );
	}

	/**
	 * Include required ajax files.
	 */
	public function ajax_includes() {
		include_once( 'includes/class-sp-ajax.php' );					// Ajax functions for admin and the front-end
	}

	/**
	 * Include required frontend files.
	 */
	public function frontend_includes() {
		include_once( 'includes/class-sp-template-loader.php' );		// Template Loader
		include_once( 'includes/class-sp-frontend-scripts.php' );		// Frontend Scripts
		include_once( 'includes/class-sp-shortcodes.php' );				// Shortcodes class
	}

	/**
	 * Include core widgets
	 */
	public function include_widgets() {
		include_once( 'includes/widgets/class-sp-widget-countdown.php' );
		include_once( 'includes/widgets/class-sp-widget-event-calendar.php' );
		include_once( 'includes/widgets/class-sp-widget-event-list.php' );
		include_once( 'includes/widgets/class-sp-widget-event-blocks.php' );
		include_once( 'includes/widgets/class-sp-widget-league-table.php' );
		include_once( 'includes/widgets/class-sp-widget-player-list.php' );
		include_once( 'includes/widgets/class-sp-widget-player-gallery.php' );

		do_action( 'sportspress_widgets' );
	}

	/**
	 * Init SportsPress when WordPress Initialises.
	 */
	public function init() {
		// Before init action
		do_action( 'before_sportspress_init' );

		// Set up localisation
		$this->load_plugin_textdomain();

		// Load class instances
		$this->countries = new SP_Countries();	// Countries class
		$this->formats = new SP_Formats();		// Formats class

		// Load string options
		$this->text = get_option( 'sportspress_text', array() );

		// Init action
		do_action( 'sportspress_init' );
	}

	/**
	 * Load Localisation files.
	 *
	 * Note: the first-loaded translation file overrides any following ones if the same translation is present
	 */
	public function load_plugin_textdomain() {
		$locale = apply_filters( 'plugin_locale', get_locale(), 'sportspress' );
		
		// Global + Frontend Locale
		load_textdomain( 'sportspress', WP_LANG_DIR . "/sportspress/sportspress-$locale.mo" );
		load_plugin_textdomain( 'sportspress', false, plugin_basename( dirname( __FILE__ ) . "/languages" ) );
	}

	/**
	 * Ensure theme and server variable compatibility and setup image sizes.
	 */
	public function setup_environment() {
		add_theme_support( 'post-thumbnails' );

		// Add image sizes
		add_image_size( 'sportspress-fit-thumbnail',  320, 320, false );
		add_image_size( 'sportspress-fit-icon',  128, 128, false );
		add_image_size( 'sportspress-fit-mini',  32, 32, false );
	}

	/** Helper functions ******************************************************/

	/**
	 * Get the plugin url.
	 *
	 * @return string
	 */
	public function plugin_url() {
		return untrailingslashit( plugins_url( '/', __FILE__ ) );
	}

	/**
	 * Get the plugin path.
	 *
	 * @return string
	 */
	public function plugin_path() {
		return untrailingslashit( plugin_dir_path( __FILE__ ) );
	}

	/**
	 * Get the template path.
	 *
	 * @return string
	 */
	public function template_path() {
		return apply_filters( 'SP_TEMPLATE_PATH', 'sportspress/' );
	}
}

endif;

if ( ! function_exists( 'SP' ) ):

/**
 * Returns the main instance of SP to prevent the need to use globals.
 *
 * @since  0.7
 * @return SportsPress
 */
function SP() {
	return SportsPress::instance();
}

SP();

endif;
