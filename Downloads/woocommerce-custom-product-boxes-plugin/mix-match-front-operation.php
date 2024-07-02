<?php 
if (! defined('ABSPATH') ) {
	exit; // Exit if accessed directly.
}

class MIXMATCH_FRONT_PRODUCT_BUNDLES extends EXTENDONS_MIXMATCH_PRODUCT_BUNDLES {


	public function __construct() {

		$view  = get_option('extendons_custombox_general_settings');
		add_action('wp', array( $this, 'wooextmm_scripts_sytles_enqueue' ));
		add_filter('template_include', array( $this, 'wooextmm_overrider_single_product_page' ), 20);
		add_action('mixmatch_after_single_product_summary', array( $this, 'wooextmm_single_product_summary_callback' ));

		add_filter('woocommerce_add_cart_item_data', array( $this, 'wooextmm_woocommerce_add_cart_item_data' ), 10, 2);

		add_action('woocommerce_add_to_cart', array( $this, 'wooextmm_woocommerce_add_to_cart' ), 10, 6);

		add_filter('woocommerce_cart_item_remove_link', array( $this, 'wooextmm_woocommerce_cart_item_remove_link' ), 10, 2);

		add_filter('woocommerce_cart_item_quantity', array( $this, 'wooextmm_woocommerce_cart_item_quantity' ), 10, 2);

		add_action('woocommerce_after_cart_item_quantity_update', array( $this, 'wooextmm_update_cart_item_quantity' ), 1, 2);

		add_action('woocommerce_before_cart_item_quantity_zero', array( $this, 'wooextmm_update_cart_item_quantity' ), 1);

		add_filter('woocommerce_cart_item_price', array( $this, 'wooextmm_woocommerce_cart_item_price' ), 99, 3);

		add_filter('woocommerce_cart_item_subtotal', array( $this, 'wooextmm_bundles_item_subtotal' ), 99, 3);

		add_filter('woocommerce_add_cart_item', array( $this, 'woocommerce_add_cart_item' ), 10, 2);

		add_filter('woocommerce_checkout_item_subtotal', array( $this, 'wooextmm_bundles_item_subtotal' ), 10, 3);

		add_action('woocommerce_cart_item_removed', array( $this, 'wooextmm_woocommerce_cart_item_removed' ), 10, 2);

		add_action('woocommerce_cart_item_restored', array( $this, 'wooextmm_woocommerce_cart_item_restored' ), 10, 2);

		add_filter('woocommerce_cart_contents_count', array( $this, 'wooextmm_woocommerce_cart_contents_count' ));

		add_filter('woocommerce_cart_item_class', array( $this, 'wooextmm_table_item_class_bundle' ), 10, 2);

		add_filter('woocommerce_get_cart_item_from_session', array( $this, 'wooextmm_woocommerce_get_cart_item_from_session' ), 10, 3);

		add_action('woocommerce_before_calculate_totals', array( $this, 'wooextmm_add_custom_price' ));

		add_filter('woocommerce_get_item_data', array( $this, 'wooextmm_display_gift_message' ), 10, 2);

		add_action('woocommerce_checkout_create_order_line_item', array( $this, 'extendons_add_custom_data_to_order' ), 10, 4);
		// add_shortcode('ext_custom_shortcode', array($this, 'ext_mb_add_shortcode'));

		//add_action('init', array($this, 'ext_mb_add_shortcode'), 10 ,1);
	}


	public function extendons_add_custom_data_to_order( $item, $cart_item_key, $cart_item, $order ) {

		$product = $order->get_product_from_item($item);
		$prod_id =  $product->get_id();
		$box_no = intval($cart_item['mm_item_id']+intval(1));
		$item->add_meta_data(__('box'), $box_no, true);     
	}


	public function wooextmm_add_custom_price( $cart_object ) {
		if (!empty($_REQUEST['ext_mix_nonce_field'])) {
			$retrieved_nonce = sanitize_text_field($_REQUEST['ext_mix_nonce_field']);
		} else {
			$retrieved_nonce = 0;
		}

		if (wp_verify_nonce($retrieved_nonce, 'ext_mix_nonce_action')) {

			die('Failed security check');
		}
		
		
		foreach ( $cart_object->cart_contents as $key => $value ) {
			
			if (isset($value['mm_perItem_pricing'])) {
				$subtotal = $value['mm_perItem_pricing'];
				$value['data']->set_price($subtotal);
			}
		}
	}


	public function wooextmm_table_item_class_bundle( $classname, $cart_item ) {
		if (isset($cart_item[ 'mmBundleParent' ]) ) {
			return $classname . 'mixmatch-child';  
		} else if (isset($cart_item[ 'mmBundleItems' ]) ) {
			$classname = $classname . ' mixmatch-parent';
			return $classname;
		} else {
			return $classname;
		}
	}

	public function wooextmm_woocommerce_get_cart_item_from_session( $cart_item, $item_session_values, $cart_item_key ) {

		$cart_contents = !empty(WC()->cart) ? WC()->cart->cart_contents : '';
		if (isset($item_session_values[ 'bundles_item' ]) && !empty($item_session_values[ 'bundles_item' ]) ) {
			$cart_item[ 'bundles_item' ] = $item_session_values[ 'bundles_item' ];
		}
		if (isset($item_session_values[ 'mmBundleItems' ]) ) {
			$cart_item[ 'mmBundleItems' ] = $item_session_values[ 'mmBundleItems' ];
		}

		if (isset($item_session_values[ 'mmBundleParent' ]) ) {
			$cart_item[ 'mmBundleParent' ] = $item_session_values[ 'mmBundleParent' ];
			$cart_item[ 'mm_item_id' ] = $item_session_values[ 'mm_item_id' ];
			$bundle_cart_key = $cart_item[ 'mmBundleParent' ];

			if (isset($cart_contents[ $bundle_cart_key ]) ) {

				$parent = $cart_contents[ $bundle_cart_key ][ 'data' ];
				$product_id = $cart_item[ 'mm_item_id' ];
				$cart_item['data']->set_price(0);
			}

		}

		return $cart_item;
	}



