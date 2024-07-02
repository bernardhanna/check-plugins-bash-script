<?php
/**
 * Front Prefilled products file.
 *
 * @package Woocommercecustomproductboxesplugin
 * @link    https://woocommerce.com/products/woocommerce-custom-product-boxes-plugin
 */
?>

<div class="prefilled_products">
	<table>
		<thead>
			<tr>
				<th>
					<span class="tip"><?php echo wc_help_tip('Checkbox to include product in box as mandatory'); ?><?php echo esc_html__('Mandatory', 'extendons-woocommerce-product-boxes'); ?></span>
				</th>
				<th>
					<span class="tip"><?php echo wc_help_tip('Add prefilled products'); ?><?php echo esc_html__('Product Name', 'extendons-woocommerce-product-boxes'); ?></span>
				</th>
				 <th>
					<span class="tip"><?php echo wc_help_tip('Prefilled product quantity in the box'); ?><?php echo esc_html__('Quantity', 'extendons-woocommerce-product-boxes'); ?></span>
				</th>
				<th>
					<span class="tip"><?php echo wc_help_tip('Delete the prefilled product'); ?><?php echo esc_html__('Actions', 'extendons-woocommerce-product-boxes'); ?></span>
				</th>
			</tr>
		</thead>
		<tbody id="prefilled-row-mixmatch">

			<?php if (!empty($prefilled_items_data)) { ?>
				<?php $i = 0; ?>
				<?php 

				foreach ($prefilled_items_data as $item_Data) { 

					$product = wc_get_product($item_Data['product_id']); 

					?>

					<tr id="mm_prefilled_items_mm<?php echo esc_attr($i); ?>">
						<input type="hidden" value="<?php echo esc_attr($item_Data['product_id']); ?>" name="_mm_prefilled_product[<?php echo esc_attr($i); ?>][product_id]" />
						<td>
					<?php if (isset($item_Data['pre_mandetory']) && 'on' == $item_Data['pre_mandetory'] ) { ?>
								<input checked="checked" type="checkbox" name="_mm_prefilled_product[<?php echo esc_attr($i); ?>][pre_mandetory]">
					<?php } else { ?>
								<input type="checkbox" name="_mm_prefilled_product[<?php echo esc_attr($i); ?>][pre_mandetory]">
					<?php } ?>
							
						</td>
						<td>
						   <input readonly type="text" name="_mm_prefilled_product[<?php echo esc_attr($i); ?>][pre_name]" value="<?php echo esc_attr($product->get_name()) . ' - #' . esc_attr($product->get_id()); ?>">
						</td>
						<td>
							<input min="1" max="<?php echo esc_attr($box_quatity); ?>" type="number" class="_mm_prefilled_products"  value="<?php echo esc_attr($item_Data['pre_qty']); ?>" name="_mm_prefilled_product[<?php echo esc_attr($i); ?>][pre_qty]">
						</td>
						<td>
						   <input class="button mm_prefilled_delete" type="button" value="Delete" onclick="mm_save_bundle_remove(event, '<?php echo esc_attr($i); ?>', this);" />
						</td>
					</tr>

					<?php 
					$i++; 
				} 
			} 
			?>

		</tbody>
	</table>
</div>
