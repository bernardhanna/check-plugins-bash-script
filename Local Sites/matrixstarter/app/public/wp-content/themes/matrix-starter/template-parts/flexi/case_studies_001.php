<?php
$heading_tag = get_sub_field('heading_tag') ?: 'h2';
$heading_text = get_sub_field('heading_text');
$projects = new WP_Query([
    'post_type' => 'projects',
    'posts_per_page' => -1, // Display all projects
]);

$section_bg_color = get_sub_field('section_bg_color') ?: '#FFFFFF';
?>

<section class="flex flex-col items-center py-8 lg:py-20" style="background-color: <?php echo esc_attr($section_bg_color); ?>;">
    <div class="max-w-[1440px] m-auto px-4 lg:px-8 xxl:px-0">
        <div class="flex flex-col text-3xl font-semibold leading-none">
            <<?php echo esc_html($heading_tag); ?>><?php echo esc_html($heading_text); ?></<?php echo esc_html($heading_tag); ?>>
            <div class="mt-4 bg-orange-500 border-orange-500 border-solid border-[3px] min-h-[3px] w-[66px]" aria-hidden="true"></div>
        </div>
        <div class="grid grid-cols-1 gap-10 mt-16 md:grid-cols-2 max-md:mt-10">
            <?php if ($projects->have_posts()): ?>
                <?php while ($projects->have_posts()): $projects->the_post(); ?>
                    <a href="<?php the_permalink(); ?>" class="flex flex-col w-full" style="min-width: 240px;">
                        <?php if (has_post_thumbnail()): ?>
                            <img src="<?php echo esc_url(get_the_post_thumbnail_url()); ?>" alt="<?php echo esc_attr(get_post_meta(get_post_thumbnail_id(), '_wp_attachment_image_alt', true)); ?>" class="object-cover w-full aspect-[2.18]" />
                        <?php endif; ?>
                        <div class="flex flex-col justify-between w-full p-10 bg-neutral-100 xl:h-[420px]">
                            <div class="flex flex-col text-black">
                                <h2 class="text-3xl font-semibold leading-none"><?php the_title(); ?></h2>
                                <div class="mt-4 bg-orange-500 border-orange-500 border-solid border-[3px] min-h-[3px] w-[66px]" aria-hidden="true"></div>
                                <div class="mt-4 text-lg leading-7"><?php the_excerpt(); ?></div>
                            </div>
                            <button class="px-12 mt-4 text-base font-semibold text-white uppercase bg-green-700 min-h-[60px] w-full lg:w-[370px] mx-auto flex items-center justify-center max-md:px-5 border-2 border-[#0D783D] hover:bg-transparent hover:text-[#0D783D]">
                                Read more
                            </button>
                        </div>
                    </a>
                <?php endwhile; wp_reset_postdata(); ?>
            <?php endif; ?>
        </div>
    </div>
</section>
