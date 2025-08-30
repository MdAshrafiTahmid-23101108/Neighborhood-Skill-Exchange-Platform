<?php
session_start();
require_once("DBconnect.php");
if(!isset($_SESSION['user_id'])){
    header("Location: login.html");
    exit();
}
$user_id = $_SESSION['user_id'];
$name = $_SESSION['user_name'];
$reputation = $_SESSION['reputation'];
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Challenges</title>
</head>
<body>
    <header>
        <h1>This is Challenges page</h1>
    </header>
    <nav>
        <a href="user_dashboard.php">Dashboard</a>
        <a href="user_skill_tree.php">My skills</a>
        <a href="barter.php">Barter</a>
        <a href="logout.php">Log out</a>
        <a href="leaderboard.php">Leaderboard</a>
    </nav>
    <section class="user">
        <h2><?php echo $name; ?></h2>
        <h3>Reputation Score: <?php echo $reputation;?></h3>
    </section>
    <section class="Challenge list">
        <table>
            <thead>
                <tr>
                    <th>Title</th>
                    <th>Description</th>
                    <th>Start_time</th>
                    <th>End_time</th>
                    <th>Reward</th>
                    <th hidden></th>
                </tr>
            </thead>
            <tbody>
                <?php 
                $sql = "SELECT * FROM challenge";
                $result = mysqli_query($conn, $sql);
                if(mysqli_num_rows($result) > 0){
                    while($row = mysqli_fetch_assoc($result)){
                ?>
                <tr>
                    <td><?php echo $row["Title"]; ?></td>
                    <td><?php echo $row["Description"]; ?></td>
                    <td><?php echo $row["Start_time"]; ?></td>
                    <td><?php echo $row["End_time"]; ?></td>
                    <td align="center"><?php echo $row["Reward"]; ?></td>
                    <td>
                    <form action="join_challenge.php" method="post">
                        <input type="submit" value="join">
                    </form>
                    </td>
                </tr>
                <?php
                    }
                }
                ?>
            </tbody>
        </table>
    </section>
</body>
</html>