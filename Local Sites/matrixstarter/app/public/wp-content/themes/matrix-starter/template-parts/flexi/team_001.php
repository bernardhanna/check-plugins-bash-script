<?php
$heading_tag = get_sub_field('heading_tag') ?: 'h2';
$heading_text = get_sub_field('heading_text');
$team_members = get_sub_field('team_members');
?>
<section class="flex flex-col items-center justify-center py-8 lg:py-20 text-black bg-[#E7E7E7] max-desktop:px-8">
    <div class="max-w-[1440px] m-auto">
        <div class="flex flex-col text-3xl font-semibold leading-none">
            <<?php echo esc_html($heading_tag); ?>><?php echo esc_html($heading_text); ?></<?php echo esc_html($heading_tag); ?>>
            <div class="mt-4 bg-orange-500 border-orange-500 border-solid border-[3px] min-h-[3px] w-[66px]" aria-hidden="true"></div>
        </div>
        <div class="grid grid-cols-1 gap-10 mt-16 max-md:mt-10 md:grid-cols-2 lg:grid-cols-4">
            <?php if ($team_members): ?>
                <?php foreach ($team_members as $member): ?>
                    <?php
                    $post = $member['team_member'];
                    setup_postdata($post);

                    $team_image_url = get_the_post_thumbnail_url($post->ID, 'full');
                    $team_image_alt = get_post_meta(get_post_thumbnail_id($post->ID), '_wp_attachment_image_alt', true);
                    $team_name = get_the_title($post->ID);
                    $team_content = get_the_content($post->ID); // Get the content of the post
                    $team_categories = get_the_terms($post->ID, 'team_category'); // Get the team categories
                    ?>
                    <article class="flex flex-col">
                        <?php if ($team_image_url): ?>
                            <img src="<?php echo esc_url($team_image_url); ?>" alt="<?php echo esc_attr($team_image_alt); ?>" class="object-cover w-full aspect-[1.25]" />
                        <?php endif; ?>
                        <div class="flex flex-col items-center w-full py-8 bg-white">
                            <span class="text-2xl font-semibold leading-none text-center"><?php echo esc_html($team_name); ?></span>
                            <p class="mt-2 text-lg leading-loose"><?php echo wp_kses_post($team_content); ?></p>
                            <?php if ($team_categories && !is_wp_error($team_categories)): ?>
                                <div class="mt-4 text-sm text-gray-600">
                                    
                                    <ul class="flex flex-wrap justify-center space-x-2">
                                        <?php foreach ($team_categories as $category): ?>
                                            <li><span class="px-2 py-1 rounded"><?php echo esc_html($category->name); ?></span></li>
                                        <?php endforeach; ?>
                                    </ul>
                                </div>
                            <?php endif; ?>
                        </div>
                    </article>
                    <?php wp_reset_postdata(); ?>
                <?php endforeach; ?>
            <?php endif; ?>
        </div>
    </div>
</section>
