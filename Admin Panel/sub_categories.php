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
		
$update_sub_category_status = "update Sub_Categories set Status='$status' where Id='$Id'";

$main_update_sub_category_status = mysqli_query($database_connection,$update_sub_category_status);
}

if($type=='delete'){
		$id=get_secure_value($database_connection,$_GET['id']);
		
$delete_sub_category = "delete from Sub_Categories where Id='$id'";

$main_delete_sub_category = mysqli_query($database_connection,$delete_sub_category);
	}
}

$select_sub_category = "select Sub_Categories.*, Categories.* from Sub_Categories,Categories where Categories.Id=Sub_Categories.Category order by Sub_Categories.Sub_Category asc ";

$main_select_sub_category = mysqli_query($database_connection,$select_sub_category);
?>

<div class="content pb-0">
	<div class="orders">
	   <div class="row">
		  <div class="col-xl-12">
			 <div class="card">
				<div class="card-body">
				   <h4 class="box-title">Sub Categories | Ecommerce Website</h4>
				   <h4 class="box-link"><a href="manage_sub_categories.php?type=add">Add Sub Category</a> </h4>
				</div>
				<div class="card-body--">
				   <div class="table-stats order-table ov-h">
					  <table class="table ">
						 <thead>
							<tr>
							   <th>ID</th>
							   <th>Category</th>
							   <th>Sub Category</th>
							   <th>Status</th>
							   <th>Operations</th>
							</tr>
						 </thead>
						 <tbody>
							<?php 
							
      
while($fetch_sub_category_data = mysqli_fetch_array($main_select_sub_category)){ 
?>
    <tr>							   
<td><?php echo $fetch_sub_category_data['Id']?></td>

<td><?php echo $fetch_sub_category_data['Category']?></td>

<td><?php echo $fetch_sub_category_data['Sub_Category']?></td>

<td><?php

if($fetch_sub_category_data['Status']==1){
	  echo "<span class='badge badge-complete'><a href='?type=status&operation=deactivate&id=".$fetch_sub_category_data['Id']."'>Active</a></span>&nbsp;";
}else{
				echo "<span class='badge badge-pending'><a href='?type=status&operation=activate&id=".$fetch_sub_category_data['Id']."'>Inactive</a></span>&nbsp;";
								}
					?>
								</td>
								
					<td><?php
								echo "<span class='badge badge-edit'><a href='manage_sub_categories.php?type=edit&id=".$fetch_sub_category_data['Id']."'>Edit</a></span>&nbsp;";
							
								echo "<span class='badge badge-delete'><a href='?type=delete&id=".$fetch_sub_category_data['Id']."'>Delete</a></span>";
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
