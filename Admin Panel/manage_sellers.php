<?php 
require('header.php');

$seller_name = '';
$seller_mobile_number = '';
$seller_username = '';
$seller_email_id = '';
$seller_photo = '';
$seller_date_of_birth = '';
$seller_password = '';
$seller_confirm_password = '';

$error_message = '';
$validator = 'required';
$update_seller_data = '';

$type = get_secure_value($database_connection,$_GET['type']);

if($type=='edit') {
			$card_header = "Edit Seller's Information";
			$button_value = "Proceed To Edit Seller's Information";
			$error_type = '$type';
}else {
			$card_header = 'Add New Seller';
			$button_value = 'Proceed To Add Seller';
			$error_type = '$type';
}

if(isset($_GET['id']) && $_GET['id']!=''){
$validator = '';

$Id = get_secure_value($database_connection,$_GET['id']);

$select_seller = "select * from Sellers where Id='$Id'";

$main_select_seller = mysqli_query($database_connection,$select_seller);

$fetch_seller_data = mysqli_fetch_array($main_select_seller);

$seller_name = $fetch_seller_data['Name'];

$seller_mobile_number = $fetch_seller_data['Mobile_Number'];

$seller_username = $fetch_seller_data['Username'];

$seller_email_id = $fetch_seller_data['Email_Id'];

$seller_date_of_birth = $fetch_seller_data['Date_Of_Birth'];

$seller_password = $fetch_seller_data['Password'];

$seller_confirm_password = $fetch_seller_data['Confirm_Password'];

}

if(isset($_POST['submit'])){
$seller_name = get_secure_value($database_connection,$_POST['seller_name']);

$seller_mobile_number = get_secure_value($database_connection,$_POST['seller_mobile_number']);

$seller_username = get_secure_value($database_connection,$_POST['seller_username']);

$seller_email_id = get_secure_value($database_connection,$_POST['seller_email_id']);

$seller_date_of_birth = get_secure_value($database_connection,$_POST['seller_date_of_birth']);

$seller_password = get_secure_value($database_connection,$_POST['seller_password']);

$seller_confirm_password = get_secure_value($database_connection,$_POST['seller_confirm_password']);

$seller_registration_period = date('d-m-Y h:i:s A');

$seller_updation_period = date('d-m-Y h:i:s A');

if($seller_password === $seller_confirm_password) {

if($_FILES['seller_photo']['type']!='' && ($_FILES['seller_photo']['type']!='image/png' || $_FILES['seller_photo']['type']!='image/jpg' || $_FILES['seller_photo']['type']!='image/jpeg')) {
			
			$error_message = "Failed to add / edit the seller ($seller_name) because the image is not in the format of (Png,Jpg,Jpeg)";
			
}

if(isset($_GET['id']) && $_GET['id']!=''){

if($_FILES['seller_photo']['name']!=''){
  $seller_photo  = rand(111111111,999999999).'_'.$_FILES['seller_photo']['name'];
			move_uploaded_file($_FILES['seller_photo']['tmp_name'],'../Media/Sellers/'.$seller_photo);
  
  $update_seller_data = "update Sellers set Id='$Id',Name='$seller_name',Mobile_Number='$seller_mobile_number',Username='$seller_username',Email_Id='$seller_email_id',Date_Of_Birth='$seller_date_of_birth',Password='$seller_password',Confirm_Password='$seller_confirm_password',seller_Photo='$seller_photo',Updation_Date_Time='$seller_updation_period' where Id='$Id'";
  }else{
  			$update_seller_data = "update Sellers set Id='$Id',Name='$seller_name',Mobile_Number='$seller_mobile_number',Username='$seller_username',Email_Id='$seller_email_id',Date_Of_Birth='$seller_date_of_birth',Password='$seller_password',Confirm_Password='$seller_confirm_password',Updation_Date_Time='$seller_updation_period' where Id='$Id'";			
  }
  $main_update_seller = mysqli_query($database_connection,$update_seller_data);
   header('location:sellers.php');
die();
}else{

//Validating Email-Id Of Seller
$email_validation_query = "select * from Sellers where Email_Id = '$seller_email_id'";

$main_email_validation_query = mysqli_query($database_connection,$email_validation_query);

$email_validation = mysqli_num_rows($main_email_validation_query);

//Validating Mobile Number Of seller
$mobile_validation_query = "select * from Sellers where Mobile_Number = '$seller_mobile_number'";

$main_mobile_validation_query = mysqli_query($database_connection,$mobile_validation_query);

$mobile_validation = mysqli_num_rows($main_mobile_validation_query);

//Validating Username Of Seller
$username_validation_query = "select * from Sellers where Username = '$seller_username'";

$main_username_validation_query = mysqli_query($database_connection,$username_validation_query);

$username_validation = mysqli_num_rows($main_username_validation_query);

if($email_validation > 0) {
$error_message = "Failed To Add The Seller ( $seller_name ) Because The Email-Id ( $seller_email_id ) Entered Already Exists";

}else{

if($mobile_validation > 0) {
$error_message = "Failed To Add The Seller ( $seller_name ) Because The Mobile Number ( $seller_mobile_number ) Entered Already Exists";

}else{
if($username_validation > 0) {
$error_message = "Failed To Add The Seller ( $seller_name ) Because The Username ( $seller_username ) Entered Already Exists";

}else{
			$seller_photo  = rand(111111111,999999999).'_'.$_FILES['seller_photo']['name'];

move_uploaded_file($_FILES['seller_photo']['tmp_name'],'../Media/Sellers/'.$seller_photo);

$insert_seller = "insert into Sellers(Name,Mobile_Number,Username,Email_Id,seller_Photo,Date_Of_Birth,Password,Confirm_Password,Registration_Date_Time,Status) values('$seller_name','$seller_mobile_number','$seller_username','$seller_email_id','$seller_photo','$seller_date_of_birth','$seller_password','$seller_confirm_password','$seller_registration_period','1')";

$main_insert_seller = mysqli_query($database_connection,$insert_seller);   

?>

<script>	window.location.href='sellers.php';
</script>

<?php
     }
    }
   }
  }
 }else{
			$error_message = "Failed To Add The Seller ( $seller_name ) Because The Passwords Entered Doesn't Match";
 }
}

