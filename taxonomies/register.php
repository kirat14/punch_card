<?php
function pcard_register_pgame_type_taxonomy()
{
    $labels = array(
        'name' => __('Pool Game Types', PUNCHCARDDOMAIN),
        'singular_name' => __('Pool Game Type', PUNCHCARDDOMAIN),
        'edit_item' => __('Edit Pool Game Type', PUNCHCARDDOMAIN),
        'update_item' => __('Update Pool Game Type', PUNCHCARDDOMAIN),
        'add_new_item' => __('Add New Pool Game Type', PUNCHCARDDOMAIN),
        'new_item_name' => __('New Pool Game Type Name', PUNCHCARDDOMAIN),
    );

    $args = array(
        'hierarchical' => true,
        'labels' => $labels,
        'public' => true,
        'show_admin_column' => true,
        'show_in_quick_edit' => true,
    );

    $post_types = array('punch-card');

    register_taxonomy('pool-game-type', $post_types, $args);
}