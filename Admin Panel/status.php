<?php
require('header.php');

if(isset($_GET['type']) && $_GET['type']!=''){

$type = get_secure_value($database_connection,$_GET['type']);

if($type == 'delete_order_status'){

		$id = get_secure_value($database_connection,$_GET['id']);
		
$delete_order_status = "delete from Order_Status where Id = '$id'";

$main_delete_order_status = mysqli_query($database_connection,$delete_order_status);

	}else if($type == 'delete_payment_status'){
	
		$Id = get_secure_value($database_connection,$_GET['id']);
		
$delete_payment_status = "delete from Payment_Status where Id = '$Id'";

$main_delete_payment_status = mysqli_query($database_connection,delete_payment_status);

	}
}

$select_order_status = "select * from Order_Status order by Id asc ";

$main_select_order_status = mysqli_query($database_connection,$select_order_status);

$select_payment_status = "select * from Payment_Status order by Id asc ";

$main_select_payment_status = mysqli_query($database_connection,$select_payment_status);
?>

<div class="content pb-0">
	<div class="orders">
	   <div class="row">
		  <div class="col-xl-12">
			 <div class="card">
				<div class="card-body">
				   <h4 class="box-title">Order's Status | Ecommerce Website</h4>
				   <h4 class="box-link"><a href="manage_order_status.php?type=add">Add Order's Status</a> </h4>
				</div>
				<div class="card-body--">
				   <div class="table-stats order-table ov-h">
					  <table class="table ">
						 <thead>
							<tr>
							   <th>ID</th>
							   <th>Status</th>							   
							   <th>Operations</th>
							</tr>
						 </thead>
						 <tbody>
							<?php 							      
while($fetch_order_status = mysqli_fetch_array($main_select_order_status)){ 
?>
    <tr>							   
<td><?php echo $fetch_order_status['Id']?></td>

<td><?php echo $fetch_order_status['Status']?></td>

  <td><?php
								echo "<span class='badge badge-edit'><a href='manage_order_status.php?type=edit&id=".$fetch_order_status['Id']."'>Edit</a></span>&nbsp;";
							
								echo "<span class='badge badge-delete'><a href='?type=delete_order_status&id=".$fetch_order_status['Id']."'>Delete</a></span>";
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

<div class="content pb-0">
	<div class="orders">
	   <div class="row">
		  <div class="col-xl-12">
			 <div class="card">
				<div class="card-body">
				   <h4 class="box-title">Payment's Status | Ecommerce Website</h4>
				   <h4 class="box-link"><a href="manage_payment_status.php?type=add">Add Payment's Status</a> </h4>
				</div>
				<div class="card-body--">
				   <div class="table-stats order-table ov-h">
					  <table class="table ">
						 <thead>
							<tr>
							   <th>ID</th>
							   <th>Status</th>							   
							   <th>Operations</th>
							</tr>
						 </thead>
						 <tbody>
							<?php 							      
while($fetch_payment_status = mysqli_fetch_array($main_select_payment_status)){ 
?>
    <tr>							   
<td><?php echo $fetch_payment_status['Id']?></td>

<td><?php echo $fetch_payment_status['Status']?></td>

  <td><?php
								echo "<span class='badge badge-edit'><a href='manage_payment_status.php?type=edit&id=".$fetch_payment_status['Id']."'>Edit</a></span>&nbsp;";
							
								echo "<span class='badge badge-delete'><a href='?type=delete_payment_status&id=".$fetch_payment_status['Id']."'>Delete</a></span>";
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
