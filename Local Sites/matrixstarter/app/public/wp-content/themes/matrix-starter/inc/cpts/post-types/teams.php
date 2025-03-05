<?php

// Register Teams custom post type
add_action('init', function () {
    register_extended_post_type('team', [
        'menu_icon' => 'dashicons-groups',
        'supports' => ['title', 'editor', 'thumbnail'],
        'has_archive' => true,
        'rewrite' => ['slug' => 'teams'],
        'show_in_rest' => true, // Enable Gutenberg support
    ], [
        'singular' => 'Member',
        'plural'   => 'Team',
        'slug'     => 'team'
    ]);
});
