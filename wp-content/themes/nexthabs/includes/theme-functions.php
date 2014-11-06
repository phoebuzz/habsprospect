<?php
if ( ! defined( 'ABSPATH' ) ) exit;

/**
 * Theme Functions
 *
 * General theme functions.
 *
 * @since   1.0
 * @author 	ThemeBoy
 */

/**
 * Check for IE.
 *
 * @since  	1.0
 * @return 	bool
 * @param   $version IE version
 * @uses  	substr()
 * @author 	ThemeBoy
 */
if ( ! function_exists( 'is_ie' ) ) {
	function is_ie ( $version = '6.0' ) {
		$supported_versions = array( '6.0', '7.0', '8.0', '9.0' );
		$agent 				= substr( $_SERVER['HTTP_USER_AGENT'], 25, 4 );
		$current_version 	= substr( $_SERVER['HTTP_USER_AGENT'], 30, 3 );
		$response 			= false;

		if ( in_array( $version, $supported_versions ) && 'MSIE' == $agent && ( $version == $current_version ) ) {
			$response = true;
		}

		return $response;
	} // End is_ie()
}

/**
 * Check if SportsPress is activated.
 *
 * @since  	1.0
 * @return 	bool
 * @uses  	class_exists()
 * @author 	ThemeBoy
 */
if ( ! function_exists( 'is_sportspress_activated' ) ) {
	function is_sportspress_activated() {
		return class_exists( 'sportspress' ) ? true : false;
	}
}

/**
 * Retrieves a menu name.
 *
 * Return the menu title from a location.
 *
 * @since  	1.0
 * @return 	string
 * @uses  	get_nav_menu_locations(), wp_get_nav_menu_object()
 * @param   $location Menu location
 * @author 	ThemeBoy
 */
function tb_get_menu_name( $location ) {
    if ( ! has_nav_menu( $location ) ) return false;

    $menus 			= get_nav_menu_locations();
    $menu_title 	= wp_get_nav_menu_object( $menus[$location] )->name;

    return $menu_title;
}

/**
 * Theme Setup.
 *
 * Sets up theme defaults and registers support for various WordPress features.
 *
 * @uses add_theme_support() To add support for automatic feed links.
 * @uses add_editor_style() To style the visual editor.
 */
if ( ! function_exists( 'themeboy_setup' ) ) {
	function themeboy_setup () {
		if ( locate_template( 'editor-style.css' ) != '' ) {
			add_editor_style();
		}

		add_theme_support( 'automatic-feed-links' );

		if ( function_exists( 'wp_nav_menu') ) {
			add_theme_support( 'nav-menus' );
			register_nav_menus(
				array(
					'primary' 	=> __( 'Primary Menu', 'themeboy' )
					)
				);
		}
		
		$args = array(
			'width'         => 1920,
			'height'        => 1080,
			'default-image' => get_template_directory_uri() . '/images/header.jpg',
		);
		add_theme_support( 'custom-header', $args );

		$args = array(
			'default-color' => 'dadada',
		);
		add_theme_support( 'custom-background', $args );
		add_theme_support( 'post-thumbnails' );

		// Add image sizes
		add_theme_support( 'post-thumbnails' );
		
		// Standard (3:2)
		add_image_size( 'themeboy-standard', 640, 480, true );
		add_image_size( 'themeboy-standard-thumbnail', 320, 240, true );

		// Wide (16:9)
		add_image_size( 'themeboy-wide-header', 1920, 1080, true );

		// Square (1:1)
		add_image_size( 'themeboy-square-thumbnail', 320, 320, true );

		// Fit (Proportional)
		add_image_size( 'sportspress-fit',  640, 640, false );
		add_image_size( 'sportspress-fit-thumbnail',  320, 320, false );
		add_image_size( 'sportspress-fit-icon',  128, 128, false );
		add_image_size( 'sportspress-fit-mini',  32, 32, false );
	} // End themeboy_setup()
}

