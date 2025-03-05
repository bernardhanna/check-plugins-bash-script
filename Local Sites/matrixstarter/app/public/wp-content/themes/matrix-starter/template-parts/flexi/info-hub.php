<?php
$info_hub_items = get_sub_field('info_hub_items');
$section_bg_color = get_sub_field('section_bg_color') ?: '#FFFFFF';
?>

<section class="flex flex-col items-center py-8 lg:py-20" style="background-color: <?php echo esc_attr($section_bg_color); ?>;">
    <div class="max-w-[1440px] m-auto px-4 lg:px-8 xxl:px-0">
        <div class="grid grid-cols-1 gap-10 md:grid-cols-2 lg:grid-cols-3">
            <?php if ($info_hub_items): ?>
                <?php foreach ($info_hub_items as $item): ?>
                    <?php
                    $item_image_id = $item['item_image'];
                    $item_image_url = wp_get_attachment_url($item_image_id);
                    $item_image_alt = get_post_meta($item_image_id, '_wp_attachment_image_alt', true);
                    $item_title = $item['item_title'];
                    $item_description = $item['item_description'];
                    $item_bg_color = $item['item_bg_color'];
                    $item_link = $item['item_link'];
                    
                    // Get the title of the linked page/post
                    $linked_page_title = get_the_title(url_to_postid($item_link));
                    ?>
                    <a href="<?php echo esc_url($item_link); ?>" class="flex flex-col w-full" style="min-width: 240px;">
                        <img src="<?php echo esc_url($item_image_url); ?>" alt="<?php echo esc_attr($item_image_alt); ?>" class="object-cover w-full aspect-[1.88]" />
                        <div class="flex flex-col justify-between w-full h-auto p-10 pb-0" style="background-color: <?php echo esc_attr($item_bg_color); ?>;">
                            <div class="flex flex-col text-black">
                                <h2 class="text-2xl font-semibold leading-none"><?php echo esc_html($item_title); ?></h2>
                                <div class="mt-3 bg-orange-500 border-orange-500 border-solid border-[3px] min-h-[3px] w-[66px]" aria-hidden="true"></div>
                                <div class="mt-3 text-lg leading-7 clamp-text"><?php echo wp_kses_post($item_description); ?></div>
                            </div>
                            <button class="px-12 mb-10 mt-10 w-full text-base font-semibold text-white uppercase bg-green-700 min-h-[60px] flex items-center justify-center max-md:px-5 max-md:mt-10 border-2 border-[#0D783D] hover:bg-transparent hover:text-[#0D783D]">
                               Visit  <?php echo esc_html($item_title); ?>
                            </button>
                        </div>
                    </a>
                <?php endforeach; ?>
            <?php endif; ?>
        </div>
    </div>
</section>