<?php


$heading_tag = get_sub_field('heading_tag') ?: 'h2';
$heading_text = get_sub_field('heading_text') ?: 'Table Heading';
$tables = get_sub_field('tables');
?>
<section class="flex flex-col items-center justify-center px-4 py-8 text-black xl:py-10 lg:px-8 xxl:px-0">
    <div class="max-w-[1440px] w-full m-auto">
        <div class="flex flex-col text-2xl font-semibold leading-none max-sm:justify-center max-sm:items-center max-sm:text-center">
            <<?php echo esc_html($heading_tag); ?> class="max-md:max-w-full"><?php echo esc_html($heading_text); ?></<?php echo esc_html($heading_tag); ?>>
            <div class="mt-4 bg-orange-500 border-orange-500 border-solid border-[3px] min-h-[3px] w-[66px]"></div>
        </div>
        <div class="flex flex-wrap max-w-full mt-8 max-md:mt-10 gap-y-10">
            <?php if ($tables): ?>
                <?php foreach ($tables as $table): ?>
                    <article class="w-full">
                        <?php if ($table['table_rows']): ?>
                            <?php foreach ($table['table_rows'] as $index => $row): ?>
										 <?php 
									  $column_count = 0;
										if (!empty($row['grant_name'])) {
											$column_count++;
										}
										if (!empty($row['type_of_home'])) {
											$column_count++;
										}
										if (!empty($row['grant_value'])) {
											$column_count++;
										}
									?>
                                <div class="flex items-stretch w-full gap-1 mb-1">
									 <?php if (!empty($row['grant_name'])): ?>
									  <div class="flex flex-col <?php echo $column_count == 3 ? 'w-[25%]' : 'w-1/2'; ?> md:w-[32%]">
                                        <div class="gap-1 md:gap-2.5 self-stretch p-2 md:p-4 w-full grow" style="background-color: <?php echo $index == 0 ? '#0D783D' : ($index % 2 == 0 ? '#F5F5F5' : '#E7E7E7'); ?>;">
                                            <p style="color:<?php echo $index == 0 ? '#FFFFFF' : ($index % 2 == 0 ? '#000000' : '#000000'); ?>; font-weight: <?php echo $index == 0 ? '700' : ($index % 2 == 0 ? '400' : '400'); ?>;">
												<?php echo esc_html($row['grant_name']); ?>
										
											</p>
                                        </div>
                                    </div>
									<?php endif; ?>
                                    <div class="flex flex-col  <?php echo $column_count == 3 ? 'w-[40%]' : 'w-1/2'; ?> md:w-[<?php echo !empty($row['grant_name']) ? '32%' : '64%'; ?>]">
                                        <div class="gap-1 md:gap-2.5 self-stretch p-2 md:p-4 w-full grow" style="background-color: <?php echo $index == 0 ? '#0D783D' : ($index % 2 == 0 ? '#F5F5F5' : '#E7E7E7'); ?>;">
                                            <p style="color:<?php echo $index == 0 ? '#FFFFFF' : ($index % 2 == 0 ? '#000000' : '#000000'); ?>; font-weight: <?php echo $index == 0 ? '700' : ($index % 2 == 0 ? '400' : '400'); ?>;">
												<?php echo esc_html($row['type_of_home']); ?>
												
											</p>
                                        </div>
                                    </div>
                                    <div class="flex flex-col <?php echo $column_count == 3 ? 'w-[35%]' : 'w-1/2'; ?> md:w-[35%]">
                                        <div class="gap-1 md:gap-2.5 self-stretch p-2 md:p-4 w-full grow" style="background-color: <?php echo $index == 0 ? '#0D783D' : ($index % 2 == 0 ? '#F5F5F5' : '#E7E7E7'); ?>;">       
   											<p style="color:<?php echo $index == 0 ? '#FFFFFF' : ($index % 2 == 0 ? '#000000' : '#000000'); ?>; font-weight: <?php echo $index == 0 ? '700' : ($index % 2 == 0 ? '400' : '400'); ?>;">
												<?php echo esc_html($row['grant_value']); ?>
											</p>
                                        </div>
                                    </div>
                                </div>
                            <?php endforeach; ?>
                        <?php endif; ?>
                    </article>
                <?php endforeach; ?>
            <?php endif; ?>
        </div>
    </div>
</section>
