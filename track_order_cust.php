<?php
session_start();
if(isset($_SESSION["login_user"])){$user=$_SESSION["login_user"];}
else{header("Location:profile.php");}
if(isset($_POST["submit"])){
    extract($_POST);
    $conn=pg_connect("host=localhost port=5432 dbname=bookrental user=postgres password=tejas@1998");

    if(!$conn){
        echo "Connection failed";
    } 
    else{
        $sql1="select status_id from fulfill where order_id='$order' order by status_id DESC";
        $val1=pg_query($conn,$sql1);
        $val1=pg_fetch_array($val1,NULL,PGSQL_ASSOC);
        if($val1["status_id"] > 0 && $val1["status_id"] < 3 ){
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
                echo "Your order has been $description";
                ?>
            </div>
            <a href="profile.php"> Home </a>        

            </body>
            </html>

        <?php
        }
        else{
            ?>
            <html>
             <head>
                <link rel="stylesheet" type="text/css" href="orders_styles.css">
            </head>
            <body>

            <div class="all_orders">   
                Please enter valid status or order id
            </div>

            </body>
            </html> 
            <?php
        }
    }
}
else{

?>

<html>
<head>
        <link rel="stylesheet" type="text/css" href="orders_styles.css">
</head>
<body>
<form action="track_order_cust.php" method="post">
<h1> Order Id: <input type="text" name="order" ><br> </h1>
<br>
<input name="submit" type="submit" style="text-decoration: none;
            outline:none;
            border:2px solid #f49292;
            background:#f46969;
            border-radius:18px;
            margin:5px;
            width:150px;
            height:40px;"></input>
</form>
</body>
</html>
<?php
}
?>