<?php
// disable direct file access
if (!defined('ABSPATH')) {

	exit;

}


// Add custom user profile field
function custom_user_profile_fields($user)
{
	$selected_punch_card = get_user_meta($user->ID, 'selected_punch_card', true);
	$milestone_to_reward = get_post_meta($selected_punch_card, 'milestone_to_reward', true);
	$game_played = get_user_meta($user->ID, 'game_played', true);
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
	</table>
	<?php
}
add_action('show_user_profile', 'custom_user_profile_fields');
add_action('edit_user_profile', 'custom_user_profile_fields');


// Show List of rewarded punch cards
function show_rewarded_punch_cards($user)
{
	$rewarded_punch_cards = get_user_meta($user->ID, 'rewarded_punch_cards', true);
	?>
	<h3>
		<?php _e('Rewarded Punch Cards', PUNCHCARDDOMAIN); ?>
	</h3>

	<?php if (!empty($rewarded_punch_cards)): ?>
		<table class="form-table">
			<tr>
				<th>
					<?php _e('Title', PUNCHCARDDOMAIN); ?>
				</th>
				<th>
					<?php _e('Milestone To Reward', PUNCHCARDDOMAIN); ?>
				</th>
				<th>
					<?php _e('Reward', PUNCHCARDDOMAIN); ?>
				</th>
			</tr>
			<?php foreach ($rewarded_punch_cards as $punch_card_id): ?>
				<tr>
					<td>
						<?php echo esc_html($punch_card_id); ?>
					</td>
					<td>
						<?php echo esc_html(get_post_meta($punch_card_id, 'milestone_to_reward', true)); ?>
					</td>
					<td>
						<?php echo esc_html(get_post_meta($punch_card_id, 'reward', true)); ?>
					</td>
				</tr>
			<?php endforeach; ?>
		</table>
	<?php else: ?>
		<p>
			<?php _e('No Punch Cards Assigned', PUNCHCARDDOMAIN); ?>
		</p>
	<?php endif; ?>
<?php
}
add_action('show_user_profile', 'show_rewarded_punch_cards');
add_action('edit_user_profile', 'show_rewarded_punch_cards');


require_once PUNCHCARDPATH . 'admin/user/profile-error-validation.php';
require_once PUNCHCARDPATH . 'admin/user/update-profile.php';

