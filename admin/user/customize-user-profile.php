<?php
// disable direct file access
if (!defined('ABSPATH')) {

	exit;

}

function punch_card_disable_backend_admin_bar()
{
	if (current_user_can('subscriber')) { ?>
		<style type="text/css" media="screen">
			html.wp-toolbar {
				padding-top: 0;
			}

			#wpadminbar {
				display: none;
			}
		</style>
		<?php
	}
}
add_action('admin_print_scripts-profile.php', 'punch_card_disable_backend_admin_bar');


// Hide admin color scheme
function custom_admin_color_scheme_picker($user_id)
{
	global $_wp_admin_css_colors;
	$_wp_admin_css_colors = [];
}
add_action('user_edit_form_tag', 'custom_admin_color_scheme_picker', 10, 1);




// Show List of rewarded punch cards
function show_rewarded_punch_cards($user)
{
	$rewarded_punch_cards = get_user_meta($user->ID, 'rewarded_punch_cards', true);
	?>
	<h3>
		<?php _e('Rewarded Punch Cards', PUNCHCARDDOMAIN); ?>
	</h3>

	<?php if (!empty($rewarded_punch_cards)): ?>
		<table class="wp-list-table widefat fixed striped table-view-list pages">
			<thead>
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
			</thead>
			<tbody>
				<?php foreach ($rewarded_punch_cards as $punch_card_id):
					$terms = get_the_terms($punch_card_id, 'pool-game-type');
					$name = '';
					if (!is_a($terms, 'WP_Error') && $terms !== false) {
						$name = $terms[0]->name;
					}
					error_log(print_r($punch_card_id, true));
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
			</tbody>


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