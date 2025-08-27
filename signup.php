<?php
require_once('DBconnect.php'); 
if (
    isset($_POST['username'], $_POST['password'], $_POST['confirm_password'], $_POST['email'], $_POST['location'])
) {
    $username = trim($_POST['username']);
    $password = $_POST['password'];
    $confirm  = $_POST['confirm_password'];
    $email    = trim($_POST['email']);
    $location = trim($_POST['location']);

    if ($password !== $confirm) {

        header("Location: signup.html?error=1");
        exit();
    }

    if (strlen($password) < 8) {
        header("Location: signup.html?error=2");
        exit();
    }

    $password_hashed = password_hash($password, PASSWORD_DEFAULT);

    $stmt = $conn->prepare("INSERT INTO user (User_name, Password, Email, Location, Reputation, Role) VALUES (?, ?, ?, ?, 0, 'user')");
    if ($stmt === false) {
       
        header("Location: signup.html?error=3");
        exit();
    }

    $stmt->bind_param("ssss", $username, $password_hashed, $email, $location);
    $exec = $stmt->execute();

    if ($exec && $stmt->affected_rows > 0) {
     
        $stmt->close();
        header("Location: login.html");
        exit();
    } else {
       
        $stmt->close();
        header("Location: signup.html?error=4");
        exit();
    }
} else {
    
    header("Location: signup.html?error=5");
    exit();
}
?>
