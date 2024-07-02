jQuery(document).ready(function (jQuery) {
    
    // onload set price
    var mm_pdata = jQuery('#mmproduct_data').val();

    // console.log(mm_pdata);
    
    var mm_pdata = jQuery.parseJSON(mm_pdata);
    jQuery('#add_new_box').hide();
    jQuery('#mm_sucess').hide();
    jQuery('#demo1').addClass('collapse in');
    var arrs=[];
    jQuery(".box-tobe-filled").each(function(){
        if(jQuery(this).attr('data-pid')){
            prod_id=jQuery(this).data('pid');
            arrs.push(prod_id);
        }
    });
    
    if(mm_pdata) {
        if(mm_pdata.box_pricing === 'perwithbase') {

            var current = mm_pdata.box_price;
            var pricepre = 0;
            for (var i = 0; i <= arrs.length; i++) {
                if(mm_pdata.items[arrs[i]] && mm_pdata.items[arrs[i]].price) {
                    pricepre += parseFloat(mm_pdata.items[arrs[i]].price);
                }
            }
            var totalPrefilledPrice = parseFloat(pricepre) + parseFloat(current);
            totalPrefilledPrice = totalPrefilledPrice.toFixed(2);
            jQuery('.parentPrice').html(mm_pdata.currCurrency+' '+totalPrefilledPrice);
            jQuery('#mmperItemPrice').val(60);

        } else if(mm_pdata.box_pricing === 'perwoutbase') {
            var current = 0;
            var pricepre = 0;
            for (var i = 0; i <= arrs.length; i++) {
                if(mm_pdata.items[arrs[i]] && mm_pdata.items[arrs[i]].price) {
                    pricepre += parseFloat(mm_pdata.items[arrs[i]].price);
                }
            }
            var totalPrefilledPrice = parseFloat(pricepre) + parseFloat(current);
            totalPrefilledPrice = totalPrefilledPrice.toFixed(2);
            jQuery('.parentPrice').html(mm_pdata.currCurrency+' '+totalPrefilledPrice);
            jQuery('#mmperItemPrice').val(totalPrefilledPrice);
        }
    }

    // allow scroll
    jQuery(window).scroll(function () {
        var mm_pdata = jQuery('#mmproduct_data').val();
        var mm_pdata = jQuery.parseJSON(mm_pdata);
        if(mm_pdata != null) {
            if(mm_pdata.allowscroll=='yes') {
                var offset = jQuery(".box-tobe-filled").offset().top;
                var windowsc = jQuery(window).scrollTop();
                if (jQuery(window).scrollTop() >= Math.round(offset)) {
                    jQuery('.mm_filled_col').addClass('openmmliner');
                } else {
                    jQuery(".mm_filled_col").removeClass('openmmliner');
                }
            }
        }
    });

    // quatity mix and match input
    function wcqib_refresh_quantity_increments() {
        jQuery("div.mm_quantity:not(.buttons_added), td.mm_quantity:not(.buttons_added)").each(function(a, b) {
            var c = jQuery(b);
            c.addClass("buttons_added"), c.children().first().before('<input type="button" value="-" class="minus" />'), c.children().last().after('<input type="button" value="+" class="plus" />')
        })
    }
    String.prototype.getDecimals || (String.prototype.getDecimals = function() {
        var a = this, b = ("" + a).match(/(?:\.(\d+))?(?:[eE]([+-]?\d+))?$/);
        return b ? Math.max(0, (b[1] ? b[1].length : 0) - (b[2] ? +b[2] : 0)) : 0
    }), jQuery(document).ready(function() {
        wcqib_refresh_quantity_increments()
    }), jQuery(document).on("updated_wc_div", function() {
        wcqib_refresh_quantity_increments()
    }), jQuery(document).on("click", ".plus, .minus", function() {
        var a = jQuery(this).closest(".mm_quantity").find(".qty"),
            b = parseFloat(a.val()),
            c = parseFloat(a.attr("max")),
            d = parseFloat(a.attr("min")),
            e = a.attr("step");
        b && "" !== b && "NaN" !== b || (b = 0), "" !== c && "NaN" !== c || (c = ""), "" !== d && "NaN" !== d || (d = 0), "any" !== e && "" !== e && void 0 !== e && "NaN" !== parseFloat(e) || (e = 1), jQuery(this).is(".plus") ? c && b >= c ? a.val(c) : a.val((b + parseFloat(e)).toFixed(e.getDecimals())) : d && b <= d ? a.val(d) : b > 0 && a.val((b - parseFloat(e)).toFixed(e.getDecimals())), a.trigger("change")
    });

    // on click add product to bundle
    jQuery('#mm_error').hide();
    // show the error if stack is full 
    function mm_stack_error(str){
        jQuery('#mm_error').show();
            setTimeout(function() {
            jQuery('#mm_error').fadeOut(1000);
        }, 1000);
    }

    function mm_stack_full_massage() {
        jQuery('#mm_stack_full').show();
            setTimeout(function() {
            jQuery('#mm_stack_full').fadeOut(2000);
        }, 1000);
    }

    // may be minimum
    function enable_disabled_add_to_Cart(){
        var mm_pdata = jQuery('#mmproduct_data').val();
        var mm_pdata = jQuery.parseJSON(mm_pdata);
        var arr =[];
        if(jQuery('#mm_product_items').val()!=''){
            arr = jQuery('#mm_product_items').val().split(",");
        }
        
        if(mm_pdata.items && arr.length && mm_pdata.partialyAllow == 'yes') {
            if(arr.length && mm_pdata.minallow<=arr.length+1){
                return 1;
            } else  {
                return 0;
            }
        } else if(mm_pdata.items && arr.length && mm_pdata.boxqty<=arr.length+1) {
            return 1;
        } else {
            return 0;
        }
    }

    // count products
    function mm_count_product_number(){
        var arr =[];
        if(jQuery('#mm_product_items').val()!=''){
          arr = jQuery('#mm_product_items').val().split(",");
        }
        return parseInt(arr.length);
    }

    // increase product price
    function mm_price_increase(prod_id) {
        var mm_pdata = jQuery('#mmproduct_data').val();
        var mm_pdata = jQuery.parseJSON(mm_pdata);


                   

        if(mm_pdata.box_pricing==='perwithbase' || mm_pdata.box_pricing==='perwoutbase'){
            var current = 0;
            var price = 0;
            current = jQuery('.parentPrice').text();
            current = jQuery.trim(current);
            current = current.replace(/[^0-9\.]/g, '');
            if(mm_pdata.items[prod_id] && mm_pdata.items[prod_id].price){

                price = mm_pdata.items[prod_id].price;
                with2Decimals = current.toString().match(/^-?\d+(?:\.\d{0,2})?/)[0];
                current = with2Decimals;
               
                current = parseFloat(current) + parseFloat(price);
                current = current.toFixed(2);
               
                // to-do currency syomble position
                jQuery('.parentPrice').html(mm_pdata.currCurrency+''+current);
                jQuery('#mmperItemPrice').val(current);
            }
        }
        
    }

    function arrayTo2DArray1(list, howMany) {

      var result = []
      input = list.slice(0)
      while (input[0]) {
        result.push(input.splice(0, howMany))
      }
      return result;


    }

    
    // adding products to cart
    jQuery('body').on('click','.mm_adding-pro-icon', function (e) {
        
        var mm_pdata = jQuery('#mmproduct_data').val();
        var mm_pdata = jQuery.parseJSON(mm_pdata);

        var targ = jQuery(this);
        var add_new_box = jQuery('#add_new_boxes').val(); 
        var prod_id = targ.closest('.product_mm').data('mm_id');


        // image animation
        jQuery('#thumb-up-'+prod_id).show().delay(3000).fadeOut();
        var qty = jQuery('#product-quantity'+prod_id).val();
       
        for (var i = 0; i < qty; i++) {
            
            var f = mm_count_product_number();
            var t = parseInt(f);
            // box is full
            if(t+1 == mm_pdata.boxqty) {
                // box is full
                mm_stack_full_massage();
                if(add_new_box=='yes'){
                    
                    jQuery('#add_new_box').show();  
                }
                
            }

            if(t >= mm_pdata.boxqty) {
                // show error stack full
                
                if(jQuery('#prefilleds').val()=='yes' && add_new_box=='yes'){
                     mm_stack_error();
                     jQuery('#add_new_box').show(); 
                     jQuery('.single_add_to_cart_button').removeAttr('disabled');

                 }else{

                    mm_stack_error();

                 }
               

                return;
            } else  {

                if(add_new_box=='yes') {

                // add product images to boxes
                    var image = jQuery('#mm_product_image'+prod_id).attr('src');

                    var box_no  = jQuery('.mm_filled_col .box-tobe-filled span:empty:first').parent().parent().parent().attr('id');
                    jQuery('.mm_filled_col .box-tobe-filled span:empty:first').append('<img src="'+image+'">').parent().addClass('mm_yes').attr('data-pid', prod_id);
                    // adding product ids to hidden field
                    var boxqty = jQuery('#boxQty').val();
                    var arrs=[];
                    jQuery(".box-tobe-filled").each(function(){
                        if(jQuery(this).attr('data-pid')){
                            prod_idd=jQuery(this).attr('data-pid');
                            arrs.push(prod_idd);
                             
                           
                        }   
                    
                    });

                
                   var  final_array = arrayTo2DArray1(arrs, boxqty);

                                  
                // diabled remove on button
                if(enable_disabled_add_to_Cart()===1 && jQuery('.parentPrice').text().length){

                    var partialyAllow = mm_pdata.partialyAllow;

                    if(partialyAllow=='yes'){

                        jQuery('.single_add_to_cart_button').removeAttr('disabled');
                        jQuery('#add_new_box').show();   

                    }else {

                        jQuery('.single_add_to_cart_button').removeAttr('disabled');
                    }


                    
                }
                jQuery('#mm_product_items').val(JSON.stringify(final_array));
                // increase price by product
                mm_price_increase(prod_id);




                }  

                else {

                     // add product images to boxes
                var image = jQuery('#mm_product_image'+prod_id).attr('src');
                jQuery('.mm_filled_col .box-tobe-filled span:empty:first').append('<img src="'+image+'">').parent().addClass('mm_yes').attr('data-pid', prod_id);
                // adding product ids to hidden field
                var arrs=[];
                jQuery(".box-tobe-filled").each(function(){
                    if(jQuery(this).attr('data-pid')){
                        prod_idd=jQuery(this).attr('data-pid');
                        arrs.push(prod_idd);
                    }
                });
                // diabled remove on button
                if(enable_disabled_add_to_Cart()===1 && jQuery('.parentPrice').text().length){
                    jQuery('.single_add_to_cart_button').removeAttr('disabled');
                }

                jQuery('#mm_product_items').val(arrs.join(","));
                // increase price by product
                mm_price_increase(prod_id);
                }
               
            }
        }
    });

    function mm_price_decrease(prod_id){
        var mm_pdata = jQuery('#mmproduct_data').val();
        var mm_pdata = jQuery.parseJSON(mm_pdata);
        if(mm_pdata.box_pricing==='perwithbase' || mm_pdata.box_pricing==='perwoutbase'){
            var current = 0;
            var price = 0;
            current = jQuery('.parentPrice').text();
            current = jQuery.trim(current);
            current = current.replace(/[^0-9\.]/g, '');
            if(mm_pdata.items[prod_id] && mm_pdata.items[prod_id].price){
                price = mm_pdata.items[prod_id].price;
                with2Decimals = current.toString().match(/^-?\d+(?:\.\d{0,2})?/)[0];
                current = with2Decimals;
                
                current = parseFloat(current) - parseFloat(price);
                current = current.toFixed(2);
                
                jQuery('.parentPrice').html(mm_pdata.currCurrency+''+current);
                jQuery('#mmperItemPrice').val(current);
            }
        }  
    }

    // remove class and attr on product removed
    jQuery('body').on("click",".box-tobe-filled", function (e) {
        e.preventDefault();
        var targ=jQuery(this);
        if(targ.hasClass('mm_yes') && !targ.hasClass('mendatory')){
            prod_id = targ.attr('data-pid');
            targ.children().empty();
            targ.attr('data-pid','').removeAttr('data-pid');
            targ.removeClass('mm_yes');
            // decrease price
            mm_price_decrease(prod_id);
            jQuery('#add_new_box').hide();
        }
    });

    // remove product remvove product ids
    jQuery("body").on("click", '.box-tobe-filled', function (e) {
        var mm_pdata = jQuery('#mmproduct_data').val();
        var mm_pdata = jQuery.parseJSON(mm_pdata);
        var arr=[];
        jQuery(".box-tobe-filled").each(function(){
            if(jQuery(this).attr('data-pid')){
                prod_idd=jQuery(this).attr('data-pid');
                arr.push(prod_idd);
            }
        });
        if(mm_pdata.items && arr.length && mm_pdata.partialyAllow == 'yes') {
            if(arr.length+1 >= mm_pdata.minallow){
                jQuery('.single_add_to_cart_button').attr("disabled", "disabled");
            }
        }else if(jQuery.isEmptyObject(arr)) {
            jQuery('.single_add_to_cart_button').attr("disabled", "disabled");
        }
        jQuery('#mm_product_items').val(arr.join(","));
    });

});


