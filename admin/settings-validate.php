<?php // MyPlugin - Validate Settings



// disable direct file access
if ( ! defined( 'ABSPATH' ) ) {
	
	exit;
	
}



// callback: validate options
function myplugin_callback_validate_options( $input ) {
	
	// custom url
	if ( isset( $input['company_website'] ) ) {
		
		$input['company_website'] = esc_url( $input['company_website'] );
		
	}
	
	// company_name
	if ( isset( $input['company_name'] ) ) {
		
		$input['company_name'] = sanitize_text_field( $input['company_name'] );
		
	}
	
	// sub_title
	if ( isset( $input['sub_title'] ) ) {
		
		$input['sub_title'] = sanitize_text_field( $input['sub_title'] );
		
	}

	// punch_card_message
	if ( isset( $input['punch_card_message'] ) ) {
		
		$input['punch_card_message'] = wp_kses_post( $input['punch_card_message'] );
		
	}
	
	return $input;
	
}


