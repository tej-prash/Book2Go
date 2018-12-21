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
	<?php 

	if(isset($_SESSION['login_user'])){

		$conn=pg_connect("host=localhost port=5432 dbname=bookrental user=postgres password=tejas@1998");
		if(!$conn){
			echo "Connection failed";
		} 
		else{
					extract($_POST);
					$book_id=$remove;
					//echo $book_id;
					pg_query($conn,"UPDATE book
				SET availability = 0 WHERE book_id='$book_id';");
					//echo "done";
					header('Location: showbooksup.php');
			}
		}
	?>

					

</body>
</html>
