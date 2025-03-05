<?php

use StoutLogic\AcfBuilder\FieldsBuilder;

$navigationFields = new FieldsBuilder('navigation_settings');

$navigationFields
  ->addGroup('navigation_settings_start', [
    'label' => 'Navigation Settings',
  ])
  ->addRadio('navigation_style', [
    'label'        => 'Navigation Style',
    'instructions' => 'Choose the style of navigation to use.',
    'choices'      => [
      'navbar_1' => 'Navbar 1',
      'navbar_2' => 'Navbar 2',
    ],
    'default_value' => 'navbar_1',
    'layout'        => 'vertical',
  ])

  // Preview for Style 1
  ->addMessage(
    'navbar_1_preview', // Unique key for this preview
    '<strong>Navbar 1 Preview</strong><br>
         <img src="' . get_template_directory_uri() . '/template-parts/header/navigation/001/preview.jpg" 
              style="max-width:100%;border:1px solid #ccc;" alt="Style 1 Preview" />'
  )
  ->conditional('navigation_style', '==', 'navbar_1') // Show only for Style 1

  // Preview for Style 2
  ->addMessage(
    'navbar_2_preview', // Unique key for this preview
    '<strong>Navbar 2 Preview</strong><br>
         <img src="' . get_template_directory_uri() . '/template-parts/header/navigation/002/preview.jpg" 
              style="max-width:100%;border:1px solid #ccc;" alt="Style 2 Preview" />'
  )
  ->conditional('navigation_style', '==', 'navbar_2') // Show only for Style 2

  ->addAccordion('navigation_settings_end')->endpoint();

return $navigationFields;
