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
	
	$options = get_option( 'punch_card_plugin_settings', punch_card_plugin_settings_default() );
	
	$id    = isset( $args['id'] )    ? $args['id']    : '';
	$label = isset( $args['label'] ) ? $args['label'] : '';

	
	$value = isset( $options[$id] ) ? sanitize_text_field( $options[$id] ) : '';
	
	echo '<input id="punch_card_plugin_setting_'. $id .'" name="punch_card_plugin_settings['. $id .']" type="text" size="40" value="'. $value .'"><br />';
	echo '<label for="punch_card_plugin_setting_'. $id .'">'. $label .'</label>';
	
}

// callback: textarea field
function punch_card_callback_field_textarea( $args ) {
	
	$options = get_option( 'punch_card_plugin_settings', punch_card_plugin_settings_default() );
	
	$id    = isset( $args['id'] )    ? $args['id']    : '';
	$label = isset( $args['label'] ) ? $args['label'] : '';
	
	$allowed_tags = wp_kses_allowed_html( 'post' );
	
	$value = isset( $options[$id] ) ? wp_kses( stripslashes_deep( $options[$id] ), $allowed_tags ) : '';
	
	echo '<textarea id="punch_card_plugin_setting_'. $id .'" name="punch_card_plugin_settings['. $id .']" rows="5" cols="50">'. $value .'</textarea><br />';
	echo '<label for="punch_card_plugin_setting_'. $id .'">'. $label .'</label>';
	
}