 <?php
  // Get ACF fields
  $hero_image = get_field('hero_image');
  $hero_image_alt = get_field('hero_image_alt');
  $hero_image_title = get_field('hero_image_title');

  // Get featured image if ACF image is not set
  if (!$hero_image) {
    $hero_image = get_the_post_thumbnail_url(get_the_ID(), 'full');
    $hero_image_alt = get_post_meta(get_post_thumbnail_id(get_the_ID()), '_wp_attachment_image_alt', true);
    $hero_image_title = get_the_title(get_post_thumbnail_id(get_the_ID()));
  }

  // Get the ACF title or fallback to the post title
  // Set title for different scenarios
  if (is_home()) {
    // This is the blog index page (set in WordPress settings)
    $hero_title = get_field('hero_title') ?: get_the_title(get_option('page_for_posts'));
  } else {
    // For all other pages, use the ACF hero title or fall back to the post title
    $hero_title = get_field('hero_title') ?: get_the_title();
  }

  $hero_heading_tag = get_field('hero_heading_tag') ?: 'h1';

  // Get the font size, line height, and max width settings
  $hero_font_size = get_field('hero_font_size') ?: 'text-[48px]';
  $hero_line_height = get_field('hero_line_height') ?: 'leading-[56px]';
  $hero_max_width = get_field('hero_max_width');

  // Set title for different scenarios
  if (is_home()) {
    // For the blog index page, use the ACF hero title or fall back to the "Posts Page" title
    $hero_title = get_field('hero_title') ?: get_the_title(get_option('page_for_posts'));
    // Get the ACF hero description for the blog index page or leave it empty
    $hero_description = get_field('hero_description') ?: get_the_excerpt(get_option('page_for_posts'));
  } else {
    // For other pages, use the ACF hero title and description or fallback to the post title and excerpt
    $hero_title = get_field('hero_title') ?: get_the_title();
    $hero_description = get_field('hero_description') ?: get_the_excerpt();
  }


  $hero_link = get_field('hero_link');
  $hero_link_title = get_field('hero_link_title');
  $hero_link_alt = get_field('hero_link_alt');

  $hero_secondary_link = get_field('hero_secondary_link');

  // Get the height and width settings
  $hero_height = get_field('hero_height') ?: 'xxl:max-h-[500px]';
  $hero_width = get_field('hero_width') ?: 'xl:max-w-[745px]';

  // Check if any of the key fields have content
  if ($hero_image || $hero_title || $hero_description || $hero_link || $hero_secondary_link):

  ?>

   <section class="bg-top bg-cover md:block" style="background-image: url('<?php echo esc_url($hero_image); ?>')" class="<?php echo esc_attr($hero_height); ?>">
     <div class="container max-w-[1440px]  max-xxl:px-8 mx-auto">
       <div class="py-28">
         <div class="w-full lg:w-[612px] bg-[#0D783D] p-8">
           <?php if ($hero_title): ?>
             <<?php echo esc_html($hero_heading_tag); ?> class="text-2xl lg:text-4xl font-semibold text-white xl:<?php echo esc_attr($hero_font_size); ?> xl:<?php echo esc_attr($hero_line_height); ?>"
               <?php if ($hero_max_width): ?>
               style="max-width: <?php echo esc_attr($hero_max_width); ?>;"
               <?php endif; ?>>
               <?php echo esc_html($hero_title); ?>
             </<?php echo esc_html($hero_heading_tag); ?>>
           <?php endif; ?>
           <?php if ($hero_description): ?>
             <p class="mt-6 text-lg leading-7 text-white max-md:max-w-full"><?php echo esc_html($hero_description); ?></p>
             <div class="mt-8">
             <?php endif; ?>
             <?php if ($hero_link): ?>
               <a href="<?php echo esc_url($hero_link['url']); ?>"
                 <?php if ($hero_link_title): ?>
                 title="<?php echo esc_attr($hero_link_title); ?>"
                 <?php endif; ?>
                 <?php if ($hero_link_alt): ?>
                 alt="<?php echo esc_attr($hero_link_alt); ?>"
                 <?php endif; ?>
                 class="flex items-center justify-center px-12 py-4 bg-white text-black text-base font-semibold uppercase min-h-[60px] min-w-[252px] w-auto max-w-fit border-2 border-white hover:bg-transparent hover:text-white">
                 <?php echo esc_html($hero_link['title']); ?>
               </a>
             <?php endif; ?>
             </div>
         </div>
       </div>
     </div>
   </section>
 <?php endif; ?>