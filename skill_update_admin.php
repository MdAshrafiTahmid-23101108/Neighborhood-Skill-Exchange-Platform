<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Skill List</title>
</head>
<body>
    <header>
        <h1>This is Skill List</h1>
    </header>
    <nav>
        <a href="admin_dashboard.html"><h2>Admin</h2></a>
        <a href="challenge_update_admin.php"><h2>Challenge List</h2></a>
    </nav>
    <section class="skill-list">
        <table>
            <thead>
                <tr>
                    <th>Skill id</th>
                    <th>Skill Name</th>
                    <th>Description</th>
                    <th>Category</th>
                    <th>Level</th>
                    <th>Prerequisite</th>
                    <th>Requirement</th>
                </tr>
            </thead>
            <tbody>
                <?php 
                require_once("DBconnect.php");
                $sql = "SELECT * FROM skill";
                $result = mysqli_query($conn, $sql);
                if(mysqli_num_rows($result) > 0){
                    while($row = mysqli_fetch_assoc($result)){
                ?>
                        <tr>
                            <td align="center"><?php echo $row["Skill_id"]; ?></td>
                            <td align="center"><?php echo $row["Skill_name"]; ?></td>
                            <td><?php echo $row["Description"]; ?></td>
                            <td><?php echo $row["Category"]; ?></td>
                            <td align="center"><?php echo $row["Expertise_level"]; ?></td>
                            <td align="center"><?php if ($row["Skill_id"] == $row["Parent_id"]){
                                                        echo "None";
                                                        }else{
                                                            $id = $row["Parent_id"];
                                                            $parent = mysqli_fetch_assoc(mysqli_query($conn, "SELECT Skill_name,Expertise_level FROM skill WHERE Skill_id=$id"));
                                                            echo "{$parent['Skill_name']}({$parent['Expertise_level']})";
                                                        } 
                                                ?>
                            </td>
                            <td align="center"><?php echo $row["Requirement"]; ?></td>
                        </tr>
                <?php
                        }
                    }
                ?>
            </tbody>
        </table>
        <h2>Add Skill</h2>
        <form class="skill_form" action="add_skill_admin.php" method="post">
            <p>Skill Name:<input type="text" name="skill_name" required></p>
            <p>Description:<input type="text" name="description" required></p>
            <p>Category:<input type="text" name="category" required></p>
            <p>Level:<input type="text" name="level" required></p>
            <p>Prerequisite:<input type="int" name="parent"></p>
            <p>Requirement:<input type="text" name="requirement"></p>
            <input type="submit" value="Add" />
        </form>

        <h2>Remove Skill</h2>
        <form action="remove_skill_admin.php" method="post">
            <p>Skill id:<input type="int" name="skill_id" required></p>
            <input type="submit" value="Remove" />
        </form>
    </section>
</body>
</html>