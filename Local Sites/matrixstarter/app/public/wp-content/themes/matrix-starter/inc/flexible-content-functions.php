<?php
// File: inc/flexible-content-functions.php

/**
 * Load Flexible Content Templates
 * 
 * Automatically loads flexible content templates based on the layout name
 */
function load_flexible_content_templates()
{
  if (have_rows('flexible_content_blocks')) {
    while (have_rows('flexible_content_blocks')) : the_row();
      $layout = get_row_layout();

      // Check for template file
      $template_path = get_template_directory() . '/template-parts/flexi/' . $layout . '.php';
      if (file_exists($template_path)) {
        get_template_part('template-parts/flexi/' . $layout);
      } else {
        // Optional: Log missing template files for debugging
        error_log("Missing flexible content template file: {$layout}.php");
      }
    endwhile;
  }
}

/**
 * Get Available Flexible Content Layouts
 * 
 * Returns an array of available layout names based on template files
 */
function get_available_flexi_layouts()
{
  $flexi_path = get_template_directory() . '/template-parts/flexi/';
  $files = glob($flexi_path . '*.php');

  return array_map(function ($file) {
    return basename($file, '.php');
  }, $files);
}

/**
 * Validate Flexible Content Layout
 * 
 * Ensures that ACF field definitions have corresponding template files
 */
function validate_flexi_layout($layout_name)
{
  $available_layouts = get_available_flexi_layouts();
  if (!in_array($layout_name, $available_layouts)) {
    error_log("Warning: ACF flexible content layout '{$layout_name}' has no corresponding template file");
    return false;
  }
  return true;
}
