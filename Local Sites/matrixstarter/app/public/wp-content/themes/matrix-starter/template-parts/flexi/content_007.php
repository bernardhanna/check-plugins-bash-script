<?php
$heading_tag = get_sub_field('heading_tag') ?: 'h2';
$heading_text = get_sub_field('heading_text');
$content_paragraph = get_sub_field('content_paragraph');
$content_image_id = get_sub_field('content_image');
$content_image_url = wp_get_attachment_url($content_image_id);
$content_image_alt = get_post_meta($content_image_id, '_wp_attachment_image_alt', true);
$button_text = get_sub_field('button_text');
$button_link = get_sub_field('button_link');
$background_color = get_sub_field('background_color') ?: '#FFFFFF';
$sections = get_sub_field('sections');
?>
<section class="flex flex-col items-center" style="background-color: <?php echo esc_attr($background_color); ?>;">
    <div class="max-desktop:px-8 py-8 lg:py-20 max-w-[1440px] m-auto px-4 lg:px-8 xxl:px-0">
        <div class="flex flex-col items-start justify-between max-w-full tablet:flex-row">
            <article class="w-full font-semibold text-black tablet:pr-20 tablet:w-1/2">
                <div class="flex flex-col w-full text-3xl leading-10">
                    <<?php echo esc_html($heading_tag); ?>><?php echo esc_html($heading_text); ?></<?php echo esc_html($heading_tag); ?>>
                    <div class="mt-4 bg-orange-500 border-orange-500 border-solid border-[3px] min-h-[3px] w-[66px]"></div>
                </div>
                <div class="mt-6 text-lg font-normal leading-7">
                    <?php echo wp_kses_post($content_paragraph); ?>
                </div>
                <div class="flex items-center gap-10 mt-6 text-base text-white uppercase">
                    <a href="<?php echo esc_url($button_link); ?>" class="px-12 bg-green-700 min-h-[60px] w-full lg:min-w-[240px] lg:w-[370px] flex items-center justify-center border-2 border-[#0D783D] hover:bg-transparent hover:text-[#0D783D]" role="button">
                        <?php echo esc_html($button_text); ?> ss
                    </a>
                    <?php if ($content_image_url): ?>
                        <img src="<?php echo esc_url($content_image_url); ?>" alt="<?php echo esc_attr($content_image_alt); ?>" class="max-tablet:hidden object-cover w-[203px]" />
                    <?php endif; ?>
                </div>
            </article>
            <div class="flex flex-col w-full tablet:gap-10 max-tablet:py-12 xl:flex-row tablet:w-1/2">
                <?php if ($sections): ?>
                    <?php foreach ($sections as $section): ?>
                        <?php
                        $section_icon_id = $section['section_icon'];
                        $section_icon_url = wp_get_attachment_url($section_icon_id);
                        $section_icon_alt = get_post_meta($section_icon_id, '_wp_attachment_image_alt', true);
                        $section_title = $section['section_title'];
                        $section_text = $section['section_text'];
                        $section_background_color = $section['section_background_color'];
                        ?>
                        <div class="flex flex-col justify-start w-full xl:w-1/2" style="background-color: <?php echo esc_attr($section_background_color); ?>;">
                            <div class="flex justify-center h-[240px]">
                                <?php if ($section_icon_url): ?>
                                    <img src="<?php echo esc_url($section_icon_url); ?>" alt="<?php echo esc_attr($section_icon_alt); ?>" class="object-cover w-full" />
                                <?php endif; ?>
                            </div>
                            <div class="flex flex-col p-10 text-black bg-neutral-100">
                                <h3 class="text-3xl font-semibold"><?php echo esc_html($section_title); ?></h3>
                                <p class="mt-2.5 text-lg leading-7"><?php echo wp_kses_post($section_text); ?></p>
                            </div>
                        </div>
                    <?php endforeach; ?>
                <?php endif; ?>
            </div>
        </div>
    </div>
</section>
