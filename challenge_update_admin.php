<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Challenge List</title>
</head>
<body>
    <header>
        <h1>This is Challenge List</h1>
    </header>
    <nav>
        <a href="skill_update_admin.php">Skill List</a>
        <a href="admin_dashboard.html">Admin</a>
        <a href="logout.php">Log out</a>
    </nav>
    <h2>Challenge list</h2>
    <section class="Challenge list">
        <table>
            <thead>
                <tr>
                    <th>Id</th>
                    <th>Title</th>
                    <th>Description</th>
                    <th>Start_time</th>
                    <th>End_time</th>
                    <th>Reward</th>
                </tr>
            </thead>
            <tbody>
                <?php 
                        require_once("DBconnect.php");
                        $sql = "SELECT * FROM challenge";
                        $result = mysqli_query($conn, $sql);
                        if(mysqli_num_rows($result) > 0){
                            while($row = mysqli_fetch_assoc($result)){
                        ?>
                <tr>
                            <td align="center"><?php echo $row["Challenge_id"]; ?></td>
                            <td><?php echo $row["Title"]; ?></td>
                            <td><?php echo $row["Description"]; ?></td>
                            <td><?php echo $row["Start_time"]; ?></td>
                            <td><?php echo $row["End_time"]; ?></td>
                            <td align="center"><?php echo $row["Reward"]; ?></td>
                </tr>
                <?php
                            }
                        }
                        ?>
            </tbody>
        </table>
    </section>
    <section class="Add Challenge">
        <h2>Add Challenges</h2>
        <form class="challenge_form" action="add_challenge_admin.php" method="post">
            <p>Title:<input type="text" name="title" required></p>
            <p>Description:<input type="text" name="description" required></p>
            <p>Start_time:<input type="datetime-local" name="start_time" required></p>
            <p>End_time:<input type="datetime-local" name="end_time" required></p>
            <p>Reward:<input type="text" name="reward" required></p>
            <input type="submit" value="Add" />
          </form>
    </section>
    <section class="Remove challenge">
        <h2>Remove Challenge</h2>
        <form action="remove_challenge_admin.php" method="post">
            <p>Challenge id:<input type="int" name="challenge_id" required></p>
            <input type="submit" value="Remove" />
        </form>
    </section>
</body>
</html>