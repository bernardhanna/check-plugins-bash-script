<?php
// File: template-parts/hero/hero_001.php

// Ensure this template is loaded within a flexible content row
if (get_row_layout() !== 'hero_001') {
  return;
}

// Retrieve ACF fields using get_sub_field
$hero_image = get_sub_field('hero_image');
$hero_image_alt = get_sub_field('hero_image_alt') ?: get_bloginfo('name');
$hero_image_title = get_sub_field('hero_image_title') ?: get_bloginfo('name');

// Determine hero image source
if (!$hero_image) {
  $hero_image = get_the_post_thumbnail_url(get_the_ID(), 'full');
  $hero_image_alt = get_post_meta(get_post_thumbnail_id(get_the_ID()), '_wp_attachment_image_alt', true) ?: get_bloginfo('name');
  $hero_image_title = get_the_title(get_post_thumbnail_id(get_the_ID()));
}

// Retrieve hero title and description
$hero_title = get_sub_field('hero_title') ?: get_the_title();
$hero_description = get_sub_field('hero_description') ?: get_the_excerpt();

// Retrieve button links
$hero_primary_button = get_sub_field('hero_primary_button');
$hero_secondary_button = get_sub_field('hero_secondary_button');

// Retrieve styling options
$hero_heading_tag = get_sub_field('hero_heading_tag') ?: 'h2';
$hero_font_size = get_sub_field('hero_font_size') ?: 'text-[48px]';
$hero_line_height = get_sub_field('hero_line_height') ?: 'leading-[56px]';
$hero_max_width = get_sub_field('hero_max_width');
$hero_height = get_sub_field('hero_height') ?: 'xxl:max-h-[500px]';
$hero_width = get_sub_field('hero_width') ?: 'xl:max-w-[745px]';

// Check if any of the key fields have content
if ($hero_image || $hero_title || $hero_description || $hero_primary_button || $hero_secondary_button):
?>
  <section class="bg-top bg-cover md:block" style="background-image: url('<?php echo esc_url($hero_image); ?>');">
    <div class="container max-w-[1440px] max-xxl:px-8 mx-auto">
      <div class="py-28">
        <div class="w-full lg:w-[612px] bg-[#0D783D] p-8">
          <?php if ($hero_title): ?>
            <<?php echo esc_html($hero_heading_tag); ?> class="text-2xl lg:text-4xl font-semibold text-white xl:<?php echo esc_attr($hero_font_size); ?> xl:<?php echo esc_attr($hero_line_height); ?>"
              <?php if ($hero_max_width): ?>
              style="max-width: <?php echo esc_attr($hero_max_width); ?>;"
              <?php endif; ?>>
              <?php echo esc_html($hero_title); ?>
            </<?php echo esc_html($hero_heading_tag); ?>>
          <?php endif; ?>

          <?php if ($hero_description): ?>
            <p class="mt-6 text-lg leading-7 text-white max-md:max-w-full"><?php echo esc_html($hero_description); ?></p>
          <?php endif; ?>

          <?php if ($hero_primary_button || $hero_secondary_button): ?>
            <div class="flex mt-8 space-x-4">
              <?php if ($hero_primary_button): ?>
                <a href="<?php echo esc_url($hero_primary_button['url']); ?>"
                  <?php if ($hero_primary_button['title']): ?>
                  title="<?php echo esc_attr($hero_primary_button['title']); ?>"
                  <?php endif; ?>
                  <?php if (!empty($hero_primary_button['alt'])): ?>
                  alt="<?php echo esc_attr($hero_primary_button['alt']); ?>"
                  <?php endif; ?>
                  class="flex items-center justify-center px-12 py-4 bg-white text-black text-base font-semibold uppercase min-h-[60px] min-w-[252px] w-auto max-w-fit border-2 border-white hover:bg-transparent hover:text-white">
                  <?php echo esc_html($hero_primary_button['title']); ?>
                </a>
              <?php endif; ?>

              <?php if ($hero_secondary_button): ?>
                <a href="<?php echo esc_url($hero_secondary_button['url']); ?>"
                  <?php if ($hero_secondary_button['title']): ?>
                  title="<?php echo esc_attr($hero_secondary_button['title']); ?>"
                  <?php endif; ?>
                  <?php if (!empty($hero_secondary_button['alt'])): ?>
                  alt="<?php echo esc_attr($hero_secondary_button['alt']); ?>"
                  <?php endif; ?>
                  class="flex items-center justify-center px-12 py-4 bg-transparent text-white text-base font-semibold uppercase min-h-[60px] min-w-[252px] w-auto max-w-fit border-2 border-white hover:bg-white hover:text-black">
                  <?php echo esc_html($hero_secondary_button['title']); ?>
                </a>
              <?php endif; ?>
            </div>
          <?php endif; ?>
        </div>
      </div>
    </div>
  </section>
<?php endif; ?>