<?php
get_header();
?>

<main class="w-full site-main">

    <?php if (have_rows('flexible_content_blocks')) : ?>
        <?php while (have_rows('flexible_content_blocks')) : the_row(); ?>

            <?php if (get_row_layout() === 'hero') : ?>
                <section class="hero">
                    <div class="container mx-auto">
                        <h1 class="text-4xl font-bold"><?php the_sub_field('title'); ?></h1>
                        <p class="text-lg"><?php the_sub_field('content'); ?></p>
                    </div>
                </section>
            <?php elseif (get_row_layout() === 'content_block') : ?>
                <section class="content-block">
                    <div class="container mx-auto">
                        <h2 class="text-3xl font-bold"><?php the_sub_field('title'); ?></h2>
                        <p class="text-lg"><?php the_sub_field('content'); ?></p>
                    </div>
                </section>
            <?php elseif (get_row_layout() === 'image_block') : ?>
                <section class="image-block">
                    <div class="container mx-auto">
                        <img src="<?php the_sub_field('image'); ?>" alt="<?php the_sub_field('title'); ?>">
                    </div>
                </section>
            <?php endif; ?>
        <?php endwhile; ?>
    <?php endif; ?>

</main>

<?php
get_footer();
?>