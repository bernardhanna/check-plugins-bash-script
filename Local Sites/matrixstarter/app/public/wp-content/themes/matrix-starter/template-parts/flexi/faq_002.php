<?php
$heading_tag = get_sub_field('heading_tag') ?: 'h2';
$heading_text = get_sub_field('heading_text');
$faq_items = get_sub_field('faq_items');
$form_shortcode = get_sub_field('form_shortcode');
$section_bg_color = get_sub_field('section_bg_color');
?>
<section class="flex flex-col items-center justify-center pb-20 max-desktop:px-8" style="background-color: <?php echo esc_attr($section_bg_color); ?>;">
    <div class="max-w-[1440px] m-auto flex flex-col">
        <div class="grid grid-cols-1 xl:grid-cols-2 gap-[5rem] mt-16">

			<div class="flex flex-wrap items-start justify-between" x-data="{ openIndex: null }">
                <?php if ($faq_items): ?>
                    <?php foreach ($faq_items as $index => $item): ?>
                        <?php
                        $faq_post = $item['faq_item'];
                        if ($faq_post):
                            $faq_title = get_the_title($faq_post);
                            $faq_content = apply_filters('the_content', get_post_field('post_content', $faq_post));
                        ?>
                            <div class="w-full mt-4 md:mt-0">
                                <button 
                                    class="w-full text-left" 
                                    @click="openIndex === <?php echo $index; ?> ? openIndex = null : openIndex = <?php echo $index; ?>"
                                    :class="openIndex === <?php echo $index; ?> ? 'bg-[#0D783D] text-white' : 'bg-[#EFF5EC] text-black'"
                                >
                                    <div class="flex flex-row justify-between gap-5 lg:gap-10 p-5 cursor-pointer">
                                        <h3 class="md:text-base xl:text-2xl font-semibold leading-none w-[80%] lg:w-[90%] md:min-w-[240px] max-md:max-w-full">
                                            <?php echo esc_html($faq_title); ?>
                                        </h3>
                                        <div class="flex items-center justify-center">
                                            <img x-show="openIndex !== <?php echo $index; ?>" src="<?php echo get_site_url(); ?>/wp-content/uploads/2024/09/Vector.png" alt="Down Icon" >
                                            <img x-show="openIndex === <?php echo $index; ?>" src="<?php echo get_site_url(); ?>/wp-content/uploads/2024/09/up.png" alt="Up Icon" >
                                        </div>
                                    </div>
                                </button>
                                <div x-show="openIndex === <?php echo $index; ?>" class="p-5 text-lg leading-7 bg-neutral-100" x-cloak>
                                    <?php echo wp_kses_post($faq_content); ?>
                                </div>
                            </div>
                        <?php endif; ?>
                    <?php endforeach; ?>
                <?php endif; ?>
            </div>
			
            <?php if ($form_shortcode): ?>
            <div class="flex items-start justify-center w-full px-10 py-20 text-black bg-secondary-dark max-md:px-5">
				<div class="flex flex-col w-full">
				     <header class="flex flex-col self-start text-3xl font-semibold leading-none">
                        <h2>Ask your questions</h2>
                        <div class="mt-4 bg-orange-500 border-orange-500 border-solid border-[3px] min-h-[3px] w-[66px]"></div>
                    </header>
                <?php echo do_shortcode($form_shortcode); ?>
					</div>
            </div>
            <?php else : ?>
            <div class="flex items-start justify-center w-full px-10 py-20 text-black bg-secondary-dark max-md:px-5 max-h-[860px]">
                <div class="flex flex-col w-full">
                    <header class="flex flex-col self-start text-3xl font-semibold leading-none">
                        <h2>Ask your questions</h2>
                        <div class="mt-4 bg-orange-500 border-orange-500 border-solid border-[3px] min-h-[3px] w-[66px]"></div>
                    </header>
                    <form class="flex flex-col gap-2.5 mt-16 w-full text-xl leading-snug max-md:mt-10">
                        <div class="flex flex-col gap-6">
                            <input type="text" id="name" name="name" placeholder="Name*" required class="w-full p-5 bg-white min-h-[68px] " aria-required="true">
                            <input type="email" id="email" name="email" placeholder="Mail*" required class="w-full p-5 bg-white min-h-[68px] " aria-required="true">
                            <input type="text" id="subject" name="subject" placeholder="Subject" class="w-full p-5 bg-white min-h-[68px] ">
                            <textarea id="questions" name="questions" placeholder="Your questions..." class="w-full px-5 pt-5 pb-44 bg-white min-h-[220px]  max-md:pb-24"></textarea>
                            <button type="submit" class="w-full px-12 mt-6 text-base font-semibold text-white uppercase bg-green-700 min-h-[60px] border-2 border-[#0D783D] hover:bg-transparent hover:text-[#0D783D]">
                                Submit now
                            </button>
                        </div>
                    </form>
                </div>
            </div>
            <?php endif; ?>
        </div>
    </div>
</section>
