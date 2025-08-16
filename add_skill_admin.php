<?php
require_once('DBconnect.php');

if(isset($_POST['skill_name']) && isset($_POST['description']) && isset($_POST['category']) && isset($_POST['level'])){
	$skill_name= $_POST['skill_name'];
	$description = $_POST['description'];
	$category = $_POST['category'];
	$level= $_POST['level'];
    $parent=$_POST['parent'];
    $requirement=$_POST['requirement'];

	
	
	$sql = " INSERT INTO skill (skill_name,description,category,expertise_level,parent_id,requirement) VALUES( '$skill_name', '$description', '$category', '$level','$parent', '$requirement') ";
	
	$result = mysqli_query($conn, $sql);
	echo "ran successfully";
	if(mysqli_affected_rows($conn)){
		//echo "Inserted Successfully";
		header("Location: skill_update_admin.php");
	}
	else{
		echo "Insertion Failed";
		header("Location: skill_update_admin.php");
	}
}
?>