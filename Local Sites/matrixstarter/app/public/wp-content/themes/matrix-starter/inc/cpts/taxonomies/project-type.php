<?php

// Register Project Type taxonomy for Portfolio
add_action('init', function() {
    register_extended_taxonomy('project_type', 'portfolio', [
        'hierarchical' => true,
        'labels' => [
            'singular' => 'Project Type',
            'plural'   => 'Project Types',
        ],
        'rewrite' => ['slug' => 'project-type'],
        'show_in_rest' => true, // Enable Gutenberg support
    ]);
});