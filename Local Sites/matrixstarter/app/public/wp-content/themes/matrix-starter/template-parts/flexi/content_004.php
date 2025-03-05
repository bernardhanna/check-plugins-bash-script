<?php
$heading_tag = get_sub_field('heading_tag') ?: 'h2';
$heading_text = get_sub_field('heading_text');
$content_text = get_sub_field('content_text');
$background_color = get_sub_field('background_color');
$images = get_sub_field('images');
?>

<section class="flex flex-col items-center justify-center py-8 lg:py-20" style="background-color: <?php echo esc_attr($background_color); ?>;">
    <div class="flex flex-wrap justify-between w-full max-w-[1440px] mx-auto px-4 lg:px-8 xxl:px-0">
        <article class="xl:py-16 xl:pr-16 flex flex-col justify-center min-w-[240px] w-full md:w-1/2">
            <?php if ($heading_text): ?>
                <<?php echo esc_html($heading_tag); ?> class="text-3xl font-semibold leading-10 text-black">
                    <?php echo esc_html($heading_text); ?>
                </<?php echo esc_html($heading_tag); ?>>
            <?php endif; ?>
            <?php if ($content_text): ?>
                <p class="mt-6 text-lg leading-7 text-black">
                    <?php echo wp_kses_post($content_text); ?>
                </p>
            <?php endif; ?>
        </article>
        <aside class="flex flex-col justify-center items-center px-9 py-10 min-w-[240px] w-full md:w-1/2">
            <div class="flex flex-row items-start justify-center w-full gap-10">
                <?php if ($images): ?>
                    <?php foreach ($images as $image): ?>
                        <?php
                        $image_id = $image['image'];
                        $image_url = $image_id ? wp_get_attachment_image_url($image_id, 'full') : '';
                        $image_alt = $image_id ? get_post_meta($image_id, '_wp_attachment_image_alt', true) : '';
                        ?>
                        <figure class="flex flex-col w-full md:w-1/2">
                            <?php if ($image_url): ?>
                                <img src="<?php echo esc_url($image_url); ?>" alt="<?php echo esc_attr($image_alt); ?>" class="object-cover w-full" />
                            <?php endif; ?>
                        </figure>
                    <?php endforeach; ?>
                <?php endif; ?>
            </div>
        </aside>
    </div>
</section>
