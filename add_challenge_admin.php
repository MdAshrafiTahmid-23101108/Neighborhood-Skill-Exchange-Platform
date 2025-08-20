<?php
require_once('DBconnect.php');

if(isset($_POST['title']) && isset($_POST['description']) && isset($_POST['start_time']) && isset($_POST['end_time'])&& isset($_POST['reward'])){
	$title= $_POST['title'];
	$description = $_POST['description'];
	$start_time= $_POST['start_time'];
    $end_time=$_POST['end_time'];
    $reward=$_POST['reward'];

	
	
	$sql = " INSERT INTO challenge (Title,Description,Start_time,End_time,Reward) VALUES( '$title', '$description', '$start_time','$end_time', '$reward') ";
	
	$result = mysqli_query($conn, $sql);
	if(mysqli_affected_rows($conn)){
		header("Location: challenge_update_admin.php");
		exit();
	}
	else{
		header("Location: challenge_update_admin.php");
		exit();
	}
}
?>