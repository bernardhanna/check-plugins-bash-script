<?php 

if (! defined('ABSPATH') ) {
	exit; // Exit if accessed directly.
}

class MIXMATCH_ADMIN_PRODUCT_BUNDLES extends EXTENDONS_MIXMATCH_PRODUCT_BUNDLES {


	public function __construct() {
	
		add_action('admin_enqueue_scripts', array( $this, 'wooextmm_enqueue_admin_scripts' ));

		add_action('plugins_loaded', array( $this, 'wooextmm_mixmatch_product_type' ));

		add_filter('woocommerce_product_data_tabs', array( $this, 'wooextmm_product_data_tabs' ));

		add_filter('product_type_selector', array( $this, 'wooextmm_product_type_selector' ));

		add_action('woocommerce_product_data_panels', array( $this, 'wooextmm_product_data_panels' ));

		add_action('woocommerce_process_product_meta', array( $this, 'wooextmm_save_product_field' ));

		add_filter('woocommerce_settings_tabs_array', array( $this, 'extendons_settings_tabs_array' ), 50);//admin   
		add_action('woocommerce_settings_extenons-customboxes-tab', array( $this, 'extendons_general_admin_settings' )); //admin

		add_action('wp_ajax_extendons_save_general_settings', array( $this, 'extendons_save_general_settings' ));
		add_action('wp_ajax_nopriv_extendons_save_general_settings', array( $this, 'extendons_save_general_settings' ));

		add_action('wp_ajax_extendons_pd_addon_popup', array( $this, 'extendons_pd_addon_popup' ));
		add_action('wp_ajax_nopriv_extendons_pd_addon_popup', array( $this, 'extendons_pd_addon_popup' ));
	}

	public function extendons_pd_addon_popup() {
		$dataproid = isset($_REQUEST['dataproid']) ? filter_var($_REQUEST['dataproid']) : '';
		$itemQty = isset($_REQUEST['itemQty']) ? filter_var($_REQUEST['itemQty']) : '';

		if ('' != $dataproid) {
			$product = wc_get_product($dataproid);
			$image_url = wp_get_attachment_image_src(get_post_thumbnail_id($product->get_id()), 'single-post-thumbnail');
			if (!empty($image_url)) {
				$image_url = $image_url[0];
			} else {
				$size = 'woocommerce_thumbnail';
				$src = WC()->plugin_url() . '/assets/images/placeholder.png';
				$placeholder_image = get_option('woocommerce_placeholder_image', 0);
				if (! empty($placeholder_image) ) {
					if (is_numeric($placeholder_image) ) {
						$image = wp_get_attachment_image_src($placeholder_image, $size);

						if (! empty($image[0]) ) {
							$src = $image[0];
						}
					} else {
						$src = $placeholder_image;
					}
				}
				$image_url = $src;
			}
			?>
			<div class="pop_container">
				<div class="pop_inner">
					<div class="add_on_popup_close">
						<img src="<?php echo esc_url(plugin_dir_url(__FILE__)); ?>templates/single-product/add-to-cart/product-gift-box/front-end/images/pop-up_close.png" alt="">
					</div>
					<div class="pd_box_list">
						<div class="pd_add_block">
							<div class="pd_add_block_inner" style="display:block;">
								<div class="pod_right_block">
									<div class="image_block">
										<img width="100" src="<?php echo esc_url($image_url); ?>" alt="">
									</div>
								</div>
								<div class="pd_dtl" style="display: flow-root;">
									<h2 class="pd_title"><a href="<?php echo esc_url(get_permalink($product->get_id())); ?>"><?php echo filter_var($product->get_name()); ?></a></h2>
									 <span class="pd_price"><span class="price">
			<?php echo filter_var($product->get_price_html()); ?>
									</span></span>
									<p class="addon_pd_dtl"><?php echo filter_var($product->get_description()); ?></p>
			<?php 
			$_manage_stock = get_post_meta($product->get_id(), '_manage_stock', true);
			if ('yes' == $_manage_stock) {
				?>
										<p class="stock in-stock"><?php echo filter_var($product->get_stock_quantity()); ?> in stock
										</p>
				<?php
			}
			?>

									<div class="pd_addon_btns">

										<div class="addon_qty" style="display:flex;margin:inherit;">
											<a href="#" data-id="<?php echo filter_var($product->get_id()); ?>" class="qty_control minus extendonsfilledboxesremove"></a>
											<span class="value extendonsqtytext popupqty<?php echo filter_var($product->get_id()); ?>" id="<?php echo filter_var($product->get_id()); ?>">
												<?php echo filter_var($itemQty); ?>
											</span>
											<a href="#" class="qty_control plus add_cta" data-id="<?php echo filter_var($product->get_id()); ?>">
											</a>
										</div>    
									</div>
																									  
								</div>
							</div>
						</div>            
					</div>
				</div>

			</div>
			<?php

		}
		wp_die();
	}



