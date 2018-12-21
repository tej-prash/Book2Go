<?php
    $error="";

session_start();
if(isset($_SESSION["login_user"])){$user=$_SESSION["login_user"];}
else{header("Location:employee.php");}
if(isset($_POST["submit"])){
    extract($_POST);
    $conn=pg_connect("host=localhost port=5432 dbname=bookrental user=postgres password=tejas@1998");

    if(!$conn){
        echo "Connection failed";
    } 
    else{
    $sql1="select status_id from orders where order_id='$order'";
    $val1=pg_query($conn,$sql1);
    $val1=pg_fetch_array($val1,NULL,PGSQL_ASSOC);
    if($status<5 &&$val1["status_id"] == $status-1){
        
         $sql="insert into fulfill(order_id,employee_id,status_id) values('$order','$user','$status');";
         $val=pg_query($conn,$sql);
         if(!$val){
            die('Could not obtain data'.pg_last_error());
         }

     header("Location: employee.php");
    }
}
}
?>
<!DOCTYPE HTML>
<html>
<body>
<form action="change_status.php" method="post">
Order Id: <input type="text" name="order"><br>
Status: <input type="text" name="status"><br>
<input name="submit" type="submit"></input>
<div><?php echo "$error"; ?> </div>
</form>

</body>
</html>