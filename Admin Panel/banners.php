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
		
$update_banner_status = "update Banners set Status='$status' where Id='$Id'";

$main_update_banner_status = mysqli_query($database_connection,$update_banner_status);
}

if($type=='delete'){
		$id = get_secure_value($database_connection,$_GET['id']);
		
$delete_banner = "delete from Banners where Id='$id'";

$main_delete_banner = mysqli_query($database_connection,$delete_banner);
	}
}

$select_banner = "select * from Banners order by Id desc ";

$main_select_banner = mysqli_query($database_connection,$select_banner);
?>

<div class="content pb-0">
	<div class="orders">
	   <div class="row">
		  <div class="col-xl-12">
			 <div class="card">
				<div class="card-body">
				   <h4 class="box-title">Banners | Ecommerce Website</h4>
				   <h4 class="box-link"><a href="manage_banners.php?type=add">Add Banner</a> </h4>
				</div>
				<div class="card-body--">
				   <div class="table-stats order-table ov-h">
					  <table class="table ">
						 <thead>
							<tr>
							   <th>ID</th>
							   <th>Main Heading</th>
							   <th>Sub Heading</th>
							   <th>Button Text</th>
							   <th>Button Link</th>
							   <th>Banner Image</th>
							   <th>Status</th>
							   <th>Operations</th>
							</tr>
						 </thead>
						 <tbody>
							<?php 
							
      
while($fetch_banner_data = mysqli_fetch_array($main_select_banner)){ 
?>
    <tr>							   
<td><?php echo $fetch_banner_data['Id']?></td>

<td><?php echo $fetch_banner_data['Main_Heading']?></td>

<td><?php echo $fetch_banner_data['Sub_Heading']?></td>

<td><?php echo $fetch_banner_data['Button_Text']?></td>

<td><?php echo $fetch_banner_data['Button_Link']?></td>

<td><a href="<?php echo BANNER_IMAGE_SITE_PATH.$fetch_banner_data['Banner_Image'] ?>" ><img src="<?php echo BANNER_IMAGE_SITE_PATH.$fetch_banner_data['Banner_Image'] ?>"></a></td>

<td><?php

if($fetch_banner_data['Status']==1){
	  echo "<span class='badge badge-complete'><a href='?type=status&operation=deactivate&id=".$fetch_banner_data['Id']."'>Active</a></span>&nbsp;";
}else{
				echo "<span class='badge badge-pending'><a href='?type=status&operation=activate&id=".$fetch_banner_data['Id']."'>Inactive</a></span>&nbsp;";
								}
					?>
								</td>
								
					<td><?php
								echo "<span class='badge badge-edit'><a href='manage_banners.php?type=edit&id=".$fetch_banner_data['Id']."'>Edit</a></span>&nbsp;";
							
								echo "<span class='badge badge-delete'><a href='?type=delete&id=".$fetch_banner_data['Id']."'>Delete</a></span>";
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
