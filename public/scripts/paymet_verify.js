jQuery(document).ready(function() {
    
	jQuery("#complete_checkout").on("click", function() {
	
		alert("wtf");
		var name = jQuery("input#name").val();
		var number = jQuery("input#number").val();
		var month = jQuery("#month option:selected").val();
		console.debug(month);
		alert("wtf");
		var year = jQuery("#year option:selected").val();
		var ccv = jQuery("input#ccv").val();
		var payment_type = jQuery("input[name='payment_type']:checked").val();
		
		var form_data = { name : name, number : number, month : month, year : year, ccv : ccv, payment_type : payment_type  };
		
		console.debug(form_data);
		//hideInputErrors();
		//createAccount(form_data);

	
	})	
});
