<?php
session_start();
require_once("DBconnect.php");
if(!isset($_SESSION['user_id'])){
    header("Location: login.html");
    exit();
}
$user_id = $_SESSION['user_id'];
if(isset($_POST["skill_id"])){
    $skill_id = $_POST["skill_id"];
    $sql = "INSERT INTO user_skill VALUES ($user_id,$skill_id)";
    $result = mysqli_query($conn, $sql);
	if(mysqli_affected_rows($conn)){
		header("Location: user_skill_tree.php");
		exit();
	}
	else{
		header("Location: user_skill_tree.php");
		exit();
	}
}
?>