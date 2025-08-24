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

function skill_status($conn,$user_id,$skill_id,$requirement){
    $sql = "SELECT * FROM user_skill WHERE User_id=$user_id AND Skill_id=$skill_id";
    $result = mysqli_query($conn, $sql);
    if(mysqli_num_rows($result) == 0){
        $sql = "SELECT * FROM user_skill WHERE User_id=$user_id AND Skill_id=(SELECT Parent_id FROM skill WHERE Skill_id=$skill_id)";
        $result = mysqli_query($conn, $sql);
        if(mysqli_num_rows($result) > 0 || $requirement=="None"){
            return "brown";
        }else{
            return "gray";
        }
    }else{
        return "green";
    }
}


function skill_tree($conn,$category,$level,$user_id,$indent_level = 1,$parent_id=null){
    if($level=="Beginner"){
        $sql = "SELECT * FROM skill WHERE Category='$category' AND Expertise_level='$level'";
    }else{
        $sql = "SELECT * FROM skill WHERE Parent_id=$parent_id AND Skill_id!=$parent_id";
    }
    $result = mysqli_query($conn, $sql);
    if(mysqli_num_rows($result) > 0){
        while($row = mysqli_fetch_assoc($result)){
            $skill_name = $row["Skill_name"];
            $skill_id = $row["Skill_id"];
            $description = $row["Description"];
            $requirement = $row["Requirement"];
            $hover_text = "Description: $description\nRequirement: $requirement";
            $indent = str_repeat("&nbsp;", 8 * $indent_level);
            $color = skill_status($conn,$user_id,$skill_id,$requirement);
?>
            <h3 style="<?php echo "color:$color" ?>" title="<?php echo $hover_text; ?>" ><?php echo $indent . $skill_name."($level)"; ?></h3>
<?php
            if($level=="Beginner"){
?>
                <section class="Intermediate">
                    <?php
                    skill_tree($conn,$category,"Intermediate",$user_id,$indent_level+1,$skill_id);
                    ?>
                </section>
<?php
            }else{
?>
                <section class="Advanced">
                    <?php
                    skill_tree($conn,$category,"Advanced",$user_id,$indent_level+1,$skill_id);
                    ?>
                </section>
<?php
            }
        }
    }
}


?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>My skills</title>
</head>
<body>
    <h1>This is skill tree page</h1>
    <nav>
        <a href="user_dashboard.php">Dashboard</a>
        <a href="barter.php">Barter</a>
        <a href="logout.php">Log out</a>
        <a href="leaderboard.php">Leaderboard</a>
    </nav>
    <section class="user">
        <h2><?php echo $name; ?></h2>
        <h3>Reputation Score: <?php echo $reputation;?></h3>
        <p>
            <h4 style="color:blue">Category</h4> 
            <h4 style="color:green">Learned</h4>
            <h4 style="color:brown">Recommended</h4>
            <h4 style="color:gray">Locked</h4>
        </p>
    </section>
    <h1>Skill tree</h1>
    <?php
    $sql = "SELECT DISTINCT Category FROM skill";
    $result = mysqli_query($conn, $sql);
    if(mysqli_num_rows($result) > 0){
        while($row = mysqli_fetch_assoc($result)){
            $category = $row["Category"];
    ?>
            <section class="category">
                <h2 style="color:blue;"><?php echo $category; ?></h2>
                <section class="Beginner">
                    <?php
                    skill_tree($conn,$category,"Beginner",$user_id);
                    ?>
                </section>
            </section>
    <?php
        }
    }
    ?>
</body>
</html>