	public function extendons_save_general_settings() {

		$_mm_layoutstyle_type = isset($_REQUEST['_mm_layoutstyle_type']) ? filter_var($_REQUEST['_mm_layoutstyle_type']) : '';
		$_mm_template_type = isset($_REQUEST['_mm_template_type']) ? filter_var($_REQUEST['_mm_template_type']) : '';
		
	
		$_mm_enabledescription = isset($_REQUEST['_mm_enabledescription']) ? filter_var($_REQUEST['_mm_enabledescription']) : '';
		
		$_mm_addtocarttext = isset($_REQUEST['_mm_addtocarttext']) ? filter_var($_REQUEST['_mm_addtocarttext']) : '';

		$_mm_boxheadingmessage = isset($_REQUEST['_mm_boxheadingmessage']) ? filter_var($_REQUEST['_mm_boxheadingmessage']) : '';
		
		$_mm_Outofstocktext = isset($_REQUEST['_mm_Outofstocktext']) ? filter_var($_REQUEST['_mm_Outofstocktext']) : '';
		$_mm_boxsuccessmsg = isset($_REQUEST['_mm_boxsuccessmsg']) ? filter_var($_REQUEST['_mm_boxsuccessmsg']) : '';

		$_mm_color_backgroundcolor = isset($_REQUEST['_mm_color_backgroundcolor']) ? filter_var($_REQUEST['_mm_color_backgroundcolor']) : '';
		$_mm_color_primarycolor = isset($_REQUEST['_mm_color_primarycolor']) ? filter_var($_REQUEST['_mm_color_primarycolor']) : '';
		
		$_mm_color_pricecolor =  isset($_REQUEST['_mm_color_pricecolor']) ? filter_var($_REQUEST['_mm_color_pricecolor']) : '';

		$_mm_image_placeholder = isset($_REQUEST['_mm_image_placeholder']) ? filter_var($_REQUEST['_mm_image_placeholder']) : '';
		$_mm_form_width = isset($_REQUEST['_mm_form_width']) ? filter_var($_REQUEST['_mm_form_width']) : '';
		
		$extgeneralsetting = array(

		'_mm_layoutstyle_type' => $_mm_layoutstyle_type,
		'_mm_template_type'  => $_mm_template_type,
		'_mm_enabledescription' => $_mm_enabledescription, 
		'_mm_addtocarttext' => $_mm_addtocarttext, 
		'_mm_boxheadingmessage' => $_mm_boxheadingmessage,
		'_mm_Outofstocktext' => $_mm_Outofstocktext,   
		'_mm_boxsuccessmsg' => $_mm_boxsuccessmsg, 
		'_mm_color_backgroundcolor' => $_mm_color_backgroundcolor,
		'_mm_image_placeholder' => $_mm_image_placeholder,
		'_mm_color_primarycolor'=> $_mm_color_primarycolor,
		'_mm_color_pricecolor' =>$_mm_color_pricecolor,
		'_mm_form_width' => $_mm_form_width,

		);

		update_option('extendons_custombox_general_settings', $extgeneralsetting);
		wp_die();
	}

