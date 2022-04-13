<?php
require('header.php');

if(isset($_GET['type']) && $_GET['type']!=''){
	$type = get_secure_value($database_connection,$_GET['type']);
	
	if($type=='status'){
		$operation = get_secure_value($database_connection,$_GET['operation']);
		
		$Id = get_secure_value($database_connection,$_GET['id']);
		
		if($operation=='activate'){
			$status='1';
		}else{
			$status='0';
		}
		
		$update_coupon_code_status = "update Coupon_Codes set Status='$status' where Id='$Id'";
		
		$main_update_coupon_code_status = mysqli_query($database_connection,$update_coupon_code_status);
	}
	
	if($type=='delete'){
		$id = get_secure_value($database_connection,$_GET['id']);
		
		$delete_coupon_code = "delete from Coupon_Codes where Id='$id'";
		
		$main_delete_coupon_code = mysqli_query($database_connection,$delete_coupon_code);
	}
}

$select_coupon_code = "select * from Coupon_Codes order by Id desc";

$main_select_coupon_code = mysqli_query($database_connection,$select_coupon_code);
?>

<div class="content pb-0">
	<div class="orders">
	   <div class="row">
		  <div class="col-xl-12">
			 <div class="card">
				<div class="card-body">
				   <h4 class="box-title">Coupon Codes | Ecommerce Website</h4>
				   <h4 class="box-link"><a href="manage_coupon_codes.php">Add Coupon Code</a> </h4>
				</div>
				<div class="card-body--">
				   <div class="table-stats order-table ov-h">
					  <table class="table ">
						 <thead>
							<tr>
							   <th>ID</th>
							   <th>Coupon Code</th>
							   <th>Coupon Code Value</th>
							   <th>Coupon Code Type</th>
							   <th>Cart Minimum Value</th>
							   <th>Status</th>
							   <th>Operations</th>
							</tr>
						 </thead>
						 <tbody>
							<?php 
while($fetch_coupon_code_data = mysqli_fetch_array($main_select_coupon_code)){?>
							<tr>
							   <td><?php echo $fetch_coupon_code_data['Id']?></td>
							   <td><?php echo $fetch_coupon_code_data['Coupon_Code']?></td>
							   <td><?php echo $fetch_coupon_code_data['Coupon_Code_Value']?></td>
							  <td><?php echo $fetch_coupon_code_data['Coupon_Code_Type'] ?></td>
							   <td><?php echo $fetch_coupon_code_data['Cart_Minimum_Value']?></td>
							   <td>
							   <?php
if($fetch_coupon_code_data['Status']==1){
									
								echo "<span class='badge badge-complete'><a href='?type=status&operation=deactivate&id=".$fetch_coupon_code_data['Id']."'>Active</a></span>&nbsp;";
								
																}else{
																
									echo "<span class='badge badge-pending'><a href='?type=status&operation=activate&id=".$fetch_coupon_code_data['Id']."'>Inactive</a></span>&nbsp;";
							
								}
							?>
							</td>
								
							<td><?php
								echo "<span class='badge badge-edit'><a href='manage_coupon_codes.php?type=edit&id=".$fetch_coupon_code_data['Id']."'>Edit</a></span>&nbsp;";
								
								echo "<span class='badge badge-delete'><a href='?type=delete&id=".$fetch_coupon_code_data['Id']."'>Delete</a></span>";
?>
							   </td>
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

<?php
require('footer.php');
?>
