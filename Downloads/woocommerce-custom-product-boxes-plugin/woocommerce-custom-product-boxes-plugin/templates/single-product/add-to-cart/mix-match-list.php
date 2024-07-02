<?php
/**
 * Mix & Match Single Template
 */
if (! defined('ABSPATH') ) {
	exit;
}
global $product;
$parentPrice = wc_get_product($product->get_id());
$parentProductPrice = $parentPrice->get_price();

$arrayData = json_decode($mmdata);
if (!empty($arrayData->box_pricing) && 'perwoutbase' == $arrayData->box_pricing  ) {
	$parentPrices = '0';
} else {
	$parentPrices = $parentProductPrice;
}
?>
<form class="cart pc_add_to_cart_form" action="<?php echo esc_url(apply_filters('woocommerce_add_to_cart_form_action', $product->get_permalink())); ?>" method="post" enctype='multipart/form-data'>
	<input type="hidden" name="add_new_box" id="add_new_boxes" value="<?php echo esc_attr($arrayData->add_new_box); ?>">    
	<div class="mix_match_product_container_list bootstrap-iso">
		<div class="mix_match_container_wrap_list">
			<div class="row">
						<div class="col-sm-12 col-md-6">
							
							<!-- <div id="add_new_boxlist"><button class="btn btn-outline-dark" type="button">Add Box Quantity</button></div> -->
						
						</div>
					</div>
			<div class="row">

				<div class="col-md-12">
					
					<div class="alert alert-danger" id="mmlist_error">
						<p>
							<?php echo esc_html__('Maximum Stack Is full please remove some to add this one!', 'extendons-mix-match-bundle'); ?>
						</p>
					</div>
					<div class="alert alert-success" id="mm_sucess">
					<p><?php echo esc_html__('Quantity will increased you can add more items!', 'extendons-mix-match-bundle'); ?></p>
					</div>

					<?php

					if ('yes'==$arrayData->add_new_box) {

						?>
							<input type="hidden" name="boxcount" id="boxcount" value="">
							<input type="hidden" name="boxQty" id="boxQty" value="<?php echo esc_attr($arrayData->boxqty); ?>">
							<div id="addcollapse">
							<button type="button" class="btn btn-basic" name="demo" id="collapsebox" data-toggle="collapse" data-target="#demo">Box 1 </button>
							<div class="collapse" id="demo">
							<div class="mm_list_product_wrap" id="col12">
								
								<input type="hidden" id="listmm" name="listmm" value=<?php echo json_encode($mixmatch_items); ?>>
						<?php 
						foreach ($mixmatch_items as $key => $value) {
							$_product = wc_get_product($value); 
							?>
							<div class="row">
								<div class="col-md-4">
									<div class="mm_list_image">
										 <img id="mm_product_image<?php echo esc_attr($value); ?>" src="<?php echo esc_url(get_the_post_thumbnail_url($value)); ?>">
									</div>
								</div>
								<div class="col-md-4">
									<div class="mm_list_name">
										<a id="listval<?php echo esc_attr($value); ?>" href="<?php echo esc_url(get_the_permalink($value)); ?>" target="_blank">
											<input type="hidden" name="titlelist" id="listtitle<?php echo esc_attr($value); ?>" value="<?php echo esc_attr(get_the_title($value)); ?> ">
							<?php echo esc_attr(get_the_title($value)); ?> 
										</a><br>
										<span>
							<?php esc_html_e('Price:', 'extendons-mix-match-bundle'); ?> <?php echo wp_kses(__(wc_price($_product->get_price()), 'extendons-mix-match-bundles'), ''); ?> 
										</span>
										<input type="hidden" name="listprice" id="listprice<?php echo esc_attr($value); ?>" value="<?php echo wp_kses(__(wc_price($_product->get_price()), 'extendons-mix-match-bundles'), ''); ?> ">
									</div>
								</div>
								<div class="col-md-4">
									<div class="mm_list_number">
										<div class="input-group">
											<span class="input-group-btn">
												<button onclick="decrement(<?php echo esc_attr($value); ?>);" type="button" class="btn btn-default minuss">
							<?php esc_html_e('-', 'extendons-mix-match-bundle'); ?>
												</button>
											</span>
											<input id="product_qty_1<?php echo esc_attr($value); ?>" type="text" readonly class="form-control" value="0" min="1" max="100">
											<span class="input-group-btn">
												<button onclick="increment(<?php echo esc_attr($value); ?>);" type="button" class="btn btn-default mm_list_add_qty">
							<?php esc_html_e('+', 'extendons-mix-match-bundle'); ?>
												</button>

											</span>
										</div>
									</div>
								</div>
							</div>
						<?php } ?>
					</div> 
				</div>
			</div>

					<div class="listmm_filled_col">
						<div class="row" id="addbox">
						<?php for ($i=0; $i < $mmboxqty; $i++) { ?>

								<div class="listbox-tobe-filled">
									<span></span>
								</div>
						<?php } ?>
						</div>
					</div>
					
				</div>

						<?php if (isset($giftmasg) &&'yes'== $giftmasg) { ?>
						<div class="row">
							<div class="col-md-12">
								<div class="mm-gift-masg">
									<label class="gift-masg-label" for="mm-gmasg">
							<?php echo esc_html__($masglabel, 'extendons-mix-match-bundle'); ?>
									</label>
									<textarea name="mm_gift_massage" id="mm-gmasg" rows="10" cols="10" placeholder="Enter a gift message here"></textarea>
									<input type="hidden" name="mm_gift_massage_lbl" value="<?php echo esc_attr($masglabel); ?>">
								</div>
							</div>
						</div>
						<?php } ?> 
						<?php
					} else {

						?>

							<div class="mm_list_product_wrap" id="col12">
						<?php 
						foreach ($mixmatch_items as $key => $value) {
							$_product = wc_get_product($value); 

							?>
							<div class="row">
								<div class="col-md-4">
									<div class="mm_list_image">
										 <img id="mm_product_image<?php echo esc_attr($value); ?>" src="<?php echo esc_url(get_the_post_thumbnail_url($value)); ?>">  
									</div>
								</div>
								<div class="col-md-4">
									<div class="mm_list_name">
										<a href="<?php echo esc_url(get_the_permalink($value)); ?>" target="_blank">
							<?php echo esc_attr(get_the_title($value)); ?> 
										</a><br>
										<span>
							<?php esc_html_e('Price:', 'extendons-mix-match-bundle'); ?> <?php echo wp_kses(__(wc_price($_product->get_price()), 'extendons-mix-match-bundles'), ''); ?> 
										</span>
									</div>
								</div>
								<div class="col-md-4">
									<div class="mm_list_number">
										<div class="input-group">
											<span class="input-group-btn">
												<button onclick="decrement(<?php echo esc_attr($value); ?>);" type="button" class="btn btn-default minuss">
							<?php esc_html_e('-', 'extendons-mix-match-bundle'); ?>
												</button>
											</span>
											<input id="product_qty_1<?php echo esc_attr($value); ?>" type="text" readonly class="form-control" value="0" min="1" max="100">
											<span class="input-group-btn">
												<button onclick="increment(<?php echo esc_attr($value); ?>);" type="button" class="btn btn-default mm_list_add_qty">
							<?php esc_html_e('+', 'extendons-mix-match-bundle'); ?>
												</button>
											</span>
										</div>
									</div>
								</div>
							</div>
						<?php } ?>
					</div> 

					<div class="listmm_filled_col">
						<div class="row" id="addbox">
						<?php for ($i=0; $i < $mmboxqty; $i++) { ?>

								<div class="listbox-tobe-filled">
									<span></span>
								</div>
						<?php } ?>
						</div>
					</div>
					
				</div>

						<?php if (isset($giftmasg) &&'yes'== $giftmasg) { ?>
						<div class="row">
							<div class="col-md-12">
								<div class="mm-gift-masg">
									<label class="gift-masg-label" for="mm-gmasg">
							<?php echo esc_html__($masglabel, 'extendons-mix-match-bundle'); ?>
									</label>
									<textarea name="mm_gift_massage" id="mm-gmasg" rows="10" cols="10" placeholder="Enter a gift message here"></textarea>
									<input type="hidden" name="mm_gift_massage_lbl" value="<?php echo esc_attr($masglabel); ?>">
								</div>
							</div>
						</div>
						<?php } ?> 

						<?php

					}

					?>

					

				<?php do_action('mixmatch_optoins_compatible_before_add_to_cart_button'); ?>

				<div class="list_mm_list_qty">
					<?php 
					if (!$product->is_sold_individually()) {
						woocommerce_quantity_input(
							array(
							'min_value' => apply_filters('woocommerce_quantity_input_min', 1, $product),
							'max_value' => apply_filters('woocommerce_quantity_input_max', $product->backorders_allowed() ? '' : $product->get_stock_quantity(), $product),
							)
						); 
					}
					?>
					<input type="hidden" id="mmproduct_data" value='<?php echo esc_attr($mmdata); ?>' minqty="<?php echo esc_attr($mmboxqty); ?>">
					<input id="mm_product_items" type="hidden" name="mm_product_items" value="">
					<input id="mmperItemPrice" type="hidden" name="mmperItemPrice" value="">
					<button disabled="disabled" type="submit" name="add-to-cart" value="<?php echo esc_attr($product->get_id()); ?>" class="single_add_to_cart_button button alt">
						<?php echo esc_html($product->single_add_to_cart_text()); ?>        
					</button>
				</div>

			</div>
			
		</div> 
	</div>

</form>
