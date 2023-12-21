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
					<?php _e('Pool Game Type', PUNCHCARDDOMAIN); ?>
				</th>
				<th>
					<?php _e('Milestone To Reward', PUNCHCARDDOMAIN); ?>
				</th>
				<th>
					<?php _e('Reward', PUNCHCARDDOMAIN); ?>
				</th>
			</tr>
			<?php foreach ($rewarded_punch_cards as $punch_card_id):
				$terms = get_the_terms($punch_card_id, 'pool-game-type');
				$name = '';
				if (!is_a($terms, 'WP_Error') && $terms !== false) {
					$name = $terms[0]->name;
				}
				?>
				<tr>
					<td>
						<?php echo esc_html($name); ?>
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



// Add phone number after contact section
function custom_get_user_contact_methods($methods, $user)
{
	// Add phone contact method
	$methods['phone'] = __('Phone Number');

	return $methods;
}

add_filter('user_contactmethods', 'custom_get_user_contact_methods', 10, 2);

// Hide admin color scheme
function custom_admin_color_scheme_picker($user_id)
{
	global $_wp_admin_css_colors;
	$_wp_admin_css_colors = 0;
}

add_action('user_edit_form_tag', 'custom_admin_color_scheme_picker', 10, 1);


