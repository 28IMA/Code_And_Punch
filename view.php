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
    $role = $_SESSION['role'];
    $users = mysqli_query($conn, "select * from user order by role, fullname");
    disconnectDB();
    
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
    <h1>Who In Class</h1>

    <table>
        <tr> 
            <th>Full Name</th>
            <th>Role</th>
            <th></th>
        </tr>
        <?php while($user = $users->fetch_assoc()): ?>
        <tr>
            <td style="text-transform: capitalize;"><?=$user['fullname']?></td>
            <td style="text-transform: capitalize;"><?=$user['role']?></td>
            <td>
                <div style="display:inline-block;">
                    <form action="detail.php" method="post">
                        <input type="hidden" name = "view_id" value = "<?=$user['id']?>">
                        <button type="submit"> View </button>
                    </form>
                </div>
                <?php if($role =="teacher" && $user['role'] =="student"):?>
                    <div style="display:inline-block;">
                        <form action="editStudent.php" method="post">
                            <input type="hidden" name ="edit_id" value = "<?=$user['id']?>">
                            <button type = "submit"> Edit </button>
                        </form>
                    </div>
                    <div style="display:inline-block;">
                        <form action="deleteStudent.php" method="post">
                            <input type="hidden" name ="delete_id" value = "<?=$user['id']?>">
                            <button type ="submit">Delete</button>
                        </form>
                    </div>
                <?php endif;?>
            </td>
        </tr>  
        <?php endwhile;?> 
    </table>
    <br>
    <div>
        <?php if($role=="teacher"): ?>
            <button><a style="text-decoration:none; color: #000" href="addStudent.php" >Add New Student</a></button>
        <?php endif; ?>
    </div>
    <br>
    <div>
        <a href="main.php">Back To Home</a>
    </div>
</body>
</html>