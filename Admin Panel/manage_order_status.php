<?php
require('header.php');

$order_status = '';
$error_message = '';

$type = get_secure_value($database_connection,$_GET['type']);

if($type=='edit'){
			$card_header = 'Edit Order Status';
			$button_value = 'Proceed To Edit Order Status';
			$error_type = '$type';
}else {
			$card_header = 'Add Order Status';
			$button_value = 'Proceed To Add Order Status';
			$error_type = '$type';
}

if(isset($_GET['id']) && $_GET['id']!=''){

$Id = get_secure_value($database_connection,$_GET['id']);
	
$select_order_status = "select * from Order_Status where Id='$Id'";

$main_select_order_status = mysqli_query($database_connection,$select_order_status);

$fetch_order_status = mysqli_fetch_array($main_select_order_status);

$order_status = $fetch_order_status['Status'];

}

if(isset($_POST['submit'])){
$order_status = get_secure_value($database_connection,$_POST['order_status']);

$order_status_validation_query = "select * from Order_Status where Status='$order_status'";

$main_order_status_validation_query = mysqli_query($database_connection,$order_status_validation_query);

$order_status_validator = mysqli_num_rows($main_order_status_validation_query);

if($order_status_validator) {

			$error_message = "Failed to add / edit the order status ($order_status) because the order status already exists";
}else {
			if(isset($_GET['id']) && $_GET['id']!=''){

$id = get_secure_value($database_connection,$_GET['id']);

$update_order_status = "update Order_Status set Status='$order_status' where Id='$id'";

$main_update_order_status = mysqli_query($database_connection,$update_order_status);

}else{

$insert_order_status = "insert into Order_Status(Status) values('$order_status')";

$main_insert_order_status = mysqli_query($database_connection,$insert_order_status);
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
									<label for="categories" class=" form-control-label">Order Status</label>
									<input type="text" name="order_status" placeholder="Enter Order Status Name" class="form-control" required value="<?php echo $order_status ?>">
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
