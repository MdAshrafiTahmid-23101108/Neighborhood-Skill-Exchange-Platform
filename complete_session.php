<?php
session_start();
require_once("DBconnect.php");
$session_id = $_POST["session_id"];
if(isset($session_id)){
    $sql = "UPDATE session SET status='completed' WHERE Session_id=$session_id";
    mysqli_query($conn,$sql);
}
header("Location: session.php");
exit();