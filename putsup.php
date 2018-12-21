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
<form action="showbooks.php" method=post onsubmit="foo1()">
 	Name The book :<br>
  <input type="text" name="bookname"><br>
  <br>
  Author Name:<br>
  <input type="text" name="authorname"><br><br>
  Book Type: <br>
   <input type="radio" name="booktype" value="paperback" checked> Paperback &nbsp
  <input type="radio" name="booktype" value="hardcover"> Hardcover &nbsp
  <input type="radio" name="booktype" value="other"> Other
  <br>
  <br>
  Book renting price:<br>
   <input type="number" name="bookprice">
   <br>
   Lend Duration:
   <br>
   <input type="number" name="lendduration">

   <br><br>
    <input type="submit" value="Submit">

</form>
</body>
</html>
</br></br>
</body>
</html>