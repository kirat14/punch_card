<?php
// exit if file is called directly
if ( ! defined( 'ABSPATH' ) ) {

	exit;

}

// add top-level administrative menu
function punch_card_plugin_add_toplevel_menu() {
	/* 
		add_menu_page(
			string   $page_title, 
			string   $menu_title, 
			string   $capability, 
			string   $menu_slug, 
			callable $function = '', 
			string   $icon_url = '', 
			int      $position = null 
		)
	*/
	add_menu_page(
		'Punch card Settings',
		'Punch card plugin',
		'manage_options',
		'punch_card_plugin',
		'punch_card_plugin_display_settings_page',
		'dashicons-admin-generic',
		null
	);
	
}


// add sub-level administrative menu
function punch_card_plugin_add_sublevel_menu() {
	
	/*
	
	add_submenu_page(
		string   $parent_slug,
		string   $page_title,
		string   $menu_title,
		string   $capability,
		string   $menu_slug,
		callable $function = ''
	);
	
	*/
	
	add_submenu_page(
		'options-general.php',
		'Punch Card Settings',
		'Punch Card Settings',
		'manage_options',
		'options_punch_card_page',
		'punch_card_plugin_display_settings_page'
	);
	
}

//add_action( 'admin_menu', 'punch_card_plugin_add_sublevel_menu' );
add_action( 'admin_menu', 'punch_card_plugin_add_toplevel_menu' );