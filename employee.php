<?php
session_start();
$servername="localhost";
$username="postgres";
$password="tejas@1998";
$flag_user_exists=0;
$flag_username_exists=0;
//Start a connection
$conn=pg_connect("host=localhost port=5432 dbname=bookrental user=postgres password=tejas@1998");

if(!$conn){
	echo "Connection failed";
} 
else{
$user=$_SESSION['login_user'];
}
?>

<!DOCTYPE html>
<html>
<head>
	<link rel="stylesheet" type="text/css" href="profile_styles.css">
</head>
<body>
	<div class="topnav">
			<a href="change_status.php"> Update Status  </a>
			<a href="orders_fulfilled.php"> Orders fulfilled </a>
			<a href="logout.php"> Log-out</a> 

	</div>
	<div>
		<center> <h1> Welcome <?php if(!$_SESSION['login_user']){header('Location:login.php');
}else{echo ($_SESSION['login_user']);} ?> </h1> </center>
	</div>
	
	<!--<div id="profile">
		Upload your profile picture!
		<input type="file" id="myFile"></input>
		<img src="" alt="Profile Picture"></img>
	</div>
	<script>
		var r=window.setInterval(display,1000);
		function display(){
			var source=document.getElementById("myFile").value;
			if(source!=''){
				document.getElementById("profile").getElementsByClassName("img")[0].src=source;
				clearInterval(r);
			}
		}
	</script>-->
</body>
</html>
</br></br>
</body>
</html>