<?php
session_start();
include('sign_up_process.php');
if(isset($_SESSION['login_user'])){
	header('Location:profile.php');
}


?>
<!DOCTYPE HTML>
<html>
<head>
	<style>
		body{
			background:url("Mild.jpg") fixed;
			background-repeat:no-repeat;
			background-position:center;
			background-size:cover;
		}
		#f1{
			text-align: center;
			top:180px;
			position:relative;
		}
		.login input{
			text-decoration: none;
			outline:none;
			border:2px solid #d5dfef;
			background:#d5dfef;
			border-radius:15px;
			margin:20px;
			width:200px;
			height:40px;
		}
		#submit{
			text-decoration: none;
			outline:none;
			border:2px solid #f49292;
			background:#f46969;
			border-radius:18px;
			margin:20px;
			width:200px;
			height:40px;
		}
		#error{
			margin:10px;
			font-family:georgia;
			color:#AEBD38;
		}
		#register{
			margin:10px;
			text-align:center;
			font-family:georgia;
			font-size:20px;
		}
		form div a{
			text-decoration: none;
			outline:none;
			font-size:20px;
			color:black;
		}
	</style>
</head>
<body>
	<form method="POST" action="" id="f1">
		<div class="login">
		<input id="email"type="text" name="username" placeholder="Username"></div>
		<div class="login">
		<input type="password" name="password" placeholder="*********">
		</div>
	<input type="submit" name="submit" value="Login" id="submit">
	<div id="error"><?php echo $error; ?> </div>
	<div id="register">Not registered? <a href="sign_up_home.php">Sign Up Here</a></div>
</form>
</body>
</html>