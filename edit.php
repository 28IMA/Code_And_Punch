<?php
    
    session_start();
    require './function.php';
    if(!isset($_SESSION['id'])){
        header('location: index.php');
        exit;
    }

    session_regenerate_id(true);
    connectDB();
    $id = $_SESSION['id'];
    $role = $_SESSION['role'];
    $password = $_SESSION['password'];
    $user = getInfo($id);
    $username = $user['username'];
    $fullname = $user['fullname'];
    $email = $user['email'];
    $phone = $user['phone'];
    $errors= [];
    if(isset($_POST['edit'])){
        $newpass = cleanInput($_POST['newpass']);
        $newemail = cleanInput($_POST['newemail']);
        $newphone = cleanInput($_POST['newphone']);

        if(empty($newpass)){
            $errors['pass'] = "Please Enter New Password!";
        }else if(strlen($newpass) < 8){
            $errors['pass'] = "Password Must Be At Least 8 Characters!";
        }

        if(empty($newemail)){
            $errors['email'] = 'Please Enter Your Email!';
        }else{
            if(!filter_var($newemail, FILTER_VALIDATE_EMAIL)){
                $errors['email'] = 'Please Enter A Valid Email!';
            }else if($newemail === $email){
                // user don't change email
            }else{
                $sql = 'select * from user where email = ?';
                $stm = $conn->prepare($sql);
                $stm->bind_param('s', $newemail);
                $stm->execute();
                $result = $stm->get_result();
                if(mysqli_num_rows($result) > 0){
                    $errors['email'] = 'This Email Has Already Used!';
                }
            }
        }

        if(empty($newphone)){
            $errors['phone'] = 'Please Enter Your Phone Number!';
        }else{
            if(!preg_match('/^[0][0-9]{9}$/', $newphone)){
                $errors['phone'] = 'Please Enter Valid Phone Number!';
            }
        }

        if(empty($errors)){
            $_SESSION['password'] = $newpass;
            $newpass = md5($newpass);
            $sql = "update user set password = ?, email = ?, phone = ? where id = ?";
            $stm = $conn->prepare($sql);
            $stm->bind_param("sssi", $newpass, $newemail, $newphone, $id);
            $stm->execute();
            $stm->close();
            disconnectDB();
            header('location: main.php');
        }
    }
    
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Edit</title>
</head>
<body>
    <h1>Edit Your Infomation</h1>
    <div>
        <h3>Your Infomation</h3>
        <form action="" method = "post">
            <p>
                Fullname:
                <span><?=$fullname?></span>
            </p>
            <p>
                Role:
                <span style="text-transform: capitalize;"><?=$role?></span>
            </p>
            <p>
                Username: 
                <span><?=$username?></span>
            </p>

            <p>
                Password: <br>
                <input type="text" name="newpass" value="<?=$password?>"><br>
                <span style="color:red;" ><?=$errors['pass']??''?></span>
            </p>

            <p>
                Email: <br>
                <input type="text" name="newemail" value="<?=$email?>"><br>
                <span style="color:red;" ><?=$errors['email']??''?></span>
            </p>

            <p>
                Phone: <br>
                <input type="text" name="newphone" value="<?=$phone?>"><br>
                <span style="color:red;" ><?=$errors['phone']??''?></span>
            </p>
            <p>
                <button type="submit" name="edit">Submit</button>
            </p>
        </form>
    </div>

<div>
    <a href="main.php">Back To Home</a>
</div>
</body>
</html>