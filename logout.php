<?php
session_start();
$temp1=$_SESSION['login_user'];
if(session_destroy()){
	/*$servername="localhost";
	$username="root";
	$password="";
	$flag_user_exists=0;
	$flag_username_exists=0;
	//Start a connection
	$user=$_POST["username"];
	$pass=$_POST["password"];
	$conn=mysqli_connect($servername,$username,$password,"touch");

	if($conn->connect_error){
		echo "Connection failed";
	} */
	//$val1=mysqli_query($conn,"UPDATE lesson_data SET user_yes=0 WHERE username='$temp1'");
	header("Location:intro.html");
}
?>