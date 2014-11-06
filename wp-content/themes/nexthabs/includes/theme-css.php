<?php
/**
 * Enqueue CSS.
 *
 * Enqueue the theme stylesheet and output it in the <head>
 *
 * @since  	1.0
 * @return 	void
 * @uses  	wp_register_style(), wp_enqueue_style
 * @author 	ThemeBoy
 */
if ( ! function_exists( 'tb_load_frontend_css' ) ) {
	function tb_load_frontend_css () {
		wp_register_style( 'theme-stylesheet', get_stylesheet_uri() );
		wp_enqueue_style( 'theme-stylesheet' );

		// Google fonts
		wp_enqueue_style( 'Droid Sans', '//fonts.googleapis.com/css?family=Droid+Sans:400,700' );
		wp_enqueue_style( 'Lato', '//fonts.googleapis.com/css?family=Lato:400,700' );

		do_action( 'themeboy_add_css' );
	} // End tb_load_frontend_css()
}

/**
 * Custom CSS.
 *
 * @since  	1.0
 * @return 	void
 * @author 	ThemeBoy
 */
if ( ! function_exists( 'tb_custom_css' ) ) {
	function tb_custom_css() {
		$options = get_option( 'premier_theme_options', array() );
		$show_logo = tb_array_value( $options, 'show_logo', false );
		$header = '#' . get_header_textcolor();
		
		$colors = get_option( 'sportspress_frontend_css_colors' );
		$sp_primary = tb_array_value( $colors, 'primary', '#d4000f' );
		$sp_background = tb_array_value( $colors, 'background', '#cccccc' );
		$sp_text = tb_array_value( $colors, 'text', '#111111' );
		$sp_heading = tb_array_value( $colors, 'heading', '#ffffff' );
		$sp_link = tb_array_value( $colors, 'link', '#d4000f' );

	    ?>
	    <style type="text/css">
	    .header-main {
	        background-image: url(<?php header_image(); ?>);
	    }
	    .header-main h2 {
	    	color: <?php echo $header; ?>;
	    }
	    a,
	    .infinity.event-teams .team-result,
	    .widget_calendar table tr #today,
	    .widget_calendar table tr #today a,
	    .sp-calendar-wrapper table tr #today,
	    .sp-calendar-wrapper table tr #today a,
	    .widget_sp_countdown .event-name a,
	    .sp-data-table a {
	        color: <?php echo $sp_link; ?>;
	    }
	    .infobox h2,
	    .comments-title span,
	    .widget_tag_cloud,
	    .widget_archive,
	    .widget_archive .widget-title,
	    .widget_archive li:first-child,
	    .widget_archive li:first-child a,
	    .widget_categories .widget-title,
	    .widget_sp_countdown .widget-title,
	    .widget_sp_countdown .countdown,
	    .widget_sp_countdown .countdown small,
	    .infinity.event-teams .countdown,
	    .infinity.event-teams .countdown small {
	        color: <?php echo $sp_primary; ?>;
	    }
	    table {
	    	background: <?php echo $sp_background; ?>;
	    }
	    table thead tr th,
	    table thead tr td,
	    table tfoot tr th,
	    table tfoot tr td,
	    .widget_calendar table tr #prev a:before,
	    .widget_calendar table tr #prev a:after,
	    .widget_calendar table tr #next a:before,
	    .widget_calendar table tr #next a:after,
	    .sp-calendar-wrapper table tr #prev a:before,
	    .sp-calendar-wrapper table tr #prev a:after,
	    .sp-calendar-wrapper table tr #next a:before,
	    .sp-calendar-wrapper table tr #next a:after,
	    caption, .sp-table-caption,
		body.single-sp_team .widget_sp_countdown .widget-title,
		body.single-sp_team .widget_sp_countdown .event-name,
		body.single-sp_team .widget_sp_countdown .event-name a,
		body.single-sp_team .widget_sp_countdown .event-league,
		body.single-sp_team .widget_sp_countdown .event-venue,
		body.single-sp_team .widget_sp_countdown .countdown,
		body.single-sp_team .widget_sp_countdown .countdown small,
		.image-caption,
		.image-caption-alt,
		.infinity.team-name h2,
		.infinity.team-name h2 a {
	    	color: <?php echo $sp_heading; ?>;
	    }
	    table tr th,
	    table tr td {
	    	color: <?php echo $sp_text; ?>;
	    }
	    .more-link,
	    caption,
	    button, .button,
	    .header-main .nav-menu .current_page_item,
	    .header-main .nav-menu .current-menu-item,
	    .header-main .nav-menu .current-menu-parent,
	    .header-main .nav-menu .current-menu-ancestor,
	    .left-off-canvas-menu .current_page_item,
	    .left-off-canvas-menu .current-menu-item,
	    .entry-content li:before,
	    .entry-content blockquote:before,
	    .comments-title,
	    .comment-body .reply,
	    .widget_tag_cloud,
	    .widget_calendar table tbody,
	    .sp-calendar-wrapper table tbody,
	    body.single-sp_team .widget_sp_countdown,
	    .player-position,
	    .image-caption .player-number,
	    .image-caption-alt,
	    .infinity,
	    .sp-table-caption,
	    .event-team-players table td .sub,
	    .event-team-ratio .statistic .bar,
	    #footer {
	        background: <?php echo $sp_primary; ?>;
	    }
	    #masthead,
	    .header-main .nav-menu li:hover a,
	    .cat-links a,
	    .summary-bar,
	    .post-gallery .summary-bar .cat-links a,
	    .sp-google-map,
	    .widget_categories li a,
	    .widget_archive li:first-child a,
	    .widget_calendar table tbody tr td,
	    .sp-calendar-wrapper table tbody tr td {
	        border-color: <?php echo $sp_primary; ?>;
	    }
	    a:hover,
	    a:focus {
	        color: <?php echo tb_darken( $sp_primary, 25 ); ?>;
	    }
	    .more-link:hover,
	    button:hover, .button:hover,
	    ul.off-canvas-list li a:hover {
	        background: <?php echo tb_darken( $sp_primary, 25 ); ?>;
	    }

	    /*
	    table {
	    	color: <?php echo $sp_text; ?>;
	    	background: <?php echo $sp_background; ?>;
	    }

		table thead tr th,
		table thead tr td,
		table tfoot tr th,
		table tfoot tr td,
		.sp-data-table tfoot a {
	    	color: <?php echo $sp_heading; ?>;
	    }
	    */
	    </style>
	    <?php
	} // End tb_custom_css()
}
