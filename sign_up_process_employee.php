
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
$sql="SELECT employee_id,contact_number FROM employee";
$val=pg_query($conn,$sql);
if(!$val){
	die('Could not obtain data'.pg_last_error());
}
$rows=pg_fetch_all($val);
$count=0;
while($count<sizeof($rows)){
	$row=$rows[$count];
	if(($user==$row['employee_id'])){
		$flag_username_exists=1;
		if(($pass==$row['contact_number'])){
		$flag_user_exists=1;
		break;
		}
	}
	$count++;
}
if($flag_user_exists==1){
	$_SESSION['login_user']=$user; 
//echoari "connection sucessfull";
$temp1=$_SESSION['login_user'];
echo "session variable set $user";
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
