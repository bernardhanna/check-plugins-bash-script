jQuery(document).ready(function (jQuery) {
    jQuery('#mm_sucess').hide();
    // onload set price
    var mm_pdata = jQuery('#mmproduct_data').val();
    var mm_pdata = jQuery.parseJSON(mm_pdata);
   
    if(mm_pdata) {
        if(mm_pdata.box_pricing === 'perwithbase') {

            var current = parseInt(mm_pdata.box_price);
            current = current.toFixed(2);
            jQuery('p.price').html('<span class="woocommerce-Price-amount amount"><span class="woocommerce-Price-currencySymbol">'+mm_pdata.currCurrency+'</span>'+current+'</span>');
            jQuery('#mmperItemPrice').val(current);

        } else if(mm_pdata.box_pricing === 'perwoutbase') {
            var current = 0;
            current = current.toFixed(2);
            jQuery('p.price').html('<span class="woocommerce-Price-amount amount"><span class="woocommerce-Price-currencySymbol">'+mm_pdata.currCurrency+'</span>'+current+'</span>');
            jQuery('#mmperItemPrice').val(current);

        }
    }

    jQuery('#demo').addClass('collapse in');
});

// display none by default
jQuery('#mmlist_error').hide(); 
// function full display error
function mmlist_stack_full(str){
    jQuery('#mmlist_error').show();
        setTimeout(function() {
        jQuery('#mmlist_error').fadeOut(1000);
    }, 1000);
}

