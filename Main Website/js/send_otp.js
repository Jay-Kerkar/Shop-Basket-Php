function sendOtpToEmailId() {

jQuery('#email_id_error').html('');

		var email_id = jQuery('#email_id').val();
	
	if(email_id == '') {	
		jQuery('#email_id_error').html('Please Enter Your Email Id');
	
	}else { 	jQuery('.send_otp_to_email_id').html('Please Wait...');
jQuery('.send_otp_to_email_id').attr('disabled',true);

			jQuery.ajax({
			url:'send_otp.php',
			type:'post',			data:'email_id='+email_id+'&type=email_id',
			success:function(result){
					if(result=='OTP Sent Successfully To The Email Id'){
					jQuery('#email_id').attr('disabled',true);		jQuery('.verify_otp_of_email_id').show();		jQuery('.send_otp_to_email_id').hide();

					}else  if(result=='Email Id Already Exists'){
jQuery('#email_id_error').html('Sorry, failed to register the customer because the email-id entered already exists');					
jQuery('.send_otp_to_email_id').html('Send OTP');
jQuery('.send_otp_to_email_id').attr('disabled',false);
			}else{
jQuery('.send_otp_to_email_id').html('Send OTP');
jQuery('.send_otp_to_email_id').attr('disabled',false);
					
jQuery('#email_id_error').html('Please Try After Sometime');		
						
					}
				}
			});					
 } 
}

function verifyOtpOfEmailId() {

jQuery('#email_id_error').html('');

		var email_id_otp = jQuery('#email_id_otp').val();
	
	if(email_id_otp == '') {	
		jQuery('#email_id_error').html('Please Enter The OTP Received On Your Email-Id');
	
	}else {
	
	 jQuery.ajax({
			url:'verify_otp.php',
			type:'post',			data:'email_id_otp='+email_id_otp+'&type=email_id',
			success:function(result){
			if(result=='Email Id OTP Verified Successfully'){
						jQuery('.verify_otp_of_email_id').hide();		jQuery('#email_id_otp_result').html('Email Id Verified Successfully');
						
jQuery('#email_id_verification_status').val('Email Id Verified');
    if(jQuery('#mobile_number_verification_status').val() == 'Mobile Number Verified') {	        jQuery('#proceed_to_register').attr('disabled',false);
      }
					}else{
								
jQuery('#email_id_otp_result').html('Please Enter Correct OTP');		
						
					}
				}
			});		
 }
}

function sendOtpToMobileNumber() {

jQuery('#mobile_number_error').html('');
		var mobile_number = jQuery('#mobile_number').val();
	
	if(mobile_number == '') {	
		jQuery('#mobile_number_error').html('Please Enter Your Mobile Number');
	
	}else { 
		jQuery('.send_otp_to_mobile_number').html('Please Wait...');
jQuery('.send_otp_to_mobile_number').attr('disabled',true);

			jQuery.ajax({
			url:'send_otp.php',
			type:'post',			data:'mobile_number='+mobile_number+'&type=mobile_number',
			success:function(result){
					if(result=='OTP Sent Successfully To The Mobile Number'){
					jQuery('#mobile_number').attr('disabled',true);		jQuery('.verify_otp_of_mobile_number').show();		jQuery('.send_otp_to_mobile_number').hide();

					}else if(result=='Mobile Number Already Exists'){
jQuery('#mobile_number_error').html('Sorry, failed to register the customer because the mobile number entered already exists');					
jQuery('.send_otp_to_mobile_number').html('Send OTP');
jQuery('.send_otp_to_mobile_number').attr('disabled',false);
			}else{
jQuery('.send_otp_to_mobile_number').html('Send OTP');
jQuery('.send_otp_to_mobile_number').attr('disabled',false);
					
jQuery('#mobile_number_error').html('Please Try After Sometime');		
						
					}
				}
			});					
 } 
}

function verifyOtpOfMobileNumber(){

jQuery('#mobile_number_error').html('');
		var mobile_number_otp = jQuery('#mobile_number_otp').val();
	
	if(mobile_number_otp == '') {	
		jQuery('#mobile_number_error').html('Please Enter The OTP Received On Your Mobile Number');
	
	}else {
	
	 jQuery.ajax({
			url:'verify_otp.php',
			type:'post',			data:'mobile_number_otp='+mobile_number_otp+'&type=mobile_number',
			success:function(result){
			if(result=='Mobile Number OTP Verified Successfully'){
						jQuery('.verify_otp_of_mobile_number').hide();		jQuery('#mobile_number_otp_result').html('Mobile Number Verified Successfully');
						
jQuery('#mobile_number_verification_status').val('Mobile Number Verified');

if(jQuery('#email_id_verification_status').val() == 'Email Id Verified') {	        jQuery('#proceed_to_register').attr('disabled',false);
      }
					}else{
					
jQuery('#mobile_number_otp_result').html('Please Enter Correct OTP');		
						
					}
				}
			});		
 }
}
