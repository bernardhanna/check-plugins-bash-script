<?php
// Fetch main section fields
$heading_tag = get_sub_field('heading_tag') ?: 'h2';
$heading_text = get_sub_field('heading_text');
$main_paragraph = get_sub_field('main_paragraph');

// Fetch details section
$details_section = get_sub_field('details_section');

// Fetch main image
$main_image_id = get_sub_field('main_image');
$main_image_url = $main_image_id ? wp_get_attachment_image_url($main_image_id, 'full') : '';

// Fetch tab titles and content
$tab_1_title = get_sub_field('tab_1_title');
$tab_1_content = get_sub_field('tab_1_content');
$tab_1_image_id = get_sub_field('tab_1_image');
$tab_1_image_url = $tab_1_image_id ? wp_get_attachment_image_url($tab_1_image_id, 'full') : '';

$tab_2_title = get_sub_field('tab_2_title');
$tab_2_content = get_sub_field('tab_2_content');
$tab_2_image_id = get_sub_field('tab_2_image');
$tab_2_image_url = $tab_2_image_id ? wp_get_attachment_image_url($tab_2_image_id, 'full') : '';

$tab_3_title = get_sub_field('tab_3_title');
$tab_3_content = get_sub_field('tab_3_content');
$tab_3_image_id = get_sub_field('tab_3_image');
$tab_3_image_url = $tab_3_image_id ? wp_get_attachment_image_url($tab_3_image_id, 'full') : '';

// Fetch grant information
$grant_information = get_sub_field('grant_information');
?>

