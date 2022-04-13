<?php
require('header.php');

$color = '';
$error_message = '';

$type = get_secure_value($database_connection,$_GET['type']);

if($type=='edit'){
			$card_header = 'Edit Color';
			$button_value = 'Proceed To Edit Color';
			$error_type = '$type';
}else {
			$card_header = 'Add Color';
			$button_value = 'Proceed To Add Color';
			$error_type = '$type';
}

if(isset($_GET['id']) && $_GET['id']!=''){

$Id = get_secure_value($database_connection,$_GET['id']);
	
$select_color = "select * from Colors where Id='$Id'";

$main_select_color = mysqli_query($database_connection,$select_color);

$fetch_color_data = mysqli_fetch_array($main_select_color);

$color = $fetch_color_data['Color'];

}

if(isset($_POST['submit'])){
$color = get_secure_value($database_connection,$_POST['color']);

$color_validation_query = "select * from Colors where Color='$color'";

$main_color_validation_query = mysqli_query($database_connection,$color_validation_query);

$color_validator = mysqli_num_rows($main_color_validation_query);

if($color_validator) {

			$error_message = "Failed to add / edit the color ($color) because the color already exists";
}else {
			if(isset($_GET['id']) && $_GET['id']!=''){

$id = get_secure_value($database_connection,$_GET['id']);

$update_color = "update Colors set Color='$color' where Id='$id'";

$main_update_color = mysqli_query($database_connection,$update_color);

}else{

$insert_color = "insert into Colors(Color,Status) values('$color','1')";

$main_insert_color = mysqli_query($database_connection,$insert_color);
 }
 
redirect_page('colors.php');
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
									<label for="Colors" class=" form-control-label">Color</label>
									<input type="text" name="color" placeholder="Enter Color's Name" class="form-control" required value="<?php echo $color ?>">
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
