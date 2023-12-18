<?php
// disable direct file access
if (!defined('ABSPATH')) {

    exit;

}

// callback: Punch Card data section
function punch_card_callback_section_data() {

	echo '<p>These settings enable you to customize the data to be displayed on the punch card.</p>';

}


// callback: text field
function punch_card_callback_field_text( $args ) {
	
	$options = get_option( 'punch_card_title_option', punch_card_options_default() );
	
	$id    = isset( $args['id'] )    ? $args['id']    : '';
	$label = isset( $args['label'] ) ? $args['label'] : '';
	
	$value = isset( $options[$id] ) ? sanitize_text_field( $options[$id] ) : '';
	
	echo '<input id="punch_card_title_option_'. $id .'" name="punch_card_title_option['. $id .']" type="text" size="40" value="'. $value .'"><br />';
	echo '<label for="punch_card_title_option_'. $id .'">'. $label .'</label>';
	
}