<?php

// Register Team Categories taxonomy
add_action('init', function() {
    register_extended_taxonomy('team_category', 'teams', [
        'hierarchical' => true,
        'labels' => [
            'singular' => 'Team Category',
            'plural'   => 'Team Categories',
        ],
        'rewrite' => ['slug' => 'team-category'],
        'show_in_rest' => true, // Enable Gutenberg support
    ]);
});
