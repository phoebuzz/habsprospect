<?php
if ( ! defined( 'ABSPATH' ) ) exit;

/**
 * Registers sidebars
 *
 * @since   1.0
 * @return 	void
 * @uses    register_sidebar()
 * @var 	int $footer_widget_regions the number of footer widget regions
 * @author 	ThemeBoy
 */
if ( ! function_exists( 'tb_register_sidebars' ) ) {
	function tb_register_sidebars() {

	    if ( ! function_exists( 'register_sidebar' ) ) return;

	    register_sidebar( array(
	    	'name' 				=> __( 'Sidebar', 'themeboy' ),
	    	'id' 				=> 'primary',
	    	'description' 		=> __( 'Default sidebar.', 'themeboy' ),
			'before_widget' 	=> '<aside id="%1$s" class="widget %2$s">',
			'after_widget'  	=> '</aside>',
			'before_title'  	=> '<h2 class="widget-title">',
			'after_title'   	=> '</h2>',
	    ) );

		register_sidebar( array(
			'name'          	=> __( 'Headline', 'themeboy' ),
			'description'   	=> null,
			'id'            	=> 'headline',
			'before_widget' 	=> '<div class="large-12 columns"><aside id="%1$s" class="widget %2$s">',
			'after_widget'  	=> '</aside></div>',
			'before_title' 	 	=> '<h2 class="widget-title">',
			'after_title'   	=> '</h2>',
		) );

		register_sidebar( array(
			'name'          	=> __( 'Homepage', 'themeboy' ),
			'description'   	=> null,
			'id'            	=> 'homepage',
			'before_widget' 	=> '<div class="large-6 columns"><aside id="%1$s" class="widget %2$s">',
			'after_widget'  	=> '</aside></div>',
			'before_title'  	=> '<h3 class="widget-title">',
			'after_title'   	=> '</h3>',
		) );

		$footer_widget_regions = apply_filters( 'tb_footer_widget_regions', 3 );

		for ( $i = 1; $i <= intval( $footer_widget_regions ); $i++ ) {
			register_sidebar( array(
				'name' 				=> sprintf( __( 'Footer %d', 'themeboy' ), $i ),
				'id' 				=> sprintf( 'footer-%d', $i ),
				'description' 		=> sprintf( __( 'Widgetized Footer Region %d.', 'themeboy' ), $i ),
				'before_widget' 	=> '<aside id="%1s" class="widget %2$s">',
				'after_widget' 		=> '</aside>',
				'before_title' 		=> '<h3 class="widget-title">',
				'after_title' 		=> '</h3>',
				)
			);
		}
	}
}
