<?php
/**
 * Template Name: Contact Page
 *
 * @package Matrix Starter
 */

get_header();
?>

<main class="site-main">
    <div class="container mx-auto px-4 py-6">
        <h1 class="text-4xl font-bold">Contact Us</h1>
        <?php
        if (have_posts()) :
            while (have_posts()) : the_post();
                get_template_part('template-parts/content/content', 'contact');
            endwhile;
        endif;
        ?>
    </div>
</main>

<?php
get_footer();
?>
