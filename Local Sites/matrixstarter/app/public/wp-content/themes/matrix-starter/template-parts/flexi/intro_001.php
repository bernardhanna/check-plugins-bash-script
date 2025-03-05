<?php
$intro_001_heading_tag = get_sub_field('intro_001_heading_tag') ?: 'h2'; // Default to h2 if not set
$intro_001_heading_text = get_sub_field('intro_001_heading_text');
$intro_001_paragraph_text = get_sub_field('intro_001_paragraph_text');
$intro_001_button_link = get_sub_field('intro_001_button_link');
?>
<section class="flex max-w-[1440px] mx-auto px-4 lg:px-8 xxl:px-0 relative">
    <div class="flex flex-col w-full px-4 py-16 my-12 lg:px-12 max-md:max-w-full bg-secondary-dark">
        <?php if ($intro_001_heading_text): ?>
            <<?php echo esc_html($intro_001_heading_tag); ?> class="text-2xl lg:text-3xl font-semibold leading-[2rem] text-center text-black max-md:max-w-full">
                <?php echo esc_html($intro_001_heading_text); ?>
            </<?php echo esc_html($intro_001_heading_tag); ?>>
        <?php endif; ?>

        <?php if ($intro_001_paragraph_text): ?>
            <div class="px-8 mt-6 text-lg leading-7 text-center text-black lg:px-20 max-md:max-w-full">
                <?php echo wp_kses_post($intro_001_paragraph_text); ?>
            </div>
        <?php endif; ?>

        <?php if ($intro_001_button_link): ?>
            <a href="<?php echo esc_url($intro_001_button_link['url']); ?>"
                title="<?php echo esc_attr($intro_001_button_link['title']); ?>"
                class="self-center flex items-center justify-center px-12 mt-6 text-base text-white uppercase bg-green-700 w-full max-w-[252px] min-h-[60px] max-md:px-5 font-semibold border-2 border-[#0D783D] hover:bg-transparent hover:text-[#0D783D]">
                <?php echo esc_html($intro_001_button_link['title']); ?>
            </a>
        <?php endif; ?>
    </div>
</section>