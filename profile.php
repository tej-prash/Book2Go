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
			<a href="disp.php" target="_self"> Search </a>
			<a href="orders.php"> Previous orders </a> 
			<a href="track_order_cust.php">Track your order! </a>
			<a href="overdue.php"> Overdue books </a>
			<div class="dropdown">
				<!--<button class="dropdown_button">Account Settings </button>-->
				<!--<div class="dropdown_content">
					<a href="user.php">Change username </a></br>
					<a href="pass.php">Change password </a></br>
				</div> -->
			</div>	
			<a href="logout.php"> Log-out</a> 


	</div>
	<div>
		<center> <h1> Welcome <?php if(!$_SESSION['login_user']){header('Location:login.php');
}else{echo ($_SESSION['login_user']);} ?> </h1> </center>
	</div>
	
	<div>
		<h1><a href="putsup.php"> Put up a new book book </a></h1><br><br> 
		<h1><a href="showbooksup.php"> Books You have put up  </a></h1>
		<h1><a href="track_order_owner.php"> See where your book is  </a></h1>

	</div>
	
</body>
</html>
</br></br>
</body>
</html>