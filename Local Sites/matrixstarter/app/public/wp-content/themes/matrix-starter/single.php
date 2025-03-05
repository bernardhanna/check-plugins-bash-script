<?php
get_header();
?>

<main class="w-full site-main">
    <?php get_template_part('template-parts/header/subpage-header'); ?>
    <?php get_template_part('template-parts/header/breadcrumbs'); ?>
     <div class="max-w-[1440px] px-4 mx-auto">
        <?php
        if (have_posts()) :
            while (have_posts()) : the_post();
                get_template_part('template-parts/content/content', 'page');
            endwhile;
        else :
            echo '<p>No content found</p>';
        endif;
        ?>
    </div>
</main>

<?php
get_footer();
?>