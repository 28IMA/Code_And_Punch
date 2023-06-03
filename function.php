<?php
global $conn;
function connectDB(){
    global $conn;
    $conn = mysqli_connect("localhost", "root", "", "codenpunch");
    if(mysqli_connect_errno()){
        die("Couldn't connect to Database!");
    }
}

function disconnectDB(){
    global $conn;
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

function insertUser($username, $password, $fullname, $email, $phone, $role){
    global $conn;
    $sql = 'insert into user (username, password, fullname, email, phone, role) values(?, ?, ?, ?, ?, ?)';
    $statement = $conn->prepare($sql);
    $statement->bind_param("ssssss",$username, $password, $fullname, $email, $phone, $role);
    $statement->execute();
    $statement->close();   
}

function getInfo($id){
    global $conn;
    $sql = 'select * from user where id = ?';
    $stm = $conn->prepare($sql);
    $stm->bind_param("i", $id);
    $stm->execute();
    $result = $stm->get_result();
    $result = $result->fetch_assoc();
    return $result;
}