	public function woocommerce_add_cart_item( $cart_item, $cart_key ) {


		$cart_contents = WC()->cart->cart_contents;
		if (isset($cart_item[ 'mmBundleParent' ])) {

			$bundle_cart_key = $cart_item[ 'mmBundleParent' ];
			if (isset($cart_contents[ $bundle_cart_key ]) ) {
				$parent = $cart_contents[ $bundle_cart_key ][ 'data' ];
				$bundle_item_id = $cart_item[ 'mm_item_id' ];
				$cart_item[ 'data' ]->set_price(0);


			}

		}

		return $cart_item;
	}


	public function wooextmm_woocommerce_cart_item_removed( $cart_item_key, $cart ) {
		if (!empty($cart->removed_cart_contents[ $cart_item_key ][ 'bundles_item' ]) ) {
			$bundled_item_cart_keys = $cart->removed_cart_contents[ $cart_item_key ][ 'bundles_item' ];
			foreach ( $bundled_item_cart_keys as $bundled_item_cart_key ) {
				if (!empty($cart->cart_contents[ $bundled_item_cart_key ]) ) {
					$remove = $cart->cart_contents[ $bundled_item_cart_key ];
					$cart->removed_cart_contents[ $bundled_item_cart_key ] = $remove;
					unset($cart->cart_contents[ $bundled_item_cart_key ]);
					/**
					 * Check WooCommerce is installed and active
					 *
					 * This function will check that woocommerce is installed and active
					 * and returns true or false
					 *
					 * @since 1.0.1
					**/ 
					do_action('woocommerce_cart_item_removed', $bundled_item_cart_key, $cart);
				}
			}
		}
	}


	public function wooextmm_woocommerce_cart_item_restored( $cart_item_key, $cart ) {
		if (!empty($cart->cart_contents[ $cart_item_key ][ 'bundles_item' ]) ) {
			$bundled_item_cart_keys = $cart->cart_contents[ $cart_item_key ][ 'bundles_item' ];
			foreach ( $bundled_item_cart_keys as $bundled_item_cart_key ) {
				$cart->restore_cart_item($bundled_item_cart_key);
			}
		}
	}

	public function wooextmm_woocommerce_cart_contents_count( $count ) {
		$cart_contents = WC()->cart->cart_contents;

		$bundled_items_count = 0;
		foreach ( $cart_contents as $cart_item_key => $cart_item ) {
			if (!empty($cart_item[ 'mmBundleParent' ]) ) {
				$bundled_items_count += $cart_item[ 'quantity' ];
			}
		}

		return intval($count - $bundled_items_count);
	}


	public function wooextmm_bundles_item_subtotal( $subtotal, $cart_item, $cart_item_key ) {

		if (isset($cart_item['mm_perItem_pricing'])) {
			$subtotal = $cart_item['mm_perItem_pricing'];   
			$subtotal = floatval($subtotal) * $cart_item['quantity'];
			$subtotal = wc_price($subtotal);
		}
		if (isset($cart_item[ 'mmBundleParent' ]) ) {
			$bundle_cart_key = $cart_item[ 'mmBundleParent' ];
			if (isset(WC()->cart->cart_contents[ $bundle_cart_key ]) ) {
				return '';
			}
		}
		if (isset($cart_item[ 'bundles_item' ]) ) {
			if ($cart_item[ 'data' ]->get_price() == 0 ) {
				return '';
			}
		}
		return $subtotal;
	}


	public function wooextmm_woocommerce_cart_item_price( $price, $cart_item, $cart_item_key ) {
		if (isset($cart_item['mm_perItem_pricing'])) {
			$price = wc_price($cart_item['mm_perItem_pricing']);
		}
		if (isset($cart_item[ 'mmBundleParent' ]) ) {
			$bundle_cart_key = $cart_item[ 'mmBundleParent' ];
			if (isset(WC()->cart->cart_contents[ $bundle_cart_key ]) ) {
				return '';
			}
		}

		return $price;
	}


	public function wooextmm_woocommerce_cart_item_remove_link( $link, $cart_item_key ) {

		if (isset(WC()->cart->cart_contents[ $cart_item_key ][ 'mmBundleParent' ]) ) {
			$bundle_cart_key = WC()->cart->cart_contents[ $cart_item_key ][ 'mmBundleParent' ];
			if (isset(WC()->cart->cart_contents[ $bundle_cart_key ]) ) {
				return '';
			}
		}

		return $link;
	}

	public function wooextmm_woocommerce_cart_item_quantity( $quantity, $cart_item_key ) {

		if (isset(WC()->cart->cart_contents[ $cart_item_key ][ 'mmBundleParent' ]) ) {
			return WC()->cart->cart_contents[ $cart_item_key ][ 'quantity' ];
		}
		return $quantity;
	}

