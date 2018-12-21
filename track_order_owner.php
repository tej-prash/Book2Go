<?php
session_start();
if(isset($_SESSION["login_user"])){$user=$_SESSION["login_user"];}
else{header("Location:putsup.php");}
if(isset($_POST["submit"])){
    extract($_POST);
    $conn=pg_connect("host=localhost port=5432 dbname=bookrental user=postgres password=tejas@1998");

    if(!$conn){
        echo "Connection failed";
    } 
    else{
    $sql1="select f.status_id from fulfill f,orders o where o.order_id=f.order_id and o.book_id='$order' order by f.status_id DESC";    
    $val1=pg_query($conn,$sql1);
    $val1=pg_fetch_array($val1,NULL,PGSQL_ASSOC);
    if($val1["status_id"] > 0){

         if(!$val1){
            die('Could not obtain data'.pg_last_error());
         }
         $status_code=$val1["status_id"];
        $sql="select * from status where status_id='$status_code'";
        $val=pg_query($conn,$sql);
        $val=pg_fetch_array($val,NULL,PGSQL_ASSOC);
        if(!$val){
            die('Could not obtain data'.pg_last_error());
        }
        $description=$val["status_name"];
        ?>
        <html>
             <head>
                <link rel="stylesheet" type="text/css" href="orders_styles.css">
            </head>
            <body>

            <div class="all_orders">   
                <?php 
                echo "$status_code <br>"; 
                if($status_code==4)
                    echo "Your order has been completed and your book is with you";
                else if($status_code==0){
                    echo "An order has been placed on your book";
                }
                else{
                    echo "Your book with book id $order has been $description";
                }
                ?>

            </div>

            </body>
            </html>
            <?php
     }

 
}
}
else{



?>
<!DOCTYPE HTML>
<html>
<head>
        <link rel="stylesheet" type="text/css" href="orders_styles.css">
 </head>
<body>
<form action="track_order_owner.php" method="post">
<h2> Book Id: <input type="text" name="order"><br></h2>
<input name="submit" type="submit"></input>
</form>

</body>
</html>
<?php
}
?>