<html>
<head>
	<link rel="stylesheet" type="text/css" href="orders_styles.css">
</head>
<body>


<?php

$dbh = pg_connect("host=localhost port=5432 dbname=bookrental user=postgres password=tejas@1998");


if (!$dbh) {


    die("Error in connection: " . pg_last_error());


}

$books_available = "SELECT * from book where availability = 2 ";

$result = pg_query($dbh, $books_available);

if (!$result) {


    die("Error in SQL query: " . pg_last_error());


} ?>

<div class = "all_orders">
<?php

while ($row = pg_fetch_array($result)) {


    echo "Book ID: " . $row[0] . "<br />";


    echo "Title: " . $row[1] . "<br />";

    echo "Author: " . $row[6] . "<br />";

    echo "Owner ID: " . $row[5] . "<br />";

     echo "Lend duration(days): " . $row[4] . "<br />";

    echo "Price: " . $row[3] . "<br />";
    echo " <br> <br> <br> ";

}
pg_free_result($result);

//$books_in_circulation = "SELECT * from book where availability = 1";

//$result = pg_query($dbh, $books_in_circulation);

?>

<div class = "all_orders">
<?php
$usernameq = "SELECT * from BOOK b, USERS u , OWNER o,orders ord where b.owner_id = o.owner_id and o.user_id = u.user_id and b.availability=1 and b.book_id = ord.book_id";
//$duedateq= "SELECT due_date from ORDERS o, BOOK b where b.book_id = ord.book_id and b.availability=1";

$username =  pg_query($dbh, $usernameq);
//$duedate = pg_query($dbh, $duedateq);



while ($row = pg_fetch_array($username)) {


    echo "Book ID: " . $row["book_id"] . "<br />";


    echo "Title: " . $row["book_name"] . "<br />";

    echo "Author: " . $row["author_name"] . "<br />";

    echo "Owner ID: " . $row["owner_id"] . "<br />";

     echo "Lend duration(days): " . $row["lend_duration"] . "<br />";

    echo "Price: " . $row["book_price"] . "<br />";
    echo "Ownername: " . $row["fullname"] .  "<br/>";
    echo "due date: " . $row["due_date"] . "<br/>";
    echo " <br> <br> <br> ";

}
pg_close($dbh);

?>
<form name="place_order"action="place_order.php">
<input type="submit" value =" Click here to order a book! "style="text-decoration: none;
            outline:none;
            border:2px solid #f49292;
            background:#f46969;
            border-radius:18px;
            margin:20px;
            width:200px;
            height:40px;" > </input>
 </form>           
  </body>


</html>



