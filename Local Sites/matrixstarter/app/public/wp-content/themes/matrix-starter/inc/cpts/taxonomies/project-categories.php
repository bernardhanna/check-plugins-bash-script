<?php

// Register Project Categories taxonomy
add_action('init', function() {
    register_extended_taxonomy('project_category', 'projects', [
        'hierarchical' => true,
        'labels' => [
            'singular' => 'Project Category',
            'plural'   => 'Project Categories',
        ],
        'rewrite' => ['slug' => 'project-category'],
        'show_in_rest' => true, // Enable Gutenberg support
    ]);
});
