<?php
require('header.php');

$category = '';
$error_message = '';

$type = get_secure_value($database_connection,$_GET['type']);

if($type=='edit'){
			$card_header = 'Edit Category';
			$button_value = 'Proceed To Edit Category';
			$error_type = '$type';
}else {
			$card_header = 'Add Category';
			$button_value = 'Proceed To Add Category';
			$error_type = '$type';
}

if(isset($_GET['id']) && $_GET['id']!=''){

$Id = get_secure_value($database_connection,$_GET['id']);
	
$select_category = "select * from Categories where Id='$Id'";

$main_select_category = mysqli_query($database_connection,$select_category);

$fetch_category_data = mysqli_fetch_array($main_select_category);

$validate_category = mysqli_num_rows($main_select_category);

if($validate_category > 0){
			$category = $fetch_category_data['Category'];
}else{
			redirect_page('categories.php');
}

}

if(isset($_POST['submit'])){
$category = get_secure_value($database_connection,$_POST['category']);

$category_validation_query = "select * from Categories where Category='$category'";

$main_category_validation_query = mysqli_query($database_connection,$category_validation_query);

$category_validator = mysqli_num_rows($main_category_validation_query);

if($category_validator) {

			$error_message = "Failed to add / edit the category ($category) because the category already exists";
}else {
			if(isset($_GET['id']) && $_GET['id']!=''){

$id = get_secure_value($database_connection,$_GET['id']);

$update_category = "update Categories set Category='$category' where Id='$id'";

$main_update_category = mysqli_query($database_connection,$update_category);

}else{

$insert_category = "insert into Categories(Category,Status) values('$category','1')";

$main_insert_category = mysqli_query($database_connection,$insert_category);
 }
redirect_page('categories.php');
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
									<input type="text" name="category" placeholder="Enter Category's Name" class="form-control" required value="<?php echo $category ?>">
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
