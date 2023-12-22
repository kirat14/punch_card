<?php
// disable direct file access
if (!defined('ABSPATH')) {

	exit;

}

// User Settings Errors
add_filter('user_profile_update_errors', 'punch_card_user_settings_errors', 10, 3);
function punch_card_user_settings_errors($errors, $update, $user)
{
	$selected_punch_card = sanitize_text_field($_POST['selected_punch_card']);
	$game_played = intval($_POST['game_played']);
	// Validate game_played against milestone_to_reward
	$milestone_to_reward = get_post_meta($selected_punch_card, 'milestone_to_reward', true);

	//error_log(print_r($update, true));
	if ($game_played > $milestone_to_reward) {
		$errors->add('my-plugin-invalid-admin-level', '<strong>ERROR:</strong> Games Played cannot exceed the Milestone To Reward for the selected punch card.');
	}
}



function validate_and_save_phone($errors, $update, $user) {
    if (isset($_POST['phone'])) {
        $phone = sanitize_text_field($_POST['phone']);

        // Your custom phone number validation logic
        if (!is_numeric($phone) || strlen($phone) !== 10) {
            // Phone number doesn't match the required criteria
            $errors->add('invalid_phone', __('Invalid phone number. Please enter a 10-digit numeric value.', PUNCHCARDDOMAIN));
        } else {
            // Valid phone number, save it
            update_user_meta($user->ID, 'phone', $phone);
        }
    }

    return $errors;
}

add_filter('user_profile_update_errors', 'validate_and_save_phone', 10, 3);

