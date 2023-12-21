<?php
// disable direct file access
if (!defined('ABSPATH')) {

	exit;

}

// Save custom user profile field
function save_custom_user_profile_fields($user_id)
{
	$selected_punch_card = sanitize_text_field($_POST['selected_punch_card']);
	$game_played = intval($_POST['game_played']);
	// Validate game_played against milestone_to_reward
	$milestone_to_reward = intval(get_post_meta($selected_punch_card, 'milestone_to_reward', true));

	if (current_user_can('edit_user', $user_id)) {
		if ($game_played == $milestone_to_reward) {
			//
			////// Add rewarded punch cards
			//

			// Get existing punch cards for the user
			$punch_cards = get_user_meta($user_id, 'rewarded_punch_cards', true);
			$punch_cards = is_array($punch_cards) ? $punch_cards : [];

			// Add the punch card to rewarded list
			$punch_cards[] = $selected_punch_card;
			// Update the user meta with the array of PunchCard objects
			update_user_meta($user_id, 'rewarded_punch_cards', $punch_cards);

			// remove the selected punch card
			delete_user_meta($user_id, 'selected_punch_card');
			delete_user_meta($user_id, 'game_played');
		} else if ($game_played < $milestone_to_reward) {
			update_user_meta($user_id, 'selected_punch_card', $selected_punch_card);
			update_user_meta($user_id, 'game_played', $game_played);
		}
	}
}
add_action('personal_options_update', 'save_custom_user_profile_fields');
add_action('edit_user_profile_update', 'save_custom_user_profile_fields');