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
		
$update_color_status = "update Colors set Status='$status' where Id='$Id'";

$main_update_color_status = mysqli_query($database_connection,$update_color_status);
}

if($type=='delete'){
		$id=get_secure_value($database_connection,$_GET['id']);
		
$delete_color = "delete from Colors where Id='$id'";

$main_delete_color = mysqli_query($database_connection,$delete_color);
	}
}

$select_color = "select * from Colors order by Id asc ";

$main_select_color = mysqli_query($database_connection,$select_color);
?>

<div class="content pb-0">
	<div class="orders">
	   <div class="row">
		  <div class="col-xl-12">
			 <div class="card">
				<div class="card-body">
				   <h4 class="box-title">Colors | Ecommerce Website</h4>
				   <h4 class="box-link"><a href="manage_colors.php?type=add">Add Color</a> </h4>
				</div>
				<div class="card-body--">
				   <div class="table-stats order-table ov-h">
					  <table class="table ">
						 <thead>
							<tr>
							   <th>ID</th>
							   <th>Color</th>
							   <th>Status</th>
							   <th>Operations</th>
							</tr>
						 </thead>
						 <tbody>
							<?php 
							
      
while($fetch_color_data = mysqli_fetch_array($main_select_color)){ 
?>
    <tr>							   
<td><?php echo $fetch_color_data['Id']?></td>

<td><?php echo $fetch_color_data['Color']?></td>

<td><?php

if($fetch_color_data['Status']==1){
	  echo "<span class='badge badge-complete'><a href='?type=status&operation=deactivate&id=".$fetch_color_data['Id']."'>Active</a></span>&nbsp;";
}else{
				echo "<span class='badge badge-pending'><a href='?type=status&operation=activate&id=".$fetch_color_data['Id']."'>Inactive</a></span>&nbsp;";
								}
					?>
								</td>
								
					<td><?php
								echo "<span class='badge badge-edit'><a href='manage_colors.php?type=edit&id=".$fetch_color_data['Id']."'>Edit</a></span>&nbsp;";
							
								echo "<span class='badge badge-delete'><a href='?type=delete&id=".$fetch_color_data['Id']."'>Delete</a></span>";
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
