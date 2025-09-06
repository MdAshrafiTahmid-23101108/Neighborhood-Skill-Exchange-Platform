<?php
session_start();
require_once("DBconnect.php");
if(!isset($_SESSION['user_id'])){
    header("Location: login.html");
    exit();
}
$user_id = $_SESSION['user_id'];
if (isset($_POST['challenge_id'])) {
    $challenge_id = $_POST['challenge_id'];
    if(mysqli_num_rows(mysqli_query($conn,"SELECT * FROM participates_in WHERE User_id=$user_id AND Challenge_id=$challenge_id")) == 0){
        $sql = "INSERT INTO participates_in VALUES ($user_id, $challenge_id)";
        mysqli_query($conn, $sql);
    }
}
header("Location: user_challenge.php");
exit();
?>
