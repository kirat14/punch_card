<?php
/*
Plugin Name: Punch Card
Description: Welcome to WordPress plugin development.
Plugin URI:  https://moumini.tarik.online
Author:      Tarik Moumini
Version:     1.0
License:     GPLv2 or later
Text Domain: punch-card
Domain Path: /languages/

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

define('PUNCHCARDDOMAIN', 'punch-card');
define('PUNCHCARDPATH', plugin_dir_path(__FILE__));


require_once PUNCHCARDPATH . 'includes/helper_validation.php';
require_once PUNCHCARDPATH . 'admin/user/customize-user-profile.php';

if (is_admin()) {

	// include plugin dependencies
	require_once PUNCHCARDPATH . 'admin/admin-menu.php';
	require_once PUNCHCARDPATH . 'admin/settings-page.php';
	require_once PUNCHCARDPATH . 'admin/settings-register.php';
	require_once PUNCHCARDPATH . 'admin/settings-callbacks.php';
	require_once PUNCHCARDPATH . 'admin/user/custom-field.php';
	require_once PUNCHCARDPATH . 'admin/user/profile-error-validation.php';
	require_once PUNCHCARDPATH . 'admin/user/update-profile.php';

	// default plugin options
	function punch_card_plugin_settings_default()
	{

		return array(
			'company_name' => 'You Stick Out',
			'sub_title' => 'Digital Agency',
			'company_website' => 'https://youstickout.com',
			'punch_card_message' => '<h2>Come in for free coffee!</h2>'
		);

	}
}


// Punch Card Post Type
require_once PUNCHCARDPATH . 'post-types/register.php';
add_action('init', 'punch_card_card_type');

// Punch Card Taxonomy
require_once(PUNCHCARDPATH . '/taxonomies/register.php');
add_action('init', 'pcard_register_pgame_type_taxonomy');


require_once PUNCHCARDPATH . 'admin/user/registration/registration-form.php';


add_action('plugins_loaded', 'punch_card_load_text_domain');
function punch_card_load_text_domain()
{
	load_plugin_textdomain(PUNCHCARDDOMAIN, false, dirname(plugin_basename(__FILE__)) . '/languages/');
}

