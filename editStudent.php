<?php
    session_start();
    require './function.php';
    if(!isset($_SESSION['id'])){
        header('location" index.php');
        exit;
    }
    if($_SESSION['role'] != 'teacher'){
        header('location: main.php');
        exit;
    }
    session_regenerate_id(true);
    connectDB();

    if(isset($_POST['edit_id'])){
        $_SESSION['edit_student_id'] = $_POST['edit_id'];
    }
    $student = getInfo($_SESSION['edit_student_id']);
    $errors = [];
    if(isset($_POST['edit'])){
        $new_s_username = cleanInput($_POST['username']);
        $new_s_password = cleanInput($_POST['pass']);
        $new_s_email = cleanInput($_POST['email']);
        $new_s_phone = cleanInput($_POST['phone']);
        $new_s_fullname = cleanInput($_POST['fullname']);
        
        //username
        if(empty($new_s_username)){
            $errors['username'] = 'This Field Can Not Be Empty!';
        }else if($new_s_username == $student['username']){
            // don't change username
        }else{
            $sql = 'select * from user where username = ?';
            $stm = $conn->prepare($sql);
            $stm->bind_param('s', $new_s_username);
            $stm->execute();
            $result = $stm->get_result();
            if(mysqli_num_rows($result) > 0){
                $errors['username'] = 'This Username Has Already Existed!';
            }
        }

        //password
        if(empty($new_s_password)){
            // don't change password
        }else if(strlen($new_s_password) < 8){
            $errors['pass'] = 'Password Must Contain At Least 8 Character!';
        }

        //email
        if(empty($new_s_email)){
            $errors['email'] = 'Please Enter Your Email!';
        }else{
            if(!filter_var($new_s_email, FILTER_VALIDATE_EMAIL)){
                $errors['email'] = 'Please Enter A Valid Email!';
            }else if($new_s_email == $student['email']){;
                // user don't change email
            }else{
                $sql = 'select * from user where email = ?';
                $stm = $conn->prepare($sql);
                $stm->bind_param('s', $new_s_email);
                $stm->execute();
                $result = $stm->get_result();
                if(mysqli_num_rows($result) > 0){
                    $errors['email'] = 'This Email Has Already Used!';
                }
            }
        }

        //phone
        if(empty($new_s_phone)){
            $errors['phone'] = 'Please Enter Your Phone Number!';
        }else{
            if(!preg_match('/^[0][0-9]{9}$/', $new_s_phone)){
                $errors['phone'] = 'Please Enter Valid Phone Number!';
            }
        }

        //fullname
        if(empty($new_s_fullname)){
            $errors['fullname'] = 'Please Enter Your Full Name!';
        }else if(preg_match('/[\'"^.£$%&*()}{@#~?><>,|=+_¬-]/', $new_s_fullname)){
            $errors['fullname'] = 'Full Name Can Not Contain Special Character!';
        }


        if(empty($errors)){
            if(!empty($new_s_password)) // if password was changed
                $new_s_password = md5($new_s_password);
            else $new_s_password = $student['password'];
            $sql = "update user set username = ?, password = ?, email = ?, phone = ?, fullname = ? where id = ?";
            $stm = $conn->prepare($sql);
            $stm->bind_param("sssssi", $new_s_username, $new_s_password, $new_s_email, $new_s_phone, $new_s_fullname, $student['id']);
            $stm->execute();
            $stm->close();
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
    <title>Edit</title>
</head>
<body>
    <h1>Edit Student Information</h1>
    <div>
        <h3>Student Information</h3>
        <form action="" method="post">
            <p>
                Fullname: <br>
                <input type="text" name="fullname" value="<?=$student['fullname']??''?>"><br>
                <span style="color: red;"><?=$errors['fullname']??''?></span>
            </p>
            <p>
                Email: <br>
                <input type="text" name="email" value="<?=$student['email']??''?>"><br>
                <span style="color: red;"><?=$errors['email']??''?></span>
            </p>
            <p>
                Phone Number: <br>
                <input type="text" name="phone" value="<?=$student['phone']??''?>"><br>
                <span style="color: red;"><?=$errors['phone']??''?></span>
            </p>
            <p>
                Username: <br>
                <input type="text" name="username" value="<?=$student['username']??''?>"><br>
                <span style="color: red;"><?=$errors['username']??''?></span>
            </p>
            <p>
                Password: <br>
                <input type="text" name="pass" value="<?=$new_s_password??''?>"> <br>
                <span style="color: red;"><?=$errors['pass']??''?></span>
            </p>
            <p>
                <button type="submit" name="edit">Edit</button>
            </p>
        </form>
    </div>


    <div>
        <a href="main.php">Back To Home</a>
    </div>
</body>
</html>