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
    <?php
    session_start(); 
    require_once("DBconnect.php");
    if(!isset($_SESSION['user_id'])){
    header("Location: login.html");
    }
    $user_id = $_SESSION['user_id'];
    $sql = "SELECT * FROM user WHERE User_id=$user_id";
    $result = mysqli_query($conn, $sql);
    if(mysqli_num_rows($result) > 0){
        $row = mysqli_fetch_array($result)
    ?>
    <h2><?php echo $row["User_name"]; ?></h2>
    <?php
    }
    ?>
</body>
</html>