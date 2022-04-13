<?php
require('header.php');

$payment_status = '';
$error_message = '';

$type = get_secure_value($database_connection,$_GET['type']);

if($type=='edit'){
			$card_header = 'Edit Payment Status';
			$button_value = 'Proceed To Edit Payment Status';
			$error_type = '$type';
}else {
			$card_header = 'Add Payment Status';
			$button_value = 'Proceed To Add Payment Status';
			$error_type = '$type';
}

if(isset($_GET['id']) && $_GET['id']!=''){

$Id = get_secure_value($database_connection,$_GET['id']);
	
$select_payment_status = "select * from Payment_Status where Id='$Id'";

$main_select_payment_status = mysqli_query($database_connection,$select_payment_status);

$fetch_payment_status = mysqli_fetch_array($main_select_payment_status);

$payment_status = $fetch_payment_status['Status'];

}

if(isset($_POST['submit'])){
$payment_status = get_secure_value($database_connection,$_POST['payment_status']);

$payment_status_validation_query = "select * from Payment_Status where Status='$payment_status'";

$main_payment_status_validation_query = mysqli_query($database_connection,$payment_status_validation_query);

$payment_status_validator = mysqli_num_rows($main_payment_status_validation_query);

if($payment_status_validator) {

			$error_message = "Failed to add / edit the Payment Status ($payment_status) because the Payment Status already exists";
}else {
			if(isset($_GET['id']) && $_GET['id']!=''){

$id = get_secure_value($database_connection,$_GET['id']);

$update_payment_status = "update Payment_Status set Status='$payment_status' where Id='$id'";

$main_update_payment_status = mysqli_query($database_connection,$update_payment_status);

}else{

$insert_payment_status = "insert into Payment_Status(Status) values('$payment_status')";

$main_insert_payment_status = mysqli_query($database_connection,$insert_payment_status);
 }
header('location:status.php');
 }
}
?>

<div class="content pb-0">
            <div class="animated fadeIn">
               <div class="row">
                  <div class="col-lg-12">
                     <div class="card">
                        <div class="card-header"><strong><?php echo $card_header ?></strong></div>
                        <form method="post">
							<div class="card-body card-block">
							   <div class="form-group">
									<label for="categories" class=" form-control-label">Payment Status</label>
									<input type="text" name="payment_status" placeholder="Enter Payment Status" class="form-control" required value="<?php echo $payment_status ?>">
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
<?php
require('footer.php');
?>
