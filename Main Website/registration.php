<?php  
require('database_connection.php');
require('functions.php');

$name = get_secure_value($database_connection,$_POST['name']);

$email_id = get_secure_value($database_connection,$_POST['email_id']);

$mobile_number = get_secure_value($database_connection,$_POST['mobile_number']);

$gender = get_secure_value($database_connection,$_POST['gender']);

$password = get_secure_value($database_connection,$_POST['password']);

$confirm_password = get_secure_value($database_connection,$_POST['confirm_password']);

$registration_period = date('d-m-Y h:i A');

//Validating Email-Id Of Customer
$email_validation_query = "select * from Customers where Email_Id = '$email_id'";

$main_email_validation_query = mysqli_query($database_connection,$email_validation_query);

$email_validation = mysqli_num_rows($main_email_validation_query);

//Validating Mobile Number Of Customer
$mobile_validation_query = "select * from Customers where Mobile_Number = '$mobile_number'";

$main_mobile_validation_query = mysqli_query($database_connection,$mobile_validation_query);

$mobile_validation = mysqli_num_rows($main_mobile_validation_query);

if($email_validation > 0) {

			echo "Email Id Already Exists";
			
}else {

if($mobile_validation > 0) {

echo "Mobile Number Already Exists";

}else {

	$insert_query = "insert into Customers(Name,Email_Id,Mobile_Number,Gender,Password,Confirm_Password,Registration_Date_Time) values('$name','$email_id','$mobile_number','$gender','$password','$confirm_password','$registration_period')";

$main_insert_query = mysqli_query($database_connection,$insert_query);

$_SESSION['CUSTOMER_LOGIN'] = 'yes';

echo "Customer Registered Successfully";
 }
}
?>
