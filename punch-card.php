<?php
/*
Plugin Name: Punch Card
Description: Welcome to WordPress plugin development.
Plugin URI:  https://moumini.tarik.online
Author:      Tarik Moumini
Version:     1.0
License:     GPLv2 or later

This program is free software; you can redistribute it and/or
modify it under the terms of the GNU General Public License
as published by the Free Software Foundation; either version
2 of the License, or (at your option) any later version.

This program is distributed in the hope that it will be useful,
but WITHOUT ANY WARRANTY; without even the implied warranty of
MERCHANTABILITY or FITNESS FOR A PARTICULAR PURPOSE.  See the
GNU General Public License for more details.

You should have received a copy of the GNU General Public License
with this program. If not, visit: https://www.gnu.org/licenses/
*/

// exit if file is called directly
if (!defined('ABSPATH')) {

	exit;

}

if (is_admin()) {

	// include plugin dependencies
	require_once plugin_dir_path(__FILE__) . 'admin/admin-menu.php';
	require_once plugin_dir_path(__FILE__) . 'admin/settings-page.php';
	require_once plugin_dir_path(__FILE__) . 'admin/settings-register.php';
	require_once plugin_dir_path(__FILE__) . 'admin/settings-callbacks.php';

	// default plugin options
	function punch_card_options_default()
	{

		return array(
			'company_name' => 'You Stick Out',
			'sub_title' => 'Digital Agency',
			'company_website' => 'https://youstickout.com',
			'punch_card_message' => 'Come in for free coffee!'
		);

	}
}