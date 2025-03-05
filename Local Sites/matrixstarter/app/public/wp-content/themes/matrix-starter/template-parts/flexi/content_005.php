<?php
$paragraph_text = get_sub_field('paragraph_text');
$heading_tag = get_sub_field('heading_tag') ?: 'h2';
$background_color = get_sub_field('background_color') ?: '#FEF3C7';
$text_color = get_sub_field('text_color') ?: '#000000';
?>

<section class="py-20" style="background-color: <?php echo esc_attr($background_color); ?>;">
    <div class="max-w-[1440px] px-4 mx-auto">
        <<?php echo esc_html($heading_tag); ?> class="text-2xl font-semibold leading-8" style="color: <?php echo esc_attr($text_color); ?>;">
            <?php echo wp_kses_post($paragraph_text); ?>
        </<?php echo esc_html($heading_tag); ?>>
    </div>
</section>
