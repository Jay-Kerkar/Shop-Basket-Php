function customer_registration(){

	var name = jQuery("#name").val();
	var email_id = jQuery("#email_id").val();
	var mobile_number = jQuery("#mobile_number").val();
	var gender = jQuery("#gender").val();
	var password = jQuery("#password").val();
	var confirm_password = jQuery("#confirm_password").val();

    if(password == confirm_password) {
        jQuery.ajax({
		url:'registration.php',
		type:'post',			
        data:'name='+name+'&email_id='+email_id+'&mobile_number='+mobile_number+'&gender='+gender+'&password='+password+'&confirm_password='+confirm_password,
		success:function(result){
            if(result=='Email Id Already Exists'){					
                jQuery('#email_id_error').html('Sorry, failed to register the customer because the email-id entered already exists');
			     }
            if(result=='Mobile Number Already Exists'){					
                jQuery('#mobile_number_error').html('Sorry, failed to register the customer because the mobile number entered already exists');
		       }
            if(result=='Customer Registered Successfully'){				
                jQuery('#registration_error').html('Congratulations, You Have Been Registered Successfully');
			}
        }
    });
  }else{			
    jQuery('#password_error').html('Sorry, failed to register the customer because the passwords entered does not matched');
    }
}