	public function wooextmm_update_cart_item_quantity( $cart_item_key, $quantity = 0 ) {

		if (!empty($_REQUEST['ext_mix_nonce_field'])) {
			$retrieved_nonce = sanitize_text_field($_REQUEST['ext_mix_nonce_field']);
		} else {
			$retrieved_nonce = 0;
		}

		if (wp_verify_nonce($retrieved_nonce, 'ext_mix_nonce_action')) {

			die('Failed security check');
		}

		// if (isset($_POST['add_new_box'])) {

		$add_new_box = 'yes';

		if ('yes'==$add_new_box) {

			if (!empty(WC()->cart->cart_contents[ $cart_item_key ]) ) {

				if ($quantity <= 0 ) {

					$quantity = 0;

				} else {

					$quantity = WC()->cart->cart_contents[ $cart_item_key ][ 'quantity' ];

				}

				if (!empty(WC()->cart->cart_contents[ $cart_item_key ][ 'mmBundleItems' ]) && !isset(WC()->cart->cart_contents[ $cart_item_key ][ 'mmBundleParent' ]) ) {

					$stamp = WC()->cart->cart_contents[ $cart_item_key ][ 'mmBundleItems' ];

					foreach ( WC()->cart->cart_contents as $key => $value ) {

						if (isset($value[ 'mmBundleParent' ]) && $cart_item_key == $value[ 'mmBundleParent' ] ) {
							   $bundle_item_ids  = $value['mm_item_id'];
							   $bundle_quantity = $value[ 'quantity' ];
							   WC()->cart->set_quantity($key, $bundle_quantity, false);
						}
					}
				}
			}

		} elseif (!empty(WC()->cart->cart_contents[ $cart_item_key ]) ) {


			if ($quantity <= 0 ) {

				$quantity = 0;

			} else {

				$quantity = WC()->cart->cart_contents[ $cart_item_key ][ 'quantity' ];

			}

			if (!empty(WC()->cart->cart_contents[ $cart_item_key ][ 'mmBundleItems' ]) && !isset(WC()->cart->cart_contents[ $cart_item_key ][ 'mmBundleParent' ]) ) {

				$stamp = WC()->cart->cart_contents[ $cart_item_key ][ 'mmBundleItems' ];

				foreach ( WC()->cart->cart_contents as $key => $value ) {

					if (isset($value[ 'mmBundleParent' ]) && $cart_item_key == $value[ 'mmBundleParent' ] ) {
						$bundle_item_ids  = $value['mm_item_id'];
						$bundle_quantity = $stamp[ $bundle_item_ids ][ 'quantity' ];
						WC()->cart->set_quantity($key, $quantity * $bundle_quantity, false);
					}
				}
			}
		}
		// }
	}


	public function wooextmm_woocommerce_add_to_cart( $cart_item_key, $product_id, $quantity, $variation_id, $variation, $cart_item_data ) {

		if (!empty($_REQUEST['ext_mix_nonce_field'])) {
			$retrieved_nonce = sanitize_text_field($_REQUEST['ext_mix_nonce_field']);
		} else {
			$retrieved_nonce = 0;
		}

		if (wp_verify_nonce($retrieved_nonce, 'ext_mix_nonce_action')) {

			die('Failed security check');
		}

		$add_new_box = get_post_meta($product_id, '_mm_add_new_boxes', true);                                    

		if ('yes'==$add_new_box) {

			if (isset($cart_item_data[ 'mmBundleItems' ])) {

				$mm_items_cart_data = array( 'mmBundleParent' => $cart_item_key );

				foreach ($cart_item_data[ 'mmBundleItems' ] as $key => $value ) {

					$product_box = $value['product_id'];
					$quantity = $value['product_id'];
					$boxqty = $value['boxQty'];

					if (is_array($value['product_id'])) {
						$product_box = array_unique($value['product_id']);
						$quantity = array_count_values($value['product_id']);
					}


					foreach ($product_box as $key1 => $value1) {

						$mm_item_cart_data = $mm_items_cart_data;

						$mm_item_cart_data[ 'mm_item_id' ] = $key;

						$item_quantity = $quantity;

						$quantity = $item_quantity;

						$total_quantity = $quantity;

						$prod_ids = $value1;

						$bundled_item_cart_key = $this->mmbndles_bundled_add_to_cart($product_id, $prod_ids, $mm_item_cart_data, $total_quantity, $variation_id, '', $boxqty);

						if ($bundled_item_cart_key && !in_array($bundled_item_cart_key, WC()->cart->cart_contents[ $cart_item_key ][ 'bundles_item' ]) ) {

							WC()->cart->cart_contents[ $cart_item_key ][ 'bundles_item' ][] = $bundled_item_cart_key;
							WC()->cart->cart_contents[ $cart_item_key ][ 'woextmm_parent' ] = $cart_item_key;
						}  

					}

				}

			}



		} elseif (isset($cart_item_data[ 'mmBundleItems' ])) {



			$mm_items_cart_data = array( 'mmBundleParent' => $cart_item_key );

			foreach ($cart_item_data[ 'mmBundleItems' ] as $key => $value ) {

				$mm_item_cart_data = $mm_items_cart_data;

				$mm_item_cart_data[ 'mm_item_id' ] = $key;

				$item_quantity = $value['quantity'];

				$total_quantity = $item_quantity * $quantity;

				$prod_ids = $value[ 'product_id' ];

				$boxqty = $value['boxQty'];

			


				$bundled_item_cart_key = $this->mmbndles_bundled_add_to_cart($product_id, $prod_ids, $mm_item_cart_data, $total_quantity, $variation_id, '', $boxqty);

				if ($bundled_item_cart_key && !in_array($bundled_item_cart_key, WC()->cart->cart_contents[ $cart_item_key ][ 'bundles_item' ]) ) {

					WC()->cart->cart_contents[ $cart_item_key ][ 'bundles_item' ][] = $bundled_item_cart_key;
					WC()->cart->cart_contents[ $cart_item_key ][ 'woextmm_parent' ] = $cart_item_key;
				}
			}
		}
	}