	public function extendons_settings_tabs_array( $tabs ) {
		$tabs['extenons-customboxes-tab'] = __('Custom Boxes', 'extendons-woocommerce-product-boxes');
		return $tabs;
	}

	public function extendons_general_admin_settings() {

		include_once MIXMATCH_BUNDLES_DIR . 'Include/general_settings.php' ;    
	}



	public function wooextmm_mixmatch_product_type() {

		include_once MIXMATCH_BUNDLES_DIR . 'Include/bundle-product-type.php' ;    
	}

	public function wooextmm_product_data_tabs( $tabs ) {
		
		$tabs['wooextmm'] = array(
		'label'  => esc_html__('Product Boxes', 'extendons-woocommerce-product-boxes'),
		'target' => 'wooextmm_settings',
		'class'  => array( 'show_if_wooextmm' ),
		);

		return $tabs;
	}

	public function wooextmm_product_type_selector( $types ) {
		
		$types['wooextmm'] = esc_html__('Custom Product Boxes', 'extendons-woocommerce-product-boxes');

		return $types;
	}

	public function wooextmm_product_data_panels() {
			
		global $post; 

		$query_args = array(
		'post_status' => 'publish',
		'ignore_sticky_posts' => 1,
		'posts_per_page' => -1,
		'orderby' => 'title',
		'order' => 'ASC',
		'post_type' => array( 'product', 'product_variation' ),
		);

		$allProducts = get_posts($query_args); 

		$savePro = get_post_meta($post->ID, '_mm_add_products', true); 
		?>
		
		<div id="wooextmm_settings" class="panel woocommerce_options_panel">
			
			<div class="main-setting-mix-match">
				
		<?php 

		woocommerce_wp_checkbox(
			array(
			'id' => '_mm_sort_enable_box',
			'label' => esc_html__('Enable/Disable', 'extendons-woocommerce-product-boxes'),
			'desc_tip' => 'true',
			'description' => esc_html__('Enable the button to make it a product box.', 'extendons-woocommerce-product-boxes'),
			'value' => get_post_meta($post->ID, '_mm_sort_enable_box', true),
			)
		);

					woocommerce_wp_select(
						array(
						'id' => '_mm_pricing_type',
						'label' => esc_html__('Pricing Type', 'extendons-woocommerce-product-boxes'),
						'desc_tip'      => 'true',
						'description'   => esc_html__('Select Pricing Type', 'extendons-woocommerce-product-boxes'),
						'options' => array( 
							'fixed' => esc_html__('Fixed Pricing', 'extendons-woocommerce-product-boxes'),
							'perwithbase' => esc_html__('Per Item Price With Base Price', 'extendons-woocommerce-product-boxes'),
							'perwoutbase' => esc_html__('Per Item Price Without Base Price', 'extendons-woocommerce-product-boxes'),
						),
						'value' => get_post_meta($post->ID, '_mm_pricing_type', true),
						)
					); 

					woocommerce_wp_text_input(
						array(
						'id' => '_mm_box_quantity',
						'label' => esc_html__('Box Quantity', 'extendons-woocommerce-product-boxes'),
						'type' => 'number',
						'desc_tip'      => 'true',
						'placeholder'   => 'Default 5!',
						'description'   => esc_html__('Enter the number of item which can be added to box, if left empty, 5 box quantity will be set by default.', 'extendons-woocommerce-product-boxes'),
						'value' => get_post_meta($post->ID, '_mm_box_quantity', true),
						)
					);
			
					woocommerce_wp_checkbox(
						array(
						'id' => '_mm_partialy_filled_layout',
						'label' => esc_html__('Allow Partially-Filled Box', 'extendons-woocommerce-product-boxes'),
						'desc_tip'      => 'true',
						'description'   => esc_html__('Allow the purchase of box which has not been filled to its full capacity', 'extendons-woocommerce-product-boxes'),
						'value' => get_post_meta($post->ID, '_mm_partialy_filled_layout', true),
						)
					);

					woocommerce_wp_text_input(
						array(
						'id' => '_mm_boxmin_qty_allow',
						'label' => esc_html__('Minimum Allowed', 'extendons-woocommerce-product-boxes'),
						'desc_tip'      => 'true',
						'type' => 'number',
						'custom_attributes' => array(
							'step'  => 'any',
							'min'   => '1',  
						), 
						'description'   => esc_html__('Set the minimum box quantity to be allowed', 'extendons-woocommerce-product-boxes'),
						'value' => get_post_meta($post->ID, '_mm_boxmin_qty_allow', true),
						)
					); 

					woocommerce_wp_checkbox(
						array(
						'id' => '_mm_sort_product_date',
						'label' => esc_html__('Sort Products by Date', 'extendons-woocommerce-product-boxes'),
						'desc_tip' => 'true',
						'description' => esc_html__('Adds newly added product to the top', 'extendons-woocommerce-product-boxes'),
						'value' => get_post_meta($post->ID, '_mm_sort_product_date', true),
						)
					);

					// for subscription plugin compatibility meta if enable and plugin exist
					// do_action('mm_subscription_product_meta');

					woocommerce_wp_checkbox(
						array(
						'id' => '_mm_enable_gift_masg',
						'label' => esc_html__('Enable Gift Message', 'extendons-woocommerce-product-boxes'),
						'desc_tip'      => 'true',
						'description'   => esc_html__('Allows Customers to send a message along with the Gift Box', 'extendons-woocommerce-product-boxes'),
						'value' => get_post_meta($post->ID, '_mm_enable_gift_masg', true),
						)
					);



					woocommerce_wp_text_input(
						array(
						'id' => '_mm_gift_masg_label',
						'label' => esc_html__('Gift Message Label', 'extendons-woocommerce-product-boxes'),
						'desc_tip'      => 'true',
						'type' => 'text',
						'description'   => esc_html__('Set a label for Gift Message field', 'extendons-woocommerce-product-boxes'),
						'value' => get_post_meta($post->ID, '_mm_gift_masg_label', true),
						)
					);

					woocommerce_wp_checkbox(
						array(
						'id' => '_mm_enable_limit_per_prod',
						'label' => esc_html__('Enable Per Product Limit', 'extendons-woocommerce-product-boxes'),
						'desc_tip'      => 'true',
						'description'   => esc_html__('Restrict customers to a limit for identical products.', 'extendons-woocommerce-product-boxes'),
						'value' => get_post_meta($post->ID, '_mm_enable_limit_per_prod', true),
						)
					);



					woocommerce_wp_text_input(
						array(
						'id' => '_mm_limit_per_prod_quanity',
						'label' => esc_html__('Enter limit per product', 'extendons-woocommerce-product-boxes'),
						'desc_tip'      => 'true',
						'type' => 'number',
						'description'   => esc_html__('Set a limit that restrict customers not to add same product more than this limit.', 'extendons-woocommerce-product-boxes'),
						'value' => get_post_meta($post->ID, '_mm_limit_per_prod_quanity', true),
						)
					); 
					
					woocommerce_wp_checkbox(
						array(
						'id' => '_mm_add_new_boxes',
						'label' => esc_html__('Enable New Box Quantity', 'extendons-woocommerce-product-boxes'),
						'desc_tip'      => 'true',
						'description'   => esc_html__('Allow Customers to Add Box Quantity', 'extendons-woocommerce-product-boxes'),
						'value' => get_post_meta($post->ID, '_mm_add_new_boxes', true),
						)
					);

		?>
					

					<hr>
					<div class="mm_addons_notes">
						<h4><?php echo esc_html__('IMPORTANT NOTE:', 'extendons-woocommerce-product-boxes'); ?></h4>
						<ul>
							<li>
								<?php echo esc_html__('Variable Product can be added with separate variations.', 'extendons-woocommerce-product-boxes'); ?>        
							</li>
							<li>
								<?php echo esc_html__('For prefilled products add quantity that is available in stock.', 'extendons-woocommerce-product-boxes'); ?>
							</li>
							<li>
								<?php echo esc_html__('If you can update the individual product you must update the Add-On Products again.', 'extendons-woocommerce-product-boxes'); ?>
							</li>
						</ul>
					</div>

		<?php if ($allProducts) { ?>
						<p class="form-field _mm_add_products_field ">
							<label for="_mm_add_products"><?php echo esc_html__('Add-On Products', 'extendons-woocommerce-product-boxes'); ?></label>
							<select multiple="" class="form-control" id="_mm_add_products" name="_mm_add_products[]">
			<?php foreach ( $allProducts as $product ) { ?> 
				<?php if (is_array($savePro)) { ?>
										<option value="<?php echo filter_var($product->ID); ?>" 
					<?php  
					if (in_array($product->ID, $savePro)) {
						echo 'selected'; 
					}  
					?>
											>
					<?php echo filter_var($product->post_title); ?>        
										</option>
				<?php } else { ?>
									<option value="<?php echo filter_var($product->ID); ?>" <?php echo selected($product->ID, $savePro); ?>>
					<?php echo filter_var($product->post_title); ?>
									</option>
				<?php 
				} 
			} 
			?>
							</select>
						</p>
			<?php  
		} else { 
			echo esc_html__('No Products Found', 'extendons-woocommerce-product-boxes'); 
		}   


		woocommerce_wp_checkbox(
			array(
			'id' => '_mm_enable_prefiled',
			'label' => esc_html__('Pre-Filled Box', 'extendons-woocommerce-product-boxes'),
			'desc_tip'      => 'true',
			'description'   => esc_html__('Allow pre-filled box', 'extendons-woocommerce-product-boxes'),
			'value' => get_post_meta($post->ID, '_mm_enable_prefiled', true),
			)
		); 

		// render all saved product items
		$query_args = array(
		 'post__in' => $savePro,
		 'post_status' => 'publish',
		 'orderby' => 'title',
		 'order' => 'ASC',
		 'post_type' => array( 'product', 'product_variation' ),
		 );

		$allProductsMM = get_posts($query_args); 
		?>

					<p class="form-field mm_mandatory_items_wrapper">
						<label class="search-wooextb-label" for="mm_render_prefilled_products">
							<strong><?php esc_html_e('Select Products', 'product-bundles-extendons'); ?></strong>
						</label>
						<select id="mm_render_prefilled_products" class="select">
		  <?php if (!empty($savePro)) { ?>
				<?php foreach ( $allProductsMM as $product ) { ?> 
								<option value="<?php echo esc_attr($product->ID); ?>">
					<?php echo esc_attr($product->post_title); ?>      
								</option>
				<?php 
				} 
		  } 
			?>
						</select>
						<button type="button" id="mm_pre_fillder_items_btn" class="button button-primary button-large"><?php esc_html_e('Add New Prefilled', 'extendons-woocommerce-product-boxes'); ?></button>
						<input type="hidden" id="mm_current_id" value="<?php echo esc_attr($post->ID); ?>">
					</p>
					
		<?php 
		$prefilled_items_data = get_post_meta($post->ID, '_mm_prefilled_product', true);
		$box_quatity = get_post_meta($post->ID, '_mm_box_quantity', true);
		//var_dump($prefilled_items_data);
		include_once MIXMATCH_BUNDLES_DIR . 'Include/prefilled-template.php'; 
		?>

			</div>

		</div>

		<?php 
	}

