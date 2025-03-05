<?php
// Get ACF fields for the section
$heading_tag = get_sub_field('heading_tag') ?: 'h2';
$heading_text = get_sub_field('heading_text') ?: 'Why choose House 2 Home to manage your Deep Retrofit?';
$articles = get_sub_field('articles');
?>
<section class="flex flex-col items-center justify-center px-4 py-8 text-black lg:py-20 bg-neutral-100 lg:px-8 xxl:px-0">
    <div class="max-w-[1440px] mx-auto">
        <div class="flex flex-col text-3xl font-semibold leading-none max-sm:justify-center max-sm:items-center max-sm:text-center">
            <<?php echo esc_html($heading_tag); ?> class="max-md:max-w-full"><?php echo esc_html($heading_text); ?></<?php echo esc_html($heading_tag); ?>>
            <div class="mt-8 lg:mt-4 bg-orange-500 border-orange-500 border-solid border-[3px] min-h-[3px] w-[66px]"></div>
        </div>
        <div class="flex flex-wrap justify-between max-w-full mt-8 max-md:mt-2">
            <?php if ($articles): ?>
                <?php foreach ($articles as $article): ?>
                    <?php
                    $article_image_id = $article['article_image'];
                    $article_image_url = wp_get_attachment_url($article_image_id);
                    $article_image_alt = get_post_meta($article_image_id, '_wp_attachment_image_alt', true);
                    $article_title = $article['article_title'];
                    $article_description = $article['article_description'];
                    $background_color = $article['background_color'];
                    $text_color = $article['text_color'];
                    ?>
                    <article class="flex flex-col min-w-[240px] w-full lg:w-[calc(33.333%-2rem)] relative mt-8">
                        <div class="w-full bg-white min-h-[280px] max-md:max-w-full flex justify-center items-center">
                        <?php if ($article_image_url): ?>
                            <img src="<?php echo esc_url($article_image_url); ?>" alt="<?php echo esc_attr($article_image_alt); ?>" class="object-contain" />
                        <?php endif; ?>
                        </div>
                        <div class="flex items-start w-full p-10 size-full max-md:px-5 max-md:max-w-full" style="background-color: <?php echo esc_attr($background_color); ?>; color: <?php echo esc_attr($text_color); ?>;">
                            <div class="flex flex-col min-w-[240px]">
                                <h3 class="text-3xl font-semibold leading-10"><?php echo esc_html($article_title); ?></h3>
                                 <p class="mt-6 text-lg leading-7"><?php echo wp_kses_post($article_description); ?></p>
                            </div>
                        </div>
                    </article>
                <?php endforeach; ?>
            <?php endif; ?>
        </div>
    </div>
</section>

