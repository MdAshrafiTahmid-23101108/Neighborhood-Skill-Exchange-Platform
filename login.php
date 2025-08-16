<?php
session_start();
require_once('DBconnect.php');

if(isset($_POST['username']) && isset($_POST['password'])){
    $username = $_POST['username'];
    $password = $_POST['password'];
    $sql = "SELECT user_id,role FROM user WHERE user_name = '$username' AND password = '$password'";
    $result = mysqli_query($conn, $sql);

    if(mysqli_num_rows($result) > 0){
        $row = mysqli_fetch_assoc($result);
        $_SESSION['user_id'] = $row['user_id'];
        if ($row['role'] === 'admin') {
            header("Location: admin_dashboard.html");
        } elseif ($row['role'] === 'user') {
            header("Location: user_dashboard.php");
        }
    }
    else{
        echo "Wrong username or password";
    }
}
?>