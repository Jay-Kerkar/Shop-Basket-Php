<?php 
require('header.php'); 
?>

<?php 
$fetch_data_error = 0;

//Fetching Total Orders

$fetch_total_orders = mysqli_query($database_connection,"select Id from Orders");

$total_orders = mysqli_num_rows($fetch_total_orders);

if($total_orders > 0) {
		$no_of_orders = $total_orders;
}else {
		$no_of_orders = $fetch_data_error;
}

//Fetching Total Products

$fetch_total_products = mysqli_query($database_connection,"select Id from Products");

$total_products = mysqli_num_rows($fetch_total_products);

if($total_products > 0) {
		$no_of_products = $total_products;
}else {
		$no_of_products = $fetch_data_error;
}

//Fetching Total Complaints_Suggestions

$fetch_total_complaints_suggestions = mysqli_query($database_connection,"select Id from Complaints_Suggestions");

$total_complaints_suggestions = mysqli_num_rows($fetch_total_complaints_suggestions);

if($total_complaints_suggestions > 0) {
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
				   <h4 class="box-title">Dashboard | Seller Panel | Ecommerce Website</h4>
				</div>
				<div class="card-body--">
				   <div class="table-stats order-table ov-h">
					  <table class="table ">
						 <thead>
							<tr>
	        <th>Total Orders</th>
							   <th>Total Products</th>
							   <th>Total Suggestions / Complaints</th>
							</tr>
						 </thead>
      
      <tbody>
      			<tr>
      						<td><?php echo $no_of_orders ?></td>
      						<td><?php echo $no_of_products ?></td>
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

<?php 
require('footer.php'); 
?>
