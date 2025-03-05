<?php
$heading_tag = get_sub_field('heading_tag') ?: 'h2';
$heading_text = get_sub_field('heading_text');
$contact_description = get_sub_field('contact_description');
$contact_info = get_sub_field('contact_info');
$section_bg_color = get_sub_field('section_bg_color') ?: '#F3F4F6';
$iframe_code = get_sub_field('iframe_code');
?>

<section class="flex flex-col items-center py-8 text-black xl:py-20" style="background-color: <?php echo esc_attr($section_bg_color); ?>;">
    <div class="max-w-[1440px] m-auto px-4 lg:px-8 xxl:px-0 w-full">
        <div class="flex flex-col text-3xl font-semibold leading-none">
            <<?php echo esc_html($heading_tag); ?>><?php echo esc_html($heading_text); ?></<?php echo esc_html($heading_tag); ?>>
            <div class="mt-4 bg-orange-500 border-orange-500 border-solid border-[3px] min-h-[3px] w-[66px]"></div>
        </div>
        <p class="mt-6 text-2xl leading-none">
            <?php echo wp_kses_post($contact_description); ?>
        </p>
        <div class="grid grid-cols-1 gap-10 mt-16 bg-white md:grid-cols-2 max-md:mt-10">
            <?php if ($contact_info): ?>
                <?php foreach ($contact_info as $info): ?>
                    <article class="flex flex-col h-full p-10">
                        <div>
                            <h3 class="text-2xl font-semibold leading-none"><?php echo esc_html($info['contact_title']); ?></h3>
                            <div class="mt-6 text-lg leading-7">
                                <?php echo wp_kses_post($info['contact_details']); ?>
                            </div>
                        </div>
                    </article>
                <?php endforeach; ?>
            <?php endif; ?>
            <?php if ($iframe_code): ?>
                <div class="w-full">
                    <?php echo $iframe_code; ?>
                </div>
            <?php endif; ?>
        </div>
    </div>
</section>
