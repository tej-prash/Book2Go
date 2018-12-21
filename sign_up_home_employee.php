<?php
	session_start();
	if(isset($_SESSION['login_user'])){
		header("Location:employee.php");
	} 
	else{
		include('sign_up_employee.php');
	}
?>
<html>
<head>
<style>
body{
  background-image:url(download.jpg);
  background-size: cover;
  background-repeat:no-repeat;
}
.d1{
    
    border-color:black;
    border-width:1px;
    background: rgba(70, 80, 100, 0.1);
    padding-left:0px;
    padding-right:0px;
    padding-bottom:50px;
    padding-top:10px;
    margin-top:130px;
    margin-right:500px;
    margin-left:500px;
    border-radius:20px;
}

input{
    border-style:solid;
    margin-left:120px;
    margin-right:120px;
    margin-top:20px;
    border-radius:30px;
    border-width:5px;
    border:0.5px;
    width:50%;
    height:25px;
}
#fn{
border-style:solid;
    margin-left:120px;
    margin-right:120px;
    margin-top:0px;
    border-radius:30px;
    border-width:5px;
    border:0.5px;
    width:50%;
}
</style>
</head>
<body>
<div>
<h6 style="font-size:50px;font-family:Serif;color:Black;margin-top:10px;margin-left:50px"><span style="font-size:100px">X</span>PERT-<span style="font-size:90px">T</span>YPING<h6>
</div>
<div class="d1">
<form method="POST" onsubmit="return check()">
<center><h3 style="font-size:30px;font-family:Serif;color:Black;margin-top:10px;margin-bottom:0px;text-decoration:underline">Sign Up<h3><center></br>
<input style="margin-top:0%" id="fn" type="text" name="full_name" placeholder="Full Name " required></br>
<input style="margin-top:0%" id="fn" type="text" name="dob" placeholder="Date of birth " required></br>
<input style="margin-top:0%" id="fn" type="text" name="contact_number" placeholder="Phone number" required></br>
<h1> Enter place of residence details </h1>
<input style="margin-top:0%" id="fn" type="text" name="flat_no" placeholder="Flat number" required></br>
<input style="margin-top:0%" id="fn" type="text" name="street_name" placeholder="Street number" required></br>
<input style="margin-top:0%" id="fn" type="text" name="locality" placeholder="Locality" required></br>
<input style="margin-top:0%" id="fn" type="text" name="city" placeholder="City" required></br>
<input style="margin-top:0%" id="fn" type="text" name="state" placeholder="State" required></br>
<input style="margin-top:0%" id="fn" type="text" name="country" placeholder="Country" required></br>
<input style="margin-top:0%" id="fn" type="text" name="zipcode" placeholder="Zipcode" required></br>


<img src="logo.png" style="height:120px;width:240px">
<input style="background-color:white;color:Blue" type="submit" name="submit"value="Sign Up">
<a href="facebook.com">
</a>
</div>
</body>
</html>

