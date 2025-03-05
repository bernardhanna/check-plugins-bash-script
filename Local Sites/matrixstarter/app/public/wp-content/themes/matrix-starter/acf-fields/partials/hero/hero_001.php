<?php

use StoutLogic\AcfBuilder\FieldsBuilder;

// Define Content Block 001 layout
$hero_001 = new FieldsBuilder('hero_001', [
  'label' => 'Hero 001',
]);

$hero_001
  ->addImage('hero_image', [
    'label' => 'Hero Image',
    'return_format' => 'url',
  ])
  ->addText('hero_title', [
    'label' => 'Hero Title',
    'default_value' => 'Hero 001',
  ])
  ->addSelect('hero_heading_tag', [
    'label' => 'Heading Tag',
    'choices' => [
      'h1' => 'H1',
      'h2' => 'H2',
      'h3' => 'H3',
      'h4' => 'H4',
      'h5' => 'H5',
      'h6' => 'H6',
    ],
    'default_value' => 'h2', // Set default value to H2
  ])
  ->addSelect('hero_font_size', [
    'label' => 'Title Font Size',
    'choices' => [
      'text-[56px]' => '56px',
      'text-[48px]' => '48px',
    ],
    'default_value' => 'text-[48px]', // Default to 48px
  ])
  ->addSelect('hero_line_height', [
    'label' => 'Title Line Height',
    'choices' => [
      'leading-[64px]' => '64px',
      'leading-[56px]' => '56px',
    ],
    'default_value' => 'leading-[56px]', // Default to 56px
  ])
  ->addText('hero_max_width', [
    'label' => 'Title Max Width (optional)',
    'instructions' => 'Enter a max-width value (e.g., 600px) for the title.',
    'default_value' => '', // Default is empty
  ])
  ->addTextarea('hero_description', [
    'label' => 'Hero Description',
    'rows' => 4,
    'default_value' => 'Lorem ipsum dolor sit amet, consectetur adipiscing elit.'
  ])
  ->addLink('hero_link', [
    'label' => 'Hero Primary Button Link',
    'return_format' => 'array', // Get both URL and title
  ])
  ->addLink('hero_secondary_link', [
    'label' => 'Hero Secondary Button Link',
    'return_format' => 'array', // Get both URL and title
  ])
  ->addSelect('hero_height', [
    'label' => 'Hero Height',
    'choices' => [
      'xxl:max-h-[500px]' => '500px',
      'xxl:max-h-[680px]' => '680px',
    ],
    'default_value' => 'xxl:max-h-[500px]', // Default to 500px
  ])
  ->addSelect('hero_width', [
    'label' => 'Hero Width',
    'choices' => [
      'xl:max-w-[745px]' => '745px',
      'xl:max-w-[612px]' => '612px',
    ],
    'default_value' => 'xl:max-w-[745px]', // Default to 745px
  ]);
return $hero_001;
