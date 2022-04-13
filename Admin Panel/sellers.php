<?php
require('header.php');

if(isset($_GET['type']) && $_GET['type']!=''){

$type = get_secure_value($database_connection,$_GET['type']);

if($type=='status'){
$operation = get_secure_value($database_connection,$_GET['operation']);

$Id = get_secure_value($database_connection,$_GET['id']);

if($operation == 'activate'){
			$status='1';
}else{
			$status='0';
}
		
$update_seller_status = "update Sellers set Status='$status' where Id='$Id'";

$main_update_seller_status = mysqli_query($database_connection,$update_seller_status);
}

if($type=='delete'){
		$Id = get_secure_value($database_connection,$_GET['id']);
		
$delete_seller = "delete from Sellers where Id='$Id'";

$main_delete_seller = mysqli_query($database_connection,$delete_seller);
	}
}

$select_seller = "select * from Sellers";

$main_select_seller = mysqli_query($database_connection,$select_seller);
?>

<div class="content pb-0">
	<div class="orders">
	   <div class="row">
		  <div class="col-xl-12">
			 <div class="card">
				<div class="card-body">
				   <h4 class="box-title">Sellers | Ecommerce Website </h4>

				<h4 class="box-link"><a href="manage_sellers.php?type=add">Add Seller</a> </h4>
				</div>
				
				<div class="card-body--">
				   <div class="table-stats order-table ov-h">
					  <table class="table ">
						 <thead>
							<tr>
							   <th>ID</th>
							   <th>Name</th>
							   <th>Mobile Number</th>
							   <th>Username</th>
							   <th>Email Id</th>
							   <th>Photo</th>
							   <th>Date Of Birth</th>
							   <th>Password</th>
							   <th>Registration Date</th>
							   <th>Updation Date</th>
							   <th>Status</th>
							   <th>Operations</th>
							</tr>
						 </thead>
						 <tbody>
						 			
							<?php 
while($fetch_seller_data = mysqli_fetch_array($main_select_seller)){ ?>

							<tr>
							   <td><?php echo $fetch_seller_data['Id']?></td>
							   <td><?php echo $fetch_seller_data['Name']?></td>
							   <td><?php echo $fetch_seller_data['Mobile_Number']?></td>
							   
							   <td><?php echo $fetch_seller_data['Username']?></td>
							   
							   <td><?php echo $fetch_seller_data['Email_Id']?></td>
							   <td><img src="../Media/Sellers/<?php echo $fetch_seller_data['Seller_Photo'] ?>"/></td>
							   <td><?php echo $fetch_seller_data['Date_Of_Birth']?></td>
							   <td><?php echo $fetch_seller_data['Password']?></td>
							   <td><?php echo $fetch_seller_data['Registration_Date_Time']?></td>
							   
							   <td><?php echo $fetch_seller_data['Updation_Date_Time']?></td>
							   
							   <td><?php

if($fetch_seller_data['Status']==1){
	  echo "<span class='badge badge-complete'><a href='?type=status&operation=deactivate&id=".$fetch_seller_data['Id']."'>Active</a></span>&nbsp;";
}else{
				echo "<span class='badge badge-pending'><a href='?type=status&operation=activate&id=".$fetch_seller_data['Id']."'>Inactive</a></span>&nbsp;";
								}
					?>
					
								</td>
								
							   <td><?php
								echo "<span class='badge badge-edit'><a href='manage_sellers.php?type=edit&id=".$fetch_seller_data['Id']."'>Edit</a></span>&nbsp;";
							
								echo "<span class='badge badge-delete'><a href='?type=delete&id=".$fetch_seller_data['Id']."'>Delete</a></span>";
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
