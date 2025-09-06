<?php
session_start();
require_once("DBconnect.php");
if(!isset($_SESSION['user_id'])){
    header("Location: login.html");
    exit();
}

?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Request_Pending_for_users</title>
</head>
<body>
    <header>
        <h1>This is Request Pending from User</h1>
    </header>
    <nav>
        <a href="skill_update_admin.php">Skill List</a>
        <a href="challenge_update_admin.php">Challenge List</a>
        <a href="logout.php">Log out</a>
    </nav>
    <table>
        <thead>
            <tr>
                <th>User ID</th>
                <th>User Name</th>
                <th>Challenge Title</th>
                <th>End Time</th>
                <th>Reward</th>
                <th>Confirmation Button</th>
                <th hidden></th>
            </tr>
        </thead>
        <tbody>
            <?php
            $sql = "SELECT p.User_id, u.User_name, p.Challenge_id, c.Title, c.End_time, c.Reward 
            FROM participates_in p 
            JOIN user u ON p.User_id = u.User_id 
            JOIN challenge c ON p.Challenge_id = c.Challenge_id 
            ORDER BY c.End_time ASC";
            $result = mysqli_query($conn, $sql);
            if(mysqli_num_rows($result) > 0){
                while($row = mysqli_fetch_assoc($result)){
                    
            ?>
            <tr>
                <td><?php echo $row["User_id"]; ?></td>
                <td><?php echo $row["User_name"]; ?></td>
                <td><?php echo $row["Title"]; ?></td>
                <td><?php echo $row["End_time"]; ?></td>
                <td><?php echo $row["Reward"]; ?></td>
                <td>
                    <form action= "admin_confirm.php" method = "post">
                        <input type="hidden" name = "Challenge_id" value = "<?php echo $row["Challenge_id"]; ?>">
                        <input type="hidden" name = "User_id" value = "<?php echo $row["User_id"]; ?>">
                        <input type = "submit" name = "confirm" value = conirm>
                    </form>
                </td>
            </tr>
            <?php
                }
            }
            ?>
        </tbody>
    </table>
</body>
</html>

