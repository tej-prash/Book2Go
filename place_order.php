




<?php
$error="";  
session_start();
$flag=0;
if (isset($_POST['submit'])){

    // attempt a connection


$dbh = pg_connect("host=localhost port=5432 dbname=bookrental user=postgres password=tejas@1998");


    if (!$dbh) {


        die("Error in connection: " . pg_last_error());


    }

    // escape strings in input data

    $bookid = pg_escape_string($_POST['bookid']);

    $books = pg_query($dbh, "SELECT * FROM BOOK");
    //$book_count = pg_query($dbh, "SELECT COUNT(*) FROM BOOK");
    if(!$books){
      die("cannot get books\n");
    }
    $exists = 0; 
    $i = 0;
    $val=pg_fetch_all($books);

    while($i<sizeof($val)) {
      $row=$val[$i];
    	if ($bookid == $row["book_id"]) {
    		$exists = 1;
    		break;
  	   }
       $i++;
    }

   if(!$exists){$error="Please enter valid id";header("Location:place_order.php");}
   $user=$_SESSION['login_user'];
   $user_id="SELECT user_id from users where user_name='$user'";
   $val=pg_query($dbh,$user_id);
   if(!$val){
        die("user id failed\n");
    }
   $val=pg_fetch_array($val,NULL,PGSQL_ASSOC);
   $user_id=$val["user_id"];
   $custid= "SELECT cust_id from customer WHERE user_id='$user_id'"; 
   $val=pg_query($dbh,$custid);
   if(!$val){
        die("customer id failed\n");
    }
   $val=pg_fetch_array($val,NULL,PGSQL_ASSOC);
   $custid=$val["cust_id"];
    $t = date('Y-m-d H:i:s');
   $date=date_create();
  $due_date = date_add($date,date_interval_create_from_date_string("14 days"));
  $date=$date->format('Y-m-d');
  $due_date=$due_date->format('Y-m-d');
    $cost = "SELECT book_price from book WHERE book_id = '$bookid'";

    $result = pg_query($dbh, $cost);
    if(!$result){
        die("Cost failed\n");
    }
    $cost=(pg_fetch_row($result))[0];

    $result = pg_query($dbh, "SELECT COUNT(*) FROM ORDERS");
    $num=(pg_fetch_row($result))[0]+1;
    $order_id="oraa".(string)$num;
    // execute query
    //$x = 1;



    $new_order = "INSERT INTO orders (order_id,book_id, cust_id, time_of_order , cost ,status_id,due_date,deliver_date) VALUES('$order_id','$bookid', '$custid' , '$t' , '$cost' , '0','$due_date','$date')";

   //$book_availability_update  = "UPDATE book SET availability = 1 where book_id = '$bookid'" ;

  //$update = pg_query($dbh, $book_availability_update);


    $result = pg_query($dbh, $new_order);


    if (!$result) {


        die("Error in SQL query: " . pg_last_error());


    }

//$update = pg_query($dbh, "UPDATE book SET availability = 'false',");
    $flag=1;
    ?>
    <html>
    <body>
        <h2> Congrats! Your order has been placed! Please note the following order id</h2>

        <h1> <?php echo "$order_id"; ?>
          <a href="disp.php"> Home</a>
    </body> 

    </html>
    <?php


   


    // free memory


    pg_free_result($result);



   


    // close connection


    pg_close($dbh);


}

if (isset($_POST['delete_order'])){
	$dbh = pg_connect("host=localhost port=5432 dbname=bookrental user=postgres password=tejas@1998");

	 if (!$dbh) {


        die("Error in connection: " . pg_last_error());


    }

	 $bookid = pg_escape_string($_POST['bookid']);
	 //$curr_book = pg_query($dbh, "SELECT * FROM BOOK WHERE book_id = '$bookid'");
	 //$status = pg_query($dbh, "SELECT status_id FROM orders WHERE book_id = '$bookid' and status_id='0'");
   //$val=pg_fetch_array($status);
   //$=$val["status_id"];
		$delete = "select * FROM orders WHERE book_id = '$bookid'";

		 $result = pg_query($dbh, $delete);


  	  if (!$result) {
      	  die("Error in SQL query: " . pg_last_error());
   	 }
     $status_code=5;
     $result=pg_fetch_all($result);
     $j=0;
     while($j<sizeof($result)){
        $row=$result[$j];
        $status_code=$row["status_id"];
        if($status_code==0)break;
        $j++;
     }   
     if($status_code==0){
        $delete = "delete FROM orders WHERE book_id = '$bookid' and status_id='0'";
     $result = pg_query($dbh, $delete);

         if (!$result) {
          die("Error in SQL query: " . pg_last_error());
     }
     
      $book_availability_update  = "UPDATE book SET availability = 2 where book_id = '$bookid'" ;

       $result = pg_query($dbh, $book_availability_update);

      if (!$result) {

          die("Error in SQL query: " . pg_last_error());


     } 
     ?>
     <div>
        Deletion sucessful;
        <a href="disp.php">Home </a>
    </div>

     <?php
   }
   else{
    echo "<h2>You cannot delete the order</h2>";
    echo "<a href=\"disp.php\"> Home </a>";
   }
     ?>

     
<?php
    // free memory


    //pg_free_result($result);

}

if((!isset($_POST["submit"]))&&(!isset($_POST["delete_order"]))){		
	

	

	
	

?>


  
<html>
<style>
body{
  background:url("Mild.jpg");
  background-size:cover;
  background-repeat: no-repeat;
}
</style>

<body>
<form action="place_order.php" method="post">

     <center>
     Book_id: <br> <input type="text" name="bookid" size="30">  



     <p>
     <p>


     <input type="submit" name="submit" value="Order the book"> <p>

  
    <input type = "submit" name = "delete_order" value="Cancel order"> <p>
    <div> <?php echo "$error"; ?>

  <center>


   </form> 


  


  </body>


</html>
<?php
}
?>