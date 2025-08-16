<?php
$servername = "localhost";
$username = "root";
$password = "";
$dbname = "neighbourhood-skill-exchange";

$conn = new mysqli($servername, $username, $password);
if ($conn->connect_error) {
    die("Connection Failed: ". $conn->connect_error);
}else{
    echo "Connection Established";
    mysqli_select_db($conn, $dbname);
}
?>