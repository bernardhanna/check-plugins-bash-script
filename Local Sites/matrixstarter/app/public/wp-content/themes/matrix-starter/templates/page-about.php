<?php
/**
 * Template Name: About Page
 *
 * @package Matrix Starter
 */

get_header();
?>

<main class="site-main">
    <div class="container mx-auto px-4 py-6">
        <h1 class="text-4xl font-bold">About Us</h1>
        <section class="about-content">
            <?php
            if (have_posts()) :
                while (have_posts()) : the_post();
                    the_content();
                endwhile;
            endif;
            ?>
        </section>
    </div>
</main>

<?php
get_footer();
