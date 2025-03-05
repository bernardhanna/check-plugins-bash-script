<?php

// Register testimonial custom post type
add_action('init', function() {
    register_extended_post_type('testimonial', [
        'menu_icon' => 'dashicons-testimonial',
        'supports' => ['title', 'editor', 'thumbnail'],
        'has_archive' => true,
        'rewrite' => ['slug' => 'testimonial'],
        'show_in_rest' => true, // Enable Gutenberg support
    ], [
        'singular' => 'Testimonial Item',
        'plural'   => 'Testimonials',
        'slug'     => 'Testimonial'
    ]);
});
