jQuery(document).ready(function() {
    
	jQuery("#complete_checkout").on("click", function() {
		hideInputErrors();
		var payment_type = jQuery("input[name='payment_type']:checked").val();
	
		// check if need to verify 
		
		if(payment_type == "PP" || payment_type == "WU") {
			// submit the form and make sure other fields are not validated. 	
		}
		
		var name = jQuery("input#name").val();
		var number = jQuery("input#number").val();
		var month = jQuery("#month option:selected").val();
		var year = jQuery("#year option:selected").val();
		var ccv = jQuery("input#ccv").val();
		var special_instructions = jQuery("textarea#special_instructions").val();

		
		var form_data = { name : name, number : number, month : month, year : year, ccv : ccv, payment_type : payment_type, special_instructions:special_instructions  };
		
		console.debug(form_data);
		//hideInputErrors();
		verifyPayment(form_data);
		})
		
	jQuery("input[name='payment_type']").on("change", function() {
			var current_radio = jQuery("input[name='payment_type']:checked").val();
			if(current_radio == "PP" || current_radio =="WU") {
				jQuery(".payment-box .cc-info").css("visibility","hidden");	
			} else {
				jQuery(".payment-box .cc-info").css("visibility","visible");	
			}
	})
});

function verifyPayment(form_data) {
	
		var url = "/checkout/payment-verify/"
	        try {
            jQuery.ajax( {
                url : url,
                dataType : 'json',
				data: form_data,
                success : function(data) {
					
                    processResult(data);   	        
                }
            });
        } catch (e) {
        }    
}

function processResult(return_data) {
	if(return_data.validation == -1) {
		showInputErrors(return_data.errors);			
	} else if(return_data.validation == 0) {
		//showServerError();	
	} else if(return_data.validation == 1) {
		completeOrder()	
	}
		
}

function completeOrder() {
	jQuery("form#finish_checkout").submit();
}

function showInputErrors(data) {
	jQuery.each(data, function(tag, message) {
		
		jQuery('#'+tag+'').addClass("error-box");
		
		console.debug(tag);
		console.debug(message);
		console.debug(jQuery('#'+tag+'').prev());
		var error_message;
		for(var i in message) {
			error_message = message[i];
			break;
		}
		jQuery('<span class="error-text">'+error_message+'</span>').insertAfter('#'+tag+'');
		
		if(tag == "payment_type") {
			jQuery(".payment-option").addClass("error-box");	
		}
	})
}





function hideInputErrors() {
		jQuery(".payment-option").removeClass("error-box");
		jQuery(".payment-option").removeClass("error-box");
		jQuery(".error-text").remove();
		jQuery(".server-error").remove();	
}