	public function mmbndles_bundled_add_to_cart( $bundle_parent_id, $bundle_product_ids, $cart_item_data, $quantity = 1, $variation_id = 0, $variation = array(), $boxqty = 1 ) {
		if ($quantity <= 0 ) {
			return false;
		}
		if (!empty($_REQUEST['ext_mix_nonce_field'])) {
			$retrieved_nonce = sanitize_text_field($_REQUEST['ext_mix_nonce_field']);
		} else {
			$retrieved_nonce = 0;
		}
		if (wp_verify_nonce($retrieved_nonce, 'ext_mix_nonce_action')) {
			die('Failed security check');
		}
			
			$add_new_box = get_post_meta($bundle_parent_id, '_mm_add_new_boxes', true); 
		if ('yes' != $add_new_box) {
			
			$cart_item_data = ( array ) apply_filters('woocommerce_add_cart_item_data', $cart_item_data, $bundle_product_ids, $variation_id);
					
			$cart_id = WC()->cart->generate_cart_id($bundle_product_ids, $variation_id, $variation, $cart_item_data);
				
			$cart_item_key = WC()->cart->find_product_in_cart($cart_id);
				
			if (  'product_variation' == get_post_type($bundle_product_ids)) {
				$variation_id = $bundle_product_ids;            
				$bundle_product_ids  = wp_get_post_parent_id($variation_id);
						
			}
			$product_data = wc_get_product($variation_id ? $variation_id : $bundle_product_ids);

			if (!$cart_item_key ) {    
				$cart_item_key = $cart_id;
				WC()->cart->cart_contents[ $cart_item_key ] = apply_filters(
					'woocommerce_add_cart_item', array_merge(
						$cart_item_data, array(
						'product_id'   => $bundle_product_ids,
						'variation_id' => $variation_id,
						'variation'    => $variation,
						'quantity'     => $quantity * $boxqty,
						'data'         => $product_data,    
						) 
					), $cart_item_key 
				);

			}
		} else {
			$cart_item_data = ( array ) apply_filters('woocommerce_add_cart_item_data', $cart_item_data, $bundle_product_ids, $variation_id);
			$cart_id = WC()->cart->generate_cart_id($bundle_product_ids, $variation_id, $variation, $cart_item_data);
			$cart_item_key = WC()->cart->find_product_in_cart($cart_id);
			if (  'product_variation' == get_post_type($bundle_product_ids)  ) {
				$variation_id = $bundle_product_ids;
				$bundle_product_ids  = wp_get_post_parent_id($variation_id);
			}
			//haseeb edit v 1.3.0
			if ('0'== $variation_id) {
				$variation_id = $bundle_product_ids;
			}
			//
			$product_data = wc_get_product($variation_id ? $variation_id : $bundle_product_ids);  
				
			if (!$cart_item_key ) {
				$cart_item_key = $cart_id;
				WC()->cart->cart_contents[ $cart_item_key ] = apply_filters(
					'woocommerce_add_cart_item', array_merge(
						$cart_item_data, array(
						'product_id'   => $bundle_product_ids,
						'variation_id' => $variation_id,
						'variation'    => $variation,
						'quantity'     => $quantity[$variation_id] * $boxqty,
						'data'         => $product_data,
						) 
					), $cart_item_key 
				);

			}
		}
			
			return $cart_item_key;
	}



	public function wooextmm_woocommerce_add_cart_item_data( $cart_item_data, $product_id ) {

		$product = wc_get_product($product_id);
		if (!$product || !$product->is_type('wooextmm') ) {
			return $cart_item_data;
		}

		// gift massage 
		$mm_gift_massage = isset($_REQUEST['mm_gift_massage']) ? sanitize_text_field($_REQUEST['mm_gift_massage']) : '';
		$mm_gift_massage_lbl = isset($_REQUEST['mm_gift_massage_lbl']) ? sanitize_text_field($_REQUEST['mm_gift_massage_lbl']) : '';
		// per item pricing
		$mm_perItem_pricing = isset($_REQUEST['mmperItemPrice']) ? sanitize_text_field($_REQUEST['mmperItemPrice']) : 0;
		// product custom option price
		$mm_product_custom_options = isset($_REQUEST['mmoptionprice']) ? sanitize_text_field($_REQUEST['mmoptionprice']) : '';

		// product items mixmatch
		$mm_product_items = isset($_REQUEST['mm_product_items']) ? sanitize_text_field($_REQUEST['mm_product_items']) : '';

		$add_new_box_quantity = get_post_meta($product_id, '_mm_add_new_boxes', true);

		// $metaSelect = get_post_meta($product_id, '_mm_template_type', true);

		if ('yes'!=$add_new_box_quantity) {
			$mm_product_items = explode(',', $mm_product_items);
		}   
		if (!!$mm_product_items ) {

			if (!empty($_REQUEST['ext_mix_nonce_field'])) {
				$retrieved_nonce = sanitize_text_field($_REQUEST['ext_mix_nonce_field']);
			} else {
				$retrieved_nonce = 0;
			}

			if (wp_verify_nonce($retrieved_nonce, 'ext_mix_nonce_action')) {

				die('Failed security check');
			}


			if ('yes'==$add_new_box_quantity) {

				$arrays =json_decode(stripslashes($mm_product_items));
				$size = count($arrays);
				$quantity =  1;
				$mmBundleItems = array();   
				for ($i=0; $i<$size ; $i++) { 

					for ($j=0; $j<count($arrays[$i]); $j++) { 

						$mmBundleItems[$i] = array(

						 'product_id' => $arrays[$i],
						 'quantity' => $arrays[$i],
						 'boxQty'  => isset($_REQUEST['extendons_gt_box_qty' . $i]) ? filter_var($_REQUEST['extendons_gt_box_qty' . $i]) : '1',
						);

					}
				}

				$cart_item_data['mmBundleItems'] = $mmBundleItems;
				$cart_item_data['add_new_boxes'] = $add_new_box_quantity; 
				$cart_item_data['mmGiftmassage'] = $mm_gift_massage;
				$cart_item_data['mm_gift_massage_lbl'] = $mm_gift_massage_lbl;
				$cart_item_data['mm_product_custom_options'] = $mm_product_custom_options;
				$cart_item_data['mm_perItem_pricing'] = $mm_perItem_pricing;
				$cart_item_data['bundles_item'] = array();

			} else { 

				$mm_product_itemss = isset($_REQUEST['mm_product_items']) ? map_deep(wp_unslash($_REQUEST['mm_product_items']), 'sanitize_text_field') : array();

				// print_r($mm_product_items);

				$arrays =json_decode(stripslashes($mm_product_itemss));
				$productOccurences = array_count_values($arrays[0]);
				$mmBundleItems = array();
				$i = 1;
				foreach ($productOccurences as $key => $values) {
					$mmBundleItems[$i] = array(
					'product_id' => stripslashes($key),
					'quantity' => $values, 
					'boxQty'  => isset($_REQUEST['extendons_gt_box_qty0']) ? filter_var($_REQUEST['extendons_gt_box_qty0']) : '1',
					);
					$i++; 
				} 

				$cart_item_data['mmBundleItems'] = $mmBundleItems;
				$cart_item_data['add_new_boxes'] = $add_new_box_quantity;
				$cart_item_data['mmGiftmassage'] = $mm_gift_massage;
				$cart_item_data['mm_gift_massage_lbl'] = $mm_gift_massage_lbl;
				$cart_item_data['mm_product_custom_options'] = $mm_product_custom_options;
				$cart_item_data['mm_perItem_pricing'] = $mm_perItem_pricing;
				$cart_item_data['bundles_item'] = array();

			}
		}       

		return $cart_item_data;
	}


