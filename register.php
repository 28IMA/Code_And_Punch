<?php
    require './function.php';
    connectDB();
    $errors = [];
    if(isset($_POST['register'])){
        $fullname = cleanInput($_POST['fullname']);
        $username = cleanInput($_POST['username']);
        $pass = cleanInput($_POST['pass']);
        $pass2 = cleanInput($_POST['pass2']);
        $email = cleanInput($_POST['email']);
        $phone = cleanInput($_POST['phone']);
        if(!isset($_POST['role'])){
            $errors['role'] = 'Please Choose Your Role!';
        }else{
            $role = $_POST['role'];
        }
        
        if(empty($fullname)){
            $errors['fullname'] = 'Please Enter Your Full Name!';
        }else if(preg_match('/[\'"^.£$%&*()}{@#~?><>,|=+_¬-]/', $fullname)){
            $errors['fullname'] = 'Full Name Can Not Contain Special Character!';
        }

        if(empty($email)){
            $errors['email'] = 'Please Enter Your Email!';
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
            $errors['phone'] = 'Please Enter Your Phone Number!';
        }else{
            if(!preg_match('/^[0][0-9]{9}$/', $phone)){
                $errors['phone'] = 'Please Enter Valid Phone Number!';
            }
        }

        if(empty($username)){
            $errors['username'] = 'Please Enter Username';
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
            $errors['pass'] = 'Please Enter Your Password!';
        }else if(strlen($pass) < 8){
            $errors['pass'] = 'Password Must Be At Least 8 Characters!';
        }
        
        
        if(empty($pass2)){
            $errors['pass2'] = 'Please Confirm Your Password!';
        }else{
            if($pass != $pass2){
                $errors['pass2'] = 'Password And Confirm Password Must Be The Same!';
            }
        }
        
        if(empty($errors)){
            $password = md5($pass);
            insertUser($username, $password, $fullname, $email, $phone, $role);
            disconnectDB();
            header('location: index.php');
        }
    }
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Register</title>
</head>
<body>
    <form action="" method="post">
        <h1>Sign Up</h1>
        <!-- fullname -->
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
        <!-- confirm password -->
        <p>
            Confirm Password: <br>
            <input type="text" name="pass2" value="<?=$_POST['pass2']??''?>"><br>
            <span style="color: red;"><?= $errors['pass2'] ?? ''?></span>
        </p>
        <!-- role -->
        <p>
            You Are: <br>
            Teacher <input type="radio" name="role" value="teacher">
            Student <input type="radio" name="role" value="student"><br>
            <span style="color: red;"><?= $errors['role'] ?? ''?></span>
        </p>
        <!-- submit register -->
        <p>
        <button type="submit" name="register">Submit</button>       
        </p>
    </form>
</body>
</html>