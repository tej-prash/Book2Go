<html>
<head>
	<link rel="stylesheet" type="text/css" href="orders_styles.css">
</head>
<body>


<?php

session_start();

$dbh = pg_connect("host=localhost port=5432 dbname=bookrental user=postgres password=tejas@1998");



if (!$dbh) {


    die("Error in connection: " . pg_last_error());


}

$userid = "SELECT user_id from users where user_name = '$_SESSION[login_user]' " ;
$result_userid = pg_query($dbh, $userid);
$result_userid=pg_fetch_row($result_userid)[0];
$prev_orders = "SELECT * from orders o, customer c where c.user_id ='$result_userid' and c.cust_id = o.cust_id";

$result_prev_orders = pg_query($dbh, $prev_orders);
if(!$result_prev_orders) die("error : " . pg_last_error());
$curr_date = date('Y-m-d');

$row=pg_fetch_all($result_prev_orders);
$j=0;
while ( $j< sizeof($row)) {
	$i=$row[$j];
	$due_date = $i["due_date"];
	 $orderid=$i["order_id"];

	if(strtotime($curr_date) > strtotime($due_date)) {
		echo "Order " .$i["order_id"]. " is overdue. <br /> ";
		$book_title = "SELECT book_name from book b , orders o where b.book_id = o.book_id and o.order_id = '$orderid'";
		$result_book_title = pg_query($dbh , $book_title);

		if(!$result_book_title) die("error : " . pg_last_error());
		$result_book_title = pg_fetch_row($result_book_title)[0];
		echo " Book title: " . $result_book_title . "<br/>";
		echo "Due date :" . $i["due_date"] . "<br/>"; ?>
		<form action="overdue.php" method="post">
		<input type = "submit" name = "renew"> 
		$_POST["order_id"]=$orderid;
		$_POST[""]
		</form>
		<?php
		if (isset($_POST["renew"])){
	   		$orderid=$i["order_id"];
			$lend_dur = "select b.lend_duration from book b, orders o where b.book_id = o.book_id and o.order_id = '$orderid'";
			$lend_dur=pg_query($dbh,$lend_dur);
			if(!$lend_dur){
				die("Failure");
			}
			$lend_dur=pg_fetch_row($lend_dur)[0];
			$new_date = date_add(date_create($i["due_date"]),date_interval_create_from_date_string($lend_dur));
			$new_date = $new_date->format('Y-m-d');
			$book_renew_update  = "UPDATE orders SET due_date = '$new_date' where order_id = '$orderid'" ;
	  		$update = pg_query($dbh, $book_renew_update);
	  		if(!$update){
	  			die("Failture update");
	  		}
  		}
	}
	$j++;
} 	
?>

