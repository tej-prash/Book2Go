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
	<link rel="stylesheet" type="text/css" href="orders_styles.css">
</head>
<body>
	<?php 

	if(isset($_SESSION['login_user'])){

		$conn=pg_connect("host=localhost port=5432 dbname=bookrental user=postgres password=tejas@1998");
		if(!$conn){
			echo "Connection failed";
		} 
		else{
					$name=$_SESSION['login_user'];
					$val=pg_query($conn,"SELECT user_id from users WHERE user_name='$name'");
					$row=pg_fetch_row($val);
					$user_id=$row[0];
					$val=pg_query($conn,"SELECT owner_id from owner WHERE user_id='$user_id'");
					$row=pg_fetch_row($val);
					$new_owner_id=$row[0];
					$val=pg_query($conn,"SELECT count(*) from book where owner_id='$new_owner_id' AND (availability=1)");
					$row=pg_fetch_row($val);
					$countt=$row[0];
					$val=pg_query($conn,"SELECT count(*) from book where owner_id='$new_owner_id' AND (availability=2)");
					$row=pg_fetch_row($val);
					$count2=$row[0];
					$val=pg_query($conn,"SELECT book_name,author_name,book_type,book_price,lend_duration,book_id,availability,owner_id from book where owner_id='$new_owner_id' AND (availability=1)");
					$rows=pg_fetch_all($val);
					$i=0;
					$val2=pg_query($conn,"SELECT book_name,author_name,book_type,book_price,lend_duration,book_id,availability from book where owner_id='$new_owner_id' AND (availability=2)");
					$rows2=pg_fetch_all($val2);
					$j=0;
					
					if($countt!=0)
					{	echo("the books which are taken by another user are-<br>");
					while($i<sizeof($rows)){
						$row=$rows[$i];	
						$book_name=$row["book_name"];
						$author_name=$row["author_name"];
						$book_type=$row["book_type"];
						$book_price=$row["book_price"];
						$lend_duration=$row["lend_duration"];
						$book_id=$row["book_id"];
						$owner_id=$row["owner_id"];
						$val=pg_query($conn,"SELECT cust_id from orders where book_id='$book_id'");
						$ro=pg_fetch_row($val);
						$cust_id=$ro[0];
						$val=pg_query($conn,"SELECT user_id from customer where cust_id='$cust_id'");
						$ro=pg_fetch_row($val);
						$user2_id=$ro[0];
						$val=pg_query($conn,"SELECT user_name from users where user_id='$user2_id'");
						$ro=pg_fetch_row($val);
						$user2_name=$ro[0];
						echo("<div class=\"all_orders\">
							<div> Book Name: $book_name </div>
							<div> Author Name: $author_name </div>
							<div>Cost: $book_price </div>
							<div>Lend Duration: $lend_duration </div>
							<div>Book Type : $book_type</div>
							<div>Book id: $book_id </div>
							<div>cust who has borrowed your book is $user2_name</div>
							

							
					</div>	<br><br>");
						$i++;

					}
				}
				echo("The books which are available are - <br>");
				if($count2!=0)
				{
					while($j<sizeof($rows2)){
						$row=$rows2[$j];	
						$book_name=$row["book_name"];
						$author_name=$row["author_name"];
						$book_type=$row["book_type"];
						$book_price=$row["book_price"];
						$lend_duration=$row["lend_duration"];
						$book_id=$row["book_id"];
						echo("<div class=\"all_orders\">
							<div> Book Name: $book_name </div>
							<div> Author Name: $author_name </div>
							<div>Cost: $book_price </div>
							<div>Lend Duration: $lend_duration </div>
							<div>Book Type : $book_type</div>
							<div>Book id: $book_id </div>
							<form action=\"deletebooks.php\" method=\"post\">
				
<button name=\"remove\" type=\"submit\" value=$book_id>Remove </button>
</script>

							
					</div>	<br><br>");
						$j++;

					}
				}
				}

				
			}
		
	?>

			<a href="profile.php"> Home </a>		

</body>
</html>
