<?php
require('header.php');

if(isset($_GET['type']) && $_GET['type']!=''){

$type = get_secure_value($database_connection,$_GET['type']);

if($type=='delete'){
		$Id = get_secure_value($database_connection,$_GET['id']);
		
$delete_customer = "delete from Customers where Id='$Id'";

$main_delete_customer = mysqli_query($database_connection,$delete_customer);
	}
}

$select_customer = "select * from Customers";

$main_select_customer = mysqli_query($database_connection,$select_customer);
?>

<div class="content pb-0">
	<div class="orders">
	   <div class="row">
		  <div class="col-xl-12">
			 <div class="card">
				<div class="card-body">
				   <h4 class="box-title">Customers | Ecommerce Website </h4>			
				<div class="card-body--">
				   <div class="table-stats order-table ov-h">
					  <table class="table ">
						 <thead>
							<tr>
							   <th>ID</th>
							   <th>Name</th>							   
							   <th>Email Id</th>
							   <th>Mobile Number</th>
							   <th>Password</th>
							   <th>Registration Date</th> 
							   <th>Operation</th>
							</tr>
						 </thead>
						 <tbody>
						 			
							<?php 
while($fetch_customer_data = mysqli_fetch_array($main_select_customer)){ ?>

							<tr>
							   <td><?php echo $fetch_customer_data['Id']?></td>
							   <td><?php echo $fetch_customer_data['Name']?></td>
							   <td><?php echo $fetch_customer_data['Email_Id']?></td>
							   <td><?php echo $fetch_customer_data['Mobile_Number']?></td>							   							   
							   <td><?php echo $fetch_customer_data['Password']?></td>
							   <td><?php echo $fetch_customer_data['Registration_Date_Time']?></td>							   		 											
							   <td><?php
								echo "<span class='badge badge-delete'><a href='?type=delete&id=".$fetch_customer_data['Id']."'>Delete</a></span>";
								?></td>
							</tr>
							<?php } ?>
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
