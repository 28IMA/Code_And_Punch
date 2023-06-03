<?php

function connectDB(){
    global $conn;
    $conn = mysqli_connect("localhost", "root", "", "codenpunch");
    if(mysqli_connect_errno()){
        die("Couldn't connect to Database!");
    }
}

function disconnectDB($conn){
    if($conn){
        mysqli_close($conn);
    }
}

function cleanInput($data){
    $data = trim($data);
    $data = stripslashes($data);
    $data = htmlspecialchars($data);
    return $data;
}

function insertUser($conn ,$username, $password, $fullname, $email, $phone, $role){
    $sql = 'insert into user (username, password, fullname, email, phone, role) values(?, ?, ?, ?, ?, ?)';
    $statement = $conn->prepare($sql);
    $statement->bind_param("ssssss",$username, $password, $fullname, $email, $phone, $role);
    $statement->execute();
    $statement->close();   
}