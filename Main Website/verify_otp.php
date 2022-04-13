<?php
require('database_connection.php');
require('functions.php');

$type = get_secure_value($database_connection,$_POST['type']);

$email_id_otp = get_secure_value($database_connection,$_POST['email_id_otp']);

$mobile_number_otp = get_secure_value($database_connection,$_POST['mobile_number_otp']);

if($type=='email_id'){

	if($email_id_otp == $_SESSION['EMAIL_ID_OTP']){	
	
		unset($_SESSION['EMAIL_OTP']);
		echo "Email Id OTP Verified Successfully";
		
	}else{
	
		echo "Failed To Verify Email Id OTP";
		
	}
}

if($type == 'mobile_number'){

	if($mobile_number_otp == $_SESSION['MOBILE_NUMBER_OTP']){
		unset($_SESSION['MOBILE_NUMBER_OTP']);
		echo "Mobile Number OTP Verified Successfully";
		
	}else{
	
		echo "Failed To Verify Mobile Numbe OTP";
		
	}
}
?>
