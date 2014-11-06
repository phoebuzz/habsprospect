<?php
if ( ! defined( 'ABSPATH' ) ) exit;

/**
 * Theme Actions
 *
 * This is where theme functions are hooked into the appropriate hooks / filters.
 *
 * @since   3.0
 * @author 	ThemeBoy
 */

/**
 * Actions
 */
add_action( 'after_setup_theme', 'themeboy_setup' );
add_action( 'wp_head', 'tb_add_favicon', 10 );
add_action( 'wp_head', 'tb_load_responsive_meta_tags', 10 );
//add_action( 'wp_head', 'tb_custom_styling', 10 );
add_action( 'wp_head', 'tb_custom_css', 10 );
add_action( 'wp_head', 'tb_custom_typography', 10 );
add_action( 'tb_header_before', 'tb_top_nav', 10 );
add_action( 'tb_header_inside', 'tb_logo' );
add_action( 'homepage', 'tb_display_introduction', 5 );
add_action( 'homepage', 'tb_display_features', 60 );
add_action( 'homepage', 'tb_display_featured_products', 50 );
add_action( 'homepage', 'tb_display_recent_projects', 10 );
add_action( 'homepage', 'tb_display_recent_posts', 30 );
add_action( 'homepage', 'tb_display_our_team', 40 );
add_action( 'homepage', 'tb_display_testimonials', 20 );
add_action( 'widgets_init', 'tb_register_sidebars' );
add_action( 'widgets_init', 'tb_include_widgets' );
add_action( 'pre_get_posts', 'tb_query_venue_events' );

if ( ! is_admin() ) {
	add_action( 'wp_enqueue_scripts', 'tb_load_frontend_css', 20 );
	add_action( 'wp_enqueue_scripts', 'tb_add_javascript' );
	add_filter( 'excerpt_length', 'tb_excerpt_length', 999 );
}

/**
 * Filters
 */
add_filter( 'body_class','tb_layout_body_class', 10 );
add_filter( 'nav_menu_css_class', 'tb_active_nav_class', 10, 2 );
add_filter( 'wp_list_pages', 'tb_active_list_pages_class', 10, 1 );
add_filter( 'get_search_form', 'tb_customise_search_form' );
add_filter( 'excerpt_more', 'tb_excerpt_more' );