	public function wooextmm_save_product_field( $post_id ) {

		if (!empty($_REQUEST['ext_mix_nonce_field'])) {

			$retrieved_nonce = sanitize_text_field($_REQUEST['ext_mix_nonce_field']);
		} else {
			$retrieved_nonce = 0;
		}
		
		if (wp_verify_nonce($retrieved_nonce, 'ext_mix_nonce_action')) {

			die('Failed security check');
		}

		$product = wc_get_product($post_id);

		if (!$product ) {
			return;
		}
		//echo '<pre>';print_r($_POST);exit;
		$_mm_custombox_checkbox = isset($_POST[ '_mm_sort_enable_box' ]) ? sanitize_text_field($_POST[ '_mm_sort_enable_box' ]) : false;
		update_post_meta($post_id, '_mm_sort_enable_box', sanitize_text_field($_mm_custombox_checkbox));

		$_mm_pricing_type = isset($_POST[ '_mm_pricing_type' ]) ? sanitize_text_field($_POST[ '_mm_pricing_type' ]) : false;
		update_post_meta($post_id, '_mm_pricing_type', sanitize_text_field($_mm_pricing_type));

		$_mm_box_quantity = isset($_POST[ '_mm_box_quantity' ]) ? sanitize_text_field($_POST[ '_mm_box_quantity' ]) : false;

		if (!isset($_mm_box_quantity) || empty($_mm_box_quantity)) {
			$_mm_box_quantity = 5;
		}
		update_post_meta($post_id, '_mm_box_quantity', sanitize_text_field($_mm_box_quantity));

		$_mm_select_box_type = isset($_POST[ '_mm_select_box_type' ]) ? sanitize_text_field($_POST[ '_mm_select_box_type' ]) : false;
		update_post_meta($post_id, '_mm_select_box_type', sanitize_text_field($_mm_select_box_type));

		$_mm_column_box_gift = isset($_POST[ '_mm_column_box_gift' ]) ? sanitize_text_field($_POST[ '_mm_column_box_gift' ]) : false;
		update_post_meta($post_id, '_mm_column_box_gift', sanitize_text_field($_mm_column_box_gift));

		$_mm_color_box_gift = isset($_POST[ '_mm_color_box_gift' ]) ? sanitize_text_field($_POST[ '_mm_color_box_gift' ]) : false;
		update_post_meta($post_id, '_mm_color_box_gift', sanitize_text_field($_mm_color_box_gift));

		$_mm_column_product_layout = isset($_POST[ '_mm_column_product_layout' ]) ? sanitize_text_field($_POST[ '_mm_column_product_layout' ]) : false;
		update_post_meta($post_id, '_mm_column_product_layout', sanitize_text_field($_mm_column_product_layout));

		$_mm_partialy_filled_layout = isset($_POST[ '_mm_partialy_filled_layout' ]) ? 'yes' : 'no';
		update_post_meta($post_id, '_mm_partialy_filled_layout', sanitize_text_field($_mm_partialy_filled_layout));

		$_mm_boxmin_qty_allow = isset($_POST[ '_mm_boxmin_qty_allow' ]) ? sanitize_text_field($_POST[ '_mm_boxmin_qty_allow' ]) : false;
		update_post_meta($post_id, '_mm_boxmin_qty_allow', sanitize_text_field($_mm_boxmin_qty_allow));

		$_mm_sort_product_date = isset($_POST[ '_mm_sort_product_date' ]) ? 'yes' : 'no';
		update_post_meta($post_id, '_mm_sort_product_date', sanitize_text_field($_mm_sort_product_date));

		// $_mm_allow_scroll_lock = isset( $_POST[ '_mm_allow_scroll_lock' ] ) ? 'yes' : 'no';
		// update_post_meta( $post_id, '_mm_allow_scroll_lock', sanitize_text_field($_mm_allow_scroll_lock ));

		$_mm_enable_gift_masg = isset($_POST[ '_mm_enable_gift_masg' ]) ? 'yes' : 'no';
		update_post_meta($post_id, '_mm_enable_gift_masg', sanitize_text_field($_mm_enable_gift_masg));

		$_mm_gift_masg_label = isset($_POST[ '_mm_gift_masg_label' ]) ? sanitize_text_field($_POST[ '_mm_gift_masg_label' ]) : false;
		update_post_meta($post_id, '_mm_gift_masg_label', sanitize_text_field($_mm_gift_masg_label));

		$_mm_enable_limit_per_prod = isset($_POST[ '_mm_enable_limit_per_prod' ]) ? 'yes' : 'no';
		update_post_meta($post_id, '_mm_enable_limit_per_prod', sanitize_text_field($_mm_enable_limit_per_prod));

		$_mm_limit_per_prod_quanity = isset($_POST[ '_mm_limit_per_prod_quanity' ]) ? sanitize_text_field($_POST[ '_mm_limit_per_prod_quanity' ]) : false;
		update_post_meta($post_id, '_mm_limit_per_prod_quanity', sanitize_text_field($_mm_limit_per_prod_quanity));
		
		$_mm_add_products = isset($_POST[ '_mm_add_products' ]) ? sanitize_meta('', $_POST[ '_mm_add_products' ], '') : false;
		update_post_meta($post_id, '_mm_add_products', $_mm_add_products);

		$_mm_enable_prefiled = isset($_POST[ '_mm_enable_prefiled' ]) ? 'yes' : 'no';
		update_post_meta($post_id, '_mm_enable_prefiled', sanitize_text_field($_mm_enable_prefiled));
		$_mm_add_new_boxes = isset($_POST[ '_mm_add_new_boxes' ]) ? 'yes' : 'no';
		update_post_meta($post_id, '_mm_add_new_boxes', sanitize_text_field($_mm_add_new_boxes));



		// prefilled
		
		$actualArray = array();
		$new_array_to_be_push = array();
		if (isset($_POST['_mm_prefilled_product'])) {

			$_mm_prefilled = isset($_REQUEST['_mm_prefilled_product']) ? map_deep(wp_unslash($_REQUEST['_mm_prefilled_product']), 'sanitize_text_field'): array();

			foreach ( $_mm_prefilled as $key => $value ) {
				if ($value['pre_qty'] > 1 ) {
					for ( $i = 0; $i < $value['pre_qty']; $i++ ) { 
						$new_array_to_be_push[] = $value;
					}
				} else {
					$new_array_to_be_push[] = $value;
				}
			}
	
			$_mm_prefilled_index = array_values($_mm_prefilled);
			$tempArray           = array_unique(array_column($_mm_prefilled_index, 'product_id'));

			$actualArray         = array_intersect_key($_mm_prefilled_index, $_mm_prefilled_index);
			$actualArray[0]['_mm_box_quantity'] = $_mm_box_quantity;

		}
		update_post_meta($post_id, '_mm_prefilled_product_front', $new_array_to_be_push);
		update_post_meta($post_id, '_mm_prefilled_product', $actualArray);
		update_option('save_template', $_mm_template_type);
	}

