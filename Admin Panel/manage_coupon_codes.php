<?php
require('header.php');

$coupon_code = '';
$coupon_code_value = '';
$coupon_code_type = '';
$cart_minimum_value = '';

$error_message = '';

$type = get_secure_value($database_connection,$_GET['type']);

if($type=='edit'){
			$card_header = 'Edit Coupon Code';
			$button_value = 'Proceed To Edit Coupon Code';
}else {
			$card_header = 'Add Coupon Code';
			$button_value = 'Proceed To Add Coupon Code';
}

if(isset($_GET['id']) && $_GET['id']!=''){

	$Id = get_secure_value($database_connection,$_GET['id']);
	
	$select_coupon_code_for_updation = "select * from Coupon_Codes where Id = '$Id'";
	
	$main_select_coupon_code_for_updation = mysqli_query($database_connection,$select_coupon_code_for_updation);
	
	$coupon_code_validator_for_updation = mysqli_num_rows($main_select_coupon_code_for_updation);
	
if($coupon_code_validator_for_updation > 0){
	$fetch_coupon_code_data_for_updation = mysqli_fetch_array($main_select_coupon_code_for_updation);
		 
		$coupon_code = $fetch_coupon_code_data_for_updation['Coupon_Code'];
		
		$coupon_code_value = $fetch_coupon_code_data_for_updation['Coupon_Code_Value'];
		
		$coupon_code_type = $fetch_coupon_code_data_for_updation['Coupon_Code_Type'];
		
		$cart_minimum_value = $fetch_coupon_code_data_for_updation['Cart_Minimum_Value'];
				
	}else{
	
		header('location:coupon_codes.php');
		die();
		
	}
}

if(isset($_POST['submit'])){

	$coupon_code = get_secure_value($database_connection,$_POST['coupon_code']);
		
		$coupon_code_value = get_secure_value($database_connection,$_POST['coupon_code_value']);
		
		$coupon_code_type = get_secure_value($database_connection,$_POST['coupon_code_type']);
		
		$cart_minimum_value = get_secure_value($database_connection,$_POST['cart_minimum_value']);
	
	$select_coupon_code = "select * from Coupon_Codes where Coupon_Code = '$coupon_code'";
	
	$main_select_coupon_code = mysqli_query($database_connection,$select_coupon_code);
	
	$coupon_code_validator = mysqli_num_rows($main_select_coupon_code);
	
	if($coupon_code_validator){
	
		if(isset($_GET['id']) && $_GET['id']!=''){
		
			$fetch_coupon_code_data = mysqli_fetch_array($main_select_coupon_code);
			if($Id == $fetch_coupon_code_data['Id']){
			
			}else{
				$error_message = "Failed to add / edit the coupon code ($coupon_code) because the coupon code already exists";
			}
		}else{	
			$error_message = "Failed to add / edit the coupon code ($coupon_code) because the coupon code already exists";
		}
}

if($error_message == ''){

		if(isset($_GET['id']) && $_GET['id']!=''){
		
		$update_coupon_code ="update Coupon_Codes set Coupon_Code='$coupon_code',Coupon_Code_Value='$coupon_code_value',Coupon_Code_Type='$coupon_code_type',Cart_Minimum_Value='$cart_minimum_value' where Id='$Id'";
		
		$main_update_coupon_code = mysqli_query($database_connection,$update_coupon_code);
	
}else{

				$insert_coupon_code ="insert into Coupon_Codes(Coupon_Code,Coupon_Code_Value,Coupon_Code_Type,Cart_Minimum_Value,Status) values('$coupon_code','$coupon_code_value','$coupon_code_type','$cart_minimum_value','1')";
			
			$main_insert_coupon_code = mysqli_query($database_connection,$insert_coupon_code);
			
		 	}
?>
<script>			window.location.href='coupon_codes.php'
</script>
<?php
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
									<label for="categories" class=" form-control-label">Coupon Code</label>
									<input type="text" name="coupon_code" placeholder="Enter Coupon Code" class="form-control" required value="<?php echo $coupon_code ?>">
								</div>
								
								<div class="form-group">
									<label for="categories" class=" form-control-label">Coupon Code Value</label>
									<input type="number" name="coupon_code_value" placeholder="Enter Coupon Code Value" class="form-control" required value="<?php echo $coupon_code_value ?>">
							
									<label for="categories" class=" form-control-label">Coupon Code Type</label>
									<select name="coupon_code_type" class="form-control">
												<?php  
if($coupon_code_type == 'Percentage') {
	 echo '<option>Select Coupon Code Type</option>';
	 echo '<option value="Percentage" selected>Percentage</option>';
		echo '<option value="Value">Value</option>';												
}else if($coupon_code_type == 'Value'){
	 echo '<option>Select Coupon Code Type</option>';
	 echo '<option value="Percentage">Percentage</option>';
		echo '<option value="Value" selected>Value</option>';														
}else{
  echo '<option selected>Select Coupon Code Type</option>';		
  echo '<option value="Percentage">Percentage</option>';
		echo '<option value="Value">Value</option>';	
}
												?>
									</select>
								
									<label for="categories" class=" form-control-label">Cart Minimum Value</label>
									<input type="number" name="cart_minimum_value" placeholder="Enter Cart Minimum Value" class="form-control" required value="<?php echo $cart_minimum_value ?>">
								</div>
																
							   <button id="payment-button" name="submit" type="submit" class="btn btn-lg btn-info btn-block">
							   <span id="payment-button-amount"><?php echo $button_value ?>
							   </span>
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
