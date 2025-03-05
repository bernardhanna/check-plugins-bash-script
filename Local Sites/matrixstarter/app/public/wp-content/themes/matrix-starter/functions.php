<?php
// Theme setup
if (! function_exists('get_field') && ! is_admin()) {
    wp_die(
        'The ACF plugin is not active. This theme depends on it. Please activate it.',
        'Plugin Missing',
        array('response' => 500)
    );
}

function matrix_starter_setup()
{
    add_theme_support('title-tag');
    add_theme_support('post-thumbnails');
    add_theme_support('custom-logo');
    add_theme_support('html5', array('search-form', 'comment-form', 'comment-list', 'gallery', 'caption'));
    register_nav_menus(array(
        'primary' => esc_html__('Primary Menu', 'matrix-starter'),
        'footer' => esc_html__('Footer Menu', 'matrix-starter'),
        'copyright' => esc_html__('Copyright Menu', 'matrix-starter'),
    ));
}
add_action('after_setup_theme', 'matrix_starter_setup');
// Include the Enqueue Fonts
require_once get_template_directory() . '/inc/enqueue-fonts.php';
// Include the Enqueue Scripts and Styles
require_once get_template_directory() . '/inc/enqueue-scripts.php';
// load the helper functions
require_once get_template_directory() . '/inc/hero-functions.php';
require_once get_template_directory() . '/inc/flexible-content-functions.php';

// Function to handle Tailwind config updates and trigger rebuilds
function handle_tailwind_config_update()
{
    // Update the CSS version to force cache refresh
    update_option('theme_css_version', time());

    // Clear any WordPress caches
    if (function_exists('wp_cache_flush')) {
        wp_cache_flush();
    }

    // Touch the CSS file to trigger rebuild
    $css_path = get_template_directory() . '/assets/css/app.css';
    if (file_exists($css_path)) {
        // Touch the main CSS file
        touch($css_path);

        // Create and remove a temporary file to trigger file system events
        $temp_path = get_template_directory() . '/assets/css/.temp';
        file_put_contents($temp_path, '');
        usleep(100000); // Wait 100ms
        if (file_exists($temp_path)) {
            unlink($temp_path);
        }

        // Log successful update for debugging
        error_log('Tailwind config updated and rebuild triggered');
    } else {
        error_log('CSS file not found at: ' . $css_path);
    }
}

// Hook to handle Tailwind updates when ACF options are saved
add_action('acf/save_post', function ($post_id) {
    if ($post_id === 'options') {
        handle_tailwind_config_update();
    }
}, 30);

// Autoload Composer dependencies
if (file_exists(get_template_directory() . '/vendor/autoload.php')) {
    require_once get_template_directory() . '/vendor/autoload.php';
} else {
    // Handle error or provide a fallback
    error_log('Composer autoload file not found.');
}

// Autoload ACF fields
require_once get_template_directory() . '/inc/autoload-acf-fields.php';

// Autoload Custom Post Types and Taxonomies
require_once get_template_directory() . '/inc/cpts/init.php';

// Include the ACF theme options setup
require_once get_template_directory() . '/inc/theme-options.php';

// Include login customizations
require_once get_template_directory() . '/inc/login-customizations.php';

// Customize excerpt more text
function custom_excerpt_more($more)
{
    return '';  // Return an empty string to remove the ellipsis
}
add_filter('excerpt_more', 'custom_excerpt_more');

// Add custom image sizes in your theme
function my_custom_image_sizes()
{
    add_image_size('hero-image', 1600, 900, true); // Example custom image size
    add_image_size('hero-thumbnail', 800, 450, true); // Example thumbnail for smaller screens
}
add_action('after_setup_theme', 'my_custom_image_sizes');

// Ensure the sizes are visible in the srcset
function my_custom_image_size_names($sizes)
{
    return array_merge($sizes, array(
        'hero-image' => __('Hero Image'),
        'hero-thumbnail' => __('Hero Thumbnail'),
    ));
}
add_filter('image_size_names_choose', 'my_custom_image_size_names');
