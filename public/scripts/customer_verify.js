
jQuery(document).ready(function() {
    
	jQuery("#proceed_new").on("click", function() {
	
		var name = jQuery("#name").val();
		var company = jQuery("#company").val();
		var address1 = jQuery("#address1").val();
		var address2 = jQuery("#address2").val();
		var city = jQuery("#city").val();
		var state = jQuery("#state").val();
		var zip = jQuery("#zip").val();
		var country = jQuery("#country option:selected").val();
		var phone = jQuery("#phone").val();
		var email = jQuery("#email").val();
		var password = jQuery("#password").val();
		var passwordcheck = jQuery("#passwordcheck").val();
		var mail_list = 0;
		if(jQuery("input[name='maillist']:checked").val() == "maillist") {
					mail_list = 1;
		};
		
		var form_data = { name : name, company : company, address1 : address1, address2:address2, city : city, state : state, zip : zip , country : country, phone : phone, email : email , password : password, passwordcheck : passwordcheck, mail_list : mail_list };
		
		//console.debug(form_data);
		hideInputErrors();
		createAccount(form_data);

	
	})	
});

function createAccount(form_data) {
	
		var url = "/account/create/"
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
		showServerError();	
	} else if(return_data.validation == 1) {
		moveToPayment()	
	}
		
}

function moveToPayment() {
	jQuery("#new_acc").submit();
}

function showServerError(){
	jQuery(".new_account_wrapper").prepend('<div class="server-error"><span>There has been a problem creating your account.  Please try again or contact 123dj.com at 1-800-856-8397</span></div>');
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
	  	moveToPayment()	;
	}
}