<html>
<head>
					<link rel="stylesheet" type="text/css" href="orders_styles.css">
</head>	
<body>
	<a href="profile.php"> Home </a>		

</body>
<html>
<?php
	session_start();
	if(isset($_SESSION['login_user'])){

		$conn=pg_connect("host=localhost port=5432 dbname=bookrental user=postgres password=tejas@1998");
		if(!$conn){
			echo "Connection failed";
		} 
		else{
			$user_name=$_SESSION['login_user'];
			//echo 'hi';
			$val=pg_query($conn,"SELECT user_id from users where user_name='$user_name'");
			if(!$val){
				die('Could not obtain data'.pg_last_error($conn));
			}
			$row=pg_fetch_array($val,NULL,PGSQL_ASSOC);
			$user=$row["user_id"];
			$val=pg_query($conn,"SELECT cust_id from customer where user_id='$user'");
			if(!$val){
				die('Could not obtain data'.pg_last_error($conn));
			}
			
			$row=pg_fetch_array($val,NULL,PGSQL_ASSOC);
			$cust=$row["cust_id"];
			$val=pg_query($conn,"SELECT * from orders where cust_id='$cust'");
			if(!$val){
				die('Could not obtain data'.pg_last_error($conn));
			}
			//echo "$cust";
			$size=sizeof($val);
			//echo "$size";
			$arr=pg_fetch_all($val);
			$num_rows=0;
			//echo sizeof($arr);

			while($num_rows<sizeof($arr)){
				$row=$arr[$num_rows];
				//echo "Entered while";
				$order_id=$row["order_id"];
				$time_order=$row["time_of_order"];
				$cost=$row["cost"];
				$deliver_date=$row["deliver_date"];
				$due_date=$row["due_date"];
				$book_id=$row["book_id"];

				$val=pg_query($conn,"SELECT * from book where book_id='$book_id'");
				if(!$val){
					die('Could not obtain data'.pg_last_error($conn));
				}
				//echo 'hi';
				$row=pg_fetch_array($val,NULL,PGSQL_ASSOC);
				$owner=$row["owner_id"];
				$book_name=$row["book_name"];
				$author_name=$row["author_name"];
				//obtaining user_id of owner in order to obtain their info
				$val=pg_query($conn,"select user_id from owner where owner_id='$owner'");
				$row=pg_fetch_array($val,NULL,PGSQL_ASSOC);
				$owner_user_id=$row["user_id"];
				$val=pg_query($conn,"SELECT * from users where user_id='$owner_user_id'");
				if(!$val){
					die('Could not obtain data'.pg_last_error($conn));
				}
				//echo "$owner_user_id";
				//extract owner information
				$row=pg_fetch_array($val,NULL,PGSQL_ASSOC);
				$owner_user_name=$row["user_name"];
				$owner_name=$row["fullname"];
				$owner_email=$row["email_id"];
				$owner_phone=$row["phone_number"];
				
				//extract owner address
				$val=pg_query($conn,"SELECT * from useraddress where user_id='$owner_user_id'");
				if(!$val){
					die('Could not obtain data'.pg_last_error($conn));
				}
				$row=pg_fetch_row($val);
				$address='';
				for($i=1;$i<count($row);$i++){
					$address=$address.",".$row[$i];
				}
				//echo "$address\n";
				//echo "hi";
				?>
				


					<center><h1> <?php if($num_rows==0)echo $_SESSION['login_user']." previous orders" ?> </h1></center>
					<div class="all_orders">
							<div> Order id: <?php echo "$order_id" ?> </div>
							<div> Time of order: <?php echo "$time_order" ?> </div>
							<div>Cost: <?php echo "$cost" ?> </div>
							<div>Deliver date: <?php echo "$deliver_date" ?> </div>
							<div>Due date: <?php echo "$due_date" ?> </div>
							<div>Book name: <?php echo "$book_name" ?> </div>
							<div>Book author: <?php echo "$author_name" ?> </div>
							<div>Owner's username: <?php echo "$owner_user_name" ?> </div>
							<div>Owner's email: <?php echo "$owner_email" ?> </div>
							<div>Owner's phone: <?php echo "$owner_phone" ?> </div>
							<div>Owner's address: <?php echo "$address" ?> </div>
					</div>	
			<?php 
			$num_rows++;
			//echo "$num_rows";
			}
		}
	}
	else{
		echo "session variable not set";
		$test=$_SESSION['login_user'];
		echo '$test';
	}

?>