/**
 * Load Theme Options.
 *
 * Sets the global options variable to access later on.
 *
 * @since  	1.0
 * @return 	null
 * @author 	ThemeBoy
 */
if ( ! function_exists( 'tb_global_options' ) ) {
	function tb_global_options () {
		global $tb_options;
		$tb_options = get_option( 'premier_theme_options', array() );
	}
}


/**
 * Load Responsive Meta Tags.
 *
 * Sets the device width and tells IE to use Chrome Frame if it's installed.
 *
 * @since  	1.0
 * @return 	string
 * @author 	ThemeBoy
 */
if ( ! function_exists( 'tb_load_responsive_meta_tags' ) ) {
	function tb_load_responsive_meta_tags () {
		$html = '';

		$html .= "\n" . '<!-- Always force latest IE rendering engine (even in intranet) & Chrome Frame -->' . "\n";
		$html .= '<meta http-equiv="X-UA-Compatible" content="IE=edge,chrome=1" />' . "\n";

		/* Remove this if not responsive design */
		$html .= "\n" . '<!--  Mobile viewport scale | Disable user zooming as the layout is optimised -->' . "\n";
		$html .= '<meta name="viewport" content="width=device-width, initial-scale=1, maximum-scale=1">' . "\n";

		echo $html;
	} // End tb_load_responsive_meta_tags()
}


/**
 * Add Favicon.
 *
 * @since  	1.0
 * @return 	string
 * @author 	ThemeBoy
 */
if ( ! function_exists( 'tb_add_favicon' ) ) {
	function tb_add_favicon () {
		$options = get_option( 'premier_theme_options', array() );
		if ( tb_array_value( $options, 'favicon', false ) ):
			$url = $options['favicon'];
		else:
			$url = get_stylesheet_directory_uri() . '/favicon.ico';
		endif;

		echo '<link rel="shortcut icon" href="' . $url . '" />';
	} // End tb_add_favicon()
}

/**
 * Custom Styling.
 *
 * Output custom CSS based on Theme Options.
 *
 * @since  	1.0
 * @return 	string $output concatenated CSS
 * @uses  	tb_get_dynamic_values()
 * @author 	ThemeBoy
 */
if ( ! function_exists( 'tb_custom_styling' ) ) {
	function tb_custom_styling() {

		$output = '';
		$settings = array(
						'body_color' 		=> '',
						'body_img' 			=> '',
						'body_repeat' 		=> '',
						'body_pos' 			=> '',
						'body_attachment' 	=> '',
						'link_color' 		=> '',
						'link_hover_color' 	=> '',
						'button_color' 		=> ''
						);
		$settings = tb_get_dynamic_values( $settings );

		if ( is_array( $settings ) ) {

			// Add CSS to output
			if ( $settings['body_color'] != '' ) {
				$output .= '#inner-wrapper { background: ' . $settings['body_color'] . ' !important; }' . "\n";
			}

			if ( $settings['body_img'] != '' ) {
				$body_image = $settings['body_img'];
				if ( is_ssl() ) { $body_image = str_replace( 'http://', 'https://', $body_image ); }
				$output .= '#inner-wrapper { background-image: url( ' . esc_url( $body_image ) . ' ) !important; }' . "\n";
			}

			if ( ( $settings['body_img'] != '' ) && ( $settings['body_repeat'] != '' ) && ( $settings['body_pos'] != '' ) ) {
				$output .= '#inner-wrapper { background-repeat: ' . $settings['body_repeat'] . ' !important; }' . "\n";
			}

			if ( ( $settings['body_img'] != '' ) && ( $settings['body_pos'] != '' ) ) {
				$output .= '#inner-wrapper { background-position: ' . $settings['body_pos'] . ' !important; }' . "\n";
			}

			if ( ( $settings['body_img'] != '' ) && ( $settings['body_attachment'] != '' ) ) {
				$output .= '#inner-wrapper { background-attachment: ' . $settings['body_attachment'] . ' !important; }' . "\n";
			}

			if ( $settings['link_color'] != '' ) {
				$output .= 'a { color: ' . $settings['link_color'] . ' !important; }' . "\n";
			}

			if ( $settings['link_hover_color'] != '' ) {
				$output .= 'a:hover, .post-more a:hover, .post-meta a:hover, .post p.tags a:hover { color: ' . $settings['link_hover_color'] . ' !important; }' . "\n";
			}

			if ( $settings['button_color'] != '' ) {
				$output .= 'a.button, a.comment-reply-link, #commentform #submit, #contact-page .submit { background: ' . $settings['button_color'] . ' !important; border-color: ' . $settings['button_color'] . ' !important; }' . "\n";
				$output .= 'a.button:hover, a.button.hover, a.button.active, a.comment-reply-link:hover, #commentform #submit:hover, #contact-page .submit:hover { background: ' . $settings['button_color'] . ' !important; opacity: 0.9; }' . "\n";
			}

		} // End If Statement

		// Output styles
		if ( isset( $output ) && $output != '' ) {
			$output = strip_tags( $output );
			$output = "\n" . "<!-- ThemeBoy Custom Styling -->\n<style type=\"text/css\">\n" . $output . "</style>\n";
			echo $output;
		}
	} // End tb_custom_styling()
}

