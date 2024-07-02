<?php
/**
	Plugin Name:  Custom Mix & Match Product Boxes
	Plugin URI: https://woocommerce.com/products/custom-mix-match-product-boxes/
	Description: Custom Mix & Match Product Boxes Plugin
	Author: Extendons
	Version: 1.3.1
	Text Domain: extendons-woocommerce-product-boxes
	Developed By: Extendons
	Author URI: https://woocommerce.com/vendor/extendons/
	Woo: 4868116:3dc108f92ca1b9067461c360c795c939
 */


//If not user for security purpose
if ( ! defined( 'ABSPATH' ) ) { 
	exit;
}
if (! function_exists('is_plugin_active') ) {
	include_once ABSPATH . 'wp-admin/includes/plugin.php';
}


if (!class_exists('EXTENDONS_MIXMATCH_PRODUCT_BUNDLES') ) {

	class EXTENDONS_MIXMATCH_PRODUCT_BUNDLES {
	

		public function __construct() {

			/**
			* Check if WooCommerce is active
			* if wooCommerce is not active Min & Max module will not work.
			**/
			if (!is_plugin_active('woocommerce/woocommerce.php') ) {
				add_action('admin_notices', array( $this, 'extendons_admin_notice' ) );
				return;
			}

			$this->module_constant();

			add_action('wp_loaded', array( $this, 'wooextmm_bundles_main_scripts_loading' ));

			add_action('plugins_loaded', array( $this, 'wooextmm_bundles_load_textdomain' ), 100);

			include_once MIXMATCH_BUNDLES_DIR . 'mix-match-admin-operation.php';
			include_once MIXMATCH_BUNDLES_DIR . 'mix-match-front-operation.php';
			register_activation_hook(__FILE__, array( $this, 'wooextmm_install_default_settings_for_multisite' ));
		
			// require file of woocommerce subscription
			include_once MIXMATCH_BUNDLES_DIR . 'mix-match-subscription-box-competibility.php';

			add_action('wp_ajax_get_product_mix_match', array( $this, 'wooextmm_getting_product_mix_match_callback' ));

			add_filter('woocommerce_is_purchasable', array( $this, 'wooextmm_is_product_purchasable_measurement' ), 10, 2);

			add_action('wp_ajax_mm_add_new_products', array( $this, 'wooextmm_add_prefilled_item_callback' ));
		}

		public function extendons_admin_notice() {
			
			// Deactivate the plugin
			deactivate_plugins(__FILE__);

			$allowed_tags = array(
			'a' => array(
			'class' => array(),
			'href' => array(),
			'rel' => array(),
			'title' => array(),
			),
			'abbr' => array(
			'title' => array(),
			),
			'b' => array(),
			'blockquote' => array(
			'cite' => array(),
			),
			'cite' => array(
			'title' => array(),
			),
			'code' => array(),
			'del' => array(
			'datetime' => array(),
			'title' => array(),
			),
			'dd' => array(),
			'div' => array(
			'class' => array(),
			'title' => array(),
			'style' => array(),
			),
			'dl' => array(),
			'dt' => array(),
			'em' => array(),
			'h1' => array(),
			'h2' => array(),
			'h3' => array(),
			'h4' => array(),
			'h5' => array(),
			'h6' => array(),
			'i' => array(),
			'img' => array(
			'alt' => array(),
			'class' => array(),
			'height' => array(),
			'src' => array(),
			'width' => array(),
			),
			'li' => array(
			'class' => array(),
			),
			'ol' => array(
			'class' => array(),
			),
			'p' => array(
			'class' => array(),
			),
			'q' => array(
			'cite' => array(),
			'title' => array(),
			),
			'span' => array(
			'class' => array(),
			'title' => array(),
			'style' => array(),
			),
			'strike' => array(),
			'strong' => array(),
			'ul' => array(
			'class' => array(),
			),
			);

			$wpf_message = '<div id="message" class="error">
					<p><strong>Custom Mix & Match Product Boxes is inactive.</strong> The <a href="http://wordpress.org/extend/plugins/woocommerce/">WooCommerce plugin</a> must be active for this plugin to work. Please install &amp; activate WooCommerce »</p></div>';

			echo wp_kses(__($wpf_message, 'extendons_menu_cart_plugin'), $allowed_tags);
		}

		public function wooextmm_add_prefilled_item_callback() {

			if (!isset($_POST['mm_nonce']) || ! wp_verify_nonce(sanitize_text_field($_POST['mm_nonce']), 'mm_nonce') ) {

				die(esc_html__('Permissions check failed', 'extendons-woocommerce-product-boxes'));

			} else {


				if (isset($_POST['item_count']) || isset($_POST['mm_prod_ids'])) {
					$product = wc_get_product(intval($_POST['mm_prod_ids']));
					$item_inc = intval($_POST['item_count']);
				}
				echo '<tr id="mm_prefilled_items_mm' . esc_attr($item_inc) . '">
            <input type="hidden" value="' . intval($product->get_id()) . '" name="_mm_prefilled_product[' . esc_attr($item_inc) . '][product_id]" />
            <td>
            <input type="checkbox" name="_mm_prefilled_product[' . esc_attr($item_inc) . '][pre_mandetory]">
            </td>
            <td>
            <input readonly type="text" name="_mm_prefilled_product[' . esc_attr($item_inc) . '][pre_name]" value="#' . intval($product->get_id()) . ' - ' . esc_attr($product->get_name()) . '">
            </td>
            <td>
            <input min="1" type="number" name="_mm_prefilled_product[' . esc_attr($item_inc) . '][pre_qty]">
            </td>
            <td>
            <input class="button mm_prefilled_delete" onclick="mm_save_bundle_remove(event, ' . esc_attr($item_inc) . ', this);" type="button" value="Delete" />
            </td>
            </tr>';

			} die();
		}
		public function wooextmm_install_default_settings_for_multisite( $network_wide ) {

			if (is_multisite() && $network_wide ) { 

				foreach (get_sites(array( 'fields'=>'ids' )) as $blog_id) {

					switch_to_blog($blog_id);
					$this->extendons_vs_set_default_settings();

					restore_current_blog();
				} 

			} else {

				$this->extendons_vs_set_default_settings();
			}
		}
		public function extendons_vs_set_default_settings() {

			$general_settings =  get_option('extendons_custombox_general_settings');
			if (empty($general_settings)) {
				$extgeneralsetting = array(

				'_mm_layoutstyle_type' => 'simple',
				'_mm_template_type'  => 'grid',
				'_mm_enabledescription' => 'yes', 
				'_mm_addtocarttext' => 'Add to cart', 
				'_mm_boxheadingmessage' => 'Add your favourites to the Box',
				'_mm_Outofstocktext' => 'Out of Stock',   
				'_mm_boxsuccessmsg' => 'Box is full', 
				'_mm_color_backgroundcolor' => '',

				);

				update_option('extendons_custombox_general_settings', $extgeneralsetting);
			}
		}

		public function wooextmm_getting_product_mix_match_callback() {

			$return = array();
			if (isset($_GET['q'])) {
				$string1 = sanitize_text_field($_GET['q']);
			}
			$search_results = new WP_Query(
				array( 
				's'=> $string1,
				'post_status' => 'publish',
				'ignore_sticky_posts' => 1,
				'posts_per_page' => -1,
				'orderby' => 'title',
				'order' => 'ASC',
				'post_type' => array( 'product', 'product_variation' ),
				)
			);
		
			if ($search_results->have_posts() ) {

				while ( $search_results->have_posts() ) {
					$search_results->the_post(); 
				
					$title = ( mb_strlen($search_results->post->post_name) > 50 ) ? mb_substr($search_results->post->post_name, 0, 49) . '...' : $search_results->post->post_name;

					$return[] = array( $search_results->post->ID, ucfirst($title . ' (#' . $search_results->post->ID . ')') );

				}

			}
		
			echo json_encode($return);
		
			die;
		}

		public function wooextmm_is_product_purchasable_measurement( $purchasable, $product ) {

			if ('wooextmm' == $product->get_type() ) {
				$purchasable = true;
			}

			return $purchasable;
		}

		public function module_constant() {

			if (!defined('MIXMATCH_BUNDLES_URL') ) {
				define('MIXMATCH_BUNDLES_URL', plugin_dir_url(__FILE__));
			}

			if (!defined('MIXMATCH_BUNDLES_BASENAME') ) {
				define('MIXMATCH_BUNDLES_BASENAME', plugin_basename(__FILE__));
			}

			if (! defined('MIXMATCH_BUNDLES_DIR') ) {
				define('MIXMATCH_BUNDLES_DIR', plugin_dir_path(__FILE__));
			}

			if (!defined('MIXMATCH_BUNDLE_TEMPLATE_PATH') ) {
				define('MIXMATCH_BUNDLE_TEMPLATE_PATH', MIXMATCH_BUNDLES_DIR . 'templates');
			}
		}

		public function wooextmm_bundles_load_textdomain() {

			load_plugin_textdomain('extendons-woocommerce-product-boxes', false, dirname(plugin_basename(__FILE__)) . '/languages/');
		}

		public function wooextmm_bundles_main_scripts_loading() {
			wp_enqueue_script('jquery');
		}
	} 
	new EXTENDONS_MIXMATCH_PRODUCT_BUNDLES();
}
