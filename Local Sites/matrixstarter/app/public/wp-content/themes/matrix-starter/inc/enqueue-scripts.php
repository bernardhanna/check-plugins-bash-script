<?php
// File: inc/enqueue-scripts.php

/**
 * Enqueue Scripts and Styles for the Theme
 */
function matrix_starter_enqueue_scripts()
{
  // Get theme version for cache busting
  $theme_version = get_option('theme_css_version', '1.0');

  // Get enabled scripts from ACF options
  $enabled_scripts = get_field('enabled_scripts', 'option');

  // Enqueue Alpine.js Intersect Plugin
  wp_enqueue_script(
    'alpine-intersect',
    'https://cdn.jsdelivr.net/npm/@alpinejs/intersect@3.x.x/dist/cdn.min.js',
    [],
    null,
    true
  );

  // Initialize Alpine.js with Intersect Plugin
  wp_add_inline_script('alpine-intersect', "
        document.addEventListener('alpine:init', () => {
            Alpine.plugin(AlpineIntersect);
        });
    ");

  // Enqueue Alpine.js
  wp_enqueue_script(
    'alpine',
    'https://cdn.jsdelivr.net/npm/alpinejs@3.x.x/dist/cdn.min.js',
    [],
    null,
    true
  );

  // ─────────────────────────────────────────────────────────────────────
  // CONDITIONAL ENQUEUING BASED ON THEME OPTIONS
  // ─────────────────────────────────────────────────────────────────────

  if (is_array($enabled_scripts)) {
    // Conditionally enqueue Font Awesome
    if (in_array('font_awesome', $enabled_scripts)) {
      wp_enqueue_style(
        'font-awesome',
        'https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.1/css/all.min.css',
        [],
        null
      );
    }

    // Conditionally enqueue Hamburgers CSS
    if (in_array('hamburger_css', $enabled_scripts)) {
      wp_enqueue_style(
        'hamburgers-css',
        'https://cdnjs.cloudflare.com/ajax/libs/hamburgers/1.2.1/hamburgers.min.css',
        [],
        '1.2.1'
      );
    }

    // Conditionally enqueue Flowbite
    if (in_array('flowbite', $enabled_scripts)) {
      wp_enqueue_script(
        'flowbite',
        'https://unpkg.com/flowbite@1.6.5/dist/flowbite.min.js',
        ['alpine'], // Ensure Alpine is loaded first
        '1.6.5',
        true
      );
    }

    // Conditionally enqueue Slick Carousel
    if (in_array('slick', $enabled_scripts)) {
      // Enqueue Slick CSS
      wp_enqueue_style(
        'slick-css',
        'https://cdn.jsdelivr.net/npm/slick-carousel@1.8.1/slick/slick.css',
        [],
        '1.8.1'
      );

      // Enqueue Slick JS
      wp_enqueue_script(
        'slick-js',
        'https://cdn.jsdelivr.net/npm/slick-carousel@1.8.1/slick/slick.min.js',
        ['jquery'], // Ensure jQuery is loaded first
        '1.8.1',
        true
      );
    }
  }

  // Enqueue main stylesheet with version control (enqueued last)
  wp_enqueue_style(
    'matrix-starter-style',
    get_template_directory_uri() . '/dist/styles.css',
    [],
    $theme_version
  );

  // Enqueue dynamic Tailwind styles with version control (enqueued last)
  wp_enqueue_style(
    'matrix-starter-dynamic-style',
    get_template_directory_uri() . '/dist/app.css',
    [],
    $theme_version
  );

  // Enqueue main JavaScript file
  wp_enqueue_script(
    'matrix-starter-scripts',
    get_template_directory_uri() . '/dist/styles.js',
    [], // Add dependencies if needed, e.g., ['jquery', 'slick-js', 'flowbite']
    null,
    true
  );
}
add_action('wp_enqueue_scripts', 'matrix_starter_enqueue_scripts');
