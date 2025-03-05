<?php
$heading_tag = get_sub_field('heading_tag') ?: 'h2';
$heading_text = get_sub_field('heading_text');
$history_items = get_sub_field('history_items');
?>
<section class="flex flex-col items-center justify-center py-8 text-black lg:py-20 bg-yellow-50">
    <div class="max-w-[1440px] m-auto px-4 lg:px-8 xxl:px-0">
        <div class="flex flex-col text-3xl font-semibold leading-none">
            <<?php echo esc_html($heading_tag); ?>><?php echo esc_html($heading_text); ?></<?php echo esc_html($heading_tag); ?>>
            <div class="mt-4 bg-orange-500 border-orange-500 border-solid border-[3px] min-h-[3px] w-[66px]"></div>
        </div>
        <div class="grid grid-cols-1 gap-10 mt-16 max-md:mt-10 md:grid-cols-2 lg:grid-cols-3">
            <?php if ($history_items): ?>
                <?php foreach ($history_items as $item): ?>
                    <?php
                    $item_image_id = $item['item_image'];
                    $item_image_url = wp_get_attachment_url($item_image_id);
                    $item_image_alt = get_post_meta($item_image_id, '_wp_attachment_image_alt', true);
                    $item_year = $item['item_year'];
                    $item_title = $item['item_title'];
                    $item_description = $item['item_description'];
                    $item_background_color = $item['item_background_color'];
                    ?>
                    <article class="relative">
                        <div class="relative w-full">
                            <img src="<?php echo esc_url($item_image_url); ?>" alt="<?php echo esc_attr($item_image_alt); ?>" class="object-cover w-full aspect-[1.56] max-md:max-w-full" />
                            <div class="absolute bottom-0 px-6 py-2 text-2xl font-semibold leading-none b-0 whitespace-nowrap bg-secondary-dark max-md:px-5"><?php echo esc_html($item_year); ?></div>
                        </div>
                        <div class="flex items-start w-full p-10 bg-white pt-14 max-md:px-5 max-md:max-w-full" style="background-color: <?php echo esc_attr($item_background_color); ?>;">
                            <div class="flex flex-col min-w-[240px]">
                                <span class="text-2xl font-semibold"><?php echo esc_html($item_title); ?></span>
                                <p class="mt-6 text-lg leading-7"><?php echo wp_kses_post($item_description); ?></p>
                            </div>
                        </div>
                    </article>
                <?php endforeach; ?>
            <?php endif; ?>
        </div>
    </div>
</section>
