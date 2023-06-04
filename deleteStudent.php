<?php
    session_start();
    require './function.php';
    if(!isset($_SESSION['id']) || $_SESSION['role'] != 'teacher'){
        header('location: main.php');
    }
    if(isset($_POST['delete_id'])){
        connectDB();
        $deleteID = $_POST['delete_id'];
        $sql = 'delete from user where id = ?';
        $stm = $conn->prepare($sql);
        $stm->bind_param("i", $deleteID);
        $stm->execute();
        $stm->close();
        disconnectDB();
        header('location: view.php');
    }

?>