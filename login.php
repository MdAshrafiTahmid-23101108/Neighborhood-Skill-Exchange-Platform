<?php
require_once('DBconnect.php');

if(isset($_POST['username']) && isset($_POST['password'])){
    $username = $_POST['username'];
    $password = $_POST['password'];
    $sql = "SELECT * FROM user WHERE user_name = '$username' AND password = '$password'";
    $result = mysqli_query($conn, $sql);

    if(mysqli_num_rows($result) > 0){
        // echo "Let him enter";
        header("Location: dashboard.html");
    }
    else{
        echo "Wrong username or password";
    }
}
?>