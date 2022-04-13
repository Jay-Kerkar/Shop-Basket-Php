<?php 
require('header.php');
?>

<style>
.verify_otp_of_email_id	{
			display:none;
}

.verify_otp_of_mobile_number{
			display:none;
}
</style>

<!-- Breadcrumbs -->
	<div class="breadcrumbs">
		<div class="container">
			<div class="row">
				<div class="col-12">
					<div class="bread-inner">
						<ul class="bread-list">
							<li><a href="home.php">Home<i class="ti-arrow-right"></i></a></li>
							<li class="active"><a href="customer_registration.php">Register</a></li>
						</ul>
					</div>
				</div>
			</div>
		</div>
	</div>
	<!-- End Breadcrumbs -->
  
	<!-- Start Registration Form -->
	<section id="contact-us" class="contact-us section">
		<div class="container">
				<div class="contact-head">
					<div class="row">
						<div class="col-lg-8 col-12">
							<div class="form-main">
								<div class="title">
									<h4>Become A Part Of Our Family,</h4>
									<h3>Just Fill The Form Below</h3>
								</div>
								<form class="form" method="post">
									<div class="row">
										<div class="col-lg-6 col-12">
											<div class="form-group">
												<label>Your Name<span>*</span></label>
												<input id="name" name="name" type="text" placeholder="Enter your name" required>
											</div>
										</div>
										<div class="col-lg-6 col-12">
											<div class="form-group">
												<label>Your Email Id<span>*</span></label>
												<input id="email_id" name="email_id" type="email" placeholder="Enter your email id ">
												<button type="button" class="btn send_otp_to_email_id" id="send_otp_to_email_id" onclick="send_otp_to_email_id()">Send OTP</button>
												<input id="email_id_otp" name="email_id_otp" type="text" class="verify_otp_of_email_id" placeholder="Enter the OTP received on your email-id ">
												<button type="button" class="btn verify_otp_of_email_id" id="verify_otp_of_email_id" name="verify_otp_of_email_id" onclick="verify_otp_of_email_id()">Verify OTP</button>
												<span id="email_id_otp_result"></span>
											</div>	
										<span class="field_error "id="email_id_error"></span>
								</div>
										<div class="col-lg-6 col-12">
											<div class="form-group">
												<label>Your Mobile Number<span>*</span></label> 
												<input id="mobile_number" name="mobile_number" type="number" placeholder=" Enter your mobile number" required>
          
          <button type="button" class="btn send_otp_to_mobile_number" id="send_otp_to_mobile_number" name="send_otp_to_mobile_number" onclick="send_otp_to_mobile_number()">Send OTP</button>
												<input id="mobile_number_otp" name="mobile_number_otp" type="text" class="verify_otp_of_mobile_number" placeholder="Enter the OTP received on your mobile number ">
												<button type="button" class="btn verify_otp_of_mobile_number" id="verify_otp_of_mobile_number" onclick="verify_otp_of_mobile_number()">Verify OTP</button>
												<span id="mobile_number_otp_result"></span>										                                      
											</div>	
											<span class="field_error " id="mobile_number_error"></span>
										</div>
										<div class="col-lg-6 col-10">
											<div class="form-group">
														<label>Gender<span>*</span></label>
										<select name="gender" id="gender">
										<option selected="selected">Select your gender</option>
										<option>Male</option>
										<option>Female</option>
										<option>Others</option>
									</select>
									</div>
										</div>
										<div class="col-lg-6 col-12">
											<div class="form-group">
												<label>Your Password<span>*</span></label>
												<input id="password" name="password" type="password" placeholder="Enter your password" required>
											</div>
										</div>
											<div class="col-lg-6 col-12">
											<div class="form-group">
												<label>Your Confirm Password<span>*</span></label>
												<input id="confirm_password" name="confirm_password" type="password" placeholder="Enter your confirm password" required>
												<span class="field_error "id="password_error"></span>
											</div>
										</div>
										<div class="col-12">
											<div class="form-group button">
												<button type="button" class="btn" id="proceed_to_register" name="proceed_to_register" onclick="customer_registration()" disabled>Proceed To Register</button>
											</div>
										</div>
									</div>
									<div class="field_error" id="registration_error"></div>
								</form>
							</div>
						</div>
					<!-- End Registration Form -->
					
<input type="hidden" id="email_id_verification_status">
<input type="hidden" id="mobile_number_verification_status">

<script>
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

</script>

<?php 
require('footer.php');
?>
