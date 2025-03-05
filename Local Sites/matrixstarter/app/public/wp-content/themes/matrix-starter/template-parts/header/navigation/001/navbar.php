<?php
// File: template-parts/header/navigation/001/navbar.php

// Retrieve Logo Information
$logo_id = get_field('logo', 'option');
$logo_url = $logo_id ? wp_get_attachment_image_url($logo_id, 'full') : '';
$logo_alt = $logo_id ? get_post_meta($logo_id, '_wp_attachment_image_alt', true) : get_bloginfo('name');

// Retrieve Calculator Button Text and Link
$calculator_text = get_field('calculator_text', 'option') ?: 'Calculator';
$calculator_link = get_field('calculator_link', 'option');

// Retrieve Hamburger Settings from ACF Mobile Navigation Options
$enable_hamburger = get_field('enable_hamburger', 'option');
$hamburger_style = get_field('hamburger_style', 'option');


?>

<section
  x-data="{ isSticky: false, isOpen: false }"
  x-init="window.addEventListener('scroll', () => { isSticky = window.pageYOffset > 100 })"
  class="relative z-50 py-8 transition-all duration-300 bg-primary"
  x-effect="isOpen ? document.body.style.overflow = 'hidden' : document.body.style.overflow = ''">

  <div :class="{ 'fixed-header': isSticky }" class="flex flex-wrap items-center justify-between w-full m-auto bg-white max-xxl:px-8">
    <div class="max-w-[1440px] mx-auto w-full flex flex-row justify-between items-center">
      <a href="<?php echo esc_url(home_url('/')); ?>" class="flex flex-col items-start justify-center my-auto">
        <?php if ($logo_url) : ?>
          <img src="<?php echo esc_url($logo_url); ?>" alt="<?php echo esc_attr($logo_alt); ?>" class="object-contain max-w-full aspect-[2.33] w-[168px]" />
        <?php else : ?>
          <span class="text-base font-bold"><?php echo get_bloginfo('name'); ?></span>
        <?php endif; ?>
      </a>

      <div class="flex-wrap items-center hidden h-full gap-10 text-base font-semibold text-black uppercase xl:flex">
        <?php

        use Log1x\Navi\Navi;

        $navigation = Navi::make()->build('primary');
        if ($navigation->isNotEmpty()) : ?>
          <nav id="site-navigation">
            <ul id="primary-menu" class="flex space-x-12">
              <?php foreach ($navigation->toArray() as $item) : ?>
                <li class="relative group <?php echo esc_attr($item->classes); ?> <?php echo $item->active ? 'current-item' : ''; ?> ">
                  <a href="<?php echo esc_url($item->url); ?>" class="gap-2.5 self-stretch my-auto whitespace-nowrap <?php echo $item->active ? 'active-item' : ''; ?>">
                    <?php echo esc_html($item->label); ?>
                  </a>
                  <?php if ($item->children) : ?>
                    <ul class="absolute left-0 hidden space-y-2 border-t-2 border-green-700 bg-neutral-dark group-hover:block children min-w-[200px]">
                      <?php foreach ($item->children as $child) : ?>
                        <li class="<?php echo esc_attr($child->classes); ?> <?php echo $child->active ? 'current-item' : ''; ?>">
                          <a href="<?php echo esc_url($child->url); ?>" class="block px-4 py-2 text-sm text-black hover:text-black hover:bg-background-light border-b-1 border-background-light">
                            <?php echo esc_html($child->label); ?>
                          </a>
                        </li>
                      <?php endforeach; ?>
                    </ul>
                  <?php endif; ?>
                </li>
              <?php endforeach; ?>
            </ul>
          </nav>
        <?php endif; ?>
      </div>

      <!-- Hamburger Menu Button -->
      <?php if ($enable_hamburger): ?>
        <button
          :class="{ 'is-active z-50': isOpen }"
          class="hamburger <?php echo esc_attr($hamburger_style); ?> md:hidden"
          type="button"
          aria-label="Menu"
          aria-expanded="false"
          @click="isOpen = !isOpen">
          <span class="hamburger-box">
            <span class="hamburger-inner"></span>
          </span>
        </button>
      <?php endif; ?>

    </div>
  </div>

  <!-- Mobile Navigation Menu -->
  <div
    x-show="isOpen"
    class="absolute top-0 left-0 z-40 w-full h-screen bg-white md:hidden"
    @click.away="isOpen = false"
    x-transition>
    <nav class="flex flex-col items-center justify-center h-full">
      <?php
      if ($navigation->isNotEmpty()) : ?>
        <ul class="space-y-8 text-center">
          <?php foreach ($navigation->toArray() as $item) : ?>
            <li>
              <a href="<?php echo esc_url($item->url); ?>" class="text-2xl font-semibold">
                <?php echo esc_html($item->label); ?>
              </a>
            </li>
            <?php if ($item->children) : ?>
              <?php foreach ($item->children as $child) : ?>
                <li>
                  <a href="<?php echo esc_url($child->url); ?>" class="text-xl font-medium">
                    <?php echo esc_html($child->label); ?>
                  </a>
                </li>
              <?php endforeach; ?>
            <?php endif; ?>
          <?php endforeach; ?>
        </ul>
      <?php endif; ?>
    </nav>
  </div>

</section>