/**
 * Custom Typography Styles.
 *
 * Output custom typography selectors based on Theme Options.
 *
 * @since  	1.0
 * @return 	void
 * @uses  	global $tb_options array of Theme Options
 * @author 	ThemeBoy
 */
if ( ! function_exists( 'tb_custom_typography' ) ) {
	function tb_custom_typography() {
		// Get options
		global $tb_options;

		// Reset
		$output 				= '';
		$default_google_font 	= false;

		// Type Check for Array
		if ( is_array( $tb_options ) ) {

			// Add Text title and tagline if text title option is enabled
			if ( isset( $tb_options['tb_texttitle'] ) && $tb_options['tb_texttitle'] == 'true' ) {

				if ( $tb_options['tb_font_site_title'] )
					$output .= 'body #wrapper #header .site-title a {'.tb_generate_font_css($tb_options['tb_font_site_title']).'}' . "\n";
			}

			if ( isset( $tb_options['tb_typography'] ) && $tb_options['tb_typography'] == 'true' ) {

				if ( isset( $tb_options['tb_font_body'] ) && $tb_options['tb_font_body'] )
					$output .= 'body { '.tb_generate_font_css($tb_options['tb_font_body'], '1.5').' }' . "\n";

				if ( isset( $tb_options['tb_font_nav'] ) && $tb_options['tb_font_nav'] )
					$output .= 'body #wrapper #navigation .nav a { '.tb_generate_font_css($tb_options['tb_font_nav'], '1.4').' }' . "\n";

				if ( isset( $tb_options['tb_font_page_title'] ) && $tb_options['tb_font_page_title'] )
					$output .= 'body #wrapper .page header h1 { '.tb_generate_font_css($tb_options[ 'tb_font_page_title' ]).' }' . "\n";

				if ( isset( $tb_options['tb_font_post_title'] ) && $tb_options['tb_font_post_title'] )
					$output .= 'body #wrapper .post header h1, body #wrapper .post header h1 a:link, body #wrapper .post header h1 a:visited { '.tb_generate_font_css($tb_options[ 'tb_font_post_title' ]).' }' . "\n";

				if ( isset( $tb_options['tb_font_post_meta'] ) && $tb_options['tb_font_post_meta'] )
					$output .= 'body #wrapper .post-meta { '.tb_generate_font_css($tb_options[ 'tb_font_post_meta' ]).' }' . "\n";

				if ( isset( $tb_options['tb_font_post_entry'] ) && $tb_options['tb_font_post_entry'] )
					$output .= 'body #wrapper .entry, body #wrapper .entry p { '.tb_generate_font_css($tb_options[ 'tb_font_post_entry' ], '1.5').' } h1, h2, h3, h4, h5, h6 { font-family: '.stripslashes($tb_options[ 'tb_font_post_entry' ]['face']).', arial, sans-serif; }'  . "\n";

				if ( isset( $tb_options['tb_font_widget_titles'] ) && $tb_options['tb_font_widget_titles'] )
					$output .= 'body #wrapper .widget h3 { '.tb_generate_font_css($tb_options[ 'tb_font_widget_titles' ]).' }'  . "\n";

				if ( isset( $tb_options['tb_font_widget_titles'] ) && $tb_options['tb_font_widget_titles'] )
					$output .= 'body #wrapper .widget h3 { '.tb_generate_font_css($tb_options[ 'tb_font_widget_titles' ]).' }'  . "\n";

				// Component titles
				if ( isset( $tb_options['tb_font_component_titles'] ) && $tb_options['tb_font_component_titles'] )
					$output .= 'body #wrapper .component h2.component-title { '.tb_generate_font_css($tb_options[ 'tb_font_component_titles' ]).' }'  . "\n";

			// Add default typography Google Font
			} else {

				// Load default Google Fonts
				global $default_google_fonts;
				if ( is_array( $default_google_fonts) and count( $default_google_fonts ) > 0 ) :

					$count = 0;
					foreach ( $default_google_fonts as $font ) {
						$count++;
						$tb_options[ 'tb_default_google_font_'.$count ] = array( 'face' => $font );
					}
					$default_google_font = true;

				endif;

			}

		} // End If Statement

		// Output styles
		if (isset($output) && $output != '') {

			// Load Google Fonts stylesheet in HEAD
			if (function_exists( 'tb_google_webfonts')) tb_google_webfonts();

			$output = "\n" . "<!-- ThemeBoy Custom Typography -->\n<style type=\"text/css\">\n" . $output . "</style>\n";
			echo $output;

		// Check if default google font is set and load Google Fonts stylesheet in HEAD
		} elseif ( $default_google_font ) {

			// Enable Google Fonts stylesheet in HEAD
			if ( function_exists( 'tb_google_webfonts' ) ) tb_google_webfonts();

		}

	} // End tb_custom_typography()
}

