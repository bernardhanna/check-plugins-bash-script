<?php

use StoutLogic\AcfBuilder\FieldsBuilder;

// Define the Intro Block layout
$intro_001 = new FieldsBuilder('intro_001', [
  'label' => 'Intro Block',
]);

$intro_001
  ->addSelect('intro_001_heading_tag', [
    'label' => 'Heading Tag',
    'choices' => [
      'h1' => 'H1',
      'h2' => 'H2',
      'h3' => 'H3',
      'h4' => 'H4',
      'h5' => 'H5',
      'h6' => 'H6',
    ],
    'default_value' => 'h2',
  ])
  ->addText('intro_001_heading_text', [
    'label' => 'Heading Text',
    'placeholder' => 'Intro Block 1',
    'default_value' => 'Intro Block 1',
  ])
  ->addWysiwyg('intro_001_paragraph_text', [
    'label' => 'Paragraph Text',
    'tabs' => 'all',
    'toolbar' => 'full',
    'media_upload' => 0,
    'default_value' => '<p>Enter your paragraph text here...</p>',
  ])
  ->addLink('intro_001_button_link', [
    'label' => 'Button Link',
    'return_format' => 'array',
    'default_value' => [
      'url' => home_url('/'),
      'title' => 'Lorem Ipsum',
      'target' => '_self',
    ],
  ]);

return $intro_001;