// may be minimum
function enable_disabled_add_to_Carts(){
    var mm_pdata = jQuery('#mmproduct_data').val();
    var mm_pdata = jQuery.parseJSON(mm_pdata);
    var arr =[];
    if(jQuery('#mm_product_items').val()!=''){
        arr = jQuery('#mm_product_items').val().split(",");
    }
    if(mm_pdata.items && arr.length) {
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

// list count number array
function mmlist_count_product_number(){
    var arr =[];
    if(jQuery('#mm_product_items').val()!=''){
      arr = jQuery('#mm_product_items').val().split(",");
    }
    return parseInt(arr.length);


}

// increment id and price
function mmlist_price_increase(prod_id) {
    var mm_pdata = jQuery('#mmproduct_data').val();
    var mm_pdata = jQuery.parseJSON(mm_pdata);
    if(mm_pdata.box_pricing==='perwithbase' || mm_pdata.box_pricing==='perwoutbase'){
        var current = 0;
        var price = 0;
        current = jQuery('p.price .amount').text();
        current = jQuery.trim(current);
        current = current.replace(/[^0-9\.]/g, '');
        if(mm_pdata.items[prod_id] && mm_pdata.items[prod_id].price){
            price = mm_pdata.items[prod_id].price;
             with2Decimals = current.toString().match(/^-?\d+(?:\.\d{0,2})?/)[0];
             current = with2Decimals;
            current = parseFloat(current) + parseFloat(price);
            // console.log(current);
            current = current.toFixed(2);
            
            jQuery('p.price').html('<span class="woocommerce-Price-amount amount"><span class="woocommerce-Price-currencySymbol">'+mm_pdata.currCurrency+'</span>'+current+'</span>');
            jQuery('#mmperItemPrice').val(current);
        }
    }
}

// decrement id and price
function mmlist_price_decrease(prod_id){
    var mm_pdata = jQuery('#mmproduct_data').val();
    var mm_pdata = jQuery.parseJSON(mm_pdata);
    if(mm_pdata.box_pricing==='perwithbase' || mm_pdata.box_pricing==='perwoutbase'){
        var current = 0;
        var price = 0;
        current = jQuery('p.price .amount').text();
        current = jQuery.trim(current);
        current = current.replace(/[^0-9\.]/g, '');
        if(mm_pdata.items[prod_id] && mm_pdata.items[prod_id].price){
            price = mm_pdata.items[prod_id].price;
            with2Decimals = current.toString().match(/^-?\d+(?:\.\d{0,2})?/)[0];
            current = with2Decimals;
            current = parseFloat(current) - parseFloat(price);
            current = current.toFixed(2);
            jQuery('p.price').html('<span class="woocommerce-Price-amount amount"><span class="woocommerce-Price-currencySymbol">'+mm_pdata.currCurrency+'</span>'+current+'</span>');
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

//increment
function increment(id) {
    jQuery('#product_qty_1'+id).val(parseInt(jQuery('#product_qty_1'+id).val()) + 1);
    var mm_pdata = jQuery('#mmproduct_data').val();
    var mm_pdata = jQuery.parseJSON(mm_pdata);
    var prod_id = id;
    var qty = jQuery('#product_qty_1'+id).val();
    var add_new_box = jQuery('#add_new_boxes').val();
    if(qty > 0) {
        var f = mmlist_count_product_number();
        var t = parseInt(f);
    
        if(t == mm_pdata.boxqty) {
            if(add_new_box=='yes') {
                jQuery('#add_new_boxlist').show();
              
             }
            jQuery('#product_qty_1'+id).val(parseInt(jQuery('#product_qty_1'+id).val()) - 1);
            mmlist_stack_full();
            return;
        } else  {
             
            if(add_new_box=='yes'){

            var image = jQuery('#mm_product_image'+prod_id).attr('src');
            var box_no  = jQuery('.mm_filled_col .box-tobe-filled span:empty:first').parent().parent().parent().attr('id');    
            jQuery('.listmm_filled_col .listbox-tobe-filled span:empty:first').append('<img src="">').parent().addClass('id-'+prod_id).attr('data-pid', prod_id);
            // adding product ids to hidden field

            var boxqty = jQuery('#boxQty').val();

            var arrs=[];
            jQuery(".listbox-tobe-filled").each(function(){
                if(jQuery(this).attr('data-pid')){
                    prod_idd=jQuery(this).attr('data-pid');
                    arrs.push(prod_idd);
                }
            });

            var  final_array = arrayTo2DArray1(arrs, boxqty);
            // // diabled remove on button
            if(enable_disabled_add_to_Carts()===1){
                jQuery('.single_add_to_cart_button').removeAttr('disabled');
            }
            
            jQuery('#mm_product_items').val(JSON.stringify(final_array));
            mmlist_price_increase(prod_id);


            } else {

            jQuery('.listmm_filled_col .listbox-tobe-filled span:empty:first').append('<img src="">').parent().addClass('id-'+prod_id).attr('data-pid', prod_id);
            // adding product ids to hidden field
            var arrs=[];
            jQuery(".listbox-tobe-filled").each(function(){
                if(jQuery(this).attr('data-pid')){
                    prod_idd=jQuery(this).attr('data-pid');
                    arrs.push(prod_idd);
                }
            });

            // // diabled remove on button
            if(enable_disabled_add_to_Carts()===1){
                jQuery('.single_add_to_cart_button').removeAttr('disabled');
            }
            
            jQuery('#mm_product_items').val(arrs.join(","));
            mmlist_price_increase(prod_id);

            }

           
        }
    }

}

// Decrement
function decrement(id) {
    if(parseInt(jQuery('#product_qty_1'+id).val()) > 0){
       jQuery('#product_qty_1'+id).val(parseInt(jQuery('#product_qty_1'+id).val()) - 1);
    }
    var mm_pdata = jQuery('#mmproduct_data').val();
    var mm_pdata = jQuery.parseJSON(mm_pdata);
    var prod_id = parseInt(id);
    var targ = jQuery('.listmm_filled_col .row .listbox-tobe-filled');

    for (var i = 0; i < targ.length; i++) {
        if(targ[i].className.split(' ')[1] === 'id-'+prod_id) {
            targ[i].classList.remove('id-'+prod_id);
            targ[i].removeAttribute('data-pid');
            targ[i].firstElementChild.innerHTML = '';
            mmlist_price_decrease(prod_id);
            jQuery('#add_new_box').hide();
            break;
        }
    }
}


jQuery(document).ready(function (jQuery) {
    // bind on jquery remove items
    jQuery(".minuss").bind("click", function (e) {
        var mm_pdata = jQuery('#mmproduct_data').val();
        var mm_pdata = jQuery.parseJSON(mm_pdata);
        var arr=[];
        jQuery(".listbox-tobe-filled").each(function(){
            if(jQuery(this).attr('data-pid')){
                prod_id=jQuery(this).attr('data-pid');
                arr.push(prod_id);
            }
        });
        if(mm_pdata.items && arr.length) {
            if(arr.length+1 >= mm_pdata.minallow){
                jQuery('.single_add_to_cart_button').attr("disabled", "disabled");
            }
        }else if(jQuery.isEmptyObject(arr)) {
            jQuery('.single_add_to_cart_button').attr("disabled", "disabled");
        }
        jQuery('#mm_product_items').val(arr.join(","));
    });
});


jQuery(document).ready(function (jQuery) {
    var count=1;
    jQuery('#demo').attr('id','demo'+count);
    jQuery('#collapsebox').attr('data-target','#demo'+count);
    jQuery('#collapsebox').attr('id','collapsebox'+count);
    jQuery('#boxcount').attr('value', count);
    var mm_pdata = jQuery('#mmproduct_data').val();
    var mm_pdata = jQuery.parseJSON(mm_pdata);
    jQuery('#add_new_box').on('click', function(){

        jQuery('#collapsebox1').show();
        jQuery('#demo'+count).removeClass('in');
        count = count+1;
        var getboxQty =jQuery('#mmproduct_data').val();
        var obj = jQuery.parseJSON(getboxQty );   
        var oldboxqty= jQuery('#mmproduct_data').attr('minqty');
        var new_boxQty = parseInt( obj.boxqty)+ parseInt(oldboxqty);
        obj.boxqty= new_boxQty;
        var newval=JSON.stringify(obj);
        jQuery('#mmproduct_data').val(newval);
        var boxcol = jQuery('#boxcol').val();
        var a  = parseInt(jQuery( ".box-tobe-filled").find( "div" ).length);
        var html ='<button type="button" class="btn btn-basic" id="collapsebox'+count+'" name="demo" data-toggle="collapse" data-target="#demo'+count+'">Box'+count+' </button> <div class="collapse in" id="demo'+count+'"><div class="row">';
            var i;
            var q=a;
            var size = parseInt(oldboxqty) +  a;
            for (i = a; i <size; i++) { 
            
                 html = html+ '<div id="mm_item'+i+'" class="'+boxcol+' box-tobe-filled"><span></span><div class="mm_remove_product_icon"></div></div>';

            }

        html = html+  '</div>';
        html = html+ '</div>';

        var arr = [];
        arr.push(count);
        jQuery('#boxcount').attr('value',arr); 

        jQuery('#addcollapse').append(html);
        jQuery('.collapsebox').addClass('collapse');
        jQuery('.collapsebox').attr('id', 'demo'+count);  
        jQuery('#add_new_box').hide();
 
    });    
 
});


jQuery(document).ready(function (jQuery) {
    var count=1;
    jQuery('#demo').attr('id','demo'+count);
    jQuery('#collapsebox').attr('data-target','#demo'+count);
    jQuery('#collapsebox').attr('id','collapsebox'+count);
    jQuery('#boxcount').attr('value', count);

    jQuery('#add_new_boxlist').on('click', function(){

        jQuery('#collapsebox1').show();
        jQuery('#demo'+count).removeClass('in');
        count = count+1;
        var getboxQty =jQuery('#mmproduct_data').val();
        var obj = jQuery.parseJSON(getboxQty );
        var oldboxqty= jQuery('#mmproduct_data').attr('minqty');
        var new_boxQty = parseInt( obj.boxqty)+ parseInt(oldboxqty);
        obj.boxqty= new_boxQty;
        var newval=JSON.stringify(obj);
        jQuery('#mmproduct_data').val(newval);
        var boxcol = jQuery('#boxcol').val();



        var  listid = jQuery('#listmm').val(); 
        listid = listid.replace(/^\[(.+)\]$/,'$1');
        listid = listid.replace(/\"/g, "");
        listid = listid.split(',');
        var img = jQuery('#mm_product_image').val();   
        var a  = parseInt(jQuery( ".box-tobe-filled").find( "div" ).length);
        var html ='<button type="button" class="btn btn-basic" id="collapsebox'+count+'" name="demo" data-toggle="collapse" data-target="#demo'+count+'">Box'+count+' </button> <div class="collapse in" id="demo'+count+'"><div class="row">';
            var i;
            var q=a;
            var size = parseInt(oldboxqty) +  a;
            for (i = a; i <size; i++) { 
                 
                jQuery('#addbox').append('<div class="listbox-tobe-filled"><span></span></div>');

                 var img = jQuery('#mm_product_image'+listid[i]+'').attr('src');
                 var href= jQuery('#listval'+listid[i]+'').attr('href');
                 var listtitle = jQuery('#listtitle'+listid[i]+' ').attr('value');
                 var listprice = jQuery('#listprice'+listid[i]+' ').attr('value');
                 html = html+ '<div class="row" style="padding:10px;margin-right:10px;"><div class="col-md-4"><div class="mm_list_image"><img id="mm_product_image'+listid[i]+'" src="'+img+'"></div></div><div class="col-md-4"><div class="mm_list_name"><a id="listval'+listid[i]+'" href="'+href+'" target="_blank">'+listtitle+'</a><br><span>Price:'+listprice+' </span></div></div><div class="col-md-4"><div class="mm_list_number"><div class="input-group"><span class="input-group-btn"><button onclick="decrement('+listid[i]+');" type="button" class="btn btn-default minuss">-</button></span><input id="product_qty_1'+listid[i]+'" type="text" readonly class="form-control" value="0" min="1" max="100"><span class="input-group-btn"><button onclick="increment('+listid[i]+');" type="button" class="btn btn-default mm_list_add_qty">+</button></span></div></div></div></div>'
            }

        html = html+  '</div>';
        html = html+ '</div>';

        var arr = [];
        arr.push(count);
        jQuery('#boxcount').attr('value',arr); 

        jQuery('#addcollapse').append(html);
        jQuery('.collapsebox').addClass('collapse');
        jQuery('.collapsebox').attr('id', 'demo'+count);  
        jQuery('#add_new_box').hide();

       
        


        
    });

    
 
});