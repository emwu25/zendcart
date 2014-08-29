// -------------------------------------------------------- BELOW DEALS WITH THE PERSON LOGGING IN FROM THE CUSTOMER INFO PAGE AT THE CHECKOUT PROCESS --------------------------

jQuery(document).ready(function() {
    
	jQuery("#proceed_login").on("click",function() {
		
		var login_email = jQuery("#login_email").val();
		var login_pass = jQuery("#login_pass").val();
		hideInputErrors();
		
		var form_data = { login_email : login_email, login_pass : login_pass };
		logIn(form_data);
	})
});


function logIn(form_data) {
	
		var url = "/checkout/login/"
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
		showInputErrors(return_data.errors);			
	} else if(return_data.validation == 1) {
	  	moveToAccount()	;
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