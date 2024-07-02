<?php
/**
 * MM_WCsubscription_Compatibility_Feature class file.
 *
 * @package Woocommercecustomproductboxesplugin
 * @link    https://woocommerce.com/products/woocommerce-custom-product-boxes-plugin
 */

if (!defined('ABSPATH')) {
	exit; // Exit if accessed directly.
}

if (!class_exists('MM_WCsubscription_Compatibility_Feature')) {
	
	/**
	 * MM_WCsubscription_Compatibility_Feature class
	 *
	 * The class holding the definations of wc subscription module functions
	 *
	 * @package Woocommercecustomproductboxesplugin
	 * @link    https://woocommerce.com/products/woocommerce-custom-product-boxes-plugin
	 */
	class MM_WCsubscription_Compatibility_Feature {
	
		
		/**
		 * Constructor
		 */
		public function __construct() {

			// check is sbuscription and add order item meta
			add_filter('woocommerce_is_subscription', array( $this, 'mmIsSubscription' ), 10, 3);
			
			// adding field and sving field
			add_action('mm_subscription_product_meta', array( $this, 'mmSubscriptionProductMetaCallback' ));
			add_action('woocommerce_process_product_meta', array( $this, 'mmSaveSubscriptionProductMeta' ));

			// make this work for subscribtion
			add_filter('mix_match_box_product_single_add_to_cart_text', array( $this, 'minMaxSingleAddtoCartText' ), 10, 2);
			add_filter('mix_match_box_product_add_to_cart_text', array( $this, 'minMaxSingleAddtoCartText' ), 10, 2);
			add_action('min_match_box_product_after_price_sub', array( $this, 'minMatchBoxProductAfterPrice' ));
			add_action('wcs_can_item_be_removed', array( $this, 'minMatchCanItemBeRemoved' ), 10, 3);
		}

		/**
		 * Single add to cart text
		 *
		 * @param string $text    add to cart text.
		 * @param array  $product product array.
		 *
		 * @return string text
		 */
		public function minMaxSingleAddtoCartText( $text, $product ) {
			
			$url_path = trim(parse_url(add_query_arg(array()), PHP_URL_PATH), '/');
			
			if (get_post_meta($product->get_id(), '_mm_enable_wc_subscription', true) == 'yes') {
			
				$texta = esc_html__('Sign Up Now', 'extendons-woocommerce-product-boxes');
			
			} else {

				$texta = $text;
			}
			
			return $texta;
		}

		/**
		 * Single add to cart text
		 *
		 * @param int $product_id product id.
		 *
		 * @return string text
		 */
		public function minMatchBoxProductAfterPrice( $product_id ) {
			
			$product = wc_get_product($product_id);

			if ($product->is_type('wooextmm') && get_post_meta($product_id, '_mm_enable_wc_subscription', true) == 'yes') {
				
				$interval = array(
				 '1'=> 'every ',
				 '2'=> 'every 2nd ',
				 '3'=> 'every 3rd ',
				 '4'=> 'every 4th ',
				 '5'=> 'every 5th ',
				 '6'=> 'every 6th ',
				);
				
				$interv = get_post_meta($product_id, '_subscription_period_interval', true);
				
				$period = get_post_meta($product_id, '_subscription_period', true);
				
				echo '<p class="mix_matc_subscription_details">' . ( isset($interval[$interv]) ? esc_attr($interval[$interv]) : ' / ' ) . esc_attr($period) . '</p>';
			}
		}

		/**
		 * Mix and Match item remove
		 *
		 * @param bool  $allow_remove allow to remove.
		 * @param array $item         product data.
		 * @param int   $subscription subscription.
		 *
		 * @return boolen
		 */
		public function minMatchCanItemBeRemoved( $allow_remove, $item, $subscription ) {
			
			$product=wc_get_product($item['product_id']);
			
			if (count($subscription->get_items()) > 1 && $product->is_type('wooextmm')) {
			
				$allow_remove = false;
			
			}
			
			return $allow_remove;
		}

		/**
		 * Mix and Match item remove
		 *
		 * @param bool  $is_subscription subscription.
		 * @param int   $product_id      product id.
		 * @param array $product         product data.
		 *
		 * @return boolen
		 */
		public function mmIsSubscription( $is_subscription, $product_id, $product ) {
			
			$enable_mm_subscription = get_post_meta($product_id, '_mm_enable_wc_subscription', true);

			if ('yes' == $enable_mm_subscription) {
			
				$is_subscription = true;
			}

			return $is_subscription;
		}

		/**
		 * Subscription Meta box
		 *
		 * @return html
		 */
		public function mmSubscriptionProductMetaCallback() {

			// we use this add action to hook the enable meta for subscription box.
				
			//----------------------------------------------//
			//   do_action('mm_subscription_product_meta'); //
			//----------------------------------------------//
			global $post; 

			wp_nonce_field('ext_mix_nonce_action', 'ext_mix_nonce_field');

			woocommerce_wp_checkbox(
				array(
				'id' => '_mm_enable_wc_subscription',
				'label' => esc_html__('Enable Subscription', 'extendons-woocommerce-product-boxes'),
				'desc_tip'      => 'true',
				'description'   => esc_html__('Enable Subscription for Extendons Mix & Match Product Boxes.', 'extendons-woocommerce-product-boxes'),
				'value' => get_post_meta($post->ID, '_mm_enable_wc_subscription', true),
				)
			);
		}

		/**
		 * Mix and Match item remove
		 *
		 * @param int $post_id product id.
		 *
		 * @return meta
		 */
		public function mmSaveSubscriptionProductMeta( $post_id ) {

			if (!empty($_REQUEST['ext_mix_nonce_field'])) {

				$retrieved_nonce = sanitize_text_field($_REQUEST['ext_mix_nonce_field']);
			} else {
				$retrieved_nonce = 0;
			}
			
			if (!wp_verify_nonce($retrieved_nonce, 'ext_mix_nonce_action')) {

				die('Failed security check');
			}

			if (defined('DOING_AUTOSAVE') && DOING_AUTOSAVE) { 
				return;
			}

			$product = wc_get_product($post_id);
			if (!$product ) {
				return;
			}

			// if current user can't edit 
			if (!current_user_can('edit_post')) { 
				return;
			}

			// saving all important meta to let subscription work with mix and match
			if (isset($_POST['_mm_enable_wc_subscription'])) {

				wp_set_object_terms($post_id, 'subscription', 'wooextmm');
				if (isset($_POST['_subscription_price'])) {
					update_post_meta($post_id, '_subscription_price', sanitize_text_field($_POST['_subscription_price']));
				}
				if (isset($_POST['_subscription_sign_up_fee'])) {
					update_post_meta($post_id, '_subscription_sign_up_fee', sanitize_text_field($_POST['_subscription_sign_up_fee']));
				}
				if (isset($_POST['_subscription_period'])) {
					update_post_meta($post_id, '_subscription_period', sanitize_text_field($_POST['_subscription_period']));
				}
				if (isset($_POST['_subscription_period_interval'])) {
					update_post_meta($post_id, '_subscription_period_interval', sanitize_text_field($_POST['_subscription_period_interval']));
				}
				
				if (isset($_POST['_subscription_length'])) {
					update_post_meta($post_id, '_subscription_length', sanitize_text_field($_POST['_subscription_length']));
				}
				
				if (isset($_POST['_subscription_trial_period'])) {
					update_post_meta($post_id, '_subscription_trial_period', sanitize_text_field($_POST['_subscription_trial_period']));
				}
				
				if (isset($_POST['_subscription_trial_length'])) {
					update_post_meta($post_id, '_subscription_trial_length', sanitize_text_field($_POST['_subscription_trial_length']));
				}
				
				update_post_meta($post_id, '_mm_enable_wc_subscription', 'yes');
				
			} else {
			   
				wp_remove_object_terms($post_id, 'subscription', 'wooextmm');
				delete_post_meta($post_id, '_subscription_price');
				delete_post_meta($post_id, '_subscription_sign_up_fee');
				delete_post_meta($post_id, '_subscription_period');
				delete_post_meta($post_id, '_subscription_period_interval');
				delete_post_meta($post_id, '_subscription_length');
				delete_post_meta($post_id, '_subscription_trial_period');
				delete_post_meta($post_id, '_subscription_trial_length');
				update_post_meta($post_id, '_mm_enable_wc_subscription', 'no');

			}
		}
	} 
	new MM_WCsubscription_Compatibility_Feature();
}
