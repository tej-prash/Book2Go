
<?php
$error=" ";
if(isset($_POST['submit'])){
	if(empty($_POST['username'])||empty($_POST['password'])){
		$error="Username or password invalid";
	}
	else{
$servername="localhost";
$username="postgres";
$password="tejas@1998";
$flag_user_exists=0;
$flag_username_exists=0;
//Start a connection
$user=$_POST["username"];
$pass=$_POST["password"];
$conn=pg_connect("host=localhost port=5432 dbname=bookrental user=postgres password=tejas@1998");

if(!$conn){
	echo "Connection failed";
} 
else{
$sql='SELECT user_name,pw FROM users';
$val=pg_query($conn,$sql);
if(!$val){
	die('Could not obtain data'.pg_last_error());
}
$flag_user_deleted=0;
while($row=pg_fetch_array($val,NULL,PGSQL_ASSOC)){
	if(($user==$row['user_name'])){
		$flag_username_exists=1;
		if(($pass==$row['pw'])){
		if($row["deleted_flag"]=='t'){
			$flag_user_deleted=1;	break;
		}
		$flag_user_exists=1;
		break;
		}
	}
}
if($flag_user_deleted){
	$error="User does not exist!";
}
if($flag_user_exists==1){
	$_SESSION['login_user']=$user; 
//echoari "connection sucessfull";
$temp1=$_SESSION['login_user'];
}
else{
	//if($flag_username_exists==1){
		$error="Incorrect Password. Please try again!";
	//}
	/*else{
		$error="PLEASE SIGN UP";
	}*/
}
}
}
pg_close($conn);
}
?>