/*
//Hashing Password And Confirm Password
$secure_password = password_hash($seller_password,PASSWORD_BCRYPT);

$secure_confirm_password = password_hash($seller_confirm_password,PASSWORD_BCRYPT);*/

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
									<input type="text" name="seller_name" placeholder="Enter Seller's Name" class="form-control" required value="<?php echo $seller_name ?>">
									
									<label for="categories" class=" form-control-label">Mobile Number</label>
									<input type="number" name="seller_mobile_number" placeholder="Enter Seller's Mobile Number" class="form-control" required value="<?php echo $seller_mobile_number ?>">
									
									<label for="categories" class=" form-control-label">Username</label>
									<input type="text" name="seller_username" placeholder="Enter Seller's Username" class="form-control" required value="<?php echo $seller_username ?>">
									
									<label for="categories" class=" form-control-label">Email Id</label>
									<input type="email" name="seller_email_id" placeholder="Enter Seller's Email Id" class="form-control" required value="<?php echo $seller_email_id ?>">
									
									<label for="categories" class=" form-control-label">Seller's Photo</label>
									<input type="file" name="seller_photo" class="form-control" <?php echo  $validator ?>>
																
									<label for="categories" class=" form-control-label">Date Of Birth (DOB)</label>
									<input type="date" name="seller_date_of_birth" placeholder="Enter Seller's Date Of Birth" class="form-control" required value="<?php echo $seller_date_of_birth ?>">
									
									<label for="categories" class=" form-control-label">Password</label>
									<input type="password" name="seller_password" placeholder="Enter Your Password" class="form-control" required value="<?php echo $seller_password ?>">
									
									<label for="categories" class=" form-control-label">Confirm Password</label>
									<input type="password" name="seller_confirm_password" placeholder="Re-Enter Your Password" class="form-control" required value="<?php echo $seller_confirm_password ?>">
									
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
