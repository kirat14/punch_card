<?php
// disable direct file access
if (!defined('ABSPATH')) {

    exit;

}

function punch_card_card_type()
{
    $labels = array(
        'name' => __('Punch Cards', PUNCHCARDDOMAIN),
        'singular_name' => __('Punch Card', PUNCHCARDDOMAIN),
        'add_new' => __('Add New Punch Card', PUNCHCARDDOMAIN),
        'add_new_item' => __('Add New Punch Card', PUNCHCARDDOMAIN),
    );

    $args = array(
        'labels' => $labels,
        'public' => true,
        'menu_icon' => 'dashicons-nametag',
        'supports' => array('title')
    );

    register_post_type('punch-card', $args);
}



add_filter('rwmb_meta_boxes', 'punch_card_register_meta_boxes');

function punch_card_register_meta_boxes($meta_boxes)
{
    $prefix = '';

    $meta_boxes[] = [
        'title' => esc_html__('Loyalty Card', PUNCHCARDDOMAIN),
        'post_types' => 'punch-card',
        'id' => 'loyalty_card',
        'context' => 'after_title',
        'autosave' => true,
        'fields' => [
            [
                'type' => 'number',
                'name' => esc_html__('Milestone To Reward', PUNCHCARDDOMAIN),
                'id' => $prefix . 'milestone_to_reward',
                'desc' => esc_html__('The number of games a client should reach to get rewards', PUNCHCARDDOMAIN),
                'placeholder' => esc_html__('Games Threshold', PUNCHCARDDOMAIN),
            ],
            [
                'type' => 'text',
                'name' => esc_html__('Reward', PUNCHCARDDOMAIN),
                'id' => $prefix . 'reward',
                'desc' => esc_html__('The reward provided upon reaching the threshold.', PUNCHCARDDOMAIN),
                'placeholder' => esc_html__('50% off all drinks', PUNCHCARDDOMAIN),
            ],
        ],
    ];

    return $meta_boxes;
}

// reorder punch-card post type columns
require_once PUNCHCARDPATH . 'post-types/arrange.php';