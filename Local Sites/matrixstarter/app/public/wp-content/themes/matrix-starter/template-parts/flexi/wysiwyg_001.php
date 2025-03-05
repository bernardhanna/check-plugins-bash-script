<?php
$heading_tag = get_sub_field('heading_tag') ?: 'h2';
$heading_text = get_sub_field('heading_text');
$content = get_sub_field('content');
$background_color = get_sub_field('background_color') ?: '#FFFFFF';
$custom_classes = get_sub_field('custom_classes');
?>
<section class="relative py-20 <?php echo esc_attr($custom_classes); ?>" style="background-color: <?php echo esc_attr($background_color); ?>;">
    <div class="flex flex-col-reverse lg:flex-row items-stretch max-w-full w-[1440px] m-auto px-4 lg:px-8 xxl:px-0">
        <div class="flex flex-col w-full">
            <?php if ($heading_text): ?>
                <<?php echo esc_html($heading_tag); ?> class="text-3xl font-semibold leading-none"><?php echo esc_html($heading_text); ?></<?php echo esc_html($heading_tag); ?>>
            <?php endif; ?>
            <div class="mt-6 text-lg leading-7">
                <?php echo $content; ?>
            </div>
        </div>
    </div>
</section>
