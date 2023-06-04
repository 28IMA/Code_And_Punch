<?php
    session_start();
    require './function.php';
    // auth
    if(!isset($_SESSION['id'])){
        header("location: index.php");
        exit;
    }

    session_regenerate_id(true);
    if(isset($_POST['view_id'])){
        // main user
        $user_role = $_SESSION['role'];
        // view user
        $view_id = $_POST['view_id'];
        connectDB();
        $view_user = getInfo($view_id);
        $view_fullname = $view_user['fullname'];
        $view_email = $view_user['email'];
        $view_phone = $view_user['phone'];
        $view_role = $view_user['role'];
        disconnectDB();
    }
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>View Detail</title>
</head>
<body>
    <h3>INFOMATION DETAIL OF <?=strtoupper($view_fullname)?></h3>
    <div>
        <ul>
            <li>
                <span>Full Name: <?=$view_fullname??''?></span>
            </li>
            <li>
                <span style="text-transform: capitalize;">Role: <?=$view_role??''?></span>
            </li>
            <li>
                <span>Email: <?=$view_email??''?></span>
            </li>
            <li>
                <span>Phone: <?=$view_phone??''?></span>
            </li>
        </ul>
    </div>


    <div>
        <a href="main.php">Back To Home</a>
    </div>
</body>
</html>