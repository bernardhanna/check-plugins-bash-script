jQuery(document).ready(function (jQuery) {

        jQuery('body').on('click','.radio_option_images_rs', function(e) {
    e.preventDefault();
    var curr = jQuery(this);

    var mediaUploader;
    mediaUploader = wp.media.frames.file_frame = wp.media({
      button: {
        text: 'Choose Image'
      }, multiple: false });
    
    mediaUploader.on('select', function() {
      var attachment = mediaUploader.state().get('selection').first().toJSON();
      curr.attr('src', attachment.url);
      curr.parents('td').find('input').attr('value',attachment.url);
    // .attr('val',"abcd");
    curr.parents('td').find('.remove_button').show();
    jQuery('.modal').css('overflow', 'scroll');
  });

    mediaUploader.open();
    
  });
    
    jQuery(".remove_image_rs").click(function(e){
    e.preventDefault();
    // alert("");
    var d_src=jQuery(this).parents('table').attr('data-default_img');
  
        jQuery(this).parents('td').find('img').attr('src',d_src);
        jQuery(this).parents('td').find('input').attr('value',"");

        if(jQuery(this).parents('td').find('img').attr('src')==d_src){
        jQuery(this).parent('p').hide();
        }
    });


    jQuery('body').on('click','.extendons-save_generalsettings',function(){

        var _mm_layoutstyle_type = jQuery('#_mm_layoutstyle_type').val();
        var _mm_template_type = jQuery('#_mm_template_type').val();
      
        var _mm_enabledescription = 'no';   
        if(jQuery('#_mm_enabledescription').is(':checked') == true){
            _mm_enabledescription = 'yes';
        }

        var _mm_addtocarttext = jQuery('#_mm_addtocarttext').val(); 

        var _mm_boxheadingmessage = jQuery('#_mm_boxheadingmessage').val();

        var _mm_Outofstocktext = jQuery('#_mm_Outofstocktext').val();

        var _mm_boxsuccessmsg = jQuery('#_mm_boxsuccessmsg').val();

        var _mm_form_width = jQuery('#_mm_form_width').val();

        var _mm_color_backgroundcolor = jQuery('#_mm_color_backgroundcolor').val();

        var _mm_color_primarycolor = jQuery('#_mm_color_primarycolor').val();

        var _mm_image_placeholder = jQuery('[name="box_ph_image_val"]').val();

        var _mm_color_pricecolor = jQuery('#_mm_color_pricecolor').val();
       console.log(_mm_color_pricecolor);

        var ajaxurl = mm_varf.ajax_url;
        
         jQuery.ajax({
            url: ajaxurl,
            type: 'post',
            data: {
                action: 'extendons_save_general_settings',
                _mm_layoutstyle_type: _mm_layoutstyle_type,
                _mm_template_type: _mm_template_type,
                _mm_enabledescription:_mm_enabledescription,
                _mm_addtocarttext:_mm_addtocarttext,
                _mm_boxheadingmessage:_mm_boxheadingmessage,
                _mm_Outofstocktext:_mm_Outofstocktext,
                _mm_boxsuccessmsg:_mm_boxsuccessmsg,
                _mm_color_backgroundcolor: _mm_color_backgroundcolor,
                _mm_color_primarycolor : _mm_color_primarycolor,
                _mm_color_pricecolor : _mm_color_pricecolor,
                _mm_image_placeholder : _mm_image_placeholder,
                _mm_form_width : _mm_form_width,

        
            },
            success: function (data) {
                jQuery('.generalsuccessmessage').fadeIn();
                jQuery('.generalsuccessmessage').delay(3000).fadeOut('slow');
                jQuery("html, body").animate({ scrollTop: 0 }, "1");              
                jQuery('html, body').stop(true, true);
                // console.log(_mm_image_placeholder);
                return false;   
                window.onbeforeunload = null;

            }   
        });        
    });
	
	
	jQuery('#_mm_layoutstyle_type').change(function(){
       
		 if(jQuery(this).val() =='simple') {
			 jQuery('.extboxdesc').hide();
		 } else {
			  jQuery('.extboxdesc').show();
		 }
		
    });
	
	
	// partially filled enabled and min qty
    jQuery('#_mm_partialy_filled_layout').change(function(){
        if(this.checked){
            jQuery('._mm_boxmin_qty_allow_field').show();
        } else {
            jQuery('._mm_boxmin_qty_allow_field').hide();
        }
    });
	 if(jQuery('#_mm_partialy_filled_layout').is(':checked') == true){
        jQuery('._mm_boxmin_qty_allow_field').show();
    } else {
        jQuery('._mm_boxmin_qty_allow_field').hide();
    }
  
    // checkbox masg label gift
    jQuery('#_mm_enable_gift_masg').change(function(){
        if(this.checked){
            jQuery('._mm_gift_masg_label_field').show();
        } else {
            jQuery('._mm_gift_masg_label_field').hide();
        }
    });
    if(jQuery('#_mm_enable_gift_masg').is(':checked') == true){
        jQuery('._mm_gift_masg_label_field').show();
    } else {
        jQuery('._mm_gift_masg_label_field').hide();
    }

     jQuery('#_mm_enable_limit_per_prod').change(function(){
        if(this.checked){
            jQuery('._mm_limit_per_prod_quanity_field').show();
        } else {
            jQuery('._mm_limit_per_prod_quanity_field').hide();
        }
    });
    if(jQuery('#_mm_enable_limit_per_prod').is(':checked') == true){
        jQuery('._mm_limit_per_prod_quanity_field').show();
    } else {
        jQuery('._mm_limit_per_prod_quanity_field').hide();
    }




    // prefilled checkbox
    jQuery('#_mm_enable_prefiled').change(function(){
        if(this.checked){
            jQuery('.mm_mandatory_items_wrapper, .prefilled_products').show();
        } else {
            jQuery('.mm_mandatory_items_wrapper, .prefilled_products').hide();
        }
    });
    if(jQuery('#_mm_enable_prefiled').is(':checked') == true){
        jQuery('.mm_mandatory_items_wrapper, .prefilled_products').show();
    } else {
        jQuery('.mm_mandatory_items_wrapper, .prefilled_products').hide();
    }

    jQuery('._mm_prefilled_products').on('focusin mouseover', function(){
        // console.log("Saving value " + jQuery(this).val());
        jQuery(this).data('val', jQuery(this).val());
    });

    jQuery(document).on('change', '._mm_prefilled_products', function( e ) {
        e.preventDefault();
        var total        = 0;
        var box_quantity = parseInt( jQuery('#_mm_box_quantity').val() );
        var prev_value   = jQuery(this).data('val');

        jQuery('._mm_prefilled_products').each( function( index, e) {
            total +=  parseInt( jQuery(e).val() );
        });

        if( total > box_quantity ) {
            alert( 'Number of prefilled products can\'t be greater than box quantity.');
            jQuery(this).val( prev_value );
        }   
    });

    // select 2 for selecting bundles
    jQuery('#_mm_add_products').select2({minimumInputLength: 3});

    // append new row prefilled 
    jQuery('#mm_pre_fillder_items_btn').on('click', function (e) {
        var mm_prod_ids = jQuery('#mm_render_prefilled_products').val();
        var mm_current_id = jQuery('#mm_current_id').val();
        var item_count = jQuery('tbody#prefilled-row-mixmatch tr').size();
        if(mm_prod_ids == null){
            alert('Please add some product to save');
            return false;
        } else {
            ajax: {
                data = {
                    action: 'mm_add_new_products',
                    mm_prod_ids : mm_prod_ids,
                    mm_current_id : mm_current_id,
                    mm_nonce: mm_varf.mm_nonce,
                    item_count : item_count
                };
                jQuery.post(ajaxurl, data, function (response) {
                    jQuery('#prefilled-row-mixmatch').append(response);
                });
            }
        }
    });

    // loading for subscription
    jQuery('.options_group.pricing' ).addClass( 'show_if_wooextmm' );
    jQuery('.options_group.subscription_pricing ' ).addClass( 'show_if_wooextmm' );
    jQuery('.options_group ._tax_status_field').parent().addClass( 'show_if_wooextmm' );
    jQuery('.inventory_options.inventory_tab').addClass( 'show_if_wooextmm' );
    jQuery('.options_group ._manage_stock_field').addClass( 'show_if_wooextmm' );

});


jQuery(document).ready(function(){

  jQuery('#_mm_add_products').on('change keypress', function() {

      // Grab the text of the selected item
      var select2Option = jQuery("#_mm_add_products").select2("val");
        //console.log(select2Option);
        jQuery('#mm_render_prefilled_products')
        .find('option')
        .remove()
        .end()
        .append('')
        .val('')
        ;
        var i;
        if( Array.isArray(select2Option) && select2Option.length > 0){
            for(i = 0 ; i< select2Option.length; i++){
                var val=jQuery('#_mm_add_products').find('option[value="'+select2Option[i]+'"]').text();
                jQuery('#mm_render_prefilled_products').append('<option value='+select2Option[i]+'>'+val+'</option>')
            }    
        }
        

    });


});

function mm_save_bundle_remove(e, index, element){
    jQuery(element).parent().parent().remove();
}

