<?php
// disable direct file access
if (!defined('ABSPATH')) {

    exit;

}

add_action( 'admin_init', 'punch_card_register_settings' );

function punch_card_register_settings()
{
    register_setting(
        'punch_card_plugin_option_group',
        'punch_card_plugin_settings');

    add_settings_section(
        'punch_card_main_section',
        'Punch Card Data',
        'punch_card_callback_section_data',
        'punch_card_options_page'
    );

    add_settings_field(
		'company_name',
		'Company Name',
		'punch_card_callback_field_text',
		'punch_card_options_page',
		'punch_card_main_section',
		[ 'id' => 'company_name', 'label' => 'Company name to be shown on the Punch Card' ]
	);

    add_settings_field(
		'sub_title',
		'Sub Title',
		'punch_card_callback_field_text',
		'punch_card_options_page',
		'punch_card_main_section',
		[ 'id' => 'sub_title', 'label' => 'Sub Title to be shown on the Punch Card' ]
	);

    add_settings_field(
		'company_website',
		'Company Website',
		'punch_card_callback_field_text',
		'punch_card_options_page',
		'punch_card_main_section',
		[ 'id' => 'company_website', 'label' => 'Company Website to be shown on the Punch Card' ]
	);

    add_settings_field(
		'punch_card_message',
		'Punch Card front message',
		'punch_card_callback_field_textarea',
		'punch_card_options_page',
		'punch_card_main_section',
		[ 'id' => 'punch_card_message', 'label' => 'Message to be shown on the Punch Card front' ]
	);
}