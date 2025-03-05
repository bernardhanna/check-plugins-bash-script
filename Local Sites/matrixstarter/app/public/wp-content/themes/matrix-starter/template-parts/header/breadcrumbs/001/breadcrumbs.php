        <nav
          class="flex flex-col items-center self-stretch justify-center px-6 py-5 text-lg font-bold leading-loose text-black bg-white border-b border-solid border-b-neutral-200"
          aria-label="Breadcrumb">
          <div class="flex flex-col items-start max-w-full w-[1440px]">
            <ol class="flex flex-wrap items-start gap-4 max-md:max-w-full">
              <!-- Home link -->
              <li>
                <a href="<?php echo esc_url(home_url('/')); ?>" class="text-green-700">
                  Home
                </a>
              </li>
              <li aria-hidden="true">&gt;</li>

              <?php if (is_single()) : ?>
                <!-- Blog link -->
                <li>
                  <a href="<?php echo esc_url(get_permalink(get_option('page_for_posts'))); ?>" class="text-green-700">
                    Blog
                  </a>
                </li>
                <li aria-hidden="true">&gt;</li>
                <!-- Current post title -->
                <li aria-current="page"><?php the_title(); ?></li>

              <?php elseif (is_home()) : ?>
                <!-- If it's the Blog index page -->
                <li>
                  <a href="<?php echo esc_url(get_permalink(get_option('page_for_posts'))); ?>" class="text-green-700">
                    Blog
                  </a>
                </li>

              <?php elseif (is_page() && !is_front_page()) : ?>
                <!-- Loop through ancestors if the page has a parent -->
                <?php
                global $post;
                $ancestors = array_reverse(get_post_ancestors($post->ID));
                foreach ($ancestors as $ancestor) :
                  $ancestor_url   = get_permalink($ancestor);
                  $ancestor_title = get_the_title($ancestor);
                ?>
                  <li>
                    <a href="<?php echo esc_url($ancestor_url); ?>" class="text-green-700">
                      <?php echo esc_html($ancestor_title); ?>
                    </a>
                  </li>
                  <li aria-hidden="true">&gt;</li>
                <?php endforeach; ?>
                <!-- Current page title -->
                <li aria-current="page"><?php the_title(); ?></li>

              <?php elseif (is_category() || is_tag()) : ?>
                <!-- Category or tag archive -->
                <li>
                  <a href="<?php echo esc_url(get_permalink(get_option('page_for_posts'))); ?>" class="text-green-700">
                    Blog
                  </a>
                </li>
                <li aria-hidden="true">&gt;</li>
                <li aria-current="page"><?php single_term_title(); ?></li>

              <?php elseif (is_search()) : ?>
                <!-- Search results -->
                <li aria-current="page">
                  Search Results for "<?php echo get_search_query(); ?>"
                </li>

              <?php elseif (is_404()) : ?>
                <!-- 404 page -->
                <li aria-current="page">Page Not Found</li>

              <?php endif; ?>
            </ol>
          </div>
        </nav>