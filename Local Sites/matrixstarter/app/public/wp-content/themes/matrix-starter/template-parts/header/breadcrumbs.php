<?php

/**
 * Example of rendering breadcrumbs based on ACF options.
 * Assumes you have:
 *   1) A True/False field named 'enable_breadcrumbs' (checkbox).
 *   2) A Radio field named 'breadcrumb_style' with 'style_1' and 'style_2'.
 *   
 */

// Retrieve the ACF option values
$enable_breadcrumbs     = get_field('enable_breadcrumbs', 'option');  // returns true/false
$breadcrumb_style       = get_field('breadcrumb_style', 'option');    // returns 'style_1' or 'style_2'

// Only render if the checkbox is enabled
if ($enable_breadcrumbs) :


    if ($breadcrumb_style === 'style_1') :

        get_template_part('template-parts/header/breadcrumbs/001/breadcrumbs');

    elseif ($breadcrumb_style === 'style_2') :

        get_template_part('template-parts/header/breadcrumbs/002/breadcrumbs');

    endif;
?>

<?php endif; // end if enable_breadcrumbs