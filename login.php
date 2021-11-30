<?php 

session_start();
require_once('config/db_connect.php');
$username = $passwrod = '';

$errors = array('username' => '', 'password' => '');

if(isset($_POST['submit'])) {
	if (empty($_POST['username'])) {
		$errors['username'] = 'Username is required';
	} else {
		$username = $_POST['username'];
	}

	if(empty($_POST['password'])) {
		$errors['password'] = 'Password is required';
	} else {
		$password = $_POST['password'];
	}

    $sql="select * from user where username='".$username."'AND password='".$password."' limit 1";

	$result = mysqli_query($conn, $sql);

	if(mysqli_num_rows($result)==1){
       
       echo "You have logged succesfully";
	   header("Location: index.php");
	   exit();
    }
    else{
        echo " You Have Entered Incorrect Password";
		header("Location: login.php");
        exit();
    }
}

?>



<!DOCTYPE html>
<html>
<head>
	<title> Login Page </title>
	<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.7.0/css/font-awesome.min.css">
	<link href="https://fonts.googleapis.com/icon?family=Material+Icons"
      rel="stylesheet">
	<link rel="stylesheet" a href="css/login.css">
</head>
<body>
	<div class="container">
	<img src="img/avatar.png"/>
		<form action="login.php" method="POST" enctype="multipart/form-data">
			<div class="form-input">
				<input type="text" name="username" placeholder="Enter the username"/> 
				<div class="red-text"> <?php echo $errors['username']; ?> </div>
			</div>
			<div class="form-input">
				<input type="password" name="password" placeholder="Enter the password"/>
				<div class="red-text"> <?php echo $errors['password']; ?> </div>
			</div>
			<input type="submit" name="submit" value="LOGIN" class="btn-login"/>
		</form>
	</div>
</body>
</html>