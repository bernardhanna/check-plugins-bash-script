<?php
// Heading and paragraphs
$heading_tag = get_sub_field('heading_tag') ?: 'h2';
$heading_text = get_sub_field('heading_text');
$paragraph_1 = get_sub_field('paragraph_1');
$paragraph_2 = get_sub_field('paragraph_2');

// FAQ Section
$faq_1_question = get_sub_field('faq_1_question');
$faq_1_answer = get_sub_field('faq_1_answer');
$faq_2_question = get_sub_field('faq_2_question');
$faq_2_answer = get_sub_field('faq_2_answer');

// Image
$insulation_image_id = get_sub_field('insulation_image');
$insulation_image_url = $insulation_image_id ? wp_get_attachment_image_url($insulation_image_id, 'full') : '';
$insulation_image_alt = $insulation_image_id ? get_post_meta($insulation_image_id, '_wp_attachment_image_alt', true) : '';

// Grant section
$grant_heading = get_sub_field('grant_heading');
$grant_type_1 = get_sub_field('grant_type_1');
$grant_type_2 = get_sub_field('grant_type_2');
$grant_type_3 = get_sub_field('grant_type_3');
$grant_type_4 = get_sub_field('grant_type_4');
$grant_value_1 = get_sub_field('grant_value_1');
$grant_value_2 = get_sub_field('grant_value_2');
$grant_value_3 = get_sub_field('grant_value_3');
$grant_value_4 = get_sub_field('grant_value_4');
?>

<section class="flex flex-col items-center justify-center py-20 bg-yellow-50">
  <div class="flex flex-col p-16 max-w-full bg-white w-[1440px] max-md:px-5">
    <div class="flex flex-wrap gap-10 w-full min-h-[562px]">
      <article class="flex flex-col flex-1 justify-center basis-0 min-w-[240px] max-md:max-w-full">
        <div class="flex flex-col w-full">
          <<?php echo esc_html($heading_tag); ?> class="text-3xl font-semibold leading-none text-black"><?php echo esc_html($heading_text); ?></<?php echo esc_html($heading_tag); ?>>
          <p class="mt-6 text-lg leading-7 text-black"><?php echo esc_html($paragraph_1); ?></p>
          <p class="mt-6 text-lg leading-7 text-black"><?php echo esc_html($paragraph_2); ?></p>
          <div class="flex flex-col w-full mt-6">
            <details class="mt-2 bg-neutral-100">
              <summary class="p-4 text-xl font-semibold leading-snug text-black"><?php echo esc_html($faq_1_question); ?></summary>
              <div class="p-4 bg-neutral-100">
                <p><?php echo esc_html($faq_1_answer); ?></p>
              </div>
            </details>
            <details class="mt-2 bg-neutral-100">
              <summary class="p-4 text-xl font-semibold leading-snug text-black"><?php echo esc_html($faq_2_question); ?></summary>
              <div class="p-4 bg-neutral-100">
                <p><?php echo esc_html($faq_2_answer); ?></p>
              </div>
            </details>
          </div>
        </div>
      </article>

      <!-- Image -->
      <?php if ($insulation_image_url): ?>
        <img src="<?php echo esc_url($insulation_image_url); ?>" class="object-cover flex-1 self-start w-full aspect-[1.3] basis-0 min-w-[240px]" alt="<?php echo esc_attr($insulation_image_alt); ?>" />
      <?php endif; ?>
    </div>

    <!-- Grants Section -->
    <section class="flex flex-col w-full mt-16 max-md:mt-10">
      <h3 class="text-2xl font-semibold leading-none text-black"><?php echo esc_html($grant_heading); ?></h3>
      <div class="flex flex-wrap items-start w-full gap-1 mt-6 text-lg leading-loose text-black">
        <div class="flex flex-row items-start w-full gap-1 mb-1">
          <div class="flex flex-col w-full md:w-[64%]">
            <div class="p-4 w-full bg-[#0D783D]">
              <p class="font-semibold text-white">Types of home</p>
            </div>
            <div class="p-4 mt-1 w-full bg-[#EFF5EC]">
              <p class="text-black"><?php echo esc_html($grant_type_1); ?></p>
            </div>
            <div class="p-4 mt-1 w-full bg-[#EFF5EC]">
              <p class="text-black"><?php echo esc_html($grant_type_2); ?></p>
            </div>
            <div class="p-4 mt-1 w-full bg-[#EFF5EC]">
              <p class="text-black"><?php echo esc_html($grant_type_3); ?></p>
            </div>
            <div class="p-4 mt-1 w-full bg-[#EFF5EC]">
              <p class="text-black"><?php echo esc_html($grant_type_4); ?></p>
            </div>
          </div>
          <div class="flex flex-col w-full md:w-[35%]">
            <div class="p-4 w-full bg-[#0D783D]">
              <p class="font-semibold text-white">Grant Value</p>
            </div>
            <div class="p-4 mt-1 w-full bg-[#EFF5EC]">
              <p class="text-black"><?php echo esc_html($grant_value_1); ?></p>
            </div>
            <div class="p-4 mt-1 w-full bg-[#EFF5EC]">
              <p class="text-black"><?php echo esc_html($grant_value_2); ?></p>
            </div>
            <div class="p-4 mt-1 w-full bg-[#EFF5EC]">
              <p class="text-black"><?php echo esc_html($grant_value_3); ?></p>
            </div>
            <div class="p-4 mt-1 w-full bg-[#EFF5EC]">
              <p class="text-black"><?php echo esc_html($grant_value_4); ?></p>
            </div>
          </div>
        </div>
      </div>
    </section>
  </div>
</section>
