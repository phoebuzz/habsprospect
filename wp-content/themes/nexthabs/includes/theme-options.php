<?php
if ( ! defined( 'ABSPATH' ) ) exit;
if (!function_exists( 'tb_options')) {
function tb_options() {

// THEME VARIABLES
$themename = 'Premier';
$themeslug = 'themeboy';

// STANDARD VARIABLES. DO NOT TOUCH!
$shortname = 'tb';
$manualurl = 'http://docs.themeboy.com/document/'.$themeslug.'/';

//Access the WordPress Categories via an Array
$tb_categories = array();
$tb_categories_obj = get_categories( 'hide_empty=0' );
foreach ($tb_categories_obj as $tb_cat) {
    $tb_categories[$tb_cat->cat_ID] = $tb_cat->cat_name;}
$categories_tmp = array_unshift($tb_categories, 'Select a category:' );

//Access the WordPress Pages via an Array
$tb_pages = array();
$tb_pages_obj = get_pages( 'sort_column=post_parent,menu_order' );
foreach ($tb_pages_obj as $tb_page) {
    $tb_pages[$tb_page->ID] = $tb_page->post_name; }
$tb_pages_tmp = array_unshift($tb_pages, 'Select a page:' );

//Stylesheets Reader
$alt_stylesheet_path = get_template_directory() . '/styles/';
$alt_stylesheets = array();
if ( is_dir($alt_stylesheet_path) ) {
    if ($alt_stylesheet_dir = opendir($alt_stylesheet_path) ) {
        while ( ($alt_stylesheet_file = readdir($alt_stylesheet_dir)) !== false ) {
            if(stristr($alt_stylesheet_file, '.css') !== false) {
                $alt_stylesheets[] = $alt_stylesheet_file;
            }
        }
    }
}

// Below are the various theme options fields.
$options = array();
$other_entries = array( '0', '1', '2', '3', '4', '5', '6', '7', '8', '9', '10', '11', '12', '13', '14', '15', '16', '17', '18', '19' );

/* General */

$options[] = array( 'name' => __( 'General Settings', 'themeboy' ),
    				'type' => 'heading',
    				'icon' => 'general' );

$options[] = array( 'name' => __( 'Theme Stylesheet', 'themeboy' ),
    				'desc' => __( 'Select your themes alternative color scheme.', 'themeboy' ),
    				'id' => $shortname . '_alt_stylesheet',
    				'std' => 'default.css',
    				'type' => 'select',
    				'options' => $alt_stylesheets );

$options[] = array( 'name' => __( 'Custom Logo', 'themeboy' ),
    				'desc' => __( 'Upload a logo for your theme, or specify an image URL directly.', 'themeboy' ),
    				'id' => $shortname . '_logo',
    				'std' => '',
    				'type' => 'upload' );

$options[] = array( 'name' => __( 'Text Title', 'themeboy' ),
    				'desc' => sprintf( __( 'Enable text-based Site Title and Tagline. Setup title & tagline in %1$s.', 'themeboy' ), '<a href="' . esc_url( home_url() ) . '/wp-admin/options-general.php">' . __( 'General Settings', 'themeboy' ) . '</a>' ),
    				'id' => $shortname . '_texttitle',
    				'std' => 'false',
    				'class' => 'collapsed',
    				'type' => 'checkbox' );

$options[] = array( 'name' => __( 'Site Title', 'themeboy' ),
    				'desc' => __( 'Change the site title typography.', 'themeboy' ),
    				'id' => $shortname . '_font_site_title',
    				'std' => array( 'size' => '36', 'unit' => 'px', 'face' => 'Droid Serif', 'style' => '', 'color' => '#333333' ),
    				'class' => 'hidden',
    				'type' => 'typography' );

/* Styling */

$options[] = array( 'name' => __( 'Styling', 'themeboy' ),
    				'type' => 'heading',
    				'icon' => 'styling' );

$options[] = array( 'name' => __( 'Body Background Color', 'themeboy' ),
    				'desc' => __( 'Pick a custom color for background color of the theme e.g. #697e09', 'themeboy' ),
    				'id' => $shortname . '_body_color',
    				'std' => '',
    				'type' => 'color' );

$options[] = array( 'name' => __( 'Body background image', 'themeboy' ),
    				'desc' => __( 'Upload an image for the theme\'s background', 'themeboy' ),
    				'id' => $shortname . '_body_img',
    				'std' => '',
    				'type' => 'upload' );

$options[] = array( 'name' => __( 'Background image repeat', 'themeboy' ),
    				'desc' => __( 'Select how you would like to repeat the background-image', 'themeboy' ),
    				'id' => $shortname . '_body_repeat',
    				'std' => 'no-repeat',
    				'type' => 'select',
    				'options' => array( 'no-repeat', 'repeat-x', 'repeat-y', 'repeat' ) );

$options[] = array( 'name' => __( 'Background image position', 'themeboy' ),
    				'desc' => __( 'Select how you would like to position the background', 'themeboy' ),
    				'id' => $shortname . '_body_pos',
    				'std' => 'top',
    				'type' => 'select',
    				'options' => array( 'top left', 'top center', 'top right', 'center left', 'center center', 'center right', 'bottom left', 'bottom center', 'bottom right' ) );

$options[] = array( 'name' => __( 'Background Attachment', 'themeboy' ),
    				'desc' => __( 'Select whether the background should be fixed or move when the user scrolls', 'themeboy' ),
    				'id' => $shortname.'_body_attachment',
    				'std' => 'scroll',
    				'type' => 'select',
    				'options' => array( 'scroll', 'fixed' ) );

/* Typography */

$options[] = array( 'name' => __( 'Typography', 'themeboy' ),
    				'type' => 'heading',
    				'icon' => 'typography' );

$options[] = array( 'name' => __( 'Enable Custom Typography', 'themeboy' ) ,
    				'desc' => __( 'Enable the use of custom typography for your site. Custom styling will be output in your sites HEAD.', 'themeboy' ) ,
    				'id' => $shortname . '_typography',
    				'std' => 'false',
    				'type' => 'checkbox' );

$options[] = array( 'name' => __( 'General Typography', 'themeboy' ) ,
    				'desc' => __( 'Change the general font.', 'themeboy' ) ,
    				'id' => $shortname . '_font_body',
    				'std' => array( 'size' => '1.4', 'unit' => 'em', 'face' => 'FontSiteSans-Roman', 'style' => '', 'color' => '#3E3E3E' ),
    				'type' => 'typography' );

$options[] = array( 'name' => __( 'Navigation', 'themeboy' ) ,
    				'desc' => __( 'Change the navigation font.', 'themeboy' ),
    				'id' => $shortname . '_font_nav',
    				'std' => array( 'size' => '1', 'unit' => 'em', 'face' => 'FontSiteSans-Cond', 'style' => '', 'color' => '#3E3E3E' ),
    				'type' => 'typography' );

$options[] = array( 'name' => __( 'Page Title', 'themeboy' ) ,
    				'desc' => __( 'Change the page title.', 'themeboy' ) ,
    				'id' => $shortname . '_font_page_title',
    				'std' => array( 'size' => '2.2', 'unit' => 'em', 'face' => 'BergamoStd', 'style' => 'bold', 'color' => '#3E3E3E' ),
    				'type' => 'typography' );

$options[] = array( 'name' => __( 'Post Title', 'themeboy' ) ,
    				'desc' => __( 'Change the post title.', 'themeboy' ) ,
    				'id' => $shortname . '_font_post_title',
    				'std' => array( 'size' => '2.2', 'unit' => 'em', 'face' => 'BergamoStd', 'style' => 'bold', 'color' => '#3E3E3E' ),
    				'type' => 'typography' );

$options[] = array( 'name' => __( 'Post Meta', 'themeboy' ),
    				'desc' => __( 'Change the post meta.', 'themeboy' ) ,
    				'id' => $shortname . '_font_post_meta',
    				'std' => array( 'size' => '1', 'unit' => 'em', 'face' => 'BergamoStd', 'style' => '', 'color' => '#3E3E3E' ),
    				'type' => 'typography' );

$options[] = array( 'name' => __( 'Post Entry', 'themeboy' ) ,
    				'desc' => __( 'Change the post entry.', 'themeboy' ) ,
    				'id' => $shortname . '_font_post_entry',
    				'std' => array( 'size' => '1', 'unit' => 'em', 'face' => 'BergamoStd', 'style' => '', 'color' => '#3E3E3E' ),
    				'type' => 'typography' );

$options[] = array( 'name' => __( 'Widget Titles', 'themeboy' ) ,
    				'desc' => __( 'Change the widget titles.', 'themeboy' ) ,
    				'id' => $shortname . '_font_widget_titles',
    				'std' => array( 'size' => '1', 'unit' => 'em', 'face' => 'FontSiteSans-Cond', 'style' => 'bold', 'color' => '#3E3E3E' ),
    				'type' => 'typography' );

/* Layout */

$options[] = array( 'name' => __( 'Layout', 'themeboy' ),
    				'type' => 'heading',
    				'icon' => 'layout' );

$options[] = array( 'name' => __( 'Global Layout', 'themeboy' ),
                    'type' => 'subheading' );

$url =  get_template_directory_uri() . '/functions/images/';
$options[] = array( 'name' => __( 'Main Layout', 'themeboy' ),
    				'desc' => __( 'Select which layout you want for your site.', 'themeboy' ),
    				'id' => $shortname . '_site_layout',
    				'std' => 'layout-left-content',
    				'type' => 'images',
    				'options' => array(
    					'layout-left-content' => $url . '2cl.png',
    					'layout-right-content' => $url . '2cr.png' )
    				);


/* Dynamic Images */

$options[] = array( 'name' => __( 'Dynamic Images', 'themeboy' ),
    				'type' => 'heading',
    				'icon' => 'image' );

$options[] = array( 'name' => __( 'Resizer Settings', 'themeboy' ),
    				'type' => 'subheading' );

$options[] = array( 'name' => __( 'Dynamic Image Resizing', 'themeboy' ),
    				'desc' => '',
    				'id' => $shortname . '_wpthumb_notice',
					"std" => __( 'There are two alternative methods of dynamically resizing the thumbnails in the theme, <strong>WP Post Thumbnail</strong> (default) or <strong>TimThumb</strong>.', 'themeboy' ),
    				'type' => 'info' );

$options[] = array( 'name' => __( 'WP Post Thumbnail', 'themeboy' ),
    				'desc' => __( 'Use WordPress post thumbnail to assign a post thumbnail. Will enable the <strong>Featured Image panel</strong> in your post sidebar where you can assign a post thumbnail.', 'themeboy' ),
    				'id' => $shortname . '_post_image_support',
    				'std' => 'true',
    				'class' => 'collapsed',
    				'type' => 'checkbox' );

$options[] = array( 'name' => __( 'WP Post Thumbnail - Dynamic Image Resizing', 'themeboy' ),
    				'desc' => __( 'The post thumbnail will be dynamically resized using native WP resize functionality. <em>(Requires PHP 5.2+)</em>', 'themeboy' ),
    				'id' => $shortname . '_pis_resize',
    				'std' => 'true',
    				'class' => 'hidden',
    				'type' => 'checkbox' );

$options[] = array( 'name' => __( 'WP Post Thumbnail - Hard Crop', 'themeboy' ),
    				'desc' => __( 'The post thumbnail will be cropped to match the target aspect ratio (only used if "Dynamic Image Resizing" is enabled).', 'themeboy' ),
    				'id' => $shortname . '_pis_hard_crop',
    				'std' => 'true',
    				'class' => 'hidden last',
    				'type' => 'checkbox' );

$options[] = array( 'name' => __( 'TimThumb', 'themeboy' ),
					"desc" => __( 'This will enable the <a href="http://code.google.com/p/timthumb/">TimThumb</a> (thumb.php) script which dynamically resizes images added through the <strong>custom settings panel</strong>  below the post editor. Make sure your themes <em>cache</em> folder is writable. <a href="http://docs.themeboy.com/document/docs-featured-images/">Need help?</a>', 'themeboy' ),
    				'id' => $shortname . '_resize',
    				'std' => 'true',
    				'type' => 'checkbox' );

$options[] = array( 'name' => __( 'Automatic Image Thumbnail', 'themeboy' ),
    				'desc' => __( 'If no thumbnail is specified then the first uploaded image in the post is used.', 'themeboy' ),
    				'id' => $shortname . '_auto_img',
    				'std' => 'false',
    				'type' => 'checkbox' );

$options[] = array( 'name' => __( 'Thumbnail Settings', 'themeboy' ),
    				'type' => 'subheading' );

$options[] = array( 'name' => __( 'Thumbnail Image Dimensions', 'themeboy' ),
    				'desc' => __( 'Enter an integer value i.e. 250 for the desired size which will be used when dynamically creating the images.', 'themeboy' ),
    				'id' => $shortname . '_image_dimensions',
    				'std' => '',
    				'type' => array(
    					array(  'id' => $shortname . '_thumb_w',
    						'type' => 'text',
    						'std' => 1200,
    						'meta' => __( 'Width', 'themeboy' ) ),
    					array(  'id' => $shortname . '_thumb_h',
    						'type' => 'text',
    						'std' => 1200,
    						'meta' => __( 'Height', 'themeboy' ) )
    				) );

$options[] = array( 'name' => __( 'Thumbnail Alignment', 'themeboy' ),
    				'desc' => __( 'Select how to align your thumbnails with posts.', 'themeboy' ),
    				'id' => $shortname . '_thumb_align',
    				'std' => 'aligncenter',
    				'type' => 'select2',
    				'options' => array( 'alignleft' => __( 'Left', 'themeboy' ), 'alignright' => __( 'Right', 'themeboy' ), 'aligncenter' => __( 'Center', 'themeboy' ) ) );

$options[] = array( 'name' => __( 'Single Post - Show Thumbnail', 'themeboy' ),
    				'desc' => __( 'Show the thumbnail in the single post page.', 'themeboy' ),
    				'id' => $shortname . '_thumb_single',
    				'class' => 'collapsed',
    				'std' => 'false',
    				'type' => 'checkbox' );

$options[] = array( 'name' => __( 'Single Post - Thumbnail Dimensions', 'themeboy' ),
    				'desc' => __( 'Enter an integer value i.e. 250 for the image size. Max width is 576.', 'themeboy' ),
    				'id' => $shortname . '_image_dimensions',
    				'std' => '',
    				'class' => 'hidden last',
    				'type' => array(
    					array(  'id' => $shortname . '_single_w',
    						'type' => 'text',
    						'std' => 1200,
    						'meta' => __( 'Width', 'themeboy' ) ),
    					array(  'id' => $shortname . '_single_h',
    						'type' => 'text',
    						'std' => 1200,
    						'meta' => __( 'Height', 'themeboy' ) )
    				) );

$options[] = array( 'name' => __( 'Single Post - Thumbnail Alignment', 'themeboy' ),
    				'desc' => __( 'Select how to align your thumbnail with single posts.', 'themeboy' ),
    				'id' => $shortname . '_thumb_single_align',
    				'std' => 'aligncenter',
    				'type' => 'select2',
    				'class' => 'hidden',
    				'options' => array( 'alignleft' => __( 'Left', 'themeboy' ), 'alignright' => __( 'Right', 'themeboy' ), 'aligncenter' => __( 'Center', 'themeboy' ) ) );

$options[] = array( 'name' => __( 'Add Featured Image to RSS feed', 'themeboy' ),
    				'desc' => __( 'Add the featured image to your RSS feed', 'themeboy' ),
    				'id' => $shortname . '_rss_thumb',
    				'std' => 'false',
    				'type' => 'checkbox' );

/* Contact Template Settings */

$options[] = array( 'name' => __( 'Contact Page', 'themeboy' ),
					'icon' => 'maps',
				    'type' => 'heading');

$options[] = array( 'name' => __( 'Contact Information', 'themeboy' ),
					'type' => 'subheading');

$options[] = array( "name" => __( 'Contact Information Panel', 'themeboy' ),
					"desc" => __( 'Enable the contact information panel on your contact page template.', 'themeboy' ),
					"id" => $shortname."_contact_panel",
					"std" => "false",
					"class" => 'collapsed',
					"type" => "checkbox" );

$options[] = array( 'name' => __( 'Location Name', 'themeboy' ),
					'desc' => __( 'Enter the location name. Example: London Office', 'themeboy' ),
					'id' => $shortname . '_contact_title',
					'std' => '',
					'class' => 'hidden',
					'type' => 'text' );

$options[] = array( 'name' => __( 'Location Address', 'themeboy' ),
					'desc' => __( "Enter your company's address", 'themeboy' ),
					'id' => $shortname . '_contact_address',
					'std' => '',
					'class' => 'hidden',
					'type' => 'textarea' );

$options[] = array( 'name' => __( 'Telephone', 'themeboy' ),
					'desc' => __( 'Enter your telephone number', 'themeboy' ),
					'id' => $shortname . '_contact_number',
					'std' => '',
					'class' => 'hidden',
					'type' => 'text' );

$options[] = array( 'name' => __( 'Fax', 'themeboy' ),
					'desc' => __( 'Enter your fax number', 'themeboy' ),
					'id' => $shortname . '_contact_fax',
					'std' => '',
					'class' => 'hidden last',
					'type' => 'text' );

$options[] = array( 'name' => __( 'Contact Form E-Mail', 'themeboy' ),
					'desc' => __( "Enter your E-mail address to use on the 'Contact Form' page Template.", 'themeboy' ),
					'id' => $shortname.'_contactform_email',
					'std' => '',
					'type' => 'text' );

$options[] = array( 'name' => __( 'Maps', 'themeboy' ),
					'type' => 'subheading');

$options[] = array( 'name' => __( 'Contact Form Google Maps Coordinates', 'themeboy' ),
					'desc' => sprintf( __( 'Enter your Google Map coordinates to display a map on the Contact Form page template and a link to it on the Contact Us widget. You can get these details from %1$s', 'themeboy' ), '<a href="http://itouchmap.com/latlong.html" target="_blank">Google Maps</a>' ),
					'id' => $shortname . '_contactform_map_coords',
					'std' => '',
					'type' => 'text' );

$options[] = array( 'name' => __( 'Map Callout Text', 'themeboy' ),
					'desc' => __( 'Text or HTML that will be output when you click on the map marker for your location.', 'themeboy' ),
					'id' => $shortname . '_maps_callout_text',
					'std' => '',
					'type' => 'textarea');

// Add extra options through function
if ( function_exists( 'tb_options_add') )
	$options = tb_options_add($options);

if ( get_option( 'tb_template') != $options) update_option( 'tb_template',$options);
if ( get_option( 'tb_themename') != $themename) update_option( 'tb_themename',$themename);
if ( get_option( 'tb_shortname') != $shortname) update_option( 'tb_shortname',$shortname);
if ( get_option( 'tb_manual') != $manualurl) update_option( 'tb_manual',$manualurl);

// TB Metabox Options
// Start name with underscore to hide custom key from the user
global $post;
$tb_metaboxes = array();

// Shown on both posts and pages


// Show only on specific post types or page

if ( ( get_post_type() == 'post') || ( !get_post_type() ) ) {

	// TimThumb is enabled in options
	if ( get_option( 'tb_resize') == 'true' ) {

		$tb_metaboxes[] = array (	'name' => 'image',
									'label' => __( 'Image', 'themeboy' ),
									'type' => 'upload',
									'desc' => __( 'Upload an image or enter an URL.', 'themeboy' ) );

		$tb_metaboxes[] = array (	'name' => '_image_alignment',
									'std' => __( 'Center', 'themeboy' ),
									'label' => __( 'Image Crop Alignment', 'themeboy' ),
									'type' => 'select2',
									'desc' => __( 'Select crop alignment for resized image', 'themeboy' ),
									'options' => array(	'c' => 'Center',
														't' => 'Top',
														'b' => 'Bottom',
														'l' => 'Left',
														'r' => 'Right'));
	// TimThumb disabled in the options
	} else {

		$tb_metaboxes[] = array (	'name' => '_timthumb-info',
									'label' => __( 'Image', 'themeboy' ),
									'type' => 'info',
									'desc' => sprintf( __( '%1$s is disabled. Use the %2$s panel in the sidebar instead, or enable TimThumb in the options panel.', 'themeboy' ), '<strong>'.__( 'TimThumb', 'themeboy' ).'</strong>', '<strong>'.__( 'Featured Image', 'themeboy' ).'</strong>' ) ) ;

	}

	$tb_metaboxes[] = array (  'name'  => 'embed',
					            'std'  => '',
					            'label' => __( 'Embed Code', 'themeboy' ),
					            'type' => 'textarea',
					            'desc' => __( 'Enter the video embed code for your video (YouTube, Vimeo or similar)', 'themeboy' ) );

} // End post

$tb_metaboxes[] = array (	'name' => '_layout',
							'std' => 'normal',
							'label' => __( 'Layout', 'themeboy' ),
							'type' => 'images',
							'desc' => __( 'Select the layout you want on this specific post/page.', 'themeboy' ),
							'options' => array(
										'layout-default' => $url . 'layout-off.png',
										'layout-full' => get_template_directory_uri() . '/functions/images/' . '1c.png',
										'layout-left-content' => get_template_directory_uri() . '/functions/images/' . '2cl.png',
										'layout-right-content' => get_template_directory_uri() . '/functions/images/' . '2cr.png'));


if ( get_post_type() == 'slide' || ! get_post_type() ) {
        $tb_metaboxes[] = array (
                                    'name' => 'url',
                                    'label' => __( 'Slide URL', 'themeboy' ),
                                    'type' => 'text',
                                    'desc' => sprintf( __( 'Enter an URL to link the slider title to a page e.g. %s (optional)', 'themeboy' ), 'http://yoursite.com/pagename/' )
                                    );

        $tb_metaboxes[] = array (
                                    'name'  => 'embed',
                                    'std'  => '',
                                    'label' => __( 'Embed Code', 'themeboy' ),
                                    'type' => 'textarea',
                                    'desc' => __( 'Enter the video embed code for your video (YouTube, Vimeo or similar)', 'themeboy' )
                                    );
} // End Slide

// Add extra metaboxes through function
if ( function_exists( 'tb_metaboxes_add' ) )
	$tb_metaboxes = tb_metaboxes_add( $tb_metaboxes );

if ( get_option( 'tb_custom_template' ) != $tb_metaboxes) update_option( 'tb_custom_template', $tb_metaboxes );

} // END tb_options()
} // END function_exists()

// Add options to admin_head
add_action( 'admin_head', 'tb_options' );

//Global options setup
add_action( 'init', 'tb_global_options' );
function tb_global_options(){
	// Populate ThemeBoy option in array for use in theme
	global $tb_options;
	$tb_options = get_option( 'tb_options' );
}