/**
 * Generate Google Font CSS.
 *
 * Check if Google fonts are specified and output the CSS.
 *
 * @since  	1.0
 * @return 	void
 * @uses  	array $google_fonts
 * @param   $option Theme Option
 * @param   $em Font size
 * @author 	ThemeBoy
 */
if ( ! function_exists( 'tb_generate_font_css' ) ) {
	function tb_generate_font_css( $option, $em = '1' ) {

		// Test if font-face is a Google font
		global $google_fonts;

		// Type Check for Array
		if ( is_array( $google_fonts ) ) {

			foreach ( $google_fonts as $google_font ) {

				// Add single quotation marks to font name and default arial sans-serif ending
				if ( $option[ 'face' ] == $google_font[ 'name' ] )
					$option[ 'face' ] = "'" . $option[ 'face' ] . "', arial, sans-serif";

			} // END foreach

		} // End If Statement

		if ( !@$option["style"] && !@$option["size"] && !@$option["unit"] && !@$option["color"] )
			return 'font-family: '.stripslashes($option["face"]).';';
		else
			return 'font:'.$option["style"].' '.$option["size"].$option["unit"].'/'.$em.'em '.stripslashes($option["face"]).';color:'.$option["color"].'!important;';
	}
}

/**
 * Filter body_class.
 *
 * Add layout classes to the body tag via the body_class filter.
 *
 * @since  	1.0
 * @return 	array $classes layout classes
 * @uses  	global $tb_options array of Theme Options
 * @author 	ThemeBoy
 */
