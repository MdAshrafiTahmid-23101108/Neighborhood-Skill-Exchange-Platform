<?php
require_once('DBconnect.php');

if(isset($_POST['username']) && isset($_POST['password']) && isset($_POST['email']) && isset($_POST['location'])){
	$username= $_POST['username'];
	$password = $_POST['password'];
	$email = $_POST['email'];
	$location= $_POST['location'];
	
	$sql = " INSERT INTO user (user_name,password,email,location,reputation) VALUES( '$username', '$password', '$email', '$location',0 ) ";
	
	$result = mysqli_query($conn, $sql);
	echo "ran successfully";
	if(mysqli_affected_rows($conn)){
		//echo "Inserted Successfully";
		header("Location: login.html");
	}
	else{
		echo "Insertion Failed";
		header("Location: signup.html");
	}
}
?>

