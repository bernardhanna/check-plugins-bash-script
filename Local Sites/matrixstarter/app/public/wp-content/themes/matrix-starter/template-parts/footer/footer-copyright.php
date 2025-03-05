<section class="flex flex-col items-center self-stretch justify-center py-5 text-lg leading-loose bg-white">
  <div class="flex flex-col-reverse md:flex-row gap-10 justify-between items-center max-w-full w-[1440px] max-sm:px-6 max-desktop:px-8">
    <span class="self-stretch my-auto text-black max-md:max-w-full">
      &copy; <?php echo date('Y'); ?> <?php bloginfo('name'); ?>.
      <?php echo __('All rights reserved.', 'matrix-starter'); ?>
    </span>
    <nav class="flex flex-wrap gap-4 items-center self-stretch my-auto font-bold text-green-700 min-w-[240px] max-md:max-w-full">
      <?php if (function_exists('wp_nav_menu')) : ?>
        <?php
        wp_nav_menu([
          'theme_location' => 'copyright',
          'container' => false,
          'items_wrap' => '<ul id="%1$s" class="%2$s">%3$s</ul>',
          'menu_class' => 'flex flex-wrap gap-4 items-center self-stretch my-auto font-bold text-green-700',
          'fallback_cb' => false,
        ]);
        ?>
      <?php endif; ?>
    </nav>
  </div>
</section>