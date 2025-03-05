<?php
// File: inc/acf/options/theme-options/breadcrumbs.php

use StoutLogic\AcfBuilder\FieldsBuilder;

$breadcrumbsFields = new FieldsBuilder('breadcrumbs_fields');

$breadcrumbsFields
  ->addGroup('breadcrumbs_settings', [
    'label' => 'Breadcrumb Settings',
  ])
  // Toggle for enabling breadcrumbs
  ->addTrueFalse('enable_breadcrumbs', [
    'label'        => 'Enable Breadcrumbs',
    'instructions' => 'Check to enable the breadcrumb navigation.',
    'ui'           => 1,
    'default_value' => 0,
  ])

  // Preview for Style 1
  ->addMessage(
    'style_1_preview', // MUST be unique
    '<strong>Style 1 Preview</strong><br>
         <img src="/wp-content/themes/matrix-starter/template-parts/header/breadcrumbs/001/001.jpg" 
              style="max-width:100%;border:1px solid #ccc;" alt="Style 1 Preview" />'
  )
  ->conditional('breadcrumb_style', '==', 'style_1')

  // Preview for Style 2
  ->addMessage(
    'style_2_preview', // MUST be unique
    '<strong>Style 2 Preview</strong><br>
         <img src="/wp-content/themes/matrix-starter/template-parts/header/breadcrumbs/002/003.jpg"
              style="max-width:100%;border:1px solid #ccc;" alt="Style 2 Preview" />'
  )
  ->conditional('breadcrumb_style', '==', 'style_2')

  // Radio field to select the style
  ->addRadio('breadcrumb_style', [
    'label'         => 'Breadcrumb Style',
    'instructions'  => 'Pick your preferred breadcrumb style.',
    'choices'       => [
      'style_1' => 'Use Style 1',
      'style_2' => 'Use Style 2',
    ],
    'default_value' => 'style_1',
    'return_format' => 'value',
    'layout'        => 'vertical',
  ])
  ->addAccordion('breadcrumbs_settings_end')->endpoint();

return $breadcrumbsFields;
