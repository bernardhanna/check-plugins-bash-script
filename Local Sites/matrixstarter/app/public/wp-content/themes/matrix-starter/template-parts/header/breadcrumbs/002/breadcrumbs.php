        <nav
          class="flex flex-col items-center self-stretch justify-center px-6 py-5 text-lg font-bold leading-loose text-white bg-gray-700 border-b border-solid border-b-neutral-200"
          aria-label="Breadcrumb">
          <div class="flex flex-col items-start max-w-full w-[1440px]">
            <ol class="flex flex-wrap items-start gap-4 max-md:max-w-full">
              <!-- Home link -->
              <li>
                <a href="<?php echo esc_url(home_url('/')); ?>" class="text-green-300">
                  Home
                </a>
              </li>
              <li aria-hidden="true">&gt;</li>

              <!-- The same logic as style_1 can be reused here for pages, categories, etc. -->
              <?php if (is_single()) : ?>
                <li>
                  <a href="<?php echo esc_url(get_permalink(get_option('page_for_posts'))); ?>" class="text-green-300">
                    Blog
                  </a>
                </li>
                <li aria-hidden="true">&gt;</li>
                <li aria-current="page"><?php the_title(); ?></li>

              <?php elseif (is_home()) : ?>
                <li>
                  <a href="<?php echo esc_url(get_permalink(get_option('page_for_posts'))); ?>" class="text-green-300">
                    Blog
                  </a>
                </li>

              <?php elseif (is_page() && !is_front_page()) : ?>
                <?php
                global $post;
                $ancestors = array_reverse(get_post_ancestors($post->ID));
                foreach ($ancestors as $ancestor) :
                  $ancestor_url   = get_permalink($ancestor);
                  $ancestor_title = get_the_title($ancestor);
                ?>
                  <li>
                    <a href="<?php echo esc_url($ancestor_url); ?>" class="text-green-300">
                      <?php echo esc_html($ancestor_title); ?>
                    </a>
                  </li>
                  <li aria-hidden="true">&gt;</li>
                <?php endforeach; ?>
                <li aria-current="page"><?php the_title(); ?></li>

              <?php elseif (is_category() || is_tag()) : ?>
                <li>
                  <a href="<?php echo esc_url(get_permalink(get_option('page_for_posts'))); ?>" class="text-green-300">
                    Blog
                  </a>
                </li>
                <li aria-hidden="true">&gt;</li>
                <li aria-current="page"><?php single_term_title(); ?></li>

              <?php elseif (is_search()) : ?>
                <li aria-current="page">
                  Search Results for "<?php echo get_search_query(); ?>"
                </li>

              <?php elseif (is_404()) : ?>
                <li aria-current="page">Page Not Found</li>

              <?php endif; ?>
            </ol>
          </div>
        </nav>