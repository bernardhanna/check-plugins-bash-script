<?php

// Register Service Categories taxonomy
add_action('init', function() {
    register_extended_taxonomy('service_category', 'services', [
        'hierarchical' => true,
        'labels' => [
            'singular' => 'Service Category',
            'plural'   => 'Service Categories',
        ],
        'rewrite' => ['slug' => 'service-category'],
        'show_in_rest' => true, // Enable Gutenberg support
    ]);
});