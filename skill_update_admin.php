<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Skill Update</title>
</head>
<body>
    <section class="skill-list">
        <table>
            <thead>
                <tr>
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
                            <td><?php echo $row["Skill_name"]; ?></td>
                            <td><?php echo $row["Description"]; ?></td>
                            <td><?php echo $row["Category"]; ?></td>
                            <td><?php echo $row["Expertise_level"]; ?></td>
                            <td><?php echo $row["Parent_id"]; ?></td>
                            <td><?php echo $row["Requirement"]; ?></td>
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
            <p>Prerequisite:<input type="text" name="parent"></p>
            <p>Requirement:<input type="text" name="requirement"></p>
            <input type="submit" value="Submit" />
          </form>
    </section>
</body>
</html>