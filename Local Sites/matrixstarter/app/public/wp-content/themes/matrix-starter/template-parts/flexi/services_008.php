<?php
$heading_tag = get_sub_field('heading_tag') ?: 'h2';
$heading_text = get_sub_field('heading_text');
$content_blocks = get_sub_field('content_blocks');
?>
<section class="flex flex-col items-center self-stretch justify-center px-4 py-8 bg-white lg:py-20 lg:px-8 xxl:px-0">
    <div class="max-w-[1440px] m-auto">
        <div class="flex flex-col text-3xl font-semibold leading-none">
            <<?php echo esc_html($heading_tag); ?>><?php echo esc_html($heading_text); ?></<?php echo esc_html($heading_tag); ?>>
            <div class="mt-4 bg-orange-500 border-orange-500 border-solid border-[3px] min-h-[3px] w-[66px]"></div>
        </div>
        <div class="grid grid-cols-1 gap-10 mt-16 max-md:mt-10 md:grid-cols-2">
            <?php if ($content_blocks): ?>
                <?php foreach ($content_blocks as $block): ?>
                    <?php
                    $block_image_id = $block['block_image'];
                    $block_image_url = wp_get_attachment_url($block_image_id);
                    $block_image_alt = get_post_meta($block_image_id, '_wp_attachment_image_alt', true);
                    $block_title = $block['block_title'];
                    $block_text = $block['block_text'];
                    $block_bg_color = $block['block_bg_color'];
                    ?>
                    <article class="flex flex-col min-w-[240px] w-full">
                        <div class="flex flex-col items-center justify-center w-full" style="background-color: <?php echo esc_attr($block_bg_color); ?>; min-height: 300px;">
                            <?php if ($block_image_url): ?>
                                <img src="<?php echo esc_url($block_image_url); ?>" alt="<?php echo esc_attr($block_image_alt); ?>" class="object-cover w-full h-[300px] max-w-full aspect-square" />
                            <?php endif; ?>
                        </div>
                        <div class="flex flex-col w-full p-10 text-black bg-neutral-100 max-md:px-5 max-md:max-w-full min-h-[382px]">
                            <span class="text-3xl font-semibold leading-none"><?php echo esc_html($block_title); ?></span>
                            <div class="mt-2.5 text-lg leading-7"><?php echo wp_kses_post($block_text); ?></div>
                        </div>
                    </article>
                <?php endforeach; ?>
            <?php endif; ?>
        </div>
    </div>
</section>
