<?php
get_header();
?>

<main class="site-main">
	<?php get_template_part('template-parts/header/subpage-header'); ?>
    <?php get_template_part('template-parts/header/breadcrumbs'); ?>
    <div class="max-w-[1440px] m-auto max-desktop:px-8">
        <div class="grid grid-cols-1 gap-10 mt-16 md:grid-cols-2 max-md:mt-10">
            <?php if (have_posts()): ?>
                <?php while (have_posts()): the_post(); ?>
                    <a href="<?php the_permalink(); ?>" class="flex flex-col w-full" style="min-width: 240px;">
                        <?php if (has_post_thumbnail()): ?>
                            <img src="<?php echo esc_url(get_the_post_thumbnail_url()); ?>" alt="<?php echo esc_attr(get_post_meta(get_post_thumbnail_id(), '_wp_attachment_image_alt', true)); ?>" class="object-cover w-full aspect-[2.18]" />
                        <?php endif; ?>
                        <div class="flex flex-col justify-between w-full p-10 bg-neutral-100">
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
                <?php endwhile; ?>
            <?php else: ?>
                <p>No posts found.</p>
            <?php endif; ?>
        </div>

		<div class="flex items-center justify-center w-full mt-10 mb-10 pagination">
			<?php
			// Custom pagination function to highlight the current page link and add spacing
			function custom_paginate_links($template) {
				// Add the 'current' class to the active page
				$template = str_replace("page-numbers current", "page-numbers current text-orange-500 font-bold", $template);

				// Add spacing between page numbers
				$template = str_replace("page-numbers", "page-numbers mx-2", $template);

				return $template;
			}

			// Add filter to modify paginate_links output
			add_filter('paginate_links_output', 'custom_paginate_links');

			// Output the pagination
			echo paginate_links(array(
				'total' => $wp_query->max_num_pages,
				'current' => max(1, get_query_var('paged')),
				'mid_size' => 1,
				'prev_text' => __('&laquo; Prev', 'text-domain'),
				'next_text' => __('Next &raquo;', 'text-domain'),
			));

			// Remove the filter to avoid affecting other pagination instances
			remove_filter('paginate_links_output', 'custom_paginate_links');
			?>
		</div>


    </div>
</main>

<?php
get_footer();