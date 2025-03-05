<?php
$heading_tag = get_sub_field('heading_tag') ?: 'h2';
$heading_text = get_sub_field('heading_text');
$content_text = get_sub_field('content_text');
$background_color = get_sub_field('background_color');
$main_image_id = get_sub_field('main_image');
$main_image_url = $main_image_id ? wp_get_attachment_image_url($main_image_id, 'full') : '';
?>

<section class="relative pt-20 pb-10" style="background-color: <?php echo esc_attr($background_color); ?>;">
    <div class="max-w-[1440px] flex-col lg:flex-row m-auto flex p-10 items-center">
        <div class="z-0 flex flex-col self-stretch justify-center w-2/5 py-10 text-black lg:pr-20 lg:pl-14">
            <?php if ($heading_text): ?>
                <<?php echo esc_html($heading_tag); ?> class="text-3xl font-semibold leading-10"><?php echo esc_html($heading_text); ?></<?php echo esc_html($heading_tag); ?>>
            <?php endif; ?>
            <?php if ($content_text): ?>
                <p class="mt-6 text-lg leading-7"><?php echo wp_kses_post($content_text); ?></p>
            <?php endif; ?>
        </div>
        <div class="w-3/5">
            <?php if ($main_image_url): ?>
                <img src="<?php echo esc_url($main_image_url); ?>" alt="<?php echo esc_attr(get_post_meta($main_image_id, '_wp_attachment_image_alt', true)); ?>" class="object-cover w-full" />
            <?php endif; ?>
        </div>
    </div>
</section>
