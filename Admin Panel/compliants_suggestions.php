<?php
require('header.php');

if(isset($_GET['type']) && $_GET['type']!=''){
	$type = get_secure_value($database_connection,$_GET['type']);
	
	if($type=='delete'){
		$Id = get_secure_value($database_connection,$_GET['id']);
		
		$delete_record = "delete from Complaints_Suggestions where Id='$Id'";
		
		$main_delete_record = mysqli_query($database_connection,$delete_record);
	}
}

$select_record = "select * from Complaints_Suggestions order by Id desc";

$main_select_category = mysqli_query($database_connection,$select_record);
?>

<div class="content pb-0">
	<div class="orders">
	   <div class="row">
		  <div class="col-xl-12">
			 <div class="card">
				<div class="card-body">
				   <h4 class="box-title">Complaints / Suggestions</h4>
				</div>
				<div class="card-body--">
				   <div class="table-stats order-table ov-h">
					  <table class="table ">
						 <thead>
							<tr>
							   <th>Id</th>
							   <th>Name</th>
							   <th>Email Id</th>
							   <th>Mobile Number</th>
							   <th>Type Of Message</th>
							   <th>Subject</th>
							  <th>Message</th>
							   <th>Registration Date</th>
							   <th>Operation</th>
							</tr>
						 </thead>
						 <tbody>
							<?php 
while($fetch_data = mysqli_fetch_array($main_select_category)){?>
							<tr>
							   <td><?php echo $fetch_data['Id']?></td>
							   <td><?php echo $fetch_data['Name']?></td>
							   <td><?php echo $fetch_data['Email_Id']?></td>
							   <td><?php echo $fetch_data['Mobile_Number']?></td>
							   <td><?php echo $fetch_data['Type_Of_Message']?></td>
							   <td><?php echo $fetch_data['Subject']?></td>
							   <td><?php echo $fetch_data['Message']?></td>
							   <td><?php echo $fetch_data['Registration_Date_Time']?></td>
							   <td>
								<?php
								echo "<span class='badge badge-delete'><a href='?type=delete&id=".$fetch_data['Id']."'>Dispose</a></span>";
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
