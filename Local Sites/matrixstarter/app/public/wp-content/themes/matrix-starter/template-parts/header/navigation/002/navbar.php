<?php

/**
 * Flowbite Navbar Template with Log1x\Navi\Navi
 * Path: /template-parts/header/header-navigation/flowbite-navbar.php
 */

use Log1x\Navi\Navi;

// 1. ACF Fields for Logo
$logo_id  = get_field('logo', 'option');
$logo_url = $logo_id ? wp_get_attachment_image_url($logo_id, 'full') : '';
$logo_alt = $logo_id ? get_post_meta($logo_id, '_wp_attachment_image_alt', true) : get_bloginfo('name');

// 2. ACF Fields for Download button text/link (optional)
$download_button_text = get_field('download_button_text', 'option') ?: 'Download';
$download_button_url  = get_field('download_button_url', 'option')  ?: '#';

// 3. Build the 'primary' navigation with Navi
$navigation = Navi::make()->build('primary');

?>

<nav class="bg-white border-gray-200 py-2.5 dark:bg-gray-900">
  <div class="flex flex-wrap items-center justify-between max-w-screen-xl px-4 mx-auto">

    <!-- Logo or Site Name -->
    <a href="<?php echo esc_url(home_url('/')); ?>" class="flex items-center">
      <?php if ($logo_url) : ?>
        <img
          src="<?php echo esc_url($logo_url); ?>"
          alt="<?php echo esc_attr($logo_alt); ?>"
          class="h-6 mr-3 sm:h-9" />
      <?php else : ?>
        <span class="self-center text-xl font-semibold whitespace-nowrap dark:text-white">
          <?php echo esc_html(get_bloginfo('name')); ?>
        </span>
      <?php endif; ?>
    </a>

    <!-- Right-side area (Download Button, Mobile Toggle) -->
    <div class="flex items-center lg:order-2">
      <a href="<?php echo esc_url($download_button_url); ?>"
        class="text-white bg-purple-700 hover:bg-purple-800 focus:ring-4 focus:ring-purple-300
                font-medium rounded-lg text-sm px-4 lg:px-5 py-2 lg:py-2.5 sm:mr-2 lg:mr-0
                dark:bg-purple-600 dark:hover:bg-purple-700 focus:outline-none dark:focus:ring-purple-800">
        <?php echo esc_html($download_button_text); ?>
      </a>

      <!-- Flowbite Mobile Toggle Button -->
      <button data-collapse-toggle="mobile-menu-flowbite" type="button"
        class="inline-flex items-center p-2 ml-1 text-sm text-gray-500 rounded-lg lg:hidden hover:bg-gray-100 focus:outline-none focus:ring-2 focus:ring-gray-200 dark:text-gray-400 dark:hover:bg-gray-700 dark:focus:ring-gray-600"
        aria-controls="mobile-menu-flowbite" aria-expanded="false">
        <span class="sr-only">Open main menu</span>
        <!-- Hamburger Icon -->
        <svg class="w-6 h-6" fill="currentColor" viewBox="0 0 20 20">
          <path fill-rule="evenodd"
            d="M3 5a1 1 0 011-1h12a1 1 0 110 2H4a1 1
                   0 01-1-1zM3 10a1 1
                   0 011-1h12a1 1
                   0 110 2H4a1 1
                   0 01-1-1zM3 15a1 1
                   0 011-1h12a1 1
                   0 110 2H4a1 1
                   0 01-1-1z"
            clip-rule="evenodd">
          </path>
        </svg>
        <!-- Close Icon (hidden by default) -->
        <svg class="hidden w-6 h-6" fill="currentColor" viewBox="0 0 20 20">
          <path fill-rule="evenodd"
            d="M4.293 4.293a1 1 0 011.414 0L10 8.586l4.293-4.293a1 1
                   0 111.414 1.414L11.414 10l4.293 4.293a1 1
                   0 01-1.414 1.414L10 11.414l-4.293 4.293a1 1
                   0 01-1.414-1.414L8.586 10 4.293 5.707a1 1
                   0 010-1.414z"
            clip-rule="evenodd">
          </path>
        </svg>
      </button>
    </div>

    <!-- Nav Links (Desktop + Mobile) -->
    <div class="items-center justify-between w-full lg:flex lg:w-auto lg:order-1"
      id="mobile-menu-flowbite">
      <?php if ($navigation->isNotEmpty()) : ?>
        <ul class="flex flex-col mt-4 font-medium lg:flex-row lg:space-x-8 lg:mt-0">
          <?php foreach ($navigation->toArray() as $item) : ?>
            <li class="<?php echo esc_attr($item->classes); ?> <?php echo $item->active ? 'active' : ''; ?>">

              <!-- Parent Link -->
              <a href="<?php echo esc_url($item->url); ?>"
                class="block py-2 pl-3 pr-4 text-gray-700 border-b border-gray-100 hover:bg-gray-50 
                        lg:hover:bg-transparent lg:border-0 lg:hover:text-purple-700 lg:p-0 dark:text-gray-400 
                        lg:dark:hover:text-white dark:hover:bg-gray-700 dark:hover:text-white 
                        lg:dark:hover:bg-transparent dark:border-gray-700
                        <?php echo $item->active ? 'bg-purple-700 text-white lg:text-purple-700' : ''; ?>">
                <?php echo esc_html($item->label); ?>
              </a>

              <!-- Check for Child Items -->
              <?php if (! empty($item->children)) : ?>
                <ul class="ml-4 border-l border-gray-200 dark:border-gray-700 lg:hidden">
                  <?php foreach ($item->children as $child) : ?>
                    <li class="<?php echo esc_attr($child->classes); ?> <?php echo $child->active ? 'active' : ''; ?>">
                      <a href="<?php echo esc_url($child->url); ?>"
                        class="block py-2 pl-3 pr-4 text-gray-700 hover:bg-gray-50 
                                lg:hover:bg-transparent lg:border-0 lg:hover:text-purple-700 lg:p-0 dark:text-gray-400 
                                lg:dark:hover:text-white dark:hover:bg-gray-700 dark:hover:text-white 
                                lg:dark:hover:bg-transparent dark:border-gray-700
                                <?php echo $child->active ? 'bg-purple-700 text-white' : ''; ?>">
                        <?php echo esc_html($child->label); ?>
                      </a>
                    </li>
                  <?php endforeach; ?>
                </ul>
              <?php endif; ?>
            </li>
          <?php endforeach; ?>
        </ul>
      <?php else : ?>
        <!-- If no menu items exist -->
        <p class="mt-4 font-medium text-gray-500">No menu items found.</p>
      <?php endif; ?>
    </div>
  </div>
</nav>

<!-- Make sure Flowbite's JS is enqueued so the toggle works -->