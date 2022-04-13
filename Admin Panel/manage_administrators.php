<?php 
require('header.php');

$administrator_name = '';
$administrator_mobile_number = '';
$administrator_username = '';
$administrator_email_id = '';
$administrator_photo = '';
$administrator_date_of_birth = '';
$administrator_password = '';
$administrator_confirm_password = '';

$error_message = '';
$validator = 'required';
$update_administrator_data = '';

$type = get_secure_value($database_connection,$_GET['type']);

if($type=='edit') {
			$card_header = "Edit Administrator's Information";
			$button_value = "Proceed To Edit Administrator's Information";
			$error_type = '$type';
}else {
			$card_header = 'Add New Administrator';
			$button_value = 'Proceed To Add Administrator';
			$error_type = '$type';
}

if(isset($_GET['id']) && $_GET['id']!=''){
$validator = '';

$Id = get_secure_value($database_connection,$_GET['id']);

$select_administrator = "select * from Administrators where Id='$Id'";

$main_select_administrator = mysqli_query($database_connection,$select_administrator);

$fetch_administrator_data = mysqli_fetch_array($main_select_administrator);

$administrator_name = $fetch_administrator_data['Name'];

$administrator_mobile_number = $fetch_administrator_data['Mobile_Number'];

$administrator_username = $fetch_administrator_data['Username'];

$administrator_email_id = $fetch_administrator_data['Email_Id'];

$administrator_date_of_birth = $fetch_administrator_data['Date_Of_Birth'];

$administrator_password = $fetch_administrator_data['Password'];

$administrator_confirm_password = $fetch_administrator_data['Confirm_Password'];

}

if(isset($_POST['submit'])){
$administrator_name = get_secure_value($database_connection,$_POST['administrator_name']);

$administrator_mobile_number = get_secure_value($database_connection,$_POST['administrator_mobile_number']);

$administrator_username = get_secure_value($database_connection,$_POST['administrator_username']);

$administrator_email_id = get_secure_value($database_connection,$_POST['administrator_email_id']);

$administrator_date_of_birth = get_secure_value($database_connection,$_POST['administrator_date_of_birth']);

$administrator_password = get_secure_value($database_connection,$_POST['administrator_password']);

$administrator_confirm_password = get_secure_value($database_connection,$_POST['administrator_confirm_password']);

$administrator_registration_period = date('d-m-Y h:i:s A');

$administrator_updation_period = date('d-m-Y h:i:s A');

if($administrator_password === $administrator_confirm_password) {

if($_FILES['administrator_photo']['type']!='' && ($_FILES['administrator_photo']['type']!='image/png' || $_FILES['administrator_photo']['type']!='image/jpg' || $_FILES['administrator_photo']['type']!='image/jpeg')) {
			
			$error_message = "Failed to add / edit the administrator ($administrator_name) because the image is not in the format of (Png,Jpg,Jpeg)";
			
}

if(isset($_GET['id']) && $_GET['id']!=''){

if($_FILES['administrator_photo']['name']!=''){
  $administrator_photo  = rand(111111111,999999999).'_'.$_FILES['administrator_photo']['name'];
			move_uploaded_file($_FILES['administrator_photo']['tmp_name'],'../Media/Administrators/'.$administrator_photo);
  
  $update_administrator_data = "update Administrators set Id='$Id',Name='$administrator_name',Mobile_Number='$administrator_mobile_number',Username='$administrator_username',Email_Id='$administrator_email_id',Date_Of_Birth='$administrator_date_of_birth',Password='$administrator_password',Confirm_Password='$administrator_confirm_password',Administrator_Photo='$administrator_photo',Updation_Date_Time='$administrator_updation_period' where Id='$Id'";
  }else{
  			$update_administrator_data = "update Administrators set Id='$Id',Name='$administrator_name',Mobile_Number='$administrator_mobile_number',Username='$administrator_username',Email_Id='$administrator_email_id',Date_Of_Birth='$administrator_date_of_birth',Password='$administrator_password',Confirm_Password='$administrator_confirm_password',Updation_Date_Time='$administrator_updation_period' where Id='$Id'";			
  }
  $main_update_administrator = mysqli_query($database_connection,$update_administrator_data);
   header('location:administrators.php');
die();
}else{

//Validating Email-Id Of Administrator
$email_validation_query = "select * from Administrators where Email_Id = '$administrator_email_id'";

$main_email_validation_query = mysqli_query($database_connection,$email_validation_query);

$email_validation = mysqli_num_rows($main_email_validation_query);

//Validating Mobile Number Of Administrator
$mobile_validation_query = "select * from Administrators where Mobile_Number = '$administrator_mobile_number'";

$main_mobile_validation_query = mysqli_query($database_connection,$mobile_validation_query);

$mobile_validation = mysqli_num_rows($main_mobile_validation_query);

//Validating Username Of Administrator
$username_validation_query = "select * from Administrators where Username = '$administrator_username'";

$main_username_validation_query = mysqli_query($database_connection,$username_validation_query);

$username_validation = mysqli_num_rows($main_username_validation_query);

if($email_validation > 0) {
$error_message = "Failed To Add The Administrator ( $administrator_name ) Because The Email-Id ( $administrator_email_id ) Entered Already Exists";

}else{

if($mobile_validation > 0) {
$error_message = "Failed To Add The Administrator ( $administrator_name ) Because The Mobile Number ( $administrator_mobile_number ) Entered Already Exists";

}else{
if($username_validation > 0) {
$error_message = "Failed To Add The Administrator ( $administrator_name ) Because The Username ( $administrator_username ) Entered Already Exists";

}else{
			$administrator_photo  = rand(111111111,999999999).'_'.$_FILES['administrator_photo']['name'];

move_uploaded_file($_FILES['administrator_photo']['tmp_name'],'../Media/Administrators/'.$administrator_photo);

$insert_administrator = "insert into Administrators(Name,Mobile_Number,Username,Email_Id,Administrator_Photo,Date_Of_Birth,Password,Confirm_Password,Registration_Date_Time,Status) values('$administrator_name','$administrator_mobile_number','$administrator_username','$administrator_email_id','$administrator_photo','$administrator_date_of_birth','$administrator_password','$administrator_confirm_password','$administrator_registration_period','1')";

$main_insert_administrator = mysqli_query($database_connection,$insert_administrator);   

?>

<script>	window.location.href='administrators.php';
</script>

<?php
     }
    }
   }
  }
 }else{
			$error_message = "Failed To Add The Administrator ( $administrator_name ) Because The Passwords Entered Doesn't Match";
 }
}

