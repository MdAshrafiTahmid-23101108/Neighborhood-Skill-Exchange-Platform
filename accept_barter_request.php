<?php
session_start();
require_once("DBconnect.php");
if(isset($_POST['Barter_id'])){
    $barter_id = $_POST['Barter_id'];
    $sql_update_barter = "UPDATE barter SET Status='accepted' WHERE Barter_id=$barter_id";
    mysqli_query($conn, $sql_update_barter);
    $sql_update_session = "UPDATE session SET Status='due' WHERE Barter_id=$barter_id";
    mysqli_query($conn, $sql_update_session);
}
header("Location: barter.php");
exit();
?>
