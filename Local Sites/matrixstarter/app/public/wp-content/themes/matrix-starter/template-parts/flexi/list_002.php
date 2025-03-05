<?php
// Fetch the repeater field for articles within the list_002 layout
$articles = get_sub_field('articles'); // Ensure you're using get_sub_field within a layout block context
?>

<section class="py-8 lg:py-20">
    <div class="max-w-[1440px] m-auto flex flex-wrap justify-between gap-10 px-4 lg:px-8 xxl:px-0">
        <?php if ($articles): ?>
            <?php foreach ($articles as $article): ?>
                <?php
                $heading = $article['heading'];
                $main_image_id = $article['main_image'];
                $main_image_url = $main_image_id ? wp_get_attachment_image_url($main_image_id, 'full') : '';
                $main_image_alt = $main_image_id ? get_post_meta($main_image_id, '_wp_attachment_image_alt', true) : '';
                $content = $article['content'];
                $list_items = $article['list_items'];
                $button_link = $article['button_link'];
                $background_color = $article['background_color'] ?: '#FFFFFF';
                ?>
                
                <article class="flex flex-col min-w-[240px] w-full lg:w-[46%] xl:w-[48%]" style="background-color: <?php echo esc_attr($background_color); ?>;">
                    <?php if ($main_image_url): ?>
                        <img src="<?php echo esc_url($main_image_url); ?>" alt="<?php echo esc_attr($main_image_alt); ?>" class="object-cover w-full aspect-[1.73] min-h-[190px] lg:min-h-[405px]" />
                    <?php endif; ?>

                    <div class="flex flex-col px-16 py-10 max-md:px-5">
                        <?php if ($heading): ?>
                            <h2 class="text-3xl font-semibold"><?php echo esc_html($heading); ?></h2>
                        <?php endif; ?>

                        <?php if ($content): ?>
                            <div class="mt-6"><?php echo wp_kses_post($content); ?></div>
                        <?php endif; ?>

                        <?php if ($list_items): ?>
                            <ul class="mt-6">
                                <?php foreach ($list_items as $item): ?>
                                    <?php
                                    $item_text = $item['item_text'];
                                    ?>
                                    <li class="flex items-center gap-4 py-3">
                                        <div class="w-[10%]">          
										<svg class="w-full mr-4" xmlns="http://www.w3.org/2000/svg" width="40" height="40" viewBox="0 0 40 40" fill="none">
                                        <path d="M17.0658 27.1907L9.99414 20.1173L12.3508 17.7607L17.0658 22.474L26.4925 13.0457L28.8508 15.404L17.0658 27.1907Z" fill="#0D783D"/>
                                        <path fill-rule="evenodd" clip-rule="evenodd" d="M1.66211 20.0003C1.66211 9.87533 9.87044 1.66699 19.9954 1.66699C30.1204 1.66699 38.3288 9.87533 38.3288 20.0003C38.3288 30.1253 30.1204 38.3337 19.9954 38.3337C9.87044 38.3337 1.66211 30.1253 1.66211 20.0003ZM19.9954 35.0003C18.0256 35.0003 16.0751 34.6123 14.2552 33.8585C12.4353 33.1047 10.7817 31.9998 9.38884 30.6069C7.99596 29.214 6.89107 27.5605 6.13725 25.7406C5.38343 23.9207 4.99544 21.9702 4.99544 20.0003C4.99544 18.0305 5.38343 16.08 6.13725 14.2601C6.89107 12.4402 7.99596 10.7866 9.38884 9.39372C10.7817 8.00084 12.4353 6.89595 14.2552 6.14213C16.0751 5.38831 18.0256 5.00033 19.9954 5.00033C23.9737 5.00033 27.789 6.58068 30.602 9.39372C33.4151 12.2068 34.9954 16.0221 34.9954 20.0003C34.9954 23.9786 33.4151 27.7939 30.602 30.6069C27.789 33.42 23.9737 35.0003 19.9954 35.0003Z" fill="#0D783D"/>
                                    </svg>
									</div>
                                        <span class="font-bold w-[90%]"><?php echo esc_html($item_text); ?></span>
                                    </li>
                                <?php endforeach; ?>
                            </ul>
                        <?php endif; ?>

                        <?php if ($button_link): ?>
                            <a href="<?php echo esc_url($button_link['url']); ?>" class="self-center px-12 mt-6 text-base font-semibold text-white uppercase bg-green-700 min-h-[60px] flex items-center justify-center max-md:px-5 border-2 border-[#0D783D] hover:bg-transparent hover:text-[#0D783D]">
                                <?php echo esc_html($button_link['title']); ?>
                            </a>
                        <?php endif; ?>
                    </div>
                </article>
            <?php endforeach; ?>
        <?php else: ?>
            <p>No articles found.</p>
        <?php endif; ?>
    </div>
</section>
