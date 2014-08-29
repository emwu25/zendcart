// -------------------------------------------------------- BELOW DEALS WITH THE PERSON LOGGING IN FROM THE CUSTOMER INFO PAGE AT THE CHECKOUT PROCESS --------------------------

jQuery(document).ready(function() {
    
	jQuery("#proceed_login").on("click",function() {
		
		//jQuery('<div class="ajax-loader"><img src="/cart_images/ajax-loader.gif"></div>')
		
		jQuery('<div class="ajax-loader"><img src="/cart_images/ajax-loader.gif"><span> Sending Email. Please Wait...</span></div>').insertBefore(".checkout_button");
		jQuery(".ajax-loader").delay(800).animate({height: "40px"});
		
		var login_email = jQuery("#login_email").val();
		hideInputErrors();
		
		var form_data = { login_email : login_email};
		sendRecover(form_data);
	})
});


function sendRecover(form_data) {
	
		var url = "/account/send-recover/"
	        try {
            jQuery.ajax( {
                url : url,
                dataType : 'json',
				data: form_data,
                success : function(data) {
					
                    processLogin(data);   	        
                }
            });
        } catch (e) {
        }    
}

function processLogin(return_data) {
	 if(return_data.validation == -1) {
		removeLoader();
		showInputErrors(return_data.errors);			
	} else if(return_data.validation == 1) {
	  	removeLoader();
		showConfirmation();
	} else if (return_data.validation == 0) { 
		// show user that some internal error occured. 
	}
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
		jQuery('#'+tag+'').prev().append('<span class="error-text">'+error_message+'</span>');
		if(tag == "passwordmatch") {
		 	jQuery('#password').prev().append('<span class="error-text">'+error_message+'</span>');
			jQuery("#password, #passwordcheck").addClass("error-box");	
		}
	})
}


function hideInputErrors() {
		jQuery("input").removeClass("error-box");
		jQuery(".error-text").remove();
		jQuery(".server-error").remove();	
}

function moveToAccount() {
	window.location = "/account/view";	
}

function removeLoader() {
	jQuery(".ajax-loader").remove();	
}

function showConfirmation() { 
	jQuery(".info-box label").remove();
	jQuery(".info-box input").remove();
	jQuery(".info-box .checkout_button").remove();
	jQuery(".password-reset-note").remove();
	jQuery('<div class="recovery_sent"><span>Email Sent. Please follow instructions in the email in order to reset your password.</span></div>').insertAfter(".info-box h4");
}