<?php
$heading_tag = get_sub_field('heading_tag') ?: 'h2';
$heading_text = get_sub_field('heading_text');
$section_bg_color = get_sub_field('section_bg_color') ?: '#F3F4F6';

// Query for the latest job posts
$jobs_query = new WP_Query([
    'post_type' => 'jobs',
    'posts_per_page' => 6, // Adjust the number of posts displayed
]);

?>
<section class="flex flex-col items-center justify-center py-8 text-black lg:py-20" style="background-color: <?php echo esc_attr($section_bg_color); ?>;">
    <div class="max-w-[1440px] m-auto px-4 lg:px-8 xxl:px-0">
        <div class="flex flex-col text-3xl font-semibold leading-none">
            <<?php echo esc_html($heading_tag); ?>><?php echo esc_html($heading_text); ?></<?php echo esc_html($heading_tag); ?>>
            <div class="mt-4 bg-orange-500 border-orange-500 border-solid border-[3px] min-h-[3px] w-[66px]"></div>
        </div>
        <div class="grid grid-cols-1 gap-10 mt-16 max-md:mt-10 md:grid-cols-2">
            <?php if ($jobs_query->have_posts()): ?>
                <?php while ($jobs_query->have_posts()): $jobs_query->the_post(); ?>
                    <a href="<?php the_permalink(); ?>" class="block p-10 bg-white">
                        <article class="flex flex-col">
                            <h3 class="text-2xl leading-none"><?php the_title(); ?></h3>
                            <time class="mt-6 leading-loose"><?php echo get_the_date(); ?></time>
                            <p class="mt-6 leading-7"><?php echo wp_trim_words(get_the_excerpt(), 20); ?></p>
                            <span class="self-start px-12 mt-6 text-base text-white uppercase bg-green-700 min-h-[60px] flex items-center justify-center max-md:px-5 font-semibold border-2 border-[#0D783D] hover:bg-transparent hover:text-[#0D783D]">Read more</span>
                        </article>
                    </a>
                <?php endwhile; wp_reset_postdata(); ?>
            <?php else: ?>
                <p>No job openings available.</p>
            <?php endif; ?>
        </div>
    </div>
</section>
