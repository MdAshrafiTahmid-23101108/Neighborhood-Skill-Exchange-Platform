<?php
session_start();
require_once("DBconnect.php");

$current_user_id = $_SESSION['user_id'] ?? null;

if(isset($_POST['Receiver_id'], $_POST['Location'], $_POST['Scheduled_time'])){
    $receiver_id = $_POST['Receiver_id'];
    $location = mysqli_real_escape_string($conn, $_POST['Location']);
    $scheduled_time = mysqli_real_escape_string($conn, $_POST['Scheduled_time']);
    $sql_barter = "INSERT INTO barter (Status, Conversation, Conversation_time) VALUES ('pending','','')";
    mysqli_query($conn, $sql_barter);
    $barter_id = mysqli_insert_id($conn);
    $sql_session = "INSERT INTO session (Location, Scheduled_time, Status, Feedback_score, Feedback_comment, Barter_id) 
                    VALUES ('$location', '$scheduled_time', 'pending', 0, '', $barter_id)";
    mysqli_query($conn, $sql_session);
    $sql_engage = "INSERT INTO engages_in (User_1, User_2, Barter_id) VALUES ($current_user_id, $receiver_id, $barter_id)";
    mysqli_query($conn, $sql_engage);
}

header("Location: barter.php");
exit();
?>
