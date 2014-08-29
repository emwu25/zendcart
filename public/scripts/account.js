jQuery(document).ready(function() {
    
	jQuery(".profile-addr-change").on("click", function(){
		jQuery("body").prepend('<div class="gray-disable" />');
		showAddressChange();
	});
	
	jQuery(document).on("click",".close-button-wrapper a", function() {
		hideAddressChange();
	})
	
	jQuery(document).on("click",".change-password .close-button-wrapper a", function() {
		hidePasswordChange();
	})
	
	jQuery(document).on("click",".add-address .save-button div", function() {
		var form_data = jQuery("#add-address-form").serialize();
		hideInputErrors();
		addNewAddress(form_data);
	})
	
	jQuery(".profile-passwd-change").on("click", function() {
		jQuery("body").prepend('<div class="gray-disable" />');
		showPasswordChange();		
	})

	jQuery(document).on("click",".change-password .close-button-wrapper a", function() {
		hidePasswordChange();
	})	

	jQuery(document).on("click",".change-password .save-button div", function() {
		var form_data = jQuery("#change-password-form").serialize();
		hideInputErrors();
		savePassword(form_data);
	})
	
});


function showPasswordChange() {
		var url = "/account/change-password";
	        try {
            jQuery.ajax( {
                url : url,
                dataType : 'json',
				//data: form_data,
                success : function(data) {
                    showChangeBox(data);   	        
                }
            });
        } catch (e) {
        }    		
}


function showAddressChange() {

		var url = "/account/add-address/"
	        try {
            jQuery.ajax( {
                url : url,
                dataType : 'json',
				//data: form_data,
                success : function(data) {
                    showChangeBox(data);   	        
                }
            });
        } catch (e) {
			alert("wtf");
        }    
}

function showChangeBox(data) { 
	jQuery("body").prepend(data.html);
	jQuery(".add-address #state").val(data.state);
	jQuery(".add-address #country").val(data.country);
}

function addNewAddress(formdata) { 
		var url = "/account/save-address/"
	        try {
            jQuery.ajax( {
                url : url,
                dataType : 'json',
				data: formdata,
                success : function(data) {
                    processAddResults(data);   	        
                }
            });
        } catch (e) {
        }  	
}

function processAddResults(return_data) {
	if(return_data.validation == -1) {
		showInputErrors(return_data.errors);			
	} else if(return_data.validation == 0) {
		showServerError();	
	} else if(return_data.validation == 1) {
		updateAddress(return_data)	
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
		 	jQuery('#new-pass2').prev().append('<span class="error-text">'+error_message+'</span>');
			jQuery("#new-pass, #new-pass2").addClass("error-box");	
		}
	})
}

function updateAddress(data) {
		hideAddressChange(); 
		jQuery(".profile-address-wrapper").html(data.html)
}


function hideInputErrors() {
		jQuery("input").removeClass("error-box");
		jQuery(".error-text").remove();
		jQuery(".server-error").remove();	
}

function hideAddressChange() {
			jQuery(".add-address-wrapper").remove();
		jQuery(".gray-disable").remove();
}

function hidePasswordChange() {
			jQuery(".change-password-wrapper").remove();
		jQuery(".gray-disable").remove();
}

function savePassword(formdata) { 
		var url = "/account/save-password/"
	        try {
            jQuery.ajax( {
                url : url,
                dataType : 'json',
				data: formdata,
                success : function(data) {
                    processPasswordChange(data);   	        
                }
            });
        } catch (e) {
        }  	
}

function processPasswordChange(return_data) {
	if(return_data.validation == -1) {
		showInputErrors(return_data.errors);		
	} else if(return_data.validation == 0) {
		showServerError();	
	} else if(return_data.validation == 1) {
		updatePassword(return_data)	
	}
}

function updatePassword(data) { 
		jQuery(".change-password-wrapper").remove();
		jQuery(".gray-disable").remove();
		jQuery(".profile-info-wrapper").html(data.html)
}