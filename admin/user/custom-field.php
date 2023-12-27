<?php
// disable direct file access
if (!defined('ABSPATH')) {

	exit;

}

function admin_assign_card_rendering($user_ID, $selected_punch_card, $milestone_to_reward, $game_played)
{
	$card_assignment_date = get_user_meta($user_ID, 'card_assignment_date', true);
	if (empty($card_assignment_date))
		$card_assignment_date = date("d-m-Y H:i");

	// Convert to the required format
	$card_assignment_date = date('Y-m-d\TH:i', strtotime($card_assignment_date));
	?>
	<h3>
		<?php _e('Assing User Loyalty Card', PUNCHCARDDOMAIN); ?>
	</h3>

	<table class="form-table">
		<tr>
			<th>
				<label for="selected_punch_card">
					<?php _e('Select a Loyalty Card', PUNCHCARDDOMAIN); ?>
				</label>
			</th>
			<td>
				<?php
				$args = array(
					'post_type' => 'punch-card',
					'posts_per_page' => -1,
				);

				$punch_card_posts = get_posts($args);
				?>
				<select name="selected_punch_card" id="selected_punch_card">
					<option value="">
						<?php _e('Select a Loyalty Card', PUNCHCARDDOMAIN); ?>
					</option>
					<?php
					foreach ($punch_card_posts as $punch_card) {
						echo '<option value="' . esc_attr($punch_card->ID) . '" ' . selected($selected_punch_card, $punch_card->ID, false) . '>' . esc_html($punch_card->post_title) . '</option>';
					}
					?>
				</select>
			</td>
		</tr>

		<tr>
			<th>
				<label>
					<?php _e('Milestone To Reward', PUNCHCARDDOMAIN); ?>
				</label>
			</th>
			<td>
				<label>
					<?php echo esc_attr($milestone_to_reward); ?>
				</label>
			</td>
		</tr>

		<tr>
			<th>
				<label for="game_played">
					<?php _e('Games Played', PUNCHCARDDOMAIN); ?>
				</label>
			</th>
			<td>
				<input type="number" name="game_played" id="game_played" value="<?php
				echo esc_attr($game_played); ?>" min="0" step="1">
			</td>
		</tr>

		<tr>
			<th>
				<label for="card_assignment_date">
					<?php _e('Assigned On', PUNCHCARDDOMAIN); ?>
				</label>
			</th>
			<td>
				<input type="datetime-local" id="card_assignment_date" name="card_assignment_date"
					value="<?php echo esc_attr($card_assignment_date) ?>"
					pattern="(0[1-9]|1[0-2])-(0[1-9]|[12][0-9]|3[01])-\d{4} (0[0-9]|1[0-9]|2[0-3]):[0-5][0-9]"
					title="<?php _e('Enter a valid datetime (dd-mm-yyyy hh:MM)', PUNCHCARDDOMAIN); ?>" required>
			</td>
		</tr>
	</table>
	<?php
}


function user_current_punch_card($selected_punch_card, $milestone_to_reward, $game_played)
{

	$terms = get_the_terms($selected_punch_card, 'pool-game-type');
	$name = '';
	if (!is_a($terms, 'WP_Error') && $terms !== false) {
		$name = get_the_title($selected_punch_card) . ' ' . $terms[0]->name;
	}

	?>
	<h3>
		<?php _e('Loyalty Card', PUNCHCARDDOMAIN); ?>
	</h3>

	<table class="form-table">
		<tr>
			<th>
				<label>
					<?php _e('Current Loyalty Card', PUNCHCARDDOMAIN); ?>
				</label>
			</th>
			<td>
				<label>
					<?php echo esc_html($name) ?>
				</label>
			</td>
		</tr>

		<tr>
			<th>
				<label>
					<?php _e('Milestone To Reward', PUNCHCARDDOMAIN); ?>
				</label>
			</th>
			<td>
				<label>
					<?php echo esc_attr($milestone_to_reward); ?>
				</label>
			</td>
		</tr>

		<tr>
			<th>
				<label for="game_played">
					<?php _e('Games Played', PUNCHCARDDOMAIN); ?>
				</label>
			</th>
			<td>
				<label>
					<?php echo esc_attr($game_played); ?>
				</label>
			</td>
		</tr>
	</table>
	<?php
}


// Add custom user profile field
function custom_user_profile_fields($user)
{
	$selected_punch_card = get_user_meta($user->ID, 'selected_punch_card', true);
	$milestone_to_reward = get_post_meta($selected_punch_card, 'milestone_to_reward', true);
	$game_played = get_user_meta($user->ID, 'game_played', true);
	if (current_user_can('administrator')):
		admin_assign_card_rendering($user->ID, $selected_punch_card, $milestone_to_reward, $game_played);
	else:
		user_current_punch_card($selected_punch_card, $milestone_to_reward, $game_played);
	endif;

}
add_action('show_user_profile', 'custom_user_profile_fields');
add_action('edit_user_profile', 'custom_user_profile_fields');


// Add phone number after contact section
function custom_get_user_contact_methods($methods, $user)
{
	// Add phone contact method
	$methods['phone'] = __('Phone Number', PUNCHCARDDOMAIN);

	return $methods;
}

add_filter('user_contactmethods', 'custom_get_user_contact_methods', 10, 2);


