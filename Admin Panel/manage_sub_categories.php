<?php
require('header.php');

$category = '';
$sub_category = '';
$error_message = '';

$type = get_secure_value($database_connection,$_GET['type']);

if($type=='edit'){
			$card_header = 'Edit Sub Category';
			$button_value = 'Proceed To Edit Sub Category';
			$error_type = '$type';
}else {
			$card_header = 'Add Sub Category';
			$button_value = 'Proceed To Add Sub Category';
			$error_type = '$type';
}

if(isset($_GET['id']) && $_GET['id']!=''){

$Id = get_secure_value($database_connection,$_GET['id']);
	
$select_sub_category = "select * from Sub_Categories where Id='$Id'";

$main_select_sub_category = mysqli_query($database_connection,$select_sub_category);

$fetch_sub_category_data = mysqli_fetch_array($main_select_sub_category);

$category = $fetch_sub_category_data['Category'];

$sub_category = $fetch_sub_category_data['Sub_Category'];

}

if(isset($_POST['submit'])){
$category = get_secure_value($database_connection,$_POST['category']);

$sub_category = get_secure_value($database_connection,$_POST['sub_category']);

$sub_category_validation_query = "select * from Sub_Categories where Sub_Category='$sub_category' and Category='$category'";

$main_sub_category_validation_query = mysqli_query($database_connection,$sub_category_validation_query);

$sub_category_validator = mysqli_num_rows($main_sub_category_validation_query);

if($sub_category_validator) {

			$error_message = "Failed to add / edit the sub category ($sub_category) because the sub category already exists";
}else {
			if(isset($_GET['id']) && $_GET['id']!=''){

$id = get_secure_value($database_connection,$_GET['id']);

$update_sub_category = "update Sub_Categories set Sub_Category='$sub_category',Category='$category' where Id='$id'";

$main_update_sub_category = mysqli_query($database_connection,$update_sub_category);

}else{

$insert_sub_category = "insert into Sub_Categories(Category,Sub_Category,Status) values('$category','$sub_category','1')";

$main_insert_sub_category = mysqli_query($database_connection,$insert_sub_category);
 }
 redirect_page('sub_categories.php');
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
									<label for="categories" class=" form-control-label">Category</label>
									<select class="form-control" name="category" required>
												<option value="">Select Category</option>
												<?php  
												$select_categories = mysqli_query($database_connection,"select * from Categories where Status='1'");
												
												while($fetch_categories = mysqli_fetch_array($select_categories)){
												if($fetch_categories['Id'] == $category){
										echo "<option value=".$fetch_categories['Id']." selected>".$fetch_categories['Category']."</option>";						
												}else{
													echo "<option value=".$fetch_categories['Id'].">".$fetch_categories['Category']."</option>";					
												}												
											}
												?>
									</select>				
								</div>
						<div class="form-group">
									<label for="categories" class=" form-control-label">Sub Category</label>		
								<input type="text" name="sub_category" placeholder="Enter Sub Category's Name" class="form-control" required value="<?php echo $sub_category ?>">
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
