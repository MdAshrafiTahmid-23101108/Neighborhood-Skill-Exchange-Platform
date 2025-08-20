<?php
require_once('DBconnect.php');

if(isset($_POST['username']) && isset($_POST['password']) && isset($_POST['email']) && isset($_POST['location'])){
	$username= $_POST['username'];
	$password = $_POST['password'];
	$email = $_POST['email'];
	$location= $_POST['location'];
	
	$sql = " INSERT INTO user (user_name,password,email,location,reputation,role) VALUES( '$username', '$password', '$email', '$location',0, 'user') ";
	
	$result = mysqli_query($conn, $sql);
	if(mysqli_affected_rows($conn)){
		header("Location: login.html");
		exit();
	}
	else{
		header("Location: signup.html");
		exit();
	}
}
?>

