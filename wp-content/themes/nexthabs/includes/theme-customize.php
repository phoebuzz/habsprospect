<?php
/**
 * Setup customize register.
 *
 * @author 		ThemeBoy
 * @category 	Admin
 * @package 	Premier
 * @version     1.0
 */

add_action( 'customize_register', 'tb_customize_register' );

function tb_customize_register( $wp_customize ) {

    
    /*
    $wp_customize->add_section('premier_color_scheme', array(
        'title'    => __('Color Scheme', 'premier'),
        'priority' => 120,
    ));
    */
 
 /*
    //  =============================
    //  = Text Input                =
    //  =============================
    $wp_customize->add_setting('premier_theme_options[text_test]', array(
        'default'        => 'Arse!',
        'capability'     => 'edit_theme_options',
        'type'           => 'option',
 
    ));
 
    $wp_customize->add_control('premier_text_test', array(
        'label'      => __('Text Test', 'premier'),
        'section'    => 'premier_color_scheme',
        'settings'   => 'premier_theme_options[text_test]',
    ));
 
    //  =============================
    //  = Radio Input               =
    //  =============================
    $wp_customize->add_setting('premier_theme_options[color_scheme]', array(
        'default'        => 'value2',
        'capability'     => 'edit_theme_options',
        'type'           => 'option',
    ));
 
    $wp_customize->add_control('premier_color_scheme', array(
        'label'      => __('Color Scheme', 'premier'),
        'section'    => 'premier_color_scheme',
        'settings'   => 'premier_theme_options[color_scheme]',
        'type'       => 'radio',
        'choices'    => array(
            'value1' => 'Choice 1',
            'value2' => 'Choice 2',
            'value3' => 'Choice 3',
        ),
    ));
 
    //  =============================
    //  = Checkbox                  =
    //  =============================
    $wp_customize->add_setting('premier_theme_options[checkbox_test]', array(
        'capability' => 'edit_theme_options',
        'type'       => 'option',
    ));
 
    $wp_customize->add_control('display_header_text', array(
        'settings' => 'premier_theme_options[checkbox_test]',
        'label'    => __('Display Header Text', 'premier'),
        'section'  => 'premier_color_scheme',
        'type'     => 'checkbox',
    ));
 
 
    //  =============================
    //  = Select Box                =
    //  =============================
     $wp_customize->add_setting('premier_theme_options[header_select]', array(
        'default'        => 'value2',
        'capability'     => 'edit_theme_options',
        'type'           => 'option',
 
    ));
    $wp_customize->add_control( 'example_select_box', array(
        'settings' => 'premier_theme_options[header_select]',
        'label'   => 'Select Something:',
        'section' => 'premier_color_scheme',
        'type'    => 'select',
        'choices'    => array(
            'value1' => 'Choice 1',
            'value2' => 'Choice 2',
            'value3' => 'Choice 3',
        ),
    ));
 
    */
 
    //  =============================
    //  = Logo                      =
    //  =============================
    $wp_customize->add_setting('premier_theme_options[logo]', array(
        'default'           => get_template_directory_uri() . '/images/logo.png',
        'capability'        => 'edit_theme_options',
        'type'           	=> 'option',
    ));
 
    $wp_customize->add_control( new WP_Customize_Image_Control($wp_customize, 'logo', array(
        'label'    => __('Logo', 'premier'),
        'section'  => 'title_tagline',
        'settings' => 'premier_theme_options[logo]',
    )));

    $wp_customize->add_setting('premier_theme_options[show_logo]', array(
        'default'           => 1,
        'capability'        => 'edit_theme_options',
        'type'           	=> 'option',
    ));
 
    $wp_customize->add_control( new WP_Customize_Control($wp_customize, 'show_logo', array(
        'label'    => __('Display Logo', 'premier'),
        'section'  => 'title_tagline',
        'settings' => 'premier_theme_options[show_logo]',
        'type'     => 'checkbox',
    )));

    $wp_customize->add_setting('premier_theme_options[favicon]', array(
        'default'           => get_template_directory_uri() . '/favicon.ico',
        'capability'        => 'edit_theme_options',
        'type'              => 'option',
    ));
 
    $wp_customize->add_control( new WP_Customize_Image_Control($wp_customize, 'favicon', array(
        'label'    => __('Shortcut Icon', 'premier'),
        'section'  => 'title_tagline',
        'settings' => 'premier_theme_options[favicon]',
    )));
 
 /*
    //  =============================
    //  = File Upload               =
    //  =============================
    $wp_customize->add_setting('premier_theme_options[upload_test]', array(
        'default'           => 'arse',
        'capability'        => 'edit_theme_options',
        'type'           => 'option',
 
    ));
 
    $wp_customize->add_control( new WP_Customize_Upload_Control($wp_customize, 'upload_test', array(
        'label'    => __('Upload Test', 'premier'),
        'section'  => 'premier_color_scheme',
        'settings' => 'premier_theme_options[upload_test]',
    )));
    */
 
 
    //  =============================
    //  = Color Picker              =
    //  =============================
    $wp_customize->add_setting('sportspress_frontend_css_colors[primary]', array(
        'default'           => '#d4000f',
        'sanitize_callback' => 'sanitize_hex_color',
        'capability'        => 'edit_theme_options',
        'type'           => 'option',
    ));
 
    $wp_customize->add_control( new WP_Customize_Color_Control($wp_customize, 'primary', array(
        'label'    => __('Primary', 'premier'),
        'section'  => 'colors',
        'settings' => 'sportspress_frontend_css_colors[primary]',
    )));

    $wp_customize->add_setting('sportspress_frontend_css_colors[link]', array(
        'default'           => '#d4000f',
        'sanitize_callback' => 'sanitize_hex_color',
        'capability'        => 'edit_theme_options',
        'type'           => 'option',
    ));
 
    $wp_customize->add_control( new WP_Customize_Color_Control($wp_customize, 'link', array(
        'label'    => __('Link', 'premier'),
        'section'  => 'colors',
        'settings' => 'sportspress_frontend_css_colors[link]',
    )));

    $wp_customize->add_setting('sportspress_frontend_css_colors[background]', array(
        'default'           => '#cccccc',
        'sanitize_callback' => 'sanitize_hex_color',
        'capability'        => 'edit_theme_options',
        'type'           => 'option',
    ));
 
    $wp_customize->add_control( new WP_Customize_Color_Control($wp_customize, 'background', array(
        'label'    => __('SportsPress', 'premier') . ' ' . __('Background', 'premier'),
        'section'  => 'colors',
        'settings' => 'sportspress_frontend_css_colors[background]',
    )));

    $wp_customize->add_setting('sportspress_frontend_css_colors[text]', array(
        'default'           => '#111111',
        'sanitize_callback' => 'sanitize_hex_color',
        'capability'        => 'edit_theme_options',
        'type'           => 'option',
    ));
 
    $wp_customize->add_control( new WP_Customize_Color_Control($wp_customize, 'text', array(
        'label'    => __('SportsPress', 'premier') . ' ' . __('Text', 'premier'),
        'section'  => 'colors',
        'settings' => 'sportspress_frontend_css_colors[text]',
    )));

    $wp_customize->add_setting('sportspress_frontend_css_colors[heading]', array(
        'default'           => '#ffffff',
        'sanitize_callback' => 'sanitize_hex_color',
        'capability'        => 'edit_theme_options',
        'type'           => 'option',
    ));
 
    $wp_customize->add_control( new WP_Customize_Color_Control($wp_customize, 'heading', array(
        'label'    => __('SportsPress', 'premier') . ' ' . __('Heading', 'premier'),
        'section'  => 'colors',
        'settings' => 'sportspress_frontend_css_colors[heading]',
    )));
 
/*
 
    //  =============================
    //  = Page Dropdown             =
    //  =============================
    $wp_customize->add_setting('premier_theme_options[page_test]', array(
        'capability'     => 'edit_theme_options',
        'type'           => 'option',
 
    ));
 
    $wp_customize->add_control('premier_page_test', array(
        'label'      => __('Page Test', 'premier'),
        'section'    => 'premier_color_scheme',
        'type'    => 'dropdown-pages',
        'settings'   => 'premier_theme_options[page_test]',
    ));

    // =====================
    //  = Category Dropdown =
    //  =====================
    $categories = get_categories();
	$cats = array();
	$i = 0;
	foreach($categories as $category){
		if($i==0){
			$default = $category->slug;
			$i++;
		}
		$cats[$category->slug] = $category->name;
	}
 
	$wp_customize->add_setting('_s_f_slide_cat', array(
		'default'        => $default
	));
	$wp_customize->add_control( 'cat_select_box', array(
		'settings' => '_s_f_slide_cat',
		'label'   => 'Select Category:',
		'section'  => '_s_f_home_slider',
		'type'    => 'select',
		'choices' => $cats,
	));
    */

/*
$wp_customize->add_section( 'themeslug_logo_section' , array(
    'title'       => __( 'Logo', 'themeslug' ),
    'priority'    => 30,
    'description' => 'Upload a logo to replace the default site name and description in the header',
) );

$wp_customize->add_setting( 'themeslug_logo' );

$wp_customize->add_control( new WP_Customize_Image_Control( $wp_customize, 'themeslug_logo', array(
    'label'    => __( 'Logo', 'themeslug' ),
    'section'  => 'themeslug_logo_section',
    'settings' => 'themeslug_logo',
) ) );
*/

}
