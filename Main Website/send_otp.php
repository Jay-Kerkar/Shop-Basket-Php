<?php
require('database_connection.php');
require('functions.php');

$type = get_secure_value($database_connection,$_POST['type']);

if($type=='email_id'){

$email_id = get_secure_value($database_connection,$_POST['email_id']);

$verify_customer_email_id = mysqli_num_rows(mysqli_query($database_connection,"select * from Customers where Email_Id='$email_id'"));
	
if($verify_customer_email_id > 0){
		echo "Email Id Already Exists";
		die();
}
	
$email_id_otp = rand(111111,999999);	$_SESSION['EMAIL_ID_OTP'] = $email_id_otp;
$email_message = "The $email_id_otp Is Your OTP To Verify Your Email Id - Ecommerce Website";
	
/*send_message_to_email_id("snackspace.gaming@gmail.com","snackspace.gaming@gmail.com","SnackSpace@5321","Customer Email Id Verification - Ecommerce Website",$email_message,$email_id,"OTP Sent Successfully To The Email Id");*/

}

if($type=='mobile_number'){

	$mobile_number = get_secure_value($database_connection,$_POST['mobile_number']);
	
	$verify_customer_mobile_number = mysqli_num_rows(mysqli_query($database_connection,"select * from Customers where Mobile_Number='$mobile_number'"));
	
if($verify_customer_mobile_number > 0){
		echo "Mobile Number Already Exists";
		die();
	}
	
	$mobile_number_otp = rand(111111,999999);
	$_SESSION['MOBILE_NUMBER_OTP'] = $mobile_number_otp;
	$mobile_message = "The $mobile_number_otp Is Your OTP To Verify Your Mobile Number - Ecommerce Website";
 $success_message		= "OTP Sent Successfully To The Mobile Number";
 	send_message_to_mobile_number($mobile_number,$mobile_message,$success_message);
			
}
?>
