<?php
session_start();

require('database_connection.php');
require('functions.php');

if(isset($_POST['proceed_to_login'])){

$username = get_secure_value($database_connection,$_POST['username']);
	
$password = get_secure_value($database_connection,$_POST['password']);

$select_administrator = "select * from Administrators where Username='$username' and Password='$password'";

$main_select_administrator = mysqli_query($database_connection,$select_administrator);

$fetch_administrator_data = mysqli_fetch_array($main_select_administrator);

$administrator_validator = mysqli_num_rows($main_select_administrator);

$administrator_name = $fetch_administrator_data['Name'];

$administrator_id = $fetch_administrator_data['Id'];
 
$administrator_status = $fetch_administrator_data['Status']; 

if($administrator_validator > 0) {
 if($administrator_status == '1') {
 
$_SESSION['ADMIN_LOGIN']='yes';

$_SESSION['ADMIN_USERNAME'] = $username;

$_SESSION['ADMIN_ID'] = $administrator_id;

$_SESSION['ADMIN_NAME'] = $administrator_name;

header('location:dashboard.php');
		die();
		
 }else{
 		
 		$login_error_message="Failed To Login Because The Administrator ( $administrator_name ) Is Not Active";

 }
}else{

			$login_error_message="Please enter correct login credentials";	
			
 }
}

/* Under Testing Mode
if(isset($_POST['proceed_to_login'])){

$username = get_secure_value($database_connection,$_POST['username']);
	
$password = get_secure_value($database_connection,$_POST['password']);

$select_administrator = "select * from Administrators where Username='$username'";

$main_select_administrator = mysqli_query($database_connection,$select_administrator);

$fetch_administrator_data = mysqli_fetch_array($main_select_administrator);

$administrator_validator = mysqli_num_rows($main_select_administrator);

$administrator_password = $fetch_administrator_data['Password'];

$administrator_password_decode = password_verify($password,$administrator_password);

$administrator_name = $fetch_administrator_data['Name'];
 
$administrator_status = $fetch_administrator_data['Status']; 

if($administrator_validator > 0) {
 if($administrator_password_decode) {
			if($administrator_status == '1') {
 
$_SESSION['ADMIN_LOGIN']='yes';

$_SESSION['ADMIN_USERNAME'] = $username;

header('location:dashboard.php');
		die();
		
}else {

			$login_error_message="Failed To Login Because The Administrator ( $administrator_name ) Is Not Active";
  
  }
 }
}else {
			$login_error_message="Please enter correct login credentials";	
 }
}*/
?>

<!DOCTYPE html>
<html lang="en" dir="ltr">
   <head>
   			  <meta http-equiv="content-type" content="text/html>
      <meta charset="utf-8">
      <meta http-equiv="X-UA-Compatible" content="IE=edge">
      <title>Admin Login | E commerce Website</title>
      <meta name="viewport" content="width=device-width, initial-scale=1">
      <style>
    	@import url('https://fonts.googleapis.com/css2?family=Poppins:wght@200;300;400;500;600;700&display=swap');
*{
  margin: 0;
  padding: 0;
  box-sizing: border-box;
  font-family: 'Poppins',sans-serif;
}
body{
  height: 100vh;
  display: flex;
  justify-content: center;
  align-items: center;
  padding: 10px;
  background: black;
}
.container{
  max-width: 700px;
  width: 100%;
  background-color: black;
  border:1px solid white;
  padding: 25px 30px;
  border-radius: 5px;
  box-shadow: 0 5px 10px rgba(0,0,0,0.15);
}
.container .title{
  font-size: 25px;
  font-weight: 500;
  position: relative;
  color: white;
}
.container .title::before{
  content: "";
  position: absolute;
  left: 0;
  bottom: 0;
  height: 3px;
  width: 30px;
  border-radius: 5px;
  background: linear-gradient(135deg, #71b7e6, #9b59b6);
}
.content form .user-details{
  display: flex;
  flex-wrap: wrap;
  justify-content: space-between;
  margin: 20px 0 12px 0;
}
form .user-details .input-box{
  margin-bottom: 15px;
  width: calc(100% / 2 - 20px);
}
form .input-box span.details{
  display: block;
  font-weight: 500;
  margin-bottom: 5px;
}
.user-details .input-box input{
  height: 45px;
  width: 100%;
  outline: none;
  font-size: 16px;
  border-radius: 5px;
  padding-left: 15px;
  border: 1px solid #ccc;
  border-bottom-width: 2px;
  transition: all 0.3s ease;				
}
.user-details .input-box input:focus,
.user-details .input-box input:valid{
  border-color: #9b59b6;
}
 form .gender-details .gender-title{
  font-size: 20px;
  font-weight: 500;
 }
 form .category{
   display: flex;
   width: 80%;
   margin: 14px 0 ;
   justify-content: space-between;
 }
 form .category label{
   display: flex;
   align-items: center;
   cursor: pointer;
 }
 
 .field_error{
	color:red;
	margin-top:0px;
}

 form .category label .dot{
  height: 18px;
  width: 18px;
  border-radius: 50%;
  margin-right: 10px;
  background: #d9d9d9;
  border: 5px solid transparent;
  transition: all 0.3s ease;
}
 #dot-1:checked ~ .category label .one,
 #dot-2:checked ~ .category label .two,
 #dot-3:checked ~ .category label .three{
   background: #9b59b6;
   border-color: #d9d9d9;
 }
 form input[type="radio"]{
   display: none;
 }
 form .button{
   height: 45px;
   margin: 35px 0
 }
 form .button input{
   height: 100%;
   width: 182%;
   border-radius: 10px;
   border: none;
   color: #fff;
   font-size: 18px;
   font-weight: 500;
   letter-spacing: 1px;
   cursor: pointer;
   transition: all 0.3s ease;
   background: linear-gradient(135deg, #71b7e6, #9b59b6);
 }
 form .button input:hover{
  background: linear-gradient(-135deg, #71b7e6, #9b59b6);
  }
 @media(max-width: 584px){
 .container{
  max-width: 100%;
}
form .user-details .input-box{
    margin-bottom: 15px;
    width: 100%;
  }
  form .category{
    width: 100%;
  }
  .content form .user-details{
    max-height: 300px;
    overflow-y: scroll;
  }
  .user-details::-webkit-scrollbar{
    width: 5px;
  }
  }
  @media(max-width: 459px){
  .container .content .category{
    flex-direction: column;
  }
}
 </style>
 
</head>
<body>
  <div class="container">
    <div class="title">Admin Login</div>
    <div class="content">
      <form method="POST">
        <div class="user-details">
          <div class="input-box">
            <span class="details">Username</span>
            <input type="text" placeholder="Enter your username" name="username" required>
          </div>
          <div class="input-box">
            <span class="details">Password</span>
            <input type="password" placeholder="Enter your password" name="password" required>
          </div>
        <div class="button">
          <input type="submit" name="proceed_to_login" value="Proceed To Login">
        </div>
        <div class="field_error"><?php echo $login_error_message ?></div>
      </form>
    </div>
  </div>
</body>
</html>
