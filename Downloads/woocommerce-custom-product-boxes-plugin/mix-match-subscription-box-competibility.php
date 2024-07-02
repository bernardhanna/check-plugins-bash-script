<?php 

if (!defined('ABSPATH')) {
	exit; // Exit if accessed directly.
}
if (! function_exists('is_plugin_active')) {
	include_once ABSPATH . 'wp-admin/includes/plugin.php' ;
}
if (!class_exists('MixMatch_Compatible_Class_WCSubscription')) {
	
	class MixMatch_Compatible_Class_WCSubscription {
	
		
		public function __construct() {
			
			// check for plugin we need for acitive this compatibility
			$active_plugins = get_option('active_plugins');
			// print_r($active_plugins);
			if (is_plugin_active('woocommerce/woocommerce.php') && is_plugin_active('woocommerce-subscriptions/woocommerce-subscriptions.php') ) {
				$this->include_compatible_class();
			}
		


			// if (in_array( 'woocommerce-subscriptions/woocommerce-subscriptions.php', apply_filters('active_plugins', $active_plugins)) && 
			//  in_array( 'woocommerce/woocommerce.php', apply_filters( 'active_plugins', $active_plugins)) && 
			//  in_array( 'extendons-woocommerce-product-boxes/extendons-woocommerce-product-boxes.php', apply_filters( 'active_plugins', $active_plugins))) {
				
			//  // include file with make compatible  
			//  $this->include_compatible_class();

			// }
		}
		
		public function include_compatible_class() {

			include_once MIXMATCH_BUNDLES_DIR . '/Include/mm-wcsubscription-compatible.php';
		}
	}
	
	new MixMatch_Compatible_Class_WCSubscription();
}