/*
//Hashing Password And Confirm Password
$secure_password = password_hash($administrator_password,PASSWORD_BCRYPT);

$secure_confirm_password = password_hash($administrator_confirm_password,PASSWORD_BCRYPT);*/

?>

<div class="content pb-0">
            <div class="animated fadeIn">
               <div class="row">
                  <div class="col-lg-12">
                     <div class="card">
                        <div class="card-header"><strong><?php echo $card_header ?></strong></div>
                        <form method="post" enctype="multipart/form-data">
							<div class="card-body card-block">
							   <div class="form-group">
									<label for="categories" class=" form-control-label">Name</label>
									<input type="text" name="administrator_name" placeholder="Enter Administrator's Name" class="form-control" required value="<?php echo $administrator_name ?>">
									
									<label for="categories" class=" form-control-label">Mobile Number</label>
									<input type="number" name="administrator_mobile_number" placeholder="Enter Administrator's Mobile Number" class="form-control" required value="<?php echo $administrator_mobile_number ?>">
									
									<label for="categories" class=" form-control-label">Username</label>
									<input type="text" name="administrator_username" placeholder="Enter Administrator's Username" class="form-control" required value="<?php echo $administrator_username ?>">
									
									<label for="categories" class=" form-control-label">Email Id</label>
									<input type="email" name="administrator_email_id" placeholder="Enter Administrator's Email Id" class="form-control" required value="<?php echo $administrator_email_id ?>">
									
									<label for="categories" class=" form-control-label">Administrator's Photo</label>
									<input type="file" name="administrator_photo" class="form-control" <?php echo  $validator ?>>
																
									<label for="categories" class=" form-control-label">Date Of Birth (DOB)</label>
									<input type="date" name="administrator_date_of_birth" placeholder="Enter Administrator's Date Of Birth" class="form-control" required value="<?php echo $administrator_date_of_birth ?>">
									
									<label for="categories" class=" form-control-label">Password</label>
									<input type="password" name="administrator_password" placeholder="Enter Your Password" class="form-control" required value="<?php echo $administrator_password ?>">
									
									<label for="categories" class=" form-control-label">Confirm Password</label>
									<input type="password" name="administrator_confirm_password" placeholder="Re-Enter Your Password" class="form-control" required value="<?php echo $administrator_confirm_password ?>">
									
								</div>
							   <button id="payment-button" name="submit" type="submit" class="btn btn-lg btn-info btn-block">
							   <span id="payment-button-amount"><?php echo $button_value ?></span>
							   </button>
							   <div class="field_error"><?php echo $error_message ?></div>
							</div>
						</form>
                     </div>
                  </div>
               </div>
            </div>
         </div>
         
<?php require('footer.php'); ?>
