<?php
session_start();
require_once("DBconnect.php");

$current_user_id = $_SESSION['user_id'] ?? null;
if (!$current_user_id) {
    header("Location: login.php");
    exit();
}
$sql = "
SELECT S.Session_id, S.Location, S.Scheduled_time, S.Status AS Session_status, 
       B.Status AS Barter_status, U1.User_name AS Sender, U2.User_name AS Receiver,
       E.User_1, E.User_2, B.Barter_id
FROM session S
INNER JOIN barter B ON S.Barter_id = B.Barter_id
INNER JOIN engages_in E ON B.Barter_id = E.Barter_id
INNER JOIN user U1 ON E.User_1 = U1.User_id
INNER JOIN user U2 ON E.User_2 = U2.User_id
WHERE (E.User_1 = $current_user_id OR E.User_2 = $current_user_id)
AND B.Status = 'accepted'
ORDER BY S.Scheduled_time ASC
";
$result = mysqli_query($conn, $sql);
?>
<!DOCTYPE html>
<html lang="en">
<head>
<meta charset="UTF-8">
<meta name="viewport" content="width=device-width, initial-scale=1.0">
<title>My Sessions</title>
</head>
<body>
<h1>My Sessions</h1>
<a href="user_dashboard.php">Back to Dashboard</a>
<br><br>
<?php
if ($result && mysqli_num_rows($result) > 0) {
    echo "<table border='1' cellpadding='5' cellspacing='0'>";
    echo "<tr>
            <th>With</th>
            <th>Skill/Topic</th>
            <th>Location</th>
            <th>Scheduled Time</th>
            <th>Barter Status</th>
            <th>Session Status</th>
            <th hidden></th>
          </tr>";
    while ($row = mysqli_fetch_assoc($result)) {
        $other_user_id = ($row['User_1'] == $current_user_id) ? $row['User_2'] : $row['User_1'];
        $other_user_name = ($row['User_1'] == $current_user_id) ? $row['Receiver'] : $row['Sender'];
        $location = $row['Location'] ?: 'Not scheduled';
        $scheduled_time = ($row['Scheduled_time'] && $row['Scheduled_time'] != '0000-00-00 00:00:00') 
                          ? $row['Scheduled_time'] : 'Not scheduled';
        $sql_skill = "
        SELECT SK.Skill_name
        FROM user_skill US
        INNER JOIN skill SK ON US.Skill_id = SK.Skill_id
        WHERE US.User_id = {$row['User_1']}
        ";
        $skill_result = mysqli_query($conn, $sql_skill);
        $skill_name = "N/A";
        if ($skill_result && mysqli_num_rows($skill_result) > 0) {
            $skill_row = mysqli_fetch_assoc($skill_result);
            $skill_name = $skill_row['Skill_name'];
        }
        echo "<tr>";
        echo "<td>$other_user_name</td>";
        echo "<td>$skill_name</td>";
        echo "<td>$location</td>";
        echo "<td>$scheduled_time</td>";
        echo "<td>{$row['Barter_status']}</td>";
        echo "<td>{$row['Session_status']}</td>";
        if($row['Session_status'] == "due"){
            ?>
            <td><form action="complete_session.php" method="post">
                <input type="hidden" name="session_id" value="<?php echo $row['Session_id'] ?>">
                <input type="submit" value="complete">
                </form>
            </td>
            <?php
        }
        echo "</tr>";
    }
    echo "</table>";
} else {
    echo "<p>No upcoming sessions found for you.</p>";
}
?>
</body>
</html>
