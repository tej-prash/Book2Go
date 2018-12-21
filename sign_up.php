<?php
$error=" ";
if(isset($_POST['submit'])){
	if(empty($_POST['username'])||empty($_POST['password'])){
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
$user=$_POST["username"];
$pass=$_POST["password"];
$email=$_POST["email"];
$fullname=$_POST["full_name"];
$dob=$_POST["dob"];
$gender=$_POST["gender"];
$phone=$_POST["phone"];
$conn=pg_connect("host=localhost port=5432 dbname=bookrental user=postgres password=tejas@1998");

if(!$conn){
	echo "Connection failed";
} 
else{
$sql='SELECT user_name,pw FROM users';
$val=pg_query($conn,$sql);
if(!$val){
	die('Could not obtain data1'.pg_last_error());
}
while($row=pg_fetch_array($val,NULL,PGSQL_ASSOC)){
	if(($user==$row['user_name'])){
		$flag_username_exists=1;
		break;
	}
}
if($flag_username_exists==1){
	$error="Username already exists";
}
else{
	$val=pg_query($conn,"select count(*) from users");
	$row=pg_fetch_row($val);
	$id=$row[0]+1;
	$id="uaa".(string)$id;
	//echo "$user  $pass";
	//print_r($user);
	//$sql="INSERT INTO login_members VALUES(2,$user,$pass,'hi')";
	$val=pg_query($conn,"INSERT INTO users(user_id,user_name,pw,dob,fullname,phone_number,email_id,sex,deleted_flag) VALUES('$id','$user','$pass','$dob','$fullname','$phone','$email','$gender','false')");
	if(!$val){
		die('Could not obtain data'.pg_last_error($conn));
	}
	$cust="caa".(string)$id;
	$val=pg_query($conn,"INSERT INTO customer(cust_id,user_id) VALUES('$id','$cust')");
	if(!$val){
		die('Could not obtain data'.pg_last_error($conn));
	}
	//echoari "connection sucessfull";
	$_SESSION['login_user']=$user;
	header("Location:profile.php");
}

}
}
}
pg_close($conn);
}
?>
