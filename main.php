<?php
    session_start();
    require './function.php';
    // 
    if(!isset($_SESSION['id'])){
        header('location: index.php');
        exit;
    }
    session_regenerate_id(true);
    connectDB();
    $info = getInfo($_SESSION['id']);
    $password = $_SESSION['password'];
    $username = $info['username'];
    $fullname = $info['fullname'];
    $email = $info['email'];
    $phone = $info['phone'];
    disconnectDB();
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Home</title>
</head>
<body>
    <h1>Wellcome!</h1>

    <!-- Current Info -->
    <div>
        <h2>Your Info</h2>
        <ul>
            <li>
                <span>Full name: </span>
                <span><?=$fullname?></span>
            </li>
            <li>
                <span>Username: </span>
                <span><?=$username?></span>
            </li>
            <li>
                <span>Password: </span>
                <span><?=$password?></span>    
            </li>
            <li>
                <span>Email: </span>
                <span><?=$email?></span>
            </li>
            <li>
                <span>Phone: </span>
                <span><?=$phone?></span>
            </li>
        </ul>
        <button><a style="text-decoration:none; color:#000" href="edit.php">Edit</a></button>
    </div>

    <!-- function -->
    <div>
        <h2>Task</h2>
        <ul>
            <li><a href="view.php">View</a</li>
            <li><a href="#">Homework</a></li>
            <li><a href="#">Game</a></li>
            <li><a href="logout.php">Quit</a></li>
        </ul>
    </div>


</body>
</html>