<?php
if ( ! defined( 'ABSPATH' ) ) exit;

/*-----------------------------------------------------------------------------------*/
/* Start ThemeBoy Functions - Please refrain from editing this section */
/*-----------------------------------------------------------------------------------*/

// Admin init
//require_once ( get_template_directory() . '/functions/admin-init.php' );

/*-----------------------------------------------------------------------------------*/
/* Load the theme-specific files, with support for overriding via a child theme.
/*-----------------------------------------------------------------------------------*/

if ( ! isset( $content_width ) )
	$content_width = 637;

$includes = array(
				'includes/theme-options.php', 				// Options panel settings and custom settings
				'includes/theme-actions.php', 				// Theme actions
				'includes/theme-functions.php', 			// General theme functions
				'includes/theme-template.php', 				// Theme template functions
				'includes/theme-comments.php', 				// Custom comments/pingback loop
				'includes/theme-customize.php', 			// Customize
				'includes/theme-css.php', 					// Load CSS
				'includes/theme-js.php', 					// Load JavaScript
				'includes/theme-sidebars.php', 				// Initialize widgetized areas
				'includes/theme-widgets.php',				// Theme widgets
				'includes/theme-plugin-integrations.php'	// Plugin integrations
				);

// Allow child themes/plugins to add widgets to be loaded.
$includes = apply_filters( 'themeboy_includes', $includes );

foreach ( $includes as $i ) {
	locate_template( $i, true );
}

if ( is_admin() ) {
	//include_once( 'includes/admin/class-tb-admin.php' );
}

/*-----------------------------------------------------------------------------------*/
/* You can add custom functions below */
/*-----------------------------------------------------------------------------------*/










/*-----------------------------------------------------------------------------------*/
/* Don't add any code below here or the sky will fall down */
/*-----------------------------------------------------------------------------------*/