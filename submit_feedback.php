<?php
session_start();
require_once("DBconnect.php");

$current_user_id = $_SESSION['user_id'] ?? null;

if(isset($_POST['Barter_id'], $_POST['Feedback_score'], $_POST['Feedback_comment'])){
    $barter_id = $_POST['Barter_id'];
    $score = $_POST['Feedback_score'];
    $comment = mysqli_real_escape_string($conn, $_POST['Feedback_comment']);

    // Update session feedback
    $sql = "UPDATE session 
            SET Feedback_score=$score, Feedback_comment='$comment' 
            WHERE Barter_id=$barter_id";
    mysqli_query($conn, $sql);

    header("Location: barter.php");
    exit();
} else {
    echo "Invalid feedback submission.";
}
?>

