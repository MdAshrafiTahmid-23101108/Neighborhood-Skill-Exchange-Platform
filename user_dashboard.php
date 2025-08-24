<?php
session_start();
require_once("DBconnect.php");
if(!isset($_SESSION['user_id'])){
    header("Location: login.html");
    exit();
}
$user_id = $_SESSION['user_id'];
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Dashboard</title>
</head>
<body>
    <header>
        <h1>This is User Dashboard</h1>
    </header>
    <nav>
        <a href="user_skill_tree.php">My skills</a>
        <a href="barter.php">Barter</a>
        <a href="logout.php">Log out</a>
        <a href="leaderboard.php">Leaderboard</a>

    </nav>
    <?php 
    $sql = "SELECT * FROM user WHERE User_id=$user_id";
    $result = mysqli_query($conn, $sql);
    if(mysqli_num_rows($result) > 0){
        $row = mysqli_fetch_array($result);
        $name = $row["User_name"];
        $reputation = $row["Reputation"];
    ?>
    <section class="user">
        <h2><?php echo $name; ?></h2>
        <h3>Reputation Score: <?php echo $reputation;?></h3>
    </section>
    <?php
    }
    $_SESSION["user_name"] = $name;
    $_SESSION["reputation"] = $reputation;
    ?>
</body>
</html>
