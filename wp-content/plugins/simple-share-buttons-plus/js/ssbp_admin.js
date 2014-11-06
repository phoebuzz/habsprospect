jQuery(document).ready(function() {

	//------- INCLUDE LIST ----------//

	// add drag and sort functions to include table
	jQuery(function() {
		jQuery( "#ssbpsort1, #ssbpsort2" ).sortable({
			connectWith: ".connectedSortable"
		}).disableSelection();
	  });
	 
	// extract and add include list to hidden field
	jQuery('#ssbp_selected_buttons').val(jQuery('#ssbpsort2 li').map(function() {
	// For each <li> in the list, return its inner text and let .map()
	//  build an array of those values.
	return jQuery(this).attr('id');
	}).get());
	  
	// after a change, extract and add include list to hidden field
	jQuery('.ssbp-include-list').mouseout(function() {
		jQuery('#ssbp_selected_buttons').val(jQuery('#ssbpsort2 li').map(function() {
		// For each <li> in the list, return its inner text and let .map()
		//  build an array of those values.
		return jQuery(this).attr('id');
		}).get());
	});
	
	// when support details textarea is clicked
	jQuery('#ssbp-support-textarea,.support-details-btn').click(function(){
		// select text in support details textarea
		document.getElementById("ssbp-support-textarea").select();
	});
	
	// color picker
	jQuery('#ssbp_font_color,#ssbp_color_main,#ssbp_color_border,#ssbp_color_hover').wpColorPicker();
	
	// when circle buttons is clicked
	jQuery('#ssbp_circle_buttons').click(function(){
	
		// if box has been checked
		if(jQuery('#ssbp_circle_buttons').prop('checked')) {
			jQuery(".ssbp_show_btn_txt").hide(150);
			jQuery('#ssbp_show_btn_txt').attr('checked', false);
		} else {
			jQuery(".ssbp_show_btn_txt").show(150);
		}
		
	});

	// when the default style dropdown is changed
	jQuery('#ssbp_default_style').change(function(){
	
		// if a default style has been selected
		if(jQuery("#ssbp_default_style").val() == '') {
			jQuery(".ssbp_default_styles").hide(150);
			jQuery("#ssbp_non_default").show(150);
		} else {
			jQuery("#ssbp_non_default").hide(150);
			jQuery(".ssbp_default_styles").show(150);
		}
		
	});
	
	// when custom images checkbox is clicked
	jQuery('#ssbp_custom_images').change(function(){
	
		// if box has been checked
		if(jQuery('#ssbp_custom_images').prop('checked')) {
			jQuery(".ssbp_custom_image").show(150);
			jQuery(".ssbp_non_custom_image").hide(150);
		} else {
			jQuery(".ssbp_custom_image").hide(150);
			jQuery(".ssbp_non_custom_image").show(150);
		}
		
	});
	
	// when custom style button is clicked
	jQuery('#ssbp_button_custom_styles').click(function(){
	
		// hide show custom css and hide normal settings
		jQuery("#ssbp_option_custom_css").show();
		jQuery("#ssbp_normal_settings").hide();
	}); 
	
	// when show custom colours is clicked
	jQuery('#ssbp_button_custom_colours').click(function(){
	
		// show custom colour settings
		jQuery('.ssbp-custom-colours').toggle(150);
	}); 
	
	// when assisted CSS button is clicked
	jQuery('#ssbp_button_normal_settings').click(function(){
	
		// hide show custom css and hide normal settings
		jQuery("#ssbp_normal_settings").show(150);
		jQuery("#ssbp_option_custom_css").hide(150);
	}); 
	
	// when counter CSS is clicked
	jQuery('#ssbp_counter_normal_settings').click(function(){
	
		// hide show custom css and hide normal settings
		jQuery("#ssbp_counter_settings").show(150);
		jQuery("#ssbp_counter_custom_css").hide(150);
		
		// clear the contents of the custom css field
		// this must be done so that the custom styles don't
		// continue to overwrite other styles
		jQuery('#ssbp_share_count_css').val('');
	});
	
	// ----- IMAGE UPLOADS ------ //	 

	// custom image upload
	jQuery('.customUpload').click(function() {
	
		// get custom data field for the text field to return the url to
		var strInputID = jQuery(this).data('ssbp-input');
		
		// simple function to change button text after loading window
		ssba_tb_interval = setInterval( function() { 
			jQuery('#TB_iframeContent').contents().find('.savesend .button').val('Use this image'); 
		}, 200 );
		
		// load thickbox window with upload options
		tb_show('Upload Image', 'media-upload.php?type=image&amp;TB_iframe=true');
		
		// send image back to the text field
		window.send_to_editor = function(html) {
			imgurl = jQuery('img',html).attr('src');
			jQuery('#' + strInputID).val(imgurl);
			tb_remove();
		};
		
		return false;
	});
	
	// select ortsh url upon clicking the text input
	jQuery(".ssbp-ortsh-input-url").on("click", function () {
	   jQuery(this).select();
	});

});