<?php
$heading = get_sub_field('heading');
$description = get_sub_field('description');
$grant_1_name = get_sub_field('grant_1_name');
$grant_1_details = get_sub_field('grant_1_details');
$grant_2_name = get_sub_field('grant_2_name');
$grant_2_details = get_sub_field('grant_2_details');
$grant_2_description = get_sub_field('grant_2_description');
$grant_3_name = get_sub_field('grant_3_name');
$grant_3_details = get_sub_field('grant_3_details');
$grant_3_description = get_sub_field('grant_3_description');
?>

<section class="flex flex-col items-center justify-center py-20 bg-white">
  <div class="flex flex-col max-w-full w-[1440px] px-4 lg:px-8 xxl:px-0">
    <div class="flex flex-col self-start">
       <?php if ($heading): ?>
        <span class="text-3xl font-semibold leading-none text-black"><?php echo esc_html($heading); ?></span>
        <div class="mt-4 bg-orange-500 border-orange-500 border-solid border-[3px] min-h-[3px] w-[66px]"></div>
     <?php endif; ?>
      </div>
    <div class="flex flex-wrap w-full gap-10 mt-16 text-lg max-md:mt-10 max-md:max-w-full">
     <?php if ($description): ?>
      <p class="flex-1 leading-7 text-black shrink w-full lg:w-[30%]">
        <?php echo esc_html($description); ?>
      </p>
  <?php endif; ?>
   <div class="grant_table grid grid-cols-1 lg:grid-cols-3 gap-1 w-full lg:w-[65%] mx-auto text-lg leading-loose">
      
      <!-- Grant 1 -->
      <div class="flex flex-col justify-between bg-white border border-gray-200">
        <span class="p-4 font-bold text-white bg-green-700"><?php echo esc_html($grant_1_name); ?></span>
        <p class="p-4 mt-1 bg-[#EFF5EC]"><?php echo esc_html($grant_1_details); ?></p>
        <div class="flex-grow p-4 mt-1 bg-[#EFF5EC]" aria-hidden="true"></div>
      </div>

      <!-- Grant 2 -->
      <div class="flex flex-col justify-between bg-white border border-gray-200">
        <span class="p-4 font-bold text-white bg-green-700"><?php echo esc_html($grant_2_name); ?></span>
        <p class="p-4 mt-1 bg-[#EFF5EC]"><?php echo esc_html($grant_2_details); ?></p>
        <p class="flex-grow p-4 mt-1 leading-7 bg-[#EFF5EC]"><?php echo wp_kses_post($grant_2_description); ?></p>
      </div>

      <!-- Grant 3 -->
      <div class="flex flex-col justify-between bg-white border border-gray-200">
        <span class="p-4 font-bold text-white bg-green-700"><?php echo esc_html($grant_3_name); ?></span>
        <p class="p-4 mt-1 bg-[#EFF5EC]"><?php echo esc_html($grant_3_details); ?></p>
        <p class="flex-grow p-4 mt-1 leading-7 bg-[#EFF5EC]"><?php echo wp_kses_post($grant_3_description); ?></p>
      </div>
      
    </div>
    </div>
  </div>
</section>

<script>
  function equalizeHeights() {
    const columns = document.querySelectorAll('.grant_table .flex');
    let maxHeight = 0;

    // Reset heights to auto to recalculate
    columns.forEach(column => column.style.height = 'auto');

    // Find the maximum height
    columns.forEach(column => {
      const columnHeight = column.offsetHeight;
      if (columnHeight > maxHeight) {
        maxHeight = columnHeight;
      }
    });

    // Set all columns to the maximum height
    columns.forEach(column => column.style.height = maxHeight + 'px');
  }

  // Equalize heights on page load and resize
  window.addEventListener('load', equalizeHeights);
  window.addEventListener('resize', equalizeHeights);
</script>