<section class="flex flex-col items-center pb-20 bg-yellow-50">
  <div class="flex flex-col p-16 max-w-full bg-white w-[1440px] max-md:px-5">
    <!-- Main Section -->
    <div class="flex flex-col w-full gap-10 lg:flex-row">
      <article class="flex flex-col flex-1 shrink justify-center basis-0 min-w-[240px] max-md:max-w-full">
        <header>
          <<?php echo esc_html($heading_tag); ?> class="text-3xl font-semibold leading-none text-black max-md:max-w-full">
            <?php echo esc_html($heading_text); ?>
          </<?php echo esc_html($heading_tag); ?>>
        </header>
        <p class="mt-6 text-lg leading-7 text-black max-md:max-w-full">
          <?php echo wp_kses_post($main_paragraph); ?>
        </p>
        
        <?php if ($details_section): ?>
          <div class="flex flex-col w-full mt-6 max-md:max-w-full">
            <?php foreach ($details_section as $detail): ?>
              <details class="mt-2 bg-neutral-100">
                <summary class="p-4 text-xl font-semibold leading-snug text-black"><?php echo esc_html($detail['details_summary']); ?></summary>
                <div class="p-4 bg-neutral-100">
                  <p><?php echo wp_kses_post($detail['details_content']); ?></p>
                </div>
              </details>
            <?php endforeach; ?>
          </div>
        <?php endif; ?>
      </article>

      <!-- Main Image -->
      <?php if ($main_image_url): ?>
        <img src="<?php echo esc_url($main_image_url); ?>" class="object-contain flex-1 shrink self-start w-full aspect-[1.3] basis-0 min-w-[240px] max-md:max-w-full" alt="Wall insulation illustration" />
      <?php endif; ?>
    </div>

    <!-- Tab Section with Alpine.js -->
    <div class="flex items-start w-full gap-1 mt-16 max-md:mt-10 max-md:max-w-full" x-data="{ activeTab: 0 }">
      <div class="flex flex-col flex-1 shrink w-full basis-0 min-w-[240px] max-md:max-w-full">
        <nav class="flex flex-col w-full max-md:max-w-full">
          <ul class="flex flex-col items-start w-full text-lg font-semibold leading-none text-black xxl:text-2xl md:flex-row max-md:max-w-full">
            <li @click="activeTab = 0" :class="activeTab === 0 ? 'bg-green-700 text-white' : 'bg-stone-200 text-black'" class="w-full pt-5 pb-5 pl-4 cursor-pointer lg:w-1/3 ">
              <?php echo esc_html($tab_1_title); ?>
            </li>
            <li @click="activeTab = 1" :class="activeTab === 1 ? 'bg-green-700 text-white' : 'bg-stone-200 text-black'" class="w-full pt-5 pb-5 pl-4 cursor-pointer lg:w-1/3 ">
              <?php echo esc_html($tab_2_title); ?>
            </li>
            <li @click="activeTab = 2" :class="activeTab === 2 ? 'bg-green-700 text-white' : 'bg-stone-200 text-black'" class="w-full pt-5 pb-5 pl-4 cursor-pointer lg:w-1/3 ">
              <?php echo esc_html($tab_3_title); ?>
            </li>
          </ul>
        </nav>

        <!-- Tab 1 Content -->
        <template x-if="activeTab === 0">
          <article class="flex flex-col p-10 w-full border-solid bg-neutral-100 border-t-[3px] border-t-green-700 max-md:px-5 max-md:max-w-full">
            <div class="flex flex-col lg:flex-row gap-10 justify-center items-center w-full text-lg leading-6 text-black min-h-[480px] max-md:max-w-full">
              <p class="self-stretch flex-1 my-auto shrink basis-0 max-md:max-w-full">
                <?php echo wp_kses_post($tab_1_content); ?>
              </p>
              <?php if ($tab_1_image_url): ?>
                <img src="<?php echo esc_url($tab_1_image_url); ?>" class="object-contain self-stretch my-auto aspect-square min-w-[240px] w-full lg:w-[400px]" alt="Internal wall insulation illustration" />
              <?php endif; ?>
            </div>
            <section class="flex flex-col mt-2.5 w-full max-md:max-w-full">
                <h3 class="text-2xl font-semibold leading-none text-black max-md:max-w-full"><?php echo esc_html(get_sub_field('grant_type_heading')); ?></h3>
                <div class="flex flex-row items-start w-full gap-1 mt-6 text-lg leading-loose text-black max-md:max-w-full overflow-visible overflow-y-scroll">
                    <div class="flex flex-col flex-1 shrink basis-0 min-w-[240px] max-md:max-w-full">
                        <h4 class="gap-2.5 self-stretch p-4 w-full text-white bg-green-700 max-md:max-w-full font-bold"><?php echo esc_html(get_sub_field('grant_type_heading')); ?></h4>
                        <ul>
                            <?php
                            $grant_type_content = explode(',', get_sub_field('grant_type_content'));
                            foreach ($grant_type_content as $index => $type): ?>
                                <li class="gap-2.5 self-stretch p-4 mt-1 w-full <?php echo $index % 2 === 0 ? 'bg-white' : 'bg-neutral-200'; ?> max-md:max-w-full"><?php echo esc_html(trim($type)); ?></li>
                            <?php endforeach; ?>
                        </ul>
                    </div>
                    <div class="flex flex-col w-[143px]">
                        <h4 class="gap-2.5 self-stretch p-4 w-full text-white bg-green-700 font-bold"><?php echo esc_html(get_sub_field('grant_value_heading')); ?></h4>
                        <ul>
                            <?php
                            $grant_value_content = explode(',', get_sub_field('grant_value_content'));
                            foreach ($grant_value_content as $index => $value): ?>
                                <li class="gap-2.5 self-stretch p-4 mt-1 w-full whitespace-nowrap <?php echo $index % 2 === 0 ? 'bg-white' : 'bg-neutral-200'; ?>"><?php echo esc_html(trim($value)); ?></li>
                            <?php endforeach; ?>
                        </ul>
                    </div>
                </div>
            </section>
          </article>
        </template>

        <!-- Tab 2 Content -->
        <template x-if="activeTab === 1">
          <article class="flex flex-col p-10 w-full border-solid bg-neutral-100 border-t-[3px] border-t-green-700 max-md:px-5 max-md:max-w-full">
            <div class="flex flex-col lg:flex-row  gap-10 justify-center items-center w-full text-lg leading-6 text-black min-h-[480px] max-md:max-w-full">
              <p class="self-stretch flex-1 my-auto shrink basis-0 max-md:max-w-full">
                <?php echo wp_kses_post($tab_2_content); ?>
              </p>
              <?php if ($tab_2_image_url): ?>
                <img src="<?php echo esc_url($tab_2_image_url); ?>" class="object-contain self-stretch my-auto aspect-square min-w-[240px] w-full lg:w-[400px]" alt="Cavity wall insulation illustration" />
              <?php endif; ?>
            </div>
            <section class="flex flex-col mt-2.5 w-full max-md:max-w-full">
                <h3 class="text-2xl font-semibold leading-none text-black max-md:max-w-full"><?php echo esc_html(get_sub_field('grant_type_heading')); ?></h3>
                <div class="flex flex-row items-start w-full gap-1 mt-6 text-lg leading-loose text-black max-md:max-w-full overflow-visible overflow-y-scroll">
                    <div class="flex flex-col flex-1 shrink basis-0 min-w-[240px] max-md:max-w-full">
                        <h4 class="gap-2.5 self-stretch p-4 w-full text-white bg-green-700 max-md:max-w-full font-bold"><?php echo esc_html(get_sub_field('grant_type_heading')); ?></h4>
                        <ul>
                            <?php
                            $grant_type_content = explode(',', get_sub_field('grant_type_content'));
                            foreach ($grant_type_content as $index => $type): ?>
                                <li class="gap-2.5 self-stretch p-4 mt-1 w-full <?php echo $index % 2 === 0 ? 'bg-white' : 'bg-neutral-200'; ?> max-md:max-w-full"><?php echo esc_html(trim($type)); ?></li>
                            <?php endforeach; ?>
                        </ul>
                    </div>
                    <div class="flex flex-col w-[143px]">
                        <h4 class="gap-2.5 self-stretch p-4 w-full text-white bg-green-700 font-bold"><?php echo esc_html(get_sub_field('grant_value_heading')); ?></h4>
                        <ul>
                            <?php
                            $grant_value_content = explode(',', get_sub_field('grant_value_content'));
                            foreach ($grant_value_content as $index => $value): ?>
                                <li class="gap-2.5 self-stretch p-4 mt-1 w-full whitespace-nowrap <?php echo $index % 2 === 0 ? 'bg-white' : 'bg-neutral-200'; ?>"><?php echo esc_html(trim($value)); ?></li>
                            <?php endforeach; ?>
                        </ul>
                    </div>
                </div>
            </section>
          </article>
        </template>

        <!-- Tab 3 Content -->
        <template x-if="activeTab === 2">
          <article class="flex flex-col p-10 w-full border-solid bg-neutral-100 border-t-[3px] border-t-green-700 max-md:px-5 max-md:max-w-full">
            <div class="flex flex-col lg:flex-row  gap-10 justify-center items-center w-full text-lg leading-6 text-black min-h-[480px] max-md:max-w-full">
              <p class="self-stretch flex-1 my-auto shrink basis-0 max-md:max-w-full">
                <?php echo wp_kses_post($tab_3_content); ?>
              </p>
              <?php if ($tab_3_image_url): ?>
                <img src="<?php echo esc_url($tab_3_image_url); ?>" class="object-contain self-stretch my-auto aspect-quare min-w-[240px] w-full lg:w-[400px]" alt="External wall insulation illustration" />
              <?php endif; ?>
            </div>
            <section class="flex flex-col mt-2.5 w-full max-md:max-w-full">
                <h3 class="text-2xl font-semibold leading-none text-black max-md:max-w-full"><?php echo esc_html(get_sub_field('grant_type_heading')); ?></h3>
                <div class="flex flex-row items-start w-full gap-1 mt-6 text-lg leading-loose text-black max-md:max-w-full overflow-visible overflow-y-scroll">
                    <div class="flex flex-col flex-1 shrink basis-0 min-w-[240px] max-md:max-w-full">
                        <h4 class="gap-2.5 self-stretch p-4 w-full text-white bg-green-700 max-md:max-w-full font-bold"><?php echo esc_html(get_sub_field('grant_type_heading')); ?></h4>
                        <ul>
                            <?php
                            $grant_type_content = explode(',', get_sub_field('grant_type_content'));
                            foreach ($grant_type_content as $index => $type): ?>
                                <li class="gap-2.5 self-stretch p-4 mt-1 w-full <?php echo $index % 2 === 0 ? 'bg-white' : 'bg-neutral-200'; ?> max-md:max-w-full"><?php echo esc_html(trim($type)); ?></li>
                            <?php endforeach; ?>
                        </ul>
                    </div>
                    <div class="flex flex-col w-[143px]">
                        <h4 class="gap-2.5 self-stretch p-4 w-full text-white bg-green-700 font-bold"><?php echo esc_html(get_sub_field('grant_value_heading')); ?></h4>
                        <ul>
                            <?php
                            $grant_value_content = explode(',', get_sub_field('grant_value_content'));
                            foreach ($grant_value_content as $index => $value): ?>
                                <li class="gap-2.5 self-stretch p-4 mt-1 w-full whitespace-nowrap <?php echo $index % 2 === 0 ? 'bg-white' : 'bg-neutral-200'; ?>"><?php echo esc_html(trim($value)); ?></li>
                            <?php endforeach; ?>
                        </ul>
                    </div>
                </div>
            </section>
          </article>
        </template>
      </div>
    </div>
  </div>
</section>
