<?php
session_start();
require_once("DBconnect.php");
if(!isset($_SESSION['user_id'])){
    header("Location: login.html");
    exit();
}
if (isset($_POST["User_id"]) && isset($_POST["Challenge_id"])){
    $Challenge_id = $_POST["Challenge_id"];
    $User_id = $_POST["User_id"];
    $sql = "SELECT Reward FROM challenge WHERE Challenge_id = $Challenge_id";
    $result = mysqli_query($conn, $sql);
    $Reward = 0;
    if(mysqli_num_rows($result) > 0){
        $Reward = mysqli_fetch_assoc($result)["Reward"];
    }
    $sql = "UPDATE user SET Reputation= Reputation + $Reward WHERE User_id = $User_id";
    mysqli_query($conn, $sql);
}
header("Location: admin_request_pending.php");
exit();
?>