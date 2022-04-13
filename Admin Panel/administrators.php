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
		
$update_administrator_status = "update Administrators set Status='$status' where Id='$Id'";

$main_update_administrator_status = mysqli_query($database_connection,$update_administrator_status);
}

if($type=='delete'){
		$Id = get_secure_value($database_connection,$_GET['id']);
		
$delete_administrator = "delete from Administrators where Id='$Id'";

$main_delete_administrator = mysqli_query($database_connection,$delete_administrator);
	}
}

$select_administrator = "select * from Administrators";

$main_select_administrator = mysqli_query($database_connection,$select_administrator);
?>

<div class="content pb-0">
	<div class="orders">
	   <div class="row">
		  <div class="col-xl-12">
			 <div class="card">
				<div class="card-body">
				   <h4 class="box-title">Administrators | Ecommerce Website </h4>

				<h4 class="box-link"><a href="manage_administrators.php?type=add">Add Administrator</a> </h4>
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
while($fetch_administrator_data = mysqli_fetch_array($main_select_administrator)){ ?>

							<tr>
							   <td><?php echo $fetch_administrator_data['Id']?></td>
							   <td><?php echo $fetch_administrator_data['Name']?></td>
							   <td><?php echo $fetch_administrator_data['Mobile_Number']?></td>
							   
							   <td><?php echo $fetch_administrator_data['Username']?></td>
							   
							   <td><?php echo $fetch_administrator_data['Email_Id']?></td>
							   <td><img src="../Media/Administrators/<?php echo $fetch_administrator_data['Administrator_Photo'] ?>"/></td>
							   <td><?php echo $fetch_administrator_data['Date_Of_Birth']?></td>
							   <td><?php echo $fetch_administrator_data['Password']?></td>
							   <td><?php echo $fetch_administrator_data['Registration_Date_Time']?></td>
							   
							   <td><?php echo $fetch_administrator_data['Updation_Date_Time']?></td>
							   
							   <td><?php

if($fetch_administrator_data['Status']==1){
	  echo "<span class='badge badge-complete'><a href='?type=status&operation=deactivate&id=".$fetch_administrator_data['Id']."'>Active</a></span>&nbsp;";
}else{
				echo "<span class='badge badge-pending'><a href='?type=status&operation=activate&id=".$fetch_administrator_data['Id']."'>Inactive</a></span>&nbsp;";
								}
					?>
					
								</td>
								
							   <td><?php
								echo "<span class='badge badge-edit'><a href='manage_administrators.php?type=edit&id=".$fetch_administrator_data['Id']."'>Edit</a></span>&nbsp;";
							
								echo "<span class='badge badge-delete'><a href='?type=delete&id=".$fetch_administrator_data['Id']."'>Delete</a></span>";
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
