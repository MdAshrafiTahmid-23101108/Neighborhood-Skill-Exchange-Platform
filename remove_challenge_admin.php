<?php
require_once('DBconnect.php');

if (isset($_POST['challenge_id'])){
    $challenge_id = $_POST['challenge_id'];

    $sql = " DELETE FROM challenge WHERE Challenge_id=$challenge_id ";
	
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