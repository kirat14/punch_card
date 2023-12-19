<?php
// disable direct file access
if (!defined('ABSPATH')) {

    exit;

}

// Add the custom column header
function punch_card_admin_columns($columns)
{
    //error_log(var_export($columns, true)); // Log $columns to debug.log
    // put the number_of_games in the second column
    array_splice($columns, 2, 0, array('number_of_games' => esc_html__('Number of Games', PUNCHCARDDOMAIN) ));
    
    return $columns;
}
add_filter('manage_punch-card_posts_columns', 'punch_card_admin_columns');

// Populate the custom column with data
function punch_card_admin_custom_column($column, $post_id)
{
    if ($column == 'number_of_games') {
        $number_of_games = rwmb_the_value('number_of_games', [], $post_id, false);
        echo esc_html($number_of_games);
    }
}
add_action('manage_punch-card_posts_custom_column', 'punch_card_admin_custom_column', 10, 2);