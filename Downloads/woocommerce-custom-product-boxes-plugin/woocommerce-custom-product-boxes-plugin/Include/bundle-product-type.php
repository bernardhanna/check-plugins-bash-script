<?php
/**
 * Bundle Product Type file.
 *
 * @package Woocommercecustomproductboxesplugin
 * @link    https://woocommerce.com/products/woocommerce-custom-product-boxes-plugin
 */

if (!defined('ABSPATH')) { 
	exit; // Exit if accessed directly
}

/**
 * WC_Product_Wooextmm class
 *
 * The class holding the definations of bundle product type
 *
 * @package Woocommercecustomproductboxesplugin
 * @link    https://woocommerce.com/products/woocommerce-custom-product-boxes-plugin
 */
class WC_Product_Wooextmm extends WC_Product {


	/**
	 * Constructor
	 *
	 * @param array $product product array.
	 *
	 * @return array product array
	 */
	public function __construct( $product ) {

		$this->product_type = 'wooextmm';

		parent::__construct($product);
	}

	/**
	 * Custom product type
	 *
	 * @return string product type
	 */
	public function getType() {
		return 'wooextmm';
	}

	/**
	 * Add to cart text
	 *
	 * @return string add to cart text
	 */
	public function addToCartText() {
		$text = $this->is_purchasable() && $this->is_in_stock() ? __('View Products', 'extendons-woocommerce-product-boxess') : __('Read More', 'extendons-woocommerce-product-boxess');
		return apply_filters('mix_match_box_product_add_to_cart_text', $text, $this);
	}

	/**
	 * Add to cart text
	 *
	 * @return string add to cart text
	 */
	public function singleAddtoCartText() {
		return apply_filters('mix_match_box_product_single_add_to_cart_text', __('Add to cart', 'extendons-woocommerce-product-boxess'), $this);
	}
}
