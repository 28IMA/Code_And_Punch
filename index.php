<?php
    require './function.php';
    session_start();
    connectDB();
    $errors = [];
    if(isset($_POST['login'])){
        $username = cleanInput($_POST['username']);
        $pass = cleanInput($_POST['pass']);

        //validate username and password
        if(empty($username)){
            $errors['username'] = 'Please Enter Your Username!';
            if(empty($pass)){
                $errors['pass'] = 'Please Enter Your Password!';
            }
        }else{
            $pass = md5($pass);
            $sql = "select id, username, role from user where username = ? and password = ?";
            $stm = $conn->prepare($sql);
            $stm->bind_param("ss", $username, $pass);
            $stm->execute();
            $result = $stm->get_result();
            if(mysqli_num_rows($result) <= 0){
                $errors['login'] = 'Incorrect Username Or Password!';
            }else{
                //no errors
                $row = $result->fetch_assoc();
                $_SESSION['username'] = $row['username'];
                $_SESSION['id'] = $row['id'];
                $_SESSION['role'] = $row['role'];
                if($_SESSION['role'] === 'student')
                    header('location: student.php');
                else
                    header('location: teacher.php');
            }
        }
    }
    disconnectDB($conn);
?>


<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Class</title>
</head>
<body>
    <form action="" method="post">
        <h1>Sign In</h1>
        <p>
            Username: <br>
            <input type="text" name="username" value=<?=$_POST['username']?? ''?>><br>
            <span style="color: red;"><?=$errors['username']?? ''?></span>
        </p>

        <p>
            Password: <br>
            <input type="text" name="pass" value=<?=$_POST['pass']?? ''?>><br>
            <span style="color: red;"><?=$errors['pass']?? ''?></span>
        </p>

        <p><span style="color: red;"><?=$errors['login']?? ''?></span></p>

        <p>
            <button type="submit" name="login">Submit</button>
        </p>
        <footer><a href="register.php">Create New Account!</a></footer>
    </form>
</body>
</html>