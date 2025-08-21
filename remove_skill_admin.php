<?php
require_once('DBconnect.php');

if (isset($_POST['skill_id'])){
    $skill_id = $_POST['skill_id'];

    $sql = " DELETE FROM skill WHERE Skill_id=$skill_id ";
	
	$result = mysqli_query($conn, $sql);
	if(mysqli_affected_rows($conn)){
		header("Location: skill_update_admin.php");
		exit();
	}
	else{
		header("Location: skill_update_admin.php");
		exit();
	}
}
?>