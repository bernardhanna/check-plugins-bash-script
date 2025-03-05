<?php
 // Get the values from the flexible content block
$cta_001_heading_tag = get_sub_field('cta_001_heading_tag') ?: 'h4'; // Default to h2 if not set
$cta_001_heading_text = get_sub_field('cta_001_heading_text');
$cta_001_paragraph_text = get_sub_field('cta_001_paragraph_text');
$cta_001_button_link = get_sub_field('cta_001_button_link');
$cta_001_background_image = get_sub_field('cta_001_background_image');

// Get image details (alt and title)
$cta_001_background_image_id = get_sub_field('cta_001_background_image', false, false);
$cta_001_background_image_alt = get_post_meta($cta_001_background_image_id, '_wp_attachment_image_alt', true);
$cta_001_background_image_title = get_the_title($cta_001_background_image_id);
?>

<section class="relative bg-white xl:py-20">
  <div class="flex flex-col-reverse lg:flex-row items-stretch max-w-full w-[1440px] m-auto">
    <div class="flex items-center px-20 bg-secondary-dark lg:w-1/2 min-w-[240px] max-lg:px-5 lg:py-24 max-lg:max-w-full">
      <div class="flex flex-col my-auto w-full min-w-[240px] max-lg:max-w-full py-20 ">
        <?php if ($cta_001_heading_text): ?>
          <<?php echo esc_html($cta_001_heading_tag); ?> class="text-3xl font-semibold leading-none text-center max-lg:max-w-full">
            <?php echo esc_html($cta_001_heading_text); ?>
          </<?php echo esc_html($cta_001_heading_tag); ?>>
        <?php endif; ?>

        <?php if ($cta_001_paragraph_text): ?>
          <div class="mt-6 text-lg leading-7 max-lg:max-w-full">
            <?php echo wp_kses_post($cta_001_paragraph_text); ?>
          </div>
        <?php endif; ?>

        <?php if ($cta_001_button_link): ?>
          <a href="<?php echo esc_url($cta_001_button_link['url']); ?>"
              title="<?php echo esc_attr($cta_001_button_link['title']); ?>"
              target="<?php echo esc_attr($cta_001_button_link['target']); ?>"
              class="self-center flex items-center justify-center px-12 mt-6 text-base text-white uppercase bg-green-700 min-h-[60px] max-lg:px-5 font-semibold border-2 border-[#0D783D] hover:bg-transparent hover:text-[#0D783D]">
            <?php echo esc_html($cta_001_button_link['title']); ?>
          </a>
        <?php endif; ?>
      </div>
    </div>
    <?php if ($cta_001_background_image): ?>
        <div class="flex w-full lg:w-1/2">
            <img src="<?php echo esc_url($cta_001_background_image); ?>" 
                <?php if ($cta_001_background_image_alt): ?>
                    alt="<?php echo esc_attr($cta_001_background_image_alt); ?>"
                <?php endif; ?>
                <?php if ($cta_001_background_image_title): ?>
                    title="<?php echo esc_attr($cta_001_background_image_title); ?>"
                <?php endif; ?>
                class="object-cover w-full h-full" />
        </div>
    <?php endif; ?>
  </div>
</section>