	public function wooextmm_display_gift_message( $item_data, $cart_item ) {

		global $cart;

		$mm_gift_massage = isset($cart_item['mmGiftmassage']) ? $cart_item['mmGiftmassage'] : '';
		$mm_gift_massage_lbl = isset($cart_item['mm_gift_massage_lbl']) ? $cart_item['mm_gift_massage_lbl'] : '';

		// mix match gift massge for parent product
		if (isset($mm_gift_massage) && '' != $mm_gift_massage  ) {

			$item_data[] = array(
			'key'     => $mm_gift_massage_lbl,
			'value'   => $mm_gift_massage,
			); 
		}

		// show bundled by message for all its items
		if (isset($cart_item['mmBundleParent']) && '' != $cart_item['mmBundleParent']) {

			$cart_contents = WC()->cart->cart_contents;

			$bundle_cart_key = $cart_item[ 'mmBundleParent' ];

			if (isset($cart_contents[ $bundle_cart_key ]) ) {

				$parentId = $cart_contents[ $bundle_cart_key ][ 'data' ]->get_id();

				$product = wc_get_product($parentId);

				$box = $cart_item['mm_item_id']+1;

				$mmItemName = $product->get_title();

				$add_new_box_quantity = get_post_meta($parentId, '_mm_add_new_boxes', true);

				if ('yes'==$add_new_box_quantity) {
					$item_data[] = array(
					 'key'     => esc_html__('Included with', 'extendons-woocommerce-product-boxes'),
					 'value'   => $mmItemName . ' -box ' . $box . ' ',
					); 
				} else {

					$item_data[] = array(
					'key'     => esc_html__('Included with', 'extendons-woocommerce-product-boxes'),
					'value'   => $mmItemName,
					); 
				}


			}
		}

		return $item_data;
	}


	public function wooextmm_scripts_sytles_enqueue() {

		if (is_singular('product') ) {

			global $post;
			$post_id = $post->ID;
			$boxQty = get_post_meta($post_id, '_mm_box_quantity', true);
			$pricingType = get_post_meta($post_id, '_mm_pricing_type', true);
			$add_new_box_quantity = get_post_meta($post_id, '_mm_add_new_boxes', true);
			$mmPrefilled_enable = get_post_meta($post_id, '_mm_enable_prefiled', true);
			$mmPrefilled_items = get_post_meta($post_id, '_mm_prefilled_product_front', true);
			$partialyAllow = get_post_meta($post_id, '_mm_partialy_filled_layout', true);
			$minboxqty = get_post_meta($post_id, '_mm_boxmin_qty_allow', true);

			//prduct limit
			$mmProdLimitEnable = get_post_meta($post_id, '_mm_enable_limit_per_prod', true);
			$mmProdLimitQuantity = get_post_meta($post_id, '_mm_limit_per_prod_quanity', true);

			$general_settings = get_option('extendons_custombox_general_settings');
			if (isset($general_settings['_mm_boxsuccessmsg']) && '' != $general_settings['_mm_boxsuccessmsg']) {
				$boxsuccessmessage = $general_settings['_mm_boxsuccessmsg'];
			} else {
				$boxsuccessmessage = 'Box Is Full';
			}

			$parentproduct = wc_get_product($post->ID);
			$selectedallproductids = get_post_meta($parentproduct->get_id(), '_mm_add_products', true);
			$localizeproductarray = array();
			if (!empty($selectedallproductids)) {
				foreach ($selectedallproductids as $key=> $value) {

					$selectedproducts = wc_get_product($value);
					$_manage_stock = get_post_meta($selectedproducts->get_id(), '_manage_stock', true);
					if ('yes' == $_manage_stock) {
						$localizeproductarray[$selectedproducts->get_id()] = $selectedproducts->get_stock_quantity();
					}
				}

			}

			if (isset($mmPrefilled_enable) && 'yes' == $mmPrefilled_enable ) {
				if (!empty($mmPrefilled_items)) {
					$prefileldArray = $mmPrefilled_items;
				}
			} else {
				$prefileldArray = array();
			}
			$array = array();
			if (!empty($prefileldArray)) {
				$qunit_arr = array();
				foreach ($prefileldArray as $key => $value) {

					$prefilledproduct = wc_get_product($value['product_id']);
					if (!$prefilledproduct->is_in_stock() ) {
						continue;  
					}
					array_push(
						$array, array(
						'product_id' => $value['product_id'],
						'product_price' => $prefilledproduct->get_price(),
						)
					);
					$pr_id_here = $value['product_id'];
					$_manage_stock = get_post_meta($prefilledproduct->get_id(), '_manage_stock', true);
					if ('yes' == $_manage_stock) {

						if (array_key_exists($pr_id_here, $qunit_arr)) {
							$qunit_arr[$pr_id_here] = (int) $qunit_arr[$pr_id_here] + 1;
						} else {
							$qunit_arr[$pr_id_here] = 1;
						}

						if ($qunit_arr[$pr_id_here] < $prefilledproduct->get_stock_quantity()) {

							if (array_key_exists($pr_id_here, $localizeproductarray)) {
								$localizeproductarray[$pr_id_here] = (int) $localizeproductarray[$pr_id_here] - 1;
							}
							continue;
						}
					}

				}
			}

			$currencysymbol = get_woocommerce_currency_symbol();
			wp_enqueue_script('jquery');
			wp_enqueue_style('wooextbox-style-css', plugins_url('templates/single-product/add-to-cart/product-gift-box/front-end/css/style.css', __FILE__), false, '1.0.1');
			wp_enqueue_script('wooextbox-main-js', plugins_url('templates/single-product/add-to-cart/product-gift-box/front-end/js/main.js', __FILE__), false, '1.0.2');

			wp_enqueue_script('wooextbox-jquery-ui-js', 'https://cdnjs.cloudflare.com/ajax/libs/jqueryui/1.13.2/jquery-ui.min.js', false, '1.0.0');

			$plugin_dir_URL = array(
			'plugin_dir_URL' => plugin_dir_url(__FILE__),
			'plugin_dir_URL_image_path' => plugin_dir_url(__FILE__) . 'templates/single-product/add-to-cart/product-gift-box/front-end',
			'boxQty' => $boxQty,
			'add_new_box_quantity' => $add_new_box_quantity,
			'pricingType' => $pricingType,
			'parentProductprice' => $parentproduct->get_price(),
			'currencysymbol' => $currencysymbol,
			'mmPrefilled_enable' => $mmPrefilled_enable,
			'prefileldArray' => $array,
			'prefileldArraylength' => count($array),
			'partialyAllow' => $partialyAllow,
			'minboxqty'  => $minboxqty,
			'boxsuccessmessage' => $boxsuccessmessage,
			'localizeproductarray' => $localizeproductarray,
			'mmProdLimitEnable' => $mmProdLimitEnable,
			'mmProdLimitQuantity' => $mmProdLimitQuantity,
			'_mm_template_type' => $general_settings['_mm_template_type'],
			'Subtotal' => __('Subtotal', 'extendons-woocommerce-product-boxes'),  
			'ajax_url'    => admin_url('admin-ajax.php'),
			);
			wp_localize_script('wooextbox-main-js', 'ewcpm_php_vars_cb', $plugin_dir_URL); 

		}
	}

