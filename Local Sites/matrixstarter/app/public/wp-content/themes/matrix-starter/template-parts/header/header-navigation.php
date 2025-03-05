<?php

$navigation_style  = get_field('navigation_style', 'option')  ?? 'navbar_1';

// Retrieve Logo Information
$logo_id = get_field('logo', 'option');
$logo_url = $logo_id ? wp_get_attachment_image_url($logo_id, 'full') : '';
$logo_alt = $logo_id ? get_post_meta($logo_id, '_wp_attachment_image_alt', true) : get_bloginfo('name');

// Retrieve Calculator Button Text and Link
$calculator_text = get_field('calculator_text', 'option') ?: 'Calculator';
$calculator_link = get_field('calculator_link', 'option');

// Retrieve Hamburger Settings from ACF Mobile Navigation Options
$enable_hamburger = get_field('enable_hamburger', 'option');
$hamburger_style = get_field('hamburger_style', 'option');

// Validate the hamburger style to prevent invalid classes
$valid_styles = [
  'hamburger--3dx',
  'hamburger--3dx-r',
  'hamburger--3dy',
  'hamburger--3dy-r',
  'hamburger--3dxy',
  'hamburger--3dxy-r',
  'hamburger--arrow',
  'hamburger--arrow-r',
  'hamburger--arrowalt',
  'hamburger--arrowalt-r',
  'hamburger--arrowturn',
  'hamburger--arrowturn-r',
  'hamburger--boring',
  'hamburger--collapse',
  'hamburger--collapse-r',
  'hamburger--elastic',
  'hamburger--elastic-r',
  'hamburger--emphatic',
  'hamburger--emphatic-r',
  'hamburger--minus',
  'hamburger--slider',
  'hamburger--slider-r',
  'hamburger--spin',
  'hamburger--spin-r',
  'hamburger--spring',
  'hamburger--spring-r',
  'hamburger--stand',
  'hamburger--stand-r',
  'hamburger--squeeze',
  'hamburger--vortex',
  'hamburger--vortex-r',
];

if (!in_array($hamburger_style, $valid_styles)) {
  $hamburger_style = 'hamburger--spin'; // Fallback to default style
}
if ($navigation_style === 'navbar_1') :
  get_template_part('template-parts/header/navigation/001/navbar');
elseif ($navigation_style === 'navbar_2') :
  get_template_part('template-parts/header/navigation/002/navbar');
endif;
