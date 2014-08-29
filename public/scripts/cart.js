jQuery(document).ready(function(){
	
	jQuery(".main_wrapper").on("click", ".prod_row .update_button", function() { 
		
			var item_hash = jQuery(this).siblings("input").attr("name");
			var item_qty = jQuery(this).siblings("input").val();
			updateQuantity(item_hash,item_qty);
		})
	
	jQuery(".subtotal_wrapper").on("click", "#cart_checkout .update_button", function() {
			
			alert("i'm here");
			jQuery('form#checkout').submit();
			
	})
	
	
})
	
	
	
function updateQuantity(item_hashcode, item_qty) {
			
			var url = "/cart/update/" + item_hashcode + "/" + item_qty;
	        try {
            jQuery.ajax( {
                url : url,
                dataType : 'json',
                success : function(data) {
					//alert("came back");
                    updateItems(data);   	        
                }
            });
        } catch (e) {
        }    
}

function updateItems(items_data) {
	console.debug(items_data.html);
	jQuery(".box_wrapper").replaceWith(items_data.html);
	jQuery(".totals-div").replaceWith(items_data.subtotals);
}
			
// ESTIMATE SHIPPING AND TAX FOR CART PAGE -------------------------------------------------------------------------------------------------------------------------------------- 

jQuery(document).ready(function(){
	
	jQuery("#shipping_tax_price").on("click", function() {
		 
		var state = jQuery(".subtotal_wrapper #state").val();
		var zip = jQuery(".subtotal_wrapper #zip").val();
		updateTaxShipping(zip, state);
	})
	
}) 

function updateTaxShipping(zip, state) {
			
			var url = "/shipping/ups-quote";
	        try {
            jQuery.ajax( {
                url : url,
				data: {'zip' : zip, 'state' : state },
                dataType : 'json',
                success : function(data) {
					//alert("came back");
                    updateTaxShippingPrice(data);   	        
                }
            });
        } catch (e) {
        }   
}

function updateTaxShippingPrice(data) {

	jQuery(".totals-div").replaceWith(data.html);
}

// ----------------  THIS SECTION WILL DEAL WITH ACCOUNT INFO DURING THE CHECKOUT PROCESS ---------------------------------------------------------------------------------

jQuery(document).ready(function(){

	jQuery("#proceed_new").on("click", function() {
	
		//jQuery("#new_acc").submit();
		//alert("wth");
	
	})
})