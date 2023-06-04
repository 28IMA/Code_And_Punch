<?php
    session_start();
    require './function.php';
    if(!isset($_SESSION['id'])){
        header('location: index.php');
        exit;
    }
    if($_SESSION['role'] == 'student'){
        header('location: main.php');
        exit;
    }
    session_regenerate_id(true);
    connectDB();
    $errors = [];
    if(isset($_POST['add'])){
        $fullname = cleanInput($_POST['fullname']);
        $username = cleanInput($_POST['username']);
        $pass = cleanInput($_POST['pass']);
        $email = cleanInput($_POST['email']);
        $phone = cleanInput($_POST['phone']);
        
        if(empty($fullname)){
            $errors['fullname'] = 'This Field Can Not Be Empty!';
        }else if(preg_match('/[\'"^.£$%&*()}{@#~?><>,|=+_¬-]/', $fullname)){
            $errors['fullname'] = 'Full Name Can Not Contain Special Character!';
        }

        if(empty($email)){
            $errors['email'] = 'This Field Can Not Be Empty!';
        }else{
            if(!filter_var($email, FILTER_VALIDATE_EMAIL)){
                $errors['email'] = 'Please Enter A Valid Email!';
            }else{
                $sql = 'select * from user where email = ?';
                $stm = $conn->prepare($sql);
                $stm->bind_param('s', $email);
                $stm->execute();
                $result = $stm->get_result();
                if(mysqli_num_rows($result) > 0){
                    $errors['email'] = 'This Email Has Already Used!';
                }
            }
        }

        if(empty($phone)){
            $errors['phone'] = 'This Field Can Not Be Empty!';
        }else{
            if(!preg_match('/^[0][0-9]{9}$/', $phone)){
                $errors['phone'] = 'Please Enter Valid Phone Number!';
            }
        }

        if(empty($username)){
            $errors['username'] = 'This Field Can Not Be Empty!';
        }else if(preg_match('/[\'" ^.£$%&*()}{@#~?><>,|=+¬-]/', $username)){
            $errors['username'] = 'Username Can Only Contain Letter, Number, Underscore';
        }else{
            $sql = 'select * from user where username = ?';
            $stm = $conn->prepare($sql);
            $stm->bind_param('s', $username);
            $stm->execute();
            $result = $stm->get_result();
            if(mysqli_num_rows($result) > 0){
                $errors['username'] = 'This Username Has Already Existed!';
            }
        }

        if(empty($pass)){
            $errors['pass'] = 'This Field Can Not Be Empty!';
        }else if(strlen($pass) < 8){
            $errors['pass'] = 'Password Must Be At Least 8 Characters!';
        }

        if(empty($errors)){
            $pass = md5($pass);
            insertUser($username, $password, $fullname, $email, $phone, "student");
            disconnectDB();
            header('location: view.php');
        }
    }
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Add Student</title>
</head>
<body>
    <h1>Add New Student</h1>
    <form action="" method="post">
        <h3>Student Information:</h3>
        <p>
            Full Name: <br>
            <input type="text" name="fullname" value="<?=$_POST['fullname']??''?>"><br>
            <span style="color: red;"><?= $errors['fullname'] ?? ''?></span>
        </p>
        <!-- email -->
        <p>
            Email: <br>
            <input type="text" name="email" value="<?=$_POST['email']??''?>"><br>
            <span style="color: red;"><?= $errors['email'] ?? ''?></span>
        </p>
        <!-- phone -->
        <p>
            Phone Number: <br>
            <input type="text" name="phone" value="<?=$_POST['phone']??''?>"><br>
            <span style="color: red;"><?= $errors['phone'] ?? ''?></span>
        </p>
        <!-- username -->
        <p>
            Username: <br>
            <input type="text" name="username" value="<?=$_POST['username']??''?>"><br>
            <span style="color: red;"><?= $errors['username'] ?? ''?></span>
        </p>
        <!-- password -->
        <p>
            Password: <br>
            <input type="text" name="pass" value="<?=$_POST['pass']??''?>"><br>
            <span style="color: red;"><?= $errors['pass'] ?? ''?></span>
        </p>
        <p>
        <button type="submit" name="add">Add</button>       
        </p>
    </form>

    <div>
        <a href="main.php">Back To Home</a>
    </div>
</body>
</html>