	public function wooextmm_enqueue_admin_scripts() {

		wp_enqueue_script('jquery');
		wp_enqueue_media();
		wp_enqueue_style('wooextmm-admin-css', plugins_url('assets/css/backend.css', __FILE__), false, '1.0.0');
		wp_enqueue_script('spectrum-script', plugins_url('assets/js/spectrum.min.js', __FILE__), false, '1.0.0');
		wp_enqueue_style('spectrum-style', plugins_url('assets/css/spectrum.min.css', __FILE__), false, '1.0.0');
		wp_enqueue_script('wooextmm-admin-js', plugins_url('assets/js/mmadmin.js', __FILE__), false, '1.0.0');
		wp_localize_script(
			'wooextmm-admin-js', 'mm_varf', array(
			'mm_nonce'    => wp_create_nonce('mm_nonce'),
			'ajax_url'    => admin_url('admin-ajax.php'),
			'add_icon'    => MIXMATCH_BUNDLES_URL . 'assets/images/delete-row.png',
			'remove_icon' => MIXMATCH_BUNDLES_URL . 'assets/images/add-row.png',
			)
		);

		wp_enqueue_script('select2-script', plugins_url('assets/js/select2.min.js', __FILE__), false, '1.0.0');

		wp_enqueue_style('select2-style', plugins_url('assets/css/select2.min.css', __FILE__), false, '1.0.0');
	}
} 

new MIXMATCH_ADMIN_PRODUCT_BUNDLES();

?>
