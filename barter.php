<?php
session_start();
require_once("DBconnect.php");
$current_user_id = $_SESSION['user_id'] ?? null;
if (isset($_POST['Searchbox'])) {
    $search = $_POST['Searchbox'];
    header("Location: barter.php?search=$search");
    exit();
}
$search = $_GET['search'] ?? '';
?>
<!DOCTYPE html>
<html lang="en">
<head>
<meta charset="UTF-8">
<meta name="viewport" content="width=device-width, initial-scale=1.0">
<title>Barter</title>
</head>
<body>
    <h1>This is barter page</h1>
    <nav>
        <a href="user_dashboard.php">Dashboard</a>
        <a href="user_skill_tree.php">My skills</a>
        <a href="logout.php">Log out</a>
        <a href="leaderboard.php">Leaderboard</a>
        <a href="user_challenge.php">Challenges</a>
    </nav>
    <section class="Barter">
    <h1>Users who have this skill:</h1>
    <form action="barter.php" method="post">
        <p>Searchbox:<input type="text" name="Searchbox" required></p>
        <input type="submit" value="Search" />
    </form>
    <?php
    $sql_pending = "SELECT E.User_1 AS Sender_id, U.User_name AS Sender_name, B.Barter_id, B.Status, S.Location, S.Scheduled_time, S.Status AS Session_status
                    FROM engages_in E
                    INNER JOIN user U ON E.User_1 = U.User_id
                    INNER JOIN barter B ON E.Barter_id = B.Barter_id
                    LEFT JOIN session S ON B.Barter_id = S.Barter_id
                    WHERE E.User_2 = $current_user_id AND B.Status='pending'";
    $result_pending = mysqli_query($conn, $sql_pending);
    echo "<h3>Pending barter requests for you:</h3>";
    if ($result_pending && mysqli_num_rows($result_pending) > 0) {
        while ($row = mysqli_fetch_assoc($result_pending)) {
            echo "{$row['Sender_name']} has sent you a barter request ";
            echo "<br>Session Location: {$row['Location']}";
            echo "<br>Scheduled Time: {$row['Scheduled_time']}";
            echo "<form action='accept_barter_request.php' method='POST' style='display:inline'>";
            echo "<input type='hidden' name='Barter_id' value='{$row['Barter_id']}'>";
            echo "<button type='submit'>Accept</button></form><br><hr>";
        }
    } else {
        echo "No pending requests.<br>";
    }
    $sql_sent = "SELECT E.User_2 AS Receiver_id, U.User_name AS Receiver_name, B.Barter_id, B.Status, S.Location, S.Scheduled_time, S.Status AS Session_status
                FROM engages_in E
                INNER JOIN user U ON E.User_2 = U.User_id
                INNER JOIN barter B ON E.Barter_id = B.Barter_id
                LEFT JOIN session S ON B.Barter_id = S.Barter_id
                WHERE E.User_1 = $current_user_id";
    $result_sent = mysqli_query($conn, $sql_sent);
    echo "<h3>Requests you have sent:</h3>";
    if ($result_sent && mysqli_num_rows($result_sent) > 0) {
        while ($row = mysqli_fetch_assoc($result_sent)) {
            $status_text = $row['Status'] === 'accepted' ? 'accepted your request' : $row['Status'];
            echo "{$row['Receiver_name']} - Status: {$status_text}";
            echo "<br>Session Location: {$row['Location']}";
            echo "<br>Scheduled Time: {$row['Scheduled_time']}";
            echo "<br>Session Status: {$row['Session_status']}<br><hr>";
        }
    } else {
        echo "No requests sent.<br>";
    }
    if ($search !== '') {
        $search_safe = mysqli_real_escape_string($conn, $search);
        $sql_search = "SELECT U.User_id, U.User_name
                    FROM user U
                    INNER JOIN user_skill US ON U.User_id = US.User_id
                    INNER JOIN skill S ON US.Skill_id = S.Skill_id
                    WHERE S.Skill_name LIKE '%$search_safe%'
                    AND U.User_id != $current_user_id";
        $result_search = mysqli_query($conn, $sql_search);

        if ($result_search && mysqli_num_rows($result_search) > 0) {
            while ($row = mysqli_fetch_assoc($result_search)) {
                $receiver_id = $row['User_id'];
                echo "<h3>{$row['User_name']}</h3>";
                echo "<form action='send_barter_request.php' method='POST' style='display:inline'>";
                echo "<input type='hidden' name='Receiver_id' value='$receiver_id'>";
                echo "Session Location: <input type='text' name='Location' required>";
                echo " Scheduled Time: <input type='datetime-local' name='Scheduled_time' required>";
                echo "<button type='submit'>Barter Request</button>";
                echo "</form><hr>";
            }
        } else {
            echo "No users found with this skill.<br>";
        }
    }
    ?>
    </section>
</body>
</html>
