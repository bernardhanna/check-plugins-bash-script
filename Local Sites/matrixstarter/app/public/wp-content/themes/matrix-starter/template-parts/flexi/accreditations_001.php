<section class="accreditations-slider grid lg:grid-cols-7 gap-10 justify-between items-center w-full max-w-[1440px] max-md:max-w-full mx-auto pb-24 max-lg:px-8">
    <?php
    // Fetch all accreditations posts
    $accreditations_query = new WP_Query(array(
        'post_type' => 'accreditations',
        'posts_per_page' => -1, // Get all accreditations posts
    ));

    if ($accreditations_query->have_posts()) :
        while ($accreditations_query->have_posts()) : $accreditations_query->the_post();
            // Get the featured image details
            $featured_image_id = get_post_thumbnail_id();
            $featured_image = wp_get_attachment_image_src($featured_image_id, 'full'); // Get full size image
            $featured_image_url = $featured_image[0] ?? ''; // URL of the image
            $featured_image_alt = get_post_meta($featured_image_id, '_wp_attachment_image_alt', true); // Alt text
            $featured_image_title = get_the_title($featured_image_id); // Title of the image
            ?>
            <div class="flex items-center justify-center">
                <?php if ($featured_image_url) : ?>
                    <img src="<?php echo esc_url($featured_image_url); ?>" 
                         alt="<?php echo esc_attr($featured_image_alt); ?>" 
                         title="<?php echo esc_attr($featured_image_title); ?>" 
                         class="object-contain w-full max-w-[200px] max-h-[120px]" />
                <?php endif; ?>
            </div>
        <?php endwhile;
        wp_reset_postdata(); // Reset the global post object so that the rest of the page works correctly
    endif; ?>
</section>


<script>
jQuery(document).ready(function($) {
    function initSlick() {
        var windowWidth = $(window).width();

        // Activate Slick slider for widths <= 1023px
        if (windowWidth <= 1023) {
            if (!$('.accreditations-slider').hasClass('slick-initialized')) {
                $('.accreditations-slider').slick({
                    slidesToShow: 6,    // Start with 6 slides for widths <= 1023px
                    slidesToScroll: 1,
                    autoplay: true,
                    autoplaySpeed: 3000,
                    arrows: true,       // Enable navigation arrows
                    dots: false,        // Disable dots (indicators)
                    infinite: true,
                    prevArrow: '<svg class="slick-prev" xmlns="http://www.w3.org/2000/svg" width="4em" height="4em" viewBox="0 0 24 24"><path fill="none" stroke="#4e9249" stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="m14 7l-5 5m0 0l5 5"/></svg>',
                    nextArrow: '<svg class="slick-next" xmlns="http://www.w3.org/2000/svg" width="4em" height="4em" viewBox="0 0 24 24"><path fill="none" stroke="#4e9249" stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="m10 17l5-5m0 0l-5-5"/></svg>',
                    responsive: [
                        {
                            breakpoint: 1022,
                            settings: {
                                slidesToShow: 5, // 5 slides for widths <= 1022px
                            }
                        },
                        {
                            breakpoint: 993,
                            settings: {
                                slidesToShow: 4, // 4 slides for widths <= 993px
                            }
                        },
                        {
                            breakpoint: 768,
                            settings: {
                                slidesToShow: 3, // 3 slides for widths <= 768px
                            }
                        },
                        {
                            breakpoint: 680,
                            settings: {
                                slidesToShow: 2, // 2 slides for widths <= 680px
                            }
                        },
                        {
                            breakpoint: 575,
                            settings: {
                                slidesToShow: 1, // 1 slide for widths <= 575px
                            }
                        }
                    ]
                });
            }
        } else {
            // Unslick the slider if initialized and window width is > 1023px
            if ($('.accreditations-slider').hasClass('slick-initialized')) {
                $('.accreditations-slider').slick('unslick');
            }
        }
    }

    // Debounce function to prevent rapid firing on resize
    function debounce(func, wait) {
        var timeout;
        return function() {
            var context = this, args = arguments;
            clearTimeout(timeout);
            timeout = setTimeout(function() {
                func.apply(context, args);
            }, wait);
        };
    }

    // Run on document ready
    initSlick();

    // Re-run initSlick on window resize, using debounce for better performance
    $(window).on('resize', debounce(function() {
        initSlick();
    }, 250));  // 250ms debounce timer
});
</script>