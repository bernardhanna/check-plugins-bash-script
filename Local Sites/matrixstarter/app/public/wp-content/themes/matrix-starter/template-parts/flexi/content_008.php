<?php
$content_008_heading_tag = get_sub_field('content_008_heading_tag') ?: 'h2';
$content_008_heading_text = get_sub_field('content_008_heading_text');
$content_008_padding = get_sub_field('content_008_padding');

$content_008_paragraph_text = get_sub_field('content_008_paragraph_text');
$content_008_image_id = get_sub_field('content_008_image');
$content_008_image_url = wp_get_attachment_url($content_008_image_id);
$content_008_image_alt = get_post_meta($content_008_image_id, '_wp_attachment_image_alt', true);
$content_008_background_color_top = get_sub_field('content_008_background_color_top') ?: '#FEF3C7';
$content_008_background_color_bottom = get_sub_field('content_008_background_color_bottom') ?: '#F59E0B';
$content_008_layout_order = get_sub_field('content_008_layout_order');

// Determine the layout classes based on the selected option
$layout_class = ($content_008_layout_order === 'image_left_text_right') ? '' : 'lg:flex-row-reverse';
?>

<section class="flex flex-col items-center justify-center px-4 lg:px-8 xxl:px-0" style="background-color: <?php echo esc_attr($content_008_background_color_top); ?>;">
    <div class="flex flex-col lg:flex-row <?php echo esc_attr($layout_class); ?> max-w-full w-[1440px]">
        <article class="flex flex-col justify-center flex-1 w-full px-4 max-lg:py-8 lg:pr-16 lg:pl-0 shrink max-md:px-5 max-md:max-w-full lg:w-2/3">
            <?php if ($content_008_heading_text): ?>
                <<?php echo esc_html($content_008_heading_tag); ?> class="text-3xl font-semibold leading-none max-md:max-w-full">
                    <?php echo esc_html($content_008_heading_text); ?>
                </<?php echo esc_html($content_008_heading_tag); ?>>
            <?php endif; ?>

            <?php if ($content_008_paragraph_text): ?>
                <div class="mt-6 text-lg leading-7 text-white max-md:max-w-full">
                    <?php echo wp_kses_post($content_008_paragraph_text); ?>
                </div>
            <?php endif; ?>
        </article>

        <?php if ($content_008_image_url): ?>
            <div class="w-full lg:w-1/3" style="padding: <?php echo esc_attr($content_008_padding); ?>;">
                <img src="<?php echo esc_url($content_008_image_url); ?>" 
                      alt="<?php echo esc_attr($content_008_image_alt); ?>" 
                      class="object-contain w-full" />
            </div>
        <?php endif; ?>
    </div>
</section>