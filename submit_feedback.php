<?php
session_start();
require_once("DBconnect.php");

$current_user_id = $_SESSION['user_id'] ?? null;
if (!$current_user_id) {
    header("Location: login.php");
    exit();
}
if (isset($_POST['Session_id'], $_POST['Feedback_score'], $_POST['Feedback_comment'])) {
    $session_id = intval($_POST['Session_id']);
    $score = intval($_POST['Feedback_score']);
    $comment = mysqli_real_escape_string($conn, $_POST['Feedback_comment']);

    $sql = "UPDATE session SET Feedback_score = $score, Feedback_comment = '$comment' WHERE Session_id = $session_id";
    if (mysqli_query($conn, $sql)) {
        echo "Feedback submitted successfully!<br>";
        echo "<a href='sessions.php'>Back to Sessions</a>";
    } else {
        echo "Error: " . mysqli_error($conn);
    }
} else {
    echo "Invalid request.";
}
?>
