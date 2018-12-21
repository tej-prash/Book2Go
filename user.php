<?php 
session_start();
if(isset($_POST['submit'])){
	$servername="localhost";
	$username="root";
	$password="";
	//Start a connection
	$conn=mysqli_connect($servername,$username,$password,"touch");
	if($conn->connect_error){
		echo "Connection failed";
	} 
	else{		   
		$temp2=$_POST['name_user']; 
		$temp1=$_SESSION['login_user'];
		 if(mysqli_query($conn,"UPDATE login_members SET username='$temp2' WHERE username='$temp1'")){
		       	if(mysqli_query($conn,"UPDATE lesson_data SET username='$temp2' WHERE username='$temp1'")){
			       	header("Location:profile.php");
			       	$_SESSION['login_user']=$temp2;
			       	mysqli_close($conn);
			    }
		 }
		        //or die(mysqli_error($connection));
	}
}

?>
<html>
<head>
	<style>
	body{
		background:url("Mystic.jpg");
		background-size:cover;
		background-repeat: no-repeat;
	}
	#sub{
		text-decoration: none;
		outline:none;
		border:2px solid #f49292;
		background:#f46969;
		border-radius:18px;
		margin:20px;
		width:200px;
		height:40px;
	}
	#pic_id{
		text-decoration: none;
		outline:none;
		border:2px solid #f49292;
		background:#f46969;
		border-radius:18px;
		margin:20px;
		width:200px;
		height:40px;
	}
	</style>
</head>
<body>
<script src="http://code.jquery.com/jquery-1.11.1.min.js"></script>
  </script>   
  <form action=""  method="POST" enctype="multipart/form-data"> 
  	<center>
  		<h2>Enter your new username </h2>
  	<input type="text" name="name_user" size="30"> <br>
	<input type="submit" id="sub"name="submit" value="Submit">
	</center>
	</form>
</body>
</html>	