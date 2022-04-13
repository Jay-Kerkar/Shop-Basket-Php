<?php 
require('header.php'); 
?>

<?php 
$fetch_data_error = 0;

//Fetching Total Orders

$fetch_total_orders = mysqli_query($database_connection,"select Id from Orders");

$total_orders = mysqli_num_rows($fetch_total_orders);

if($total_orders) {
		$no_of_orders = $total_orders;
}else {
		$no_of_orders = $fetch_data_error;
}

//Fetching Total Products

$fetch_total_products = mysqli_query($database_connection,"select Id from Products");

$total_products = mysqli_num_rows($fetch_total_products);

if($total_products) {
		$no_of_products = $total_products;
}else {
		$no_of_products = $fetch_data_error;
}

//Fetching Total Categories

$fetch_total_categories = mysqli_query($database_connection,"select Id from Categories");

$total_categories = mysqli_num_rows($fetch_total_categories);

if($total_categories) {
		$no_of_categories = $total_categories;
}else {
		$no_of_categories = $fetch_data_error;
}

//Fetching Total Administrators

$fetch_total_administrators = mysqli_query($database_connection,"select Id from Administrators");

$total_administrators = mysqli_num_rows($fetch_total_administrators);

if($total_administrators) {
		$no_of_administrators = $total_administrators;
}else {
  $no_of_administrators = $fetch_data_error;
}

//Fetching Total Customers

$fetch_total_customers = mysqli_query($database_connection,"select Id from Customers");

$total_customers = mysqli_num_rows($fetch_total_customers);

if($total_customers) {
		$no_of_customers = $total_customers;
}else {
  $no_of_customers = $fetch_data_error;
}

//Fetching Total Complaints_Suggestions

$fetch_total_complaints_suggestions = mysqli_query($database_connection,"select Id from Complaints_Suggestions");

$total_complaints_suggestions = mysqli_num_rows($fetch_total_complaints_suggestions);

if($total_complaints_suggestions) {
		$no_of_complaints_suggestions = $total_complaints_suggestions;
}else {
		$no_of_complaints_suggestions = $fetch_data_error; 
}
?>

<div class="content pb-0">
	<div class="orders">
	   <div class="row">
		  <div class="col-xl-12">
			 <div class="card">
				<div class="card-body">
				   <h4 class="box-title">Dashboard | Ecommerce Website</h4>
				</div>
				<div class="card-body--">
				   <div class="table-stats order-table ov-h">
					  <table class="table ">
						 <thead>
							<tr>
	        <th>Total Orders</th>
							   <th>Total Products</th>
							   <th>Total Categories</th>
							   <th>Total Administrators</th>
							   <th>Total Customers</th>
							   <th>Total Suggestions / Complaints</th>
							</tr>
						 </thead>
      
      <tbody>
      			<tr>
      						<td><?php echo $no_of_orders ?></td>
      						<td><?php echo $no_of_products ?></td>
      						<td><?php echo $no_of_categories ?></td>
      						<td><?php echo $no_of_administrators ?></td>
      						<td><?php echo $no_of_customers ?></td>
      						<td><?php echo $no_of_complaints_suggestions ?></td>
      			</tr>
      </tbody>
</table>
</div>
</div>
</div>
</div>
</div>
</div>
</div>

<?php require('footer.php'); ?>
