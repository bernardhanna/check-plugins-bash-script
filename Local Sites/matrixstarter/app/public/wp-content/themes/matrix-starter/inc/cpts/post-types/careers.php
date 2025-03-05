<?php

// Register jobs custom post type
add_action('init', function() {
    register_extended_post_type('jobs', [
        'menu_icon' => 'dashicons-editor-help',
        'supports' => ['title', 'editor', 'excerpt', 'thumbnail'], 
        'has_archive' => true,
        'rewrite' => ['slug' => 'jobs'],
        'show_in_rest' => true, 
    ], [
        'singular' => 'job',
        'plural'   => 'jobs',
        'slug'     => 'jobs'
    ]);
});