	public function wooextmm_overrider_single_product_page( $template ) {

		global $post;
		
		/** Added in v-1.3.0 **/
		if (!isset($post)) {
			return $template;
		}
		//
		
		$metacustomboxenable  = get_post_meta($post->ID, '_mm_sort_enable_box', true);
		$metaSelect = get_post_meta($post->ID, '_mm_template_type', true);

		if (is_singular('product') && 'yes' == $metacustomboxenable) {

			$wc_product = wc_get_product($post->ID);

			if ('wooextmm' == $wc_product->get_type() && is_singular('product')) {

				$template = plugin_dir_path(__FILE__) . 'woocommerce/single-product.php';
			}

			return $template;

		} else {

			return $template;
		}
	}

	public function wooextmm_single_product_summary_callback() {

		global $product;
		$id = $product->get_id();
		$parentProduct = wc_get_product($product->get_id());
		$parentPrice = $parentProduct->get_price();
		$title = $product->get_title();
		$sku = $product->get_sku();
		$productsmm = get_post_meta($id, '_mm_add_products', true);
		$add_new_box_quantity = get_post_meta($id, '_mm_add_new_boxes', true);
		$sort_enable  = get_post_meta($id, '_mm_sort_product_date', true);
		// total column allowed
		$boxQty = get_post_meta($id, '_mm_box_quantity', true);

		$pricingType = get_post_meta($id, '_mm_pricing_type', true);

		// gift message
		$mmGmasgenable = get_post_meta($id, '_mm_enable_gift_masg', true);
		$mmGmasglabel = get_post_meta($id, '_mm_gift_masg_label', true);

		//prduct limit
		$mmProdLimitEnable = get_post_meta($id, '_mm_enable_limit_per_prod', true);
		$mmProdLimitQuantity = get_post_meta($id, '_mm_limit_per_prod_quanity', true);
		

		if (isset($mmGmasglabel) && '' != $mmGmasglabel ) {
			$masglabel = $mmGmasglabel;
		} else {
			$masglabel = esc_html__('Gift Message', 'extendons-woocommerce-product-boxes');
		}   

		$mmPrefilled_enable = get_post_meta($id, '_mm_enable_prefiled', true);
		$prefileldArray = array();
		$mmPrefilled_items = get_post_meta($id, '_mm_prefilled_product_front', true);
		if (isset($mmPrefilled_enable) && 'yes' == $mmPrefilled_enable ) {
			if (!empty($mmPrefilled_items)) {
				$prefileldArray = $mmPrefilled_items;
			}
		} else {
			$prefileldArray = array();
		}

		$array = array();
		if (!empty($prefileldArray)) {
			$qunit_arr = array();
			foreach ($prefileldArray as $key => $value) {

				$prefilledproduct = wc_get_product($value['product_id']);
				$pr_id_here = $value['product_id'];
				$_manage_stock = get_post_meta($prefilledproduct->get_id(), '_manage_stock', true);
				if ('yes' == $_manage_stock) {

					if (array_key_exists($pr_id_here, $qunit_arr)) {
						$qunit_arr[$pr_id_here] = (int) $qunit_arr[$pr_id_here] + 1;
					} else {
						$qunit_arr[$pr_id_here] = 1;
					}
					if ($prefilledproduct->get_stock_quantity() < $qunit_arr[$pr_id_here]) {
						   continue;
					}
				}

				if (!$prefilledproduct->is_in_stock() ) {
					continue;  
				}

				array_push(
					$array, array(
					'product_id' => $value['product_id'],
					'product_price' => $prefilledproduct->get_price(),
					)
				);

			}
		}

		$view  = get_option('extendons_custombox_general_settings');
		if (isset($view['_mm_color_backgroundcolor']) && '' != $view['_mm_color_backgroundcolor']) {

			?>
				<style type="text/css">
					.product_addon_container {
						background-color: <?php echo filter_var($view['_mm_color_backgroundcolor']); ?> !important;
					}    
				</style>

			<?php
				

			$color_val_ = $view['_mm_color_primarycolor'] ?? '#995E8E';
 
			$color_val = $color_val_ . ' !important';

			$form_width = $view['_mm_form_width'] ?? '100%';
 
			$price_color =  $view['_mm_color_pricecolor'] ?? '#6d6d6d';
			?>
	
	<style type="text/css">
		.gift_box_top .reset_gt_box .clear_cta{color: <?php echo filter_var($price_color); ?>; }

	.gt_box_tab .box_tb_list{ color: <?php echo filter_var($color_val); ?>; border:1px solid <?php echo filter_var($color_val); ?>; display: inline-block;}

	.gt_box_tab .box_tb_list .gt_qt{color: <?php echo filter_var($color_val); ?>;border:1px solid <?php echo filter_var($color_val); ?>; }

	.gt_box_tab .box_tb_list:hover{ background-color: <?php echo filter_var($color_val); ?>; border-color:<?php echo filter_var($color_val); ?>; color :#fff !important}

	.gt_box_tab .box_tb.active_tab .box_tb_list{ background-color:#ffff ; border-color:<?php echo filter_var($color_val); ?>;}

	.gift_box_container .add_box .add_box_cta{color: <?php echo filter_var($color_val); ?>; border:1px solid <?php echo filter_var($color_val); ?>; }

	.gift_box_container .add_box .add_box_cta:hover{background-color: <?php echo filter_var($color_val); ?>;}

	.product_addon_box .pd_title{color: <?php echo filter_var($color_val); ?>; }
	.pd_add_block .pd_dtl .pd_title a{color: <?php echo filter_var($color_val); ?>;}

	.pd_addon_btns .add_btn .add_cta{color: <?php echo filter_var($color_val); ?>; border:1px solid <?php echo filter_var($color_val); ?>; }

	.pd_add_block .pd_addon_btns .addon_qty{border:1px solid <?php echo filter_var($color_val); ?>;}

	.pd_addon_btns .addon_qty .qty_control{ background-color: <?php echo filter_var($color_val); ?>;}

	.pd_addon_btns .addon_qty .value{border-left: 1px solid <?php echo filter_var($color_val); ?>; border-right: 1px solid <?php echo filter_var($color_val); ?>; }

	.pd_add_block .pd_dtl .pd_price{ color: <?php echo filter_var($color_val); ?>;}

	.pd_add_block .pd_dtl .show_dtl{ color: <?php echo filter_var($color_val); ?>; }

	.pd_add_block .pd_dtl .show_dtl:hover{color:<?php echo filter_var($color_val); ?>;}

	.horizontal_box .gift_box_container .add_box .add_box_cta{ background-color: <?php echo filter_var($color_val); ?>; }

/*    .horizontal_box .gift_box_container .add_box .add_box_cta a svg:hover{fill:#fff !important}*/
	.horizontal_box .gift_box_container .gt_bx_rt .add_box .add_box_cta{background-color: #fff !important; color: <?php echo filter_var($color_val); ?>;}

	.horizontal_box .gift_box_container .gt_bx_rt .add_box .add_box_cta:hover{background-color: <?php echo filter_var($color_val); ?>; color:#fff !important }

	.horizontal_box .gt_box_tab .box_tb.active_tab .box_tb_list{color: #3434 }

/*     .horizontal_box .gt_box_tab .box_tb.active_tab .box_tb_list .gt_qt{color: <?php echo filter_var($color_val); ?>; border-color: <?php echo filter_var($color_val); ?>;} */

	.horizontal_box .gt_box_tab .box_tb.active_tab{border-left: 3px solid <?php echo filter_var($color_val); ?>;}

	.horizontal_box .reset_gt_box.resp .clear_cta{color: <?php echo filter_var($color_val); ?>;}

	.simple_pd .pd_add_block .pd_dtl .pd_price{ color: <?php echo filter_var($color_val); ?>; }

	.gt_overlay .overlay_inner .price{ color: <?php echo filter_var($color_val); ?>;}

	.horizontal_box .gt_box_tab .box_tb_list{color: <?php echo filter_var($color_val); ?>; border:1px solid <?php echo filter_var($color_val); ?>; margin-right:5px }

	.horizontal_box .gt_box_tab .box_tb_list .gt_qt{border:0px solid <?php echo filter_var($color_val); ?>; color: inherit !important;}

	.horizontal_box .reset_gt_box.resp .clear_cta{color: <?php echo filter_var($color_val); ?>;}

	.horizontal_box .gift_box_container .gt_bx_lt .add_box .add_box_cta{ color: <?php echo filter_var($color_val); ?>; }

/*    .horizontal_box .gt_box_tab .box_tb.active_tab .box_tb_list{background-color: <?php echo filter_var($color_val); ?>;} */
	.extendssubtotalboxes,.gift_box_top .gt_item_lmt .text{color: <?php echo filter_var($price_color); ?>}
	.reset_gt_box svg g{stroke: <?php echo filter_var($price_color); ?> !important}
	.product-type-wooextmm { width:<?php echo filter_var($form_width . '%'); ?>; margin:10px auto; }
	 form.cartt {
		margin-bottom: 1.618em;
		padding: 1em 0;
		}
		form.cartt .quantity {
		float: left;
		margin-right: 0.875em;	 
		}
		</style>
			<?php
		}
	
		if (isset($view['_mm_Outofstocktext']) && '' != $view['_mm_Outofstocktext']) {
			$Outofstocktext = $view['_mm_Outofstocktext'];
		} else {
			$Outofstocktext = 'Out of Stock';
		}

		if (isset($view['_mm_addtocarttext']) && '' != $view['_mm_addtocarttext']) {
			$addtocarttextbutton = $view['_mm_addtocarttext'];
		} else {
			$addtocarttextbutton = esc_html($product->single_add_to_cart_text());
		}

		if (isset($view['_mm_boxheadingmessage']) && '' != $view['_mm_boxheadingmessage']) {
			$_mm_boxheadingmessage = $view['_mm_boxheadingmessage'];
		} else {
			$_mm_boxheadingmessage = esc_html('Add your ' . count($productsmm) . ' favourites to the Box', 'woocommerce');
		}

		if (isset($view['_mm_enabledescription']) && '' != $view['_mm_enabledescription']) {
			$_mm_enabledescription = $view['_mm_enabledescription'];
		}

		if (!empty($view)) {
			if ('fixed' == $pricingType || 'perwithbase' == $pricingType) {
				$productprice = $parentProduct->get_price();
				$productprice = wc_price($productprice);
			} else if ('perwoutbase' == $pricingType) {
				$productprice =  wc_price(0);
			}
			if ('simple' == $view['_mm_layoutstyle_type'] && 'grid' == $view['_mm_template_type']) {
				$mmtemplate = 'single-product/add-to-cart/product-gift-box/front-end/product-box-horizontal-simple.php';
			} else if ('simple' == $view['_mm_layoutstyle_type'] && 'list' == $view['_mm_template_type']) {
				$mmtemplate = 'single-product/add-to-cart/product-gift-box/front-end/product-box-vertical-simple.php';
			} else if ('compressed' == $view['_mm_layoutstyle_type'] && 'grid' == $view['_mm_template_type']) {
				$mmtemplate = 'single-product/add-to-cart/product-gift-box/front-end/product-box-horizontal-compressed.php';
			} else if ('compressed' == $view['_mm_layoutstyle_type'] && 'list' == $view['_mm_template_type']) {
				$mmtemplate = 'single-product/add-to-cart/product-gift-box/front-end/product-box-vertical-compressed.php';
			} 
			
			echo '<h1 class="qodef-woo-product-title product_title entry-title"> ' . filter_var($title) . '</h1>';
			// echo '<p class="price">' . $product->get_price() . '<p>';
			echo '<form class="cartt " action=' . esc_url($product->get_permalink()) . ' method="post" enctype="multipart/form-data">';
			wc_get_template(
				$mmtemplate, array(
				'boxQty' => $boxQty,
				'selectedItems' => $productsmm,
				'add_new_box_quantity' => $add_new_box_quantity,
				'mmPrefilled_enable' => $mmPrefilled_enable,
				'prefileldArray' => $prefileldArray,
				'prefileldArraylength' => count($array),
				'outofstocktextval' => $Outofstocktext,
				'_mm_boxheadingmessage' => $_mm_boxheadingmessage,
				'_mm_enabledescription' => $_mm_enabledescription,
				'product_price' => $productprice,
				'parentProduct' => $parentProduct,
				'addtocarttextbutton' => $addtocarttextbutton,
				'mmGmasgenable' => $mmGmasgenable,
				'mmGmasglabel' => $mmGmasglabel,
				'mmProdLimitEnable' => $mmProdLimitEnable,
				'mmProdLimitQuantity' => $mmProdLimitQuantity,
				'masglabel' => $masglabel,
				'sort_enable'=> $sort_enable,
				),
				'',
				MIXMATCH_BUNDLE_TEMPLATE_PATH . '/' 
			);
			

			if ('simple' == $view['_mm_layoutstyle_type'] && 'grid' == $view['_mm_template_type'] || 'compressed' == $view['_mm_layoutstyle_type'] && 'grid' == $view['_mm_template_type']) {

				if ('yes' == $mmGmasgenable) {
					ob_start();
					?>
					<label><b> <?php echo filter_var($mmGmasglabel); ?></b></label>
					<textarea name="mm_gift_massage" class="mm_gift_massage" id="mm-gmasg" rows="4" cols="5" placeholder="Enter a gift message here"></textarea>
					<input type="hidden" name="mm_gift_massage_lbl" value=' <?php echo filter_var($masglabel); ?> '>


				<?php } ?>
				<div class="extendons_add_to_cart">
				<div class="quantity">
				<label class="screen-reader-text" for="quantity_' <?php echo filter_var($parentProduct->get_id()); ?> '"> <?php esc_attr($parentProduct->get_name()); ?> ' quantity</label>
				<input type="number" id="quantity_' . filter_var($parentProduct->get_id()) . '" class="input-text qty text" step="1" min="1" max="" name="quantity" value="1" title="Qty" size="4" placeholder="" inputmode="numeric" autocomplete="off">
				</div>
				<button disabled="disabled" type="submit" name="add-to-cart" value=" <?php echo esc_attr($parentProduct->get_id()); ?>" class="single_add_to_cart_button button alt extendonssingleaddtocart"><?php echo esc_attr($addtocarttextbutton); ?></button></div><input id="mmperItemPrice" type="hidden" name="mmperItemPrice" value="">
				<input id="mm_product_items" type="hidden" name="mm_product_items" value="">


			<?php	} ?>
			</form>
			
			<?php 
			$html_var = ob_get_clean();

		}
		echo filter_var($html_var);
	}
	
	// public function ext_mb_add_shortcode() {
	//  ob_start();
	//  $this->wooextmm_single_product_summary_callback();
	//  $html_var = ob_get_clean();
	//  return $html_var;

	// }
} 
new MIXMATCH_FRONT_PRODUCT_BUNDLES();
