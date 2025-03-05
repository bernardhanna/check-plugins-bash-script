<?php
$column_layout = get_sub_field('services_001_column_layout') ?: '3'; // Default to 3 columns
$items = get_sub_field('services_001_items');

if ($items):
?>
<section class="relative">
    <div class="grid grid-cols-1 md:grid-cols-<?php echo esc_attr($column_layout); ?> gap-8 w-full mx-auto max-w-[1440px] px-4 lg:px-8 xxl:px-0">
        <?php foreach ($items as $item): ?>
            <div class="flex flex-col w-full text-black item">
                <?php if ($item['services_001_image']): 
                    $image = $item['services_001_image']; // Image array from ACF
                    ?>
                    <img src="<?php echo esc_url($image['url']); ?>"
                         alt="<?php echo esc_attr($image['alt']); ?>"
                         class="object-cover w-full aspect-[1.92]" />
                <?php endif; ?>
                <div class="flex items-start justify-between flex-1 w-full p-10"
                     style="background-color: <?php echo esc_attr($item['services_001_background_color']); ?>;">
                    <article class="flex flex-col flex-1 w-full shrink">
                        <?php if ($item['services_001_title']): ?>
                            <h2 class="text-2xl font-semibold leading-none"><?php echo esc_html($item['services_001_title']); ?></h2>
                        <?php endif; ?>
                        <div class="mt-3 bg-accent-orange border-accent-orange border-solid border-[3px] min-h-[3px] w-[66px]" aria-hidden="true"></div>
                        <?php if ($item['services_001_description']): ?>
                            <div class="mt-3 text-lg leading-7">
                                <?php echo $item['services_001_description']; // WYSIWYG output ?>
                            </div>
                        <?php endif; ?>
                    </article>
                </div>
            </div>
        <?php endforeach; ?>
    </div>
</section>
<?php endif; ?>
