<?php
$services_002_heading_tag = get_sub_field('services_002_heading_tag') ?: 'h2';
$services_002_heading = get_sub_field('services_002_heading');
$column_layout = get_sub_field('services_002_column_layout') ?: '3';
$section_background_color = get_sub_field('services_002_section_background_color') ?: '#FFF6F1';
$item_height = get_sub_field('services_002_item_height') ?: 'h-[332px]';
$items = get_sub_field('services_002_items');
?>

<section class="flex flex-col items-center justify-center px-4 py-8 lg:py-20 lg:px-8 xxl:px-0 max-sm:justify-center max-sm:items-center" style="background-color: <?php echo esc_attr($section_background_color); ?>;">
  <div class="flex flex-col max-w-full w-[1440px]">
      <?php if ($services_002_heading): ?>
          <div class="flex flex-col self-start text-3xl font-semibold leading-none text-black max-md:max-w-full max-sm:justify-center max-sm:items-center max-sm:text-center">
              <<?php echo esc_html($services_002_heading_tag); ?> class="max-md:max-w-full leading-8">
                  <?php echo esc_html($services_002_heading); ?>
              </<?php echo esc_html($services_002_heading_tag); ?>>
              <div class="mt-4 bg-orange-500 border-orange-500 border-solid border-[3px] min-h-[3px] w-[66px]"></div>
          </div>
      <?php endif; ?>

      <div class="flex flex-col w-full mt-16 max-md:mt-10 max-md:max-w-full">
          <div class="grid grid-cols-1 md:grid-cols-<?php echo esc_attr($column_layout); ?> gap-10 w-full max-md:max-w-full">
              <?php if ($items): ?>
                  <?php foreach ($items as $item): ?>
                      <?php
                      $icon = $item['services_002_icon'];
                      $icon_url = is_array($icon) ? $icon['url'] : wp_get_attachment_url($icon);
                      $icon_alt = is_array($icon) ? $icon['alt'] : get_post_meta($icon, '_wp_attachment_image_alt', true);
                      ?>
                      <div class="flex flex-wrap flex-1 shrink gap-8 items-start p-10 basis-0 min-w-[240px] max-md:px-5 max-md:max-w-full max-sm:justify-center max-sm:items-center h-auto xl:<?php echo esc_attr($item_height); ?> bg-white">
                          <div class="flex gap-2.5 justify-center items-center w-24 h-24 bg-orange-50 min-h-[96px] rounded-[48px]">
                              <?php if ($icon_url): ?>
                                  <img loading="lazy" src="<?php echo esc_url($icon_url); ?>" alt="<?php echo esc_attr($icon_alt); ?>" class="self-stretch object-contain w-full aspect-square" />
                              <?php else: ?>
                                  <img src="https://via.placeholder.com/96" alt="Placeholder" class="self-stretch object-contain w-full my-auto aspect-square" />
                              <?php endif; ?>
                          </div>
                          <div class="flex flex-col flex-1 shrink text-black basis-0 min-w-[240px] max-md:max-w-full max-sm:justify-center max-sm:items-center max-sm:text-center">
                              <?php if ($item['services_002_title']): ?>
                                  <h3 class="text-2xl font-semibold leading-none max-md:max-w-full"><?php echo esc_html($item['services_002_title']); ?></h3>
                              <?php endif; ?>
                              <div class="mt-3 border-orange-500 border-solid border-[3px] min-h-[3px] w-[66px]"></div>
                              <?php if ($item['services_002_description']): ?>
                                  <div class="mt-3 text-lg leading-7 max-md:max-w-full">
                                      <?php echo $item['services_002_description']; ?>
                                  </div>
                              <?php endif; ?>
                          </div>
                      </div>
                  <?php endforeach; ?>
              <?php endif; ?>
          </div>
      </div>
  </div>
</section>
