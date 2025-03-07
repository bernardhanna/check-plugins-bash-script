<?php
/**
 * The Template for displaying all single products
 *
 * This template can be overridden by copying it to yourtheme/woocommerce/single-product.php.
 *
 * HOWEVER, on occasion WooCommerce will need to update template files and you
 * (the theme developer) will need to copy the new files to your theme to
 * maintain compatibility. We try to do this as little as possible, but it does
 * happen. When this occurs the version of the template file will be bumped and
 * the readme will list any important changes.
 *
 * @see     https://docs.woocommerce.com/document/template-structure/
 * @package WooCommerce/Templates
 * @version 1.6.4
 */

if (! defined('ABSPATH') ) {
	exit; // Exit if accessed directly
}

get_header('shop'); ?>

	<?php
	/**
	 * Woocommerce_before_main_content hook.
	 * 
	 * @since 1.0.0
	 * @hooked woocommerce_output_content_wrapper - 10 (outputs opening divs for the content)
	 * @hooked woocommerce_breadcrumb - 20
	 */
	do_action('woocommerce_before_main_content');
	?>

		<?php

		while ( have_posts() ) {
		
			the_post();

			do_action('woocommerce_before_single_product');

			if (post_password_required() ) {
				echo esc_attr(get_the_password_form()); // WPCS: XSS ok.
				return;
			}
			?>
				
				<div id="product-<?php the_ID(); ?>" <?php wc_product_class(); ?>>

			<?php
			/**
			 * Hook: woocommerce_before_single_product_summary.
			 *
			 * @since 1.0.0
			 * @hooked woocommerce_show_product_sale_flash - 10
			 * @hooked woocommerce_show_product_images - 20
			 */
			do_action('mixmatch_after_single_product_summary');
			// do_action( 'woocommerce_before_single_product_summary' );

			?>

					<div class="summary entry-summary">
			<?php
			 /**
			  * Hook: woocommerce_single_product_summary.
			  *
			  * @hooked woocommerce_template_single_title - 5
			  * @hooked woocommerce_template_single_rating - 10
			  * @hooked woocommerce_template_single_price - 10
			  * @hooked woocommerce_template_single_excerpt - 20
			  * @hooked woocommerce_template_single_add_to_cart - 30
			  * @hooked woocommerce_template_single_meta - 40
			  * @hooked woocommerce_template_single_sharing - 50
			  * @hooked WC_Structured_Data::generate_product_data() - 60
			  */
			 // do_action( 'woocommerce_single_product_summary' );

			?>
					</div>

			<?php
			/**
			 * Hook: woocommerce_after_single_product_summary.
			 * 
			 * @since 1.0.0
			 * @hooked woocommerce_output_product_data_tabs - 10
			 * @hooked woocommerce_upsell_display - 15
			 * @hooked woocommerce_output_related_products - 20
			 */
			do_action('woocommerce_after_single_product_summary');
			?>
				</div>

			<?php do_action('woocommerce_after_single_product'); ?>

		<?php } // end of the loop. ?>

	<?php
	/**
	 * Woocommerce_after_main_content hook.
	 *
	 * @since 1.0.0
	 * @hooked woocommerce_output_content_wrapper_end - 10 (outputs closing divs for the content)
	 */
	do_action('woocommerce_after_main_content');
	?>

	<?php
	/**
	 * Woocommerce_sidebar hook.
	 *
	 * @since 1.0.0
	 * @hooked woocommerce_get_sidebar - 10
	 */
	do_action('woocommerce_sidebar');
	?>

<?php 

get_footer('shop');


/* Omit closing PHP tag at the end of PHP files to avoid "headers already sent" issues. */
