<?php 
global $woocommerce;
$extendons_custombox_general_settings = get_option('extendons_custombox_general_settings');

?>
<style type="text/css">
	.woocommerce-save-button {
		display: none !important;
	}
</style>
<br class="clear">
<div id="message" class="updated inline generalsuccessmessage"><p><strong>Your settings have been saved.</strong></p></div>
<form method="post" id="mainform" action="" enctype="multipart/form-data">
	<h2><?php echo esc_html__('General Settings', 'extendons-woocommerce-product-boxes'); ?></h2>


	<table class="form-table">

		<tbody>

			<tr valign="top" class="single_select_page _mm_layoutstyle_type">
				<th scope="row" class="titledesc">
					<label for="woocommerce_cart_page_id"><?php echo esc_html__('Select layout style', 'extendons-woocommerce-product-boxes'); ?>
					<span class="tip"><?php echo wc_help_tip('Select template type.'); ?></span>
					</label>
				</th>
				<td class="forminp ">
					
					<select id ='_mm_layoutstyle_type'>
						<option <?php echo selected('simple', $extendons_custombox_general_settings['_mm_layoutstyle_type']); ?> value="simple"><?php echo esc_html__('Compressed', 'extendons-woocommerce-product-boxes'); ?></option>
						<option <?php echo selected('compressed', $extendons_custombox_general_settings['_mm_layoutstyle_type']); ?> value="compressed"><?php echo esc_html__('Detailed', 'extendons-woocommerce-product-boxes'); ?></option>
					</select>
					
					
					

				</td>
			</tr>

			<tr valign="top" class="single_select_page _mm_template_type_field">
				<th scope="row" class="titledesc">
					<label for="woocommerce_cart_page_id"><?php echo esc_html__('View style', 'extendons-woocommerce-product-boxes'); ?>
					<span class="tip"><?php echo wc_help_tip('Select View Style.', 'extendons-woocommerce-product-boxes'); ?></span>
					</label>
				</th>
				<td class="forminp ">
					
					
					<select id ='_mm_template_type'>
						<option <?php echo selected('grid', $extendons_custombox_general_settings['_mm_template_type']); ?> value="grid"><?php echo esc_html__('Grid', 'extendons-woocommerce-product-boxes'); ?></option>
						<option <?php echo selected('list', $extendons_custombox_general_settings['_mm_template_type']); ?> value="list"><?php echo esc_html__('List', 'extendons-woocommerce-product-boxes'); ?></option>
					</select>
				
				</td>
			</tr>
			<?php 
			$hidedesc;
			if ('simple' == $extendons_custombox_general_settings['_mm_layoutstyle_type']) {
				$hidedesc = 'hidden';
			} 
			
			?>

			<tr valign="top" class="single_select_page _mm_template_type_field extboxdesc <?php echo filter_var($hidedesc); ?>">
				<th scope="row" class="titledesc">
					<label for="woocommerce_cart_page_id"><?php echo esc_html__('Enable description', 'extendons-woocommerce-product-boxes'); ?>
					<span class="tip"><?php echo wc_help_tip('Enable product description.'); ?></span>    
					</label>
				</th>
				<td class="forminp ">
					
					<input type="checkbox" <?php checked('yes', $extendons_custombox_general_settings['_mm_enabledescription']); ?> id="_mm_enabledescription" >
					
					

				</td>
			</tr>



			<tr valign="top" class="single_select_page _mm_template_type_field">
				<th scope="row" class="titledesc">
					<label for="woocommerce_cart_page_id"><?php echo esc_html__('Add to cart text', 'extendons-woocommerce-product-boxes'); ?>
					<span class="tip"><?php echo wc_help_tip('Add to cart button Text'); ?></span>        
					</label>
				</th>
				<td class="forminp ">
					<input type="text" value="<?php echo filter_var($extendons_custombox_general_settings['_mm_addtocarttext']); ?>" id ="_mm_addtocarttext" >
				</td>
			</tr>


			<tr>
				<th scope="row" class="titledesc">
					<label for="woocommerce_cart_page_id"><?php echo esc_html__('Heading label', 'extendons-woocommerce-product-boxes'); ?>
					<span class="tip"><?php echo wc_help_tip('Custom Boxes Heading Label'); ?></span>        
					</label>
				</th>
				<td class="forminp ">
					
					<textarea id="_mm_boxheadingmessage" rows="3" cols="4"><?php echo filter_var($extendons_custombox_general_settings['_mm_boxheadingmessage']); ?></textarea>
					

				</td>
			</tr>


		</tbody>
	</table>


	<!-- <h2><?php echo esc_html__('Error Message', 'extendons-woocommerce-product-boxes'); ?></h2> -->
	<table class="form-table">

		<tbody>
			
			<tr>
				<th scope="row" class="titledesc">
					<label for="woocommerce_cart_page_id"><?php echo esc_html__('Out of stock error text message', 'extendons-woocommerce-product-boxes'); ?>
					<span class="tip"><?php echo wc_help_tip('Out of Stock text will show when Product out of stock'); ?></span>            
					</label>
				</th>
				<td class="forminp ">
					
					
					<textarea id="_mm_Outofstocktext" rows="3" cols="4"><?php echo filter_var($extendons_custombox_general_settings['_mm_Outofstocktext']); ?></textarea>


				</td>
			</tr>

		</tbody>
	</table>



	<!-- <h2><?php echo esc_html__('Success message', 'extendons-woocommerce-product-boxes'); ?></h2> -->
	<table class="form-table">

		<tbody>
			
			<tr>
				<th scope="row" class="titledesc">
					<label for="woocommerce_cart_page_id"><?php echo esc_html__('Box success message', 'extendons-woocommerce-product-boxes'); ?>
					<span class="tip"><?php echo wc_help_tip('Box Success Message will show when Box limit Full'); ?></span>    
					</label>
				</th>
				<td class="forminp ">
					
					<textarea id="_mm_boxsuccessmsg" rows="3" cols="4"><?php echo filter_var($extendons_custombox_general_settings['_mm_boxsuccessmsg']); ?></textarea>

				</td>
			</tr>



		</tbody>
	</table>




	<br class="clear">
	<br class="clear">
	<!-- <h2><?php echo esc_html__('Color settings', 'extendons-woocommerce-product-boxes'); ?></h2> -->



	<table class="form-table" data-default_img = "<?php echo esc_url(plugins_url('../templates/single-product/add-to-cart/product-gift-box/front-end/images/upload_icon.png', __FILE__)); ?>" >
		<tbody>
			<tr>
				<th scope="row" class="titledesc">
					<label for="woocommerce_form_width"><?php echo esc_html__('Form width %', 'extendons-woocommerce-product-boxes'); ?>
						<span class="tip"><?php echo wc_help_tip('You can add custom width for Product Bundles form on Product Page'); ?></span>
					</label>

				</th>
				<td class="forminp ">
					
					<input type="number" style="width: 9%;" placeholder="Default 100%" value="<?php echo filter_var($extendons_custombox_general_settings['_mm_form_width'] ?? ''); ?>" id ="_mm_form_width" >


				</td>
			</tr>
			<tr>
				<th scope="row" class="titledesc">
					<label for="woocommerce_cart_page_id"><?php echo esc_html__('Background color', 'extendons-woocommerce-product-boxes'); ?></label>
				</th>
				<td class="forminp ">
					
					<input type="color" value="<?php echo filter_var($extendons_custombox_general_settings['_mm_color_backgroundcolor']); ?>" id ="_mm_color_backgroundcolor" >


				</td>
			</tr>

			<tr>
				<th scope="row" class="titledesc">
					<label for="ext_primary_color"><?php echo esc_html__('Primary color', 'extendons-woocommerce-product-boxes'); ?></label>
				</th>
				<td class="forminp ">
					<?php $color = $extendons_custombox_general_settings['_mm_color_primarycolor'] ?? '#995E8E'; ?>
					<input type="color" value="<?php echo filter_var($color); ?>" id ="_mm_color_primarycolor" >


				</td>
			</tr>

			<tr>
				<th scope="row" class="titledesc">
					<label for="ext_primary_color"><?php echo esc_html__('Price label', 'extendons-woocommerce-product-boxes'); ?></label>
				</th>
				<td class="forminp ">
					<?php $price_color = $extendons_custombox_general_settings['_mm_color_pricecolor'] ?? '#6d6d6d'; ?>
					<input type="color" value="<?php echo filter_var($price_color); ?>" id ="_mm_color_pricecolor" >


				</td>
			</tr>


			<!-- <tr valign="top" class="">
					<?php 
					$custom_image = 'no';
					?>
						<th scope="row" class="titledesc"><?php echo filter_var(__('Box image placeholder', 'extendons-woocommerce-product-boxes')); ?></th>
							<td class="forminp forminp-checkbox ">
								<fieldset>
									<legend class="screen-reader-text"><span><?php echo filter_var(__('Enable schema', 'extendons-woocommerce-product-boxes')); ?></span></legend>
										<label for="book_sch_enable">
											<input type="checkbox" name="custom_box_image" id="custom_box_image" class="custom_box_image" <?php checked('yes', $custom_image); ?>>    
											<?php echo filter_var(__('Enable custom placeholder.', 'extendons-woocommerce-product-boxes')); ?>                            
										</label>
										<p class="description"><?php echo filter_var(__('Enables to add custom image placeholder for product bundles.', 'extendons-woocommerce-product-boxes')); ?></p>                                                             
								</fieldset>
							</td>
						</tr> -->

				<tr valign="top">
							<th scope="row" class="titledesc">
								<label for="cb_image_placeholder"><?php echo filter_var(__('Image placeholder', 'extendons-woocommerce-product-boxes')); ?><span class="woocommerce-help-tip" tabindex="0" data-tip="<?php echo filter_var(__('You can upload custom image for empty box placeholder. Otherwise default will be applied', 'extendons-woocommerce-product-boxes')); ?>"></span>
								</label>
							</th>
							<td class="forminp forminp-text">
								<?php
									$src = $extendons_custombox_general_settings['_mm_image_placeholder'] ?? '';
								if (''==$src) {

									$src=plugins_url('../templates/single-product/add-to-cart/product-gift-box/front-end/images/upload_icon.png', __FILE__);
									$val='';
								} else {
									$val = $src;
								}
									 
									/**********
* If value of hidden input field is empty hides remove button
******/
								if (''==$val) {
									$hidden='hidden';  
								} else {
									$hidden='';
								} 
								?>

									<img style="height: 95px; width: 100px; margin-bottom: -12px"  src="<?php echo ( esc_attr($src) ); ?>" name="fme-cpffw-field-option-image[]" class="form-control form-control-sm name_list radio_option_images_rs" />

									<p <?php echo ( esc_html($hidden) ); ?> style="margin: 2px;" class="remove_button" ><button class="button-primary remove_image_rs"><?php echo esc_html__('Remove Image', 'extendons-woocommerce-product-boxes'); ?></button></p>            

									<input name="box_ph_image_val" hidden value="<?php echo ( esc_attr($val) ); ?>" accept="image/png, image/jpeg" >                         
							</td>
						</tr>        
		</tbody>
	</table>
	<br class="clear">
	<button name="save" class="button-primary extendons-save_generalsettings" type="button" value="Save changes">Save changes</button>

