<?php
defined('ABSPATH') or die("No direct access permitted");

// add meta data to head as required
function get_ssbp_meta() {

	// get settings
	$arrSettings = get_ssbp_settings();

	// if a custom share title is set,  use the custom share title
	if(get_post_meta(get_the_ID(), '_ssbp_meta_title', true))
		$strSSBPTitle = get_post_meta(get_the_ID(), '_ssbp_meta_title', true);
	else // or use the default set in SSBP admin
		$strSSBPTitle = $arrSettings['ssbp_meta_title'];
	
	// if a custom share description had been set, use the custom share description
	if(get_post_meta(get_the_ID(), '_ssbp_meta_description', true))
		$strSSBPDescription = get_post_meta(get_the_ID(), '_ssbp_meta_description', true);
	else // or use the default set in SSBP admin
		$strSSBPDescription = $arrSettings['ssbp_meta_description'];
	
	// if a custom share image is set, use the custom share image
	if(get_post_meta( get_the_ID(), '_ssbp_meta_image', true))
		$strSSBPImage = get_post_meta(get_the_ID(), '_ssbp_meta_image', true);
	else // or use the default set in SSBP admin
		$strSSBPImage = $arrSettings['ssbp_meta_image'];
	
// insert left aligned meta information, with line breaks above and below
echo "\n".'<!-- START simplesharebuttons.com/plus meta data -->
<!-- simplesharebuttons.com/plus opengraph share details -->
<meta property="og:title" content="'.$strSSBPTitle.'"/>
<meta property="og:description" content="'.$strSSBPDescription.'"/>
<meta property="og:image" content="'.$strSSBPImage.'"/>
<!-- simplesharebuttons.com/plus twitter share details -->
<meta name="twitter:title" content="'.$strSSBPTitle.'">
<meta name="twitter:description" content="'.$strSSBPDescription.'">
<meta name="twitter:image:src" content="'.$strSSBPImage.'">
<!-- simplesharebuttons.com/plus google+ share details --> 	
<meta itemprop="name" content="'.$strSSBPTitle.'">
<meta itemprop="description" content="'.$strSSBPDescription.'">
<meta itemprop="image" content="'.$strSSBPImage.'">
<!-- END simplesharebuttons.com/plus meta data -->'."\n"	;
}

// Add meta boxes to the main column on the Post and Page edit screens
function ssbp_add_meta_box() {

	$screens = array( 'post', 'page' );

	foreach ( $screens as $screen ) {

		add_meta_box(
			'ssbp_sectionid',
			__( 'Simple Share Buttons Meta', 'ssbp_title' ),
			'ssbp_meta_box_callback',
			$screen
		);
	}
}
add_action( 'add_meta_boxes', 'ssbp_add_meta_box' );

/**
 * Prints the box content.
 * 
 * @param WP_Post $post The object for the current post/page.
 */
function ssbp_meta_box_callback( $post ) {

	// Add an nonce field so we can check for it later.
	wp_nonce_field( 'ssbp_meta_box', 'ssbp_meta_box_nonce' );

	/*
	 * Use get_post_meta() to retrieve an existing value
	 * from the database and use the value for the form.
	 */
	$ssbpTitle = get_post_meta( $post->ID, '_ssbp_meta_title', true );
	$ssbpImage = get_post_meta( $post->ID, '_ssbp_meta_image', true );
	$ssbpDescription = get_post_meta( $post->ID, '_ssbp_meta_description', true );

	echo '<table>';
		echo '<tr>';
			echo '<td style="min-width:115px">';
				echo '<label for="ssbp_meta_title">';
				_e( 'Share Title', 'ssbp_meta_title' );
				echo '</label> ';
			echo '</td>';
			echo '<td style="width:100%">';
				echo '<input type="text" style="width:100%" id="ssbp_meta_title" name="ssbp_meta_title" value="' . esc_attr( $ssbpTitle ) . '" />';
			echo '</td>';
		echo '</tr>';
		echo '<tr>';
			echo '<td style="min-width:115px">';	
				echo '<label for="ssbp_meta_description">';
				_e( 'Share Description', 'ssbp_meta_description' );
				echo '</label> ';
			echo '</td>';
			echo '<td style="width:100%">';
				echo '<textarea id="ssbp_meta_description" style="width:100%" name="ssbp_meta_description">' . esc_attr( $ssbpDescription ) . '</textarea>';
			echo '</td>';
		echo '</tr>';
		echo '<tr>';
			echo '<td style="min-width:115px">';
				echo '<label for="ssbp_meta_image">';
				_e( 'Share Image', 'ssbp_meta_image' );
				echo '</label> ';
			echo '</td>';
			echo '<td style="width:100%">';
				echo '<input id="ssbp_meta_image" type="text" style="width:78%" name="ssbp_meta_image" value="' . esc_attr( $ssbpImage ) . '" />';
				echo '<input id="upload_image_button" style="width:20%; float: right;" data-ssbp-input="ssbp_meta_image" class="button customUpload" type="button" value="Upload Image" />';
			echo '</td>';
		echo '</tr>';
	echo '</table>';
	echo '<p>Please also note that Facebook caches webpage details on each share click, until updated using the <a href="https://developers.facebook.com/tools/debug/" target="_blank">Facebook debugger</a></p>';
}

/**
 * When the post is saved, saves our custom data.
 *
 * @param int $post_id The ID of the post being saved.
 */
function ssbp_save_meta_box_data( $post_id ) {

	/*
	 * We need to verify this came from our screen and with proper authorization,
	 * because the save_post action can be triggered at other times.
	 */

	// Check if our nonce is set.
	if ( ! isset( $_POST['ssbp_meta_box_nonce'] ) ) {
		return;
	}

	// Verify that the nonce is valid.
	if ( ! wp_verify_nonce( $_POST['ssbp_meta_box_nonce'], 'ssbp_meta_box' ) ) {
		return;
	}

	// If this is an autosave, our form has not been submitted, so we don't want to do anything.
	if ( defined( 'DOING_AUTOSAVE' ) && DOING_AUTOSAVE ) {
		return;
	}

	// Check the user's permissions.
	if ( isset( $_POST['post_type'] ) && 'page' == $_POST['post_type'] ) {

		if ( ! current_user_can( 'edit_page', $post_id ) ) {
			return;
		}

	} else {

		if ( ! current_user_can( 'edit_post', $post_id ) ) {
			return;
		}
	}

	/* OK, it's safe for us to save the data now. */
	
	// Make sure that it is set.
	if ( ! isset( $_POST['ssbp_meta_title'] ) ) {
		return;
	}

	// Sanitize user input.
	$ssbpTitle = sanitize_text_field( $_POST['ssbp_meta_title'] );
	$ssbpImage = sanitize_text_field( $_POST['ssbp_meta_image'] );
	$ssbpDescription = sanitize_text_field( $_POST['ssbp_meta_description'] );

	// Update the meta field in the database.
	update_post_meta( $post_id, '_ssbp_meta_title', $ssbpTitle );
	update_post_meta( $post_id, '_ssbp_meta_image', $ssbpImage );
	update_post_meta( $post_id, '_ssbp_meta_description', $ssbpDescription );
}
add_action( 'save_post', 'ssbp_save_meta_box_data' );