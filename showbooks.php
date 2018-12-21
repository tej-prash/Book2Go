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
					$name=$_SESSION['login_user'];
					$val=pg_query($conn,"SELECT user_id from users WHERE user_name='$name'");
					$row=pg_fetch_row($val);
					$user_id=$row[0];
					$val=pg_query($conn,"SELECT count(*) from owner WHERE user_id='$user_id'");
					$row=pg_fetch_row($val);
					$row=$row[0];
					//echo ($row);
					if($row==0)
						{
							$val=pg_query($conn,"SELECT count(*) from owner");
					$count=pg_fetch_row($val);
					$countrow=$count[0]+1;
							pg_query($conn,"INSERT into owner values('oaa$countrow','$user_id');");
					$new_owner_id="oaa$countrow";
						}
					else
					{
						$val=pg_query($conn,"SELECT owner_id from owner WHERE user_id='$user_id'");
					$row=pg_fetch_row($val);
					$new_owner_id=$row[0];

					}
					$val=pg_query($conn,"SELECT count(*) from book");
					$count=pg_fetch_row($val);
					$countrow=$count[0]+1;
					pg_query($conn,"INSERT into book values('baa$countrow', '$bookname', '$booktype', '$bookprice', '$lendduration', '$new_owner_id','$authorname',2);");
					header('Location: showbooksup.php');
					// $val=pg_query($conn,"SELECT book_name,author_name from book where owner_id='$new_owner_id'");
					// $rows=pg_fetch_all($val);
					// $i=0;
					// while($i<sizeof($rows)){
					// 	$row=$rows[$i];	
					// 	$book_name=$row["book_name"];
					// 	$author_name=$row["author_name"];
					// 	echo("$book_name\n");
					// 	echo("$author_name\n");
					// 	$i++;

					//}
			}
		}
	?>

					

</body>
</html>
