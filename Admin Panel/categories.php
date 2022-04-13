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
		
$update_category_status = "update Categories set Status='$status' where Id='$Id'";

$main_update_category_status = mysqli_query($database_connection,$update_category_status);
}

if($type=='delete'){
		$id=get_secure_value($database_connection,$_GET['id']);
		
$delete_category = "delete from Categories where Id='$id'";

$main_delete_category = mysqli_query($database_connection,$delete_category);
	}
}

$select_category = "select * from Categories order by Category asc ";

$main_select_category = mysqli_query($database_connection,$select_category);
?>

<div class="content pb-0">
	<div class="orders">
	   <div class="row">
		  <div class="col-xl-12">
			 <div class="card">
				<div class="card-body">
				   <h4 class="box-title">Categories | Ecommerce Website</h4>
				   <h4 class="box-link"><a href="manage_categories.php?type=add">Add Category</a> </h4>
				</div>
				<div class="card-body--">
				   <div class="table-stats order-table ov-h">
					  <table class="table ">
						 <thead>
							<tr>
							   <th>ID</th>
							   <th>Category</th>
							   <th>Status</th>
							   <th>Operations</th>
							</tr>
						 </thead>
						 <tbody>
							<?php 
							
      
while($fetch_category_data = mysqli_fetch_array($main_select_category)){ 
?>
    <tr>							   
<td><?php echo $fetch_category_data['Id']?></td>

<td><?php echo $fetch_category_data['Category']?></td>

<td><?php

if($fetch_category_data['Status']==1){
	  echo "<span class='badge badge-complete'><a href='?type=status&operation=deactivate&id=".$fetch_category_data['Id']."'>Active</a></span>&nbsp;";
}else{
				echo "<span class='badge badge-pending'><a href='?type=status&operation=activate&id=".$fetch_category_data['Id']."'>Inactive</a></span>&nbsp;";
								}
					?>
								</td>
								
					<td><?php
								echo "<span class='badge badge-edit'><a href='manage_categories.php?type=edit&id=".$fetch_category_data['Id']."'>Edit</a></span>&nbsp;";
							
								echo "<span class='badge badge-delete'><a href='?type=delete&id=".$fetch_category_data['Id']."'>Delete</a></span>";
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
