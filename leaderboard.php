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
$user_rank = 1;
$calculate_rank = mysqli_query($conn,"SELECT COUNT(DISTINCT Reputation) AS rank FROM user WHERE Role='user' AND Reputation > $reputation ORDER BY Reputation DESC,User_name ASC");
if (mysqli_num_rows($calculate_rank) > 0){
    $user_rank = mysqli_fetch_assoc($calculate_rank)["rank"]+1;
}
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Leaderboard</title>
</head>
<body>
    <header>
        <h1>This is Leaderboard page</h1>
    </header>
    <nav>
        <a href="user_skill_tree.php">My skills</a>
        <a href="user_dashboard.php">Dashboard</a>
        <a href="barter.php">Barter</a>
        <a href="logout.php">Log out</a>
        <a href="user_challenge.php">Challenges</a>
    </nav>
    <section class="user">
        <h2><?php echo $name; ?></h2>
        <h3>Reputation Score: <?php echo $reputation;?></h3>
    </section>
    <h2>Your rank is <?php echo $user_rank; ?></h2>
    <section class="Leaderboard">
        <h1>Leaderboard</h1>
        <table>
            <thead>
                <tr>
                    <th><h2>Rank</h2></th>
                    <th><h2>Name</h2></th>
                    <th><h2>Reputation</h2></th>
                </tr>
            </thead>
            <tbody>
                <?php
                $sql = "SELECT User_name,Reputation FROM user WHERE Role='user' ORDER BY Reputation DESC,User_name ASC";
                $result = mysqli_query($conn,$sql);
                if(mysqli_num_rows($result)>0){
                    $rank = 0;
                    $prev_reputation = INF;
                    while($row=mysqli_fetch_assoc($result)){
                        $name = $row['User_name'];
                        $reputation = $row['Reputation'];
                        if($reputation < $prev_reputation){
                            $rank++;
                        }
                        $prev_reputation = $reputation
                        ?>
                        <tr>
                            <td align="center"><?php echo $rank ?></td>
                            <td align="center"><?php echo $name ?></td>
                            <td align="center"><?php echo $reputation ?></td>
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