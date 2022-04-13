<?php
require('header.php');

$size = '';
$sorting_order = '';
$error_message = '';

$type = get_secure_value($database_connection,$_GET['type']);

if($type=='edit'){
			$card_header = 'Edit Size';
			$button_value = 'Proceed To Edit Size';
			$error_type = '$type';
}else {
			$card_header = 'Add Size';
			$button_value = 'Proceed To Add Size';
			$error_type = '$type';
}

if(isset($_GET['id']) && $_GET['id']!=''){

$Id = get_secure_value($database_connection,$_GET['id']);
	
$select_size = "select * from Sizes where Id='$Id'";

$main_select_size = mysqli_query($database_connection,$select_size);

$fetch_size_data = mysqli_fetch_array($main_select_size);

$size = $fetch_size_data['Size'];
$sorting_order = $fetch_size_data['Sorting_Order'];

}

if(isset($_POST['submit'])){
$size = get_secure_value($database_connection,$_POST['size']);

$sorting_order = get_secure_value($database_connection,$_POST['sorting_order']);

if($type == 'add'){
$size_validation_query = "select * from Sizes where Size='$size'";

$main_size_validation_query = mysqli_query($database_connection,$size_validation_query);

$size_validator = mysqli_num_rows($main_size_validation_query);
}

if($size_validator) {

			$error_message = "Failed to add / edit the size ($size) because the size already exists";
}else {
			if(isset($_GET['id']) && $_GET['id']!=''){

$id = get_secure_value($database_connection,$_GET['id']);

$update_size = "update Sizes set Size='$size',Sorting_Order='$sorting_order' where Id='$id'";

$main_update_size = mysqli_query($database_connection,$update_size);

}else{

$insert_size = "insert into Sizes(Size,Sorting_Order,Status) values('$size','$sorting_order','1')";

$main_insert_size = mysqli_query($database_connection,$insert_size);
 }
redirect_page('sizes.php');
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
									<label for="Sizes" class=" form-control-label">Size</label>
									<input type="text" name="size" placeholder="Enter Size" class="form-control" required value="<?php echo $size ?>">
							</div>
								<div class="form-group">
									<label for="Sizes" class=" form-control-label">Sorting Order</label>
									<input type="text" name="sorting_order" placeholder="Enter Sorting Order" class="form-control" required value="<?php echo $sorting_order ?>">
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
