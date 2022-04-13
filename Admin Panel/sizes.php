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
		
$update_size_status = "update Sizes set Status='$status' where Id='$Id'";

$main_update_size_status = mysqli_query($database_connection,$update_size_status);
}

if($type=='delete'){
		$id=get_secure_value($database_connection,$_GET['id']);
		
$delete_size = "delete from Sizes where Id='$id'";

$main_delete_size = mysqli_query($database_connection,$delete_size);
	}
}

$select_size = "select * from Sizes order by Sorting_Order asc ";

$main_select_size = mysqli_query($database_connection,$select_size);
?>

<div class="content pb-0">
	<div class="orders">
	   <div class="row">
		  <div class="col-xl-12">
			 <div class="card">
				<div class="card-body">
				   <h4 class="box-title">Sizes | Ecommerce Website</h4>
				   <h4 class="box-link"><a href="manage_sizes.php?type=add">Add Size</a> </h4>
				</div>
				<div class="card-body--">
				   <div class="table-stats order-table ov-h">
					  <table class="table ">
						 <thead>
							<tr>
							   <th>ID</th>
							   <th>Size</th>
							   <th>Sorting Order</th>
							   <th>Status</th>
							   <th>Operations</th>
							</tr>
						 </thead>
						 <tbody>
							<?php 
							
      
while($fetch_size_data = mysqli_fetch_array($main_select_size)){ 
?>
    <tr>							   
<td><?php echo $fetch_size_data['Id']?></td>

<td><?php echo $fetch_size_data['Size']?></td>

<td><?php echo $fetch_size_data['Sorting_Order']?></td>

<td><?php

if($fetch_size_data['Status']==1){
	  echo "<span class='badge badge-complete'><a href='?type=status&operation=deactivate&id=".$fetch_size_data['Id']."'>Active</a></span>&nbsp;";
}else{
				echo "<span class='badge badge-pending'><a href='?type=status&operation=activate&id=".$fetch_size_data['Id']."'>Inactive</a></span>&nbsp;";
								}
					?>
								</td>
								
					<td><?php
								echo "<span class='badge badge-edit'><a href='manage_sizes.php?type=edit&id=".$fetch_size_data['Id']."'>Edit</a></span>&nbsp;";
							
								echo "<span class='badge badge-delete'><a href='?type=delete&id=".$fetch_size_data['Id']."'>Delete</a></span>";
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

<?php 
require('footer.php'); 
?>
