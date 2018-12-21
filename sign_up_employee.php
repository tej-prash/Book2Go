<?php
$error=" ";
if(isset($_POST['submit'])){
	if(empty($_POST['contact_number'])){
		alert("Invalid username or password");
		header("Location:sign_up_home.php");
	}
	else{
//session_start();
//if(isset($_SESSION['login_user']))header("Location:profile.php");
if(!isset($_SESSION['login_user'])){
$servername="localhost";
$username="postgres";
$password="tejas@1998";
$flag_user_exists=0;
$flag_username_exists=0;
//Start a connection
$pass=$_POST["contact_number"];
extract($_POST);
$conn=pg_connect("host=localhost port=5432 dbname=bookrental user=postgres password=tejas@1998");

if(!$conn){
	echo "Connection failed";
} 
else{
$sql="SELECT count(*) FROM employee";
$val=pg_query($conn,$sql);
if(!$val){
	die('Could not obtain data1'.pg_last_error());
}
$row=pg_fetch_row($val);
$row=$row[0];
$user="ea".(string)($row+1);
	//echo "$user  $pass";
	//print_r($user);
	//$sql="INSERT INTO login_members VALUES(2,$user,$pass,'hi')";
	$date=date("Y-m-d");
	$val=pg_query($conn,"INSERT INTO employee(employee_id,employee_name,doj,dob,contact_number,salary) values('$user','$full_name','$date','$dob','$contact_number',20000)");
	if(!$val){
		die('Could not obtain data'.pg_last_error($conn));
	}
	$val=pg_query($conn,"INSERT INTO employeeaddress(employee_id,flat_no,street_name,locality,city,state,country,zip_code) values('$user','$flat_no','$street_name','$locality','$city','$state','$country','$zipcode')");	
	if(!$val){
		die('Could not obtain data'.pg_last_error($conn));
	}
	//echoari "connection sucessfull";
	$_SESSION['login_user']=$user;
	header("Location:employee.php");
}
}
}
pg_close($conn);
}
?>
