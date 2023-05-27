<?php
session_start();
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    // Kết nối đến cơ sở dữ liệu MySQL
    $conn = new mysqli('localhost', 'username', 'password', 'users');

    // Lấy dữ liệu từ form đăng nhập
    $username = $_POST['username'];
    $password = $_POST['password'];

    // Truy vấn cơ sở dữ liệu để kiểm tra người dùng
    $query = "SELECT * FROM users WHERE username='$username' AND password='$password'";
    $result = $conn->query($query);

    if ($result->num_rows === 1) {
        // Đăng nhập thành công, lưu thông tin người dùng vào session
        $user = $result->fetch_assoc();
        $_SESSION['user_id'] = $user['id'];
        $_SESSION['user_type'] = $user['user_type'];

        // Điều hướng đến trang tương ứng với người dùng
        if ($user['user_type'] === 'teacher') {
            header('Location: teacher.php');
        } else {
            header('Location: student.php');
        }
    } else {
        // Đăng nhập không thành công, quay lại trang đăng nhập
        header('Location: index.php');
    }

    $conn->close();
}
?>
