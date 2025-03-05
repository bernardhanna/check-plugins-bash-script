<?php
  $title_001_heading_tag = get_sub_field('title_001_heading_tag') ?: 'h2'; // Default to h2 if not set
  $title_001_heading_text = get_sub_field('title_001_heading_text');
  $title_001_heading_color = get_sub_field('title_001_heading_color') ?: '#000000'; // Default to black if not set
  $title_001_border_color = get_sub_field('title_001_border_color') ?: '#F16623'; // Default to orange if not set
  ?>
  <section class="flex flex-col max-sm:items-center max-w-[1440px] m-auto py-8 lg:py-16 max-lg:px-8 partner-slider px-4 lg:px-8 xxl:px-0">
    <?php if ($title_001_heading_text): ?>
      <<?php echo esc_html($title_001_heading_tag); ?> class="text-3xl font-semibold leading-none"
          style="color: <?php echo esc_attr($title_001_heading_color); ?>;">
        <?php echo esc_html($title_001_heading_text); ?>
      </<?php echo esc_html($title_001_heading_tag); ?>>
    <?php endif; ?>
    <div class="mt-4 border-solid border-[3px] min-h-[3px] w-[66px]"
          style="border-color: <?php echo esc_attr($title_001_border_color); ?>;">
    </div>
  </section>