if ( ! function_exists( 'tb_layout_body_class' ) ) {
	function tb_layout_body_class( $classes ) {

		global $tb_options;

		$layout = 'two-col-left';

		if ( isset( $tb_options['tb_site_layout'] ) && ( $tb_options['tb_site_layout'] != '' ) ) {
			$layout = $tb_options['tb_site_layout'];
		}

		// Set main layout on post or page
		if ( is_singular() ) {
			global $post;
			$single = get_post_meta($post->ID, '_layout', true);
			if ( $single != "" AND $single != "layout-default" )
				$layout = $single;
		}

		// Add layout to $tb_options array for use in theme
		$tb_options['tb_layout'] = $layout;

		// Add classes to body_class() output
		$classes[] = $layout;
		return $classes;

	} // End tb_layout_body_class()
}

/**
 * Filter nav_menu_css_class.
 *
 * Add active class to the current menu item via the nav_menu_css_class filter.
 *
 * @since  	1.0
 * @return 	array $classes nav classes
 * @author 	ThemeBoy
 */
if ( ! function_exists( 'tb_active_nav_class' ) ) {
		function tb_active_nav_class( $classes, $item ) {
	    if ( $item->current == 1 || $item->current_item_ancestor == true ) {
	        $classes[] = 'active';
	    }
	    return $classes;
	} // End tb_active_nav_class()
}

/**
 * Filter wp_list_pages.
 *
 * Use the active class of ZURB Foundation on wp_list_pages output.
 * From required+ Foundation http://themes.required.ch
 *
 * @since  	1.0
 * @return 	array $output list pages HTML
 * @author 	ThemeBoy
 */
if ( ! function_exists( 'tb_active_list_pages_class' ) ) {
	function tb_active_list_pages_class( $input ) {

		$pattern = '/current_page_item/';
	    $replace = 'current_page_item active';

	    $output = preg_replace( $pattern, $replace, $input );

	    return $output;
	} // End tb_active_list_pages_class()
}

/**
 * Customise the search form.
 *
 * @since  	1.0
 * @return 	var $html modified searchform markup
 * @param  	$html modified searchform markup
 * @author 	ThemeBoy
 */
if ( ! function_exists( 'tb_customise_search_form' ) ) {
	function tb_customise_search_form ( $html ) {
	  // Add the "search_main" and "fix" classes to the wrapping DIV tag.
	  $html = str_replace( '<form', '<div class="search_main fix"><form', $html );
	  // Add the "searchform" class to the form.
	  $html = str_replace( ' method=', ' class="searchform" method=', $html );
	  // Add the placeholder attribute and CSS classes to the input field.
	  $html = str_replace( ' name="s"', ' name="s" class="field s" placeholder="' . esc_attr( __( 'Search...', 'themeboy' ) ) . '"', $html );
	  // Wrap the end of the form in a closing DIV tag.
	  $html = str_replace( '</form>', '</form></div>', $html );
	  // Add the "search-submit" class to the button.
	  $html = str_replace( ' id="searchsubmit"', ' class="search-submit" id="searchsubmit"', $html );

	  return $html;
	} // End tb_customise_search_form()
}

if ( !function_exists( 'tb_excerpt_length' ) ) {
	function tb_excerpt_length( $length ) {
		return 25;
	}
}

if ( !function_exists( 'tb_array_null_filter' ) ) {
	function tb_array_null_filter( $v ) {
		return $v != null;
	}
}

if ( !function_exists( 'tb_array_subval_filter' ) ) {
	function tb_array_subval_filter( $v ) {
		if ( ! is_array( $v ) )
			return false;
		return array_filter( $v, 'array_filter' );
	}
}

if ( !function_exists( 'tb_array_value' ) ) {
	function tb_array_value( $arr = array(), $key = 0, $default = null ) {
		return ( isset( $arr[ $key ] ) ? $arr[ $key ] : $default );
	}
}
